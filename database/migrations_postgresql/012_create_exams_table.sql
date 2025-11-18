-- Migration: Create exams table
-- Description: Stores exam information

CREATE TABLE IF NOT EXISTS exams (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    code VARCHAR(20) NOT NULL UNIQUE,
    class_id INTEGER NULL,
    exam_type VARCHAR(50) NOT NULL CHECK (exam_type IN ('midterm', 'final', 'quiz', 'assignment', 'practical')),
    academic_year VARCHAR(20) NOT NULL,
    semester VARCHAR(20) NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    total_marks INT NOT NULL DEFAULT 100,
    passing_marks INT NOT NULL DEFAULT 40,
    status VARCHAR(50) DEFAULT 'scheduled' CHECK (status IN ('scheduled', 'ongoing', 'completed', 'cancelled')),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE SET NULL,
    
    INDEX idx_code (code),
    INDEX idx_class_id (class_id),
    INDEX idx_exam_type (exam_type),
    INDEX idx_academic_year (academic_year),
    INDEX idx_status (status),
    INDEX idx_start_date (start_date)
)   ;


-- Trigger for updated_at
CREATE OR REPLACE FUNCTION update_exams_updated_at()
RETURNS TRIGGER AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS trigger_update_exams_updated_at ON exams;
CREATE TRIGGER trigger_update_exams_updated_at
    BEFORE UPDATE ON exams
    FOR EACH ROW
    EXECUTE FUNCTION update_exams_updated_at();
