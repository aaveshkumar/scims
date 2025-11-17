<?php

class FeeStructureController
{
    public function index($request)
    {
        return view('fee_structure/index', ['title' => 'Fee Structure']);
    }

    public function create($request)
    {
        return view('fee_structure/create', ['title' => 'Create - Fee Structure']);
    }

    public function store($request)
    {
        flash('success', 'Record created successfully');
        return redirect('/fee_structure');
    }

    public function show($request, $id)
    {
        return view('fee_structure/show', ['title' => 'View - Fee Structure', 'id' => $id]);
    }

    public function edit($request, $id)
    {
        return view('fee_structure/edit', ['title' => 'Edit - Fee Structure', 'id' => $id]);
    }

    public function update($request, $id)
    {
        flash('success', 'Record updated successfully');
        return redirect('/fee_structure');
    }

    public function destroy($request, $id)
    {
        flash('success', 'Record deleted successfully');
        return redirect('/fee_structure');
    }
}