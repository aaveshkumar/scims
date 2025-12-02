<?php

class StaffController
{
    private $staffModel;
    private $userModel;

    public function __construct()
    {
        $this->staffModel = new Staff();
        $this->userModel = new User();
    }

    public function index($request)
    {
        $staffByRole = [];
        
        // Get all staff with their roles
        $staff = db()->fetchAll(
            "SELECT s.*, u.first_name, u.last_name, u.email, u.phone,
                    COALESCE(r.name, 'teacher') as role
             FROM staff s
             INNER JOIN users u ON s.user_id = u.id
             LEFT JOIN user_roles ur ON u.id = ur.user_id
             LEFT JOIN roles r ON ur.role_id = r.id
             ORDER BY r.name, s.created_at DESC"
        );

        // Group by role
        foreach ($staff as $member) {
            $role = $member['role'] ?: 'teacher';
            if (!isset($staffByRole[$role])) {
                $staffByRole[$role] = [];
            }
            $staffByRole[$role][] = $member;
        }

        // Sort roles in a specific order
        $roleOrder = ['admin', 'teacher', 'accountant', 'librarian'];
        $sortedStaffByRole = [];
        foreach ($roleOrder as $role) {
            if (isset($staffByRole[$role])) {
                $sortedStaffByRole[$role] = $staffByRole[$role];
            }
        }
        // Add any remaining roles not in the order
        foreach ($staffByRole as $role => $members) {
            if (!in_array($role, $roleOrder)) {
                $sortedStaffByRole[$role] = $members;
            }
        }

        return view('staff.index', ['staffByRole' => $sortedStaffByRole]);
    }

    public function create($request)
    {
        // Only admin can create staff/teachers/parents
        if (!hasRole('admin')) {
            flash('error', 'Only administrators can add staff members');
            return redirect('/dashboard');
        }
        
        // Get all departments
        $departments = db()->fetchAll("SELECT * FROM departments WHERE status = 'active' ORDER BY name");
        
        // Get all available roles
        $allRoles = db()->fetchAll("SELECT * FROM roles ORDER BY name");
        
        return view('staff.create', ['departments' => $departments, 'allRoles' => $allRoles]);
    }

    public function store($request)
    {
        // Only admin can store staff/teachers/parents
        if (!hasRole('admin')) {
            flash('error', 'Only administrators can add staff members');
            return redirect('/dashboard');
        }
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'gender' => 'required',
            'employee_id' => 'required',
            'designation' => 'required',
            'joining_date' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fix the validation errors');
            return back();
        }

