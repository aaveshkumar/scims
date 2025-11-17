<?php

class AnnouncementController
{
    public function index($request)
    {
        return view('announcements/index', ['title' => 'Announcements']);
    }

    public function create($request)
    {
        return view('announcements/create', ['title' => 'Create - Announcements']);
    }

    public function store($request)
    {
        flash('success', 'Record created successfully');
        return redirect('/announcements');
    }

    public function show($request, $id)
    {
        return view('announcements/show', ['title' => 'View - Announcements', 'id' => $id]);
    }

    public function edit($request, $id)
    {
        return view('announcements/edit', ['title' => 'Edit - Announcements', 'id' => $id]);
    }

    public function update($request, $id)
    {
        flash('success', 'Record updated successfully');
        return redirect('/announcements');
    }

    public function destroy($request, $id)
    {
        flash('success', 'Record deleted successfully');
        return redirect('/announcements');
    }
}