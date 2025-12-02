<?php

class AuthController
{
    private $userModel;
    private $roleModel;

    public function __construct()
    {
        $this->userModel = new User();
        $this->roleModel = new Role();
    }

    public function showLogin($request)
    {
        if (isAuth()) {
            return redirect('/dashboard');
        }

        return view('auth.login');
    }

    public function login($request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:6',
            'role' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fix the validation errors');
            return back();
        }

        $email = $request->post('email');
        $password = $request->post('password');
        $selectedRole = $request->post('role');

        $user = $this->userModel->findByEmail($email);

        if (!$user) {
            flash('error', 'Invalid credentials for ' . ucfirst($selectedRole) . '. Email not found.');
            return back();
        }

        if (!$this->userModel->verifyPassword($password, $user['password'])) {
            flash('error', 'Invalid credentials for ' . ucfirst($selectedRole) . '. Incorrect password.');
            return back();
        }

        if ($user['status'] !== 'active') {
            flash('error', 'Your account is inactive. Please contact administrator.');
            return back();
        }

        // Fetch user's roles
        $db = Database::getInstance();
        $roles = $db->fetchAll(
            "SELECT r.name FROM roles r 
             INNER JOIN user_roles ur ON r.id = ur.role_id 
             WHERE ur.user_id = ?",
            [$user['id']]
        );
        
        $userRoles = array_column($roles, 'name');
        
        // Check if user is admin
        $isAdmin = in_array('admin', $userRoles);
        
        // If admin, allow login with any selected role and show admin dashboard
        if ($isAdmin) {
            $user['roles'] = $userRoles;
            $user['role'] = 'admin'; // Force admin role for dashboard
            $_SESSION['user'] = $user;
            flash('success', 'Welcome back, ' . $user['first_name'] . '!');
            return redirect('/dashboard');
        }

        // For non-admin users: Validate selected role
        $nonAdminRoles = array_filter($userRoles, fn($r) => $r !== 'admin');
        
        if (!in_array($selectedRole, $nonAdminRoles)) {
            flash('error', 'Invalid credentials for ' . ucfirst($selectedRole) . '. You do not have this role assigned.');
            return back();
        }

        // Verify user is registered in the appropriate role database table
        if (!$this->verifyRoleRegistration($user['id'], $selectedRole, $db)) {
            flash('error', 'Invalid credentials for ' . ucfirst($selectedRole) . '. Registration incomplete in system.');
            return back();
        }

        // Add roles array and selected role to user data
        $user['roles'] = $nonAdminRoles;
        $user['role'] = $selectedRole; // Store selected role

        $_SESSION['user'] = $user;

        flash('success', 'Welcome back, ' . $user['first_name'] . '!');
        return redirect('/dashboard');
    }

    private function verifyRoleRegistration($userId, $role, $db)
    {
        switch ($role) {
            case 'student':
                // Check if user exists in students table
                $student = $db->fetch(
                    "SELECT id FROM students WHERE user_id = ? AND status = 'active'",
                    [$userId]
                );
                return $student !== null;

            case 'teacher':
            case 'hr':
                // Check if user exists in staff table
                $staff = $db->fetch(
                    "SELECT id FROM staff WHERE user_id = ? AND status = 'active'",
                    [$userId]
                );
                return $staff !== null;

            case 'parent':
                // Check if user exists as a guardian (registered through student/admission system)
                $parent = $db->fetch(
                    "SELECT id FROM students WHERE guardian_email = ? LIMIT 1",
                    [$db->fetch("SELECT email FROM users WHERE id = ?", [$userId])['email']]
                );
                // For now, we also allow users with parent role in user_roles table
                return $parent !== null || true;

            default:
                return false;
        }
    }

    public function showRegister($request)
    {
        if (isAuth()) {
            return redirect('/dashboard');
        }

        return view('auth.register');
    }

    public function register($request)
    {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'password' => 'required|min:6'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fix the validation errors');
            return back();
        }

        $existingUser = $this->userModel->findByEmail($request->post('email'));
        if ($existingUser) {
            flash('error', 'Email already registered');
            return back();
        }

        try {
            $userId = $this->userModel->create([
                'first_name' => $request->post('first_name'),
                'last_name' => $request->post('last_name'),
                'email' => $request->post('email'),
                'phone' => $request->post('phone'),
                'password' => User::hashPassword($request->post('password')),
                'status' => 'active'
            ]);

            $studentRole = $this->roleModel->findByName('student');
            if ($studentRole) {
                db()->execute(
                    "INSERT INTO user_roles (user_id, role_id) VALUES (?, ?)",
                    [$userId, $studentRole['id']]
                );
            }

            flash('success', 'Registration successful! Please login.');
            return redirect('/login');
        } catch (Exception $e) {
            flash('error', 'Registration failed. Please try again.');
            return back();
        }
    }

    public function logout($request)
    {
        session_destroy();
        return redirect('/login');
    }

    public function showForgotPassword($request)
    {
        return view('auth.forgot-password');
    }

    public function sendOTP($request)
    {
        $rules = ['email' => 'required|email'];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please provide a valid email');
            return back();
        }

        $email = $request->post('email');
        $user = $this->userModel->findByEmail($email);

        if (!$user) {
            flash('error', 'Email not found');
            return back();
        }

        $otp = OtpReset::generateOTP($email);

        flash('success', 'OTP sent to your email (Demo OTP: ' . $otp . ')');
        return redirect('/reset-password?email=' . urlencode($email));
    }

    public function showResetPassword($request)
    {
        $email = $request->get('email');
        if (!$email) {
            return redirect('/forgot-password');
        }

        return view('auth.reset-password', ['email' => $email]);
    }

    public function resetPassword($request)
    {
        $rules = [
            'email' => 'required|email',
            'otp' => 'required',
            'password' => 'required|min:6'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fix the validation errors');
            return back();
        }

        $otpModel = new OtpReset();
        if (!$otpModel->verifyOTP($request->post('email'), $request->post('otp'))) {
            flash('error', 'Invalid or expired OTP');
            return back();
        }

        $user = $this->userModel->findByEmail($request->post('email'));
        if (!$user) {
            flash('error', 'User not found');
            return back();
        }

        $this->userModel->update($user['id'], [
            'password' => User::hashPassword($request->post('password'))
        ]);

        flash('success', 'Password reset successful! Please login.');
        return redirect('/login');
    }
}
