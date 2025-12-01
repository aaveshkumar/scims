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
        // Get all departments
        $departments = db()->fetchAll("SELECT * FROM departments WHERE status = 'active' ORDER BY name");
        
        return view('staff.create', ['departments' => $departments]);
    }

    public function store($request)
    {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
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

            $userId = $this->userModel->create([
                'first_name' => $request->post('first_name'),
                'last_name' => $request->post('last_name'),
                'email' => $request->post('email'),
                'phone' => $request->post('phone'),
                'password' => User::hashPassword('password123'),
                'gender' => $request->post('gender'),
                'date_of_birth' => $request->post('date_of_birth'),
                'address' => $request->post('address'),
                'status' => 'active'
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

            $this->staffModel->create([
                'user_id' => $userId,
                'employee_id' => $request->post('employee_id'),
                'designation' => $request->post('designation'),
                'department' => $request->post('department'),
                'qualification' => $request->post('qualification'),
                'experience_years' => $request->post('experience_years'),
                'joining_date' => $request->post('joining_date'),
                'salary' => $request->post('salary'),
                'bank_name' => $request->post('bank_name'),
                'account_number' => $request->post('account_number'),
                'emergency_contact' => $request->post('emergency_contact'),
                'status' => 'active'
            ]);

            $this->userModel->commit();

            flash('success', 'Staff member created successfully');
            return redirect('/staff');
        } catch (Exception $e) {
            $this->userModel->rollback();
            flash('error', 'Failed to create staff member: ' . $e->getMessage());
            return back();
        }
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
}
