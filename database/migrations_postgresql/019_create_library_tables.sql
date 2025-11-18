-- Library Management Tables

-- Books table
CREATE TABLE IF NOT EXISTS books (
    id SERIAL PRIMARY KEY,
    isbn VARCHAR(20) UNIQUE,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    publisher VARCHAR(255),
    publication_year INTEGER,
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
)   ;

-- Book Issues table
CREATE TABLE IF NOT EXISTS book_issues (
    id SERIAL PRIMARY KEY,
    book_id INTEGER NOT NULL,
    user_id INTEGER NOT NULL,
    issue_date DATE NOT NULL,
    due_date DATE NOT NULL,
    return_date DATE,
    status VARCHAR(20) DEFAULT 'issued',
    fine_amount DECIMAL(10,2) DEFAULT 0,
    fine_paid BOOLEAN DEFAULT FALSE,
    remarks TEXT,
    issued_by INTEGER,
    returned_to INTEGER,
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
)   ;

-- Library Members table
CREATE TABLE IF NOT EXISTS library_members (
    id SERIAL PRIMARY KEY,
    user_id INTEGER NOT NULL,
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
)   ;


-- Trigger for updated_at
CREATE OR REPLACE FUNCTION update_books_updated_at()
RETURNS TRIGGER AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS trigger_update_books_updated_at ON books;
CREATE TRIGGER trigger_update_books_updated_at
    BEFORE UPDATE ON books
    FOR EACH ROW
    EXECUTE FUNCTION update_books_updated_at();
