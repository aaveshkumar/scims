<?php

class Expense
{
    protected static $table = 'expenses';

    public static function all($filters = [])
    {
        $sql = "SELECT * FROM " . self::$table;
        $params = [];

        if (!empty($filters['status'])) {
            $sql .= " WHERE status = ?";
            $params[] = $filters['status'];
        }

        if (!empty($filters['category'])) {
            if (empty($filters['status'])) {
                $sql .= " WHERE category = ?";
            } else {
                $sql .= " AND category = ?";
            }
            $params[] = $filters['category'];
        }

        $sql .= " ORDER BY expense_date DESC, created_at DESC";

        return db()->fetchAll($sql, $params);
    }

    public static function find($id)
    {
        return db()->fetchOne("SELECT * FROM " . self::$table . " WHERE id = ?", [$id]);
    }

    public static function create($data)
    {
        // Generate expense number if not provided
        if (empty($data['expense_number'])) {
            $data['expense_number'] = 'EXP-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        }

        $sql = "INSERT INTO " . self::$table . " 
                (expense_number, category, description, amount, expense_date, payment_method, vendor, invoice_number, status, created_by) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        return db()->execute($sql, [
            $data['expense_number'],
            $data['category'],
            $data['description'] ?? null,
            $data['amount'],
            $data['expense_date'],
            $data['payment_method'] ?? null,
            $data['vendor'] ?? null,
            $data['invoice_number'] ?? null,
            $data['status'] ?? 'pending',
            $_SESSION['user_id'] ?? 1
        ]);
    }

    public static function update($id, $data)
    {
        $sql = "UPDATE " . self::$table . " 
                SET category = ?, description = ?, amount = ?, expense_date = ?, 
                    payment_method = ?, vendor = ?, invoice_number = ?, status = ?,
                    updated_at = CURRENT_TIMESTAMP
                WHERE id = ?";

        return db()->execute($sql, [
            $data['category'],
            $data['description'] ?? null,
            $data['amount'],
            $data['expense_date'],
            $data['payment_method'] ?? null,
            $data['vendor'] ?? null,
            $data['invoice_number'] ?? null,
            $data['status'] ?? 'pending',
            $id
        ]);
    }

    public static function delete($id)
    {
        return db()->execute("DELETE FROM " . self::$table . " WHERE id = ?", [$id]);
    }

    public static function getCategories()
    {
        return [
            'Supplies' => 'Supplies',
            'Equipment' => 'Equipment',
            'Utilities' => 'Utilities',
            'Maintenance' => 'Maintenance',
            'Travel' => 'Travel',
            'Staff' => 'Staff',
            'Other' => 'Other'
        ];
    }

    public static function getPaymentMethods()
    {
        return [
            'Cash' => 'Cash',
            'Check' => 'Check',
            'Credit Card' => 'Credit Card',
            'Bank Transfer' => 'Bank Transfer',
            'Digital Payment' => 'Digital Payment'
        ];
    }
}
