<?php

class ExamController
{
    private $examModel;
    private $classModel;

    public function __construct()
    {
        $this->examModel = new Exam();
        $this->classModel = new ClassModel();
    }

    public function index($request)
    {
        $exams = db()->fetchAll(
            "SELECT e.*, c.name as class_name
             FROM exams e
             LEFT JOIN classes c ON e.class_id = c.id
             ORDER BY e.start_date DESC"
        );

        return view('exams.index', ['exams' => $exams]);
    }

    public function create($request)
    {
        $classes = $this->classModel->where('status', 'active')->get();
        return view('exams.create', ['classes' => $classes]);
    }

    public function store($request)
    {
        $rules = [
            'name' => 'required',
            'code' => 'required',
            'exam_type' => 'required',
            'academic_year' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'total_marks' => 'required|numeric',
            'passing_marks' => 'required|numeric'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fix the validation errors');
            return back();
        }

        try {
            $this->examModel->create([
                'name' => $request->post('name'),
                'code' => $request->post('code'),
                'class_id' => $request->post('class_id'),
                'exam_type' => $request->post('exam_type'),
                'academic_year' => $request->post('academic_year'),
                'semester' => $request->post('semester'),
                'start_date' => $request->post('start_date'),
                'end_date' => $request->post('end_date'),
                'total_marks' => $request->post('total_marks'),
                'passing_marks' => $request->post('passing_marks'),
                'status' => 'scheduled'
            ]);

            flash('success', 'Exam created successfully');
            return redirect('/exams');
        } catch (Exception $e) {
            flash('error', 'Failed to create exam: ' . $e->getMessage());
            return back();
        }
    }

    public function show($request, $id)
    {
        $exam = db()->fetchOne(
            "SELECT e.*, c.name as class_name
             FROM exams e
             LEFT JOIN classes c ON e.class_id = c.id
             WHERE e.id = ?",
            [$id]
        );

        if (!$exam) {
            flash('error', 'Exam not found');
            return redirect('/exams');
        }

        $results = db()->fetchAll(
            "SELECT m.*, s.admission_number, u.first_name, u.last_name, 
                    sub.name as subject_name
             FROM marks m
             INNER JOIN students s ON m.student_id = s.id
             INNER JOIN users u ON s.user_id = u.id
             INNER JOIN subjects sub ON m.subject_id = sub.id
             WHERE m.exam_id = ?
             ORDER BY u.last_name, u.first_name",
            [$id]
        );

        return view('exams.show', ['exam' => $exam, 'results' => $results]);
    }

    public function edit($request, $id)
    {
        $exam = $this->examModel->find($id);
        if (!$exam) {
            flash('error', 'Exam not found');
            return redirect('/exams');
        }

        $classes = $this->classModel->where('status', 'active')->get();

        return view('exams.edit', ['exam' => $exam, 'classes' => $classes]);
    }

    public function update($request, $id)
    {
        $rules = [
            'name' => 'required',
            'code' => 'required',
            'exam_type' => 'required',
            'academic_year' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'total_marks' => 'required|numeric',
            'passing_marks' => 'required|numeric'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fix the validation errors');
            return back();
        }

        try {
            $this->examModel->update($id, [
                'name' => $request->post('name'),
                'code' => $request->post('code'),
                'class_id' => $request->post('class_id'),
                'exam_type' => $request->post('exam_type'),
                'academic_year' => $request->post('academic_year'),
                'semester' => $request->post('semester'),
                'start_date' => $request->post('start_date'),
                'end_date' => $request->post('end_date'),
                'total_marks' => $request->post('total_marks'),
                'passing_marks' => $request->post('passing_marks'),
                'status' => $request->post('status')
            ]);

            flash('success', 'Exam updated successfully');
            return redirect('/exams/' . $id);
        } catch (Exception $e) {
            flash('error', 'Failed to update exam: ' . $e->getMessage());
            return back();
        }
    }

    public function destroy($request, $id)
    {
        try {
            $this->examModel->delete($id);
            flash('success', 'Exam deleted successfully');
            return redirect('/exams');
        } catch (Exception $e) {
            flash('error', 'Failed to delete exam: ' . $e->getMessage());
            return back();
        }
    }
}
