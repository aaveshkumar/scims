<?php

class AssignmentController
{
    public function index($request)
    {
        $filters = [
            'subject_id' => $request->get('subject_id'),
            'class_id' => $request->get('class_id'),
            'status' => $request->get('status')
        ];
        
        $assignments = Assignment::getAll($filters);
        $subjects = db()->fetchAll("SELECT id, name FROM subjects ORDER BY name");
        $classes = db()->fetchAll("SELECT id, name FROM classes ORDER BY name");
        $stats = Assignment::getStatistics();
        
        return view('assignments/index', [
            'title' => 'Assignments Management',
            'assignments' => $assignments,
            'subjects' => $subjects,
            'classes' => $classes,
            'stats' => $stats,
            'filters' => $filters
        ]);
    }

    public function create($request)
    {
        $subjects = db()->fetchAll("SELECT id, name FROM subjects ORDER BY name");
        $classes = db()->fetchAll("SELECT id, name FROM classes ORDER BY name");
        
        return view('assignments/create', [
            'title' => 'Create Assignment',
            'subjects' => $subjects,
            'classes' => $classes
        ]);
    }

    public function store($request)
    {
        $rules = [
            'title' => 'required',
            'subject_id' => 'required',
            'class_id' => 'required',
            'assigned_date' => 'required',
            'due_date' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fill all required fields');
            return back();
        }

        try {
            $authUser = auth();
            $userId = isset($authUser['id']) ? $authUser['id'] : 1;
            
            $data = [
                'title' => $request->post('title'),
                'subject_id' => $request->post('subject_id'),
                'class_id' => $request->post('class_id'),
                'teacher_id' => $userId,
                'description' => $request->post('description'),
                'instructions' => $request->post('instructions'),
                'attachment_path' => $request->post('attachment_path'),
                'assigned_date' => $request->post('assigned_date'),
                'due_date' => $request->post('due_date'),
                'total_marks' => $request->post('total_marks') ?? 100,
                'status' => 'active'
            ];

            Assignment::create($data);
            flash('success', 'Assignment created successfully');
            return redirect('/assignments');
        } catch (Exception $e) {
            flash('error', 'Failed to create assignment: ' . $e->getMessage());
            return back();
        }
    }

    public function show($request, $id)
    {
        $assignment = Assignment::find($id);
        
        if (!$assignment) {
            flash('error', 'Assignment not found');
            return redirect('/assignments');
        }
        
        $submissions = Assignment::getSubmissions($id);
        
        return view('assignments/show', [
            'title' => 'Assignment Details',
            'assignment' => $assignment,
            'submissions' => $submissions
        ]);
    }

    public function edit($request, $id)
    {
        $assignment = Assignment::find($id);
        
        if (!$assignment) {
            flash('error', 'Assignment not found');
            return redirect('/assignments');
        }
        
        $subjects = db()->fetchAll("SELECT id, name FROM subjects ORDER BY name");
        $classes = db()->fetchAll("SELECT id, name FROM classes ORDER BY name");
        
        return view('assignments/edit', [
            'title' => 'Edit Assignment',
            'assignment' => $assignment,
            'subjects' => $subjects,
            'classes' => $classes
        ]);
    }

    public function update($request, $id)
    {
        $rules = [
            'title' => 'required',
            'due_date' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fill all required fields');
            return back();
        }

        try {
            $data = [
                'title' => $request->post('title'),
                'description' => $request->post('description'),
                'instructions' => $request->post('instructions'),
                'due_date' => $request->post('due_date'),
                'total_marks' => $request->post('total_marks'),
                'status' => $request->post('status')
            ];

            Assignment::update($id, $data);
            flash('success', 'Assignment updated successfully');
            return redirect('/assignments');
        } catch (Exception $e) {
            flash('error', 'Failed to update assignment: ' . $e->getMessage());
            return back();
        }
    }

    public function destroy($request, $id)
    {
        try {
            Assignment::delete($id);
            flash('success', 'Assignment deleted successfully');
            return redirect('/assignments');
        } catch (Exception $e) {
            flash('error', 'Failed to delete assignment: ' . $e->getMessage());
            return back();
        }
    }
    
    public function gradeSubmission($request, $id)
    {
        $rules = [
            'marks_obtained' => 'required|numeric'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please provide marks');
            return back();
        }

        try {
            $authUser = auth();
            $userId = isset($authUser['id']) ? $authUser['id'] : 1;
            
            AssignmentSubmission::grade(
                $id,
                $request->post('marks_obtained'),
                $request->post('feedback'),
                $userId
            );
            
            flash('success', 'Submission graded successfully');
            return back();
        } catch (Exception $e) {
            flash('error', 'Failed to grade submission: ' . $e->getMessage());
            return back();
        }
    }
}