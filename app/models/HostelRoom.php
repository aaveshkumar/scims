<?php

class HostelRoom
{
    protected static $table = 'hostel_rooms';
    
    public static function getAll($filters = [])
    {
        $sql = "SELECT hr.*, h.name as hostel_name
                FROM hostel_rooms hr
                JOIN hostels h ON hr.hostel_id = h.id
                WHERE 1=1";
        $params = [];
        
        if (!empty($filters['hostel_id'])) {
            $sql .= " AND hr.hostel_id = ?";
            $params[] = $filters['hostel_id'];
        }
        
        if (!empty($filters['status'])) {
            $sql .= " AND hr.status = ?";
            $params[] = $filters['status'];
        }
        
        if (!empty($filters['room_type'])) {
            $sql .= " AND hr.room_type = ?";
            $params[] = $filters['room_type'];
        }
        
        if (!empty($filters['floor_number'])) {
            $sql .= " AND hr.floor_number = ?";
            $params[] = $filters['floor_number'];
        }
        
        $sql .= " ORDER BY h.name, hr.room_number ASC";
        
        return db()->fetchAll($sql, $params);
    }
    
    public static function find($id)
    {
        $sql = "SELECT hr.*, h.name as hostel_name
                FROM hostel_rooms hr
                JOIN hostels h ON hr.hostel_id = h.id
                WHERE hr.id = ?";
        
        return db()->fetchOne($sql, [$id]);
    }
    
    public static function create($data)
    {
        $sql = "INSERT INTO hostel_rooms (hostel_id, room_number, room_type, 
                capacity, occupied_beds, floor_number, room_fee, amenities, 
                status, created_at, updated_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
        
        return db()->execute($sql, [
            $data['hostel_id'],
            $data['room_number'],
            $data['room_type'] ?? null,
            $data['capacity'] ?? 1,
            $data['occupied_beds'] ?? 0,
            $data['floor_number'] ?? null,
            $data['room_fee'] ?? null,
            $data['amenities'] ?? null,
            $data['status'] ?? 'available'
        ]);
    }
    
    public static function update($id, $data)
    {
        $sql = "UPDATE hostel_rooms SET room_number = ?, room_type = ?, 
                capacity = ?, occupied_beds = ?, floor_number = ?, room_fee = ?, 
                amenities = ?, status = ?, updated_at = NOW() WHERE id = ?";
        
        return db()->execute($sql, [
            $data['room_number'],
            $data['room_type'] ?? null,
            $data['capacity'] ?? 1,
            $data['occupied_beds'] ?? 0,
            $data['floor_number'] ?? null,
            $data['room_fee'] ?? null,
            $data['amenities'] ?? null,
            $data['status'],
            $id
        ]);
    }
    
    public static function delete($id)
    {
        return db()->execute("DELETE FROM hostel_rooms WHERE id = ?", [$id]);
    }
    
    public static function getAvailableRooms($hostelId = null)
    {
        $sql = "SELECT hr.*, h.name as hostel_name
                FROM hostel_rooms hr
                JOIN hostels h ON hr.hostel_id = h.id
                WHERE hr.occupied_beds < hr.capacity";
        $params = [];
        
        if ($hostelId) {
            $sql .= " AND hr.hostel_id = ?";
            $params[] = $hostelId;
        }
        
        $sql .= " ORDER BY h.name, hr.room_number";
        
        return db()->fetchAll($sql, $params);
    }
    
    public static function updateOccupancy($roomId)
    {
        $occupied = db()->fetchOne(
            "SELECT COUNT(*) as count FROM hostel_residents 
             WHERE room_id = ? AND status = 'active'",
            [$roomId]
        )['count'];
        
        $result = db()->execute(
            "UPDATE hostel_rooms SET occupied_beds = ?, 
             status = CASE WHEN occupied_beds >= capacity THEN 'occupied' ELSE 'available' END,
             updated_at = NOW() WHERE id = ?",
            [$occupied, $roomId]
        );
        
        $room = self::find($roomId);
        if ($room) {
            Hostel::updateOccupancy($room['hostel_id']);
        }
        
        return $result;
    }
    
    public static function hasCapacity($roomId)
    {
        $room = self::find($roomId);
        return $room && $room['occupied_beds'] < $room['capacity'];
    }
    
    public static function getResidents($roomId)
    {
        $sql = "SELECT r.*, s.first_name, s.last_name, s.roll_number
                FROM hostel_residents r
                JOIN students s ON r.student_id = s.id
                WHERE r.room_id = ? AND r.status = 'active'
                ORDER BY r.admission_date";
        
        return db()->fetchAll($sql, [$roomId]);
    }
    
    public static function getRoomTypes()
    {
        return db()->fetchAll("SELECT DISTINCT room_type FROM hostel_rooms WHERE room_type IS NOT NULL ORDER BY room_type");
    }
}
