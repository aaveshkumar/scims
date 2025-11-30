<?php

class MarkController
{
    private $markModel;
    private $examModel;
    private $studentModel;
    private $subjectModel;

    public function __construct()
    {
        $this->markModel = new Mark();
        $this->examModel = new Exam();
        $this->studentModel = new Student();
        $this->subjectModel = new Subject();
    }

    public function index($request)
    {
        $examId = $request->get('exam_id');
        $classId = $request->get('class_id');
        
        if (!$examId) {
            $exams = db()->fetchAll(
                "SELECT e.*, c.name as class_name
                 FROM exams e
                 LEFT JOIN classes c ON e.class_id = c.id
                 ORDER BY e.start_date DESC
                 LIMIT 20"
            );
            return view('marks.select-exam', ['exams' => $exams]);
        }

        $exam = $this->examModel->find($examId);
        if (!$exam) {
            flash('error', 'Exam not found');
            return redirect('/marks');
        }

        // Get all classes with student count
        $classes = db()->fetchAll(
            "SELECT DISTINCT 
                c.id,
                c.name,
                COUNT(DISTINCT s.id) as student_count
             FROM classes c
             LEFT JOIN students s ON c.id = s.class_id AND s.status = 'active'
             GROUP BY c.id, c.name
             ORDER BY c.name"
        );

        $students = [];
        
        // If a class is selected, get students from that class
        if ($classId) {
            $students = db()->fetchAll(
                "SELECT DISTINCT 
                    s.id,
                    s.admission_number,
                    u.first_name,
                    u.last_name,
                    c.name as class_name,
                    COUNT(DISTINCT m.id) as marks_count,
                    ROUND(AVG(CAST(m.marks_obtained AS DECIMAL) / NULLIF(CAST(m.total_marks AS DECIMAL), 0) * 100), 2) as avg_percentage
                 FROM students s
                 INNER JOIN users u ON s.user_id = u.id
                 LEFT JOIN classes c ON s.class_id = c.id
                 LEFT JOIN marks m ON m.student_id = s.id AND m.exam_id = ?
                 WHERE s.status = 'active' AND s.class_id = ?
                 GROUP BY s.id, s.admission_number, u.first_name, u.last_name, c.name
                 ORDER BY u.last_name, u.first_name",
                [$examId, $classId]
            );
        }

        return view('marks.index', ['exam' => $exam, 'classes' => $classes, 'students' => $students, 'selectedClassId' => $classId]);
    }

    public function enter($request)
    {
        $examId = $request->get('exam_id');
        $studentId = $request->get('student_id');

        if (!$examId || !$studentId) {
            flash('error', 'Exam and student are required');
            return redirect('/marks');
        }

        $exam = $this->examModel->find($examId);
        $student = db()->fetchOne(
            "SELECT s.*, u.first_name, u.last_name FROM students s
             INNER JOIN users u ON s.user_id = u.id WHERE s.id = ?",
            [$studentId]
        );

        $subjects = $this->subjectModel->where('class_id', $student['class_id'])->get();
        
        // If no subjects found for this class, fetch all available subjects as fallback
        if (empty($subjects)) {
            $subjects = db()->fetchAll(
                "SELECT * FROM subjects ORDER BY name"
            );
        }

        $existingMarks = db()->fetchAll(
            "SELECT * FROM marks WHERE exam_id = ? AND student_id = ?",
            [$examId, $studentId]
        );

        $marksMap = [];
        foreach ($existingMarks as $mark) {
            $marksMap[$mark['subject_id']] = $mark;
        }

        return view('marks.enter', [
            'exam' => $exam,
            'student' => $student,
            'subjects' => $subjects,
            'marksMap' => $marksMap
        ]);
    }

    public function store($request)
    {
        // Handle JSON requests
        if ($request->method() === 'POST' && strpos($_SERVER['CONTENT_TYPE'] ?? '', 'application/json') !== false) {
            $input = json_decode(file_get_contents('php://input'), true);
            $examId = $input['exam_id'] ?? null;
            $studentId = $input['student_id'] ?? null;
            $marks = $input['marks'] ?? [];
        } else {
            $examId = $request->post('exam_id');
            $studentId = $request->post('student_id');
            $marks = $request->post('marks', []);
        }

        if (!$examId || !$studentId) {
            return responseJSON(['success' => false, 'message' => 'Missing required fields'], 400);
        }

        try {
            foreach ($marks as $subjectId => $data) {
                if (empty($data['marks_obtained'])) {
                    continue;
                }

                $existing = db()->fetchOne(
                    "SELECT id FROM marks WHERE exam_id = ? AND student_id = ? AND subject_id = ?",
                    [$examId, $studentId, $subjectId]
                );

                $marksObtained = $data['marks_obtained'];
                $totalMarks = $data['total_marks'];
                $grade = Exam::calculateGrade($marksObtained, $totalMarks);

                $markData = [
                    'marks_obtained' => $marksObtained,
                    'total_marks' => $totalMarks,
                    'grade' => $grade,
                    'remarks' => $data['remarks'] ?? null,
                    'entered_by' => auth()['id']
                ];

                if ($existing) {
                    $this->markModel->update($existing['id'], $markData);
                } else {
                    $markData['exam_id'] = $examId;
                    $markData['student_id'] = $studentId;
                    $markData['subject_id'] = $subjectId;
                    $this->markModel->create($markData);
                }
            }

            return responseJSON(['success' => true, 'message' => 'Marks entered successfully']);
        } catch (Exception $e) {
            return responseJSON(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function reportCard($request, $studentId, $examId)
    {
        $student = db()->fetchOne(
            "SELECT s.*, u.first_name, u.last_name, c.name as class_name
             FROM students s
             INNER JOIN users u ON s.user_id = u.id
             LEFT JOIN classes c ON s.class_id = c.id
             WHERE s.id = ?",
            [$studentId]
        );

        $exam = $this->examModel->find($examId);

        if (!$student || !$exam) {
            flash('error', 'Student or exam not found');
            return redirect('/marks');
        }

        $marks = $this->markModel->getStudentReportCard($studentId, $examId);

        $total = 0;
        $obtained = 0;
        foreach ($marks as $mark) {
            $total += $mark['total_marks'];
            $obtained += $mark['marks_obtained'];
        }

        $percentage = $total > 0 ? round(($obtained / $total) * 100, 2) : 0;

        return view('marks.report-card', [
            'student' => $student,
            'exam' => $exam,
            'marks' => $marks,
            'total' => $total,
            'obtained' => $obtained,
            'percentage' => $percentage
        ]);
    }
}
