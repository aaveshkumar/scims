<?php

class SupportMessage extends Model
{
    protected $table = 'support_messages';
    protected $fillable = ['user_id', 'subject', 'message', 'status', 'admin_reply', 'admin_replied_by', 'replied_at'];

    public function getForUser($userId)
    {
        return $this->where('user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->get();
    }

    public function getForAdmin()
    {
        return $this->orderBy('status', 'ASC')
                    ->orderBy('created_at', 'DESC')
                    ->get();
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
        $result = new Model();
        return $result->db->fetchOne("SELECT id, first_name, last_name, email FROM users WHERE id = ?", [$userId]);
    }

    public function getAdminInfo($adminId)
    {
        $result = new Model();
        return $result->db->fetchOne("SELECT id, first_name, last_name, email FROM users WHERE id = ?", [$adminId]);
    }
}
