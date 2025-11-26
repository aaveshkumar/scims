-- System Administration Tables

-- System Settings table
CREATE TABLE IF NOT EXISTS system_settings (
    id SERIAL PRIMARY KEY,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT,
    setting_type VARCHAR(50),
    category VARCHAR(100),
    description TEXT,
    is_editable BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_setting_key (setting_key),
    INDEX idx_category (category)
);

-- Audit Logs table
CREATE TABLE IF NOT EXISTS audit_logs (
    id SERIAL PRIMARY KEY,
    user_id INT,
    action VARCHAR(100) NOT NULL,
    table_name VARCHAR(100),
    record_id INT,
    old_values TEXT,
    new_values TEXT,
    ip_address VARCHAR(50),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_user (user_id),
    INDEX idx_action (action),
    INDEX idx_table_name (table_name),
    INDEX idx_created_at (created_at)
);

-- Database Backups table
CREATE TABLE IF NOT EXISTS database_backups (
    id SERIAL PRIMARY KEY,
    backup_name VARCHAR(255) NOT NULL,
    backup_path VARCHAR(255) NOT NULL,
    backup_size BIGINT,
    backup_type VARCHAR(50),
    created_by INT,
    status VARCHAR(20) DEFAULT 'completed',
    error_message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_backup_type (backup_type),
    INDEX idx_created_at (created_at),
    INDEX idx_status (status)
);

-- Integrations table
CREATE TABLE IF NOT EXISTS integrations (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    integration_type VARCHAR(50),
    api_key TEXT,
    api_secret TEXT,
    endpoint_url VARCHAR(255),
    configuration TEXT,
    is_active BOOLEAN DEFAULT FALSE,
    last_sync TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_integration_type (integration_type),
    INDEX idx_is_active (is_active)
);


-- Trigger for updated_at
CREATE OR REPLACE FUNCTION update_system_settings_updated_at()
RETURNS TRIGGER AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS trigger_update_system_settings_updated_at ON system_settings;
CREATE TRIGGER trigger_update_system_settings_updated_at
    BEFORE UPDATE ON system_settings
    FOR EACH ROW
    EXECUTE FUNCTION update_system_settings_updated_at();
