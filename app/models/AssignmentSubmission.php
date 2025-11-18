<?php

class AssignmentSubmission
{
    protected static $table = 'assignment_submissions';
    
    public static function create($data)
    {
        $sql = "INSERT INTO assignment_submissions (assignment_id, student_id, 
                submission_date, submission_text, attachment_path, status, 
                created_at, updated_at) 
                VALUES (?, ?, NOW(), ?, ?, ?, NOW(), NOW())";
        
        return db()->execute($sql, [
            $data['assignment_id'],
            $data['student_id'],
            $data['submission_text'] ?? null,
            $data['attachment_path'] ?? null,
            'submitted'
        ]);
    }
    
    public static function grade($id, $marksObtained, $feedback, $gradedBy)
    {
        $sql = "UPDATE assignment_submissions SET marks_obtained = ?, feedback = ?, 
                graded_by = ?, graded_date = CURDATE(), status = 'graded', 
                updated_at = NOW() WHERE id = ?";
        
        return db()->execute($sql, [$marksObtained, $feedback, $gradedBy, $id]);
    }
    
    public static function find($id)
    {
        return db()->fetchOne("SELECT * FROM assignment_submissions WHERE id = ?", [$id]);
    }
}
