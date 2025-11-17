-- Library Management Tables

-- Books table
CREATE TABLE IF NOT EXISTS books (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    isbn VARCHAR(20) UNIQUE,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    publisher VARCHAR(255),
    publication_year INT UNSIGNED,
    category VARCHAR(100),
    total_copies INT DEFAULT 1,
    available_copies INT DEFAULT 1,
    location VARCHAR(100),
    price DECIMAL(10,2),
    description TEXT,
    cover_image VARCHAR(255),
    status VARCHAR(20) DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_isbn (isbn),
    INDEX idx_title (title),
    INDEX idx_category (category),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Book Issues table
CREATE TABLE IF NOT EXISTS book_issues (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    book_id INT UNSIGNED NOT NULL,
    user_id INT UNSIGNED NOT NULL,
    issue_date DATE NOT NULL,
    due_date DATE NOT NULL,
    return_date DATE,
    status VARCHAR(20) DEFAULT 'issued',
    fine_amount DECIMAL(10,2) DEFAULT 0,
    fine_paid BOOLEAN DEFAULT FALSE,
    remarks TEXT,
    issued_by INT UNSIGNED,
    returned_to INT UNSIGNED,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (book_id) REFERENCES books(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (issued_by) REFERENCES users(id) ON DELETE SET NULL,
    FOREIGN KEY (returned_to) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_user (user_id),
    INDEX idx_book (book_id),
    INDEX idx_status (status),
    INDEX idx_issue_date (issue_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Library Members table
CREATE TABLE IF NOT EXISTS library_members (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    member_number VARCHAR(50) UNIQUE NOT NULL,
    membership_type VARCHAR(50) DEFAULT 'standard',
    join_date DATE NOT NULL,
    expiry_date DATE,
    max_books INT DEFAULT 3,
    status VARCHAR(20) DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_member_number (member_number),
    INDEX idx_user (user_id),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
