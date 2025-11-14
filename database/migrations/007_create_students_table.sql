-- Migration: Create students table
-- Description: Extended student information

CREATE TABLE IF NOT EXISTS students (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    admission_number VARCHAR(50) NOT NULL UNIQUE,
    class_id INT UNSIGNED NULL,
    roll_number VARCHAR(20) NULL,
    admission_date DATE NOT NULL,
    guardian_name VARCHAR(100) NULL,
    guardian_phone VARCHAR(20) NULL,
    guardian_email VARCHAR(100) NULL,
    guardian_relation VARCHAR(50) NULL,
    previous_school VARCHAR(200) NULL,
    blood_group VARCHAR(5) NULL,
    medical_conditions TEXT NULL,
    documents JSON NULL,
    status ENUM('active', 'inactive', 'graduated', 'expelled') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE SET NULL,
    
    INDEX idx_user_id (user_id),
    INDEX idx_admission_number (admission_number),
    INDEX idx_class_id (class_id),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
