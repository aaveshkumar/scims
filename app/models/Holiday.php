<?php

namespace App\Models;

use App\Helpers\Database;
use PDO;

class Holiday
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll($filters = [])
    {
        $sql = "SELECT h.*, u.first_name, u.last_name
                FROM holidays h
                LEFT JOIN users u ON h.created_by = u.id
                WHERE 1=1";
        
        $params = [];

        if (!empty($filters['holiday_type'])) {
            $sql .= " AND h.holiday_type = :holiday_type";
            $params[':holiday_type'] = $filters['holiday_type'];
        }

        if (!empty($filters['year'])) {
            $sql .= " AND YEAR(h.start_date) = :year";
            $params[':year'] = $filters['year'];
        }

        if (isset($filters['status'])) {
            $sql .= " AND h.status = :status";
            $params[':status'] = $filters['status'];
        }

        $sql .= " ORDER BY h.start_date ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM holidays WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUpcoming($limit = 5)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM holidays
            WHERE start_date >= CURDATE()
            AND status = 'active'
            ORDER BY start_date ASC
            LIMIT ?
        ");
        $stmt->execute([$limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByYear($year)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM holidays
            WHERE YEAR(start_date) = ?
            ORDER BY start_date ASC
        ");
        $stmt->execute([$year]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO holidays (
                name, description, start_date, end_date,
                holiday_type, is_recurring, status, created_by
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");

        return $stmt->execute([
            $data['name'],
            $data['description'] ?? null,
            $data['start_date'],
            $data['end_date'],
            $data['holiday_type'] ?? 'school',
            $data['is_recurring'] ?? 0,
            $data['status'] ?? 'active',
            $data['created_by'] ?? auth()['id']
        ]);
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare("
            UPDATE holidays
            SET name = ?, description = ?, start_date = ?, end_date = ?,
                holiday_type = ?, is_recurring = ?, status = ?
            WHERE id = ?
        ");

        return $stmt->execute([
            $data['name'],
            $data['description'] ?? null,
            $data['start_date'],
            $data['end_date'],
            $data['holiday_type'] ?? 'school',
            $data['is_recurring'] ?? 0,
            $data['status'] ?? 'active',
            $id
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM holidays WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getHolidayTypes()
    {
        return ['national', 'religious', 'school', 'other'];
    }
}
