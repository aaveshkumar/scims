<?php

class Payroll
{
    protected static $table = 'payroll';
    
    public static function getAll($filters = [])
    {
        $sql = "SELECT p.*, s.employee_id, u.first_name, u.last_name, 
                CONCAT(u.first_name, ' ', u.last_name) as staff_name
                FROM payroll p
                JOIN staff s ON p.staff_id = s.id
                JOIN users u ON s.user_id = u.id
                WHERE 1=1";
        $params = [];
        
        if (!empty($filters['staff_id'])) {
            $sql .= " AND p.staff_id = ?";
            $params[] = $filters['staff_id'];
        }
        
        if (!empty($filters['month'])) {
            $sql .= " AND p.month = ?";
            $params[] = $filters['month'];
        }
        
        if (!empty($filters['year'])) {
            $sql .= " AND p.year = ?";
            $params[] = $filters['year'];
        }
        
        if (!empty($filters['status'])) {
            $sql .= " AND p.status = ?";
            $params[] = $filters['status'];
        }
        
        $sql .= " ORDER BY p.year DESC, p.month DESC, u.first_name";
        
        return db()->fetchAll($sql, $params);
    }
    
    public static function find($id)
    {
        $sql = "SELECT p.*, s.employee_id, s.designation, u.first_name, u.last_name
                FROM payroll p
                JOIN staff s ON p.staff_id = s.id
                JOIN users u ON s.user_id = u.id
                WHERE p.id = ?";
        
        return db()->fetchOne($sql, [$id]);
    }
    
    public static function create($data)
    {
        $grossSalary = $data['basic_salary'] + ($data['allowances'] ?? 0);
        $netSalary = $grossSalary - ($data['deductions'] ?? 0);
        
        $sql = "INSERT INTO payroll (payroll_number, staff_id, month, year, 
                basic_salary, allowances, deductions, gross_salary, net_salary, 
                payment_date, payment_method, status, remarks, created_by, 
                created_at, updated_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
        
        return db()->execute($sql, [
            $data['payroll_number'] ?? self::generatePayrollNumber(),
            $data['staff_id'],
            $data['month'],
            $data['year'],
            $data['basic_salary'],
            $data['allowances'] ?? 0,
            $data['deductions'] ?? 0,
            $grossSalary,
            $netSalary,
            $data['payment_date'] ?? null,
            $data['payment_method'] ?? null,
            $data['status'] ?? 'pending',
            $data['remarks'] ?? null,
            $data['created_by'] ?? null
        ]);
    }
    
    public static function update($id, $data)
    {
        $grossSalary = $data['basic_salary'] + ($data['allowances'] ?? 0);
        $netSalary = $grossSalary - ($data['deductions'] ?? 0);
        
        $sql = "UPDATE payroll SET basic_salary = ?, allowances = ?, deductions = ?, 
                gross_salary = ?, net_salary = ?, payment_date = ?, payment_method = ?, 
                status = ?, remarks = ?, updated_at = NOW() WHERE id = ?";
        
        return db()->execute($sql, [
            $data['basic_salary'],
            $data['allowances'] ?? 0,
            $data['deductions'] ?? 0,
            $grossSalary,
            $netSalary,
            $data['payment_date'] ?? null,
            $data['payment_method'] ?? null,
            $data['status'],
            $data['remarks'] ?? null,
            $id
        ]);
    }
    
    public static function delete($id)
    {
        return db()->execute("DELETE FROM payroll WHERE id = ?", [$id]);
    }
    
    public static function generatePayrollNumber()
    {
        $prefix = 'PAY';
        $year = date('Y');
        $month = date('m');
        
        $lastPayroll = db()->fetchOne(
            "SELECT payroll_number FROM payroll 
             WHERE payroll_number LIKE ? 
             ORDER BY id DESC LIMIT 1",
            ["$prefix-$year$month%"]
        );
        
        if ($lastPayroll) {
            $lastNumber = (int)substr($lastPayroll['payroll_number'], -4);
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }
        
        return "$prefix-$year$month-$newNumber";
    }
    
    public static function getStatistics()
    {
        $totalResult = db()->fetchOne("SELECT COUNT(*) as count, SUM(net_salary) as total FROM payroll");
        $pendingResult = db()->fetchOne("SELECT COUNT(*) as count FROM payroll WHERE status = 'pending'");
        $paidResult = db()->fetchOne("SELECT COUNT(*) as count FROM payroll WHERE status = 'paid'");
        $thisMonthResult = db()->fetchOne("SELECT SUM(net_salary) as total FROM payroll WHERE month = ?", [date('F')]);
        
        return [
            'total_records' => $totalResult['count'] ?? 0,
            'total_paid' => $totalResult['total'] ?? 0,
            'pending_count' => $pendingResult['count'] ?? 0,
            'paid_count' => $paidResult['count'] ?? 0,
            'current_month_total' => $thisMonthResult['total'] ?? 0
        ];
    }
}
