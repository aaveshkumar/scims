<?php

class VehicleMaintenance extends Model
{
    protected $table = 'vehicle_maintenance';
    
    /**
     * Get all maintenance records with vehicle details
     */
    public static function getAll($filters = [])
    {
        $sql = "SELECT vm.*, v.vehicle_number, v.model, v.manufacturer
                FROM vehicle_maintenance vm
                JOIN vehicles v ON vm.vehicle_id = v.id
                WHERE 1=1";
        $params = [];
        
        if (!empty($filters['vehicle_id'])) {
            $sql .= " AND vm.vehicle_id = ?";
            $params[] = $filters['vehicle_id'];
        }
        
        if (!empty($filters['status'])) {
            $sql .= " AND vm.status = ?";
            $params[] = $filters['status'];
        }
        
        if (!empty($filters['maintenance_type'])) {
            $sql .= " AND vm.maintenance_type = ?";
            $params[] = $filters['maintenance_type'];
        }
        
        $sql .= " ORDER BY vm.maintenance_date DESC";
        
        return db()->fetchAll($sql, $params);
    }
    
    /**
     * Get maintenance record by ID
     */
    public static function find($id)
    {
        $sql = "SELECT vm.*, v.vehicle_number, v.model, v.manufacturer
                FROM vehicle_maintenance vm
                JOIN vehicles v ON vm.vehicle_id = v.id
                WHERE vm.id = ?";
        
        return db()->fetchOne($sql, [$id]);
    }
    
    /**
     * Create new maintenance record
     */
    public static function create($data)
    {
        $sql = "INSERT INTO vehicle_maintenance (vehicle_id, maintenance_type, 
                description, maintenance_date, cost, vendor, next_maintenance_date, 
                status, created_at, updated_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
        
        return db()->execute($sql, [
            $data['vehicle_id'],
            $data['maintenance_type'] ?? null,
            $data['description'] ?? null,
            $data['maintenance_date'],
            $data['cost'] ?? null,
            $data['vendor'] ?? null,
            $data['next_maintenance_date'] ?? null,
            $data['status'] ?? 'completed'
        ]);
    }
    
    /**
     * Update maintenance record
     */
    public static function update($id, $data)
    {
        $sql = "UPDATE vehicle_maintenance SET maintenance_type = ?, description = ?, 
                maintenance_date = ?, cost = ?, vendor = ?, next_maintenance_date = ?, 
                status = ?, updated_at = NOW() WHERE id = ?";
        
        return db()->execute($sql, [
            $data['maintenance_type'] ?? null,
            $data['description'] ?? null,
            $data['maintenance_date'],
            $data['cost'] ?? null,
            $data['vendor'] ?? null,
            $data['next_maintenance_date'] ?? null,
            $data['status'] ?? 'completed',
            $id
        ]);
    }
    
    /**
     * Delete maintenance record
     */
    public static function delete($id)
    {
        return db()->execute("DELETE FROM vehicle_maintenance WHERE id = ?", [$id]);
    }
    
    /**
     * Get upcoming maintenance (next 30 days)
     */
    public static function getUpcoming($days = 30)
    {
        $sql = "SELECT vm.*, v.vehicle_number, v.model
                FROM vehicle_maintenance vm
                JOIN vehicles v ON vm.vehicle_id = v.id
                WHERE vm.next_maintenance_date IS NOT NULL
                AND vm.next_maintenance_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL ? DAY)
                ORDER BY vm.next_maintenance_date ASC";
        
        return db()->fetchAll($sql, [$days]);
    }
    
    /**
     * Get maintenance history for a vehicle
     */
    public static function getVehicleHistory($vehicleId)
    {
        return db()->fetchAll(
            "SELECT * FROM vehicle_maintenance 
             WHERE vehicle_id = ? 
             ORDER BY maintenance_date DESC",
            [$vehicleId]
        );
    }
    
    /**
     * Get total maintenance cost for a vehicle
     */
    public static function getTotalCost($vehicleId, $startDate = null, $endDate = null)
    {
        $sql = "SELECT SUM(cost) as total FROM vehicle_maintenance WHERE vehicle_id = ?";
        $params = [$vehicleId];
        
        if ($startDate) {
            $sql .= " AND maintenance_date >= ?";
            $params[] = $startDate;
        }
        
        if ($endDate) {
            $sql .= " AND maintenance_date <= ?";
            $params[] = $endDate;
        }
        
        $result = db()->fetchOne($sql, $params);
        return $result['total'] ?? 0;
    }
    
    /**
     * Get maintenance statistics
     */
    public static function getStatistics()
    {
        return [
            'total_maintenance' => db()->fetchOne("SELECT COUNT(*) as count FROM vehicle_maintenance")['count'],
            'total_cost' => db()->fetchOne("SELECT SUM(cost) as total FROM vehicle_maintenance")['total'] ?? 0,
            'upcoming_maintenance' => count(self::getUpcoming(30)),
            'this_month_cost' => db()->fetchOne("SELECT SUM(cost) as total FROM vehicle_maintenance WHERE MONTH(maintenance_date) = MONTH(CURDATE()) AND YEAR(maintenance_date) = YEAR(CURDATE())")['total'] ?? 0
        ];
    }
    
    /**
     * Get maintenance types
     */
    public static function getTypes()
    {
        return db()->fetchAll("SELECT DISTINCT maintenance_type FROM vehicle_maintenance WHERE maintenance_type IS NOT NULL ORDER BY maintenance_type");
    }
}
