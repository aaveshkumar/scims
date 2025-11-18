-- Advanced Finance Tables

-- Fee Structure Templates table
CREATE TABLE IF NOT EXISTS fee_structure_templates (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    class_id INT,
    academic_year VARCHAR(20),
    amount DECIMAL(10,2) NOT NULL,
    due_date DATE,
    fine_per_day DECIMAL(10,2) DEFAULT 0,
    description TEXT,
    status VARCHAR(20) DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE SET NULL,
    INDEX idx_class (class_id),
    INDEX idx_academic_year (academic_year),
    INDEX idx_status (status)
);

-- Expenses table
CREATE TABLE IF NOT EXISTS expenses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    expense_number VARCHAR(50) UNIQUE NOT NULL,
    category VARCHAR(100) NOT NULL,
    description TEXT,
    amount DECIMAL(10,2) NOT NULL,
    expense_date DATE NOT NULL,
    payment_method VARCHAR(50),
    vendor VARCHAR(255),
    invoice_number VARCHAR(100),
    approved_by INT,
    status VARCHAR(20) DEFAULT 'pending',
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (approved_by) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_expense_number (expense_number),
    INDEX idx_category (category),
    INDEX idx_expense_date (expense_date),
    INDEX idx_status (status)
);

-- Payroll table
CREATE TABLE IF NOT EXISTS payroll (
    id INT AUTO_INCREMENT PRIMARY KEY,
    payroll_number VARCHAR(50) UNIQUE NOT NULL,
    staff_id INT NOT NULL,
    month VARCHAR(20) NOT NULL,
    year INT NOT NULL,
    basic_salary DECIMAL(10,2) NOT NULL,
    allowances DECIMAL(10,2) DEFAULT 0,
    deductions DECIMAL(10,2) DEFAULT 0,
    gross_salary DECIMAL(10,2) NOT NULL,
    net_salary DECIMAL(10,2) NOT NULL,
    payment_date DATE,
    payment_method VARCHAR(50),
    status VARCHAR(20) DEFAULT 'pending',
    remarks TEXT,
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (staff_id) REFERENCES staff(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    UNIQUE (staff_id, month, year),
    INDEX idx_staff (staff_id),
    INDEX idx_month_year (month, year),
    INDEX idx_status (status)
);

-- Budgets table
CREATE TABLE IF NOT EXISTS budgets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    budget_name VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    fiscal_year VARCHAR(20) NOT NULL,
    allocated_amount DECIMAL(10,2) NOT NULL,
    spent_amount DECIMAL(10,2) DEFAULT 0,
    remaining_amount DECIMAL(10,2),
    department VARCHAR(100),
    status VARCHAR(20) DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_category (category),
    INDEX idx_fiscal_year (fiscal_year),
    INDEX idx_status (status)
);


-- Trigger for updated_at
CREATE OR REPLACE FUNCTION update_fee_structure_templates_updated_at()
RETURNS TRIGGER AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS trigger_update_fee_structure_templates_updated_at ON fee_structure_templates;
CREATE TRIGGER trigger_update_fee_structure_templates_updated_at
    BEFORE UPDATE ON fee_structure_templates
    FOR EACH ROW
    EXECUTE FUNCTION update_fee_structure_templates_updated_at();
