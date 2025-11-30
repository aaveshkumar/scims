<?php

class Asset
{
    protected static $table = 'assets';
    
    public static function getAll($filters = [])
    {
        $sql = "SELECT a.*, CONCAT(u.first_name, ' ', u.last_name) as assigned_to_name
                FROM assets a
                LEFT JOIN users u ON a.assigned_to = u.id
                WHERE 1=1";
        $params = [];
        
        if (!empty($filters['search'])) {
            $sql .= " AND (a.asset_code LIKE ? OR a.asset_name LIKE ?)";
            $search = "%{$filters['search']}%";
            $params[] = $search;
            $params[] = $search;
        }
        
        if (!empty($filters['category'])) {
            $sql .= " AND a.category = ?";
            $params[] = $filters['category'];
        }
        
        if (!empty($filters['status'])) {
            $sql .= " AND a.status = ?";
            $params[] = $filters['status'];
        }
        
        if (!empty($filters['condition_status'])) {
            $sql .= " AND a.condition_status = ?";
            $params[] = $filters['condition_status'];
        }
        
        $sql .= " ORDER BY a.asset_code ASC";
        
        return db()->fetchAll($sql, $params);
    }
    
    public static function find($id)
    {
        $sql = "SELECT a.*, CONCAT(u.first_name, ' ', u.last_name) as assigned_to_name, u.email as assigned_to_email
                FROM assets a
                LEFT JOIN users u ON a.assigned_to = u.id
                WHERE a.id = ?";
        
        return db()->fetchOne($sql, [$id]);
    }
    
    public static function create($data)
    {
        $sql = "INSERT INTO assets (asset_code, name, category, description, 
                purchase_date, purchase_cost, current_value, depreciation_rate, 
                location, assigned_to, item_condition, warranty_expiry, status, 
                created_at, updated_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
        
        return db()->execute($sql, [
            $data['asset_code'],
            $data['name'],
            $data['category'] ?? null,
            $data['description'] ?? null,
            $data['purchase_date'] ?? null,
            $data['purchase_cost'] ?? null,
            $data['current_value'] ?? $data['purchase_cost'] ?? null,
            $data['depreciation_rate'] ?? null,
            $data['location'] ?? null,
            $data['assigned_to'] ?? null,
            $data['item_condition'] ?? 'good',
            $data['warranty_expiry'] ?? null,
            $data['status'] ?? 'active'
        ]);
    }
    
    public static function update($id, $data)
    {
        $sql = "UPDATE assets SET asset_code = ?, name = ?, category = ?, 
                description = ?, purchase_date = ?, purchase_cost = ?, 
                current_value = ?, depreciation_rate = ?, location = ?, 
                assigned_to = ?, item_condition = ?, warranty_expiry = ?, 
                status = ?, updated_at = NOW() WHERE id = ?";
        
        return db()->execute($sql, [
            $data['asset_code'],
            $data['name'],
            $data['category'] ?? null,
            $data['description'] ?? null,
            $data['purchase_date'] ?? null,
            $data['purchase_cost'] ?? null,
            $data['current_value'] ?? null,
            $data['depreciation_rate'] ?? null,
            $data['location'] ?? null,
            $data['assigned_to'] ?? null,
            $data['item_condition'],
            $data['warranty_expiry'] ?? null,
            $data['status'],
            $id
        ]);
    }
    
    public static function delete($id)
    {
        return db()->execute("DELETE FROM assets WHERE id = ?", [$id]);
    }
    
    public static function getWarrantyExpiring($days = 30)
    {
        $sql = "SELECT * FROM assets 
                WHERE status = 'active' 
                AND warranty_expiry IS NOT NULL
                AND warranty_expiry BETWEEN CURRENT_DATE AND CURRENT_DATE + (? || ' days')::INTERVAL
                ORDER BY warranty_expiry ASC";
        
        return db()->fetchAll($sql, [$days]);
    }
    
    public static function calculateDepreciation($id)
    {
        $asset = self::find($id);
        if (!$asset || !$asset['purchase_cost'] || !$asset['depreciation_rate']) {
            return null;
        }
        
        $years = 1;
        if ($asset['purchase_date']) {
            $purchaseDate = new DateTime($asset['purchase_date']);
            $currentDate = new DateTime();
            $interval = $purchaseDate->diff($currentDate);
            $years = max(1, $interval->y);
        }
        
        $annualDepreciation = $asset['purchase_cost'] * ($asset['depreciation_rate'] / 100);
        $totalDepreciation = $annualDepreciation * $years;
        $currentValue = max(0, $asset['purchase_cost'] - $totalDepreciation);
        
        db()->execute(
            "UPDATE assets SET current_value = ?, updated_at = NOW() WHERE id = ?",
            [$currentValue, $id]
        );
        
        return $currentValue;
    }
    
    public static function getStatistics()
    {
        return [
            'total_assets' => db()->fetchOne("SELECT COUNT(*) as count FROM assets WHERE status = 'active'")['count'],
            'total_value' => db()->fetchOne("SELECT SUM(current_value) as total FROM assets WHERE status = 'active'")['total'] ?? 0,
            'assigned_assets' => db()->fetchOne("SELECT COUNT(*) as count FROM assets WHERE status = 'active' AND assigned_to IS NOT NULL")['count'],
            'warranty_expiring' => count(self::getWarrantyExpiring(30))
        ];
    }
    
    public static function getCategories()
    {
        return db()->fetchAll("SELECT DISTINCT category FROM assets WHERE category IS NOT NULL ORDER BY category");
    }
}
