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

$router->group(['middleware' => 'auth'], function($router) {
    $router->get('/logout', 'AuthController@logout');
    $router->get('/dashboard', 'DashboardController@index');

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

    $router->get('/materials', 'MaterialController@index');
    $router->get('/materials/{id}', 'MaterialController@show');
    $router->get('/materials/{id}/download', 'MaterialController@download');

    $router->group(['middleware' => 'role:admin,teacher'], function($router) {
        $router->get('/materials/create', 'MaterialController@create');
        $router->post('/materials', 'MaterialController@store', ['csrf']);
        $router->delete('/materials/{id}', 'MaterialController@destroy', ['csrf']);

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
        $router->get('/students', 'StudentController@index');
        $router->get('/students/create', 'StudentController@create');
        $router->post('/students', 'StudentController@store', ['csrf']);
        $router->get('/students/{id}', 'StudentController@show');
        $router->get('/students/{id}/edit', 'StudentController@edit');
        $router->post('/students/{id}', 'StudentController@update', ['csrf']);
        $router->delete('/students/{id}', 'StudentController@destroy', ['csrf']);

        $router->get('/staff', 'StaffController@index');
        $router->get('/staff/create', 'StaffController@create');
        $router->post('/staff', 'StaffController@store', ['csrf']);
        $router->get('/staff/{id}', 'StaffController@show');
        $router->get('/staff/{id}/edit', 'StaffController@edit');
        $router->post('/staff/{id}', 'StaffController@update', ['csrf']);
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

        $router->get('/admissions', 'AdmissionController@index');
        $router->get('/admissions/create', 'AdmissionController@create');
        $router->post('/admissions', 'AdmissionController@store', ['csrf']);
        $router->get('/admissions/{id}', 'AdmissionController@show');
        $router->post('/admissions/{id}/approve', 'AdmissionController@approve', ['csrf']);
        $router->post('/admissions/{id}/reject', 'AdmissionController@reject', ['csrf']);

        $router->get('/exams', 'ExamController@index');
        $router->get('/exams/create', 'ExamController@create');
        $router->post('/exams', 'ExamController@store', ['csrf']);
        $router->get('/exams/{id}', 'ExamController@show');
        $router->get('/exams/{id}/edit', 'ExamController@edit');
        $router->post('/exams/{id}', 'ExamController@update', ['csrf']);
        $router->delete('/exams/{id}', 'ExamController@destroy', ['csrf']);

        $router->get('/invoices', 'InvoiceController@index');
        $router->get('/invoices/create', 'InvoiceController@create');
        $router->post('/invoices', 'InvoiceController@store', ['csrf']);
        $router->get('/invoices/{id}', 'InvoiceController@show');
        $router->post('/invoices/{id}/payment', 'InvoiceController@recordPayment', ['csrf']);
        $router->get('/invoices/defaulters', 'InvoiceController@defaulters');

        $router->get('/timetable/create', 'TimetableController@create');
        $router->post('/timetable', 'TimetableController@store', ['csrf']);
        $router->delete('/timetable/{id}', 'TimetableController@destroy', ['csrf']);

        $router->post('/notifications/send', 'NotificationController@send', ['csrf']);

        // New Menu Routes - Placeholder Pages
        $router->get('/admissions/waitlist', function() {
            return view('placeholder', ['title' => 'Waitlist', 'module' => 'Admissions Waitlist']);
        });
        
        $router->get('/syllabus', function() {
            return view('placeholder', ['title' => 'Syllabus & Lesson Plans', 'module' => 'Syllabus Management']);
        });
        
        $router->get('/question-bank', function() {
            return view('placeholder', ['title' => 'Question Bank', 'module' => 'Question Bank']);
        });
        
        $router->get('/users', function() {
            return view('placeholder', ['title' => 'User Accounts', 'module' => 'User Management']);
        });
        
        $router->get('/roles', function() {
            return view('placeholder', ['title' => 'Roles & Permissions', 'module' => 'RBAC Management']);
        });
        
        $router->get('/departments', function() {
            return view('placeholder', ['title' => 'Departments', 'module' => 'Department Management']);
        });
        
        $router->get('/leaves', function() {
            return view('placeholder', ['title' => 'Leave Management', 'module' => 'Leave Management']);
        });
        
        $router->get('/report-cards', function() {
            return view('placeholder', ['title' => 'Report Cards', 'module' => 'Report Cards']);
        });
        
        $router->get('/fees', function() {
            return view('placeholder', ['title' => 'Fee Structure', 'module' => 'Fee Structure Management']);
        });
        
        $router->get('/payments', function() {
            return view('placeholder', ['title' => 'Payment Gateway', 'module' => 'Online Payments']);
        });
        
        $router->get('/collections', function() {
            return view('placeholder', ['title' => 'Fee Collections', 'module' => 'Collections']);
        });
        
        $router->get('/payroll', function() {
            return view('placeholder', ['title' => 'Payroll Management', 'module' => 'Staff Payroll']);
        });
        
        $router->get('/expenses', function() {
            return view('placeholder', ['title' => 'Expense Management', 'module' => 'Expenses']);
        });
        
        $router->get('/assignments', function() {
            return view('placeholder', ['title' => 'Assignments', 'module' => 'Assignment Management']);
        });
        
        $router->get('/quizzes', function() {
            return view('placeholder', ['title' => 'Quizzes', 'module' => 'Quiz Management']);
        });
        
        $router->get('/online-classes', function() {
            return view('placeholder', ['title' => 'Online Classes', 'module' => 'Virtual Classroom']);
        });
        
        $router->get('/library', function() {
            return view('placeholder', ['title' => 'Library Management', 'module' => 'Library']);
        });
        
        $router->get('/transport', function() {
            return view('placeholder', ['title' => 'Transport Management', 'module' => 'Transport']);
        });
        
        $router->get('/hostel', function() {
            return view('placeholder', ['title' => 'Hostel Management', 'module' => 'Hostel']);
        });
        
        $router->get('/inventory', function() {
            return view('placeholder', ['title' => 'Inventory & Assets', 'module' => 'Inventory']);
        });
        
        $router->get('/messages', function() {
            return view('placeholder', ['title' => 'Messages', 'module' => 'Messaging']);
        });
        
        $router->get('/announcements', function() {
            return view('placeholder', ['title' => 'Announcements', 'module' => 'Announcements']);
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
        
        $router->get('/reports/attendance', function() {
            return view('placeholder', ['title' => 'Attendance Reports', 'module' => 'Attendance Analytics']);
        });
        
        $router->get('/reports/finance', function() {
            return view('placeholder', ['title' => 'Finance Reports', 'module' => 'Financial Analytics']);
        });
        
        $router->get('/reports/academic', function() {
            return view('placeholder', ['title' => 'Academic Reports', 'module' => 'Academic Analytics']);
        });
        
        $router->get('/settings', function() {
            return view('placeholder', ['title' => 'System Settings', 'module' => 'System Configuration']);
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
    });
});
