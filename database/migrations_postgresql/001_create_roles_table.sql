-- Migration: Create roles table
-- Description: Stores user roles (admin, teacher, student, parent, accountant, hr)

CREATE TABLE IF NOT EXISTS roles (
    id SERIAL PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    display_name VARCHAR(100) NOT NULL,
    description TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_name (name)
)   ;

-- Insert default roles
INSERT INTO roles (name, display_name, description) VALUES
('admin', 'Administrator', 'Full system access and management'),
('teacher', 'Teacher', 'Manage classes, attendance, exams and marks'),
('student', 'Student', 'Access learning materials and view results'),
('parent', 'Parent', 'Monitor student progress and attendance'),
('accountant', 'Accountant', 'Manage fees and financial records'),
('hr', 'HR Manager', 'Manage staff and admissions');


-- Trigger for updated_at
CREATE OR REPLACE FUNCTION update_roles_updated_at()
RETURNS TRIGGER AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS trigger_update_roles_updated_at ON roles;
CREATE TRIGGER trigger_update_roles_updated_at
    BEFORE UPDATE ON roles
    FOR EACH ROW
    EXECUTE FUNCTION update_roles_updated_at();
