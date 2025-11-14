<?php

class FeeStructure extends Model
{
    protected $table = 'fees_structures';
    protected $fillable = [
        'name', 'class_id', 'course_id', 'academic_year', 'semester',
        'fee_type', 'amount', 'due_date', 'status'
    ];

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

    public function getActiveFees($classId = null, $academicYear = null)
    {
        $sql = "SELECT * FROM fees_structures WHERE status = 'active'";
        $params = [];

        if ($classId) {
            $sql .= " AND class_id = ?";
            $params[] = $classId;
        }

        if ($academicYear) {
            $sql .= " AND academic_year = ?";
            $params[] = $academicYear;
        }

        return $this->db->fetchAll($sql, $params);
    }
}
