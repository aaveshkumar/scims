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
            'password' => 'required|min:6'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fix the validation errors');
            return back();
        }

        $email = $request->post('email');
        $password = $request->post('password');

        $user = $this->userModel->findByEmail($email);

        if (!$user || !$this->userModel->verifyPassword($password, $user['password'])) {
            flash('error', 'Invalid email or password');
            return back();
        }

        if ($user['status'] !== 'active') {
            flash('error', 'Your account is inactive. Please contact administrator.');
            return back();
        }

        $roles = $this->userModel->roles();
        $user['roles'] = $roles;

        $_SESSION['user'] = $user;

        flash('success', 'Welcome back, ' . $user['first_name'] . '!');
        return redirect('/dashboard');
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
