<?php

class HostelResident extends Model
{
    protected $table = 'hostel_residents';
    
    public static function getAll($filters = [])
    {
        $sql = "SELECT r.*, s.first_name, s.last_name, s.roll_number, s.class,
                h.name as hostel_name, hr.room_number
                FROM hostel_residents r
                JOIN students s ON r.student_id = s.id
                JOIN hostels h ON r.hostel_id = h.id
                JOIN hostel_rooms hr ON r.room_id = hr.id
                WHERE 1=1";
        $params = [];
        
        if (!empty($filters['hostel_id'])) {
            $sql .= " AND r.hostel_id = ?";
            $params[] = $filters['hostel_id'];
        }
        
        if (!empty($filters['status'])) {
            $sql .= " AND r.status = ?";
            $params[] = $filters['status'];
        }
        
        if (!empty($filters['search'])) {
            $sql .= " AND (s.first_name LIKE ? OR s.last_name LIKE ? OR s.roll_number LIKE ?)";
            $search = "%{$filters['search']}%";
            $params[] = $search;
            $params[] = $search;
            $params[] = $search;
        }
        
        $sql .= " ORDER BY h.name, hr.room_number, s.first_name, s.last_name";
        
        return db()->fetchAll($sql, $params);
    }
    
    public static function find($id)
    {
        $sql = "SELECT r.*, s.first_name, s.last_name, s.roll_number, s.class, s.phone,
                h.name as hostel_name, hr.room_number, hr.room_type
                FROM hostel_residents r
                JOIN students s ON r.student_id = s.id
                JOIN hostels h ON r.hostel_id = h.id
                JOIN hostel_rooms hr ON r.room_id = hr.id
                WHERE r.id = ?";
        
        return db()->fetchOne($sql, [$id]);
    }
    
    public static function create($data)
    {
        $sql = "INSERT INTO hostel_residents (student_id, hostel_id, room_id, 
                admission_date, checkout_date, guardian_contact, emergency_contact, 
                status, created_at, updated_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
        
        $result = db()->execute($sql, [
            $data['student_id'],
            $data['hostel_id'],
            $data['room_id'],
            $data['admission_date'],
            $data['checkout_date'] ?? null,
            $data['guardian_contact'] ?? null,
            $data['emergency_contact'] ?? null,
            $data['status'] ?? 'active'
        ]);
        
        if ($result) {
            HostelRoom::updateOccupancy($data['room_id']);
        }
        
        return $result;
    }
    
    public static function update($id, $data)
    {
        $resident = self::find($id);
        $oldRoomId = $resident['room_id'];
        
        $sql = "UPDATE hostel_residents SET hostel_id = ?, room_id = ?, 
                admission_date = ?, checkout_date = ?, guardian_contact = ?, 
                emergency_contact = ?, status = ?, updated_at = NOW() WHERE id = ?";
        
        $result = db()->execute($sql, [
            $data['hostel_id'],
            $data['room_id'],
            $data['admission_date'],
            $data['checkout_date'] ?? null,
            $data['guardian_contact'] ?? null,
            $data['emergency_contact'] ?? null,
            $data['status'],
            $id
        ]);
        
        if ($result) {
            HostelRoom::updateOccupancy($data['room_id']);
            if ($oldRoomId != $data['room_id']) {
                HostelRoom::updateOccupancy($oldRoomId);
            }
        }
        
        return $result;
    }
    
    public static function delete($id)
    {
        $resident = self::find($id);
        $result = db()->execute("DELETE FROM hostel_residents WHERE id = ?", [$id]);
        
        if ($result && $resident) {
            HostelRoom::updateOccupancy($resident['room_id']);
        }
        
        return $result;
    }
    
    public static function isStudentResident($studentId, $excludeId = null)
    {
        $sql = "SELECT * FROM hostel_residents WHERE student_id = ? AND status = 'active'";
        $params = [$studentId];
        
        if ($excludeId) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }
        
        return db()->fetchOne($sql, $params) !== false;
    }
    
    public static function checkoutResident($id)
    {
        $data = [
            'checkout_date' => date('Y-m-d'),
            'status' => 'inactive'
        ];
        
        $resident = self::find($id);
        $result = db()->execute(
            "UPDATE hostel_residents SET checkout_date = ?, status = ?, updated_at = NOW() WHERE id = ?",
            [$data['checkout_date'], $data['status'], $id]
        );
        
        if ($result && $resident) {
            HostelRoom::updateOccupancy($resident['room_id']);
        }
        
        return $result;
    }
    
    public static function getStatistics()
    {
        return [
            'total_residents' => db()->fetchOne("SELECT COUNT(*) as count FROM hostel_residents WHERE status = 'active'")['count'],
            'students_without_hostel' => db()->fetchOne("SELECT COUNT(*) as count FROM students s LEFT JOIN hostel_residents r ON s.id = r.student_id AND r.status = 'active' WHERE r.id IS NULL")['count']
        ];
    }
}
