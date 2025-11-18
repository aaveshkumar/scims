<?php

class HostelComplaint
{
    protected static $table = 'hostel_complaints';
    
    public static function getAll($filters = [])
    {
        $sql = "SELECT c.*, 
                s.first_name as student_first_name, s.last_name as student_last_name, 
                s.roll_number,
                h.name as hostel_name,
                CONCAT(u.first_name, ' ', u.last_name) as assigned_to_name
                FROM hostel_complaints c
                JOIN hostel_residents r ON c.resident_id = r.id
                JOIN students s ON r.student_id = s.id
                JOIN hostels h ON c.hostel_id = h.id
                LEFT JOIN users u ON c.assigned_to = u.id
                WHERE 1=1";
        $params = [];
        
        if (!empty($filters['hostel_id'])) {
            $sql .= " AND c.hostel_id = ?";
            $params[] = $filters['hostel_id'];
        }
        
        if (!empty($filters['status'])) {
            $sql .= " AND c.status = ?";
            $params[] = $filters['status'];
        }
        
        if (!empty($filters['priority'])) {
            $sql .= " AND c.priority = ?";
            $params[] = $filters['priority'];
        }
        
        if (!empty($filters['complaint_type'])) {
            $sql .= " AND c.complaint_type = ?";
            $params[] = $filters['complaint_type'];
        }
        
        $sql .= " ORDER BY 
                  FIELD(c.priority, 'high', 'medium', 'low'),
                  FIELD(c.status, 'pending', 'in_progress', 'resolved'),
                  c.created_at DESC";
        
        return db()->fetchAll($sql, $params);
    }
    
    public static function find($id)
    {
        $sql = "SELECT c.*, 
                s.first_name as student_first_name, s.last_name as student_last_name, 
                s.roll_number, s.phone as student_phone,
                h.name as hostel_name,
                CONCAT(u.first_name, ' ', u.last_name) as assigned_to_name, u.email as assigned_to_email
                FROM hostel_complaints c
                JOIN hostel_residents r ON c.resident_id = r.id
                JOIN students s ON r.student_id = s.id
                JOIN hostels h ON c.hostel_id = h.id
                LEFT JOIN users u ON c.assigned_to = u.id
                WHERE c.id = ?";
        
        return db()->fetchOne($sql, [$id]);
    }
    
    public static function create($data)
    {
        $sql = "INSERT INTO hostel_complaints (resident_id, hostel_id, complaint_type, 
                description, priority, status, assigned_to, resolved_date, remarks, 
                created_at, updated_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
        
        return db()->execute($sql, [
            $data['resident_id'],
            $data['hostel_id'],
            $data['complaint_type'] ?? null,
            $data['description'],
            $data['priority'] ?? 'medium',
            $data['status'] ?? 'pending',
            $data['assigned_to'] ?? null,
            $data['resolved_date'] ?? null,
            $data['remarks'] ?? null
        ]);
    }
    
    public static function update($id, $data)
    {
        $sql = "UPDATE hostel_complaints SET complaint_type = ?, description = ?, 
                priority = ?, status = ?, assigned_to = ?, resolved_date = ?, 
                remarks = ?, updated_at = NOW() WHERE id = ?";
        
        return db()->execute($sql, [
            $data['complaint_type'] ?? null,
            $data['description'],
            $data['priority'],
            $data['status'],
            $data['assigned_to'] ?? null,
            $data['resolved_date'] ?? null,
            $data['remarks'] ?? null,
            $id
        ]);
    }
    
    public static function delete($id)
    {
        return db()->execute("DELETE FROM hostel_complaints WHERE id = ?", [$id]);
    }
    
    public static function resolve($id, $remarks = null)
    {
        return db()->execute(
            "UPDATE hostel_complaints SET status = 'resolved', resolved_date = CURDATE(), 
             remarks = ?, updated_at = NOW() WHERE id = ?",
            [$remarks, $id]
        );
    }
    
    public static function assign($id, $userId)
    {
        return db()->execute(
            "UPDATE hostel_complaints SET assigned_to = ?, status = 'in_progress', 
             updated_at = NOW() WHERE id = ?",
            [$userId, $id]
        );
    }
    
    public static function getPendingComplaints($hostelId = null)
    {
        $sql = "SELECT c.*, h.name as hostel_name
                FROM hostel_complaints c
                JOIN hostels h ON c.hostel_id = h.id
                WHERE c.status IN ('pending', 'in_progress')";
        $params = [];
        
        if ($hostelId) {
            $sql .= " AND c.hostel_id = ?";
            $params[] = $hostelId;
        }
        
        $sql .= " ORDER BY FIELD(c.priority, 'high', 'medium', 'low'), c.created_at";
        
        return db()->fetchAll($sql, $params);
    }
    
    public static function getStatistics()
    {
        return [
            'total_complaints' => db()->fetchOne("SELECT COUNT(*) as count FROM hostel_complaints")['count'],
            'pending' => db()->fetchOne("SELECT COUNT(*) as count FROM hostel_complaints WHERE status = 'pending'")['count'],
            'in_progress' => db()->fetchOne("SELECT COUNT(*) as count FROM hostel_complaints WHERE status = 'in_progress'")['count'],
            'resolved' => db()->fetchOne("SELECT COUNT(*) as count FROM hostel_complaints WHERE status = 'resolved'")['count'],
            'high_priority' => db()->fetchOne("SELECT COUNT(*) as count FROM hostel_complaints WHERE priority = 'high' AND status != 'resolved'")['count']
        ];
    }
    
    public static function getComplaintTypes()
    {
        return db()->fetchAll("SELECT DISTINCT complaint_type FROM hostel_complaints WHERE complaint_type IS NOT NULL ORDER BY complaint_type");
    }
}
