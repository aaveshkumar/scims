<?php

namespace App\Models;

use App\Helpers\Database;
use PDO;

class SchoolCalendar
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getAll($filters = [])
    {
        $sql = "SELECT sc.*, c.name as class_name, u.first_name, u.last_name 
                FROM school_calendar sc
                LEFT JOIN classes c ON sc.class_id = c.id
                LEFT JOIN users u ON sc.created_by = u.id
                WHERE 1=1";
        
        $params = [];

        if (!empty($filters['event_type'])) {
            $sql .= " AND sc.event_type = :event_type";
            $params[':event_type'] = $filters['event_type'];
        }

        if (!empty($filters['class_id'])) {
            $sql .= " AND sc.class_id = :class_id";
            $params[':class_id'] = $filters['class_id'];
        }

        if (!empty($filters['month'])) {
            $sql .= " AND MONTH(sc.event_date) = :month";
            $params[':month'] = $filters['month'];
        }

        if (!empty($filters['year'])) {
            $sql .= " AND YEAR(sc.event_date) = :year";
            $params[':year'] = $filters['year'];
        }

        if (isset($filters['is_public'])) {
            $sql .= " AND sc.is_public = :is_public";
            $params[':is_public'] = $filters['is_public'];
        }

        $sql .= " ORDER BY sc.event_date ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->db->prepare("
            SELECT sc.*, c.name as class_name
            FROM school_calendar sc
            LEFT JOIN classes c ON sc.class_id = c.id
            WHERE sc.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUpcoming($limit = 10)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM school_calendar
            WHERE event_date >= CURDATE()
            AND is_public = 1
            ORDER BY event_date ASC
            LIMIT ?
        ");
        $stmt->execute([$limit]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByDateRange($startDate, $endDate)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM school_calendar
            WHERE event_date BETWEEN ? AND ?
            ORDER BY event_date ASC
        ");
        $stmt->execute([$startDate, $endDate]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO school_calendar (
                title, description, event_date, end_date, event_type,
                category, color, is_holiday, is_public, class_id,
                department, created_by
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        return $stmt->execute([
            $data['title'],
            $data['description'] ?? null,
            $data['event_date'],
            $data['end_date'] ?? null,
            $data['event_type'] ?? 'event',
            $data['category'] ?? null,
            $data['color'] ?? '#4e73df',
            $data['is_holiday'] ?? 0,
            $data['is_public'] ?? 1,
            $data['class_id'] ?? null,
            $data['department'] ?? null,
            $data['created_by'] ?? auth()['id']
        ]);
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare("
            UPDATE school_calendar
            SET title = ?, description = ?, event_date = ?, end_date = ?,
                event_type = ?, category = ?, color = ?, is_holiday = ?,
                is_public = ?, class_id = ?, department = ?
            WHERE id = ?
        ");

        return $stmt->execute([
            $data['title'],
            $data['description'] ?? null,
            $data['event_date'],
            $data['end_date'] ?? null,
            $data['event_type'] ?? 'event',
            $data['category'] ?? null,
            $data['color'] ?? '#4e73df',
            $data['is_holiday'] ?? 0,
            $data['is_public'] ?? 1,
            $data['class_id'] ?? null,
            $data['department'] ?? null,
            $id
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM school_calendar WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getEventTypes()
    {
        return ['holiday', 'exam', 'event', 'meeting', 'vacation', 'other'];
    }
}
