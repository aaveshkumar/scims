<?php

class Message extends Model
{
    protected $table = 'messages';
    protected $fillable = ['sender_id', 'receiver_id', 'subject', 'message_body', 'attachment_path', 'parent_message_id'];

    public function getSentMessages($userId)
    {
        return $this->where('sender_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->get();
    }

    public function getReceivedMessages($userId)
    {
        return $this->where('receiver_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->get();
    }

    public function getUnreadMessages($userId)
    {
        return $this->where('receiver_id', $userId)
                    ->where('is_read', false)
                    ->orderBy('created_at', 'DESC')
                    ->get();
    }

    public function getUnreadCount($userId)
    {
        $result = $this->db->fetchOne(
            "SELECT COUNT(*) as count FROM messages WHERE receiver_id = ? AND is_read = false",
            [$userId]
        );
        return $result['count'] ?? 0;
    }

    public function markAsRead($id)
    {
        return $this->update($id, [
            'is_read' => true,
            'read_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function getConversation($userId1, $userId2)
    {
        return $this->db->fetchAll(
            "SELECT * FROM messages 
             WHERE (sender_id = ? AND receiver_id = ?) 
                OR (sender_id = ? AND receiver_id = ?)
             ORDER BY created_at ASC",
            [$userId1, $userId2, $userId2, $userId1]
        );
    }
}
