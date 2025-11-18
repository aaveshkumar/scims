-- Phase 1 Infrastructure Tables
-- Notification Queue, Event Log, System Settings

-- Notification Queue table (for async notification dispatch)
CREATE TABLE IF NOT EXISTS notification_queue (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    recipient_id INT UNSIGNED NULL,
    recipient_type VARCHAR(50) NULL COMMENT 'user, class, department, all',
    channel VARCHAR(50) NOT NULL COMMENT 'email, sms, push, in_app',
    subject VARCHAR(255) NULL,
    message TEXT NOT NULL,
    template VARCHAR(100) NULL,
    data JSON NULL COMMENT 'Template variables',
    priority ENUM('low', 'normal', 'high', 'urgent') DEFAULT 'normal',
    status ENUM('pending', 'processing', 'sent', 'failed') DEFAULT 'pending',
    scheduled_at TIMESTAMP NULL,
    sent_at TIMESTAMP NULL,
    failed_at TIMESTAMP NULL,
    error_message TEXT NULL,
    attempts INT DEFAULT 0,
    max_attempts INT DEFAULT 3,
    created_by INT UNSIGNED NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (recipient_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_status (status),
    INDEX idx_priority (priority),
    INDEX idx_channel (channel),
    INDEX idx_scheduled_at (scheduled_at),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Event Log table (system-wide activity tracking)
CREATE TABLE IF NOT EXISTS event_log (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    event_type VARCHAR(100) NOT NULL COMMENT 'login, logout, create, update, delete, etc.',
    module VARCHAR(100) NULL COMMENT 'users, students, fees, attendance, etc.',
    description TEXT NOT NULL,
    user_id INT UNSIGNED NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    data JSON NULL COMMENT 'Additional event data',
    severity ENUM('info', 'warning', 'error', 'critical') DEFAULT 'info',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_event_type (event_type),
    INDEX idx_module (module),
    INDEX idx_user_id (user_id),
    INDEX idx_severity (severity),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- School Calendar table
CREATE TABLE IF NOT EXISTS school_calendar (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NULL,
    event_date DATE NOT NULL,
    end_date DATE NULL COMMENT 'For multi-day events',
    event_type ENUM('holiday', 'exam', 'event', 'meeting', 'vacation', 'other') DEFAULT 'event',
    category VARCHAR(100) NULL,
    color VARCHAR(20) DEFAULT '#4e73df',
    is_holiday BOOLEAN DEFAULT FALSE,
    is_public BOOLEAN DEFAULT TRUE,
    class_id INT UNSIGNED NULL COMMENT 'For class-specific events',
    department VARCHAR(100) NULL COMMENT 'For department-specific events',
    created_by INT UNSIGNED NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_event_date (event_date),
    INDEX idx_event_type (event_type),
    INDEX idx_class_id (class_id),
    INDEX idx_is_public (is_public)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Holidays table (separate from calendar for better management)
CREATE TABLE IF NOT EXISTS holidays (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    holiday_type ENUM('national', 'religious', 'school', 'other') DEFAULT 'school',
    is_recurring BOOLEAN DEFAULT FALSE COMMENT 'Repeats every year',
    status ENUM('active', 'cancelled') DEFAULT 'active',
    created_by INT UNSIGNED NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_start_date (start_date),
    INDEX idx_holiday_type (holiday_type),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- School Events/Announcements table (enhanced version)
CREATE TABLE IF NOT EXISTS announcements (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    announcement_type ENUM('notice', 'event', 'alert', 'news') DEFAULT 'notice',
    priority ENUM('low', 'normal', 'high', 'urgent') DEFAULT 'normal',
    visibility ENUM('public', 'staff', 'students', 'parents', 'class', 'department') DEFAULT 'public',
    class_id INT UNSIGNED NULL,
    department VARCHAR(100) NULL,
    is_pinned BOOLEAN DEFAULT FALSE,
    attachment VARCHAR(255) NULL,
    published_at TIMESTAMP NULL,
    expires_at TIMESTAMP NULL,
    status ENUM('draft', 'published', 'archived') DEFAULT 'draft',
    views INT DEFAULT 0,
    created_by INT UNSIGNED NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_announcement_type (announcement_type),
    INDEX idx_visibility (visibility),
    INDEX idx_status (status),
    INDEX idx_is_pinned (is_pinned),
    INDEX idx_published_at (published_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- HR Events table (staff-specific events)
CREATE TABLE IF NOT EXISTS hr_events (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NULL,
    event_type ENUM('meeting', 'training', 'celebration', 'holiday', 'workshop', 'other') DEFAULT 'meeting',
    start_datetime TIMESTAMP NOT NULL,
    end_datetime TIMESTAMP NULL,
    location VARCHAR(255) NULL,
    department VARCHAR(100) NULL,
    is_mandatory BOOLEAN DEFAULT FALSE,
    max_participants INT NULL,
    registered_count INT DEFAULT 0,
    status ENUM('planned', 'confirmed', 'cancelled', 'completed') DEFAULT 'planned',
    requires_approval BOOLEAN DEFAULT FALSE,
    approved_by INT UNSIGNED NULL,
    approved_at TIMESTAMP NULL,
    created_by INT UNSIGNED NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (approved_by) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_event_type (event_type),
    INDEX idx_start_datetime (start_datetime),
    INDEX idx_department (department),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- HR Event Participants table
CREATE TABLE IF NOT EXISTS hr_event_participants (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    event_id INT UNSIGNED NOT NULL,
    user_id INT UNSIGNED NOT NULL,
    status ENUM('invited', 'registered', 'attended', 'absent', 'cancelled') DEFAULT 'invited',
    registration_date TIMESTAMP NULL,
    attendance_marked_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES hr_events(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_event_participant (event_id, user_id),
    INDEX idx_event_id (event_id),
    INDEX idx_user_id (user_id),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
