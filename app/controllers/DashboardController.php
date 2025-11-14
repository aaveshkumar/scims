<?php

class DashboardController
{
    public function index($request)
    {
        $user = auth();
        
        $stats = [];

        if (hasRole('admin')) {
            $stats = $this->getAdminStats();
        } elseif (hasRole('teacher')) {
            $stats = $this->getTeacherStats($user['id']);
        } elseif (hasRole('student')) {
            $stats = $this->getStudentStats($user['id']);
        }

        return view('dashboard.index', ['stats' => $stats, 'user' => $user]);
    }

    private function getAdminStats()
    {
        $studentModel = new Student();
        $staffModel = new Staff();
        $classModel = new ClassModel();
        $admissionModel = new Admission();

        return [
            'total_students' => $studentModel->count(),
            'total_staff' => $staffModel->count(),
            'total_classes' => $classModel->count(),
            'pending_admissions' => $admissionModel->where('status', 'pending')->count(),
        ];
    }

    private function getTeacherStats($userId)
    {
        $subjectModel = new Subject();
        $attendanceModel = new Attendance();

        return [
            'my_subjects' => $subjectModel->where('teacher_id', $userId)->count(),
            'today_attendance' => $attendanceModel
                ->where('marked_by', $userId)
                ->where('date', date('Y-m-d'))
                ->count(),
        ];
    }

    private function getStudentStats($userId)
    {
        $studentModel = new Student();
        $student = $studentModel->where('user_id', $userId)->first();

        if (!$student) {
            return [];
        }

        $attendancePercentage = (new Student())->getAttendancePercentage();

        return [
            'attendance_percentage' => $attendancePercentage,
            'admission_number' => $student['admission_number'],
        ];
    }
}
