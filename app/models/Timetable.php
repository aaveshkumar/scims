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
                    CONCAT(u.first_name, ' ', u.last_name) as teacher_name
             FROM timetables t
             INNER JOIN subjects s ON t.subject_id = s.id
             LEFT JOIN users u ON t.teacher_id = u.id
             WHERE t.class_id = ? AND t.academic_year = ? AND t.status = 'active'
             ORDER BY 
                CASE WHEN t.day_of_week = 'Monday' THEN 1
                     WHEN t.day_of_week = 'Tuesday' THEN 2
                     WHEN t.day_of_week = 'Wednesday' THEN 3
                     WHEN t.day_of_week = 'Thursday' THEN 4
                     WHEN t.day_of_week = 'Friday' THEN 5
                     WHEN t.day_of_week = 'Saturday' THEN 6
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
                FIELD(t.day_of_week, 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'),
                t.start_time",
            [$teacherId, $academicYear]
        );
    }
}
