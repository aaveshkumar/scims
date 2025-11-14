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
    });
});
