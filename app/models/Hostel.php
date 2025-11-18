<?php

class Hostel
{
    protected static $table = 'hostels';
    
    public static function getAll($filters = [])
    {
        $sql = "SELECT h.*, CONCAT(u.first_name, ' ', u.last_name) as warden_name
                FROM hostels h
                LEFT JOIN users u ON h.warden_id = u.id
                WHERE 1=1";
        $params = [];
        
        if (!empty($filters['search'])) {
            $sql .= " AND (h.name LIKE ? OR h.hostel_type LIKE ?)";
            $search = "%{$filters['search']}%";
            $params[] = $search;
            $params[] = $search;
        }
        
        if (!empty($filters['hostel_type'])) {
            $sql .= " AND h.hostel_type = ?";
            $params[] = $filters['hostel_type'];
        }
        
        if (!empty($filters['status'])) {
            $sql .= " AND h.status = ?";
            $params[] = $filters['status'];
        }
        
        $sql .= " ORDER BY h.name ASC";
        
        return db()->fetchAll($sql, $params);
    }
    
    public static function find($id)
    {
        $sql = "SELECT h.*, CONCAT(u.first_name, ' ', u.last_name) as warden_name, u.email as warden_email
                FROM hostels h
                LEFT JOIN users u ON h.warden_id = u.id
                WHERE h.id = ?";
        
        return db()->fetchOne($sql, [$id]);
    }
    
    public static function create($data)
    {
        $sql = "INSERT INTO hostels (name, hostel_type, address, warden_id, 
                total_rooms, occupied_rooms, status, created_at, updated_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
        
        return db()->execute($sql, [
            $data['name'],
            $data['hostel_type'] ?? null,
            $data['address'] ?? null,
            $data['warden_id'] ?? null,
            $data['total_rooms'] ?? 0,
            $data['occupied_rooms'] ?? 0,
            $data['status'] ?? 'active'
        ]);
    }
    
    public static function update($id, $data)
    {
        $sql = "UPDATE hostels SET name = ?, hostel_type = ?, address = ?, 
                warden_id = ?, total_rooms = ?, occupied_rooms = ?, status = ?, 
                updated_at = NOW() WHERE id = ?";
        
        return db()->execute($sql, [
            $data['name'],
            $data['hostel_type'] ?? null,
            $data['address'] ?? null,
            $data['warden_id'] ?? null,
            $data['total_rooms'] ?? 0,
            $data['occupied_rooms'] ?? 0,
            $data['status'] ?? 'active',
            $id
        ]);
    }
    
    public static function delete($id)
    {
        return db()->execute("DELETE FROM hostels WHERE id = ?", [$id]);
    }
    
    public static function updateOccupancy($hostelId)
    {
        $occupied = db()->fetchOne(
            "SELECT COUNT(*) as count FROM hostel_rooms 
             WHERE hostel_id = ? AND status = 'occupied'",
            [$hostelId]
        )['count'];
        
        return db()->execute(
            "UPDATE hostels SET occupied_rooms = ?, updated_at = NOW() WHERE id = ?",
            [$occupied, $hostelId]
        );
    }
    
    public static function getOccupancyRate($hostelId)
    {
        $hostel = self::find($hostelId);
        if (!$hostel || $hostel['total_rooms'] == 0) return 0;
        
        return round(($hostel['occupied_rooms'] / $hostel['total_rooms']) * 100, 2);
    }
    
    public static function getStatistics()
    {
        return [
            'total_hostels' => db()->fetchOne("SELECT COUNT(*) as count FROM hostels WHERE status = 'active'")['count'],
            'total_rooms' => db()->fetchOne("SELECT SUM(total_rooms) as total FROM hostels WHERE status = 'active'")['total'] ?? 0,
            'occupied_rooms' => db()->fetchOne("SELECT SUM(occupied_rooms) as total FROM hostels WHERE status = 'active'")['total'] ?? 0,
            'total_residents' => db()->fetchOne("SELECT COUNT(*) as count FROM hostel_residents WHERE status = 'active'")['count']
        ];
    }
    
    public static function getTypes()
    {
        return db()->fetchAll("SELECT DISTINCT hostel_type FROM hostels WHERE hostel_type IS NOT NULL ORDER BY hostel_type");
    }
}
