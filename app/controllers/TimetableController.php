<?php

class TimetableController
{
    private $timetableModel;
    private $classModel;
    private $subjectModel;

    public function __construct()
    {
        $this->timetableModel = new Timetable();
        $this->classModel = new ClassModel();
        $this->subjectModel = new Subject();
    }

    public function index($request)
    {
        $classes = $this->classModel->where('status', 'active')->get();
        return view('timetable.index', ['classes' => $classes]);
    }

    public function view($request)
    {
        $classId = $request->get('class_id');
        $academicYear = $request->get('academic_year', date('Y'));

        if (!$classId) {
            flash('error', 'Please select a class');
            return redirect('/timetable');
        }

        $class = $this->classModel->find($classId);
        if (!$class) {
            flash('error', 'Class not found');
            return redirect('/timetable');
        }

        $timetable = $this->timetableModel->getClassTimetable($classId, $academicYear);

        $schedule = [];
        foreach ($timetable as $entry) {
            $schedule[$entry['day_of_week']][] = $entry;
        }

        return view('timetable.view', [
            'class' => $class,
            'schedule' => $schedule,
            'academicYear' => $academicYear
        ]);
    }

    public function create($request)
    {
        $classes = $this->classModel->where('status', 'active')->get();
        $subjects = $this->subjectModel->where('status', 'active')->get();
        
        $teachers = db()->fetchAll(
            "SELECT u.id, u.first_name, u.last_name 
             FROM users u
             INNER JOIN staff s ON u.id = s.user_id
             WHERE u.status = 'active' AND s.status = 'active'
             ORDER BY u.first_name, u.last_name"
        );

        return view('timetable.create', [
            'classes' => $classes,
            'subjects' => $subjects,
            'teachers' => $teachers
        ]);
    }

    public function store($request)
    {
        $rules = [
            'class_id' => 'required|numeric',
            'subject_id' => 'required|numeric',
            'start_time' => 'required',
            'end_time' => 'required',
            'academic_year' => 'required'
        ];

        if (!validate($request->post(), $rules)) {
            flash('error', 'Please fix the validation errors');
            return back();
        }

        $daysOfWeek = $request->post('day_of_week', []);
        if (empty($daysOfWeek)) {
            flash('error', 'Please select at least one day');
            return back();
        }

        try {
            $createdCount = 0;
            foreach ($daysOfWeek as $day) {
                $this->timetableModel->create([
                    'class_id' => $request->post('class_id'),
                    'subject_id' => $request->post('subject_id'),
                    'teacher_id' => $request->post('teacher_id') ?: null,
                    'day_of_week' => $day,
                    'start_time' => $request->post('start_time'),
                    'end_time' => $request->post('end_time'),
                    'room_number' => $request->post('room_number') ?: null,
                    'academic_year' => $request->post('academic_year'),
                    'semester' => $request->post('semester') ?: null,
                    'status' => 'active'
                ]);
                $createdCount++;
            }

            flash('success', 'Timetable entries created successfully (' . $createdCount . ' day' . ($createdCount > 1 ? 's' : '') . ')');
            return redirect('/timetable');
        } catch (Exception $e) {
            flash('error', 'Failed to create timetable entry: ' . $e->getMessage());
            return back();
        }
    }

    public function destroy($request, $id)
    {
        try {
            $this->timetableModel->delete($id);
            flash('success', 'Timetable entry deleted successfully');
            return redirect('/timetable');
        } catch (Exception $e) {
            flash('error', 'Failed to delete timetable entry: ' . $e->getMessage());
            return back();
        }
    }

    public function teacherTimetable($request)
    {
        $teacherId = $request->get('teacher_id', auth()['id']);
        $academicYear = $request->get('academic_year', date('Y'));

        $timetable = $this->timetableModel->getTeacherTimetable($teacherId, $academicYear);

        $schedule = [];
        foreach ($timetable as $entry) {
            $schedule[$entry['day_of_week']][] = $entry;
        }

        return view('timetable.teacher', [
            'schedule' => $schedule,
            'academicYear' => $academicYear
        ]);
    }
}
