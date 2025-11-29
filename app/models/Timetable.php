<?php

class Timetable extends Model
{
    protected $table = 'timetables';
    protected $fillable = [
        'class_id', 'subject_id', 'teacher_id', 'day_of_week',
        'start_time', 'end_time', 'room_number', 'academic_year',
        'semester', 'status'
    ];

    public function class()
    {
        return $this->db->fetchOne(
            "SELECT * FROM classes WHERE id = ?",
            [$this->class_id]
        );
    }

    public function subject()
    {
        return $this->db->fetchOne(
            "SELECT * FROM subjects WHERE id = ?",
            [$this->subject_id]
        );
    }

    public function teacher()
    {
        if (!$this->teacher_id) {
            return null;
        }

        return $this->db->fetchOne(
            "SELECT * FROM users WHERE id = ?",
            [$this->teacher_id]
        );
    }

    public function getClassTimetable($classId, $academicYear)
    {
        return $this->db->fetchAll(
            "SELECT t.*, s.name as subject_name, s.code as subject_code,
                    CASE WHEN u.id IS NOT NULL THEN CONCAT(u.first_name, ' ', u.last_name) ELSE NULL END as teacher_name
             FROM timetables t
             INNER JOIN subjects s ON t.subject_id = s.id
             LEFT JOIN users u ON t.teacher_id = u.id
             WHERE t.class_id = ? AND t.academic_year = ? AND t.status = 'active'
             ORDER BY 
                CASE WHEN t.day_of_week = 'monday' THEN 1
                     WHEN t.day_of_week = 'tuesday' THEN 2
                     WHEN t.day_of_week = 'wednesday' THEN 3
                     WHEN t.day_of_week = 'thursday' THEN 4
                     WHEN t.day_of_week = 'friday' THEN 5
                     WHEN t.day_of_week = 'saturday' THEN 6
                     ELSE 7
                END,
                t.start_time",
            [$classId, $academicYear]
        );
    }

    public function getTeacherTimetable($teacherId, $academicYear)
    {
        return $this->db->fetchAll(
            "SELECT t.*, s.name as subject_name, c.name as class_name
             FROM timetables t
             INNER JOIN subjects s ON t.subject_id = s.id
             INNER JOIN classes c ON t.class_id = c.id
             WHERE t.teacher_id = ? AND t.academic_year = ? AND t.status = 'active'
             ORDER BY 
                CASE WHEN t.day_of_week = 'monday' THEN 1
                     WHEN t.day_of_week = 'tuesday' THEN 2
                     WHEN t.day_of_week = 'wednesday' THEN 3
                     WHEN t.day_of_week = 'thursday' THEN 4
                     WHEN t.day_of_week = 'friday' THEN 5
                     WHEN t.day_of_week = 'saturday' THEN 6
                     ELSE 7
                END,
                t.start_time",
            [$teacherId, $academicYear]
        );
    }

    public function getSubjectTimetable($subjectId, $academicYear)
    {
        return $this->db->fetchAll(
            "SELECT t.*, s.name as subject_name, s.code as subject_code, c.name as class_name,
                    CASE WHEN u.id IS NOT NULL THEN CONCAT(u.first_name, ' ', u.last_name) ELSE NULL END as teacher_name
             FROM timetables t
             INNER JOIN subjects s ON t.subject_id = s.id
             INNER JOIN classes c ON t.class_id = c.id
             LEFT JOIN users u ON t.teacher_id = u.id
             WHERE t.subject_id = ? AND t.academic_year = ? AND t.status = 'active'
             ORDER BY 
                CASE WHEN t.day_of_week = 'monday' THEN 1
                     WHEN t.day_of_week = 'tuesday' THEN 2
                     WHEN t.day_of_week = 'wednesday' THEN 3
                     WHEN t.day_of_week = 'thursday' THEN 4
                     WHEN t.day_of_week = 'friday' THEN 5
                     WHEN t.day_of_week = 'saturday' THEN 6
                     ELSE 7
                END,
                t.start_time",
            [$subjectId, $academicYear]
        );
    }
}
