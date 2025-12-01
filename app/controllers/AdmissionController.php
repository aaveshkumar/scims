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

    /**
     * Admin: List all applications with filters
     */
    public function index($request)
    {
        $status = $request->get('status', 'all');
        $search = $request->get('search', '');
        
        $query = "SELECT a.*, c.name as course_name, cl.name as class_name
                  FROM admissions a
                  LEFT JOIN courses c ON a.course_id = c.id
                  LEFT JOIN classes cl ON a.class_id = cl.id WHERE 1=1";
        
        $params = [];
        
        if ($status !== 'all') {
            $query .= " AND a.status = ?";
            $params[] = $status;
        }
        
        if ($search) {
            $query .= " AND (a.first_name LIKE ? OR a.last_name LIKE ? OR a.email LIKE ? OR a.application_number LIKE ?)";
            $searchTerm = "%{$search}%";
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $params[] = $searchTerm;
            $params[] = $searchTerm;
        }
        
        $query .= " ORDER BY a.created_at DESC";
        
        $db = Database::getInstance();
        $admissions = $db->fetchAll($query, $params);
        $statistics = Admission::getStatistics();

        return view('admissions/index', [
            'title' => 'Admissions Management',
            'admissions' => $admissions,
            'statistics' => $statistics,
            'status' => $status,
            'search' => $search
        ]);
    }

    /**
     * Public/Admin: Show application form
     */
    public function create($request)
    {
        $courses = $this->courseModel->where('status', 'active')->get();
        $classes = $this->classModel->where('status', 'active')->get();

        return view('admissions/create', [
            'title' => 'New Admission Application',
            'courses' => $courses,
            'classes' => $classes
        ]);
    }

    /**
     * Public/Admin: Submit application
     */
    public function store($request)
    {
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'date_of_birth' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'course_id' => 'required',
            'class_id' => 'required',
            'guardian_name' => 'required',
            'guardian_phone' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fix the validation errors');
            return back();
        }

        try {
            $applicationNumber = Admission::generateApplicationNumber();
            
            // Handle document uploads if any
            $documents = [];
            if ($request->hasFile('photo')) {
                $photoPath = uploadFile($request->file('photo'), 'uploads/admissions');
                if ($photoPath) {
                    $documents['photo'] = $photoPath;
                }
            }
            
            if ($request->hasFile('id_proof')) {
                $idProofPath = uploadFile($request->file('id_proof'), 'uploads/admissions');
                if ($idProofPath) {
                    $documents['id_proof'] = $idProofPath;
                }
            }
            
            if ($request->hasFile('birth_certificate')) {
                $birthCertPath = uploadFile($request->file('birth_certificate'), 'uploads/admissions');
                if ($birthCertPath) {
                    $documents['birth_certificate'] = $birthCertPath;
                }
            }

            $this->admissionModel->create([
                'application_number' => $applicationNumber,
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
                'documents' => !empty($documents) ? json_encode($documents) : null,
                'status' => 'pending'
            ]);

            flash('success', "Application submitted successfully! Your Application Number is: <strong>{$applicationNumber}</strong>. Please save it for tracking.");
            
            // Redirect based on user role
            if (isAuth() && hasRole('admin')) {
                return redirect('/admissions');
            } else {
                return redirect('/admission/track?number=' . $applicationNumber);
            }
            
        } catch (Exception $e) {
            flash('error', 'Failed to submit application: ' . $e->getMessage());
            return back();
        }
    }

    /**
     * Admin/Applicant: View application details
     */
    public function show($request, $id)
    {
        $db = Database::getInstance();
        $admission = $db->fetchOne(
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
            flash('error', 'Application not found');
            return redirect('/admissions');
        }

        $timeline = Admission::getTimeline($id);

        return view('admissions/show', [
            'title' => 'Application Details',
            'admission' => $admission,
            'timeline' => $timeline
        ]);
    }

    /**
     * Admin: Show edit form (admin only)
     */
    public function edit($request, $id)
    {
        if (!hasRole('admin')) {
            flash('error', 'Unauthorized action');
            return redirect('/admissions');
        }
        
        $admission = $this->admissionModel->find($id);
        
        if (!$admission) {
            flash('error', 'Application not found');
            return redirect('/admissions');
        }
        
        // Only allow editing if pending or waitlisted
        if (!in_array($admission['status'], ['pending', 'waitlisted'])) {
            flash('error', 'This application cannot be edited');
            return redirect('/admissions/' . $id);
        }
        
        $courses = $this->courseModel->where('status', 'active')->get();
        $classes = $this->classModel->where('status', 'active')->get();
        
        return view('admissions/edit', [
            'title' => 'Edit Application',
            'admission' => $admission,
            'courses' => $courses,
            'classes' => $classes
        ]);
    }

    /**
     * Admin: Update application (admin only)
     */
    public function update($request, $id)
    {
        if (!hasRole('admin')) {
            flash('error', 'Unauthorized action');
            return redirect('/admissions');
        }
        
        $admission = $this->admissionModel->find($id);
        
        if (!$admission) {
            flash('error', 'Application not found');
            return redirect('/admissions');
        }
        
        // Only allow editing if pending or waitlisted
        if (!in_array($admission['status'], ['pending', 'waitlisted'])) {
            flash('error', 'This application cannot be edited');
            return redirect('/admissions/' . $id);
        }
        
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'date_of_birth' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'course_id' => 'required',
            'class_id' => 'required',
            'guardian_name' => 'required',
            'guardian_phone' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fix the validation errors');
            return back();
        }

        try {
            $data = [
                'first_name' => $request->post('first_name'),
                'last_name' => $request->post('last_name'),
                'email' => $request->post('email'),
                'phone' => $request->post('phone'),
                'date_of_birth' => $request->post('date_of_birth'),
                'gender' => $request->post('gender'),
                'address' => $request->post('address'),
                'course_id' => $request->post('course_id'),
                'class_id' => $request->post('class_id'),
                'previous_school' => $request->post('previous_school'),
                'guardian_name' => $request->post('guardian_name'),
                'guardian_phone' => $request->post('guardian_phone'),
                'guardian_email' => $request->post('guardian_email')
            ];

            $this->admissionModel->update($id, $data);
            
            flash('success', 'Application updated successfully!');
            return redirect('/admissions/' . $id);
            
        } catch (Exception $e) {
            flash('error', 'Failed to update application: ' . $e->getMessage());
            return back();
        }
    }

    /**
     * Admin: Approve application
     */
    public function approve($request, $id)
    {
        if (!hasRole('admin')) {
            flash('error', 'Unauthorized action');
            return redirect('/admissions');
        }

        try {
            $userId = auth()['id'];
            $remarks = $request->post('remarks', 'Application approved');
            
            // Approve the application
            Admission::approveApplication($id, $userId, $remarks);
            
            flash('success', 'Application approved successfully!');
            return redirect('/admissions/' . $id);
            
        } catch (Exception $e) {
            flash('error', 'Failed to approve application: ' . $e->getMessage());
            return back();
        }
    }

    /**
     * Admin: Reject application
     */
    public function reject($request, $id)
    {
        if (!hasRole('admin')) {
            flash('error', 'Unauthorized action');
            return redirect('/admissions');
        }

        try {
            $userId = auth()['id'];
            $remarks = $request->post('remarks', 'Application rejected');
            
            if (empty($remarks)) {
                flash('error', 'Please provide a reason for rejection');
                return back();
            }
            
            Admission::rejectApplication($id, $userId, $remarks);
            
            flash('success', 'Application rejected');
            return redirect('/admissions/' . $id);
            
        } catch (Exception $e) {
            flash('error', 'Failed to reject application: ' . $e->getMessage());
            return back();
        }
    }

    /**
     * Admin: Move to waitlist
     */
    public function waitlist($request, $id)
    {
        if (!hasRole('admin')) {
            flash('error', 'Unauthorized action');
            return redirect('/admissions');
        }

        try {
            $userId = auth()['id'];
            $remarks = $request->post('remarks', 'Application waitlisted');
            
            Admission::waitlistApplication($id, $userId, $remarks);
            
            flash('success', 'Application moved to waitlist');
            return redirect('/admissions/' . $id);
            
        } catch (Exception $e) {
            flash('error', 'Failed to waitlist application: ' . $e->getMessage());
            return back();
        }
    }

    /**
     * Admin: Convert approved application to student
     */
    public function convertToStudent($request, $id)
    {
        if (!hasRole('admin')) {
            flash('error', 'Unauthorized action');
            return redirect('/admissions');
        }

        try {
            $result = Admission::convertToStudent($id);
            
            if ($result['success']) {
                flash('success', $result['message'] . '. Default password: ' . $result['default_password']);
                return redirect('/students/' . $result['student_id']);
            } else {
                flash('error', $result['message']);
                return back();
            }
            
        } catch (Exception $e) {
            flash('error', 'Unable to convert applicant to student. Please try again or contact support.');
            return back();
        }
    }

    /**
     * Public: Track application by application number
     */
    public function track($request)
    {
        $applicationNumber = $request->get('number', '');
        $admission = null;
        $timeline = [];
        
        if ($applicationNumber) {
            $admission = Admission::trackApplication($applicationNumber);
            if ($admission) {
                $timeline = Admission::getTimeline($admission['id']);
            }
        }

        return view('admissions/track', [
            'title' => 'Track Application',
            'applicationNumber' => $applicationNumber,
            'admission' => $admission,
            'timeline' => $timeline
        ]);
    }

    /**
     * Admin: Application statistics and reports
     */
    public function statistics($request)
    {
        if (!hasRole('admin')) {
            flash('error', 'Unauthorized action');
            return redirect('/dashboard');
        }

        $statistics = Admission::getStatistics();
        
        // Get monthly applications data
        $db = Database::getInstance();
        $monthlyData = $db->fetchAll(
            "SELECT TO_CHAR(created_at, 'YYYY-MM') as month, 
                    COUNT(*) as total,
                    SUM(CASE WHEN status = 'approved' THEN 1 ELSE 0 END) as approved,
                    SUM(CASE WHEN status = 'rejected' THEN 1 ELSE 0 END) as rejected,
                    SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending
             FROM admissions
             WHERE created_at >= NOW() - INTERVAL '6 months'
             GROUP BY TO_CHAR(created_at, 'YYYY-MM')
             ORDER BY month DESC"
        );

        return view('admissions/statistics', [
            'title' => 'Admission Statistics',
            'statistics' => $statistics,
            'monthlyData' => $monthlyData
        ]);
    }
}
