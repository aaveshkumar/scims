<?php

class Supplier
{
    protected static $table = 'suppliers';
    
    public static function getAll($filters = [])
    {
        $sql = "SELECT * FROM suppliers WHERE 1=1";
        $params = [];
        
        if (!empty($filters['search'])) {
            $sql .= " AND (supplier_code LIKE ? OR name LIKE ? OR contact_person LIKE ?)";
            $search = "%{$filters['search']}%";
            $params[] = $search;
            $params[] = $search;
            $params[] = $search;
        }
        
        if (!empty($filters['status'])) {
            $sql .= " AND status = ?";
            $params[] = $filters['status'];
        }
        
        if (!empty($filters['city'])) {
            $sql .= " AND city = ?";
            $params[] = $filters['city'];
        }
        
        $sql .= " ORDER BY name ASC";
        
        return db()->fetchAll($sql, $params);
    }
    
    public static function find($id)
    {
        return db()->fetchOne("SELECT * FROM suppliers WHERE id = ?", [$id]);
    }
    
    public static function create($data)
    {
        $sql = "INSERT INTO suppliers (supplier_code, name, contact_person, email, 
                phone, address, city, country, payment_terms, status, 
                created_at, updated_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
        
        return db()->execute($sql, [
            $data['supplier_code'],
            $data['name'],
            $data['contact_person'] ?? null,
            $data['email'] ?? null,
            $data['phone'] ?? null,
            $data['address'] ?? null,
            $data['city'] ?? null,
            $data['country'] ?? null,
            $data['payment_terms'] ?? null,
            $data['status'] ?? 'active'
        ]);
    }
    
    public static function update($id, $data)
    {
        $sql = "UPDATE suppliers SET supplier_code = ?, name = ?, contact_person = ?, 
                email = ?, phone = ?, address = ?, city = ?, country = ?, 
                payment_terms = ?, status = ?, updated_at = NOW() WHERE id = ?";
        
        return db()->execute($sql, [
            $data['supplier_code'],
            $data['name'],
            $data['contact_person'] ?? null,
            $data['email'] ?? null,
            $data['phone'] ?? null,
            $data['address'] ?? null,
            $data['city'] ?? null,
            $data['country'] ?? null,
            $data['payment_terms'] ?? null,
            $data['status'],
            $id
        ]);
    }
    
    public static function delete($id)
    {
        return db()->execute("DELETE FROM suppliers WHERE id = ?", [$id]);
    }
    
    public static function getPurchaseHistory($supplierId)
    {
        $sql = "SELECT po.*, COUNT(poi.id) as item_count
                FROM purchase_orders po
                LEFT JOIN purchase_order_items poi ON po.id = poi.po_id
                WHERE po.supplier_id = ?
                GROUP BY po.id
                ORDER BY po.order_date DESC";
        
        return db()->fetchAll($sql, [$supplierId]);
    }
    
    public static function getTotalPurchases($supplierId, $startDate = null, $endDate = null)
    {
        $sql = "SELECT SUM(total_amount) as total FROM purchase_orders WHERE supplier_id = ?";
        $params = [$supplierId];
        
        if ($startDate) {
            $sql .= " AND order_date >= ?";
            $params[] = $startDate;
        }
        
        if ($endDate) {
            $sql .= " AND order_date <= ?";
            $params[] = $endDate;
        }
        
        $result = db()->fetchOne($sql, $params);
        return $result['total'] ?? 0;
    }
    
    public static function getStatistics()
    {
        return [
            'total_suppliers' => db()->fetchOne("SELECT COUNT(*) as count FROM suppliers WHERE status = 'active'")['count'],
            'total_purchases' => db()->fetchOne("SELECT SUM(total_amount) as total FROM purchase_orders")['total'] ?? 0,
            'active_orders' => db()->fetchOne("SELECT COUNT(*) as count FROM purchase_orders WHERE status IN ('pending', 'approved')")['count']
        ];
    }
    
    public static function getCities()
    {
        return db()->fetchAll("SELECT DISTINCT city FROM suppliers WHERE city IS NOT NULL ORDER BY city");
    }
}
