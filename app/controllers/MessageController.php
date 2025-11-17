<?php

class MessageController
{
    public function index($request)
    {
        return view('messages/index', ['title' => 'Messages']);
    }

    public function create($request)
    {
        return view('messages/create', ['title' => 'Create - Messages']);
    }

    public function store($request)
    {
        flash('success', 'Record created successfully');
        return redirect('/messages');
    }

    public function show($request, $id)
    {
        return view('messages/show', ['title' => 'View - Messages', 'id' => $id]);
    }

    public function edit($request, $id)
    {
        return view('messages/edit', ['title' => 'Edit - Messages', 'id' => $id]);
    }

    public function update($request, $id)
    {
        flash('success', 'Record updated successfully');
        return redirect('/messages');
    }

    public function destroy($request, $id)
    {
        flash('success', 'Record deleted successfully');
        return redirect('/messages');
    }
}