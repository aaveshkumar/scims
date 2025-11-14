-- Migration: Create roles table
-- Description: Stores user roles (admin, teacher, student, parent, accountant, hr)

CREATE TABLE IF NOT EXISTS roles (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    display_name VARCHAR(100) NOT NULL,
    description TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    INDEX idx_name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert default roles
INSERT INTO roles (name, display_name, description) VALUES
('admin', 'Administrator', 'Full system access and management'),
('teacher', 'Teacher', 'Manage classes, attendance, exams and marks'),
('student', 'Student', 'Access learning materials and view results'),
('parent', 'Parent', 'Monitor student progress and attendance'),
('accountant', 'Accountant', 'Manage fees and financial records'),
('hr', 'HR Manager', 'Manage staff and admissions');
