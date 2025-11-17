-- Departments table
CREATE TABLE IF NOT EXISTS departments (
    id INT AUTO_INCREMENT PRIMARY KEY,
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
