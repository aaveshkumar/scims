<?php

class ReportController
{
    public function index($request)
    {
        return view('reports/index', ['title' => 'Reports & Analytics']);
    }

    public function create($request)
    {
        return view('reports/create', ['title' => 'Create - Reports & Analytics']);
    }

    public function store($request)
    {
        flash('success', 'Record created successfully');
        return redirect('/reports');
    }

    public function show($request, $id)
    {
        return view('reports/show', ['title' => 'View - Reports & Analytics', 'id' => $id]);
    }

    public function edit($request, $id)
    {
        return view('reports/edit', ['title' => 'Edit - Reports & Analytics', 'id' => $id]);
    }

    public function update($request, $id)
    {
        flash('success', 'Record updated successfully');
        return redirect('/reports');
    }

    public function destroy($request, $id)
    {
        flash('success', 'Record deleted successfully');
        return redirect('/reports');
    }
}
    public function attendance($request)
    {
        return view('reports/attendance', ['title' => 'Attendance Reports']);
    }

    public function academic($request)
    {
        return view('reports/academic', ['title' => 'Academic Reports']);
    }

    public function financial($request)
    {
        return view('reports/financial', ['title' => 'Financial Reports']);
    }

    public function custom($request)
    {
        return view('reports/custom', ['title' => 'Custom Reports']);
    }
}
