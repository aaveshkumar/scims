<?php

class PayrollController
{
    public function index($request)
    {
        return view('payroll/index', ['title' => 'Payroll']);
    }

    public function create($request)
    {
        return view('payroll/create', ['title' => 'Create - Payroll']);
    }

    public function store($request)
    {
        flash('success', 'Record created successfully');
        return redirect('/payroll');
    }

    public function show($request, $id)
    {
        return view('payroll/show', ['title' => 'View - Payroll', 'id' => $id]);
    }

    public function edit($request, $id)
    {
        return view('payroll/edit', ['title' => 'Edit - Payroll', 'id' => $id]);
    }

    public function update($request, $id)
    {
        flash('success', 'Record updated successfully');
        return redirect('/payroll');
    }

    public function destroy($request, $id)
    {
        flash('success', 'Record deleted successfully');
        return redirect('/payroll');
    }
}