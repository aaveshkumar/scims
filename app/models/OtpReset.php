<?php

class OtpReset extends Model
{
    protected $table = 'otp_resets';
    protected $fillable = ['email', 'otp', 'expires_at'];
    protected $timestamps = false;

    public static function generateOTP($email)
    {
        $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $expiresAt = date('Y-m-d H:i:s', strtotime('+15 minutes'));

        $model = new self();
        $model->create([
            'email' => $email,
            'otp' => $otp,
            'expires_at' => $expiresAt
        ]);

        return $otp;
    }

    public function verifyOTP($email, $otp)
    {
        $record = $this->db->fetchOne(
            "SELECT * FROM otp_resets 
             WHERE email = ? AND otp = ? AND is_used = 0 AND expires_at > NOW()
             ORDER BY created_at DESC LIMIT 1",
            [$email, $otp]
        );

        if (!$record) {
            return false;
        }

        $this->db->execute(
            "UPDATE otp_resets SET is_used = 1, used_at = NOW() WHERE id = ?",
            [$record['id']]
        );

        return true;
    }

    public function cleanupExpired()
    {
        return $this->db->execute(
            "DELETE FROM otp_resets WHERE expires_at < NOW()"
        );
    }
}
