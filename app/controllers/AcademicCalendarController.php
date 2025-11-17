<?php

class AcademicCalendarController
{
    public function index($request)
    {
        return view('academic_calendar/index', ['title' => 'Academic Calendar']);
    }

    public function create($request)
    {
        return view('academic_calendar/create', ['title' => 'Create - Academic Calendar']);
    }

    public function store($request)
    {
        flash('success', 'Record created successfully');
        return redirect('/academic_calendar');
    }

    public function show($request, $id)
    {
        return view('academic_calendar/show', ['title' => 'View - Academic Calendar', 'id' => $id]);
    }

    public function edit($request, $id)
    {
        return view('academic_calendar/edit', ['title' => 'Edit - Academic Calendar', 'id' => $id]);
    }

    public function update($request, $id)
    {
        flash('success', 'Record updated successfully');
        return redirect('/academic_calendar');
    }

    public function destroy($request, $id)
    {
        flash('success', 'Record deleted successfully');
        return redirect('/academic_calendar');
    }
}