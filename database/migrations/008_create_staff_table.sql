-- Migration: Create staff table
-- Description: Extended staff information

CREATE TABLE IF NOT EXISTS staff (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    employee_id VARCHAR(50) NOT NULL UNIQUE,
    designation VARCHAR(100) NOT NULL,
    department VARCHAR(100) NULL,
    qualification VARCHAR(200) NULL,
    experience_years INT NULL,
    joining_date DATE NOT NULL,
    salary DECIMAL(10, 2) NULL,
    bank_name VARCHAR(100) NULL,
    account_number VARCHAR(50) NULL,
    emergency_contact VARCHAR(20) NULL,
    documents JSON NULL,
    status ENUM('active', 'inactive', 'on_leave', 'resigned') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    
    INDEX idx_user_id (user_id),
    INDEX idx_employee_id (employee_id),
    INDEX idx_designation (designation),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
