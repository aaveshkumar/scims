<?php

class Announcement extends Model
{
    protected $table = 'announcements';
    protected $fillable = ['title', 'content', 'target_audience', 'priority', 'published_by', 'published_date', 'expiry_date', 'attachment_path', 'is_visible'];

    public function getAllActive()
    {
        return $this->where('is_visible', true)
                    ->orderBy('published_date', 'DESC')
                    ->get();
    }

    public function getByUser($userId)
    {
        return $this->where('published_by', $userId)
                    ->orderBy('created_at', 'DESC')
                    ->get();
    }

    public function incrementViews($id)
    {
        return $this->db->execute(
            "UPDATE announcements SET views_count = views_count + 1 WHERE id = ?",
            [$id]
        );
    }
}
