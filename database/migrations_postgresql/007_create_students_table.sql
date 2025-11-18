-- Migration: Create students table
-- Description: Extended student information

CREATE TABLE IF NOT EXISTS students (
    id SERIAL PRIMARY KEY,
    user_id INTEGER NOT NULL,
    admission_number VARCHAR(50) NOT NULL UNIQUE,
    class_id INTEGER NULL,
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
    status VARCHAR(50) DEFAULT 'active' CHECK (status IN ('active', 'inactive', 'graduated', 'expelled')),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE SET NULL,
    
    INDEX idx_user_id (user_id),
    INDEX idx_admission_number (admission_number),
    INDEX idx_class_id (class_id),
    INDEX idx_status (status)
)   ;


-- Trigger for updated_at
CREATE OR REPLACE FUNCTION update_students_updated_at()
RETURNS TRIGGER AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS trigger_update_students_updated_at ON students;
CREATE TRIGGER trigger_update_students_updated_at
    BEFORE UPDATE ON students
    FOR EACH ROW
    EXECUTE FUNCTION update_students_updated_at();
