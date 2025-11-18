-- Migration: Create marks table
-- Description: Stores student marks/grades

CREATE TABLE IF NOT EXISTS marks (
    id SERIAL PRIMARY KEY,
    student_id INTEGER NOT NULL,
    exam_id INTEGER NOT NULL,
    subject_id INTEGER NOT NULL,
    marks_obtained DECIMAL(5, 2) NOT NULL,
    total_marks DECIMAL(5, 2) NOT NULL,
    grade VARCHAR(5) NULL,
    remarks TEXT NULL,
    entered_by INTEGER NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE,
    FOREIGN KEY (exam_id) REFERENCES exams(id) ON DELETE CASCADE,
    FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE,
    FOREIGN KEY (entered_by) REFERENCES users(id) ON DELETE SET NULL,
    
    CONSTRAINT unique_mark UNIQUE (student_id, exam_id, subject_id),
    INDEX idx_student_id (student_id),
    INDEX idx_exam_id (exam_id),
    INDEX idx_subject_id (subject_id)
)   ;


-- Trigger for updated_at
CREATE OR REPLACE FUNCTION update_marks_updated_at()
RETURNS TRIGGER AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS trigger_update_marks_updated_at ON marks;
CREATE TRIGGER trigger_update_marks_updated_at
    BEFORE UPDATE ON marks
    FOR EACH ROW
    EXECUTE FUNCTION update_marks_updated_at();
