<?php

class ReportController
{
    private $reportModel;

    public function __construct()
    {
        $this->reportModel = new Report();
    }

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

    public function attendance($request)
    {
        $records = $this->reportModel->getAttendanceRecords();
        $summary = $this->reportModel->getAttendanceSummary();

        return view('reports/attendance', [
            'title' => 'Attendance Reports',
            'records' => $records,
            'summary' => $summary
        ]);
    }

    public function academic($request)
    {
        $records = $this->reportModel->getAcademicRecords();
        $summary = $this->reportModel->getAcademicSummary();

        return view('reports/academic', [
            'title' => 'Academic Reports',
            'records' => $records,
            'summary' => $summary
        ]);
    }

    public function financial($request)
    {
        $records = $this->reportModel->getFinancialRecords();
        $summary = $this->reportModel->getFinancialSummary();

        return view('reports/financial', [
            'title' => 'Financial Reports',
            'records' => $records,
            'summary' => $summary
        ]);
    }

    public function custom($request)
    {
        return view('reports/custom', ['title' => 'Custom Reports']);
    }
}
