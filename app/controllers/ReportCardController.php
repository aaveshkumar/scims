<?php

class ReportCardController
{
    public function index($request)
    {
        $classId = $request->get('class_id');
        $examId = $request->get('exam_id');
        
        // Fetch all classes
        $classes = db()->fetchAll(
            "SELECT id, name FROM classes ORDER BY name"
        );
        
        // Fetch all exams
        $exams = db()->fetchAll(
            "SELECT id, name, code, academic_year FROM exams ORDER BY start_date DESC LIMIT 20"
        );
        
        $reportCards = [];
        
        // If both class and exam are selected, fetch report cards
        if ($classId && $examId) {
            $reportCards = db()->fetchAll(
                "SELECT 
                    s.id as student_id,
                    s.admission_number,
                    u.first_name,
                    u.last_name,
                    c.name as class_name,
                    e.name as exam_name,
                    COUNT(DISTINCT m.id) as marks_count,
                    ROUND(AVG(CAST(m.marks_obtained AS DECIMAL) / NULLIF(CAST(m.total_marks AS DECIMAL), 0) * 100), 2) as percentage,
                    CASE 
                        WHEN AVG(CAST(m.marks_obtained AS DECIMAL) / NULLIF(CAST(m.total_marks AS DECIMAL), 0) * 100) >= 90 THEN 'A+'
                        WHEN AVG(CAST(m.marks_obtained AS DECIMAL) / NULLIF(CAST(m.total_marks AS DECIMAL), 0) * 100) >= 80 THEN 'A'
                        WHEN AVG(CAST(m.marks_obtained AS DECIMAL) / NULLIF(CAST(m.total_marks AS DECIMAL), 0) * 100) >= 70 THEN 'B+'
                        WHEN AVG(CAST(m.marks_obtained AS DECIMAL) / NULLIF(CAST(m.total_marks AS DECIMAL), 0) * 100) >= 60 THEN 'B'
                        WHEN AVG(CAST(m.marks_obtained AS DECIMAL) / NULLIF(CAST(m.total_marks AS DECIMAL), 0) * 100) >= 50 THEN 'C'
                        WHEN AVG(CAST(m.marks_obtained AS DECIMAL) / NULLIF(CAST(m.total_marks AS DECIMAL), 0) * 100) >= 40 THEN 'D'
                        ELSE 'F'
                    END as grade
                 FROM students s
                 INNER JOIN users u ON s.user_id = u.id
                 LEFT JOIN classes c ON s.class_id = c.id
                 LEFT JOIN exams e ON e.id = ?
                 LEFT JOIN marks m ON m.student_id = s.id AND m.exam_id = ?
                 WHERE s.status = 'active' AND s.class_id = ?
                 GROUP BY s.id, s.admission_number, u.first_name, u.last_name, c.name, e.name
                 ORDER BY u.last_name, u.first_name",
                [$examId, $examId, $classId]
            );
        }
        
        return view('report-cards/index', [
            'classes' => $classes,
            'exams' => $exams,
            'reportCards' => $reportCards,
            'selectedClassId' => $classId,
            'selectedExamId' => $examId
        ]);
    }

    public function printAll($request, $classId, $examId)
    {
        $class = db()->fetchOne("SELECT * FROM classes WHERE id = ?", [$classId]);
        $exam = db()->fetchOne("SELECT * FROM exams WHERE id = ?", [$examId]);

        if (!$class || !$exam) {
            flash('error', 'Class or exam not found');
            return redirect('/report-cards');
        }

        // Fetch all students with their marks and report card data
        $students = db()->fetchAll(
            "SELECT 
                s.id as student_id,
                s.admission_number,
                u.first_name,
                u.last_name,
                c.name as class_name
             FROM students s
             INNER JOIN users u ON s.user_id = u.id
             LEFT JOIN classes c ON s.class_id = c.id
             WHERE s.status = 'active' AND s.class_id = ?
             ORDER BY u.last_name, u.first_name",
            [$classId]
        );

        // Fetch marks for all students in this exam
        $allMarks = db()->fetchAll(
            "SELECT m.*, s.name as subject_name
             FROM marks m
             INNER JOIN subjects s ON m.subject_id = s.id
             WHERE m.exam_id = ? AND m.student_id IN (
                SELECT s.id FROM students s WHERE s.class_id = ? AND s.status = 'active'
             )
             ORDER BY m.student_id, s.name",
            [$examId, $classId]
        );

        // Group marks by student
        $marksByStudent = [];
        foreach ($allMarks as $mark) {
            if (!isset($marksByStudent[$mark['student_id']])) {
                $marksByStudent[$mark['student_id']] = [];
            }
            $marksByStudent[$mark['student_id']][] = $mark;
        }

        return view('report-cards/print-all', [
            'class' => $class,
            'exam' => $exam,
            'students' => $students,
            'marksByStudent' => $marksByStudent
        ]);
    }
}
