-- Migration: Create fees_structures table
-- Description: Stores fee structure definitions

CREATE TABLE IF NOT EXISTS fees_structures (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    class_id INT UNSIGNED NULL,
    course_id INT UNSIGNED NULL,
    academic_year VARCHAR(20) NOT NULL,
    semester VARCHAR(20) NULL,
    fee_type ENUM('tuition', 'exam', 'library', 'lab', 'transport', 'hostel', 'other') NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    due_date DATE NULL,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE SET NULL,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE SET NULL,
    
    INDEX idx_class_id (class_id),
    INDEX idx_course_id (course_id),
    INDEX idx_fee_type (fee_type),
    INDEX idx_academic_year (academic_year),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
