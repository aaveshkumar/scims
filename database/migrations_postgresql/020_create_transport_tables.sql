-- Transport Management Tables

-- Vehicles table
CREATE TABLE IF NOT EXISTS vehicles (
    id SERIAL PRIMARY KEY,
    vehicle_number VARCHAR(50) UNIQUE NOT NULL,
    vehicle_type VARCHAR(50),
    model VARCHAR(100),
    manufacturer VARCHAR(100),
    year INT,
    capacity INT,
    fuel_type VARCHAR(50),
    registration_date DATE,
    insurance_expiry DATE,
    fitness_expiry DATE,
    status VARCHAR(20) DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_vehicle_number (vehicle_number),
    INDEX idx_status (status)
);

-- Routes table
CREATE TABLE IF NOT EXISTS routes (
    id SERIAL PRIMARY KEY,
    route_name VARCHAR(100) NOT NULL,
    route_number VARCHAR(50) UNIQUE,
    start_point VARCHAR(255),
    end_point VARCHAR(255),
    distance DECIMAL(10,2),
    fare DECIMAL(10,2),
    vehicle_id INT,
    driver_id INT,
    status VARCHAR(20) DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (vehicle_id) REFERENCES vehicles(id) ON DELETE SET NULL,
    FOREIGN KEY (driver_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_route_number (route_number),
    INDEX idx_status (status)
);

-- Route Stops table
CREATE TABLE IF NOT EXISTS route_stops (
    id SERIAL PRIMARY KEY,
    route_id INT NOT NULL,
    stop_name VARCHAR(255) NOT NULL,
    stop_order INT NOT NULL,
    pickup_time TIME,
    drop_time TIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (route_id) REFERENCES routes(id) ON DELETE CASCADE,
    INDEX idx_route (route_id)
);

-- Transport Assignments table
CREATE TABLE IF NOT EXISTS transport_assignments (
    id SERIAL PRIMARY KEY,
    student_id INT NOT NULL,
    route_id INT NOT NULL,
    stop_id INT,
    start_date DATE NOT NULL,
    end_date DATE,
    status VARCHAR(20) DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (route_id) REFERENCES routes(id) ON DELETE CASCADE,
    FOREIGN KEY (stop_id) REFERENCES route_stops(id) ON DELETE SET NULL,
    INDEX idx_student (student_id),
    INDEX idx_route (route_id),
    INDEX idx_status (status)
);

-- Vehicle Maintenance table
CREATE TABLE IF NOT EXISTS vehicle_maintenance (
    id SERIAL PRIMARY KEY,
    vehicle_id INT NOT NULL,
    maintenance_type VARCHAR(100),
    description TEXT,
    maintenance_date DATE NOT NULL,
    cost DECIMAL(10,2),
    vendor VARCHAR(255),
    next_maintenance_date DATE,
    status VARCHAR(20) DEFAULT 'completed',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (vehicle_id) REFERENCES vehicles(id) ON DELETE CASCADE,
    INDEX idx_vehicle (vehicle_id),
    INDEX idx_maintenance_date (maintenance_date)
);


-- Trigger for updated_at
CREATE OR REPLACE FUNCTION update_vehicles_updated_at()
RETURNS TRIGGER AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS trigger_update_vehicles_updated_at ON vehicles;
CREATE TRIGGER trigger_update_vehicles_updated_at
    BEFORE UPDATE ON vehicles
    FOR EACH ROW
    EXECUTE FUNCTION update_vehicles_updated_at();
