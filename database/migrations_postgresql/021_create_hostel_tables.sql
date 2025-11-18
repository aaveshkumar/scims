-- Hostel Management Tables

-- Hostels table
CREATE TABLE IF NOT EXISTS hostels (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    hostel_type VARCHAR(50),
    address TEXT,
    warden_id INT,
    total_rooms INT DEFAULT 0,
    occupied_rooms INT DEFAULT 0,
    status VARCHAR(20) DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (warden_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_status (status)
);

-- Hostel Rooms table
CREATE TABLE IF NOT EXISTS hostel_rooms (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hostel_id INT NOT NULL,
    room_number VARCHAR(50) NOT NULL,
    room_type VARCHAR(50),
    capacity INT DEFAULT 1,
    occupied_beds INT DEFAULT 0,
    floor_number INT,
    room_fee DECIMAL(10,2),
    amenities TEXT,
    status VARCHAR(20) DEFAULT 'available',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (hostel_id) REFERENCES hostels(id) ON DELETE CASCADE,
    UNIQUE (hostel_id, room_number),
    INDEX idx_hostel (hostel_id),
    INDEX idx_status (status)
);

-- Hostel Residents table
CREATE TABLE IF NOT EXISTS hostel_residents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    hostel_id INT NOT NULL,
    room_id INT NOT NULL,
    admission_date DATE NOT NULL,
    checkout_date DATE,
    guardian_contact VARCHAR(20),
    emergency_contact VARCHAR(20),
    status VARCHAR(20) DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (hostel_id) REFERENCES hostels(id) ON DELETE CASCADE,
    FOREIGN KEY (room_id) REFERENCES hostel_rooms(id) ON DELETE CASCADE,
    INDEX idx_student (student_id),
    INDEX idx_hostel (hostel_id),
    INDEX idx_room (room_id),
    INDEX idx_status (status)
);

-- Hostel Visitors table
CREATE TABLE IF NOT EXISTS hostel_visitors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    resident_id INT NOT NULL,
    visitor_name VARCHAR(255) NOT NULL,
    visitor_phone VARCHAR(20),
    visitor_id_proof VARCHAR(100),
    visit_date DATE NOT NULL,
    entry_time TIME NOT NULL,
    exit_time TIME,
    purpose TEXT,
    approved_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (resident_id) REFERENCES hostel_residents(id) ON DELETE CASCADE,
    FOREIGN KEY (approved_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_resident (resident_id),
    INDEX idx_visit_date (visit_date)
);

-- Hostel Complaints table
CREATE TABLE IF NOT EXISTS hostel_complaints (
    id INT AUTO_INCREMENT PRIMARY KEY,
    resident_id INT NOT NULL,
    hostel_id INT NOT NULL,
    complaint_type VARCHAR(100),
    description TEXT NOT NULL,
    priority VARCHAR(20) DEFAULT 'medium',
    status VARCHAR(20) DEFAULT 'pending',
    assigned_to INT,
    resolved_date DATE,
    remarks TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (resident_id) REFERENCES hostel_residents(id) ON DELETE CASCADE,
    FOREIGN KEY (hostel_id) REFERENCES hostels(id) ON DELETE CASCADE,
    FOREIGN KEY (assigned_to) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_resident (resident_id),
    INDEX idx_hostel (hostel_id),
    INDEX idx_status (status),
    INDEX idx_priority (priority)
);

-- Mess Menu table
CREATE TABLE IF NOT EXISTS mess_menu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hostel_id INT NOT NULL,
    day_of_week VARCHAR(20) NOT NULL,
    meal_type VARCHAR(50) NOT NULL,
    menu_items TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (hostel_id) REFERENCES hostels(id) ON DELETE CASCADE,
    INDEX idx_hostel (hostel_id),
    INDEX idx_day (day_of_week)
);


-- Trigger for updated_at
CREATE OR REPLACE FUNCTION update_hostels_updated_at()
RETURNS TRIGGER AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS trigger_update_hostels_updated_at ON hostels;
CREATE TRIGGER trigger_update_hostels_updated_at
    BEFORE UPDATE ON hostels
    FOR EACH ROW
    EXECUTE FUNCTION update_hostels_updated_at();
