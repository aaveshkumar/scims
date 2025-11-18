-- Migration: Create staff table
-- Description: Extended staff information

CREATE TABLE IF NOT EXISTS staff (
    id SERIAL PRIMARY KEY,
    user_id INTEGER NOT NULL,
    employee_id VARCHAR(50) NOT NULL UNIQUE,
    designation VARCHAR(100) NOT NULL,
    department VARCHAR(100) NULL,
    qualification VARCHAR(200) NULL,
    experience_years INT NULL,
    joining_date DATE NOT NULL,
    salary DECIMAL(10, 2) NULL,
    bank_name VARCHAR(100) NULL,
    account_number VARCHAR(50) NULL,
    emergency_contact VARCHAR(20) NULL,
    documents JSON NULL,
    status VARCHAR(50) DEFAULT 'active' CHECK (status IN ('active', 'inactive', 'on_leave', 'resigned')),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    
    INDEX idx_user_id (user_id),
    INDEX idx_employee_id (employee_id),
    INDEX idx_designation (designation),
    INDEX idx_status (status)
)   ;


-- Trigger for updated_at
CREATE OR REPLACE FUNCTION update_staff_updated_at()
RETURNS TRIGGER AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS trigger_update_staff_updated_at ON staff;
CREATE TRIGGER trigger_update_staff_updated_at
    BEFORE UPDATE ON staff
    FOR EACH ROW
    EXECUTE FUNCTION update_staff_updated_at();
