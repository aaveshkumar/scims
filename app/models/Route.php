<?php

class Route
{
    protected static $table = 'routes';
    
    /**
     * Get all routes with vehicle and driver details
     */
    public static function getAll($filters = [])
    {
        $sql = "SELECT r.*, v.vehicle_number, v.model as vehicle_model,
                u.name as driver_name
                FROM routes r
                LEFT JOIN vehicles v ON r.vehicle_id = v.id
                LEFT JOIN users u ON r.driver_id = u.id
                WHERE 1=1";
        $params = [];
        
        if (!empty($filters['search'])) {
            $sql .= " AND (r.route_name LIKE ? OR r.route_number LIKE ?)";
            $search = "%{$filters['search']}%";
            $params[] = $search;
            $params[] = $search;
        }
        
        if (!empty($filters['status'])) {
            $sql .= " AND r.status = ?";
            $params[] = $filters['status'];
        }
        
        $sql .= " ORDER BY r.route_number ASC";
        
        return db()->fetchAll($sql, $params);
    }
    
    /**
     * Get route by ID with full details
     */
    public static function find($id)
    {
        $sql = "SELECT r.*, v.vehicle_number, v.model as vehicle_model, v.capacity,
                u.name as driver_name, u.email as driver_email
                FROM routes r
                LEFT JOIN vehicles v ON r.vehicle_id = v.id
                LEFT JOIN users u ON r.driver_id = u.id
                WHERE r.id = ?";
        
        return db()->fetchOne($sql, [$id]);
    }
    
    /**
     * Create new route
     */
    public static function create($data)
    {
        $sql = "INSERT INTO routes (route_name, route_number, start_point, end_point, 
                distance, fare, vehicle_id, driver_id, status, created_at, updated_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
        
        return db()->execute($sql, [
            $data['route_name'],
            $data['route_number'] ?? null,
            $data['start_point'] ?? null,
            $data['end_point'] ?? null,
            $data['distance'] ?? null,
            $data['fare'] ?? null,
            $data['vehicle_id'] ?? null,
            $data['driver_id'] ?? null,
            $data['status'] ?? 'active'
        ]);
    }
    
    /**
     * Update route
     */
    public static function update($id, $data)
    {
        $sql = "UPDATE routes SET route_name = ?, route_number = ?, start_point = ?, 
                end_point = ?, distance = ?, fare = ?, vehicle_id = ?, driver_id = ?, 
                status = ?, updated_at = NOW() WHERE id = ?";
        
        return db()->execute($sql, [
            $data['route_name'],
            $data['route_number'] ?? null,
            $data['start_point'] ?? null,
            $data['end_point'] ?? null,
            $data['distance'] ?? null,
            $data['fare'] ?? null,
            $data['vehicle_id'] ?? null,
            $data['driver_id'] ?? null,
            $data['status'] ?? 'active',
            $id
        ]);
    }
    
    /**
     * Delete route
     */
    public static function delete($id)
    {
        return db()->execute("DELETE FROM routes WHERE id = ?", [$id]);
    }
    
    /**
     * Get route stops
     */
    public static function getStops($routeId)
    {
        return db()->fetchAll(
            "SELECT * FROM route_stops WHERE route_id = ? ORDER BY stop_order ASC",
            [$routeId]
        );
    }
    
    /**
     * Add stop to route
     */
    public static function addStop($routeId, $data)
    {
        // Get next stop order
        $lastStop = db()->fetchOne(
            "SELECT MAX(stop_order) as max_order FROM route_stops WHERE route_id = ?",
            [$routeId]
        );
        $nextOrder = ($lastStop['max_order'] ?? 0) + 1;
        
        $sql = "INSERT INTO route_stops (route_id, stop_name, stop_order, 
                pickup_time, drop_time, created_at, updated_at) 
                VALUES (?, ?, ?, ?, ?, NOW(), NOW())";
        
        return db()->execute($sql, [
            $routeId,
            $data['stop_name'],
            $data['stop_order'] ?? $nextOrder,
            $data['pickup_time'] ?? null,
            $data['drop_time'] ?? null
        ]);
    }
    
    /**
     * Get students assigned to route
     */
    public static function getAssignedStudents($routeId)
    {
        $sql = "SELECT ta.*, s.first_name, s.last_name, s.roll_number, s.class,
                rs.stop_name
                FROM transport_assignments ta
                JOIN students s ON ta.student_id = s.id
                LEFT JOIN route_stops rs ON ta.stop_id = rs.id
                WHERE ta.route_id = ? AND ta.status = 'active'
                ORDER BY s.first_name, s.last_name";
        
        return db()->fetchAll($sql, [$routeId]);
    }
    
    /**
     * Get route utilization (capacity vs assignments)
     */
    public static function getUtilization($routeId)
    {
        $route = self::find($routeId);
        if (!$route) return null;
        
        $assigned = db()->fetchOne(
            "SELECT COUNT(*) as count FROM transport_assignments 
             WHERE route_id = ? AND status = 'active'",
            [$routeId]
        )['count'];
        
        $capacity = $route['capacity'] ?? 0;
        
        return [
            'assigned' => $assigned,
            'capacity' => $capacity,
            'available' => max(0, $capacity - $assigned),
            'percentage' => $capacity > 0 ? round(($assigned / $capacity) * 100, 2) : 0
        ];
    }
    
    /**
     * Get route statistics
     */
    public static function getStatistics()
    {
        return [
            'total_routes' => db()->fetchOne("SELECT COUNT(*) as count FROM routes WHERE status = 'active'")['count'],
            'total_students' => db()->fetchOne("SELECT COUNT(*) as count FROM transport_assignments WHERE status = 'active'")['count'],
            'total_stops' => db()->fetchOne("SELECT COUNT(*) as count FROM route_stops")['count'],
            'total_distance' => db()->fetchOne("SELECT SUM(distance) as total FROM routes WHERE status = 'active'")['total'] ?? 0
        ];
    }
}
