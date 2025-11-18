<?php

namespace App\Controllers;

use App\Models\SchoolCalendar;
use App\Models\Holiday;
use App\Models\ClassModel;

class CalendarController
{
    private $calendarModel;
    private $holidayModel;
    private $classModel;

    public function __construct()
    {
        $this->calendarModel = new SchoolCalendar();
        $this->holidayModel = new Holiday();
        $this->classModel = new ClassModel();
    }

    // Calendar Events Management
    public function index()
    {
        $filters = [
            'month' => $_GET['month'] ?? date('m'),
            'year' => $_GET['year'] ?? date('Y'),
            'event_type' => $_GET['event_type'] ?? '',
            'class_id' => $_GET['class_id'] ?? ''
        ];

        $events = $this->calendarModel->getAll($filters);
        $classes = $this->classModel->getAll();
        $eventTypes = $this->calendarModel->getEventTypes();

        view('calendar/index', [
            'events' => $events,
            'classes' => $classes,
            'eventTypes' => $eventTypes,
            'filters' => $filters
        ]);
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => $_POST['title'],
                'description' => $_POST['description'] ?? null,
                'event_date' => $_POST['event_date'],
                'end_date' => $_POST['end_date'] ?? null,
                'event_type' => $_POST['event_type'] ?? 'event',
                'category' => $_POST['category'] ?? null,
                'color' => $_POST['color'] ?? '#4e73df',
                'is_holiday' => isset($_POST['is_holiday']) ? 1 : 0,
                'is_public' => isset($_POST['is_public']) ? 1 : 0,
                'class_id' => !empty($_POST['class_id']) ? $_POST['class_id'] : null,
                'department' => $_POST['department'] ?? null,
                'created_by' => auth()['id']
            ];

            if ($this->calendarModel->create($data)) {
                $_SESSION['success'] = 'Calendar event created successfully';
                redirect('/calendar');
            } else {
                $_SESSION['error'] = 'Failed to create calendar event';
            }
        }

        $classes = $this->classModel->getAll();
        $eventTypes = $this->calendarModel->getEventTypes();

        view('calendar/create', [
            'classes' => $classes,
            'eventTypes' => $eventTypes
        ]);
    }

    public function edit($id)
    {
        $event = $this->calendarModel->getById($id);

        if (!$event) {
            $_SESSION['error'] = 'Event not found';
            redirect('/calendar');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => $_POST['title'],
                'description' => $_POST['description'] ?? null,
                'event_date' => $_POST['event_date'],
                'end_date' => $_POST['end_date'] ?? null,
                'event_type' => $_POST['event_type'] ?? 'event',
                'category' => $_POST['category'] ?? null,
                'color' => $_POST['color'] ?? '#4e73df',
                'is_holiday' => isset($_POST['is_holiday']) ? 1 : 0,
                'is_public' => isset($_POST['is_public']) ? 1 : 0,
                'class_id' => !empty($_POST['class_id']) ? $_POST['class_id'] : null,
                'department' => $_POST['department'] ?? null
            ];

            if ($this->calendarModel->update($id, $data)) {
                $_SESSION['success'] = 'Calendar event updated successfully';
                redirect('/calendar');
            } else {
                $_SESSION['error'] = 'Failed to update calendar event';
            }
        }

        $classes = $this->classModel->getAll();
        $eventTypes = $this->calendarModel->getEventTypes();

        view('calendar/edit', [
            'event' => $event,
            'classes' => $classes,
            'eventTypes' => $eventTypes
        ]);
    }

    public function delete($id)
    {
        if ($this->calendarModel->delete($id)) {
            $_SESSION['success'] = 'Calendar event deleted successfully';
        } else {
            $_SESSION['error'] = 'Failed to delete calendar event';
        }
        redirect('/calendar');
    }

    // Holiday Management
    public function holidays()
    {
        $filters = [
            'year' => $_GET['year'] ?? date('Y'),
            'holiday_type' => $_GET['holiday_type'] ?? '',
            'status' => $_GET['status'] ?? ''
        ];

        $holidays = $this->holidayModel->getAll($filters);
        $holidayTypes = $this->holidayModel->getHolidayTypes();

        view('calendar/holidays', [
            'holidays' => $holidays,
            'holidayTypes' => $holidayTypes,
            'filters' => $filters
        ]);
    }

    public function createHoliday()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'description' => $_POST['description'] ?? null,
                'start_date' => $_POST['start_date'],
                'end_date' => $_POST['end_date'],
                'holiday_type' => $_POST['holiday_type'] ?? 'school',
                'is_recurring' => isset($_POST['is_recurring']) ? 1 : 0,
                'status' => $_POST['status'] ?? 'active',
                'created_by' => auth()['id']
            ];

            if ($this->holidayModel->create($data)) {
                $_SESSION['success'] = 'Holiday created successfully';
                redirect('/calendar/holidays');
            } else {
                $_SESSION['error'] = 'Failed to create holiday';
            }
        }

        $holidayTypes = $this->holidayModel->getHolidayTypes();

        view('calendar/create-holiday', [
            'holidayTypes' => $holidayTypes
        ]);
    }

    public function editHoliday($id)
    {
        $holiday = $this->holidayModel->getById($id);

        if (!$holiday) {
            $_SESSION['error'] = 'Holiday not found';
            redirect('/calendar/holidays');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'description' => $_POST['description'] ?? null,
                'start_date' => $_POST['start_date'],
                'end_date' => $_POST['end_date'],
                'holiday_type' => $_POST['holiday_type'] ?? 'school',
                'is_recurring' => isset($_POST['is_recurring']) ? 1 : 0,
                'status' => $_POST['status'] ?? 'active'
            ];

            if ($this->holidayModel->update($id, $data)) {
                $_SESSION['success'] = 'Holiday updated successfully';
                redirect('/calendar/holidays');
            } else {
                $_SESSION['error'] = 'Failed to update holiday';
            }
        }

        $holidayTypes = $this->holidayModel->getHolidayTypes();

        view('calendar/edit-holiday', [
            'holiday' => $holiday,
            'holidayTypes' => $holidayTypes
        ]);
    }

    public function deleteHoliday($id)
    {
        if ($this->holidayModel->delete($id)) {
            $_SESSION['success'] = 'Holiday deleted successfully';
        } else {
            $_SESSION['error'] = 'Failed to delete holiday';
        }
        redirect('/calendar/holidays');
    }
}
