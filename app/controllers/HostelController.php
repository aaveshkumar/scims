<?php

class HostelController
{
    public function index($request)
    {
        return view('hostel/index', ['title' => 'Hostel Management']);
    }

    public function create($request)
    {
        return view('hostel/create', ['title' => 'Create - Hostel Management']);
    }

    public function store($request)
    {
        flash('success', 'Record created successfully');
        return redirect('/hostel');
    }

    public function show($request, $id)
    {
        return view('hostel/show', ['title' => 'View - Hostel Management', 'id' => $id]);
    }

    public function edit($request, $id)
    {
        return view('hostel/edit', ['title' => 'Edit - Hostel Management', 'id' => $id]);
    }

    public function update($request, $id)
    {
        flash('success', 'Record updated successfully');
        return redirect('/hostel');
    }

    public function destroy($request, $id)
    {
        flash('success', 'Record deleted successfully');
        return redirect('/hostel');
    }

    public function residents($request)
    {
        return view('hostel/residents', ['title' => 'Hostel Residents']);
    }

    public function visitors($request)
    {
        return view('hostel/visitors', ['title' => 'Hostel Visitors']);
    }

    public function complaints($request)
    {
        return view('hostel/complaints', ['title' => 'Hostel Complaints']);
    }
}
