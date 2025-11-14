<?php

class Student extends Model
{
    protected $table = 'students';
    protected $fillable = [
        'user_id', 'admission_number', 'class_id', 'roll_number',
        'admission_date', 'guardian_name', 'guardian_phone', 'guardian_email',
        'guardian_relation', 'previous_school', 'blood_group',
        'medical_conditions', 'documents', 'status'
    ];

    public function user()
    {
        return $this->db->fetchOne(
            "SELECT * FROM users WHERE id = ?",
            [$this->user_id]
        );
    }

    public function class()
    {
        if (!$this->class_id) {
            return null;
        }

        return $this->db->fetchOne(
            "SELECT * FROM classes WHERE id = ?",
            [$this->class_id]
        );
    }

    public function attendance($startDate = null, $endDate = null)
    {
        $sql = "SELECT * FROM attendance WHERE student_id = ?";
        $params = [$this->id];

        if ($startDate && $endDate) {
            $sql .= " AND date BETWEEN ? AND ?";
            $params[] = $startDate;
            $params[] = $endDate;
        }

        $sql .= " ORDER BY date DESC";

        return $this->db->fetchAll($sql, $params);
    }

    public function marks($examId = null)
    {
        $sql = "SELECT m.*, e.name as exam_name, s.name as subject_name 
                FROM marks m 
                INNER JOIN exams e ON m.exam_id = e.id 
                INNER JOIN subjects s ON m.subject_id = s.id 
                WHERE m.student_id = ?";
        $params = [$this->id];

        if ($examId) {
            $sql .= " AND m.exam_id = ?";
            $params[] = $examId;
        }

        return $this->db->fetchAll($sql, $params);
    }

    public function invoices()
    {
        return $this->db->fetchAll(
            "SELECT * FROM invoices WHERE student_id = ? ORDER BY created_at DESC",
            [$this->id]
        );
    }

    public function getAttendancePercentage($startDate = null, $endDate = null)
    {
        $sql = "SELECT 
                COUNT(*) as total,
                SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) as present
                FROM attendance WHERE student_id = ?";
        $params = [$this->id];

        if ($startDate && $endDate) {
            $sql .= " AND date BETWEEN ? AND ?";
            $params[] = $startDate;
            $params[] = $endDate;
        }

        $result = $this->db->fetchOne($sql, $params);

        if ($result['total'] == 0) {
            return 0;
        }

        return round(($result['present'] / $result['total']) * 100, 2);
    }

    public function findByAdmissionNumber($admissionNumber)
    {
        return $this->where('admission_number', $admissionNumber)->first();
    }
}
