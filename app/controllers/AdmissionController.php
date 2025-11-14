<?php

class AdmissionController
{
    private $admissionModel;
    private $courseModel;
    private $classModel;

    public function __construct()
    {
        $this->admissionModel = new Admission();
        $this->courseModel = new Course();
        $this->classModel = new ClassModel();
    }

    public function index($request)
    {
        $status = $request->get('status', 'all');
        
        $query = "SELECT a.*, c.name as course_name, cl.name as class_name
                  FROM admissions a
                  LEFT JOIN courses c ON a.course_id = c.id
                  LEFT JOIN classes cl ON a.class_id = cl.id";
        
        $params = [];
        if ($status !== 'all') {
            $query .= " WHERE a.status = ?";
            $params[] = $status;
        }
        
        $query .= " ORDER BY a.created_at DESC";
        
        $admissions = db()->fetchAll($query, $params);

        return view('admissions.index', ['admissions' => $admissions, 'status' => $status]);
    }

    public function create($request)
    {
        $courses = $this->courseModel->where('status', 'active')->get();
        $classes = $this->classModel->where('status', 'active')->get();

        return view('admissions.create', ['courses' => $courses, 'classes' => $classes]);
    }

    public function store($request)
    {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'date_of_birth' => 'required',
            'gender' => 'required|in:male,female,other',
            'address' => 'required',
            'guardian_name' => 'required',
            'guardian_phone' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fix the validation errors');
            return back();
        }

        try {
            $this->admissionModel->create([
                'application_number' => Admission::generateApplicationNumber(),
                'first_name' => $request->post('first_name'),
                'last_name' => $request->post('last_name'),
                'email' => $request->post('email'),
                'phone' => $request->post('phone'),
                'date_of_birth' => $request->post('date_of_birth'),
                'gender' => $request->post('gender'),
                'address' => $request->post('address'),
                'course_id' => $request->post('course_id'),
                'class_id' => $request->post('class_id'),
                'guardian_name' => $request->post('guardian_name'),
                'guardian_phone' => $request->post('guardian_phone'),
                'guardian_email' => $request->post('guardian_email'),
                'previous_school' => $request->post('previous_school'),
                'status' => 'pending'
            ]);

            flash('success', 'Admission application submitted successfully');
            return redirect('/admissions');
        } catch (Exception $e) {
            flash('error', 'Failed to submit application: ' . $e->getMessage());
            return back();
        }
    }

    public function show($request, $id)
    {
        $admission = db()->fetchOne(
            "SELECT a.*, c.name as course_name, cl.name as class_name,
                    u.first_name as reviewer_first_name, u.last_name as reviewer_last_name
             FROM admissions a
             LEFT JOIN courses c ON a.course_id = c.id
             LEFT JOIN classes cl ON a.class_id = cl.id
             LEFT JOIN users u ON a.reviewed_by = u.id
             WHERE a.id = ?",
            [$id]
        );

        if (!$admission) {
            flash('error', 'Admission not found');
            return redirect('/admissions');
        }

        return view('admissions.show', ['admission' => $admission]);
    }

    public function approve($request, $id)
    {
        $admission = $this->admissionModel->find($id);
        if (!$admission) {
            return responseJSON(['success' => false, 'message' => 'Admission not found'], 404);
        }

        try {
            $admissionObj = new Admission();
            foreach ($admission as $key => $value) {
                $admissionObj->$key = $value;
            }

            $admissionObj->approve(auth()['id']);
            $studentId = $admissionObj->convertToStudent();

            Notification::send(
                $studentId,
                'Admission Approved',
                'Congratulations! Your admission has been approved.',
                'success'
            );

            return responseJSON(['success' => true, 'message' => 'Admission approved and student created']);
        } catch (Exception $e) {
            return responseJSON(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function reject($request, $id)
    {
        $admission = $this->admissionModel->find($id);
        if (!$admission) {
            return responseJSON(['success' => false, 'message' => 'Admission not found'], 404);
        }

        try {
            $admissionObj = new Admission();
            foreach ($admission as $key => $value) {
                $admissionObj->$key = $value;
            }

            $remarks = $request->post('remarks', 'Application rejected');
            $admissionObj->reject(auth()['id'], $remarks);

            return responseJSON(['success' => true, 'message' => 'Admission rejected']);
        } catch (Exception $e) {
            return responseJSON(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
