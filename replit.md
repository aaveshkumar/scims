# School/College/Institution Management System (SCIMS)

## Overview
SCIMS is a comprehensive ERP system for educational institutions, built with Core PHP 8+ using a custom MVC architecture. It aims to streamline operations through modules for administration, academics, finance, and communication. Key capabilities include managing students, staff, and parents, with features for admissions, attendance, exams, fees, and an integrated Learning Management System (LMS). The project provides a robust, production-level platform for efficient institutional management.

## User Preferences
- Strict MVC architecture
- No frameworks or external libraries
- Use only Core PHP features
- PDO for all database operations
- Bootstrap for UI
- Step-by-step development with confirmation at each stage

## System Architecture
The system employs a custom MVC architecture for clear separation of concerns.

**Technical Implementations:**
- **Backend**: Core PHP 8.4 (OOP).
- **Frontend**: Bootstrap 5 + Vanilla JavaScript for a responsive UI.
- **Database**: PostgreSQL (Neon), accessed via PDO with prepared statements for security.
- **Authentication**: Session-based with Role-Based Access Control (RBAC).
- **Security**: PDO prepared statements, CSRF protection, and robust password hashing.
- **Custom Router**: Handles dynamic routes and middleware.
- **Session Management**: Native PHP sessions.

**Feature Specifications:**
- **Authentication & Security**: Login with loader animation, logout, password reset, RBAC.
- **User Management**: CRUD for Students, Staff, and Parents.
- **Admissions**: Public application form, document upload, approval workflow.
- **Academics**: Manages Courses, Classes, Subjects, teacher-subject mappings.
- **Timetable**: Creation and management of class/teacher schedules.
- **Attendance**: Daily and period-wise tracking.
- **Exams & Marks**: Exam creation, marks entry, report card generation.
- **Assignments**: Full CRUD with delete functionality, submission tracking, grading.
- **Quizzes**: Comprehensive quiz management with scheduling, duration control, marks settings.
- **Fees & Finance**: Fee structures, invoicing, payment tracking, expenses, payroll, budget planning.
- **LMS**: Study material management, question bank, lesson plans, syllabus.
- **Notifications**: Internal communication system.

**System Design Choices:**
- **UI/UX**: Bootstrap 5 for consistent design across 85+ views, including responsive layouts. Dark/light mode toggle with `localStorage` persistence.
- **File Structure**: Industry-standard organization (`/app`, `/config`, `/database`, `/public`, `/routes`).
- **Database Schema**: Proper relationships, foreign keys, indexing, and cascading operations.

## Recent Updates (Session: Nov 30, 2025)
- **Assignments Module**: Fixed database join queries (students → users for names), added comprehensive delete buttons with confirmation dialogs
- **Login Page**: Added animated loader spinner when user clicks Sign In, auto-hides on errors, disabled button during auth
- **Quizzes Module**: Fixed 404 error by registering routes, corrected auth() function usage (array not object), fixed Quiz model getAttempts joins
- **Quiz Creation Form**: Built meaningful multi-section form with:
  - Quiz Details (title, description)
  - Subject & Class selection
  - Quiz Schedule (start/end date-time)
  - Duration & Marks settings
  - Passing marks configuration
- **Quiz Index Page**: Added delete buttons (trash icon) with confirmation dialogs for inline actions
- **Forums Module**: Complete implementation with full CRUD:
  - Routes: GET /forums (list), POST /forums (create), GET /forums/{id} (view), POST /forums/{id} (update), DELETE /forums/{id}
  - Database integration with proper joins (forums → users → subjects → classes)
  - Index page displays all forums with title, subject, class, creator, status, created date, and action buttons
  - Create/Edit forms with subject and class selection
  - 5 dummy forums inserted for testing (General Discussion, Study Groups, Assignment Help, Doubt Clearing, Announcements)
- **Calendar Module**: Complete implementation with full CRUD:
  - Fixed 500 error by rewriting CalendarController to match app architecture patterns
  - Created calendar_events table with proper schema (date, time, location, event_type, creator)
  - Routes: GET /calendar (list), POST /calendar/create (store), GET /calendar/{id} (view), GET /calendar/{id}/edit, POST /calendar/{id}/edit, POST /calendar/{id}/delete
  - Index page displays all events with title, date, time, location, type, creator
  - Meaningful create/edit forms with multi-section layout: Event Details, Date & Time, Location
  - Event types: Event, Holiday, Exam, Meeting, Deadline
  - 5 dummy events inserted for testing (Annual Sports Day, Science Exhibition, PTM, Final Exams, Prize Distribution)
- **Holidays Management**: Complete implementation with full CRUD:
  - Created holidays table with proper schema (name, dates, type, status, creator)
  - Routes: GET /calendar/holidays (list), POST /calendar/holidays/create (store), GET /calendar/holidays/{id} (view), GET /calendar/holidays/{id}/edit, POST /calendar/holidays/{id}/edit, POST /calendar/holidays/{id}/delete
  - Index page displays all holidays with name, dates, type, status, creator
  - Meaningful create/edit forms with multi-section layout: Holiday Details, Duration, Settings
  - Holiday types: Holiday, Festival, Vacation, Special
  - 5 dummy holidays inserted for testing (Diwali, Christmas, New Year, Summer Vacation, Teacher Training Day)

## Critical Bug Fixes
- **auth() Function**: Changed from auth()->user()['id'] to auth()['id'] - auth() returns array from $_SESSION, not object
- **Database Joins**: Fixed student name queries to properly join students → users tables
- **PostgreSQL Compatibility**: All queries use CURRENT_DATE, INTERVAL syntax (not MySQL CURDATE/DATE_ADD)
- **Route Ordering**: Specific routes like `/calendar/holidays` MUST come BEFORE parameterized routes like `/calendar/{id}` to prevent matching conflicts

## External Dependencies
- **Database**: PostgreSQL (Neon) via PDO
- **Frontend Framework**: Bootstrap 5
- **Icons**: Bootstrap Icons 1.11.0
- **Features**: Dark/Light mode toggle, CSRF protection, session-based RBAC, loader animations
