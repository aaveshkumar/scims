<?php

class AcademicCalendar
{
    protected $table = 'academic_calendar';
    protected $db;
    protected $whereConditions;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function all()
    {
        $query = "SELECT * FROM {$this->table} ORDER BY start_date DESC";
        return $this->db->fetchAll($query);
    }

    public function find($id)
    {
        $query = "SELECT * FROM {$this->table} WHERE id = ?";
        return $this->db->fetchOne($query, [$id]);
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
        $this->whereConditions = [$column => $value];
        return $this;
    }

    public function get()
    {
        if (!isset($this->whereConditions)) {
            $query = "SELECT * FROM {$this->table} ORDER BY created_at DESC";
            return $this->db->fetchAll($query);
        }

        $column = array_key_first($this->whereConditions);
        $value = $this->whereConditions[$column];
        $query = "SELECT * FROM {$this->table} WHERE {$column} = ? ORDER BY created_at DESC";
        return $this->db->fetchAll($query, [$value]);
    }
}
