<?php

class LibraryMember extends Model
{
    protected $table = 'library_members';
    
    /**
     * Get all library members
     */
    public static function getAll($filters = [])
    {
        $sql = "SELECT lm.*, u.name, u.email, u.role_name as user_role
                FROM library_members lm
                JOIN users u ON lm.user_id = u.id
                WHERE 1=1";
        $params = [];
        
        if (!empty($filters['status'])) {
            $sql .= " AND lm.status = ?";
            $params[] = $filters['status'];
        }
        
        if (!empty($filters['membership_type'])) {
            $sql .= " AND lm.membership_type = ?";
            $params[] = $filters['membership_type'];
        }
        
        if (!empty($filters['search'])) {
            $sql .= " AND (u.name LIKE ? OR u.email LIKE ? OR lm.member_number LIKE ?)";
            $search = "%{$filters['search']}%";
            $params[] = $search;
            $params[] = $search;
            $params[] = $search;
        }
        
        $sql .= " ORDER BY lm.join_date DESC";
        
        return db()->fetchAll($sql, $params);
    }
    
    /**
     * Get member by ID
     */
    public static function find($id)
    {
        $sql = "SELECT lm.*, u.name, u.email, u.role_name
                FROM library_members lm
                JOIN users u ON lm.user_id = u.id
                WHERE lm.id = ?";
        
        return db()->fetchOne($sql, [$id]);
    }
    
    /**
     * Get member by user ID
     */
    public static function getByUserId($userId)
    {
        $sql = "SELECT lm.*, u.name, u.email
                FROM library_members lm
                JOIN users u ON lm.user_id = u.id
                WHERE lm.user_id = ?";
        
        return db()->fetchOne($sql, [$userId]);
    }
    
    /**
     * Get member by member number
     */
    public static function getByMemberNumber($memberNumber)
    {
        $sql = "SELECT lm.*, u.name, u.email
                FROM library_members lm
                JOIN users u ON lm.user_id = u.id
                WHERE lm.member_number = ?";
        
        return db()->fetchOne($sql, [$memberNumber]);
    }
    
    /**
     * Create new library member
     */
    public static function create($data)
    {
        // Generate member number if not provided
        if (empty($data['member_number'])) {
            $data['member_number'] = self::generateMemberNumber();
        }
        
        $sql = "INSERT INTO library_members (user_id, member_number, membership_type, 
                join_date, expiry_date, max_books, status, created_at, updated_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
        
        return db()->execute($sql, [
            $data['user_id'],
            $data['member_number'],
            $data['membership_type'] ?? 'standard',
            $data['join_date'],
            $data['expiry_date'] ?? null,
            $data['max_books'] ?? 3,
            $data['status'] ?? 'active'
        ]);
    }
    
    /**
     * Update member
     */
    public static function update($id, $data)
    {
        $sql = "UPDATE library_members SET membership_type = ?, expiry_date = ?, 
                max_books = ?, status = ?, updated_at = NOW() WHERE id = ?";
        
        return db()->execute($sql, [
            $data['membership_type'],
            $data['expiry_date'] ?? null,
            $data['max_books'],
            $data['status'],
            $id
        ]);
    }
    
    /**
     * Delete member
     */
    public static function delete($id)
    {
        return db()->execute("DELETE FROM library_members WHERE id = ?", [$id]);
    }
    
    /**
     * Generate unique member number
     */
    private static function generateMemberNumber()
    {
        $prefix = 'LM';
        $year = date('Y');
        $lastMember = db()->fetchOne("SELECT member_number FROM library_members ORDER BY id DESC LIMIT 1");
        
        if ($lastMember) {
            $lastNumber = intval(substr($lastMember['member_number'], -4));
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }
        
        return $prefix . $year . $newNumber;
    }
    
    /**
     * Get members whose membership is expiring soon (within 30 days)
     */
    public static function getExpiringSoon()
    {
        $sql = "SELECT lm.*, u.name, u.email
                FROM library_members lm
                JOIN users u ON lm.user_id = u.id
                WHERE lm.expiry_date IS NOT NULL 
                AND lm.expiry_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 30 DAY)
                AND lm.status = 'active'
                ORDER BY lm.expiry_date ASC";
        
        return db()->fetchAll($sql);
    }
    
    /**
     * Renew membership
     */
    public static function renewMembership($id, $months = 12)
    {
        $member = self::find($id);
        if (!$member) return false;
        
        $currentExpiry = $member['expiry_date'] ?? date('Y-m-d');
        $newExpiry = date('Y-m-d', strtotime($currentExpiry . " +{$months} months"));
        
        return db()->execute("UPDATE library_members SET expiry_date = ?, updated_at = NOW() WHERE id = ?", [$newExpiry, $id]);
    }
    
    /**
     * Get member statistics
     */
    public static function getStatistics()
    {
        return [
            'total_members' => db()->fetchOne("SELECT COUNT(*) as count FROM library_members WHERE status = 'active'")['count'],
            'expired_members' => db()->fetchOne("SELECT COUNT(*) as count FROM library_members WHERE expiry_date < CURDATE() AND status = 'active'")['count'],
            'expiring_soon' => count(self::getExpiringSoon())
        ];
    }
}
