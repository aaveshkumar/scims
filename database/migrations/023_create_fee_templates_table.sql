-- Fee Structure Management Tables

-- Fee Templates table
CREATE TABLE IF NOT EXISTS fee_templates (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    class_id INT UNSIGNED,
    academic_year VARCHAR(20) NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    fine_per_day DECIMAL(10,2) DEFAULT 0,
    due_date DATE,
    status VARCHAR(20) DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE SET NULL,
    INDEX idx_class (class_id),
    INDEX idx_academic_year (academic_year),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
