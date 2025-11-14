<?php

class AttendanceController
{
    private $attendanceModel;
    private $classModel;
    private $studentModel;

    public function __construct()
    {
        $this->attendanceModel = new Attendance();
        $this->classModel = new ClassModel();
        $this->studentModel = new Student();
    }

    public function index($request)
    {
        $classes = $this->classModel->where('status', 'active')->get();
        return view('attendance.index', ['classes' => $classes]);
    }

    public function mark($request)
    {
        $classId = $request->get('class_id');
        $date = $request->get('date', date('Y-m-d'));

        if (!$classId) {
            flash('error', 'Please select a class');
            return redirect('/attendance');
        }

        $class = $this->classModel->find($classId);
        if (!$class) {
            flash('error', 'Class not found');
            return redirect('/attendance');
        }

        $students = db()->fetchAll(
            "SELECT s.id, s.admission_number, s.roll_number, u.first_name, u.last_name,
                    a.status as attendance_status
             FROM students s
             INNER JOIN users u ON s.user_id = u.id
             LEFT JOIN attendance a ON s.id = a.student_id 
                    AND a.class_id = ? AND a.date = ? AND a.period IS NULL
             WHERE s.class_id = ? AND s.status = 'active'
             ORDER BY s.roll_number",
            [$classId, $date, $classId]
        );

        return view('attendance.mark', [
            'class' => $class,
            'students' => $students,
            'date' => $date
        ]);
    }

    public function store($request)
    {
        $classId = $request->post('class_id');
        $date = $request->post('date');
        $attendance = $request->post('attendance', []);

        if (!$classId || !$date) {
            return responseJSON(['success' => false, 'message' => 'Class and date are required'], 400);
        }

        try {
            db()->execute(
                "DELETE FROM attendance WHERE class_id = ? AND date = ? AND period IS NULL",
                [$classId, $date]
            );

            foreach ($attendance as $studentId => $status) {
                $this->attendanceModel->create([
                    'student_id' => $studentId,
                    'class_id' => $classId,
                    'date' => $date,
                    'status' => $status,
                    'marked_by' => auth()['id']
                ]);
            }

            return responseJSON(['success' => true, 'message' => 'Attendance marked successfully']);
        } catch (Exception $e) {
            return responseJSON(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function report($request)
    {
        $studentId = $request->get('student_id');
        $startDate = $request->get('start_date', date('Y-m-01'));
        $endDate = $request->get('end_date', date('Y-m-t'));

        if (!$studentId) {
            flash('error', 'Please select a student');
            return back();
        }

        $student = db()->fetchOne(
            "SELECT s.*, u.first_name, u.last_name, c.name as class_name
             FROM students s
             INNER JOIN users u ON s.user_id = u.id
             LEFT JOIN classes c ON s.class_id = c.id
             WHERE s.id = ?",
            [$studentId]
        );

        $attendance = $this->attendanceModel->getStudentAttendanceReport($studentId, $startDate, $endDate);

        $stats = db()->fetchOne(
            "SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) as present,
                SUM(CASE WHEN status = 'absent' THEN 1 ELSE 0 END) as absent,
                SUM(CASE WHEN status = 'late' THEN 1 ELSE 0 END) as late
             FROM attendance
             WHERE student_id = ? AND date BETWEEN ? AND ?",
            [$studentId, $startDate, $endDate]
        );

        return view('attendance.report', [
            'student' => $student,
            'attendance' => $attendance,
            'stats' => $stats,
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);
    }
}
