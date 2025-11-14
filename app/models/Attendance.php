<?php

class Attendance extends Model
{
    protected $table = 'attendance';
    protected $fillable = [
        'student_id', 'class_id', 'subject_id', 'date', 'period',
        'status', 'remarks', 'marked_by'
    ];

    public function student()
    {
        return $this->db->fetchOne(
            "SELECT s.*, u.first_name, u.last_name 
             FROM students s 
             INNER JOIN users u ON s.user_id = u.id 
             WHERE s.id = ?",
            [$this->student_id]
        );
    }

    public function markAttendance($studentId, $classId, $date, $status, $subjectId = null, $period = null, $markedBy = null)
    {
        $data = [
            'student_id' => $studentId,
            'class_id' => $classId,
            'date' => $date,
            'status' => $status,
            'marked_by' => $markedBy
        ];

        if ($subjectId) {
            $data['subject_id'] = $subjectId;
        }

        if ($period) {
            $data['period'] = $period;
        }

        return $this->create($data);
    }

    public function getClassAttendance($classId, $date)
    {
        return $this->db->fetchAll(
            "SELECT a.*, s.admission_number, u.first_name, u.last_name
             FROM attendance a
             INNER JOIN students s ON a.student_id = s.id
             INNER JOIN users u ON s.user_id = u.id
             WHERE a.class_id = ? AND a.date = ?",
            [$classId, $date]
        );
    }

    public function getStudentAttendanceReport($studentId, $startDate, $endDate)
    {
        return $this->db->fetchAll(
            "SELECT a.*, s.name as subject_name
             FROM attendance a
             LEFT JOIN subjects s ON a.subject_id = s.id
             WHERE a.student_id = ? AND a.date BETWEEN ? AND ?
             ORDER BY a.date DESC",
            [$studentId, $startDate, $endDate]
        );
    }
}
