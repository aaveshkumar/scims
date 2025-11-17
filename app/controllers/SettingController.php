<?php

class SettingController
{
    public function index($request)
    {
        return view('settings/index', ['title' => 'System Settings']);
    }

    public function create($request)
    {
        return view('settings/create', ['title' => 'Create - System Settings']);
    }

    public function store($request)
    {
        flash('success', 'Record created successfully');
        return redirect('/settings');
    }

    public function show($request, $id)
    {
        return view('settings/show', ['title' => 'View - System Settings', 'id' => $id]);
    }

    public function edit($request, $id)
    {
        return view('settings/edit', ['title' => 'Edit - System Settings', 'id' => $id]);
    }

    public function update($request, $id)
    {
        flash('success', 'Record updated successfully');
        return redirect('/settings');
    }

    public function destroy($request, $id)
    {
        flash('success', 'Record deleted successfully');
        return redirect('/settings');
    }
}
    public function backup($request)
    {
        return view('settings/backup', ['title' => 'Backup & Restore']);
    }

    public function auditLogs($request)
    {
        return view('settings/audit_logs', ['title' => 'Audit Logs']);
    }

    public function update($request)
    {
        flash('success', 'Settings updated successfully');
        return redirect('/settings');
    }
}
