-- Migration: Create classes table
-- Description: Stores class information (e.g., Class 10-A, BSc CS Year 1)

CREATE TABLE IF NOT EXISTS classes (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    code VARCHAR(20) NOT NULL UNIQUE,
    course_id INTEGER NULL,
    section VARCHAR(10) NULL,
    academic_year VARCHAR(20) NOT NULL,
    capacity INT NULL,
    room_number VARCHAR(20) NULL,
    status VARCHAR(50) DEFAULT 'active' CHECK (status IN ('active', 'inactive')),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE SET NULL,
    
    INDEX idx_code (code),
    INDEX idx_course_id (course_id),
    INDEX idx_academic_year (academic_year),
    INDEX idx_status (status)
)   ;


-- Trigger for updated_at
CREATE OR REPLACE FUNCTION update_classes_updated_at()
RETURNS TRIGGER AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS trigger_update_classes_updated_at ON classes;
CREATE TRIGGER trigger_update_classes_updated_at
    BEFORE UPDATE ON classes
    FOR EACH ROW
    EXECUTE FUNCTION update_classes_updated_at();
