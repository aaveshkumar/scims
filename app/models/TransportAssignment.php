<?php

class TransportAssignment extends Model
{
    protected $table = 'transport_assignments';
    
    /**
     * Get all assignments with student and route details
     */
    public static function getAll($filters = [])
    {
        $sql = "SELECT ta.*, s.first_name, s.last_name, s.roll_number, s.class,
                r.route_name, r.route_number, rs.stop_name
                FROM transport_assignments ta
                JOIN students s ON ta.student_id = s.id
                JOIN routes r ON ta.route_id = r.id
                LEFT JOIN route_stops rs ON ta.stop_id = rs.id
                WHERE 1=1";
        $params = [];
        
        if (!empty($filters['status'])) {
            $sql .= " AND ta.status = ?";
            $params[] = $filters['status'];
        }
        
        if (!empty($filters['route_id'])) {
            $sql .= " AND ta.route_id = ?";
            $params[] = $filters['route_id'];
        }
        
        if (!empty($filters['search'])) {
            $sql .= " AND (s.first_name LIKE ? OR s.last_name LIKE ? OR s.roll_number LIKE ?)";
            $search = "%{$filters['search']}%";
            $params[] = $search;
            $params[] = $search;
            $params[] = $search;
        }
        
        $sql .= " ORDER BY r.route_number, s.first_name, s.last_name";
        
        return db()->fetchAll($sql, $params);
    }
    
    /**
     * Get assignment by ID
     */
    public static function find($id)
    {
        $sql = "SELECT ta.*, s.first_name, s.last_name, s.roll_number, s.class,
                r.route_name, r.route_number, rs.stop_name
                FROM transport_assignments ta
                JOIN students s ON ta.student_id = s.id
                JOIN routes r ON ta.route_id = r.id
                LEFT JOIN route_stops rs ON ta.stop_id = rs.id
                WHERE ta.id = ?";
        
        return db()->fetchOne($sql, [$id]);
    }
    
    /**
     * Create new assignment
     */
    public static function create($data)
    {
        $sql = "INSERT INTO transport_assignments (student_id, route_id, stop_id, 
                start_date, end_date, status, created_at, updated_at) 
                VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())";
        
        return db()->execute($sql, [
            $data['student_id'],
            $data['route_id'],
            $data['stop_id'] ?? null,
            $data['start_date'],
            $data['end_date'] ?? null,
            $data['status'] ?? 'active'
        ]);
    }
    
    /**
     * Update assignment
     */
    public static function update($id, $data)
    {
        $sql = "UPDATE transport_assignments SET route_id = ?, stop_id = ?, 
                start_date = ?, end_date = ?, status = ?, updated_at = NOW() 
                WHERE id = ?";
        
        return db()->execute($sql, [
            $data['route_id'],
            $data['stop_id'] ?? null,
            $data['start_date'],
            $data['end_date'] ?? null,
            $data['status'],
            $id
        ]);
    }
    
    /**
     * Delete assignment
     */
    public static function delete($id)
    {
        return db()->execute("DELETE FROM transport_assignments WHERE id = ?", [$id]);
    }
    
    /**
     * Check if student is already assigned to a route
     */
    public static function isStudentAssigned($studentId, $excludeId = null)
    {
        $sql = "SELECT * FROM transport_assignments 
                WHERE student_id = ? AND status = 'active'";
        $params = [$studentId];
        
        if ($excludeId) {
            $sql .= " AND id != ?";
            $params[] = $excludeId;
        }
        
        return db()->fetchOne($sql, $params) !== false;
    }
    
    /**
     * Check if route has capacity for new assignment
     */
    public static function canAssignToRoute($routeId)
    {
        $utilization = Route::getUtilization($routeId);
        return $utilization && $utilization['available'] > 0;
    }
    
    /**
     * Get assignment statistics
     */
    public static function getStatistics()
    {
        return [
            'total_assignments' => db()->fetchOne("SELECT COUNT(*) as count FROM transport_assignments WHERE status = 'active'")['count'],
            'students_without_transport' => db()->fetchOne("SELECT COUNT(*) as count FROM students s LEFT JOIN transport_assignments ta ON s.id = ta.student_id AND ta.status = 'active' WHERE ta.id IS NULL")['count']
        ];
    }
}
