<?php

$router->get('/', function($request) {
    if (isAuth()) {
        return redirect('/dashboard');
    }
    return redirect('/login');
});

$router->group(['middleware' => 'guest'], function($router) {
    $router->get('/login', 'AuthController@showLogin');
    $router->post('/login', 'AuthController@login');
    $router->get('/register', 'AuthController@showRegister');
    $router->post('/register', 'AuthController@register');
    $router->get('/forgot-password', 'AuthController@showForgotPassword');
    $router->post('/send-otp', 'AuthController@sendOTP');
    $router->get('/reset-password', 'AuthController@showResetPassword');
    $router->post('/reset-password', 'AuthController@resetPassword');
});

// Public Routes (no authentication required)
$router->get('/admission/track', 'AdmissionController@track');
$router->get('/admissions/create', 'AdmissionController@create');
$router->post('/admissions', 'AdmissionController@store', ['csrf']);

$router->group(['middleware' => 'auth'], function($router) {
    $router->get('/logout', 'AuthController@logout');
    $router->get('/dashboard', 'DashboardController@index');

    // All Features Page
    $router->get('/features', function() {
        return view('features/index', ['title' => 'All Features']);
    });

    // Profile Routes
    $router->get('/profile', 'ProfileController@index');
    $router->get('/profile/edit', 'ProfileController@edit');
    $router->post('/profile/update', 'ProfileController@update', ['csrf']);
    $router->get('/profile/documents', 'ProfileController@documents');
    $router->post('/profile/upload-document', 'ProfileController@uploadDocument', ['csrf']);
    $router->get('/profile/change-password', 'ProfileController@changePassword');
    $router->post('/profile/update-password', 'ProfileController@updatePassword', ['csrf']);

    $router->get('/notifications', 'NotificationController@index');
    $router->get('/notifications/unread', 'NotificationController@unread');
    $router->post('/notifications/{id}/mark-as-read', 'NotificationController@markAsRead', ['csrf']);
    $router->post('/notifications/mark-all-read', 'NotificationController@markAllAsRead', ['csrf']);

    // Messages & Announcements
    $router->get('/messages', 'MessageController@index');
    $router->get('/messages/create', 'MessageController@create');
    $router->post('/messages', 'MessageController@store', ['csrf']);

    $router->get('/announcements', 'AnnouncementController@index');
    $router->get('/announcements/create', 'AnnouncementController@create');
    $router->post('/announcements', 'AnnouncementController@store', ['csrf']);

    $router->get('/materials', 'MaterialController@index');

    $router->group(['middleware' => 'role:admin,teacher'], function($router) {
        $router->get('/materials/create', 'MaterialController@create');
        $router->post('/materials', 'MaterialController@store', ['csrf']);
        $router->delete('/materials/{id}', 'MaterialController@destroy', ['csrf']);
    });

    $router->get('/materials/{id}', 'MaterialController@show');
    $router->get('/materials/{id}/download', 'MaterialController@download');

    $router->group(['middleware' => 'role:admin,teacher'], function($router) {
        $router->get('/attendance', 'AttendanceController@index');
        $router->get('/attendance/mark', 'AttendanceController@mark');
        $router->post('/attendance/store', 'AttendanceController@store', ['csrf']);
        $router->get('/attendance/report', 'AttendanceController@report');

        $router->get('/marks', 'MarkController@index');
        $router->get('/marks/enter', 'MarkController@enter');
        $router->post('/marks/store', 'MarkController@store', ['csrf']);
        $router->get('/marks/report-card/{studentId}/{examId}', 'MarkController@reportCard');

        $router->get('/timetable', 'TimetableController@index');
        $router->get('/timetable/view', 'TimetableController@view');
        $router->get('/timetable/teacher', 'TimetableController@teacherTimetable');
    });

    $router->group(['middleware' => 'role:admin'], function($router) {
        // Calendar & Holiday Management
        $router->get('/calendar', 'CalendarController@index');
        $router->get('/calendar/create', 'CalendarController@create');
        $router->post('/calendar/create', 'CalendarController@create', ['csrf']);
        $router->get('/calendar/{id}/edit', 'CalendarController@edit');
        $router->post('/calendar/{id}/edit', 'CalendarController@edit', ['csrf']);
        $router->post('/calendar/{id}/delete', 'CalendarController@delete', ['csrf']);
        
        $router->get('/calendar/holidays', 'CalendarController@holidays');
        $router->get('/calendar/holidays/create', 'CalendarController@createHoliday');
        $router->post('/calendar/holidays/create', 'CalendarController@createHoliday', ['csrf']);
        $router->get('/calendar/holidays/{id}/edit', 'CalendarController@editHoliday');
        $router->post('/calendar/holidays/{id}/edit', 'CalendarController@editHoliday', ['csrf']);
        $router->post('/calendar/holidays/{id}/delete', 'CalendarController@deleteHoliday', ['csrf']);

        $router->get('/students', 'StudentController@index');
        $router->get('/students/create', 'StudentController@create');
        $router->post('/students', 'StudentController@store', ['csrf']);
        $router->get('/students/{id}', 'StudentController@show');
        $router->get('/students/{id}/edit', 'StudentController@edit');
        $router->post('/students/{id}', 'StudentController@update', ['csrf']);
        $router->post('/students/{id}/toggle-status', 'StudentController@toggleStatus', ['csrf']);
        $router->delete('/students/{id}', 'StudentController@destroy', ['csrf']);

        $router->get('/staff', 'StaffController@index');
        $router->get('/staff/create', 'StaffController@create');
        $router->post('/staff', 'StaffController@store', ['csrf']);
        $router->get('/staff/{id}', 'StaffController@show');
        $router->get('/staff/{id}/edit', 'StaffController@edit');
        $router->post('/staff/{id}', 'StaffController@update', ['csrf']);
        $router->post('/staff/{id}/toggle-status', 'StaffController@toggleStatus', ['csrf']);
        $router->delete('/staff/{id}', 'StaffController@destroy', ['csrf']);

        $router->get('/courses', 'CourseController@index');
        $router->get('/courses/create', 'CourseController@create');
        $router->post('/courses', 'CourseController@store', ['csrf']);
        $router->get('/courses/{id}', 'CourseController@show');
        $router->get('/courses/{id}/edit', 'CourseController@edit');
        $router->post('/courses/{id}', 'CourseController@update', ['csrf']);
        $router->delete('/courses/{id}', 'CourseController@destroy', ['csrf']);

        $router->get('/classes', 'ClassController@index');
        $router->get('/classes/create', 'ClassController@create');
        $router->post('/classes', 'ClassController@store', ['csrf']);
        $router->get('/classes/{id}', 'ClassController@show');
        $router->get('/classes/{id}/edit', 'ClassController@edit');
        $router->post('/classes/{id}', 'ClassController@update', ['csrf']);
        $router->delete('/classes/{id}', 'ClassController@destroy', ['csrf']);

        $router->get('/subjects', 'SubjectController@index');
        $router->get('/subjects/create', 'SubjectController@create');
        $router->post('/subjects', 'SubjectController@store', ['csrf']);
        $router->get('/subjects/{id}', 'SubjectController@show');
        $router->get('/subjects/{id}/edit', 'SubjectController@edit');
        $router->post('/subjects/{id}', 'SubjectController@update', ['csrf']);
        $router->delete('/subjects/{id}', 'SubjectController@destroy', ['csrf']);

        // Admissions Management (Admin Only)
        $router->get('/admissions', 'AdmissionController@index');
        $router->get('/admissions/statistics', 'AdmissionController@statistics');
        $router->get('/admissions/{id}', 'AdmissionController@show');
        $router->get('/admissions/{id}/edit', 'AdmissionController@edit');
        $router->put('/admissions/{id}', 'AdmissionController@update', ['csrf']);
        $router->post('/admissions/{id}/approve', 'AdmissionController@approve', ['csrf']);
        $router->post('/admissions/{id}/reject', 'AdmissionController@reject', ['csrf']);
        $router->post('/admissions/{id}/waitlist', 'AdmissionController@waitlist', ['csrf']);
        $router->post('/admissions/{id}/convert', 'AdmissionController@convertToStudent', ['csrf']);

        $router->get('/exams', 'ExamController@index');
        $router->get('/exams/create', 'ExamController@create');
        $router->post('/exams', 'ExamController@store', ['csrf']);
        $router->get('/exams/{id}', 'ExamController@show');
        $router->get('/exams/{id}/edit', 'ExamController@edit');
        $router->post('/exams/{id}', 'ExamController@update', ['csrf']);
        $router->delete('/exams/{id}', 'ExamController@destroy', ['csrf']);

        $router->get('/invoices', 'InvoiceController@index');
        $router->get('/invoices/create', 'InvoiceController@create');
        $router->get('/invoices/defaulters', 'InvoiceController@defaulters');
        $router->post('/invoices', 'InvoiceController@store', ['csrf']);
        $router->get('/invoices/{id}', 'InvoiceController@show');
        $router->post('/invoices/{id}/payment', 'InvoiceController@recordPayment', ['csrf']);

        $router->get('/timetable/create', 'TimetableController@create');
        $router->post('/timetable', 'TimetableController@store', ['csrf']);
        $router->delete('/timetable/{id}', 'TimetableController@destroy', ['csrf']);

        $router->post('/notifications/send', 'NotificationController@send', ['csrf']);

        // === COMPREHENSIVE FEATURE ROUTES ===
        // Roles & Permissions
        $router->get('/roles', 'RoleController@index');
        $router->get('/roles/create', 'RoleController@create');
        $router->post('/roles', 'RoleController@store', ['csrf']);
        $router->get('/roles/{id}', 'RoleController@show');
        $router->get('/roles/{id}/edit', 'RoleController@edit');
        $router->post('/roles/{id}', 'RoleController@update', ['csrf']);
        $router->post('/roles/{id}/delete', 'RoleController@destroy', ['csrf']);
        
        // Departments
        $router->get('/departments', 'DepartmentController@index');
        $router->get('/departments/create', 'DepartmentController@create');
        $router->post('/departments', 'DepartmentController@store', ['csrf']);
        $router->get('/departments/{id}', 'DepartmentController@show');
        $router->get('/departments/{id}/edit', 'DepartmentController@edit');
        $router->post('/departments/{id}', 'DepartmentController@update', ['csrf']);
        $router->post('/departments/{id}/delete', 'DepartmentController@destroy', ['csrf']);
        
        // Academic Extensions
        $router->get('/syllabus', 'SyllabusController@index');
        $router->get('/syllabus/create', 'SyllabusController@create');
        $router->post('/syllabus', 'SyllabusController@store', ['csrf']);
        $router->get('/syllabus/{id}', 'SyllabusController@show');
        $router->get('/syllabus/{id}/edit', 'SyllabusController@edit');
        $router->post('/syllabus/{id}', 'SyllabusController@update', ['csrf']);
        $router->delete('/syllabus/{id}', 'SyllabusController@destroy', ['csrf']);
        
        $router->get('/lesson-plans', 'LessonPlanController@index');
        $router->get('/lesson-plans/create', 'LessonPlanController@create');
        $router->post('/lesson-plans', 'LessonPlanController@store', ['csrf']);
        $router->get('/lesson-plans/{id}', 'LessonPlanController@show');
        $router->get('/lesson-plans/{id}/edit', 'LessonPlanController@edit');
        $router->post('/lesson-plans/{id}', 'LessonPlanController@update', ['csrf']);
        $router->delete('/lesson-plans/{id}', 'LessonPlanController@destroy', ['csrf']);
        
        $router->get('/question-bank', 'QuestionBankController@index');
        $router->get('/question-bank/create', 'QuestionBankController@create');
        $router->post('/question-bank', 'QuestionBankController@store', ['csrf']);
        $router->get('/question-bank/{id}', 'QuestionBankController@show');
        $router->get('/question-bank/{id}/edit', 'QuestionBankController@edit');
        $router->post('/question-bank/{id}', 'QuestionBankController@update', ['csrf']);
        $router->delete('/question-bank/{id}', 'QuestionBankController@destroy', ['csrf']);
        
        $router->get('/academic-calendar', 'AcademicCalendarController@index');
        $router->get('/academic-calendar/create', 'AcademicCalendarController@create');
        $router->post('/academic-calendar', 'AcademicCalendarController@store', ['csrf']);
        $router->get('/academic-calendar/{id}', 'AcademicCalendarController@show');
        $router->get('/academic-calendar/{id}/edit', 'AcademicCalendarController@edit');
        $router->post('/academic-calendar/{id}', 'AcademicCalendarController@update', ['csrf']);
        $router->delete('/academic-calendar/{id}', 'AcademicCalendarController@destroy', ['csrf']);
        
        // Finance Extensions
        $router->get('/fee-structure', 'FeeStructureController@index');
        $router->get('/fee-structure/create', 'FeeStructureController@create');
        $router->post('/fee-structure', 'FeeStructureController@store', ['csrf']);
        $router->get('/fee-structure/{id}', 'FeeStructureController@show');
        $router->get('/fee-structure/{id}/edit', 'FeeStructureController@edit');
        $router->post('/fee-structure/{id}', 'FeeStructureController@update', ['csrf']);
        $router->delete('/fee-structure/{id}', 'FeeStructureController@destroy', ['csrf']);
        
        $router->get('/expenses', 'ExpenseController@index');
        $router->get('/expenses/create', 'ExpenseController@create');
        $router->post('/expenses', 'ExpenseController@store', ['csrf']);
        $router->get('/expenses/{id}', 'ExpenseController@show');
        $router->get('/expenses/{id}/edit', 'ExpenseController@edit');
        $router->post('/expenses/{id}', 'ExpenseController@update', ['csrf']);
        $router->post('/expenses/{id}/delete', 'ExpenseController@destroy', ['csrf']);
        
        $router->get('/payroll', 'PayrollController@index');
        $router->get('/payroll/create', 'PayrollController@create');
        $router->post('/payroll', 'PayrollController@store', ['csrf']);
        $router->get('/payroll/{id}', 'PayrollController@show');
        $router->get('/payroll/{id}/edit', 'PayrollController@edit');
        $router->post('/payroll/{id}', 'PayrollController@update', ['csrf']);
        $router->post('/payroll/{id}/delete', 'PayrollController@destroy', ['csrf']);
        
        $router->get('/budget', 'BudgetController@index');
        $router->get('/budget/create', 'BudgetController@create');
        $router->post('/budget', 'BudgetController@store', ['csrf']);
        $router->get('/budget/{id}', 'BudgetController@show');
        $router->get('/budget/{id}/edit', 'BudgetController@edit');
        $router->post('/budget/{id}', 'BudgetController@update', ['csrf']);
        $router->post('/budget/{id}/delete', 'BudgetController@destroy', ['csrf']);
        
        // Library Management
        $router->get('/library', function() { return redirect('/library/books'); });
        $router->get('/library/create', function() { return redirect('/library/books/create'); });
        $router->get('/library/books', 'LibraryController@index');
        $router->get('/library/books/create', 'LibraryController@create');
        $router->post('/library/books', 'LibraryController@store', ['csrf']);
        $router->get('/library/books/{id}', 'LibraryController@show');
        $router->get('/library/books/{id}/edit', 'LibraryController@edit');
        $router->post('/library/books/{id}', 'LibraryController@update', ['csrf']);
        $router->post('/library/books/{id}/delete', 'LibraryController@destroy', ['csrf']);
        $router->get('/library/issue', 'LibraryController@issue');
        $router->post('/library/issue', 'LibraryController@processIssue', ['csrf']);
        $router->post('/library/return', 'LibraryController@processReturn', ['csrf']);
        $router->get('/library/members', 'LibraryController@members');
        $router->get('/library/members/create', 'LibraryController@createMember');
        $router->post('/library/members', 'LibraryController@storeMember', ['csrf']);
        $router->post('/library/members/{id}/toggle-status', 'LibraryController@toggleMemberStatus', ['csrf']);
        
        // Transport Management
        $router->get('/transport', function() { return redirect('/transport/vehicles'); });
        $router->get('/transport/create', function() { return redirect('/transport/vehicles/create'); });
        $router->get('/transport/vehicles', 'TransportController@index');
        $router->get('/transport/vehicles/create', 'TransportController@create');
        $router->post('/transport/vehicles', 'TransportController@store', ['csrf']);
        $router->get('/transport/routes', 'TransportController@routes');
        $router->get('/transport/assignments', 'TransportController@assignments');
        
        // Hostel Management
        $router->get('/hostel', function() { return redirect('/hostel/rooms'); });
        $router->get('/hostel/create', function() { return redirect('/hostel/rooms/create'); });
        $router->get('/hostel/rooms', 'HostelController@index');
        $router->get('/hostel/rooms/create', 'HostelController@create');
        $router->post('/hostel/rooms', 'HostelController@store', ['csrf']);
        $router->get('/hostel/residents', 'HostelController@residents');
        $router->get('/hostel/visitors', 'HostelController@visitors');
        $router->get('/hostel/complaints', 'HostelController@complaints');
        
        // Inventory Management
        $router->get('/inventory', function() { return redirect('/inventory/assets'); });
        $router->get('/inventory/create', function() { return redirect('/inventory/assets/create'); });
        $router->get('/inventory/assets', 'InventoryController@index');
        $router->get('/inventory/assets/create', 'InventoryController@create');
        $router->post('/inventory/assets', 'InventoryController@store', ['csrf']);
        $router->get('/inventory/stock', 'InventoryController@stock');
        $router->get('/inventory/purchase-orders', 'InventoryController@purchaseOrders');
        $router->get('/inventory/suppliers', 'InventoryController@suppliers');
        
        // Reports
        $router->get('/reports/attendance', 'ReportController@attendance');
        $router->get('/reports/academic', 'ReportController@academic');
        $router->get('/reports/financial', 'ReportController@financial');
        $router->get('/reports/custom', 'ReportController@custom');
        
        // System Settings
        $router->get('/settings', 'SettingController@index');
        $router->get('/settings/backup', 'SettingController@backup');
        $router->get('/settings/audit-logs', 'SettingController@auditLogs');
        $router->post('/settings', 'SettingController@update', ['csrf']);

        // New Menu Routes - Placeholder Pages
        $router->get('/admissions/waitlist', function() {
            return view('placeholder', ['title' => 'Waitlist', 'module' => 'Admissions Waitlist']);
        });
        
        
        $router->get('/report-cards', 'ReportCardController@index');
        $router->get('/report-cards/print-all/{classId}/{examId}', 'ReportCardController@printAll');
        
        $router->get('/fees', function() {
            return view('placeholder', ['title' => 'Fee Structure', 'module' => 'Fee Structure Management']);
        });
        
        $router->get('/payments', function() {
            return view('placeholder', ['title' => 'Payment Gateway', 'module' => 'Online Payments']);
        });
        
        $router->get('/collections', function() {
            return view('placeholder', ['title' => 'Fee Collections', 'module' => 'Collections']);
        });
        
        
        $router->get('/online-classes', function() {
            return view('placeholder', ['title' => 'Online Classes', 'module' => 'Virtual Classroom']);
        });
        
        $router->get('/sms', function() {
            return view('placeholder', ['title' => 'SMS Management', 'module' => 'SMS Communication']);
        });
        
        $router->get('/email', function() {
            return view('placeholder', ['title' => 'Email Management', 'module' => 'Email Communication']);
        });
        
        $router->get('/whatsapp', function() {
            return view('placeholder', ['title' => 'WhatsApp Integration', 'module' => 'WhatsApp Communication']);
        });
        
        $router->get('/branches', function() {
            return view('placeholder', ['title' => 'Multi-Branch Management', 'module' => 'Branch Management']);
        });
        
        $router->get('/integrations', function() {
            return view('placeholder', ['title' => 'Integrations', 'module' => 'Third-Party Integrations']);
        });
        
        $router->get('/backup', function() {
            return view('placeholder', ['title' => 'Backup & Restore', 'module' => 'Data Backup']);
        });
        
        $router->get('/logs', function() {
            return view('placeholder', ['title' => 'Audit Logs', 'module' => 'Activity Logs']);
        });
        
        // Leave Management
        $router->get('/leave', 'LeaveController@index');
        $router->get('/leave/create', 'LeaveController@create');
        $router->post('/leave', 'LeaveController@store', ['csrf']);
        $router->get('/leave/{id}', 'LeaveController@show');
        $router->get('/leave/{id}/edit', 'LeaveController@edit');
        $router->post('/leave/{id}', 'LeaveController@update', ['csrf']);
        $router->delete('/leave/{id}', 'LeaveController@destroy', ['csrf']);
        
        // Admin Leave Approval
        $router->group(['middleware' => 'role:admin'], function($router) {
            $router->post('/leave/{id}/approve', 'LeaveController@approve', ['csrf']);
            $router->post('/leave/{id}/reject', 'LeaveController@reject', ['csrf']);
        });
    });
});
