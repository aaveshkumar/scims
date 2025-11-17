<?php

class LeaveController
{
    public function index($request)
    {
        return view('leave/index', ['title' => 'Leave Management']);
    }

    public function create($request)
    {
        return view('leave/create', ['title' => 'Create - Leave Management']);
    }

    public function store($request)
    {
        flash('success', 'Record created successfully');
        return redirect('/leave');
    }

    public function show($request, $id)
    {
        return view('leave/show', ['title' => 'View - Leave Management', 'id' => $id]);
    }

    public function edit($request, $id)
    {
        return view('leave/edit', ['title' => 'Edit - Leave Management', 'id' => $id]);
    }

    public function update($request, $id)
    {
        flash('success', 'Record updated successfully');
        return redirect('/leave');
    }

    public function destroy($request, $id)
    {
        flash('success', 'Record deleted successfully');
        return redirect('/leave');
    }
}