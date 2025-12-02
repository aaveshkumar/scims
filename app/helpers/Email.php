<?php

class Email
{
    /**
     * Send credentials email to new user
     * @param string $toEmail Recipient email
     * @param string $firstName User first name
     * @param string $lastName User last name
     * @param string $temporaryPassword Temporary password
     * @param string $userType Type of user (student/staff)
     * @return bool Success status
     */
    public static function sendCredentials($toEmail, $firstName, $lastName, $temporaryPassword, $userType = 'student')
    {
        $fullName = "$firstName $lastName";
        $schoolName = 'SCIMS Academy';
        $loginUrl = 'https://' . $_SERVER['HTTP_HOST'] . '/login';
        
        $subject = "Welcome to $schoolName - Your Login Credentials";
        
        $message = <<<HTML
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: #2c3e50; color: white; padding: 20px; border-radius: 5px 5px 0 0; text-align: center; }
                .content { background: #f9f9f9; padding: 20px; border: 1px solid #ddd; }
                .credentials { background: white; padding: 15px; margin: 20px 0; border-left: 4px solid #3498db; }
                .credentials strong { color: #2c3e50; }
                .footer { background: #ecf0f1; padding: 15px; text-align: center; font-size: 12px; color: #7f8c8d; border-radius: 0 0 5px 5px; }
                .button { background: #3498db; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin: 10px 0; }
                .warning { background: #fff3cd; border: 1px solid #ffc107; padding: 10px; border-radius: 5px; margin: 15px 0; color: #856404; }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h1>Welcome to $schoolName</h1>
                </div>
                <div class="content">
                    <p>Dear <strong>$fullName</strong>,</p>
                    
                    <p>Your account as a <strong>$userType</strong> has been created. Below are your login credentials:</p>
                    
                    <div class="credentials">
                        <p><strong>Email:</strong> $toEmail</p>
                        <p><strong>Temporary Password:</strong> <code style="background: #f0f0f0; padding: 5px; border-radius: 3px;">$temporaryPassword</code></p>
                    </div>
                    
                    <div class="warning">
                        ⚠️ <strong>Important:</strong> This is a temporary password that expires in 7 days. 
                        Please change it immediately after your first login for security.
                    </div>
                    
                    <p>
                        <a href="$loginUrl" class="button">Login to $schoolName</a>
                    </p>
                    
                    <p><strong>How to login:</strong></p>
                    <ol>
                        <li>Visit <a href="$loginUrl">$loginUrl</a></li>
                        <li>Enter your email: <strong>$toEmail</strong></li>
                        <li>Enter your temporary password</li>
                        <li>Select your role as <strong>$userType</strong></li>
                    </ol>
                    
                    <p><strong>Next Steps:</strong></p>
                    <ol>
                        <li>Log in with your credentials</li>
                        <li>Go to Settings → Change Password</li>
                        <li>Set a new permanent password</li>
                    </ol>
                    
                    <p>If you didn't create this account or have any issues, please contact the administrator immediately.</p>
                    
                    <p>Best regards,<br><strong>$schoolName Administration</strong></p>
                </div>
                <div class="footer">
                    <p>&copy; 2024 $schoolName. All rights reserved.</p>
                    <p>This is an automated email. Please do not reply to this message.</p>
                </div>
            </div>
        </body>
        </html>
HTML;

        return self::send($toEmail, $subject, $message);
    }

    /**
     * Send password reset email
     * @param string $toEmail Recipient email
     * @param string $firstName User first name
     * @param string $newPassword New temporary password
     * @return bool Success status
     */
    public static function sendPasswordReset($toEmail, $firstName, $newPassword)
    {
        $schoolName = 'SCIMS Academy';
        $loginUrl = 'https://' . $_SERVER['HTTP_HOST'] . '/login';
        
        $subject = "Password Reset - $schoolName";
        
        $message = <<<HTML
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: #2c3e50; color: white; padding: 20px; border-radius: 5px 5px 0 0; text-align: center; }
                .content { background: #f9f9f9; padding: 20px; border: 1px solid #ddd; }
                .credentials { background: white; padding: 15px; margin: 20px 0; border-left: 4px solid #e74c3c; }
                .credentials strong { color: #2c3e50; }
                .footer { background: #ecf0f1; padding: 15px; text-align: center; font-size: 12px; color: #7f8c8d; border-radius: 0 0 5px 5px; }
                .button { background: #e74c3c; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin: 10px 0; }
                .warning { background: #fff3cd; border: 1px solid #ffc107; padding: 10px; border-radius: 5px; margin: 15px 0; color: #856404; }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h1>Password Reset</h1>
                </div>
                <div class="content">
                    <p>Dear <strong>$firstName</strong>,</p>
                    
                    <p>Your password has been reset by the administrator. Your new temporary password is:</p>
                    
                    <div class="credentials">
                        <p><strong>New Temporary Password:</strong> <code style="background: #f0f0f0; padding: 5px; border-radius: 3px;">$newPassword</code></p>
                    </div>
                    
                    <div class="warning">
                        ⚠️ <strong>Important:</strong> This is a temporary password that expires in 7 days. 
                        Please change it immediately after your next login for security.
                    </div>
                    
                    <p>
                        <a href="$loginUrl" class="button">Login Now</a>
                    </p>
                    
                    <p>If you didn't request this password reset, please contact the administrator immediately.</p>
                    
                    <p>Best regards,<br><strong>$schoolName Administration</strong></p>
                </div>
                <div class="footer">
                    <p>&copy; 2024 $schoolName. All rights reserved.</p>
                    <p>This is an automated email. Please do not reply to this message.</p>
                </div>
            </div>
        </body>
        </html>
HTML;

        return self::send($toEmail, $subject, $message);
    }

    /**
     * Core email sending function
     * @param string $to Recipient email
     * @param string $subject Email subject
     * @param string $message HTML message
     * @return bool Success status
     */
    private static function send($to, $subject, $message)
    {
        // Headers for HTML email
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";
        $headers .= "From: noreply@scims.local\r\n";
        $headers .= "Reply-To: admin@scims.local\r\n";
        
        // Attempt to send
        try {
            $result = @mail($to, $subject, $message, $headers);
            
            // Log email sending attempt
            error_log("[EMAIL] Sent to: $to, Subject: $subject, Status: " . ($result ? 'SUCCESS' : 'FAILED'));
            
            return $result;
        } catch (Exception $e) {
            error_log("[EMAIL ERROR] Failed to send to $to: " . $e->getMessage());
            return false;
        }
    }
}
