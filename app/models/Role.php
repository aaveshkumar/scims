<?php

class Role extends Model
{
    protected $table = 'roles';
    protected $fillable = ['name', 'display_name', 'description'];

    public function users()
    {
        return $this->db->fetchAll(
            "SELECT u.* FROM users u 
             INNER JOIN user_roles ur ON u.id = ur.user_id 
             WHERE ur.role_id = ?",
            [$this->id]
        );
    }

    public function findByName($name)
    {
        return $this->where('name', $name)->first();
    }
}
