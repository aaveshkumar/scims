<?php

class Material extends Model
{
    protected $table = 'materials';
    protected $fillable = [
        'title', 'description', 'file_path', 'file_type', 'file_size',
        'subject_id', 'class_id', 'uploaded_by', 'type', 'status'
    ];

    public function subject()
    {
        if (!$this->subject_id) {
            return null;
        }

        return $this->db->fetchOne(
            "SELECT * FROM subjects WHERE id = ?",
            [$this->subject_id]
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

    public function uploader()
    {
        return $this->db->fetchOne(
            "SELECT * FROM users WHERE id = ?",
            [$this->uploaded_by]
        );
    }

    public function incrementDownloads()
    {
        return $this->db->execute(
            "UPDATE materials SET downloads = downloads + 1 WHERE id = ?",
            [$this->id]
        );
    }

    public function getClassMaterials($classId, $subjectId = null)
    {
        $sql = "SELECT m.*, s.name as subject_name, u.first_name, u.last_name
                FROM materials m
                LEFT JOIN subjects s ON m.subject_id = s.id
                INNER JOIN users u ON m.uploaded_by = u.id
                WHERE m.class_id = ? AND m.status = 'active'";
        
        $params = [$classId];

        if ($subjectId) {
            $sql .= " AND m.subject_id = ?";
            $params[] = $subjectId;
        }

        $sql .= " ORDER BY m.created_at DESC";

        return $this->db->fetchAll($sql, $params);
    }
}
