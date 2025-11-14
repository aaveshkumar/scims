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
        $students = db()->fetchAll(
            "SELECT s.*, u.first_name, u.last_name, u.email, u.phone, c.name as class_name
             FROM students s
             INNER JOIN users u ON s.user_id = u.id
             LEFT JOIN classes c ON s.class_id = c.id
             ORDER BY s.created_at DESC"
        );

        return view('students.index', ['students' => $students]);
    }

    public function create($request)
    {
        $classes = $this->classModel->where('status', 'active')->get();
        return view('students.create', ['classes' => $classes]);
    }

    public function store($request)
    {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
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

            $roleModel = new Role();
            $studentRole = $roleModel->findByName('student');
            db()->execute(
                "INSERT INTO user_roles (user_id, role_id) VALUES (?, ?)",
                [$userId, $studentRole['id']]
            );

            $this->studentModel->create([
                'user_id' => $userId,
                'admission_number' => $request->post('admission_number'),
                'class_id' => $request->post('class_id'),
                'roll_number' => $request->post('roll_number'),
                'admission_date' => $request->post('admission_date'),
                'guardian_name' => $request->post('guardian_name'),
                'guardian_phone' => $request->post('guardian_phone'),
                'guardian_email' => $request->post('guardian_email'),
                'blood_group' => $request->post('blood_group'),
                'status' => 'active'
            ]);

            $this->userModel->commit();

            flash('success', 'Student created successfully');
            return redirect('/students');
        } catch (Exception $e) {
            $this->userModel->rollback();
            flash('error', 'Failed to create student: ' . $e->getMessage());
            return back();
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
            "SELECT s.*, u.* FROM students s
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
                'gender' => $request->post('gender'),
                'date_of_birth' => $request->post('date_of_birth'),
                'address' => $request->post('address')
            ]);

            $this->studentModel->update($id, [
                'class_id' => $request->post('class_id'),
                'roll_number' => $request->post('roll_number'),
                'guardian_name' => $request->post('guardian_name'),
                'guardian_phone' => $request->post('guardian_phone'),
                'guardian_email' => $request->post('guardian_email'),
                'blood_group' => $request->post('blood_group')
            ]);

            flash('success', 'Student updated successfully');
            return redirect('/students/' . $id);
        } catch (Exception $e) {
            flash('error', 'Failed to update student: ' . $e->getMessage());
            return back();
        }
    }

    public function destroy($request, $id)
    {
        try {
            $student = $this->studentModel->find($id);
            if (!$student) {
                return responseJSON(['success' => false, 'message' => 'Student not found'], 404);
            }

            $this->studentModel->delete($id);

            return responseJSON(['success' => true, 'message' => 'Student deleted successfully']);
        } catch (Exception $e) {
            return responseJSON(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
