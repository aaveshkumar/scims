-- Migration: Create admissions table
-- Description: Stores admission applications

CREATE TABLE IF NOT EXISTS admissions (
    id SERIAL PRIMARY KEY,
    application_number VARCHAR(50) NOT NULL UNIQUE,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    date_of_birth DATE NOT NULL,
    gender VARCHAR(50) NOT NULL CHECK (gender IN ('male', 'female', 'other')),
    address TEXT NOT NULL,
    course_id INTEGER NULL,
    class_id INTEGER NULL,
    guardian_name VARCHAR(100) NOT NULL,
    guardian_phone VARCHAR(20) NOT NULL,
    guardian_email VARCHAR(100) NULL,
    previous_school VARCHAR(200) NULL,
    documents JSON NULL,
    status VARCHAR(50) DEFAULT 'pending' CHECK (status IN ('pending', 'approved', 'rejected', 'completed')),
    remarks TEXT NULL,
    reviewed_by INTEGER NULL,
    reviewed_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE SET NULL,
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE SET NULL,
    FOREIGN KEY (reviewed_by) REFERENCES users(id) ON DELETE SET NULL,
    
    INDEX idx_application_number (application_number),
    INDEX idx_email (email),
    INDEX idx_status (status),
    INDEX idx_course_id (course_id),
    INDEX idx_class_id (class_id)
)   ;


-- Trigger for updated_at
CREATE OR REPLACE FUNCTION update_admissions_updated_at()
RETURNS TRIGGER AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS trigger_update_admissions_updated_at ON admissions;
CREATE TRIGGER trigger_update_admissions_updated_at
    BEFORE UPDATE ON admissions
    FOR EACH ROW
    EXECUTE FUNCTION update_admissions_updated_at();
