<?php

class Staff extends Model
{
    protected $table = 'staff';
    protected $fillable = [
        'user_id', 'employee_id', 'designation', 'department',
        'qualification', 'experience_years', 'joining_date',
        'salary', 'bank_name', 'account_number', 'emergency_contact',
        'documents', 'status'
    ];

    public function user()
    {
        return $this->db->fetchOne(
            "SELECT * FROM users WHERE id = ?",
            [$this->user_id]
        );
    }

    public function subjects()
    {
        return $this->db->fetchAll(
            "SELECT * FROM subjects WHERE teacher_id = ?",
            [$this->user_id]
        );
    }

    public function classes()
    {
        return $this->db->fetchAll(
            "SELECT DISTINCT c.* FROM classes c
             INNER JOIN subjects s ON c.id = s.class_id
             WHERE s.teacher_id = ?",
            [$this->user_id]
        );
    }

    public function findByEmployeeId($employeeId)
    {
        return $this->where('employee_id', $employeeId)->first();
    }
}
