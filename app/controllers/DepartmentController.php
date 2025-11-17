<?php

class DepartmentController
{
    public function index($request)
    {
        return view('departments/index', ['title' => 'Departments']);
    }

    public function create($request)
    {
        return view('departments/create', ['title' => 'Create - Departments']);
    }

    public function store($request)
    {
        flash('success', 'Record created successfully');
        return redirect('/departments');
    }

    public function show($request, $id)
    {
        return view('departments/show', ['title' => 'View - Departments', 'id' => $id]);
    }

    public function edit($request, $id)
    {
        return view('departments/edit', ['title' => 'Edit - Departments', 'id' => $id]);
    }

    public function update($request, $id)
    {
        flash('success', 'Record updated successfully');
        return redirect('/departments');
    }

    public function destroy($request, $id)
    {
        flash('success', 'Record deleted successfully');
        return redirect('/departments');
    }
}