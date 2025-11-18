<?php

class FeeTemplate
{
    protected static $table = 'fee_structure_templates';
    
    public static function getAll($filters = [])
    {
        $sql = "SELECT ft.*, c.name as class_name
                FROM fee_structure_templates ft
                LEFT JOIN classes c ON ft.class_id = c.id
                WHERE 1=1";
        $params = [];
        
        if (!empty($filters['class_id'])) {
            $sql .= " AND ft.class_id = ?";
            $params[] = $filters['class_id'];
        }
        
        if (!empty($filters['academic_year'])) {
            $sql .= " AND ft.academic_year = ?";
            $params[] = $filters['academic_year'];
        }
        
        if (!empty($filters['status'])) {
            $sql .= " AND ft.status = ?";
            $params[] = $filters['status'];
        }
        
        $sql .= " ORDER BY ft.academic_year DESC, c.name";
        
        return db()->fetchAll($sql, $params);
    }
    
    public static function find($id)
    {
        $sql = "SELECT ft.*, c.name as class_name
                FROM fee_structure_templates ft
                LEFT JOIN classes c ON ft.class_id = c.id
                WHERE ft.id = ?";
        
        return db()->fetchOne($sql, [$id]);
    }
    
    public static function create($data)
    {
        $sql = "INSERT INTO fee_structure_templates (name, class_id, academic_year, 
                amount, due_date, fine_per_day, description, status, created_at, updated_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
        
        return db()->execute($sql, [
            $data['name'],
            $data['class_id'] ?? null,
            $data['academic_year'],
            $data['amount'],
            $data['due_date'] ?? null,
            $data['fine_per_day'] ?? 0,
            $data['description'] ?? null,
            $data['status'] ?? 'active'
        ]);
    }
    
    public static function update($id, $data)
    {
        $sql = "UPDATE fee_structure_templates SET name = ?, class_id = ?, 
                academic_year = ?, amount = ?, due_date = ?, fine_per_day = ?, 
                description = ?, status = ?, updated_at = NOW() WHERE id = ?";
        
        return db()->execute($sql, [
            $data['name'],
            $data['class_id'] ?? null,
            $data['academic_year'],
            $data['amount'],
            $data['due_date'] ?? null,
            $data['fine_per_day'] ?? 0,
            $data['description'] ?? null,
            $data['status'],
            $id
        ]);
    }
    
    public static function delete($id)
    {
        return db()->execute("DELETE FROM fee_structure_templates WHERE id = ?", [$id]);
    }
    
    public static function getStatistics()
    {
        return [
            'total_templates' => db()->fetchOne("SELECT COUNT(*) as count FROM fee_structure_templates WHERE status = 'active'")['count'],
            'total_amount' => db()->fetchOne("SELECT SUM(amount) as total FROM fee_structure_templates WHERE status = 'active'")['total'] ?? 0
        ];
    }
}
