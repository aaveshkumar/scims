<?php

// Add comprehensive routes for all 43 features
// This file will be appended to web.php

return [
    // Roles & Permissions (Admin only)
    ['GET', '/roles', 'RoleController@index', ['role:admin']],
    ['GET', '/roles/create', 'RoleController@create', ['role:admin']],
    ['POST', '/roles', 'RoleController@store', ['role:admin', 'csrf']],
    ['GET', '/roles/{id}', 'RoleController@show', ['role:admin']],
    ['GET', '/roles/{id}/edit', 'RoleController@edit', ['role:admin']],
    ['POST', '/roles/{id}', 'RoleController@update', ['role:admin', 'csrf']],
    ['DELETE', '/roles/{id}', 'RoleController@destroy', ['role:admin', 'csrf']],

    // Departments
    ['GET', '/departments', 'DepartmentController@index', ['role:admin']],
    ['GET', '/departments/create', 'DepartmentController@create', ['role:admin']],
    ['POST', '/departments', 'DepartmentController@store', ['role:admin', 'csrf']],
    ['GET', '/departments/{id}', 'DepartmentController@show', ['role:admin']],
    ['GET', '/departments/{id}/edit', 'DepartmentController@edit', ['role:admin']],
    ['POST', '/departments/{id}', 'DepartmentController@update', ['role:admin', 'csrf']],

    // Syllabus
    ['GET', '/syllabus', 'SyllabusController@index', ['role:admin,teacher']],
    ['GET', '/syllabus/create', 'SyllabusController@create', ['role:admin,teacher']],
    ['POST', '/syllabus', 'SyllabusController@store', ['role:admin,teacher', 'csrf']],
    ['GET', '/syllabus/{id}', 'SyllabusController@show', ['role:admin,teacher']],

    // Lesson Plans
    ['GET', '/lesson-plans', 'LessonPlanController@index', ['role:admin,teacher']],
    ['GET', '/lesson-plans/create', 'LessonPlanController@create', ['role:admin,teacher']],
    ['POST', '/lesson-plans', 'LessonPlanController@store', ['role:admin,teacher', 'csrf']],

    // Question Bank
    ['GET', '/question-bank', 'QuestionBankController@index', ['role:admin,teacher']],
    ['GET', '/question-bank/create', 'QuestionBankController@create', ['role:admin,teacher']],
    ['POST', '/question-bank', 'QuestionBankController@store', ['role:admin,teacher', 'csrf']],

    // Academic Calendar
    ['GET', '/academic-calendar', 'AcademicCalendarController@index', ['role:admin']],
    ['GET', '/academic-calendar/create', 'AcademicCalendarController@create', ['role:admin']],
    ['POST', '/academic-calendar', 'AcademicCalendarController@store', ['role:admin', 'csrf']],

    // Leave Management
    ['GET', '/leave', 'LeaveController@index', []],
    ['GET', '/leave/create', 'LeaveController@create', []],
    ['POST', '/leave', 'LeaveController@store', ['csrf']],
    ['GET', '/leave/{id}', 'LeaveController@show', []],

    // Fee Structure
    ['GET', '/fee-structure', 'FeeStructureController@index', ['role:admin']],
    ['GET', '/fee-structure/create', 'FeeStructureController@create', ['role:admin']],
    ['POST', '/fee-structure', 'FeeStructureController@store', ['role:admin', 'csrf']],

    // Expenses
    ['GET', '/expenses', 'ExpenseController@index', ['role:admin']],
    ['GET', '/expenses/create', 'ExpenseController@create', ['role:admin']],
    ['POST', '/expenses', 'ExpenseController@store', ['role:admin', 'csrf']],

    // Payroll
    ['GET', '/payroll', 'PayrollController@index', ['role:admin']],
    ['GET', '/payroll/create', 'PayrollController@create', ['role:admin']],
    ['POST', '/payroll', 'PayrollController@store', ['role:admin', 'csrf']],

    // Budget
    ['GET', '/budget', 'BudgetController@index', ['role:admin']],
    ['GET', '/budget/create', 'BudgetController@create', ['role:admin']],
    ['POST', '/budget', 'BudgetController@store', ['role:admin', 'csrf']],

    // Assignments
    ['GET', '/assignments', 'AssignmentController@index', []],
    ['GET', '/assignments/create', 'AssignmentController@create', ['role:admin,teacher']],
    ['POST', '/assignments', 'AssignmentController@store', ['role:admin,teacher', 'csrf']],
    ['GET', '/assignments/{id}', 'AssignmentController@show', []],

    // Quizzes
    ['GET', '/quizzes', 'QuizController@index', []],
    ['GET', '/quizzes/create', 'QuizController@create', ['role:admin,teacher']],
    ['POST', '/quizzes', 'QuizController@store', ['role:admin,teacher', 'csrf']],
    ['GET', '/quizzes/{id}', 'QuizController@show', []],

    // Forums
    ['GET', '/forums', 'ForumController@index', []],
    ['GET', '/forums/create', 'ForumController@create', []],
    ['POST', '/forums', 'ForumController@store', ['csrf']],
    ['GET', '/forums/{id}', 'ForumController@show', []],

    // Library
    ['GET', '/library/books', 'LibraryController@index', []],
    ['GET', '/library/books/create', 'LibraryController@create', ['role:admin']],
    ['POST', '/library/books', 'LibraryController@store', ['role:admin', 'csrf']],
    ['GET', '/library/issue', 'LibraryController@issue', []],
    ['GET', '/library/members', 'LibraryController@members', ['role:admin']],

    // Transport
    ['GET', '/transport/vehicles', 'TransportController@index', ['role:admin']],
    ['GET', '/transport/vehicles/create', 'TransportController@create', ['role:admin']],
    ['POST', '/transport/vehicles', 'TransportController@store', ['role:admin', 'csrf']],
    ['GET', '/transport/routes', 'TransportController@routes', ['role:admin']],
    ['GET', '/transport/assignments', 'TransportController@assignments', ['role:admin']],

    // Hostel
    ['GET', '/hostel/rooms', 'HostelController@index', ['role:admin']],
    ['GET', '/hostel/rooms/create', 'HostelController@create', ['role:admin']],
    ['POST', '/hostel/rooms', 'HostelController@store', ['role:admin', 'csrf']],
    ['GET', '/hostel/residents', 'HostelController@residents', ['role:admin']],
    ['GET', '/hostel/visitors', 'HostelController@visitors', ['role:admin']],
    ['GET', '/hostel/complaints', 'HostelController@complaints', []],

    // Inventory
    ['GET', '/inventory/assets', 'InventoryController@index', ['role:admin']],
    ['GET', '/inventory/assets/create', 'InventoryController@create', ['role:admin']],
    ['POST', '/inventory/assets', 'InventoryController@store', ['role:admin', 'csrf']],
    ['GET', '/inventory/stock', 'InventoryController@stock', ['role:admin']],
    ['GET', '/inventory/purchase-orders', 'InventoryController@purchaseOrders', ['role:admin']],
    ['GET', '/inventory/suppliers', 'InventoryController@suppliers', ['role:admin']],

    // Announcements
    ['GET', '/announcements', 'AnnouncementController@index', []],
    ['GET', '/announcements/create', 'AnnouncementController@create', ['role:admin']],
    ['POST', '/announcements', 'AnnouncementController@store', ['role:admin', 'csrf']],
    ['GET', '/announcements/{id}', 'AnnouncementController@show', []],

    // Messages
    ['GET', '/messages', 'MessageController@index', []],
    ['GET', '/messages/create', 'MessageController@create', []],
    ['POST', '/messages', 'MessageController@store', ['csrf']],
    ['GET', '/messages/{id}', 'MessageController@show', []],

    // Reports
    ['GET', '/reports/attendance', 'ReportController@attendance', ['role:admin,teacher']],
    ['GET', '/reports/academic', 'ReportController@academic', ['role:admin,teacher']],
    ['GET', '/reports/financial', 'ReportController@financial', ['role:admin']],
    ['GET', '/reports/custom', 'ReportController@custom', ['role:admin']],

    // Settings
    ['GET', '/settings', 'SettingController@index', ['role:admin']],
    ['GET', '/settings/backup', 'SettingController@backup', ['role:admin']],
    ['GET', '/settings/audit-logs', 'SettingController@auditLogs', ['role:admin']],
    ['POST', '/settings', 'SettingController@update', ['role:admin', 'csrf']],

    // Report Cards (already exists, adding here for completeness)
    ['GET', '/report-cards', 'MarkController@index', ['role:admin,teacher']],
];
