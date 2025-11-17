<?php

class QuizController
{
    public function index($request)
    {
        return view('quizzes/index', ['title' => 'Quizzes']);
    }

    public function create($request)
    {
        return view('quizzes/create', ['title' => 'Create - Quizzes']);
    }

    public function store($request)
    {
        flash('success', 'Record created successfully');
        return redirect('/quizzes');
    }

    public function show($request, $id)
    {
        return view('quizzes/show', ['title' => 'View - Quizzes', 'id' => $id]);
    }

    public function edit($request, $id)
    {
        return view('quizzes/edit', ['title' => 'Edit - Quizzes', 'id' => $id]);
    }

    public function update($request, $id)
    {
        flash('success', 'Record updated successfully');
        return redirect('/quizzes');
    }

    public function destroy($request, $id)
    {
        flash('success', 'Record deleted successfully');
        return redirect('/quizzes');
    }
}