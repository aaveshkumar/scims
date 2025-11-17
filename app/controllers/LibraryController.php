<?php

class LibraryController
{
    public function index($request)
    {
        return view('library/index', ['title' => 'Library Management']);
    }

    public function create($request)
    {
        return view('library/create', ['title' => 'Create - Library Management']);
    }

    public function store($request)
    {
        flash('success', 'Record created successfully');
        return redirect('/library');
    }

    public function show($request, $id)
    {
        return view('library/show', ['title' => 'View - Library Management', 'id' => $id]);
    }

    public function edit($request, $id)
    {
        return view('library/edit', ['title' => 'Edit - Library Management', 'id' => $id]);
    }

    public function update($request, $id)
    {
        flash('success', 'Record updated successfully');
        return redirect('/library');
    }

    public function destroy($request, $id)
    {
        flash('success', 'Record deleted successfully');
        return redirect('/library');
    }

    public function issue($request)
    {
        return view('library/issue', ['title' => 'Issue/Return Books']);
    }

    public function members($request)
    {
        return view('library/members', ['title' => 'Library Members']);
    }
    
    public function processIssue($request)
    {
        flash('success', 'Book issued successfully');
        return redirect('/library/issue');
    }
    
    public function processReturn($request)
    {
        flash('success', 'Book returned successfully');
        return redirect('/library/issue');
    }
}
