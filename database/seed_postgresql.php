<?php

require __DIR__ . '/../bootstrap.php';

echo "🌱 Starting PostgreSQL data seeding...\n\n";

try {
    $admin = db()->fetchOne("SELECT id FROM users WHERE email = 'admin@school.com'");
    if (!$admin) {
        echo "❌ Admin user not found! Please run seed.php first.\n";
        exit(1);
    }
    $adminId = $admin['id'];
    
    db()->beginTransaction();
    
    echo "👥 Creating Roles...\n";
    $roles = ['Admin', 'Teacher', 'Student', 'Parent', 'Accountant', 'Librarian'];
    foreach ($roles as $role) {
        $existing = db()->fetchOne("SELECT id FROM roles WHERE name = ?", [$role]);
        if (!$existing) {
            db()->execute("INSERT INTO roles (name, display_name, description, created_at) VALUES (?, ?, ?, NOW())", 
                [$role, $role, $role . ' role']);
        }
    }
    echo "✅ Roles created\n";
    
    echo "📚 Creating Courses...\n";
    $courses = [
        ['Bachelor of Science', 'BSC', 'Science degree program', 3],
        ['Bachelor of Arts', 'BA', 'Arts degree program', 3],
        ['Bachelor of Commerce', 'BCOM', 'Commerce degree program', 3],
        ['Master of Science', 'MSC', 'Postgraduate science program', 2],
        ['Master of Arts', 'MA', 'Postgraduate arts program', 2]
    ];
    foreach ($courses as $course) {
        $existing = db()->fetchOne("SELECT id FROM courses WHERE code = ?", [$course[1]]);
        if (!$existing) {
            db()->execute("INSERT INTO courses (name, code, description, duration_years, status, created_at) VALUES (?, ?, ?, ?, 'active', NOW())", 
                [$course[0], $course[1], $course[2], $course[3]]);
        }
    }
    echo "✅ Courses created\n";
    
    echo "🏫 Creating Classes...\n";
    $courseIds = db()->fetchAll("SELECT id FROM courses");
    foreach ($courseIds as $i => $course) {
        $code = "CLS" . str_pad($i + 1, 3, '0', STR_PAD_LEFT);
        $existing = db()->fetchOne("SELECT id FROM classes WHERE code = ?", [$code]);
        if (!$existing) {
            db()->execute("INSERT INTO classes (name, code, course_id, section, academic_year, capacity, status, created_at) VALUES (?, ?, ?, ?, ?, 50, 'active', NOW())", 
                ["Class " . ($i + 1), $code, $course['id'], chr(65 + $i), '2024-2025']);
        }
    }
    echo "✅ Classes created\n";
    
    echo "📖 Creating Subjects...\n";
    $subjects = ['Mathematics', 'Physics', 'Chemistry', 'Biology', 'English', 'History', 'Geography', 'Computer Science'];
    $courseIds = db()->fetchAll("SELECT id FROM courses LIMIT 1");
    if (!empty($courseIds)) {
        foreach ($subjects as $subject) {
            $existing = db()->fetchOne("SELECT id FROM subjects WHERE name = ?", [$subject]);
            if (!$existing) {
                db()->execute("INSERT INTO subjects (name, code, course_id, credits, status, created_at) VALUES (?, ?, ?, 3, 'active', NOW())", 
                    [$subject, strtoupper(substr($subject, 0, 3)), $courseIds[0]['id']]);
            }
        }
    }
    echo "✅ Subjects created\n";
    
    echo "👨‍🎓 Creating Students...\n";
    $classIds = db()->fetchAll("SELECT id FROM classes LIMIT 5");
    if (!empty($classIds)) {
        for ($i = 1; $i <= 10; $i++) {
            $email = "student{$i}@school.com";
            $existing = db()->fetchOne("SELECT id FROM users WHERE email = ?", [$email]);
            if (!$existing) {
                db()->execute("INSERT INTO users (email, password, first_name, last_name, phone, date_of_birth, status, created_at) VALUES (?, ?, ?, ?, ?, ?, 'active', NOW())", 
                    [$email, password_hash('student123', PASSWORD_DEFAULT), "Student", "Number {$i}", "123456789{$i}", '2005-01-01']);
                $userId = db()->lastInsertId();
                
                db()->execute("INSERT INTO students (user_id, admission_number, class_id, roll_number, admission_date, status, created_at) VALUES (?, ?, ?, ?, ?, 'active', NOW())", 
                    [$userId, "STU2024" . str_pad($i, 4, '0', STR_PAD_LEFT), $classIds[$i % count($classIds)]['id'], $i, '2024-01-15']);
            }
        }
    }
    echo "✅ Students created\n";
    
    echo "👨‍🏫 Creating Staff...\n";
    for ($i = 1; $i <= 5; $i++) {
        $email = "teacher{$i}@school.com";
        $existing = db()->fetchOne("SELECT id FROM users WHERE email = ?", [$email]);
        if (!$existing) {
            db()->execute("INSERT INTO users (email, password, first_name, last_name, phone, status, created_at) VALUES (?, ?, ?, ?, ?, 'active', NOW())", 
                [$email, password_hash('teacher123', PASSWORD_DEFAULT), "Teacher", "Number {$i}", "987654321{$i}"]);
            $userId = db()->lastInsertId();
            
            db()->execute("INSERT INTO staff (user_id, employee_id, designation, joining_date, status, created_at) VALUES (?, ?, ?, ?, 'active', NOW())", 
                [$userId, "EMP2024" . str_pad($i, 4, '0', STR_PAD_LEFT), 'Teacher', '2024-01-01']);
        }
    }
    echo "✅ Staff created\n";
    
    echo "📝 Creating Exams...\n";
    $classIds = db()->fetchAll("SELECT id FROM classes LIMIT 3");
    foreach ($classIds as $i => $class) {
        $code = "EX" . str_pad($i + 1, 3, '0', STR_PAD_LEFT);
        $existing = db()->fetchOne("SELECT id FROM exams WHERE code = ?", [$code]);
        if (!$existing) {
            $startDate = date('Y-m-d', strtotime('+1 month'));
            $endDate = date('Y-m-d', strtotime('+1 month +5 days'));
            db()->execute("INSERT INTO exams (name, code, class_id, exam_type, academic_year, start_date, end_date, total_marks, passing_marks, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, 100, 40, 'scheduled', NOW())", 
                ["Mid Term " . ($i + 1), $code, $class['id'], 'midterm', '2024-2025', $startDate, $endDate]);
        }
    }
    echo "✅ Exams created\n";
    
    echo "📚 Creating Library Books...\n";
    $books = [
        ['Introduction to Algorithms', 'Thomas Cormen', '978-0262033848'],
        ['Clean Code', 'Robert Martin', '978-0132350884'],
        ['Design Patterns', 'Gang of Four', '978-0201633612'],
        ['The Pragmatic Programmer', 'Hunt & Thomas', '978-0135957059'],
        ['Code Complete', 'Steve McConnell', '978-0735619678']
    ];
    foreach ($books as $book) {
        $existing = db()->fetchOne("SELECT id FROM books WHERE isbn = ?", [$book[2]]);
        if (!$existing) {
            db()->execute("INSERT INTO books (title, author, isbn, total_copies, available_copies, status, created_at) VALUES (?, ?, ?, 5, 5, 'active', NOW())", 
                [$book[0], $book[1], $book[2]]);
        }
    }
    echo "✅ Books created\n";
    
    db()->commit();
    
    echo "\n✅ Seeding completed successfully!\n\n";
    echo "📊 Final Summary:\n";
    echo "  - Roles: " . count(db()->fetchAll("SELECT id FROM roles")) . "\n";
    echo "  - Courses: " . count(db()->fetchAll("SELECT id FROM courses")) . "\n";
    echo "  - Classes: " . count(db()->fetchAll("SELECT id FROM classes")) . "\n";
    echo "  - Subjects: " . count(db()->fetchAll("SELECT id FROM subjects")) . "\n";
    echo "  - Students: " . count(db()->fetchAll("SELECT id FROM students")) . "\n";
    echo "  - Staff: " . count(db()->fetchAll("SELECT id FROM staff")) . "\n";
    echo "  - Exams: " . count(db()->fetchAll("SELECT id FROM exams")) . "\n";
    echo "  - Books: " . count(db()->fetchAll("SELECT id FROM books")) . "\n";
    
} catch (Exception $e) {
    if (db()->inTransaction()) {
        db()->rollback();
    }
    echo "\n❌ Seeding failed: " . $e->getMessage() . "\n";
    exit(1);
}
