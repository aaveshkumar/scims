<?php

class Mark extends Model
{
    protected $table = 'marks';
    protected $fillable = [
        'student_id', 'exam_id', 'subject_id', 'marks_obtained',
        'total_marks', 'grade', 'remarks', 'entered_by'
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

    public function exam()
    {
        return $this->db->fetchOne(
            "SELECT * FROM exams WHERE id = ?",
            [$this->exam_id]
        );
    }

    public function subject()
    {
        return $this->db->fetchOne(
            "SELECT * FROM subjects WHERE id = ?",
            [$this->subject_id]
        );
    }

    public function enterMarks($studentId, $examId, $subjectId, $marksObtained, $totalMarks, $enteredBy = null)
    {
        $grade = Exam::calculateGrade($marksObtained, $totalMarks);

        return $this->create([
            'student_id' => $studentId,
            'exam_id' => $examId,
            'subject_id' => $subjectId,
            'marks_obtained' => $marksObtained,
            'total_marks' => $totalMarks,
            'grade' => $grade,
            'entered_by' => $enteredBy
        ]);
    }

    public function getStudentReportCard($studentId, $examId)
    {
        return $this->db->fetchAll(
            "SELECT m.*, s.name as subject_name, s.code as subject_code
             FROM marks m
             INNER JOIN subjects s ON m.subject_id = s.id
             WHERE m.student_id = ? AND m.exam_id = ?
             ORDER BY s.name",
            [$studentId, $examId]
        );
    }
}
