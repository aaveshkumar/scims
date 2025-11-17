<?php

class BudgetController
{
    public function index($request)
    {
        return view('budget/index', ['title' => 'Budget Planning']);
    }

    public function create($request)
    {
        return view('budget/create', ['title' => 'Create - Budget Planning']);
    }

    public function store($request)
    {
        flash('success', 'Record created successfully');
        return redirect('/budget');
    }

    public function show($request, $id)
    {
        return view('budget/show', ['title' => 'View - Budget Planning', 'id' => $id]);
    }

    public function edit($request, $id)
    {
        return view('budget/edit', ['title' => 'Edit - Budget Planning', 'id' => $id]);
    }

    public function update($request, $id)
    {
        flash('success', 'Record updated successfully');
        return redirect('/budget');
    }

    public function destroy($request, $id)
    {
        flash('success', 'Record deleted successfully');
        return redirect('/budget');
    }
}