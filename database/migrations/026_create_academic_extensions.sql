-- Academic Extensions Tables

-- Syllabus table
CREATE TABLE IF NOT EXISTS syllabuses (
    id INT AUTO_INCREMENT PRIMARY KEY,
    subject_id INT NOT NULL,
    class_id INT NOT NULL,
    academic_year VARCHAR(20),
    title VARCHAR(255) NOT NULL,
    description TEXT,
    topics TEXT,
    learning_objectives TEXT,
    duration_hours INT,
    file_path VARCHAR(255),
    created_by INT,
    status VARCHAR(20) DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE,
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_subject (subject_id),
    INDEX idx_class (class_id),
    INDEX idx_academic_year (academic_year)
);

-- Lesson Plans table
CREATE TABLE IF NOT EXISTS lesson_plans (
    id INT AUTO_INCREMENT PRIMARY KEY,
    subject_id INT NOT NULL,
    class_id INT NOT NULL,
    teacher_id INT NOT NULL,
    lesson_title VARCHAR(255) NOT NULL,
    lesson_date DATE NOT NULL,
    duration_minutes INT,
    objectives TEXT,
    content TEXT,
    methodology TEXT,
    resources TEXT,
    assessment TEXT,
    homework TEXT,
    status VARCHAR(20) DEFAULT 'planned',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE,
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE CASCADE,
    FOREIGN KEY (teacher_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_subject (subject_id),
    INDEX idx_class (class_id),
    INDEX idx_teacher (teacher_id),
    INDEX idx_lesson_date (lesson_date)
);

-- Question Bank table
CREATE TABLE IF NOT EXISTS question_bank (
    id INT AUTO_INCREMENT PRIMARY KEY,
    subject_id INT NOT NULL,
    class_id INT,
    question_text TEXT NOT NULL,
    question_type VARCHAR(50),
    difficulty_level VARCHAR(20),
    marks INT DEFAULT 1,
    option_a TEXT,
    option_b TEXT,
    option_c TEXT,
    option_d TEXT,
    correct_answer TEXT,
    explanation TEXT,
    topic VARCHAR(255),
    created_by INT,
    status VARCHAR(20) DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (subject_id) REFERENCES subjects(id) ON DELETE CASCADE,
    FOREIGN KEY (class_id) REFERENCES classes(id) ON DELETE SET NULL,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_subject (subject_id),
    INDEX idx_class (class_id),
    INDEX idx_type (question_type),
    INDEX idx_difficulty (difficulty_level)
);

-- Academic Calendar table
CREATE TABLE IF NOT EXISTS academic_calendar (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_title VARCHAR(255) NOT NULL,
    event_type VARCHAR(100),
    event_date DATE NOT NULL,
    end_date DATE,
    description TEXT,
    location VARCHAR(255),
    is_holiday BOOLEAN DEFAULT FALSE,
    academic_year VARCHAR(20),
    created_by INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_event_date (event_date),
    INDEX idx_event_type (event_type),
    INDEX idx_academic_year (academic_year)
);
