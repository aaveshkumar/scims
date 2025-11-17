<?php

require __DIR__ . '/../bootstrap.php';

echo "Starting comprehensive database seeding...\n\n";

try {
    // Get existing admin user
    $admin = db()->fetchOne("SELECT id FROM users WHERE email = 'admin@school.com'");
    if (!$admin) {
        echo "❌ Admin user not found. Please run seed.php first.\n";
        exit(1);
    }
    $adminId = $admin['id'];
    
    // Get student role
    $studentRole = db()->fetchOne("SELECT id FROM roles WHERE name = 'student'");
    $studentRoleId = $studentRole['id'];
    
    // 1. Seed Courses
    echo "Seeding Courses...\n";
    $existingCourses = db()->fetchAll("SELECT id FROM courses LIMIT 1");
    if (empty($existingCourses)) {
        $courses = [
            ['name' => 'Bachelor of Science', 'code' => 'BSC', 'description' => 'Undergraduate science program', 'duration_years' => 3],
            ['name' => 'Bachelor of Arts', 'code' => 'BA', 'description' => 'Undergraduate arts program', 'duration_years' => 3],
            ['name' => 'Master of Business Administration', 'code' => 'MBA', 'description' => 'Postgraduate business program', 'duration_years' => 2],
            ['name' => 'Bachelor of Engineering', 'code' => 'BE', 'description' => 'Undergraduate engineering program', 'duration_years' => 4],
            ['name' => 'Bachelor of Commerce', 'code' => 'BCOM', 'description' => 'Undergraduate commerce program', 'duration_years' => 3]
        ];
        
        foreach ($courses as $course) {
            db()->execute(
                "INSERT INTO courses (name, code, description, duration_years, status, created_at) VALUES (?, ?, ?, ?, 'active', NOW())",
                [$course['name'], $course['code'], $course['description'], $course['duration_years']]
            );
        }
        echo "✅ Created 5 courses\n";
    } else {
        echo "ℹ️  Courses already exist\n";
    }
    
    // Get course IDs
    $courseIds = db()->fetchAll("SELECT id FROM courses LIMIT 5");
    
    // 2. Seed Classes
    echo "Seeding Classes...\n";
    $existingClasses = db()->fetchAll("SELECT id FROM classes LIMIT 1");
    if (empty($existingClasses)) {
        $classes = [
            ['name' => 'Grade 10', 'code' => 'GR10-A', 'section' => 'A', 'academic_year' => '2024', 'capacity' => 40, 'room_number' => 'Room 101'],
            ['name' => 'Grade 11', 'code' => 'GR11-A', 'section' => 'A', 'academic_year' => '2024', 'capacity' => 35, 'room_number' => 'Room 102'],
            ['name' => 'Grade 12', 'code' => 'GR12-A', 'section' => 'A', 'academic_year' => '2024', 'capacity' => 30, 'room_number' => 'Room 103'],
            ['name' => 'BSC Year 1', 'code' => 'BSC-Y1', 'section' => 'General', 'academic_year' => '2024', 'capacity' => 50, 'room_number' => 'Hall A'],
            ['name' => 'MBA Year 1', 'code' => 'MBA-Y1', 'section' => 'Executive', 'academic_year' => '2024', 'capacity' => 25, 'room_number' => 'Hall B']
        ];
        
        foreach ($classes as $i => $class) {
            $courseId = $courseIds[$i]['id'] ?? null;
            db()->execute(
                "INSERT INTO classes (name, code, course_id, section, academic_year, capacity, room_number, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, 'active', NOW())",
                [$class['name'], $class['code'], $courseId, $class['section'], $class['academic_year'], $class['capacity'], $class['room_number']]
            );
        }
        echo "✅ Created 5 classes\n";
    } else {
        echo "ℹ️  Classes already exist\n";
    }
    
    // Get class IDs
    $classIds = db()->fetchAll("SELECT id FROM classes LIMIT 5");
    
    // 3. Seed Subjects
    echo "Seeding Subjects...\n";
    $existingSubjects = db()->fetchAll("SELECT id FROM subjects LIMIT 1");
    if (empty($existingSubjects)) {
        $subjects = [
            ['name' => 'Mathematics', 'code' => 'MATH101', 'description' => 'Basic Mathematics', 'credits' => 4],
            ['name' => 'Physics', 'code' => 'PHY101', 'description' => 'Introduction to Physics', 'credits' => 4],
            ['name' => 'Chemistry', 'code' => 'CHEM101', 'description' => 'General Chemistry', 'credits' => 4],
            ['name' => 'English Literature', 'code' => 'ENG101', 'description' => 'Classic Literature', 'credits' => 3],
            ['name' => 'Computer Science', 'code' => 'CS101', 'description' => 'Programming Fundamentals', 'credits' => 4]
        ];
        
        foreach ($subjects as $subject) {
            db()->execute(
                "INSERT INTO subjects (name, code, description, credits, status, created_at) VALUES (?, ?, ?, ?, 'active', NOW())",
                [$subject['name'], $subject['code'], $subject['description'], $subject['credits']]
            );
        }
        echo "✅ Created 5 subjects\n";
    } else {
        echo "ℹ️  Subjects already exist\n";
    }
    
    // 4. Seed Students with User Accounts
    echo "Seeding Students...\n";
    $existingStudents = db()->fetchAll("SELECT id FROM students LIMIT 1");
    if (empty($existingStudents)) {
        $students = [
            ['name' => 'John Doe', 'email' => 'john.doe@student.com', 'phone' => '1234567890', 'dob' => '2005-05-15'],
            ['name' => 'Jane Smith', 'email' => 'jane.smith@student.com', 'phone' => '1234567891', 'dob' => '2005-08-20'],
            ['name' => 'Mike Johnson', 'email' => 'mike.j@student.com', 'phone' => '1234567892', 'dob' => '2004-12-10'],
            ['name' => 'Sarah Williams', 'email' => 'sarah.w@student.com', 'phone' => '1234567893', 'dob' => '2005-03-25'],
            ['name' => 'David Brown', 'email' => 'david.b@student.com', 'phone' => '1234567894', 'dob' => '2004-11-05']
        ];
        
        foreach ($students as $i => $student) {
            $classId = $classIds[$i % count($classIds)]['id'];
            $firstName = explode(' ', $student['name'])[0];
            $lastName = explode(' ', $student['name'])[1] ?? '';
            
            // Create user account
            db()->execute(
                "INSERT INTO users (first_name, last_name, email, phone, password, status, created_at) VALUES (?, ?, ?, ?, ?, 'active', NOW())",
                [$firstName, $lastName, $student['email'], $student['phone'], password_hash('student123', PASSWORD_BCRYPT)]
            );
            $userId = db()->lastInsertId();
            
            // Assign student role
            db()->execute(
                "INSERT INTO user_roles (user_id, role_id) VALUES (?, ?)",
                [$userId, $studentRoleId]
            );
            
            // Create student record
            $admissionNo = 'STU2024' . str_pad($i + 1, 3, '0', STR_PAD_LEFT);
            db()->execute(
                "INSERT INTO students (user_id, admission_number, class_id, roll_number, admission_date, guardian_name, guardian_phone, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, 'active', NOW())",
                [$userId, $admissionNo, $classId, 'ROLL' . ($i + 1), '2024-01-15', 'Parent ' . $firstName, '9' . $student['phone'], ]
            );
        }
        echo "✅ Created 5 students with user accounts\n";
    } else {
        echo "ℹ️  Students already exist\n";
    }
    
    // 5. Seed Staff
    echo "Seeding Staff...\n";
    $existingStaff = db()->fetchAll("SELECT id FROM staff LIMIT 1");
    if (empty($existingStaff)) {
        $staffMembers = [
            ['employee_id' => 'EMP001', 'name' => 'Dr. Robert Johnson', 'email' => 'robert.j@school.com', 'phone' => '9876543210', 'designation' => 'Principal'],
            ['employee_id' => 'EMP002', 'name' => 'Prof. Emily Davis', 'email' => 'emily.d@school.com', 'phone' => '9876543211', 'designation' => 'Professor'],
            ['employee_id' => 'EMP003', 'name' => 'Mr. James Wilson', 'email' => 'james.w@school.com', 'phone' => '9876543212', 'designation' => 'Teacher'],
            ['employee_id' => 'EMP004', 'name' => 'Ms. Lisa Anderson', 'email' => 'lisa.a@school.com', 'phone' => '9876543213', 'designation' => 'Teacher'],
            ['employee_id' => 'EMP005', 'name' => 'Dr. Mark Taylor', 'email' => 'mark.t@school.com', 'phone' => '9876543214', 'designation' => 'HOD']
        ];
        
        foreach ($staffMembers as $staff) {
            $cleanName = str_replace(['Dr. ', 'Prof. ', 'Mr. ', 'Ms. '], '', $staff['name']);
            $firstName = explode(' ', $cleanName)[0];
            $lastName = explode(' ', $cleanName)[1] ?? '';
            
            db()->execute(
                "INSERT INTO staff (employee_id, first_name, last_name, email, phone, designation, qualification, status, created_at) VALUES (?, ?, ?, ?, ?, ?, 'PhD', 'active', NOW())",
                [$staff['employee_id'], $firstName, $lastName, $staff['email'], $staff['phone'], $staff['designation']]
            );
        }
        echo "✅ Created 5 staff members\n";
    } else {
        echo "ℹ️  Staff already exist\n";
    }
    
    // 6. Seed Admissions
    echo "Seeding Admissions...\n";
    $existingAdmissions = db()->fetchAll("SELECT id FROM admissions LIMIT 1");
    if (empty($existingAdmissions)) {
        $admissions = [
            ['name' => 'Alice Cooper', 'email' => 'alice@example.com', 'phone' => '5551234567', 'dob' => '2006-07-10', 'status' => 'pending'],
            ['name' => 'Bob Martin', 'email' => 'bob@example.com', 'phone' => '5551234568', 'dob' => '2006-09-15', 'status' => 'approved'],
            ['name' => 'Carol White', 'email' => 'carol@example.com', 'phone' => '5551234569', 'dob' => '2006-02-20', 'status' => 'waitlist'],
            ['name' => 'Dan Green', 'email' => 'dan@example.com', 'phone' => '5551234570', 'dob' => '2005-11-25', 'status' => 'pending'],
            ['name' => 'Eve Black', 'email' => 'eve@example.com', 'phone' => '5551234571', 'dob' => '2006-04-30', 'status' => 'rejected']
        ];
        
        foreach ($admissions as $i => $admission) {
            $courseId = $courseIds[$i % count($courseIds)]['id'];
            $firstName = explode(' ', $admission['name'])[0];
            $lastName = explode(' ', $admission['name'])[1] ?? '';
            
            db()->execute(
                "INSERT INTO admissions (application_number, first_name, last_name, email, phone, date_of_birth, course_id, guardian_name, guardian_phone, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())",
                ['APP'.date('Y').str_pad($i+1, 4, '0', STR_PAD_LEFT), $firstName, $lastName, $admission['email'], $admission['phone'], $admission['dob'], $courseId, 'Guardian ' . $firstName, '9' . $admission['phone'], $admission['status']]
            );
        }
        echo "✅ Created 5 admissions\n";
    } else {
        echo "ℹ️  Admissions already exist\n";
    }
    
    // 7. Seed Exams
    echo "Seeding Exams...\n";
    $existingExams = db()->fetchAll("SELECT id FROM exams LIMIT 1");
    if (empty($existingExams)) {
        $exams = [
            ['name' => 'Mid-Term Exam 2024', 'exam_date' => '2024-11-25', 'max_marks' => 100],
            ['name' => 'Final Exam 2024', 'exam_date' => '2024-12-15', 'max_marks' => 100],
            ['name' => 'Unit Test 1', 'exam_date' => '2024-11-10', 'max_marks' => 50],
            ['name' => 'Unit Test 2', 'exam_date' => '2024-12-05', 'max_marks' => 50],
            ['name' => 'Practical Exam', 'exam_date' => '2024-12-20', 'max_marks' => 100]
        ];
        
        foreach ($exams as $i => $exam) {
            $classId = $classIds[$i % count($classIds)]['id'];
            db()->execute(
                "INSERT INTO exams (name, class_id, exam_date, max_marks, created_at) VALUES (?, ?, ?, ?, NOW())",
                [$exam['name'], $classId, $exam['exam_date'], $exam['max_marks']]
            );
        }
        echo "✅ Created 5 exams\n";
    } else {
        echo "ℹ️  Exams already exist\n";
    }
    
    // 8. Seed Library Books
    echo "Seeding Library Books...\n";
    $existingBooks = db()->fetchAll("SELECT id FROM books LIMIT 1");
    if (empty($existingBooks)) {
        $books = [
            ['title' => 'Introduction to Algorithms', 'isbn' => '978-0-262-03384-8', 'author' => 'Cormen, Leiserson', 'quantity' => 10],
            ['title' => 'Clean Code', 'isbn' => '978-0-132-35088-4', 'author' => 'Robert C. Martin', 'quantity' => 8],
            ['title' => 'The Pragmatic Programmer', 'isbn' => '978-0-135-95705-9', 'author' => 'Hunt, Thomas', 'quantity' => 6],
            ['title' => 'Design Patterns', 'isbn' => '978-0-201-63361-0', 'author' => 'Gamma et al', 'quantity' => 5],
            ['title' => 'Code Complete', 'isbn' => '978-0-735-61967-8', 'author' => 'Steve McConnell', 'quantity' => 7]
        ];
        
        foreach ($books as $book) {
            db()->execute(
                "INSERT INTO books (title, isbn, author, publisher, quantity, available_quantity, status, created_at) VALUES (?, ?, ?, 'Tech Publishers', ?, ?, 'available', NOW())",
                [$book['title'], $book['isbn'], $book['author'], $book['quantity'], $book['quantity']]
            );
        }
        echo "✅ Created 5 library books\n";
    } else {
        echo "ℹ️  Books already exist\n";
    }
    
    // 9. Seed Fee Structures
    echo "Seeding Fee Structures...\n";
    $existingFees = db()->fetchAll("SELECT id FROM fees_structures LIMIT 1");
    if (empty($existingFees)) {
        $feeStructures = [
            ['fee_type' => 'Tuition Fee', 'amount' => 50000.00],
            ['fee_type' => 'Tuition Fee', 'amount' => 55000.00],
            ['fee_type' => 'Tuition Fee', 'amount' => 60000.00],
            ['fee_type' => 'Tuition Fee', 'amount' => 80000.00],
            ['fee_type' => 'Tuition Fee', 'amount' => 150000.00]
        ];
        
        foreach ($feeStructures as $i => $fee) {
            $classId = $classIds[$i % count($classIds)]['id'];
            db()->execute(
                "INSERT INTO fees_structures (class_id, fee_type, amount, academic_year, created_at) VALUES (?, ?, ?, '2024', NOW())",
                [$classId, $fee['fee_type'], $fee['amount']]
            );
        }
        echo "✅ Created 5 fee structures\n";
    } else {
        echo "ℹ️  Fee structures already exist\n";
    }
    
    // 10. Seed Materials
    echo "Seeding Study Materials...\n";
    $existingMaterials = db()->fetchAll("SELECT id FROM materials LIMIT 1");
    if (empty($existingMaterials)) {
        $materials = [
            ['title' => 'Mathematics Chapter 1 Notes', 'type' => 'notes', 'description' => 'Introduction to Calculus'],
            ['title' => 'Physics Lab Manual', 'type' => 'manual', 'description' => 'Practical experiments guide'],
            ['title' => 'Chemistry Assignment 1', 'type' => 'assignment', 'description' => 'Chemical bonding problems'],
            ['title' => 'English Essay Topics', 'type' => 'notes', 'description' => 'Essay writing guidelines'],
            ['title' => 'CS Programming Examples', 'type' => 'code', 'description' => 'Python code samples']
        ];
        
        foreach ($materials as $i => $material) {
            $classId = $classIds[$i % count($classIds)]['id'];
            db()->execute(
                "INSERT INTO materials (title, description, file_path, file_type, class_id, uploaded_by, created_at) VALUES (?, ?, '/uploads/dummy.pdf', 'pdf', ?, ?, NOW())",
                [$material['title'], $material['description'], $classId, $adminId]
            );
        }
        echo "✅ Created 5 study materials\n";
    } else {
        echo "ℹ️  Study materials already exist\n";
    }
    
    echo "\n✅ Database seeding completed successfully!\n";
    echo "\nSummary:\n";
    echo "- Courses: " . count(db()->fetchAll("SELECT id FROM courses")) . "\n";
    echo "- Classes: " . count(db()->fetchAll("SELECT id FROM classes")) . "\n";
    echo "- Subjects: " . count(db()->fetchAll("SELECT id FROM subjects")) . "\n";
    echo "- Students: " . count(db()->fetchAll("SELECT id FROM students")) . "\n";
    echo "- Staff: " . count(db()->fetchAll("SELECT id FROM staff")) . "\n";
    echo "- Admissions: " . count(db()->fetchAll("SELECT id FROM admissions")) . "\n";
    echo "- Exams: " . count(db()->fetchAll("SELECT id FROM exams")) . "\n";
    echo "- Books: " . count(db()->fetchAll("SELECT id FROM books")) . "\n";
    echo "- Fee Structures: " . count(db()->fetchAll("SELECT id FROM fees_structures")) . "\n";
    echo "- Materials: " . count(db()->fetchAll("SELECT id FROM materials")) . "\n";
    
} catch (Exception $e) {
    echo "\n❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
    exit(1);
}
