<?php

require_once __DIR__ . '/../bootstrap.php';

$db = Database::getInstance();

echo "🌱 Starting comprehensive data seeding...\n\n";

try {
    $db->beginTransaction();

    // Get admin and existing users
    $admin = $db->fetchOne("SELECT id FROM users WHERE email = 'admin@school.com' LIMIT 1");
    if (!$admin) {
        die("❌ Admin user not found! Please run seed.php first.\n");
    }
    $adminId = $admin['id'];

    echo "📚 Seeding Courses (20 records)...\n";
    $courses = [];
    $courseNames = ['Computer Science', 'Mathematics', 'Physics', 'Chemistry', 'Biology', 'English Literature', 'History', 'Geography', 'Economics', 'Business Studies', 'Art & Design', 'Music', 'Physical Education', 'French', 'Spanish', 'Psychology', 'Sociology', 'Political Science', 'Philosophy', 'Environmental Science'];
    foreach ($courseNames as $i => $name) {
        $db->execute(
            "INSERT INTO courses (name, code, description, duration, status, created_at) 
             VALUES (?, ?, ?, ?, ?, NOW()) 
             ON DUPLICATE KEY UPDATE code=code",
            [$name, 'CRS' . str_pad($i + 1, 3, '0', STR_PAD_LEFT), "Comprehensive $name course", ($i % 3) + 1 . ' years', 'active']
        );
        $courses[] = $db->lastInsertId() ?: ($i + 1);
    }

    echo "🎓 Seeding Classes (15 records)...\n";
    $classes = [];
    $classNames = ['Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6', 'Grade 7', 'Grade 8', 'Grade 9', 'Grade 10', 'Grade 11 Science', 'Grade 11 Commerce', 'Grade 11 Arts', 'Grade 12 Science', 'Grade 12 Commerce'];
    foreach ($classNames as $i => $name) {
        $db->execute(
            "INSERT INTO classes (name, code, capacity, room_number, status, created_at) 
             VALUES (?, ?, ?, ?, ?, NOW()) 
             ON DUPLICATE KEY UPDATE code=code",
            [$name, 'CLS' . str_pad($i + 1, 3, '0', STR_PAD_LEFT), rand(30, 50), 'R-' . ($i + 101), 'active']
        );
        $classes[] = $db->lastInsertId() ?: ($i + 1);
    }

    echo "📖 Seeding Subjects (30 records)...\n";
    $subjects = [];
    $subjectNames = ['Advanced Mathematics', 'Calculus', 'Algebra', 'Geometry', 'Trigonometry', 'Quantum Physics', 'Mechanics', 'Optics', 'Thermodynamics', 'Organic Chemistry', 'Inorganic Chemistry', 'Physical Chemistry', 'Cell Biology', 'Genetics', 'Ecology', 'English Grammar', 'English Literature', 'Creative Writing', 'World History', 'Ancient Civilizations', 'World Geography', 'Microeconomics', 'Macroeconomics', 'Business Management', 'Accounting', 'Fine Arts', 'Digital Arts', 'Classical Music', 'Sports Science', 'French Language'];
    foreach ($subjectNames as $i => $name) {
        $db->execute(
            "INSERT INTO subjects (name, code, description, status, created_at) 
             VALUES (?, ?, ?, ?, NOW()) 
             ON DUPLICATE KEY UPDATE code=code",
            [$name, 'SUB' . str_pad($i + 1, 3, '0', STR_PAD_LEFT), "Advanced course in $name", 'active']
        );
        $subjects[] = $db->lastInsertId() ?: ($i + 1);
    }

    echo "👥 Seeding Staff (20 records)...\n";
    $staff = [];
    $firstNames = ['John', 'Sarah', 'Michael', 'Emily', 'David', 'Jessica', 'Robert', 'Amanda', 'William', 'Jennifer', 'James', 'Lisa', 'Thomas', 'Mary', 'Daniel', 'Patricia', 'Richard', 'Linda', 'Charles', 'Barbara'];
    $lastNames = ['Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis', 'Rodriguez', 'Martinez', 'Hernandez', 'Lopez', 'Gonzalez', 'Wilson', 'Anderson', 'Thomas', 'Taylor', 'Moore', 'Jackson', 'Martin'];
    
    for ($i = 0; $i < 20; $i++) {
        $email = strtolower($firstNames[$i]) . '.' . strtolower($lastNames[$i]) . '@school.com';
        $password = password_hash('teacher@2025', PASSWORD_DEFAULT);
        
        // Create user
        $db->execute(
            "INSERT INTO users (first_name, last_name, email, phone, password, gender, date_of_birth, status, created_at) 
             VALUES (?, ?, ?, ?, ?, ?, ?, 'active', NOW())
             ON DUPLICATE KEY UPDATE email=email",
            [$firstNames[$i], $lastNames[$i], $email, '555-' . rand(1000, 9999), $password, $i % 2 == 0 ? 'male' : 'female', date('Y-m-d', strtotime('-' . rand(30, 50) . ' years'))]
        );
        $userId = $db->lastInsertId();
        
        if ($userId) {
            // Assign teacher role
            $teacherRole = $db->fetchOne("SELECT id FROM roles WHERE name = 'teacher' LIMIT 1");
            if ($teacherRole) {
                $db->execute("INSERT IGNORE INTO user_roles (user_id, role_id, created_at) VALUES (?, ?, NOW())", [$userId, $teacherRole['id']]);
            }
            
            // Create staff record
            $db->execute(
                "INSERT INTO staff (user_id, employee_number, designation, qualification, joining_date, salary, status, created_at) 
                 VALUES (?, ?, ?, ?, ?, ?, 'active', NOW())
                 ON DUPLICATE KEY UPDATE user_id=user_id",
                [$userId, 'EMP' . str_pad($i + 1, 4, '0', STR_PAD_LEFT), ['Teacher', 'Senior Teacher', 'Assistant Professor', 'Professor'][$i % 4], ['M.Sc.', 'M.A.', 'Ph.D.', 'M.Ed.'][$i % 4], date('Y-m-d', strtotime('-' . rand(1, 10) . ' years')), rand(30000, 80000)]
            );
            $staff[] = $db->lastInsertId() ?: ($i + 1);
        }
    }

    echo "👨‍🎓 Seeding Students (50 records)...\n";
    $studentFirstNames = ['Alex', 'Emma', 'Noah', 'Olivia', 'Liam', 'Ava', 'Mason', 'Sophia', 'Jacob', 'Isabella', 'Ethan', 'Mia', 'Logan', 'Charlotte', 'Lucas', 'Amelia', 'Benjamin', 'Harper', 'Henry', 'Evelyn', 'Sebastian', 'Abigail', 'Jack', 'Emily', 'Aiden', 'Elizabeth', 'Matthew', 'Sofia', 'Samuel', 'Avery', 'David', 'Ella', 'Joseph', 'Scarlett', 'Carter', 'Grace', 'Owen', 'Chloe', 'Wyatt', 'Victoria', 'John', 'Riley', 'Dylan', 'Aria', 'Luke', 'Lily', 'Gabriel', 'Aubrey', 'Anthony', 'Zoey'];
    
    for ($i = 0; $i < 50; $i++) {
        $email = strtolower($studentFirstNames[$i]) . $i . '@student.school.com';
        $password = password_hash('student@2025', PASSWORD_DEFAULT);
        
        // Create user
        $db->execute(
            "INSERT INTO users (first_name, last_name, email, phone, password, gender, date_of_birth, status, created_at) 
             VALUES (?, ?, ?, ?, ?, ?, ?, 'active', NOW())
             ON DUPLICATE KEY UPDATE email=email",
            [$studentFirstNames[$i], $lastNames[$i % 20], $email, '555-' . rand(1000, 9999), $password, $i % 2 == 0 ? 'male' : 'female', date('Y-m-d', strtotime('-' . rand(6, 18) . ' years'))]
        );
        $userId = $db->lastInsertId();
        
        if ($userId) {
            // Assign student role
            $studentRole = $db->fetchOne("SELECT id FROM roles WHERE name = 'student' LIMIT 1");
            if ($studentRole) {
                $db->execute("INSERT IGNORE INTO user_roles (user_id, role_id, created_at) VALUES (?, ?, NOW())", [$userId, $studentRole['id']]);
            }
            
            // Create student record
            $classId = $classes[array_rand($classes)];
            $db->execute(
                "INSERT INTO students (user_id, admission_number, class_id, admission_date, guardian_name, guardian_phone, status, created_at) 
                 VALUES (?, ?, ?, ?, ?, ?, 'active', NOW())
                 ON DUPLICATE KEY UPDATE user_id=user_id",
                [$userId, 'STU' . date('Y') . str_pad($i + 1, 4, '0', STR_PAD_LEFT), $classId, date('Y-m-d', strtotime('-' . rand(1, 5) . ' years')), 'Guardian of ' . $studentFirstNames[$i], '555-' . rand(1000, 9999)]
            );
        }
    }

    echo "📝 Seeding Admissions (30 records)...\n";
    $statuses = ['pending', 'approved', 'rejected', 'waitlisted', 'completed'];
    for ($i = 0; $i < 30; $i++) {
        $status = $statuses[$i % 5];
        $courseId = $courses[array_rand($courses)];
        $classId = $classes[array_rand($classes)];
        
        $db->execute(
            "INSERT INTO admissions (application_number, first_name, last_name, email, phone, date_of_birth, gender, address, course_id, class_id, guardian_name, guardian_phone, status, applied_at, created_at) 
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())
             ON DUPLICATE KEY UPDATE application_number=application_number",
            ['ADM' . date('Y') . str_pad($i + 1, 4, '0', STR_PAD_LEFT), $studentFirstNames[$i % 50], $lastNames[$i % 20], 'applicant' . $i . '@email.com', '555-' . rand(1000, 9999), date('Y-m-d', strtotime('-' . rand(6, 18) . ' years')), $i % 2 == 0 ? 'male' : 'female', rand(100, 999) . ' Main Street, City', $courseId, $classId, 'Guardian ' . ($i + 1), '555-' . rand(1000, 9999), $status]
        );
    }

    echo "📅 Seeding Exams (15 records)...\n";
    $examTypes = ['Midterm', 'Final', 'Unit Test', 'Mock Exam', 'Practice Test'];
    for ($i = 0; $i < 15; $i++) {
        $subjectId = $subjects[array_rand($subjects)];
        $classId = $classes[array_rand($classes)];
        
        $db->execute(
            "INSERT INTO exams (name, exam_type, subject_id, class_id, exam_date, duration, total_marks, passing_marks, created_at) 
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
             ON DUPLICATE KEY UPDATE name=name",
            [$examTypes[$i % 5] . ' - ' . date('Y'), $examTypes[$i % 5], $subjectId, $classId, date('Y-m-d', strtotime('+' . rand(1, 60) . ' days')), rand(60, 180), 100, 40]
        );
    }

    echo "💰 Seeding Invoices (40 records)...\n";
    $studentIds = $db->fetchAll("SELECT id FROM students LIMIT 40");
    foreach ($studentIds as $i => $student) {
        $amount = rand(1000, 5000);
        $paid = $i % 3 == 0 ? $amount : rand(0, $amount);
        
        $db->execute(
            "INSERT INTO invoices (invoice_number, student_id, amount, paid_amount, due_amount, due_date, status, created_at) 
             VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
             ON DUPLICATE KEY UPDATE invoice_number=invoice_number",
            ['INV' . date('Y') . str_pad($i + 1, 4, '0', STR_PAD_LEFT), $student['id'], $amount, $paid, $amount - $paid, date('Y-m-d', strtotime('+' . rand(10, 90) . ' days')), $paid >= $amount ? 'paid' : ($paid > 0 ? 'partial' : 'unpaid')]
        );
    }

    echo "📚 Seeding Study Materials (25 records)...\n";
    $materialTypes = ['PDF', 'Video', 'Document', 'Presentation', 'Assignment'];
    for ($i = 0; $i < 25; $i++) {
        $subjectId = $subjects[array_rand($subjects)];
        $classId = $classes[array_rand($classes)];
        $staffId = $staff[array_rand($staff)];
        
        $db->execute(
            "INSERT INTO materials (title, description, subject_id, class_id, uploaded_by, file_path, file_type, created_at) 
             VALUES (?, ?, ?, ?, ?, ?, ?, NOW())
             ON DUPLICATE KEY UPDATE title=title",
            ['Study Material ' . ($i + 1), 'Comprehensive study material for the course', $subjectId, $classId, $staffId, '/uploads/materials/material_' . ($i + 1) . '.pdf', $materialTypes[$i % 5]]
        );
    }

    echo "📢 Seeding Notifications (30 records)...\n";
    $allUsers = $db->fetchAll("SELECT id FROM users LIMIT 30");
    foreach ($allUsers as $i => $user) {
        $db->execute(
            "INSERT INTO notifications (user_id, title, message, type, is_read, created_at) 
             VALUES (?, ?, ?, ?, ?, NOW())
             ON DUPLICATE KEY UPDATE user_id=user_id",
            [$user['id'], 'Notification ' . ($i + 1), 'This is notification message number ' . ($i + 1), ['info', 'warning', 'success', 'error'][$i % 4], $i % 3 == 0]
        );
    }

    echo "📊 Seeding Attendance (100 records)...\n";
    $studentRecords = $db->fetchAll("SELECT id, class_id FROM students LIMIT 50");
    foreach ($studentRecords as $student) {
        for ($day = 0; $day < 2; $day++) {
            $db->execute(
                "INSERT INTO attendance (student_id, class_id, attendance_date, status, created_at) 
                 VALUES (?, ?, ?, ?, NOW())
                 ON DUPLICATE KEY UPDATE student_id=student_id",
                [$student['id'], $student['class_id'], date('Y-m-d', strtotime('-' . $day . ' days')), ['present', 'absent', 'late'][$day % 3]]
            );
        }
    }

    $db->commit();
    
    echo "\n✅ Comprehensive data seeding completed successfully!\n";
    echo "📊 Summary:\n";
    echo "   - 20 Courses\n";
    echo "   - 15 Classes\n";
    echo "   - 30 Subjects\n";
    echo "   - 20 Staff Members\n";
    echo "   - 50 Students\n";
    echo "   - 30 Admissions\n";
    echo "   - 15 Exams\n";
    echo "   - 40 Invoices\n";
    echo "   - 25 Study Materials\n";
    echo "   - 30 Notifications\n";
    echo "   - 100 Attendance Records\n\n";
    echo "🎉 All data ready for testing!\n";

} catch (Exception $e) {
    $db->rollback();
    echo "\n❌ Seeding failed: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
    exit(1);
}
