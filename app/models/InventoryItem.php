<?php

class InventoryItem
{
    protected static $table = 'inventory_items';
    
    public static function getAll($filters = [])
    {
        $sql = "SELECT * FROM inventory_items WHERE 1=1";
        $params = [];
        
        if (!empty($filters['search'])) {
            $sql .= " AND (item_code LIKE ? OR name LIKE ?)";
            $search = "%{$filters['search']}%";
            $params[] = $search;
            $params[] = $search;
        }
        
        if (!empty($filters['category'])) {
            $sql .= " AND category = ?";
            $params[] = $filters['category'];
        }
        
        if (!empty($filters['status'])) {
            $sql .= " AND status = ?";
            $params[] = $filters['status'];
        }
        
        $sql .= " ORDER BY item_code ASC";
        
        return db()->fetchAll($sql, $params);
    }
    
    public static function find($id)
    {
        return db()->fetchOne("SELECT * FROM inventory_items WHERE id = ?", [$id]);
    }
    
    public static function create($data)
    {
        $sql = "INSERT INTO inventory_items (item_code, name, category, description, 
                unit, quantity, reorder_level, unit_price, location, status, 
                created_at, updated_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
        
        return db()->execute($sql, [
            $data['item_code'],
            $data['name'],
            $data['category'] ?? null,
            $data['description'] ?? null,
            $data['unit'] ?? 'piece',
            $data['quantity'] ?? 0,
            $data['reorder_level'] ?? 10,
            $data['unit_price'] ?? null,
            $data['location'] ?? null,
            $data['status'] ?? 'in_stock'
        ]);
    }
    
    public static function update($id, $data)
    {
        $sql = "UPDATE inventory_items SET item_code = ?, name = ?, category = ?, 
                description = ?, unit = ?, quantity = ?, reorder_level = ?, 
                unit_price = ?, location = ?, status = ?, updated_at = NOW() 
                WHERE id = ?";
        
        return db()->execute($sql, [
            $data['item_code'],
            $data['name'],
            $data['category'] ?? null,
            $data['description'] ?? null,
            $data['unit'],
            $data['quantity'],
            $data['reorder_level'],
            $data['unit_price'] ?? null,
            $data['location'] ?? null,
            $data['status'],
            $id
        ]);
    }
    
    public static function delete($id)
    {
        return db()->execute("DELETE FROM inventory_items WHERE id = ?", [$id]);
    }
    
    public static function adjustStock($id, $quantity, $operation = 'add')
    {
        $item = self::find($id);
        if (!$item) return false;
        
        $newQuantity = $operation === 'add' 
            ? $item['quantity'] + $quantity 
            : max(0, $item['quantity'] - $quantity);
        
        $status = $newQuantity <= 0 ? 'out_of_stock' 
            : ($newQuantity <= $item['reorder_level'] ? 'low_stock' : 'in_stock');
        
        return db()->execute(
            "UPDATE inventory_items SET quantity = ?, status = ?, updated_at = NOW() WHERE id = ?",
            [$newQuantity, $status, $id]
        );
    }
    
    public static function getLowStockItems()
    {
        return db()->fetchAll(
            "SELECT * FROM inventory_items 
             WHERE quantity <= reorder_level 
             AND status != 'discontinued'
             ORDER BY quantity ASC"
        );
    }
    
    public static function getOutOfStockItems()
    {
        return db()->fetchAll(
            "SELECT * FROM inventory_items 
             WHERE quantity = 0 
             AND status != 'discontinued'
             ORDER BY name ASC"
        );
    }
    
    public static function getStatistics()
    {
        return [
            'total_items' => db()->fetchOne("SELECT COUNT(*) as count FROM inventory_items WHERE status != 'discontinued'")['count'],
            'total_value' => db()->fetchOne("SELECT SUM(quantity * unit_price) as total FROM inventory_items WHERE status != 'discontinued'")['total'] ?? 0,
            'low_stock' => count(self::getLowStockItems()),
            'out_of_stock' => count(self::getOutOfStockItems())
        ];
    }
    
    public static function getCategories()
    {
        return db()->fetchAll("SELECT DISTINCT category FROM inventory_items WHERE category IS NOT NULL ORDER BY category");
    }
}
