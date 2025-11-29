<?php

class SubjectController
{
    private $subjectModel;
    private $courseModel;
    private $classModel;

    public function __construct()
    {
        $this->subjectModel = new Subject();
        $this->courseModel = new Course();
        $this->classModel = new ClassModel();
    }

    public function index($request)
    {
        $classId = $request->get('class_id');
        
        $query = "SELECT s.*, c.name as course_name, cl.name as class_name,
                    u.first_name as teacher_first_name, u.last_name as teacher_last_name
             FROM subjects s
             LEFT JOIN courses c ON s.course_id = c.id
             LEFT JOIN classes cl ON s.class_id = cl.id
             LEFT JOIN users u ON s.teacher_id = u.id";
        
        $params = [];
        if ($classId) {
            $query .= " WHERE s.class_id = ?";
            $params[] = $classId;
        }
        
        $query .= " ORDER BY s.created_at DESC";
        
        $subjects = db()->fetchAll($query, $params);

        return view('subjects.index', ['subjects' => $subjects, 'classId' => $classId]);
    }

    public function create($request)
    {
        $courses = $this->courseModel->where('status', 'active')->get();
        $classes = $this->classModel->where('status', 'active')->get();
        
        // Get all active staff/teachers only
        $teachers = db()->fetchAll(
            "SELECT u.id, u.first_name, u.last_name 
             FROM users u
             INNER JOIN staff s ON u.id = s.user_id
             WHERE u.status = 'active' AND s.status = 'active'
             ORDER BY u.first_name, u.last_name"
        );

        return view('subjects.create', [
            'courses' => $courses,
            'classes' => $classes,
            'teachers' => $teachers
        ]);
    }

    public function store($request)
    {
        $rules = [
            'name' => 'required',
            'code' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fix the validation errors');
            return back();
        }

        try {
            $this->subjectModel->create([
                'name' => $request->post('name'),
                'code' => $request->post('code'),
                'course_id' => $request->post('course_id') ?: null,
                'class_id' => $request->post('class_id') ?: null,
                'teacher_id' => $request->post('teacher_id') ?: null,
                'credits' => $request->post('credits') ?: null,
                'type' => $request->post('type', 'theory'),
                'description' => $request->post('description'),
                'status' => $request->post('status', 'active')
            ]);

            flash('success', 'Subject created successfully');
            return redirect('/subjects');
        } catch (Exception $e) {
            flash('error', 'Failed to create subject: ' . $e->getMessage());
            return back();
        }
    }

    public function show($request, $id)
    {
        $subject = db()->fetchOne(
            "SELECT s.*, c.name as course_name, cl.name as class_name,
                    u.first_name as teacher_first_name, u.last_name as teacher_last_name
             FROM subjects s
             LEFT JOIN courses c ON s.course_id = c.id
             LEFT JOIN classes cl ON s.class_id = cl.id
             LEFT JOIN users u ON s.teacher_id = u.id
             WHERE s.id = ?",
            [$id]
        );

        if (!$subject) {
            flash('error', 'Subject not found');
            return redirect('/subjects');
        }

        return view('subjects.show', ['subject' => $subject]);
    }

    public function edit($request, $id)
    {
        $subject = $this->subjectModel->find($id);
        if (!$subject) {
            flash('error', 'Subject not found');
            return redirect('/subjects');
        }

        $courses = $this->courseModel->where('status', 'active')->get();
        $classes = $this->classModel->where('status', 'active')->get();
        
        // Get all active staff/teachers only
        $teachers = db()->fetchAll(
            "SELECT u.id, u.first_name, u.last_name 
             FROM users u
             INNER JOIN staff s ON u.id = s.user_id
             WHERE u.status = 'active' AND s.status = 'active'
             ORDER BY u.first_name, u.last_name"
        );

        return view('subjects.edit', [
            'subject' => $subject,
            'courses' => $courses,
            'classes' => $classes,
            'teachers' => $teachers
        ]);
    }

    public function update($request, $id)
    {
        $rules = [
            'name' => 'required',
            'code' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fix the validation errors');
            return back();
        }

        try {
            $this->subjectModel->update($id, [
                'name' => $request->post('name'),
                'code' => $request->post('code'),
                'course_id' => $request->post('course_id') ?: null,
                'class_id' => $request->post('class_id') ?: null,
                'teacher_id' => $request->post('teacher_id') ?: null,
                'credits' => $request->post('credits') ?: null,
                'type' => $request->post('type'),
                'description' => $request->post('description'),
                'status' => $request->post('status')
            ]);

            flash('success', 'Subject updated successfully');
            return redirect('/subjects');
        } catch (Exception $e) {
            flash('error', 'Failed to update subject: ' . $e->getMessage());
            return back();
        }
    }

    public function destroy($request, $id)
    {
        try {
            $this->subjectModel->delete($id);
            return responseJSON(['success' => true, 'message' => 'Subject deleted successfully']);
        } catch (Exception $e) {
            return responseJSON(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
