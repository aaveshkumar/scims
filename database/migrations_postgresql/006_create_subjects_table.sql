-- Migration: Create subjects table
-- Description: Stores subject information

CREATE TABLE IF NOT EXISTS subjects (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    code VARCHAR(20) NOT NULL UNIQUE,
    course_id INTEGER NULL,
    teacher_id INTEGER NULL,
    class_id INTEGER NULL,
    credits INT NULL,
    type VARCHAR(50) DEFAULT 'theory' CHECK (type IN ('theory', 'practical', 'both')),
    description TEXT NULL,
    status VARCHAR(50) DEFAULT 'active' CHECK (status IN ('active', 'inactive')),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE SET NULL,
    FOREIGN KEY (teacher_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE SET NULL,
    
    INDEX idx_code (code),
    INDEX idx_course_id (course_id),
    INDEX idx_teacher_id (teacher_id),
    INDEX idx_class_id (class_id),
    INDEX idx_status (status)
)   ;


-- Trigger for updated_at
CREATE OR REPLACE FUNCTION update_subjects_updated_at()
RETURNS TRIGGER AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS trigger_update_subjects_updated_at ON subjects;
CREATE TRIGGER trigger_update_subjects_updated_at
    BEFORE UPDATE ON subjects
    FOR EACH ROW
    EXECUTE FUNCTION update_subjects_updated_at();
