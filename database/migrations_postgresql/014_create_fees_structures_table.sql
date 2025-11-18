-- Migration: Create fees_structures table
-- Description: Stores fee structure definitions

CREATE TABLE IF NOT EXISTS fees_structures (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    class_id INTEGER NULL,
    course_id INTEGER NULL,
    academic_year VARCHAR(20) NOT NULL,
    semester VARCHAR(20) NULL,
    fee_type VARCHAR(50) NOT NULL CHECK (fee_type IN ('tuition', 'exam', 'library', 'lab', 'transport', 'hostel', 'other')),
    amount DECIMAL(10, 2) NOT NULL,
    due_date DATE NULL,
    status VARCHAR(50) DEFAULT 'active' CHECK (status IN ('active', 'inactive')),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE SET NULL,
    FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE SET NULL,
    
    INDEX idx_class_id (class_id),
    INDEX idx_course_id (course_id),
    INDEX idx_fee_type (fee_type),
    INDEX idx_academic_year (academic_year),
    INDEX idx_status (status)
)   ;


-- Trigger for updated_at
CREATE OR REPLACE FUNCTION update_fees_structures_updated_at()
RETURNS TRIGGER AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS trigger_update_fees_structures_updated_at ON fees_structures;
CREATE TRIGGER trigger_update_fees_structures_updated_at
    BEFORE UPDATE ON fees_structures
    FOR EACH ROW
    EXECUTE FUNCTION update_fees_structures_updated_at();
