<?php

class User extends Model
{
    protected $table = 'users';
    protected $fillable = [
        'email', 'phone', 'password', 'first_name', 'last_name',
        'gender', 'date_of_birth', 'address', 'photo', 'status'
    ];
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function roles()
    {
        return $this->db->fetchAll(
            "SELECT r.* FROM roles r 
             INNER JOIN user_roles ur ON r.id = ur.role_id 
             WHERE ur.user_id = ?",
            [$this->id]
        );
    }

    public function hasRole($roleName)
    {
        $roles = $this->db->fetchAll(
            "SELECT r.name FROM roles r 
             INNER JOIN user_roles ur ON r.id = ur.role_id 
             WHERE ur.user_id = ?",
            [$this->id]
        );

        foreach ($roles as $role) {
            if ($role['name'] === $roleName) {
                return true;
            }
        }

        return false;
    }

    public function assignRole($roleId)
    {
        return $this->db->execute(
            "INSERT IGNORE INTO user_roles (user_id, role_id) VALUES (?, ?)",
            [$this->id, $roleId]
        );
    }

    public function removeRole($roleId)
    {
        return $this->db->execute(
            "DELETE FROM user_roles WHERE user_id = ? AND role_id = ?",
            [$this->id, $roleId]
        );
    }

    public function findByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    public function verifyPassword($password, $hashedPassword)
    {
        return password_verify($password, $hashedPassword);
    }

    public static function hashPassword($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}
