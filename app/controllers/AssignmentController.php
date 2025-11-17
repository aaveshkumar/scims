<?php

class AssignmentController
{
    public function index($request)
    {
        return view('assignments/index', ['title' => 'Assignments']);
    }

    public function create($request)
    {
        return view('assignments/create', ['title' => 'Create - Assignments']);
    }

    public function store($request)
    {
        flash('success', 'Record created successfully');
        return redirect('/assignments');
    }

    public function show($request, $id)
    {
        return view('assignments/show', ['title' => 'View - Assignments', 'id' => $id]);
    }

    public function edit($request, $id)
    {
        return view('assignments/edit', ['title' => 'Edit - Assignments', 'id' => $id]);
    }

    public function update($request, $id)
    {
        flash('success', 'Record updated successfully');
        return redirect('/assignments');
    }

    public function destroy($request, $id)
    {
        flash('success', 'Record deleted successfully');
        return redirect('/assignments');
    }
}