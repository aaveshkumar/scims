<?php

class LessonPlanController
{
    protected $lessonPlanModel;
    protected $subjectModel;
    protected $classModel;

    public function __construct()
    {
        $this->lessonPlanModel = new LessonPlan();
        $this->subjectModel = new Subject();
        $this->classModel = new Classes();
    }

    public function index($request)
    {
        $lessonPlans = $this->lessonPlanModel->all();
        return view('lesson-plans/index', ['lessonPlans' => $lessonPlans, 'title' => 'Lesson Plans']);
    }

    public function create($request)
    {
        $subjects = $this->subjectModel->where('status', 'active')->get();
        $classes = $this->classModel->where('status', 'active')->get();
        return view('lesson-plans/create', [
            'subjects' => $subjects,
            'classes' => $classes,
            'title' => 'Create - Lesson Plans'
        ]);
    }

    public function store($request)
    {
        $data = [
            'subject_id' => $request->post('subject_id') ?: null,
            'class_id' => $request->post('class_id') ?: null,
            'topic' => $request->post('topic'),
            'lesson_date' => $request->post('lesson_date'),
            'duration' => $request->post('duration'),
            'period_number' => $request->post('period_number') ?: null,
            'learning_outcomes' => $request->post('learning_outcomes'),
            'introduction' => $request->post('introduction'),
            'content' => $request->post('content'),
            'activities' => $request->post('activities') ?: null,
            'conclusion' => $request->post('conclusion') ?: null,
            'assessment_method' => $request->post('assessment_method') ?: null,
            'resources' => $request->post('resources') ?: null,
            'homework' => $request->post('homework') ?: null,
            'remarks' => $request->post('remarks') ?: null,
            'status' => $request->post('status', 'active'),
            'difficulty_level' => $request->post('difficulty_level') ?: null,
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($this->lessonPlanModel->create($data)) {
            flash('success', 'Lesson plan created successfully');
            return redirect('/lesson-plans');
        }

        flash('error', 'Failed to create lesson plan');
        return redirect('/lesson-plans/create');
    }

    public function show($request, $id)
    {
        $lessonPlan = $this->lessonPlanModel->find($id);
        if (!$lessonPlan) {
            flash('error', 'Lesson plan not found');
            return redirect('/lesson-plans');
        }
        return view('lesson-plans/show', ['lessonPlan' => $lessonPlan, 'title' => 'View - Lesson Plans']);
    }

    public function edit($request, $id)
    {
        $lessonPlan = $this->lessonPlanModel->find($id);
        if (!$lessonPlan) {
            flash('error', 'Lesson plan not found');
            return redirect('/lesson-plans');
        }
        $subjects = $this->subjectModel->where('status', 'active')->get();
        $classes = $this->classModel->where('status', 'active')->get();
        return view('lesson-plans/edit', [
            'lessonPlan' => $lessonPlan,
            'subjects' => $subjects,
            'classes' => $classes,
            'title' => 'Edit - Lesson Plans'
        ]);
    }

    public function update($request, $id)
    {
        $lessonPlan = $this->lessonPlanModel->find($id);
        if (!$lessonPlan) {
            flash('error', 'Lesson plan not found');
            return redirect('/lesson-plans');
        }

        $data = [
            'subject_id' => $request->post('subject_id') ?: null,
            'class_id' => $request->post('class_id') ?: null,
            'topic' => $request->post('topic'),
            'lesson_date' => $request->post('lesson_date'),
            'duration' => $request->post('duration'),
            'period_number' => $request->post('period_number') ?: null,
            'learning_outcomes' => $request->post('learning_outcomes'),
            'introduction' => $request->post('introduction'),
            'content' => $request->post('content'),
            'activities' => $request->post('activities') ?: null,
            'conclusion' => $request->post('conclusion') ?: null,
            'assessment_method' => $request->post('assessment_method') ?: null,
            'resources' => $request->post('resources') ?: null,
            'homework' => $request->post('homework') ?: null,
            'remarks' => $request->post('remarks') ?: null,
            'status' => $request->post('status', 'active'),
            'difficulty_level' => $request->post('difficulty_level') ?: null,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->lessonPlanModel->update($id, $data)) {
            flash('success', 'Lesson plan updated successfully');
            return redirect('/lesson-plans');
        }

        flash('error', 'Failed to update lesson plan');
        return redirect('/lesson-plans/' . $id . '/edit');
    }

    public function destroy($request, $id)
    {
        $lessonPlan = $this->lessonPlanModel->find($id);
        if (!$lessonPlan) {
            flash('error', 'Lesson plan not found');
            return redirect('/lesson-plans');
        }

        if ($this->lessonPlanModel->delete($id)) {
            flash('success', 'Lesson plan deleted successfully');
            return redirect('/lesson-plans');
        }

        flash('error', 'Failed to delete lesson plan');
        return redirect('/lesson-plans');
    }
}