        try {
            $this->userModel->beginTransaction();

            // Generate temporary password
            $temporaryPassword = PasswordGenerator::generate();
            $passwordExpiresAt = date('Y-m-d H:i:s', strtotime('+7 days'));

            // Convert empty date fields to NULL (PostgreSQL doesn't accept empty strings for dates)
            $dateOfBirth = $request->post('date_of_birth');
            if (empty($dateOfBirth) || $dateOfBirth === '') {
                $dateOfBirth = null;
            }

            $userId = $this->userModel->create([
                'first_name' => $request->post('first_name'),
                'last_name' => $request->post('last_name'),
                'email' => $request->post('email'),
                'phone' => $request->post('phone'),
                'password' => User::hashPassword($temporaryPassword),
                'gender' => $request->post('gender'),
                'date_of_birth' => $dateOfBirth,
                'address' => $request->post('address'),
                'status' => 'active',
                'password_temporary' => true,
                'password_expires_at' => $passwordExpiresAt
            ]);

            $role = $request->post('role', 'teacher');
            $roleModel = new Role();
            $staffRole = $roleModel->findByName($role);
            
            if ($staffRole) {
                db()->execute(
                    "INSERT INTO user_roles (user_id, role_id) VALUES (?, ?)",
                    [$userId, $staffRole['id']]
                );
            }

            // Convert empty joining_date to NULL
            $joiningDate = $request->post('joining_date');
            if (empty($joiningDate) || $joiningDate === '') {
                $joiningDate = null;
            }

            $this->staffModel->create([
                'user_id' => $userId,
                'employee_id' => $request->post('employee_id'),
                'designation' => $request->post('designation'),
                'department' => $request->post('department'),
                'qualification' => $request->post('qualification'),
                'experience_years' => $request->post('experience_years'),
                'joining_date' => $joiningDate,
                'salary' => $request->post('salary'),
                'bank_name' => $request->post('bank_name'),
                'account_number' => $request->post('account_number'),
                'emergency_contact' => $request->post('emergency_contact'),
                'status' => 'active'
            ]);

            // Store temporary password in database
            $this->userModel->update($userId, [
                'temporary_password_plaintext' => $temporaryPassword
            ]);

            $this->userModel->commit();

            // ALWAYS store password in session for display to admin on current page
            $_SESSION['new_password'] = $temporaryPassword;
            $_SESSION['new_staff_email'] = $request->post('email');
            $_SESSION['show_password_modal'] = true;

            // Try to send credentials email
            $emailSent = Email::sendCredentials(
                $request->post('email'),
                $request->post('first_name'),
                $request->post('last_name'),
                $temporaryPassword,
                ucfirst($role)
            );

            if ($emailSent) {
                flash('success', "Staff member created successfully. Login credentials sent to {$request->post('email')}");
            } else {
                flash('warning', 'Staff member created! Email could not be sent. Password shown below.');
            }

            return redirect('/staff');
        } catch (Exception $e) {
            $this->userModel->rollback();
            $errorMsg = $this->formatDatabaseError($e->getMessage());
            flash('error', 'Failed to create staff member: ' . $errorMsg);
            return back();
        }
    }

    private function formatDatabaseError($errorMessage)
    {
        // Extract meaningful error from database exception
        if (strpos($errorMessage, 'gender_check') !== false) {
            return 'Gender field is required and must be a valid option (Male, Female, Other)';
        }
        if (strpos($errorMessage, 'email') !== false) {
            return 'Email is invalid or already exists. Please use a valid, unique email address';
        }
        if (strpos($errorMessage, 'phone') !== false) {
            return 'Phone number is invalid or already exists';
        }
        if (strpos($errorMessage, 'date') !== false || strpos($errorMessage, 'datetime') !== false) {
            return 'Please enter valid dates in the correct format';
        }
        if (strpos($errorMessage, 'foreign key') !== false) {
            return 'One of the selected values (department, role, etc.) does not exist. Please check and try again';
        }
        if (strpos($errorMessage, 'unique') !== false) {
            return 'This record already exists. Please check the information and try again';
        }
        // Fallback: return a generic message
        return 'Database error occurred. Please check your input and try again';
    }

    public function show($request, $id)
    {
        $staff = db()->fetchOne(
            "SELECT s.*, u.first_name, u.last_name, u.email, u.phone, u.gender,
                    u.date_of_birth, u.address
             FROM staff s
             INNER JOIN users u ON s.user_id = u.id
             WHERE s.id = ?",
            [$id]
        );

        if (!$staff) {
            flash('error', 'Staff member not found');
            return redirect('/staff');
        }

        return view('staff.show', ['staff' => $staff]);
    }

    public function edit($request, $id)
    {
        $staff = db()->fetchOne(
            "SELECT s.id, s.user_id, s.designation, s.department, s.qualification,
                    s.experience_years, s.salary, s.joining_date, s.bank_name, s.account_number,
                    s.emergency_contact, s.status,
                    u.first_name, u.last_name, u.email, u.phone, u.gender, 
                    u.date_of_birth, u.address
             FROM staff s
             INNER JOIN users u ON s.user_id = u.id
             WHERE s.id = ?",
            [$id]
        );

        if (!$staff) {
            flash('error', 'Staff member not found');
            return redirect('/staff');
        }

        // Get all departments
        $departments = db()->fetchAll("SELECT * FROM departments WHERE status = 'active' ORDER BY name");

        // Get all available roles
        $allRoles = db()->fetchAll("SELECT * FROM roles ORDER BY name");

        // Get current role
        $currentRoles = db()->fetchAll(
            "SELECT r.name FROM roles r 
             INNER JOIN user_roles ur ON r.id = ur.role_id 
             WHERE ur.user_id = ?",
            [$staff['user_id']]
        );
        $staff['current_role'] = !empty($currentRoles) ? $currentRoles[0]['name'] : 'teacher';

        return view('staff.edit', ['staff' => $staff, 'departments' => $departments, 'allRoles' => $allRoles]);
    }

    public function update($request, $id)
    {
        $staff = $this->staffModel->find($id);
        if (!$staff) {
            flash('error', 'Staff member not found');
            return redirect('/staff');
        }

        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'designation' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fix the validation errors');
            return back();
        }

        try {
            // Handle empty date_of_birth
            $dateOfBirth = $request->post('date_of_birth');
            if (empty($dateOfBirth)) {
                $dateOfBirth = null;
            }

            $this->userModel->update($staff['user_id'], [
                'first_name' => $request->post('first_name'),
                'last_name' => $request->post('last_name'),
                'email' => $request->post('email'),
                'phone' => $request->post('phone'),
                'gender' => $request->post('gender') ?: null,
                'date_of_birth' => $dateOfBirth,
                'address' => $request->post('address')
            ]);

            $this->staffModel->update($id, [
                'designation' => $request->post('designation'),
                'department' => $request->post('department'),
                'qualification' => $request->post('qualification'),
                'experience_years' => $request->post('experience_years') ?: null,
                'salary' => $request->post('salary') ?: null,
                'bank_name' => $request->post('bank_name'),
                'account_number' => $request->post('account_number'),
                'emergency_contact' => $request->post('emergency_contact')
            ]);

            // Handle role update if user is admin
            if (hasRole('admin') && $request->post('role')) {
                $newRole = $request->post('role');
                $roleModel = new Role();
                $newRoleData = $roleModel->findByName($newRole);

                if ($newRoleData) {
                    // Delete old roles
                    db()->execute("DELETE FROM user_roles WHERE user_id = ?", [$staff['user_id']]);
                    // Assign new role
                    db()->execute(
                        "INSERT INTO user_roles (user_id, role_id) VALUES (?, ?)",
                        [$staff['user_id'], $newRoleData['id']]
                    );
                }
            }

            flash('success', 'Staff member updated successfully');
            return redirect('/staff/' . $id);
        } catch (Exception $e) {
            flash('error', 'Failed to update staff member. Please check all fields and try again.');
            return back();
        }
    }

    public function resendPassword($request, $id)
    {
        // Only admin can resend passwords
        if (!hasRole('admin')) {
            flash('error', 'Only administrators can resend passwords');
            return redirect('/staff');
        }

        try {
            $staff = $this->staffModel->find($id);
            if (!$staff) {
                flash('error', 'Staff member not found');
                return redirect('/staff');
            }

            // Get user information
            $user = $this->userModel->find($staff['user_id']);
            if (!$user) {
                flash('error', 'User not found');
                return redirect('/staff');
            }

            // Generate new temporary password
            $temporaryPassword = PasswordGenerator::generate();
            $passwordExpiresAt = date('Y-m-d H:i:s', strtotime('+7 days'));

            // Update user with new password and reset expiration
            $this->userModel->update($user['id'], [
                'password' => User::hashPassword($temporaryPassword),
                'password_temporary' => true,
                'password_expires_at' => $passwordExpiresAt
            ]);

            // Send email with new credentials
            $emailSent = Email::sendPasswordReset(
                $user['email'],
                $user['first_name'],
                $temporaryPassword
            );

            if ($emailSent) {
                flash('success', "New password sent to {$user['email']}. Password expires in 7 days.");
            } else {
                flash('warning', 'Password reset but email could not be sent. New password: ' . substr($temporaryPassword, 0, 4) . '****');
            }

            return redirect('/staff');
        } catch (Exception $e) {
            flash('error', 'Failed to resend password: ' . $e->getMessage());
            return redirect('/staff');
        }
    }

    public function destroy($request, $id)
    {
        try {
            $staff = $this->staffModel->find($id);
            if (!$staff) {
                flash('error', 'Staff member not found');
                return redirect('/staff');
            }

            // Delete the associated user as well
            $userId = $staff['user_id'];
            $this->staffModel->delete($id);
            $this->userModel->delete($userId);

            flash('success', 'Staff member deleted successfully');
            return redirect('/staff');
        } catch (Exception $e) {
            flash('error', 'Failed to delete staff member: ' . $e->getMessage());
            return redirect('/staff');
        }
    }

    public function toggleStatus($request, $id)
    {
        try {
            $staff = $this->staffModel->find($id);
            if (!$staff) {
                return responseJSON(['success' => false, 'message' => 'Staff member not found'], 404);
            }

            $newStatus = $staff['status'] === 'active' ? 'inactive' : 'active';
            $this->staffModel->update($id, ['status' => $newStatus]);

            return responseJSON([
                'success' => true, 
                'message' => 'Staff status updated successfully',
                'status' => $newStatus
            ]);
        } catch (Exception $e) {
            return responseJSON(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function getTemporaryPassword($request, $id)
    {
        if (!hasRole('admin')) {
            return responseJSON(['error' => 'Unauthorized'], 403);
        }

        $staff = $this->staffModel->find($id);
        if (!$staff) {
            return responseJSON(['error' => 'Staff not found'], 404);
        }

        $user = $this->userModel->find($staff['user_id']);
        if (!$user) {
            return responseJSON(['error' => 'User not found'], 404);
        }

        // Handle missing or null password fields (old staff or column doesn't exist)
        $password = isset($user['temporary_password_plaintext']) ? $user['temporary_password_plaintext'] : null;
        $expiresAt = isset($user['password_expires_at']) ? $user['password_expires_at'] : null;

        if (!$password || !$expiresAt) {
            return responseJSON([
                'password' => null,
                'expired' => true,
                'expires_at' => null
            ]);
        }

        $expireTime = strtotime($expiresAt);
        $now = time();

        return responseJSON([
            'password' => $password,
            'expired' => $expireTime < $now,
            'expires_at' => $expiresAt
        ]);
    }
}
