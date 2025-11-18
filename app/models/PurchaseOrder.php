<?php

class PurchaseOrder
{
    protected static $table = 'purchase_orders';
    
    public static function getAll($filters = [])
    {
        $sql = "SELECT po.*, s.name as supplier_name, s.supplier_code,
                u1.name as created_by_name, u2.name as approved_by_name
                FROM purchase_orders po
                JOIN suppliers s ON po.supplier_id = s.id
                LEFT JOIN users u1 ON po.created_by = u1.id
                LEFT JOIN users u2 ON po.approved_by = u2.id
                WHERE 1=1";
        $params = [];
        
        if (!empty($filters['search'])) {
            $sql .= " AND (po.po_number LIKE ? OR s.name LIKE ?)";
            $search = "%{$filters['search']}%";
            $params[] = $search;
            $params[] = $search;
        }
        
        if (!empty($filters['status'])) {
            $sql .= " AND po.status = ?";
            $params[] = $filters['status'];
        }
        
        if (!empty($filters['supplier_id'])) {
            $sql .= " AND po.supplier_id = ?";
            $params[] = $filters['supplier_id'];
        }
        
        $sql .= " ORDER BY po.order_date DESC, po.po_number DESC";
        
        return db()->fetchAll($sql, $params);
    }
    
    public static function find($id)
    {
        $sql = "SELECT po.*, s.name as supplier_name, s.contact_person, s.phone,
                u1.name as created_by_name, u2.name as approved_by_name
                FROM purchase_orders po
                JOIN suppliers s ON po.supplier_id = s.id
                LEFT JOIN users u1 ON po.created_by = u1.id
                LEFT JOIN users u2 ON po.approved_by = u2.id
                WHERE po.id = ?";
        
        return db()->fetchOne($sql, [$id]);
    }
    
    public static function create($data)
    {
        $sql = "INSERT INTO purchase_orders (po_number, supplier_id, order_date, 
                expected_delivery, actual_delivery, total_amount, status, 
                created_by, approved_by, remarks, created_at, updated_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
        
        return db()->execute($sql, [
            $data['po_number'],
            $data['supplier_id'],
            $data['order_date'],
            $data['expected_delivery'] ?? null,
            $data['actual_delivery'] ?? null,
            $data['total_amount'] ?? 0,
            $data['status'] ?? 'pending',
            $data['created_by'] ?? null,
            $data['approved_by'] ?? null,
            $data['remarks'] ?? null
        ]);
    }
    
    public static function update($id, $data)
    {
        $sql = "UPDATE purchase_orders SET supplier_id = ?, order_date = ?, 
                expected_delivery = ?, actual_delivery = ?, total_amount = ?, 
                status = ?, approved_by = ?, remarks = ?, updated_at = NOW() 
                WHERE id = ?";
        
        return db()->execute($sql, [
            $data['supplier_id'],
            $data['order_date'],
            $data['expected_delivery'] ?? null,
            $data['actual_delivery'] ?? null,
            $data['total_amount'],
            $data['status'],
            $data['approved_by'] ?? null,
            $data['remarks'] ?? null,
            $id
        ]);
    }
    
    public static function delete($id)
    {
        return db()->execute("DELETE FROM purchase_orders WHERE id = ?", [$id]);
    }
    
    public static function getItems($poId)
    {
        $sql = "SELECT poi.*, ii.item_code, ii.name as item_name, ii.unit
                FROM purchase_order_items poi
                JOIN inventory_items ii ON poi.item_id = ii.id
                WHERE poi.po_id = ?
                ORDER BY poi.id";
        
        return db()->fetchAll($sql, [$poId]);
    }
    
    public static function addItem($poId, $data)
    {
        $sql = "INSERT INTO purchase_order_items (po_id, item_id, quantity, 
                unit_price, total_price, received_quantity, created_at, updated_at) 
                VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())";
        
        $totalPrice = $data['quantity'] * $data['unit_price'];
        
        $result = db()->execute($sql, [
            $poId,
            $data['item_id'],
            $data['quantity'],
            $data['unit_price'],
            $totalPrice,
            0
        ]);
        
        if ($result) {
            self::recalculateTotal($poId);
        }
        
        return $result;
    }
    
    public static function receiveItems($poId, $itemId, $receivedQuantity)
    {
        $item = db()->fetchOne(
            "SELECT * FROM purchase_order_items WHERE po_id = ? AND item_id = ?",
            [$poId, $itemId]
        );
        
        if (!$item) return false;
        
        $newReceived = min($item['quantity'], $item['received_quantity'] + $receivedQuantity);
        
        db()->execute(
            "UPDATE purchase_order_items SET received_quantity = ?, updated_at = NOW() 
             WHERE po_id = ? AND item_id = ?",
            [$newReceived, $poId, $itemId]
        );
        
        InventoryItem::adjustStock($itemId, $receivedQuantity, 'add');
        
        $allReceived = db()->fetchOne(
            "SELECT COUNT(*) as count FROM purchase_order_items 
             WHERE po_id = ? AND received_quantity < quantity",
            [$poId]
        )['count'] == 0;
        
        if ($allReceived) {
            db()->execute(
                "UPDATE purchase_orders SET status = 'received', actual_delivery = CURDATE(), 
                 updated_at = NOW() WHERE id = ?",
                [$poId]
            );
        }
        
        return true;
    }
    
    public static function recalculateTotal($poId)
    {
        $total = db()->fetchOne(
            "SELECT SUM(total_price) as total FROM purchase_order_items WHERE po_id = ?",
            [$poId]
        )['total'] ?? 0;
        
        return db()->execute(
            "UPDATE purchase_orders SET total_amount = ?, updated_at = NOW() WHERE id = ?",
            [$total, $poId]
        );
    }
    
    public static function approve($id, $userId)
    {
        return db()->execute(
            "UPDATE purchase_orders SET status = 'approved', approved_by = ?, 
             updated_at = NOW() WHERE id = ?",
            [$userId, $id]
        );
    }
    
    public static function getPendingOrders()
    {
        return self::getAll(['status' => 'pending']);
    }
    
    public static function getStatistics()
    {
        return [
            'total_orders' => db()->fetchOne("SELECT COUNT(*) as count FROM purchase_orders")['count'],
            'pending' => db()->fetchOne("SELECT COUNT(*) as count FROM purchase_orders WHERE status = 'pending'")['count'],
            'approved' => db()->fetchOne("SELECT COUNT(*) as count FROM purchase_orders WHERE status = 'approved'")['count'],
            'this_month_value' => db()->fetchOne("SELECT SUM(total_amount) as total FROM purchase_orders WHERE MONTH(order_date) = MONTH(CURDATE()) AND YEAR(order_date) = YEAR(CURDATE())")['total'] ?? 0
        ];
    }
    
    public static function generatePONumber()
    {
        $prefix = 'PO';
        $year = date('Y');
        $month = date('m');
        
        $lastPO = db()->fetchOne(
            "SELECT po_number FROM purchase_orders 
             WHERE po_number LIKE ? 
             ORDER BY id DESC LIMIT 1",
            ["$prefix-$year$month%"]
        );
        
        if ($lastPO) {
            $lastNumber = (int)substr($lastPO['po_number'], -4);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }
        
        return "$prefix-$year$month-$newNumber";
    }
}
