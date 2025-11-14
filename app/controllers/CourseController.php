<?php

class CourseController
{
    private $courseModel;

    public function __construct()
    {
        $this->courseModel = new Course();
    }

    public function index($request)
    {
        $courses = $this->courseModel->all();
        return view('courses.index', ['courses' => $courses]);
    }

    public function create($request)
    {
        return view('courses.create');
    }

    public function store($request)
    {
        $rules = [
            'name' => 'required',
            'code' => 'required',
            'duration_years' => 'required|numeric'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fix the validation errors');
            return back();
        }

        try {
            $this->courseModel->create([
                'name' => $request->post('name'),
                'code' => $request->post('code'),
                'description' => $request->post('description'),
                'duration_years' => $request->post('duration_years'),
                'status' => 'active'
            ]);

            flash('success', 'Course created successfully');
            return redirect('/courses');
        } catch (Exception $e) {
            flash('error', 'Failed to create course: ' . $e->getMessage());
            return back();
        }
    }

    public function show($request, $id)
    {
        $course = $this->courseModel->find($id);
        if (!$course) {
            flash('error', 'Course not found');
            return redirect('/courses');
        }

        return view('courses.show', ['course' => $course]);
    }

    public function edit($request, $id)
    {
        $course = $this->courseModel->find($id);
        if (!$course) {
            flash('error', 'Course not found');
            return redirect('/courses');
        }

        return view('courses.edit', ['course' => $course]);
    }

    public function update($request, $id)
    {
        $rules = [
            'name' => 'required',
            'code' => 'required',
            'duration_years' => 'required|numeric'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fix the validation errors');
            return back();
        }

        try {
            $this->courseModel->update($id, [
                'name' => $request->post('name'),
                'code' => $request->post('code'),
                'description' => $request->post('description'),
                'duration_years' => $request->post('duration_years'),
                'status' => $request->post('status')
            ]);

            flash('success', 'Course updated successfully');
            return redirect('/courses');
        } catch (Exception $e) {
            flash('error', 'Failed to update course: ' . $e->getMessage());
            return back();
        }
    }

    public function destroy($request, $id)
    {
        try {
            $this->courseModel->delete($id);
            return responseJSON(['success' => true, 'message' => 'Course deleted successfully']);
        } catch (Exception $e) {
            return responseJSON(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
