<?php

class LessonPlan
{
    protected $table = 'lesson_plans';
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function all()
    {
        $query = "SELECT lp.*, s.name as subject_name, c.name as class_name, u.full_name as teacher_name
                  FROM {$this->table} lp
                  LEFT JOIN subjects s ON lp.subject_id = s.id
                  LEFT JOIN classes c ON lp.class_id = c.id
                  LEFT JOIN users u ON lp.teacher_id = u.id
                  ORDER BY lp.created_at DESC";
        return $this->db->query($query);
    }

    public function find($id)
    {
        $query = "SELECT lp.*, s.name as subject_name, c.name as class_name, u.full_name as teacher_name
                  FROM {$this->table} lp
                  LEFT JOIN subjects s ON lp.subject_id = s.id
                  LEFT JOIN classes c ON lp.class_id = c.id
                  LEFT JOIN users u ON lp.teacher_id = u.id
                  WHERE lp.id = ?";
        return $this->db->query($query, [$id])[0] ?? null;
    }

    public function create($data)
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = implode(', ', array_fill(0, count($data), '?'));
        $query = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
        return $this->db->execute($query, array_values($data));
    }

    public function update($id, $data)
    {
        $setClause = implode(', ', array_map(fn($k) => "$k = ?", array_keys($data)));
        $values = array_values($data);
        $values[] = $id;
        $query = "UPDATE {$this->table} SET {$setClause} WHERE id = ?";
        return $this->db->execute($query, $values);
    }

    public function delete($id)
    {
        return $this->db->execute("DELETE FROM {$this->table} WHERE id = ?", [$id]);
    }

    public function where($column, $value)
    {
        $query = "SELECT * FROM {$this->table} WHERE {$column} = ? ORDER BY created_at DESC";
        return $this->db->query($query, [$value]);
    }
}
