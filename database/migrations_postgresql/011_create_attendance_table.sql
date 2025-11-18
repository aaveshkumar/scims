-- Migration: Create attendance table
-- Description: Stores student attendance records

CREATE TABLE IF NOT EXISTS attendance (
    id SERIAL PRIMARY KEY,
    student_id INTEGER NOT NULL,
    class_id INTEGER NOT NULL,
    subject_id INTEGER NULL,
    date DATE NOT NULL,
    period INT NULL,
    status VARCHAR(50) NOT NULL CHECK (status IN ('present', 'absent', 'late', 'excused')),
    remarks TEXT NULL,
    marked_by INTEGER NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE,
    FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE SET NULL,
    FOREIGN KEY (marked_by) REFERENCES users(id) ON DELETE SET NULL,
    
    CONSTRAINT unique_attendance UNIQUE (student_id, class_id, subject_id, date, period),
    INDEX idx_student_id (student_id),
    INDEX idx_class_id (class_id),
    INDEX idx_date (date),
    INDEX idx_status (status)
)   ;


-- Trigger for updated_at
CREATE OR REPLACE FUNCTION update_attendance_updated_at()
RETURNS TRIGGER AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS trigger_update_attendance_updated_at ON attendance;
CREATE TRIGGER trigger_update_attendance_updated_at
    BEFORE UPDATE ON attendance
    FOR EACH ROW
    EXECUTE FUNCTION update_attendance_updated_at();
