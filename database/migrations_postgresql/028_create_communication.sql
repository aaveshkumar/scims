-- Communication Tables

-- Announcements table
CREATE TABLE IF NOT EXISTS announcements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    target_audience VARCHAR(50),
    priority VARCHAR(20) DEFAULT 'normal',
    published_by INT NOT NULL,
    published_date TIMESTAMP NOT NULL,
    expiry_date TIMESTAMP,
    attachment_path VARCHAR(255),
    is_visible BOOLEAN DEFAULT TRUE,
    views_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (published_by) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_target_audience (target_audience),
    INDEX idx_published_date (published_date),
    INDEX idx_priority (priority)
);

-- Messages table (Internal Messaging)
CREATE TABLE IF NOT EXISTS messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT NOT NULL,
    receiver_id INT NOT NULL,
    subject VARCHAR(255),
    message_body TEXT NOT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    read_at TIMESTAMP,
    attachment_path VARCHAR(255),
    parent_message_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (receiver_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (parent_message_id) REFERENCES messages(id) ON DELETE SET NULL,
    INDEX idx_sender (sender_id),
    INDEX idx_receiver (receiver_id),
    INDEX idx_is_read (is_read)
);

-- SMS Logs table
CREATE TABLE IF NOT EXISTS sms_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    recipient_phone VARCHAR(20) NOT NULL,
    recipient_name VARCHAR(255),
    message_content TEXT NOT NULL,
    sent_by INT,
    sent_at TIMESTAMP NOT NULL,
    status VARCHAR(20) DEFAULT 'sent',
    error_message TEXT,
    provider VARCHAR(50),
    cost DECIMAL(10,2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sent_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_recipient_phone (recipient_phone),
    INDEX idx_sent_at (sent_at),
    INDEX idx_status (status)
);

-- Email Logs table
CREATE TABLE IF NOT EXISTS email_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    recipient_email VARCHAR(255) NOT NULL,
    recipient_name VARCHAR(255),
    subject VARCHAR(255) NOT NULL,
    email_body TEXT NOT NULL,
    sent_by INT,
    sent_at TIMESTAMP NOT NULL,
    status VARCHAR(20) DEFAULT 'sent',
    error_message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sent_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_recipient_email (recipient_email),
    INDEX idx_sent_at (sent_at),
    INDEX idx_status (status)
);


-- Trigger for updated_at
CREATE OR REPLACE FUNCTION update_announcements_updated_at()
RETURNS TRIGGER AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS trigger_update_announcements_updated_at ON announcements;
CREATE TRIGGER trigger_update_announcements_updated_at
    BEFORE UPDATE ON announcements
    FOR EACH ROW
    EXECUTE FUNCTION update_announcements_updated_at();
