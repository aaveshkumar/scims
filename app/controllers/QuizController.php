<?php

class QuizController
{
    public function index($request)
    {
        $filters = [
            'subject_id' => $request->get('subject_id'),
            'class_id' => $request->get('class_id'),
            'status' => $request->get('status')
        ];
        
        $quizzes = Quiz::getAll($filters);
        $subjects = db()->fetchAll("SELECT id, name FROM subjects ORDER BY name");
        $classes = db()->fetchAll("SELECT id, name FROM classes ORDER BY name");
        $stats = Quiz::getStatistics();
        
        return view('quizzes/index', [
            'title' => 'Quiz Management',
            'quizzes' => $quizzes,
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
        
        return view('quizzes/create', [
            'title' => 'Create Quiz',
            'subjects' => $subjects,
            'classes' => $classes
        ]);
    }

    public function store($request)
    {
        $rules = [
            'title' => 'required',
            'subject_id' => 'required',
            'class_id' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fill all required fields');
            return back();
        }

        try {
            $data = [
                'title' => $request->post('title'),
                'subject_id' => $request->post('subject_id'),
                'class_id' => $request->post('class_id'),
                'teacher_id' => auth()->user()['id'],
                'description' => $request->post('description'),
                'duration_minutes' => $request->post('duration_minutes') ?? 30,
                'total_marks' => $request->post('total_marks') ?? 10,
                'passing_marks' => $request->post('passing_marks'),
                'start_time' => $request->post('start_time'),
                'end_time' => $request->post('end_time'),
                'status' => 'draft'
            ];

            Quiz::create($data);
            flash('success', 'Quiz created successfully');
            return redirect('/quizzes');
        } catch (Exception $e) {
            flash('error', 'Failed to create quiz: ' . $e->getMessage());
            return back();
        }
    }

    public function show($request, $id)
    {
        $quiz = Quiz::find($id);
        
        if (!$quiz) {
            flash('error', 'Quiz not found');
            return redirect('/quizzes');
        }
        
        $questions = Quiz::getQuestions($id);
        $attempts = Quiz::getAttempts($id);
        
        return view('quizzes/show', [
            'title' => 'Quiz Details',
            'quiz' => $quiz,
            'questions' => $questions,
            'attempts' => $attempts
        ]);
    }

    public function edit($request, $id)
    {
        $quiz = Quiz::find($id);
        
        if (!$quiz) {
            flash('error', 'Quiz not found');
            return redirect('/quizzes');
        }
        
        $subjects = db()->fetchAll("SELECT id, name FROM subjects ORDER BY name");
        $classes = db()->fetchAll("SELECT id, name FROM classes ORDER BY name");
        
        return view('quizzes/edit', [
            'title' => 'Edit Quiz',
            'quiz' => $quiz,
            'subjects' => $subjects,
            'classes' => $classes
        ]);
    }

    public function update($request, $id)
    {
        $rules = [
            'title' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fill all required fields');
            return back();
        }

        try {
            $data = [
                'title' => $request->post('title'),
                'description' => $request->post('description'),
                'duration_minutes' => $request->post('duration_minutes'),
                'total_marks' => $request->post('total_marks'),
                'passing_marks' => $request->post('passing_marks'),
                'start_time' => $request->post('start_time'),
                'end_time' => $request->post('end_time'),
                'status' => $request->post('status')
            ];

            Quiz::update($id, $data);
            flash('success', 'Quiz updated successfully');
            return redirect('/quizzes');
        } catch (Exception $e) {
            flash('error', 'Failed to update quiz: ' . $e->getMessage());
            return back();
        }
    }

    public function destroy($request, $id)
    {
        try {
            Quiz::delete($id);
            flash('success', 'Quiz deleted successfully');
            return redirect('/quizzes');
        } catch (Exception $e) {
            flash('error', 'Failed to delete quiz: ' . $e->getMessage());
            return back();
        }
    }
}