-- Departments table
CREATE TABLE IF NOT EXISTS departments (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    code VARCHAR(50) UNIQUE NOT NULL,
    description TEXT,
    head_id INT,
    parent_department_id INT,
    email VARCHAR(255),
    phone VARCHAR(20),
    location VARCHAR(255),
    budget DECIMAL(10,2),
    status VARCHAR(20) DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (head_id) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (parent_department_id) REFERENCES departments(id) ON DELETE SET NULL,
    INDEX idx_code (code),
    INDEX idx_status (status)
);

-- Add department_id column to staff table if not exists
ALTER TABLE staff ADD COLUMN IF NOT EXISTS department_id INT,
ADD CONSTRAINT fk_staff_department FOREIGN KEY (department_id) REFERENCES departments(id) ON DELETE SET NULL;


-- Trigger for updated_at
CREATE OR REPLACE FUNCTION update_departments_updated_at()
RETURNS TRIGGER AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS trigger_update_departments_updated_at ON departments;
CREATE TRIGGER trigger_update_departments_updated_at
    BEFORE UPDATE ON departments
    FOR EACH ROW
    EXECUTE FUNCTION update_departments_updated_at();
