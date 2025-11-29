-- Migration: Create syllabuses table

CREATE TABLE IF NOT EXISTS syllabuses (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    overview TEXT NULL,
    learning_outcomes TEXT NULL,
    topics_covered TEXT NULL,
    assessment_methods TEXT NULL,
    grading_scale VARCHAR(255) NULL,
    recommended_resources TEXT NULL,
    prerequisites VARCHAR(255) NULL,
    duration VARCHAR(100) NULL,
    academic_year VARCHAR(50) NULL,
    subject_id INT UNSIGNED NULL,
    class_id INT UNSIGNED NULL,
    status ENUM('active', 'inactive', 'draft') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE SET NULL,
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE SET NULL,
    
    INDEX idx_subject_id (subject_id),
    INDEX idx_class_id (class_id),
    INDEX idx_status (status),
    INDEX idx_academic_year (academic_year)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
