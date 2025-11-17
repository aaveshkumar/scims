<?php

class RoleController
{
    public function index($request)
    {
        return view('roles/index', ['title' => 'Roles & Permissions']);
    }

    public function create($request)
    {
        return view('roles/create', ['title' => 'Create - Roles & Permissions']);
    }

    public function store($request)
    {
        flash('success', 'Record created successfully');
        return redirect('/roles');
    }

    public function show($request, $id)
    {
        return view('roles/show', ['title' => 'View - Roles & Permissions', 'id' => $id]);
    }

    public function edit($request, $id)
    {
        return view('roles/edit', ['title' => 'Edit - Roles & Permissions', 'id' => $id]);
    }

    public function update($request, $id)
    {
        flash('success', 'Record updated successfully');
        return redirect('/roles');
    }

    public function destroy($request, $id)
    {
        flash('success', 'Record deleted successfully');
        return redirect('/roles');
    }
}