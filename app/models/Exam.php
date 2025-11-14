<?php

class Exam extends Model
{
    protected $table = 'exams';
    protected $fillable = [
        'name', 'code', 'class_id', 'exam_type', 'academic_year',
        'semester', 'start_date', 'end_date', 'total_marks',
        'passing_marks', 'status'
    ];

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

    public function marks()
    {
        return $this->db->fetchAll(
            "SELECT * FROM marks WHERE exam_id = ?",
            [$this->id]
        );
    }

    public function getResults($studentId = null)
    {
        $sql = "SELECT m.*, s.name as subject_name, 
                       u.first_name, u.last_name, st.admission_number
                FROM marks m
                INNER JOIN subjects s ON m.subject_id = s.id
                INNER JOIN students st ON m.student_id = st.id
                INNER JOIN users u ON st.user_id = u.id
                WHERE m.exam_id = ?";
        
        $params = [$this->id];

        if ($studentId) {
            $sql .= " AND m.student_id = ?";
            $params[] = $studentId;
        }

        return $this->db->fetchAll($sql, $params);
    }

    public static function calculateGrade($marksObtained, $totalMarks)
    {
        $percentage = ($marksObtained / $totalMarks) * 100;

        if ($percentage >= 90) return 'A+';
        if ($percentage >= 80) return 'A';
        if ($percentage >= 70) return 'B+';
        if ($percentage >= 60) return 'B';
        if ($percentage >= 50) return 'C';
        if ($percentage >= 40) return 'D';
        return 'F';
    }
}
