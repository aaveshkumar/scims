<?php

class ForumController
{
    public function index($request)
    {
        return view('forums/index', ['title' => 'Discussion Forums']);
    }

    public function create($request)
    {
        return view('forums/create', ['title' => 'Create - Discussion Forums']);
    }

    public function store($request)
    {
        flash('success', 'Record created successfully');
        return redirect('/forums');
    }

    public function show($request, $id)
    {
        return view('forums/show', ['title' => 'View - Discussion Forums', 'id' => $id]);
    }

    public function edit($request, $id)
    {
        return view('forums/edit', ['title' => 'Edit - Discussion Forums', 'id' => $id]);
    }

    public function update($request, $id)
    {
        flash('success', 'Record updated successfully');
        return redirect('/forums');
    }

    public function destroy($request, $id)
    {
        flash('success', 'Record deleted successfully');
        return redirect('/forums');
    }
}