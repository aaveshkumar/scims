<?php

class HostelVisitor
{
    protected static $table = 'hostel_visitors';
    
    public static function getAll($filters = [])
    {
        $sql = "SELECT v.*, 
                u_s.first_name as student_first_name, u_s.last_name as student_last_name, 
                s.roll_number,
                h.name as hostel_name, hr.room_number,
                CONCAT(u_a.first_name, ' ', u_a.last_name) as approved_by_name
                FROM hostel_visitors v
                JOIN hostel_residents r ON v.resident_id = r.id
                JOIN students s ON r.student_id = s.id
                JOIN users u_s ON s.user_id = u_s.id
                JOIN hostels h ON r.hostel_id = h.id
                JOIN hostel_rooms hr ON r.room_id = hr.id
                LEFT JOIN users u_a ON v.approved_by = u_a.id
                WHERE 1=1";
        $params = [];
        
        if (!empty($filters['resident_id'])) {
            $sql .= " AND v.resident_id = ?";
            $params[] = $filters['resident_id'];
        }
        
        if (!empty($filters['date_from'])) {
            $sql .= " AND v.visit_date >= ?";
            $params[] = $filters['date_from'];
        }
        
        if (!empty($filters['date_to'])) {
            $sql .= " AND v.visit_date <= ?";
            $params[] = $filters['date_to'];
        }
        
        if (!empty($filters['search'])) {
            $sql .= " AND (v.visitor_name LIKE ? OR u_s.first_name LIKE ? OR u_s.last_name LIKE ?)";
            $search = "%{$filters['search']}%";
            $params[] = $search;
            $params[] = $search;
            $params[] = $search;
        }
        
        $sql .= " ORDER BY v.visit_date DESC, v.entry_time DESC";
        
        return db()->fetchAll($sql, $params);
    }
    
    public static function find($id)
    {
        $sql = "SELECT v.*, 
                u_s.first_name as student_first_name, u_s.last_name as student_last_name, 
                s.roll_number, u_s.phone as student_phone,
                h.name as hostel_name, hr.room_number,
                CONCAT(u_a.first_name, ' ', u_a.last_name) as approved_by_name
                FROM hostel_visitors v
                JOIN hostel_residents r ON v.resident_id = r.id
                JOIN students s ON r.student_id = s.id
                JOIN users u_s ON s.user_id = u_s.id
                JOIN hostels h ON r.hostel_id = h.id
                JOIN hostel_rooms hr ON r.room_id = hr.id
                LEFT JOIN users u_a ON v.approved_by = u_a.id
                WHERE v.id = ?";
        
        return db()->fetchOne($sql, [$id]);
    }
    
    public static function create($data)
    {
        $sql = "INSERT INTO hostel_visitors (resident_id, visitor_name, visitor_phone, 
                visitor_id_proof, visit_date, entry_time, exit_time, purpose, 
                approved_by, created_at, updated_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
        
        return db()->execute($sql, [
            $data['resident_id'],
            $data['visitor_name'],
            $data['visitor_phone'] ?? null,
            $data['visitor_id_proof'] ?? null,
            $data['visit_date'],
            $data['entry_time'],
            $data['exit_time'] ?? null,
            $data['purpose'] ?? null,
            $data['approved_by'] ?? null
        ]);
    }
    
    public static function update($id, $data)
    {
        $sql = "UPDATE hostel_visitors SET visitor_name = ?, visitor_phone = ?, 
                visitor_id_proof = ?, visit_date = ?, entry_time = ?, exit_time = ?, 
                purpose = ?, approved_by = ?, updated_at = NOW() WHERE id = ?";
        
        return db()->execute($sql, [
            $data['visitor_name'],
            $data['visitor_phone'] ?? null,
            $data['visitor_id_proof'] ?? null,
            $data['visit_date'],
            $data['entry_time'],
            $data['exit_time'] ?? null,
            $data['purpose'] ?? null,
            $data['approved_by'] ?? null,
            $id
        ]);
    }
    
    public static function delete($id)
    {
        return db()->execute("DELETE FROM hostel_visitors WHERE id = ?", [$id]);
    }
    
    public static function markExit($id, $exitTime)
    {
        return db()->execute(
            "UPDATE hostel_visitors SET exit_time = ?, updated_at = NOW() WHERE id = ?",
            [$exitTime, $id]
        );
    }
    
    public static function getActiveVisitors()
    {
        $sql = "SELECT v.*, 
                u_s.first_name as student_first_name, u_s.last_name as student_last_name,
                h.name as hostel_name, hr.room_number
                FROM hostel_visitors v
                JOIN hostel_residents r ON v.resident_id = r.id
                JOIN students s ON r.student_id = s.id
                JOIN users u_s ON s.user_id = u_s.id
                JOIN hostels h ON r.hostel_id = h.id
                JOIN hostel_rooms hr ON r.room_id = hr.id
                WHERE v.visit_date = CURRENT_DATE AND v.exit_time IS NULL
                ORDER BY v.entry_time DESC";
        
        return db()->fetchAll($sql);
    }
    
    public static function getStatistics()
    {
        return [
            'today_visitors' => db()->fetchOne("SELECT COUNT(*) as count FROM hostel_visitors WHERE visit_date = CURDATE()")['count'],
            'active_visitors' => count(self::getActiveVisitors()),
            'this_month' => db()->fetchOne("SELECT COUNT(*) as count FROM hostel_visitors WHERE MONTH(visit_date) = MONTH(CURDATE()) AND YEAR(visit_date) = YEAR(CURDATE())")['count']
        ];
    }
}
