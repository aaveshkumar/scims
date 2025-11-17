-- Leave Management Tables

-- Leave Types table
CREATE TABLE IF NOT EXISTS leave_types (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    code VARCHAR(20) UNIQUE NOT NULL,
    days_allowed INT DEFAULT 0,
    applicable_to VARCHAR(50),
    requires_approval BOOLEAN DEFAULT TRUE,
    description TEXT,
    status VARCHAR(20) DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_code (code),
    INDEX idx_status (status)
);

-- Leave Applications table
CREATE TABLE IF NOT EXISTS leave_applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    application_number VARCHAR(50) UNIQUE NOT NULL,
    user_id INT NOT NULL,
    leave_type_id INT NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    total_days INT NOT NULL,
    reason TEXT NOT NULL,
    status VARCHAR(20) DEFAULT 'pending',
    applied_date DATE NOT NULL,
    reviewed_by INT,
    reviewed_date DATE,
    remarks TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (leave_type_id) REFERENCES leave_types(id) ON DELETE CASCADE,
    FOREIGN KEY (reviewed_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_user (user_id),
    INDEX idx_leave_type (leave_type_id),
    INDEX idx_status (status),
    INDEX idx_start_date (start_date)
);

-- Leave Balances table
CREATE TABLE IF NOT EXISTS leave_balances (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    leave_type_id INT NOT NULL,
    year INT NOT NULL,
    total_days INT DEFAULT 0,
    used_days INT DEFAULT 0,
    remaining_days INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (leave_type_id) REFERENCES leave_types(id) ON DELETE CASCADE,
    UNIQUE (user_id, leave_type_id, year),
    INDEX idx_user (user_id),
    INDEX idx_year (year)
);
