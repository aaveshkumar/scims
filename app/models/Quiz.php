<?php

class Quiz
{
    protected static $table = 'quizzes';
    
    public static function getAll($filters = [])
    {
        $sql = "SELECT q.*, s.name as subject_name, c.name as class_name,
                CONCAT(u.first_name, ' ', u.last_name) as teacher_name
                FROM quizzes q
                JOIN subjects s ON q.subject_id = s.id
                JOIN classes c ON q.class_id = c.id
                JOIN users u ON q.teacher_id = u.id
                WHERE 1=1";
        $params = [];
        
        if (!empty($filters['subject_id'])) {
            $sql .= " AND q.subject_id = ?";
            $params[] = $filters['subject_id'];
        }
        
        if (!empty($filters['class_id'])) {
            $sql .= " AND q.class_id = ?";
            $params[] = $filters['class_id'];
        }
        
        if (!empty($filters['status'])) {
            $sql .= " AND q.status = ?";
            $params[] = $filters['status'];
        }
        
        $sql .= " ORDER BY q.start_time DESC";
        
        return db()->fetchAll($sql, $params);
    }
    
    public static function find($id)
    {
        $sql = "SELECT q.*, s.name as subject_name, c.name as class_name,
                CONCAT(u.first_name, ' ', u.last_name) as teacher_name
                FROM quizzes q
                JOIN subjects s ON q.subject_id = s.id
                JOIN classes c ON q.class_id = c.id
                JOIN users u ON q.teacher_id = u.id
                WHERE q.id = ?";
        
        return db()->fetchOne($sql, [$id]);
    }
    
    public static function create($data)
    {
        $sql = "INSERT INTO quizzes (title, subject_id, class_id, teacher_id, 
                description, duration_minutes, total_marks, passing_marks, 
                start_time, end_time, status, created_at, updated_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
        
        return db()->execute($sql, [
            $data['title'],
            $data['subject_id'],
            $data['class_id'],
            $data['teacher_id'],
            $data['description'] ?? null,
            $data['duration_minutes'] ?? 30,
            $data['total_marks'] ?? 10,
            $data['passing_marks'] ?? null,
            $data['start_time'] ?? null,
            $data['end_time'] ?? null,
            $data['status'] ?? 'draft'
        ]);
    }
    
    public static function update($id, $data)
    {
        $sql = "UPDATE quizzes SET title = ?, description = ?, duration_minutes = ?, 
                total_marks = ?, passing_marks = ?, start_time = ?, end_time = ?, 
                status = ?, updated_at = NOW() WHERE id = ?";
        
        return db()->execute($sql, [
            $data['title'],
            $data['description'] ?? null,
            $data['duration_minutes'],
            $data['total_marks'],
            $data['passing_marks'] ?? null,
            $data['start_time'] ?? null,
            $data['end_time'] ?? null,
            $data['status'],
            $id
        ]);
    }
    
    public static function delete($id)
    {
        return db()->execute("DELETE FROM quizzes WHERE id = ?", [$id]);
    }
    
    public static function getQuestions($quizId)
    {
        $sql = "SELECT qq.*, qb.question_text, qb.question_type, qb.option_a, 
                qb.option_b, qb.option_c, qb.option_d, qb.correct_answer
                FROM quiz_questions qq
                JOIN question_bank qb ON qq.question_id = qb.id
                WHERE qq.quiz_id = ?
                ORDER BY qq.question_order";
        
        return db()->fetchAll($sql, [$quizId]);
    }
    
    public static function getAttempts($quizId)
    {
        $sql = "SELECT qa.*, s.first_name, s.last_name, s.roll_number
                FROM quiz_attempts qa
                JOIN students s ON qa.student_id = s.id
                WHERE qa.quiz_id = ?
                ORDER BY qa.marks_obtained DESC";
        
        return db()->fetchAll($sql, [$quizId]);
    }
    
    public static function getStatistics()
    {
        return [
            'total_quizzes' => db()->fetchOne("SELECT COUNT(*) as count FROM quizzes")['count'],
            'active_quizzes' => db()->fetchOne("SELECT COUNT(*) as count FROM quizzes WHERE status = 'active'")['count'],
            'total_attempts' => db()->fetchOne("SELECT COUNT(*) as count FROM quiz_attempts")['count'],
            'completed_attempts' => db()->fetchOne("SELECT COUNT(*) as count FROM quiz_attempts WHERE status = 'completed'")['count']
        ];
    }
}
