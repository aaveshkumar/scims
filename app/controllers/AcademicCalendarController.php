<?php

class AcademicCalendarController
{
    protected $academicCalendarModel;

    public function __construct()
    {
        $this->academicCalendarModel = new AcademicCalendar();
    }

    public function index($request)
    {
        $calendars = $this->academicCalendarModel->all();
        return view('academic-calendar/index', ['calendars' => $calendars, 'title' => 'Academic Calendar']);
    }

    public function create($request)
    {
        return view('academic-calendar/create', ['title' => 'Create - Academic Calendar']);
    }

    public function store($request)
    {
        $data = [
            'academic_year' => $request->post('academic_year'),
            'start_date' => $request->post('start_date'),
            'end_date' => $request->post('end_date'),
            'session_name' => $request->post('session_name') ?: null,
            'session_start' => $request->post('session_start') ?: null,
            'session_end' => $request->post('session_end') ?: null,
            'exam_start' => $request->post('exam_start') ?: null,
            'exam_end' => $request->post('exam_end') ?: null,
            'admission_start' => $request->post('admission_start') ?: null,
            'admission_end' => $request->post('admission_end') ?: null,
            'holidays' => $request->post('holidays') ?: null,
            'important_events' => $request->post('important_events') ?: null,
            'status' => $request->post('status', 'active'),
            'notes' => $request->post('notes') ?: null,
            'created_at' => date('Y-m-d H:i:s')
        ];

        if ($this->academicCalendarModel->create($data)) {
            flash('success', 'Academic calendar created successfully');
            return redirect('/academic-calendar');
        }

        flash('error', 'Failed to create academic calendar');
        return redirect('/academic-calendar/create');
    }

    public function show($request, $id)
    {
        $calendar = $this->academicCalendarModel->find($id);
        if (!$calendar) {
            flash('error', 'Calendar not found');
            return redirect('/academic-calendar');
        }
        return view('academic-calendar/show', ['calendar' => $calendar, 'title' => 'View - Academic Calendar']);
    }

    public function edit($request, $id)
    {
        $calendar = $this->academicCalendarModel->find($id);
        if (!$calendar) {
            flash('error', 'Calendar not found');
            return redirect('/academic-calendar');
        }
        return view('academic-calendar/edit', ['calendar' => $calendar, 'title' => 'Edit - Academic Calendar']);
    }

    public function update($request, $id)
    {
        $calendar = $this->academicCalendarModel->find($id);
        if (!$calendar) {
            flash('error', 'Calendar not found');
            return redirect('/academic-calendar');
        }

        $data = [
            'academic_year' => $request->post('academic_year'),
            'start_date' => $request->post('start_date'),
            'end_date' => $request->post('end_date'),
            'session_name' => $request->post('session_name') ?: null,
            'session_start' => $request->post('session_start') ?: null,
            'session_end' => $request->post('session_end') ?: null,
            'exam_start' => $request->post('exam_start') ?: null,
            'exam_end' => $request->post('exam_end') ?: null,
            'admission_start' => $request->post('admission_start') ?: null,
            'admission_end' => $request->post('admission_end') ?: null,
            'holidays' => $request->post('holidays') ?: null,
            'important_events' => $request->post('important_events') ?: null,
            'status' => $request->post('status', 'active'),
            'notes' => $request->post('notes') ?: null,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($this->academicCalendarModel->update($id, $data)) {
            flash('success', 'Academic calendar updated successfully');
            return redirect('/academic-calendar');
        }

        flash('error', 'Failed to update academic calendar');
        return redirect('/academic-calendar/' . $id . '/edit');
    }

    public function destroy($request, $id)
    {
        $calendar = $this->academicCalendarModel->find($id);
        if (!$calendar) {
            flash('error', 'Calendar not found');
            return redirect('/academic-calendar');
        }

        if ($this->academicCalendarModel->delete($id)) {
            flash('success', 'Academic calendar deleted successfully');
            return redirect('/academic-calendar');
        }

        flash('error', 'Failed to delete academic calendar');
        return redirect('/academic-calendar');
    }
}
