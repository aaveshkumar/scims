<?php

class SupportMessage extends Model
{
    protected $table = 'support_messages';
    protected $fillable = ['user_id', 'subject', 'message', 'status', 'admin_reply', 'admin_replied_by', 'replied_at'];

    public function getForUser($userId)
    {
        return $this->db->fetchAll(
            "SELECT * FROM support_messages WHERE user_id = ? ORDER BY created_at DESC",
            [$userId]
        );
    }

    public function getForAdmin()
    {
        return $this->db->fetchAll(
            "SELECT * FROM support_messages ORDER BY status ASC, created_at DESC"
        );
    }

    public function getOpenTickets()
    {
        return $this->where('status', 'open')
                    ->orderBy('created_at', 'DESC')
                    ->get();
    }

    public function markAsResolved($id)
    {
        return $this->update($id, [
            'status' => 'resolved',
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function addReply($id, $reply, $adminId)
    {
        return $this->update($id, [
            'admin_reply' => $reply,
            'admin_replied_by' => $adminId,
            'replied_at' => date('Y-m-d H:i:s'),
            'status' => 'replied',
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function getUserInfo($userId)
    {
        return $this->db->fetchOne("SELECT id, first_name, last_name, email FROM users WHERE id = ?", [$userId]);
    }

    public function getAdminInfo($adminId)
    {
        return $this->db->fetchOne("SELECT id, first_name, last_name, email FROM users WHERE id = ?", [$adminId]);
    }
}
