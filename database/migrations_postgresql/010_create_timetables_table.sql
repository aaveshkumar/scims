-- Migration: Create timetables table
-- Description: Stores class timetable entries

CREATE TABLE IF NOT EXISTS timetables (
    id SERIAL PRIMARY KEY,
    class_id INTEGER NOT NULL,
    subject_id INTEGER NOT NULL,
    teacher_id INTEGER NULL,
    day_of_week VARCHAR(50) NOT NULL CHECK (day_of_week IN ('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday')),
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    room_number VARCHAR(20) NULL,
    academic_year VARCHAR(20) NOT NULL,
    semester VARCHAR(20) NULL,
    status VARCHAR(50) DEFAULT 'active' CHECK (status IN ('active', 'inactive')),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE,
    FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE,
    FOREIGN KEY (teacher_id) REFERENCES users(id) ON DELETE SET NULL,
    
    INDEX idx_class_id (class_id),
    INDEX idx_subject_id (subject_id),
    INDEX idx_teacher_id (teacher_id),
    INDEX idx_day_of_week (day_of_week),
    INDEX idx_academic_year (academic_year)
)   ;


-- Trigger for updated_at
CREATE OR REPLACE FUNCTION update_timetables_updated_at()
RETURNS TRIGGER AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS trigger_update_timetables_updated_at ON timetables;
CREATE TRIGGER trigger_update_timetables_updated_at
    BEFORE UPDATE ON timetables
    FOR EACH ROW
    EXECUTE FUNCTION update_timetables_updated_at();
