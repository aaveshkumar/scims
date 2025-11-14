# School/College/Institution Management System (SCIMS)

## Project Overview
A complete School/College/Institution Management System built with Core PHP 8+ using a custom MVC architecture. This is a production-level ERP system with comprehensive modules for managing educational institutions.

## Current State
**Status**: Step 2 completed - Configuration system with .env loader implemented

## Tech Stack
- **Backend**: Core PHP 8.4 (OOP)
- **Database**: MySQL (Remote via PDO)
- **Architecture**: Custom MVC
- **Frontend**: Bootstrap 5 + Vanilla JavaScript
- **Authentication**: Session-based with RBAC
- **Security**: PDO prepared statements, CSRF protection, password hashing

## Project Structure
```
/app
  /controllers - Handle application logic
  /models - Database operations
  /views - UI templates (PHP + HTML + Bootstrap)
  /middleware - AuthMiddleware, RoleMiddleware
  /helpers - Utility functions
/config - Configuration files (database, app)
/database
  /migrations - SQL migration files
/public
  index.php - Entry point
  /uploads - User uploaded files
  /assets - CSS, JS, images
/routes
  web.php - Application routes
.env.example - Environment variables template
```

## Modules
1. **Authentication & Security**: Login, logout, password reset, RBAC
2. **User Management**: Students, Staff, Parents CRUD
3. **Admissions**: Public form, document upload, approval workflow
4. **Academics**: Courses, Classes, Subjects, teacher-subject mapping
5. **Timetable**: Class/teacher schedules with room mapping
6. **Attendance**: Daily & period-wise tracking
7. **Exams & Marks**: Exam creation, marks entry, report cards
8. **Fees & Finance**: Fee structures, invoices, payment tracking
9. **LMS**: Study materials upload and management
10. **Notifications**: Internal notification system

## Database Tables
- users, roles, user_roles
- admissions, students, staff
- subjects, classes, courses
- timetables, attendance
- exams, marks
- fees_structures, invoices
- materials, notifications
- otp_resets

## Recent Changes
- **2025-11-14**: Initial project setup
  - Created complete folder structure
  - Added .env.example template
  - Created placeholder files for MVC components
  - Set up .gitignore for security
  - Implemented Env class for .env file parsing
  - Created Config class for configuration management
  - Built bootstrap.php with global error handling
  - Configured database and app settings
  - Set up session management with custom parameters

## Development Progress
- [x] Step 1: Folder structure + empty files
- [x] Step 2: Config loader + env handling
- [ ] Step 3: Router + request/response classes
- [ ] Step 4: Base Model + DB connection
- [ ] Step 5: Database migrations
- [ ] Step 6: Models for each module
- [ ] Step 7: Controllers with CRUD
- [ ] Step 8: Views with Bootstrap
- [ ] Step 9: Routes configuration
- [ ] Step 10: Middleware setup

## User Preferences
- Strict MVC architecture
- No frameworks or external libraries
- Use only Core PHP features
- PDO for all database operations
- Bootstrap for UI
- Step-by-step development with confirmation at each stage

## Architecture Decisions
- **MVC Pattern**: Strict separation of concerns
- **Custom Router**: Built from scratch with middleware support
- **PDO**: All database queries use prepared statements
- **Session Management**: Native PHP sessions for auth
- **CSRF Protection**: Token-based validation
- **File Structure**: Industry-standard organization
