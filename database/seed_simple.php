<?php

require __DIR__ . '/../bootstrap.php';

echo "Adding dummy data to tables...\n\n";

try {
    $admin = db()->fetchOne("SELECT id FROM users WHERE email = 'admin@school.com'");
    $adminId = $admin['id'];
    
    //Already done - Courses, Classes, Subjects, Students (with user accounts)
    
    // Seed Invoices
    echo "Seeding Invoices...\n";
    $students = db()->fetchAll("SELECT id FROM students LIMIT 5");
    if (!empty($students) && count(db()->fetchAll("SELECT id FROM invoices LIMIT 1")) == 0) {
        foreach ($students as $i => $student) {
            db()->execute(
                "INSERT INTO invoices (invoice_number, student_id, amount, due_date, status, created_at) VALUES (?, ?, ?, ?, ?, NOW())",
                ['INV2024' . str_pad($i+1, 4, '0', STR_PAD_LEFT), $student['id'], (50000 + ($i * 10000)), '2024-12-31', ($i % 2 == 0 ? 'paid' : 'pending')]
            );
        }
        echo "✅ Created 5 invoices\n";
    } else {
        echo "ℹ️  Invoices already exist or no students found\n";
    }
    
    // Seed Timetables
    echo "Seeding Timetables...\n";
    $classes = db()->fetchAll("SELECT id FROM classes LIMIT 5");
    $subjects = db()->fetchAll("SELECT id FROM subjects LIMIT 5");
    if (!empty($classes) && !empty($subjects) && count(db()->fetchAll("SELECT id FROM timetables LIMIT 1")) == 0) {
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        foreach ($classes as $i => $class) {
            $subjectId = $subjects[$i % count($subjects)]['id'];
            db()->execute(
                "INSERT INTO timetables (class_id, subject_id, day_of_week, start_time, end_time, room_number, created_at) VALUES (?, ?, ?, ?, ?, ?, NOW())",
                [$class['id'], $subjectId, $days[$i], '09:00:00', '10:00:00', 'Room ' . ($i + 101)]
            );
        }
        echo "✅ Created 5 timetable entries\n";
    } else {
        echo "ℹ️  Timetables already exist or missing dependencies\n";
    }
    
    // Seed Attendance
    echo "Seeding Attendance...\n";
    if (!empty($students) && !empty($classes) && count(db()->fetchAll("SELECT id FROM attendance LIMIT 1")) == 0) {
        foreach ($students as $i => $student) {
            db()->execute(
                "INSERT INTO attendance (student_id, class_id, date, status, created_at) VALUES (?, ?, ?, ?, NOW())",
                [$student['id'], $classes[0]['id'], date('Y-m-d'), ($i % 2 == 0 ? 'present' : 'absent')]
            );
        }
        echo "✅ Created 5 attendance records\n";
    } else {
        echo "ℹ️  Attendance already exists or missing dependencies\n";
    }
    
    // Seed Marks
    echo "Seeding Marks...\n";
    $exams = db()->fetchAll("SELECT id FROM exams LIMIT 5");
    if (!empty($students) && !empty($exams) && !empty($subjects) && count(db()->fetchAll("SELECT id FROM marks LIMIT 1")) == 0) {
        foreach ($students as $i => $student) {
            $examId = $exams[$i % count($exams)]['id'];
            $subjectId = $subjects[$i % count($subjects)]['id'];
            db()->execute(
                "INSERT INTO marks (student_id, exam_id, subject_id, marks_obtained, total_marks, created_at) VALUES (?, ?, ?, ?, 100, NOW())",
                [$student['id'], $examId, $subjectId, (70 + ($i * 5))]
            );
        }
        echo "✅ Created 5 marks records\n";
    } else {
        echo "ℹ️  Marks already exist or missing dependencies\n";
    }
    
    echo "\n✅ Seeding completed!\n";
    echo "\nFinal Summary:\n";
    echo "- Courses: " . count(db()->fetchAll("SELECT id FROM courses")) . "\n";
    echo "- Classes: " . count(db()->fetchAll("SELECT id FROM classes")) . "\n";
    echo "- Subjects: " . count(db()->fetchAll("SELECT id FROM subjects")) . "\n";
    echo "- Students: " . count(db()->fetchAll("SELECT id FROM students")) . "\n";
    echo "- Admissions: " . count(db()->fetchAll("SELECT id FROM admissions")) . "\n";
    echo "- Exams: " . count(db()->fetchAll("SELECT id FROM exams")) . "\n";
    echo "- Books: " . count(db()->fetchAll("SELECT id FROM books")) . "\n";
    echo "- Invoices: " . count(db()->fetchAll("SELECT id FROM invoices")) . "\n";
    echo "- Timetables: " . count(db()->fetchAll("SELECT id FROM timetables")) . "\n";
    echo "- Attendance: " . count(db()->fetchAll("SELECT id FROM attendance")) . "\n";
    echo "- Marks: " . count(db()->fetchAll("SELECT id FROM marks")) . "\n";
    echo "- Materials: " . count(db()->fetchAll("SELECT id FROM materials")) . "\n";
    
} catch (Exception $e) {
    echo "\n❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
