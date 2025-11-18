-- Migration: Create materials table
-- Description: Stores learning materials (LMS)

CREATE TABLE IF NOT EXISTS materials (
    id SERIAL PRIMARY KEY,
    title VARCHAR(200) NOT NULL,
    description TEXT NULL,
    file_path VARCHAR(255) NOT NULL,
    file_type VARCHAR(50) NULL,
    file_size INT NULL,
    subject_id INTEGER NULL,
    class_id INTEGER NULL,
    uploaded_by INTEGER NOT NULL,
    downloads INT DEFAULT 0,
    type VARCHAR(50) DEFAULT 'notes' CHECK (type IN ('notes', 'assignment', 'syllabus', 'question_paper', 'other')),
    status VARCHAR(50) DEFAULT 'active' CHECK (status IN ('active', 'inactive')),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE SET NULL,
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE SET NULL,
    FOREIGN KEY (uploaded_by) REFERENCES users(id) ON DELETE CASCADE,
    
    INDEX idx_subject_id (subject_id),
    INDEX idx_class_id (class_id),
    INDEX idx_uploaded_by (uploaded_by),
    INDEX idx_type (type),
    INDEX idx_status (status)
)   ;


-- Trigger for updated_at
CREATE OR REPLACE FUNCTION update_materials_updated_at()
RETURNS TRIGGER AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS trigger_update_materials_updated_at ON materials;
CREATE TRIGGER trigger_update_materials_updated_at
    BEFORE UPDATE ON materials
    FOR EACH ROW
    EXECUTE FUNCTION update_materials_updated_at();
