<?php

class QuestionBankController
{
    protected $questionBankModel;
    protected $subjectModel;
    protected $classModel;

    public function __construct()
    {
        $this->questionBankModel = new QuestionBank();
        $this->subjectModel = new Subject();
        $this->classModel = new ClassModel();
    }

    public function index($request)
    {
        $questions = $this->questionBankModel->all();
        return view('question-bank/index', ['questions' => $questions, 'title' => 'Question Bank']);
    }

    public function create($request)
    {
        $subjects = $this->subjectModel->where('status', 'active')->get();
        $classes = $this->classModel->where('status', 'active')->get();
        return view('question-bank/create', [
            'subjects' => $subjects,
            'classes' => $classes,
            'title' => 'Create - Question Bank'
        ]);
    }

    public function store($request)
    {
        $data = [
            'subject_id' => $request->post('subject_id') ?: null,
            'class_id' => $request->post('class_id') ?: null,
            'question_text' => $request->post('question_text'),
            'question_type' => $request->post('question_type'),
            'difficulty_level' => $request->post('difficulty_level') ?: null,
            'marks' => $request->post('marks') ?: null,
            'option_a' => $request->post('option_a') ?: null,
            'option_b' => $request->post('option_b') ?: null,
            'option_c' => $request->post('option_c') ?: null,
            'option_d' => $request->post('option_d') ?: null,
            'correct_answer' => $request->post('correct_answer') ?: null,
            'explanation' => $request->post('explanation') ?: null,
            'chapter_topic' => $request->post('chapter_topic') ?: null,
            'keywords' => $request->post('keywords') ?: null,
            'status' => $request->post('status', 'active'),
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($this->questionBankModel->create($data)) {
            flash('success', 'Question created successfully');
            return redirect('/question-bank');
        }

        flash('error', 'Failed to create question');
        return redirect('/question-bank/create');
    }

    public function show($request, $id)
    {
        $question = $this->questionBankModel->find($id);
        if (!$question) {
            flash('error', 'Question not found');
            return redirect('/question-bank');
        }
        return view('question-bank/show', ['question' => $question, 'title' => 'View - Question Bank']);
    }

    public function edit($request, $id)
    {
        $question = $this->questionBankModel->find($id);
        if (!$question) {
            flash('error', 'Question not found');
            return redirect('/question-bank');
        }
        $subjects = $this->subjectModel->where('status', 'active')->get();
        $classes = $this->classModel->where('status', 'active')->get();
        return view('question-bank/edit', [
            'question' => $question,
            'subjects' => $subjects,
            'classes' => $classes,
            'title' => 'Edit - Question Bank'
        ]);
    }

    public function update($request, $id)
    {
        $question = $this->questionBankModel->find($id);
        if (!$question) {
            flash('error', 'Question not found');
            return redirect('/question-bank');
        }

        $data = [
            'subject_id' => $request->post('subject_id') ?: null,
            'class_id' => $request->post('class_id') ?: null,
            'question_text' => $request->post('question_text'),
            'question_type' => $request->post('question_type'),
            'difficulty_level' => $request->post('difficulty_level') ?: null,
            'marks' => $request->post('marks') ?: null,
            'option_a' => $request->post('option_a') ?: null,
            'option_b' => $request->post('option_b') ?: null,
            'option_c' => $request->post('option_c') ?: null,
            'option_d' => $request->post('option_d') ?: null,
            'correct_answer' => $request->post('correct_answer') ?: null,
            'explanation' => $request->post('explanation') ?: null,
            'chapter_topic' => $request->post('chapter_topic') ?: null,
            'keywords' => $request->post('keywords') ?: null,
            'status' => $request->post('status', 'active'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->questionBankModel->update($id, $data)) {
            flash('success', 'Question updated successfully');
            return redirect('/question-bank');
        }

        flash('error', 'Failed to update question');
        return redirect('/question-bank/' . $id . '/edit');
    }

    public function destroy($request, $id)
    {
        $question = $this->questionBankModel->find($id);
        if (!$question) {
            flash('error', 'Question not found');
            return redirect('/question-bank');
        }

        if ($this->questionBankModel->delete($id)) {
            flash('success', 'Question deleted successfully');
            return redirect('/question-bank');
        }

        flash('error', 'Failed to delete question');
        return redirect('/question-bank');
    }
}
