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
        $sql = "
            SELECT a.*, u.first_name, u.last_name, c.name as class_name
            FROM attendance a
            LEFT JOIN users u ON a.student_id = u.id
            LEFT JOIN classes c ON a.class_id = c.id
            ORDER BY a.date DESC LIMIT 100
        ";
        return $this->db->fetchAll($sql);
    }

    public function getAttendanceSummary()
    {
        $sql = "
            SELECT COUNT(*) as total, 
                   SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) as present,
                   SUM(CASE WHEN status = 'absent' THEN 1 ELSE 0 END) as absent,
                   SUM(CASE WHEN status = 'late' THEN 1 ELSE 0 END) as late
            FROM attendance
        ";
        return $this->db->fetchOne($sql);
    }

    public function getAcademicRecords()
    {
        $sql = "
            SELECT m.*, u.first_name, u.last_name, s.name as subject_name, e.exam_name
            FROM marks m
            LEFT JOIN users u ON m.student_id = u.id
            LEFT JOIN subjects s ON m.subject_id = s.id
            LEFT JOIN exams e ON m.exam_id = e.id
            ORDER BY m.marks_obtained DESC LIMIT 100
        ";
        return $this->db->fetchAll($sql);
    }

    public function getAcademicSummary()
    {
        $sql = "
            SELECT COUNT(*) as total,
                   AVG(marks_obtained) as avg_marks,
                   MAX(marks_obtained) as highest,
                   MIN(marks_obtained) as lowest
            FROM marks
        ";
        return $this->db->fetchOne($sql);
    }

    public function getFinancialRecords()
    {
        $sql = "
            SELECT i.*, u.first_name, u.last_name
            FROM invoices i
            LEFT JOIN users u ON i.student_id = u.id
            ORDER BY i.created_at DESC LIMIT 100
        ";
        return $this->db->fetchAll($sql);
    }

    public function getFinancialSummary()
    {
        $sql = "
            SELECT COUNT(*) as total,
                   SUM(total_amount) as total_amount,
                   SUM(CASE WHEN balance = 0 THEN total_amount ELSE 0 END) as paid,
                   SUM(CASE WHEN balance > 0 THEN balance ELSE 0 END) as pending
            FROM invoices
        ";
        return $this->db->fetchOne($sql);
    }

    public function getAttendanceById($id)
    {
        $sql = "SELECT * FROM attendance WHERE id = ?";
        return $this->db->fetchOne($sql, [$id]);
    }

    public function createAttendance($data)
    {
        $sql = "
            INSERT INTO attendance (student_id, class_id, subject_id, date, status, remarks)
            VALUES (?, ?, ?, ?, ?, ?)
        ";
        return $this->db->execute($sql, [
            $data['student_id'],
            $data['class_id'],
            $data['subject_id'] ?? 1,
            $data['date'],
            $data['status'],
            $data['remarks'] ?? null
        ]);
    }

    public function updateAttendance($id, $data)
    {
        $sql = "
            UPDATE attendance SET student_id = ?, class_id = ?, date = ?, status = ?, remarks = ?
            WHERE id = ?
        ";
        return $this->db->execute($sql, [
            $data['student_id'],
            $data['class_id'],
            $data['date'],
            $data['status'],
            $data['remarks'] ?? null,
            $id
        ]);
    }

    public function deleteAttendance($id)
    {
        $sql = "DELETE FROM attendance WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }

    public function getAllStudents()
    {
        $sql = "
            SELECT u.id, u.first_name, u.last_name
            FROM students s
            JOIN users u ON s.user_id = u.id
            ORDER BY u.first_name
        ";
        return $this->db->fetchAll($sql);
    }

    public function getAllClasses()
    {
        $sql = "SELECT id, name FROM classes ORDER BY name";
        return $this->db->fetchAll($sql);
    }

    public function getUniqueDates()
    {
        $sql = "SELECT DISTINCT date FROM attendance ORDER BY date DESC";
        return $this->db->fetchAll($sql);
    }

    public function getFilteredAttendance($classId = null, $date = null)
    {
        $sql = "
            SELECT a.*, u.first_name, u.last_name, c.name as class_name
            FROM attendance a
            LEFT JOIN users u ON a.student_id = u.id
            LEFT JOIN classes c ON a.class_id = c.id
            WHERE 1=1
        ";
        $params = [];

        if ($classId) {
            $sql .= " AND a.class_id = ?";
            $params[] = $classId;
        }

        if ($date) {
            $sql .= " AND a.date = ?";
            $params[] = $date;
        }

        $sql .= " ORDER BY a.date DESC, u.first_name ASC LIMIT 200";
        
        return $this->db->fetchAll($sql, $params);
    }

    public function getFilteredSummary($classId = null, $date = null)
    {
        $sql = "
            SELECT COUNT(*) as total, 
                   SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) as present,
                   SUM(CASE WHEN status = 'absent' THEN 1 ELSE 0 END) as absent,
                   SUM(CASE WHEN status = 'late' THEN 1 ELSE 0 END) as late
            FROM attendance
            WHERE 1=1
        ";
        $params = [];

        if ($classId) {
            $sql .= " AND class_id = ?";
            $params[] = $classId;
        }

        if ($date) {
            $sql .= " AND date = ?";
            $params[] = $date;
        }

        return $this->db->fetchOne($sql, $params);
    }
}
