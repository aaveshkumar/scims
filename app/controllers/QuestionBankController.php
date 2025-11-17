<?php

class QuestionBankController
{
    public function index($request)
    {
        return view('question_bank/index', ['title' => 'Question Bank']);
    }

    public function create($request)
    {
        return view('question_bank/create', ['title' => 'Create - Question Bank']);
    }

    public function store($request)
    {
        flash('success', 'Record created successfully');
        return redirect('/question_bank');
    }

    public function show($request, $id)
    {
        return view('question_bank/show', ['title' => 'View - Question Bank', 'id' => $id]);
    }

    public function edit($request, $id)
    {
        return view('question_bank/edit', ['title' => 'Edit - Question Bank', 'id' => $id]);
    }

    public function update($request, $id)
    {
        flash('success', 'Record updated successfully');
        return redirect('/question_bank');
    }

    public function destroy($request, $id)
    {
        flash('success', 'Record deleted successfully');
        return redirect('/question_bank');
    }
}