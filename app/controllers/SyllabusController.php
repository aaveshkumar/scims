<?php

class SyllabusController
{
    public function index($request)
    {
        return view('syllabus/index', ['title' => 'Syllabus Management']);
    }

    public function create($request)
    {
        return view('syllabus/create', ['title' => 'Create - Syllabus Management']);
    }

    public function store($request)
    {
        flash('success', 'Record created successfully');
        return redirect('/syllabus');
    }

    public function show($request, $id)
    {
        return view('syllabus/show', ['title' => 'View - Syllabus Management', 'id' => $id]);
    }

    public function edit($request, $id)
    {
        return view('syllabus/edit', ['title' => 'Edit - Syllabus Management', 'id' => $id]);
    }

    public function update($request, $id)
    {
        flash('success', 'Record updated successfully');
        return redirect('/syllabus');
    }

    public function destroy($request, $id)
    {
        flash('success', 'Record deleted successfully');
        return redirect('/syllabus');
    }
}