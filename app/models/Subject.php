<?php

class Subject extends Model
{
    protected $table = 'subjects';
    protected $fillable = [
        'name', 'code', 'course_id', 'teacher_id', 'class_id',
        'credits', 'type', 'description', 'status'
    ];

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

    public function course()
    {
        if (!$this->course_id) {
            return null;
        }

        return $this->db->fetchOne(
            "SELECT * FROM courses WHERE id = ?",
            [$this->course_id]
        );
    }

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

    public function assignTeacher($teacherId)
    {
        return $this->update($this->id, ['teacher_id' => $teacherId]);
    }
}
