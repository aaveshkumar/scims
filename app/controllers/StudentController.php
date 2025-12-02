<?php

class StudentController
{
    private $studentModel;
    private $userModel;
    private $classModel;

    public function __construct()
    {
        $this->studentModel = new Student();
        $this->userModel = new User();
        $this->classModel = new ClassModel();
    }

    public function index($request)
    {
        $classId = $request->get('class_id');
        
        $query = "SELECT s.*, u.first_name, u.last_name, u.email, u.phone, c.name as class_name
                  FROM students s
                  INNER JOIN users u ON s.user_id = u.id
                  LEFT JOIN classes c ON s.class_id = c.id";
        
        $params = [];
        if ($classId) {
            $query .= " WHERE s.class_id = ?";
            $params[] = $classId;
        }
        
        $query .= " ORDER BY s.created_at DESC";
        
        $students = db()->fetchAll($query, $params);
        
        return view('students.index', [
            'students' => $students,
            'classId' => $classId
        ]);
    }

    public function create($request)
    {
        // Only admin can create students
        if (!hasRole('admin')) {
            flash('error', 'Only administrators can add students');
            return redirect('/dashboard');
        }
        
        $classes = $this->classModel->where('status', 'active')->get();
        return view('students.create', ['classes' => $classes]);
    }

