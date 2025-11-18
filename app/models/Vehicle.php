<?php

class Vehicle extends Model
{
    protected $table = 'vehicles';
    
    /**
     * Get all vehicles with optional filters
     */
    public static function getAll($filters = [])
    {
        $sql = "SELECT * FROM vehicles WHERE 1=1";
        $params = [];
        
        if (!empty($filters['search'])) {
            $sql .= " AND (vehicle_number LIKE ? OR model LIKE ? OR manufacturer LIKE ?)";
            $search = "%{$filters['search']}%";
            $params[] = $search;
            $params[] = $search;
            $params[] = $search;
        }
        
        if (!empty($filters['vehicle_type'])) {
            $sql .= " AND vehicle_type = ?";
            $params[] = $filters['vehicle_type'];
        }
        
        if (!empty($filters['status'])) {
            $sql .= " AND status = ?";
            $params[] = $filters['status'];
        }
        
        $sql .= " ORDER BY vehicle_number ASC";
        
        return db()->fetchAll($sql, $params);
    }
    
    /**
     * Get vehicle by ID
     */
    public static function find($id)
    {
        return db()->fetchOne("SELECT * FROM vehicles WHERE id = ?", [$id]);
    }
    
    /**
     * Create new vehicle
     */
    public static function create($data)
    {
        $sql = "INSERT INTO vehicles (vehicle_number, vehicle_type, model, manufacturer, 
                year, capacity, fuel_type, registration_date, insurance_expiry, 
                fitness_expiry, status, created_at, updated_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
        
        return db()->execute($sql, [
            $data['vehicle_number'],
            $data['vehicle_type'] ?? null,
            $data['model'] ?? null,
            $data['manufacturer'] ?? null,
            $data['year'] ?? null,
            $data['capacity'] ?? null,
            $data['fuel_type'] ?? null,
            $data['registration_date'] ?? null,
            $data['insurance_expiry'] ?? null,
            $data['fitness_expiry'] ?? null,
            $data['status'] ?? 'active'
        ]);
    }
    
    /**
     * Update vehicle
     */
    public static function update($id, $data)
    {
        $sql = "UPDATE vehicles SET vehicle_number = ?, vehicle_type = ?, model = ?, 
                manufacturer = ?, year = ?, capacity = ?, fuel_type = ?, 
                registration_date = ?, insurance_expiry = ?, fitness_expiry = ?, 
                status = ?, updated_at = NOW() WHERE id = ?";
        
        return db()->execute($sql, [
            $data['vehicle_number'],
            $data['vehicle_type'] ?? null,
            $data['model'] ?? null,
            $data['manufacturer'] ?? null,
            $data['year'] ?? null,
            $data['capacity'] ?? null,
            $data['fuel_type'] ?? null,
            $data['registration_date'] ?? null,
            $data['insurance_expiry'] ?? null,
            $data['fitness_expiry'] ?? null,
            $data['status'] ?? 'active',
            $id
        ]);
    }
    
    /**
     * Delete vehicle
     */
    public static function delete($id)
    {
        return db()->execute("DELETE FROM vehicles WHERE id = ?", [$id]);
    }
    
    /**
     * Get vehicles expiring soon (insurance or fitness)
     */
    public static function getExpiringSoon($days = 30)
    {
        $sql = "SELECT *, 
                CASE 
                    WHEN insurance_expiry <= DATE_ADD(CURDATE(), INTERVAL ? DAY) THEN 'insurance'
                    WHEN fitness_expiry <= DATE_ADD(CURDATE(), INTERVAL ? DAY) THEN 'fitness'
                    ELSE NULL
                END as expiry_type
                FROM vehicles 
                WHERE status = 'active' 
                AND (insurance_expiry <= DATE_ADD(CURDATE(), INTERVAL ? DAY) 
                     OR fitness_expiry <= DATE_ADD(CURDATE(), INTERVAL ? DAY))
                ORDER BY 
                    LEAST(COALESCE(insurance_expiry, '9999-12-31'), 
                          COALESCE(fitness_expiry, '9999-12-31')) ASC";
        
        return db()->fetchAll($sql, [$days, $days, $days, $days]);
    }
    
    /**
     * Get available vehicles (not assigned to any route)
     */
    public static function getAvailable()
    {
        $sql = "SELECT v.* FROM vehicles v
                LEFT JOIN routes r ON v.id = r.vehicle_id AND r.status = 'active'
                WHERE v.status = 'active' AND r.id IS NULL
                ORDER BY v.vehicle_number";
        
        return db()->fetchAll($sql);
    }
    
    /**
     * Get vehicle statistics
     */
    public static function getStatistics()
    {
        return [
            'total_vehicles' => db()->fetchOne("SELECT COUNT(*) as count FROM vehicles WHERE status = 'active'")['count'],
            'total_capacity' => db()->fetchOne("SELECT SUM(capacity) as total FROM vehicles WHERE status = 'active'")['total'] ?? 0,
            'assigned_vehicles' => db()->fetchOne("SELECT COUNT(DISTINCT vehicle_id) as count FROM routes WHERE status = 'active' AND vehicle_id IS NOT NULL")['count'],
            'expiring_soon' => count(self::getExpiringSoon(30))
        ];
    }
    
    /**
     * Get vehicle types
     */
    public static function getTypes()
    {
        return db()->fetchAll("SELECT DISTINCT vehicle_type FROM vehicles WHERE vehicle_type IS NOT NULL ORDER BY vehicle_type");
    }
}
