<?php

class Assignment
{
    protected static $table = 'assignments';
    
    public static function getAll($filters = [])
    {
        $sql = "SELECT a.*, s.name as subject_name, c.name as class_name,
                t.name as teacher_name
                FROM assignments a
                JOIN subjects s ON a.subject_id = s.id
                JOIN classes c ON a.class_id = c.id
                JOIN users t ON a.teacher_id = t.id
                WHERE 1=1";
        $params = [];
        
        if (!empty($filters['subject_id'])) {
            $sql .= " AND a.subject_id = ?";
            $params[] = $filters['subject_id'];
        }
        
        if (!empty($filters['class_id'])) {
            $sql .= " AND a.class_id = ?";
            $params[] = $filters['class_id'];
        }
        
        if (!empty($filters['status'])) {
            $sql .= " AND a.status = ?";
            $params[] = $filters['status'];
        }
        
        $sql .= " ORDER BY a.due_date DESC, a.created_at DESC";
        
        return db()->fetchAll($sql, $params);
    }
    
    public static function find($id)
    {
        $sql = "SELECT a.*, s.name as subject_name, c.name as class_name,
                t.name as teacher_name
                FROM assignments a
                JOIN subjects s ON a.subject_id = s.id
                JOIN classes c ON a.class_id = c.id
                JOIN users t ON a.teacher_id = t.id
                WHERE a.id = ?";
        
        return db()->fetchOne($sql, [$id]);
    }
    
    public static function create($data)
    {
        $sql = "INSERT INTO assignments (title, subject_id, class_id, teacher_id, 
                description, instructions, attachment_path, assigned_date, due_date, 
                total_marks, status, created_at, updated_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
        
        return db()->execute($sql, [
            $data['title'],
            $data['subject_id'],
            $data['class_id'],
            $data['teacher_id'],
            $data['description'] ?? null,
            $data['instructions'] ?? null,
            $data['attachment_path'] ?? null,
            $data['assigned_date'],
            $data['due_date'],
            $data['total_marks'] ?? 100,
            $data['status'] ?? 'active'
        ]);
    }
    
    public static function update($id, $data)
    {
        $sql = "UPDATE assignments SET title = ?, description = ?, instructions = ?, 
                due_date = ?, total_marks = ?, status = ?, updated_at = NOW() WHERE id = ?";
        
        return db()->execute($sql, [
            $data['title'],
            $data['description'] ?? null,
            $data['instructions'] ?? null,
            $data['due_date'],
            $data['total_marks'],
            $data['status'],
            $id
        ]);
    }
    
    public static function delete($id)
    {
        return db()->execute("DELETE FROM assignments WHERE id = ?", [$id]);
    }
    
    public static function getSubmissions($assignmentId)
    {
        $sql = "SELECT sub.*, st.first_name, st.last_name, st.roll_number,
                g.name as graded_by_name
                FROM assignment_submissions sub
                JOIN students st ON sub.student_id = st.id
                LEFT JOIN users g ON sub.graded_by = g.id
                WHERE sub.assignment_id = ?
                ORDER BY sub.submission_date DESC";
        
        return db()->fetchAll($sql, [$assignmentId]);
    }
    
    public static function getStatistics()
    {
        return [
            'total_assignments' => db()->fetchOne("SELECT COUNT(*) as count FROM assignments WHERE status = 'active'")['count'],
            'due_soon' => db()->fetchOne("SELECT COUNT(*) as count FROM assignments WHERE status = 'active' AND due_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)")['count'],
            'total_submissions' => db()->fetchOne("SELECT COUNT(*) as count FROM assignment_submissions")['count'],
            'pending_grading' => db()->fetchOne("SELECT COUNT(*) as count FROM assignment_submissions WHERE status = 'submitted' AND marks_obtained IS NULL")['count']
        ];
    }
}