    public function store($request)
    {
        // Only admin can store students
        if (!hasRole('admin')) {
            flash('error', 'Only administrators can add students');
            return redirect('/dashboard');
        }
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'gender' => 'required',
            'admission_number' => 'required',
            'class_id' => 'required|numeric',
            'admission_date' => 'required'
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

            $roleModel = new Role();
            $studentRole = $roleModel->findByName('student');
            db()->execute(
                "INSERT INTO user_roles (user_id, role_id) VALUES (?, ?)",
                [$userId, $studentRole['id']]
            );

            // Convert empty admission_date to NULL
            $admissionDate = $request->post('admission_date');
            if (empty($admissionDate) || $admissionDate === '') {
                $admissionDate = null;
            }

            $this->studentModel->create([
                'user_id' => $userId,
                'admission_number' => $request->post('admission_number'),
                'class_id' => $request->post('class_id'),
                'roll_number' => $request->post('roll_number'),
                'admission_date' => $admissionDate,
                'guardian_name' => $request->post('guardian_name'),
                'guardian_phone' => $request->post('guardian_phone'),
                'guardian_email' => $request->post('guardian_email'),
                'blood_group' => $request->post('blood_group'),
                'status' => 'active'
            ]);

            // Store temporary password in database
            $this->userModel->update($userId, [
                'temporary_password_plaintext' => $temporaryPassword
            ]);

            $this->userModel->commit();

            // ALWAYS store password in session for display to admin on current page
            $_SESSION['new_password'] = $temporaryPassword;
            $_SESSION['new_student_email'] = $request->post('email');
            $_SESSION['show_password_modal'] = true;

            // Try to send credentials email
            $emailSent = Email::sendCredentials(
                $request->post('email'),
                $request->post('first_name'),
                $request->post('last_name'),
                $temporaryPassword,
                'student'
            );

            if ($emailSent) {
                flash('success', "Student created successfully. Login credentials sent to {$request->post('email')}");
            } else {
                flash('warning', 'Student created! Email could not be sent. Password shown below.');
            }

            return redirect('/students');
        } catch (Exception $e) {
            $this->userModel->rollback();
            $errorMsg = $this->formatDatabaseError($e->getMessage());
            flash('error', 'Failed to create student: ' . $errorMsg);
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
            return 'One of the selected values (class, etc.) does not exist. Please check and try again';
        }
        if (strpos($errorMessage, 'unique') !== false) {
            return 'This record already exists. Please check the information and try again';
        }
        // Fallback: return a generic message
        return 'Database error occurred. Please check your input and try again';
        }
    }

    public function show($request, $id)
    {
        $student = db()->fetchOne(
            "SELECT s.*, u.first_name, u.last_name, u.email, u.phone, u.gender, 
                    u.date_of_birth, u.address, c.name as class_name
             FROM students s
             INNER JOIN users u ON s.user_id = u.id
             LEFT JOIN classes c ON s.class_id = c.id
             WHERE s.id = ?",
            [$id]
        );

        if (!$student) {
            flash('error', 'Student not found');
            return redirect('/students');
        }

        return view('students.show', ['student' => $student]);
    }

    public function edit($request, $id)
    {
        $student = db()->fetchOne(
            "SELECT s.id, s.user_id, s.admission_number, s.class_id, s.roll_number,
                    s.admission_date, s.guardian_name, s.guardian_phone, s.guardian_email,
                    s.guardian_relation, s.blood_group, s.status,
                    u.first_name, u.last_name, u.email, u.phone, u.gender, 
                    u.date_of_birth, u.address
             FROM students s
             INNER JOIN users u ON s.user_id = u.id
             WHERE s.id = ?",
            [$id]
        );

        if (!$student) {
            flash('error', 'Student not found');
            return redirect('/students');
        }

        $classes = $this->classModel->where('status', 'active')->get();

        return view('students.edit', ['student' => $student, 'classes' => $classes]);
    }

    public function update($request, $id)
    {
        $student = $this->studentModel->find($id);
        if (!$student) {
            flash('error', 'Student not found');
            return redirect('/students');
        }

        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fix the validation errors');
            return back();
        }

        try {
            $this->userModel->update($student['user_id'], [
                'first_name' => $request->post('first_name'),
                'last_name' => $request->post('last_name'),
                'email' => $request->post('email'),
                'phone' => $request->post('phone'),
                'gender' => $request->post('gender') ?: null,
                'date_of_birth' => $request->post('date_of_birth') ?: null,
                'address' => $request->post('address') ?: null
            ]);

            $this->studentModel->update($id, [
                'class_id' => $request->post('class_id') ?: null,
                'roll_number' => $request->post('roll_number'),
                'guardian_name' => $request->post('guardian_name'),
                'guardian_phone' => $request->post('guardian_phone'),
                'guardian_email' => $request->post('guardian_email'),
                'blood_group' => $request->post('blood_group'),
                'status' => $request->post('status') ?: 'active'
            ]);

            flash('success', 'Student updated successfully');
            return redirect('/students/' . $id);
        } catch (Exception $e) {
            flash('error', 'Failed to update student: ' . $e->getMessage());
            return back();
        }
    }

    public function resendPassword($request, $id)
    {
        // Only admin can resend passwords
        if (!hasRole('admin')) {
            flash('error', 'Only administrators can resend passwords');
            return redirect('/students');
        }

        try {
            $student = $this->studentModel->find($id);
            if (!$student) {
                flash('error', 'Student not found');
                return redirect('/students');
            }

            // Get user information
            $user = $this->userModel->find($student['user_id']);
            if (!$user) {
                flash('error', 'User not found');
                return redirect('/students');
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

            return redirect('/students');
        } catch (Exception $e) {
            flash('error', 'Failed to resend password: ' . $e->getMessage());
            return redirect('/students');
        }
    }

    public function destroy($request, $id)
    {
        try {
            $student = $this->studentModel->find($id);
            if (!$student) {
                flash('error', 'Student not found');
                return back();
            }

            // Check if deleting from class view (class_id parameter present)
            $classId = $request->get('class_id');
            if ($classId) {
                // Only remove student from class (unenroll)
                $this->studentModel->update($id, ['class_id' => null]);
                flash('success', 'Student removed from class');
                return redirect('/students?class_id=' . $classId);
            }

            // Otherwise, delete entire student record (only if no related records)
            $db = db();
            $hasAttendance = $db->fetchOne("SELECT COUNT(*) as count FROM attendance WHERE student_id = ?", [$id])['count'] > 0;
            $hasMarks = $db->fetchOne("SELECT COUNT(*) as count FROM marks WHERE student_id = ?", [$id])['count'] > 0;
            $hasInvoices = $db->fetchOne("SELECT COUNT(*) as count FROM invoices WHERE student_id = ?", [$id])['count'] > 0;
            $hasAssignments = $db->fetchOne("SELECT COUNT(*) as count FROM assignment_submissions WHERE student_id = ?", [$id])['count'] > 0;
            $hasQuizzes = $db->fetchOne("SELECT COUNT(*) as count FROM quiz_attempts WHERE student_id = ?", [$id])['count'] > 0;

            if ($hasAttendance || $hasMarks || $hasInvoices || $hasAssignments || $hasQuizzes) {
                flash('error', 'Cannot delete student with existing records. Consider marking the student as inactive instead.');
                return back();
            }

            $this->studentModel->delete($id);
            flash('success', 'Student deleted successfully');
            return redirect('/students');
        } catch (Exception $e) {
            // Check if it's a foreign key constraint error
            if (strpos($e->getMessage(), 'foreign key constraint') !== false || 
                strpos($e->getMessage(), 'Cannot delete or update a parent row') !== false) {
                flash('error', 'Cannot delete student with existing records. Consider marking the student as inactive instead.');
            } else {
                flash('error', 'Failed to delete student: ' . $e->getMessage());
            }
            return back();
        }
    }

    public function toggleStatus($request, $id)
    {
        try {
            $student = $this->studentModel->find($id);
            if (!$student) {
                return responseJSON(['success' => false, 'message' => 'Student not found'], 404);
            }

            $newStatus = $student['status'] === 'active' ? 'inactive' : 'active';
            $this->studentModel->update($id, ['status' => $newStatus]);

            return responseJSON([
                'success' => true, 
                'message' => 'Student status updated successfully',
                'status' => $newStatus
            ]);
        } catch (Exception $e) {
            return responseJSON(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function getTemporaryPassword($request, $id)
    {
        // Only admin can view credentials
        if (!hasRole('admin')) {
            return responseJSON(['error' => 'Unauthorized'], 403);
        }

        $student = $this->studentModel->find($id);
        if (!$student) {
            return responseJSON(['error' => 'Student not found'], 404);
        }

        $user = $this->userModel->find($student['user_id']);
        if (!$user) {
            return responseJSON(['error' => 'User not found'], 404);
        }

        // Handle missing or null password fields (old students or column doesn't exist)
        $password = isset($user['temporary_password_plaintext']) ? $user['temporary_password_plaintext'] : null;
        $expiresAt = isset($user['password_expires_at']) ? $user['password_expires_at'] : null;

        if (!$password || !$expiresAt) {
            return responseJSON([
                'password' => null,
                'expired' => true,
                'expires_at' => null
            ]);
        }

        // Check if password is still valid
        $expireTime = strtotime($expiresAt);
        $now = time();

        return responseJSON([
            'password' => $password,
            'expired' => $expireTime < $now,
            'expires_at' => $expiresAt
        ]);
    }
}
