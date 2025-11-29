<?php

class Leave extends Model
{
    protected $table = 'leaves';
    protected $fillable = [
        'user_id', 'leave_type', 'start_date', 'end_date', 
        'reason', 'status', 'approved_by', 'remarks'
    ];

    public function getLeavesByUser($userId)
    {
        return $this->db->fetchAll(
            "SELECT l.*, u.first_name, u.last_name, 
                    CONCAT(au.first_name, ' ', au.last_name) as approved_by_name
             FROM leaves l
             JOIN users u ON l.user_id = u.id
             LEFT JOIN users au ON l.approved_by = au.id
             WHERE l.user_id = ?
             ORDER BY l.start_date DESC",
            [$userId]
        );
    }

    public function getPendingLeaves()
    {
        return $this->db->fetchAll(
            "SELECT l.*, u.first_name, u.last_name
             FROM leaves l
             JOIN users u ON l.user_id = u.id
             WHERE l.status = 'pending'
             ORDER BY l.created_at DESC"
        );
    }

    public function getLeavesByStatus($status)
    {
        return $this->db->fetchAll(
            "SELECT l.*, u.first_name, u.last_name,
                    CONCAT(au.first_name, ' ', au.last_name) as approved_by_name
             FROM leaves l
             JOIN users u ON l.user_id = u.id
             LEFT JOIN users au ON l.approved_by = au.id
             WHERE l.status = ?
             ORDER BY l.start_date DESC",
            [$status]
        );
    }
}
