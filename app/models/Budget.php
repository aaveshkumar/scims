<?php

class Budget
{
    protected static $table = 'budget';

    public static function all($filters = [])
    {
        $sql = "SELECT * FROM " . self::$table . " WHERE 1=1";
        $params = [];

        if (!empty($filters['category'])) {
            $sql .= " AND category = ?";
            $params[] = $filters['category'];
        }

        if (!empty($filters['status'])) {
            $sql .= " AND status = ?";
            $params[] = $filters['status'];
        }

        if (!empty($filters['academic_year'])) {
            $sql .= " AND academic_year = ?";
            $params[] = $filters['academic_year'];
        }

        $sql .= " ORDER BY academic_year DESC, allocated_amount DESC";

        return db()->fetchAll($sql, $params);
    }

    public static function find($id)
    {
        return db()->fetchOne("SELECT * FROM " . self::$table . " WHERE id = ?", [$id]);
    }

    public static function create($data)
    {
        $sql = "INSERT INTO " . self::$table . " 
                (budget_number, category, description, allocated_amount, spent_amount, academic_year, period, status, created_by) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        return db()->execute($sql, [
            $data['budget_number'] ?? self::generateBudgetNumber(),
            $data['category'],
            $data['description'] ?? null,
            $data['allocated_amount'],
            $data['spent_amount'] ?? 0,
            $data['academic_year'],
            $data['period'] ?? null,
            $data['status'] ?? 'active',
            $data['created_by'] ?? 1
        ]);
    }

    public static function update($id, $data)
    {
        $sql = "UPDATE " . self::$table . " 
                SET category = ?, description = ?, allocated_amount = ?, spent_amount = ?, 
                    academic_year = ?, period = ?, status = ?, updated_at = CURRENT_TIMESTAMP
                WHERE id = ?";

        return db()->execute($sql, [
            $data['category'],
            $data['description'] ?? null,
            $data['allocated_amount'],
            $data['spent_amount'] ?? 0,
            $data['academic_year'],
            $data['period'] ?? null,
            $data['status'],
            $id
        ]);
    }

    public static function delete($id)
    {
        return db()->execute("DELETE FROM " . self::$table . " WHERE id = ?", [$id]);
    }

    public static function generateBudgetNumber()
    {
        $prefix = 'BUD';
        $year = date('Y');
        
        $lastBudget = db()->fetchOne(
            "SELECT budget_number FROM " . self::$table . " 
             WHERE budget_number LIKE ? 
             ORDER BY id DESC LIMIT 1",
            ["$prefix-$year%"]
        );
        
        if ($lastBudget) {
            $lastNumber = (int)substr($lastBudget['budget_number'], -4);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }
        
        return "$prefix-$year-$newNumber";
    }

    public static function getCategories()
    {
        return [
            'Academic' => 'Academic',
            'Administrative' => 'Administrative',
            'Infrastructure' => 'Infrastructure',
            'Staff' => 'Staff',
            'Utilities' => 'Utilities',
            'Technology' => 'Technology',
            'Maintenance' => 'Maintenance',
            'Events' => 'Events',
            'Other' => 'Other'
        ];
    }

    public static function getStatistics()
    {
        $result = db()->fetchOne("SELECT COUNT(*) as total, SUM(allocated_amount) as total_allocated, SUM(spent_amount) as total_spent FROM " . self::$table);
        
        return [
            'total_budgets' => $result['total'] ?? 0,
            'total_allocated' => $result['total_allocated'] ?? 0,
            'total_spent' => $result['total_spent'] ?? 0,
            'remaining' => ($result['total_allocated'] ?? 0) - ($result['total_spent'] ?? 0)
        ];
    }
}
