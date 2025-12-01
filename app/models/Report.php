<?php

class Report
{
    protected $db;

    public function __construct()
    {
        $this->db = \Database::getInstance();
    }

    public function getAttendanceRecords()
    {
        $stmt = $this->db->prepare("
            SELECT a.*, u.first_name, u.last_name, c.name as class_name
            FROM attendance a
            LEFT JOIN users u ON a.student_id = u.id
            LEFT JOIN classes c ON a.class_id = c.id
            ORDER BY a.date DESC LIMIT 100
        ");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAttendanceSummary()
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as total, 
                   SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) as present,
                   SUM(CASE WHEN status = 'absent' THEN 1 ELSE 0 END) as absent,
                   SUM(CASE WHEN status = 'late' THEN 1 ELSE 0 END) as late
            FROM attendance
        ");
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getAcademicRecords()
    {
        $stmt = $this->db->prepare("
            SELECT m.*, u.first_name, u.last_name, s.name as subject_name, e.exam_name
            FROM marks m
            LEFT JOIN users u ON m.student_id = u.id
            LEFT JOIN subjects s ON m.subject_id = s.id
            LEFT JOIN exams e ON m.exam_id = e.id
            ORDER BY m.marks_obtained DESC LIMIT 100
        ");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAcademicSummary()
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as total,
                   AVG(marks_obtained) as avg_marks,
                   MAX(marks_obtained) as highest,
                   MIN(marks_obtained) as lowest
            FROM marks
        ");
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getFinancialRecords()
    {
        $stmt = $this->db->prepare("
            SELECT i.*, u.first_name, u.last_name
            FROM invoices i
            LEFT JOIN users u ON i.student_id = u.id
            ORDER BY i.created_at DESC LIMIT 100
        ");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getFinancialSummary()
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as total,
                   SUM(total_amount) as total_amount,
                   SUM(CASE WHEN balance = 0 THEN total_amount ELSE 0 END) as paid,
                   SUM(CASE WHEN balance > 0 THEN balance ELSE 0 END) as pending
            FROM invoices
        ");
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}
