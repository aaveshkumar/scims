<?php

class ClassController
{
    private $classModel;
    private $courseModel;

    public function __construct()
    {
        $this->classModel = new ClassModel();
        $this->courseModel = new Course();
    }

    public function index($request)
    {
        $classes = db()->fetchAll(
            "SELECT c.*, co.name as course_name
             FROM classes c
             LEFT JOIN courses co ON c.course_id = co.id
             ORDER BY c.created_at DESC"
        );

        return view('classes.index', ['classes' => $classes]);
    }

    public function create($request)
    {
        $courses = $this->courseModel->where('status', 'active')->get();
        return view('classes.create', ['courses' => $courses]);
    }

    public function store($request)
    {
        $rules = [
            'name' => 'required',
            'academic_year' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fix the validation errors');
            return back();
        }

        try {
            // Generate unique code
            $baseCode = strtoupper(substr($request->post('name'), 0, 3)) . '-' . date('y');
            $code = $baseCode;
            $counter = 1;
            
            // Check for existing code and append counter if needed
            while (db()->fetchOne("SELECT id FROM classes WHERE code = ?", [$code])) {
                $code = $baseCode . '-' . $counter;
                $counter++;
                if ($counter > 100) {
                    throw new Exception('Unable to generate unique class code');
                }
            }
            
            $this->classModel->create([
                'name' => $request->post('name'),
                'code' => $code,
                'course_id' => $request->post('course_id') ?: null,
                'section' => $request->post('section'),
                'academic_year' => $request->post('academic_year'),
                'capacity' => $request->post('capacity') ?: null,
                'room_number' => $request->post('room_number'),
                'status' => 'active'
            ]);

            flash('success', 'Class created successfully');
            return redirect('/classes');
        } catch (Exception $e) {
            flash('error', 'Failed to create class: ' . $e->getMessage());
            return back();
        }
    }

    public function show($request, $id)
    {
        $class = db()->fetchOne(
            "SELECT c.*, co.name as course_name
             FROM classes c
             LEFT JOIN courses co ON c.course_id = co.id
             WHERE c.id = ?",
            [$id]
        );

        if (!$class) {
            flash('error', 'Class not found');
            return redirect('/classes');
        }

        $classObj = new ClassModel();
        foreach ($class as $key => $value) {
            $classObj->$key = $value;
        }

        $studentCount = $classObj->getStudentCount();

        return view('classes.show', ['class' => $class, 'studentCount' => $studentCount]);
    }

    public function edit($request, $id)
    {
        $class = $this->classModel->find($id);
        if (!$class) {
            flash('error', 'Class not found');
            return redirect('/classes');
        }

        $courses = $this->courseModel->where('status', 'active')->get();

        return view('classes.edit', ['class' => $class, 'courses' => $courses]);
    }

    public function update($request, $id)
    {
        $rules = [
            'name' => 'required',
            'code' => 'required',
            'academic_year' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fix the validation errors');
            return back();
        }

        try {
            $this->classModel->update($id, [
                'name' => $request->post('name'),
                'code' => $request->post('code'),
                'course_id' => $request->post('course_id'),
                'section' => $request->post('section'),
                'academic_year' => $request->post('academic_year'),
                'capacity' => $request->post('capacity'),
                'room_number' => $request->post('room_number'),
                'status' => $request->post('status')
            ]);

            flash('success', 'Class updated successfully');
            return redirect('/classes');
        } catch (Exception $e) {
            flash('error', 'Failed to update class: ' . $e->getMessage());
            return back();
        }
    }

    public function destroy($request, $id)
    {
        try {
            $this->classModel->delete($id);
            return responseJSON(['success' => true, 'message' => 'Class deleted successfully']);
        } catch (Exception $e) {
            return responseJSON(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
