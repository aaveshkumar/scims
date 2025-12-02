<?php

class StudentPortalController
{
    /**
     * Feature 1: Dashboard
     */
    public function dashboard($request)
    {
        $userId = auth()['id'];
        $student = db()->fetchOne(
            "SELECT s.*, c.name as class_name FROM students s 
             LEFT JOIN classes c ON s.class_id = c.id 
             WHERE s.user_id = ?",
            [$userId]
        );

        if (!$student) {
            flash('error', 'Student record not found');
            return redirect('/dashboard');
        }

        $attendance = db()->fetchOne(
            "SELECT COUNT(*) as total, 
             SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) as present 
             FROM attendance WHERE student_id = ?",
            [$student['id']]
        );

        $marks = db()->fetchAll(
            "SELECT m.*, e.name as exam_name, s.name as subject_name 
             FROM marks m 
             JOIN exams e ON m.exam_id = e.id 
             JOIN subjects s ON m.subject_id = s.id 
             WHERE m.student_id = ? ORDER BY m.created_at DESC LIMIT 5",
            [$student['id']]
        );

        $assignments = db()->fetchAll(
            "SELECT * FROM assignments WHERE class_id = ? AND due_date >= CURRENT_DATE 
             ORDER BY due_date ASC LIMIT 3",
            [$student['class_id']]
        );

