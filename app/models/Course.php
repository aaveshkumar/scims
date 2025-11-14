<?php

class Course extends Model
{
    protected $table = 'courses';
    protected $fillable = ['name', 'code', 'description', 'duration_years', 'status'];

    public function classes()
    {
        return $this->where('course_id', $this->id)->get();
    }

    public function subjects()
    {
        return $this->db->fetchAll(
            "SELECT * FROM subjects WHERE course_id = ?",
            [$this->id]
        );
    }

    public function findByCode($code)
    {
        return $this->where('code', $code)->first();
    }

    public function getActiveClasses()
    {
        return $this->db->fetchAll(
            "SELECT * FROM classes WHERE course_id = ? AND status = 'active'",
            [$this->id]
        );
    }
}
