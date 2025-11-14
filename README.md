# School/College/Institution Management System (SCIMS)

A complete ERP system built with Core PHP 8+ using custom MVC architecture.

## Features
- Authentication & Authorization (RBAC)
- User Management (Students, Staff, Parents)
- Admissions Management
- Academic Management (Courses, Classes, Subjects)
- Timetable Management
- Attendance Tracking
- Exam & Marks Management
- Fee & Finance Management
- Learning Management System (LMS)
- Notifications

## Installation

1. Copy `.env.example` to `.env` and configure your database credentials
2. Import database migrations from `/database/migrations`
3. Set up your web server to point to `/public` directory
4. Access the application through your browser

## Requirements
- PHP 8.0 or higher
- MySQL 5.7 or higher
- PDO Extension
- Apache/Nginx with mod_rewrite

## Security
- Password hashing using password_hash()
- PDO prepared statements
- CSRF protection
- Session-based authentication
- XSS prevention

## License
Proprietary
