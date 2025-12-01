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

    public function attendanceCreate($request)
    {
        $students = $this->reportModel->getAllStudents();
        $classes = $this->reportModel->getAllClasses();

        return view('reports/attendance-create', [
            'title' => 'Add Attendance',
            'students' => $students,
            'classes' => $classes
        ]);
    }

    public function attendanceStore($request)
    {
        $student_id = $request['student_id'] ?? null;
        $class_id = $request['class_id'] ?? null;
        $date = $request['date'] ?? null;
        $status = $request['status'] ?? null;
        $remarks = $request['remarks'] ?? null;

        if (!$student_id || !$class_id || !$date || !$status) {
            flash('error', 'All fields are required');
            return redirect('/reports/attendance/create');
        }

        $this->reportModel->createAttendance([
            'student_id' => $student_id,
            'class_id' => $class_id,
            'subject_id' => 1,
            'date' => $date,
            'status' => $status,
            'remarks' => $remarks
        ]);

        flash('success', 'Attendance record created successfully');
        return redirect('/reports/attendance');
    }

    public function attendanceEdit($request, $id)
    {
        $record = $this->reportModel->getAttendanceById($id);
        if (!$record) {
            flash('error', 'Record not found');
            return redirect('/reports/attendance');
        }

        $students = $this->reportModel->getAllStudents();
        $classes = $this->reportModel->getAllClasses();

        return view('reports/attendance-edit', [
            'title' => 'Edit Attendance',
            'record' => $record,
            'students' => $students,
            'classes' => $classes
        ]);
    }

    public function attendanceUpdate($request, $id)
    {
        $student_id = $request['student_id'] ?? null;
        $class_id = $request['class_id'] ?? null;
        $date = $request['date'] ?? null;
        $status = $request['status'] ?? null;
        $remarks = $request['remarks'] ?? null;

        if (!$student_id || !$class_id || !$date || !$status) {
            flash('error', 'All fields are required');
            return redirect("/reports/attendance/$id/edit");
        }

        $this->reportModel->updateAttendance($id, [
            'student_id' => $student_id,
            'class_id' => $class_id,
            'date' => $date,
            'status' => $status,
            'remarks' => $remarks
        ]);

        flash('success', 'Attendance record updated successfully');
        return redirect('/reports/attendance');
    }

    public function attendanceDelete($request, $id)
    {
        $this->reportModel->deleteAttendance($id);
        flash('success', 'Attendance record deleted successfully');
        return redirect('/reports/attendance');
    }
}
