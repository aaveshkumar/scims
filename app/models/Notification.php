<?php

class Notification extends Model
{
    protected $table = 'notifications';
    protected $fillable = ['user_id', 'title', 'message', 'type', 'link'];

    public function markAsRead()
    {
        return $this->update($this->id, [
            'is_read' => true,
            'read_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function getUserNotifications($userId, $limit = 10)
    {
        return $this->where('user_id', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->get();
    }

    public function getUnreadCount($userId)
    {
        $result = $this->db->fetchOne(
            "SELECT COUNT(*) as count FROM notifications 
             WHERE user_id = ? AND is_read = false",
            [$userId]
        );

        return $result['count'] ?? 0;
    }

    public function getUnreadNotifications($userId)
    {
        return $this->db->fetchAll(
            "SELECT * FROM notifications WHERE user_id = ? AND is_read = false ORDER BY created_at DESC",
            [$userId]
        );
    }

    public function markAllAsRead($userId)
    {
        return $this->db->execute(
            "UPDATE notifications SET is_read = true, read_at = ? 
             WHERE user_id = ? AND is_read = false",
            [date('Y-m-d H:i:s'), $userId]
        );
    }

    public static function send($userId, $title, $message, $type = 'info', $link = null)
    {
        $notification = new self();
        return $notification->create([
            'user_id' => $userId,
            'title' => $title,
            'message' => $message,
            'type' => $type,
            'link' => $link
        ]);
    }
}
