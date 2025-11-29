<?php

class SyllabusController
{
    private $syllabusModel;

    public function __construct()
    {
        $this->syllabusModel = new Syllabus();
    }

    public function index($request)
    {
        $syllabuses = $this->syllabusModel->orderBy('created_at', 'DESC')->get();
        return view('syllabus/index', ['syllabuses' => $syllabuses, 'title' => 'Syllabus Management']);
    }

    public function create($request)
    {
        return view('syllabus/create', ['title' => 'Create - Syllabus Management']);
    }

    public function store($request)
    {
        $rules = [
            'title' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fix the validation errors');
            return back();
        }

        try {
            $this->syllabusModel->create([
                'title' => $request->post('title'),
                'overview' => $request->post('overview'),
                'learning_outcomes' => $request->post('learning_outcomes'),
                'topics_covered' => $request->post('topics_covered'),
                'assessment_methods' => $request->post('assessment_methods'),
                'grading_scale' => $request->post('grading_scale'),
                'recommended_resources' => $request->post('recommended_resources'),
                'prerequisites' => $request->post('prerequisites'),
                'duration' => $request->post('duration'),
                'academic_year' => $request->post('academic_year'),
                'subject_id' => $request->post('subject_id') ?: null,
                'class_id' => $request->post('class_id') ?: null,
                'status' => $request->post('status', 'active')
            ]);

            flash('success', 'Syllabus created successfully');
            return redirect('/syllabus');
        } catch (Exception $e) {
            flash('error', 'Failed to create syllabus: ' . $e->getMessage());
            return back();
        }
    }

    public function show($request, $id)
    {
        $syllabus = $this->syllabusModel->find($id);
        if (!$syllabus) {
            flash('error', 'Syllabus not found');
            return redirect('/syllabus');
        }
        return view('syllabus/show', ['syllabus' => $syllabus, 'title' => 'View - Syllabus Management']);
    }

    public function edit($request, $id)
    {
        $syllabus = $this->syllabusModel->find($id);
        if (!$syllabus) {
            flash('error', 'Syllabus not found');
            return redirect('/syllabus');
        }
        return view('syllabus/edit', ['syllabus' => $syllabus, 'title' => 'Edit - Syllabus Management']);
    }

    public function update($request, $id)
    {
        $syllabus = $this->syllabusModel->find($id);
        if (!$syllabus) {
            flash('error', 'Syllabus not found');
            return redirect('/syllabus');
        }

        try {
            $this->syllabusModel->update($id, [
                'title' => $request->post('title'),
                'overview' => $request->post('overview'),
                'learning_outcomes' => $request->post('learning_outcomes'),
                'topics_covered' => $request->post('topics_covered'),
                'assessment_methods' => $request->post('assessment_methods'),
                'grading_scale' => $request->post('grading_scale'),
                'recommended_resources' => $request->post('recommended_resources'),
                'prerequisites' => $request->post('prerequisites'),
                'duration' => $request->post('duration'),
                'academic_year' => $request->post('academic_year'),
                'subject_id' => $request->post('subject_id') ?: null,
                'class_id' => $request->post('class_id') ?: null,
                'status' => $request->post('status')
            ]);

            flash('success', 'Syllabus updated successfully');
            return redirect('/syllabus');
        } catch (Exception $e) {
            flash('error', 'Failed to update syllabus: ' . $e->getMessage());
            return back();
        }
    }

    public function destroy($request, $id)
    {
        try {
            $this->syllabusModel->delete($id);
            flash('success', 'Syllabus deleted successfully');
            return redirect('/syllabus');
        } catch (Exception $e) {
            flash('error', 'Failed to delete syllabus: ' . $e->getMessage());
            return back();
        }
    }
}