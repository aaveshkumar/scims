<?php

class ExpenseController
{
    public function index($request)
    {
        return view('expenses/index', ['title' => 'Expenses']);
    }

    public function create($request)
    {
        return view('expenses/create', ['title' => 'Create - Expenses']);
    }

    public function store($request)
    {
        flash('success', 'Record created successfully');
        return redirect('/expenses');
    }

    public function show($request, $id)
    {
        return view('expenses/show', ['title' => 'View - Expenses', 'id' => $id]);
    }

    public function edit($request, $id)
    {
        return view('expenses/edit', ['title' => 'Edit - Expenses', 'id' => $id]);
    }

    public function update($request, $id)
    {
        flash('success', 'Record updated successfully');
        return redirect('/expenses');
    }

    public function destroy($request, $id)
    {
        flash('success', 'Record deleted successfully');
        return redirect('/expenses');
    }
}