        return view('student-portal/dashboard', [
            'title' => 'My Dashboard',
            'student' => $student,
            'attendance' => $attendance,
            'marks' => $marks,
            'assignments' => $assignments
        ]);
    }

    /**
     * Feature 2: Student Library - View Available Books
     */
    public function libraryBooks($request)
    {
        $search = $request->get('search');
        $category = $request->get('category');
        
        $sql = "SELECT * FROM books WHERE status = 'active' AND available_copies > 0";
        $params = [];

        if ($search) {
            $sql .= " AND (title LIKE ? OR author LIKE ?)";
            $searchTerm = "%{$search}%";
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }

        if ($category) {
            $sql .= " AND category = ?";
            $params[] = $category;
        }

        $sql .= " ORDER BY title ASC";

        $books = db()->fetchAll($sql, $params);
        $categories = db()->fetchAll("SELECT DISTINCT category FROM books WHERE category IS NOT NULL ORDER BY category");

        return view('student-portal/library-books', [
            'title' => 'Library - Available Books',
            'books' => $books,
            'categories' => $categories,
            'search' => $search,
            'category' => $category
        ]);
    }

    /**
     * Feature 2b: My Borrowed Books
     */
    public function myBorrowedBooks($request)
    {
        $userId = auth()['id'];
        
        $borrowed = db()->fetchAll(
            "SELECT bi.*, b.title, b.author, b.isbn 
             FROM book_issues bi 
             JOIN books b ON bi.book_id = b.id 
             WHERE bi.user_id = ? AND bi.status = 'issued' 
             ORDER BY bi.due_date ASC",
            [$userId]
        );

        $returned = db()->fetchAll(
            "SELECT bi.*, b.title, b.author 
             FROM book_issues bi 
             JOIN books b ON bi.book_id = b.id 
             WHERE bi.user_id = ? AND bi.status = 'returned' 
             ORDER BY bi.return_date DESC LIMIT 10",
            [$userId]
        );

        return view('student-portal/my-borrowed-books', [
            'title' => 'My Borrowed Books',
            'borrowed' => $borrowed,
            'returned' => $returned
        ]);
    }

    /**
     * Feature 2c: Request Book
     */
    public function requestBook($request)
    {
        if ($request->getMethod() === 'POST') {
            $book_id = $request->post('book_id');
            $userId = auth()['id'];

            $existing = db()->fetchOne(
                "SELECT * FROM book_issues WHERE user_id = ? AND book_id = ? AND status = 'requested'",
                [$userId, $book_id]
            );

            if ($existing) {
                flash('error', 'You have already requested this book');
                return back();
            }

            try {
                db()->execute(
                    "INSERT INTO book_issues (book_id, user_id, status, created_at, updated_at) 
                     VALUES (?, ?, 'requested', NOW(), NOW())",
                    [$book_id, $userId]
                );
                flash('success', 'Book request submitted successfully');
                return back();
            } catch (Exception $e) {
                flash('error', 'Failed to request book: ' . $e->getMessage());
                return back();
            }
        }
    }

    /**
     * Feature 3: My Marks/Grades
     */
    public function myMarks($request)
    {
        $userId = auth()['id'];
        $student = db()->fetchOne("SELECT id FROM students WHERE user_id = ?", [$userId]);

        if (!$student) {
            flash('error', 'Student record not found');
            return redirect('/dashboard');
        }

        $exams = db()->fetchAll(
            "SELECT DISTINCT e.* FROM exams e 
             JOIN marks m ON e.id = m.exam_id 
             WHERE m.student_id = ? 
             ORDER BY e.date DESC",
            [$student['id']]
        );

        $selectedExamId = $request->get('exam_id') ?? ($exams[0]['id'] ?? null);

        $marks = db()->fetchAll(
            "SELECT m.*, s.name as subject_name FROM marks m 
             JOIN subjects s ON m.subject_id = s.id 
             WHERE m.student_id = ? AND m.exam_id = ? 
             ORDER BY s.name ASC",
            [$student['id'], $selectedExamId]
        );

        return view('student-portal/my-marks', [
            'title' => 'My Marks & Grades',
            'marks' => $marks,
            'exams' => $exams,
            'selectedExamId' => $selectedExamId
        ]);
    }

    /**
     * Feature 4: Attendance History
     */
    public function attendanceHistory($request)
    {
        $userId = auth()['id'];
        $student = db()->fetchOne("SELECT id FROM students WHERE user_id = ?", [$userId]);

        if (!$student) {
            flash('error', 'Student record not found');
            return redirect('/dashboard');
        }

        $attendance = db()->fetchAll(
            "SELECT * FROM attendance WHERE student_id = ? ORDER BY date DESC",
            [$student['id']]
        );

        $stats = db()->fetchOne(
            "SELECT 
             COUNT(*) as total,
             SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) as present,
             SUM(CASE WHEN status = 'absent' THEN 1 ELSE 0 END) as absent,
             SUM(CASE WHEN status = 'leave' THEN 1 ELSE 0 END) as leave
             FROM attendance WHERE student_id = ?",
            [$student['id']]
        );

        $percentage = $stats['total'] > 0 ? round(($stats['present'] / $stats['total']) * 100, 2) : 0;

        return view('student-portal/attendance-history', [
            'title' => 'Attendance History',
            'attendance' => $attendance,
            'stats' => $stats,
            'percentage' => $percentage
        ]);
    }

    /**
     * Feature 5: Fee Information
     */
    public function feeInformation($request)
    {
        $userId = auth()['id'];
        $student = db()->fetchOne("SELECT id FROM students WHERE user_id = ?", [$userId]);

        if (!$student) {
            flash('error', 'Student record not found');
            return redirect('/dashboard');
        }

        $invoices = db()->fetchAll(
            "SELECT i.*, fs.amount as fee_amount FROM invoices i 
             JOIN fee_structures fs ON i.fee_structure_id = fs.id 
             WHERE i.student_id = ? 
             ORDER BY i.created_at DESC",
            [$student['id']]
        );

        $summary = db()->fetchOne(
            "SELECT 
             COUNT(*) as total_invoices,
             SUM(CASE WHEN status = 'paid' THEN 1 ELSE 0 END) as paid_count,
             SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending_count,
             SUM(CASE WHEN status = 'paid' THEN amount ELSE 0 END) as total_paid,
             SUM(CASE WHEN status = 'pending' THEN amount ELSE 0 END) as total_pending
             FROM invoices WHERE student_id = ?",
            [$student['id']]
        );

        return view('student-portal/fee-information', [
            'title' => 'Fee Information',
            'invoices' => $invoices,
            'summary' => $summary
        ]);
    }
}
