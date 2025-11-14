<?php

class ClassModel extends Model
{
    protected $table = 'classes';
    protected $fillable = [
        'name', 'code', 'course_id', 'section', 'academic_year',
        'capacity', 'room_number', 'status'
    ];

    public function course()
    {
        return $this->db->fetchOne(
            "SELECT * FROM courses WHERE id = ?",
            [$this->course_id]
        );
    }

    public function students()
    {
        return $this->db->fetchAll(
            "SELECT s.*, u.first_name, u.last_name, u.email 
             FROM students s 
             INNER JOIN users u ON s.user_id = u.id 
             WHERE s.class_id = ?",
            [$this->id]
        );
    }

    public function subjects()
    {
        return $this->db->fetchAll(
            "SELECT * FROM subjects WHERE class_id = ?",
            [$this->id]
        );
    }

    public function timetable()
    {
        return $this->db->fetchAll(
            "SELECT t.*, s.name as subject_name, u.first_name, u.last_name 
             FROM timetables t
             INNER JOIN subjects s ON t.subject_id = s.id
             LEFT JOIN users u ON t.teacher_id = u.id
             WHERE t.class_id = ? AND t.status = 'active'
             ORDER BY t.day_of_week, t.start_time",
            [$this->id]
        );
    }

    public function getStudentCount()
    {
        $result = $this->db->fetchOne(
            "SELECT COUNT(*) as count FROM students WHERE class_id = ? AND status = 'active'",
            [$this->id]
        );
        return $result['count'] ?? 0;
    }
}
