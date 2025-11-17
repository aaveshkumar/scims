<?php

class TransportController
{
    public function index($request)
    {
        return view('transport/index', ['title' => 'Transport Management']);
    }

    public function create($request)
    {
        return view('transport/create', ['title' => 'Create - Transport Management']);
    }

    public function store($request)
    {
        flash('success', 'Record created successfully');
        return redirect('/transport');
    }

    public function show($request, $id)
    {
        return view('transport/show', ['title' => 'View - Transport Management', 'id' => $id]);
    }

    public function edit($request, $id)
    {
        return view('transport/edit', ['title' => 'Edit - Transport Management', 'id' => $id]);
    }

    public function update($request, $id)
    {
        flash('success', 'Record updated successfully');
        return redirect('/transport');
    }

    public function destroy($request, $id)
    {
        flash('success', 'Record deleted successfully');
        return redirect('/transport');
    }

    public function routes($request)
    {
        return view('transport/routes', ['title' => 'Transport Routes']);
    }

    public function assignments($request)
    {
        return view('transport/assignments', ['title' => 'Student Route Assignments']);
    }
}
