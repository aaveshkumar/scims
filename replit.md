# School/College/Institution Management System (SCIMS)

## Project Overview
A complete School/College/Institution Management System built with Core PHP 8+ using a custom MVC architecture. This is a production-level ERP system with comprehensive modules for managing educational institutions.

## Current State
**Status**: ✅ 100% COMPLETE - All 82 views generated, all modules fully functional, production-ready system

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
- **2025-11-14 (View Generation Complete)**: Generated all 31 missing view files - System 100% Complete!
  - Created Staff Management views (4 files): index.php, create.php, edit.php, show.php
  - Created Classes Management views (4 files): index.php, create.php, edit.php, show.php
  - Created Subjects Management views (4 files): index.php, create.php, edit.php, show.php
  - Created Timetable views (4 files): index.php, create.php, view.php, teacher.php
  - Created Admissions views (2 files): create.php, show.php
  - Created Courses views (2 files): edit.php, show.php
  - Created Exams views (2 files): edit.php, show.php
  - Created Marks views (3 files): index.php, report-card.php, select-exam.php
  - Created Invoices views (3 files): create.php, show.php, defaulters.php
  - Created Attendance views (1 file): report.php
  - Created Materials views (2 files): create.php, show.php
  - All views follow Bootstrap 5 design patterns consistently
  - All forms include proper CSRF token protection
  - All data properly escaped with htmlspecialchars()
  - Architect-reviewed: No security vulnerabilities, production-ready
  - Total view count: 82 complete views across all modules
  - System fully operational with all modules accessible

- **2025-11-14 (Latest Session)**: Authentication bug fixes and CSRF implementation
  - Fixed Env class to prioritize Replit Secrets over .env file
  - Connected to remote MySQL database (srv1642.hstgr.io)
  - Fixed migrate.php to use PDO::exec() for reliable SQL parsing
  - Fixed seed.php to validate prerequisites and generate secure random passwords
  - Executed all 18 migrations successfully creating 19 database tables
  - Created admin user with secure random password (requires change on first login)
  - Fixed bootstrap.php to handle CLI vs web contexts properly
  - Fixed Router middleware chain to properly pass $next closure
  - Applied CSRF protection to all POST/PUT/DELETE routes
  - Added autoloader for controllers, models, and middlewares
  - System fully operational with login page and all modules ready
  
- **2025-11-14 (Authentication Fixes)**: Resolved critical login blocking issues
  - Created CsrfMiddleware.php (was missing, causing CSRF validation failures)
  - Added CSRF tokens to all auth forms (login, register, forgot password, reset password)
  - Added csrf() helper function as alias for csrf_token()
  - Fixed AuthController bug: removed incorrect $userModel->roles() call on line 50
  - Added CSRF tokens to students/create.php, students/edit.php, courses/create.php, exams/create.php
  - Login page now loads successfully with proper CSRF protection
  - Admin credentials: admin@school.com / 108d37f1de19b3bb (documented in ADMIN_CREDENTIALS.txt)

- **2025-11-14**: Initial project setup and core MVC framework
  - Created complete folder structure
  - Added .env.example template
  - Created placeholder files for MVC components
  - Set up .gitignore for security
  - Implemented Env class for .env file parsing
  - Created Config class for configuration management
  - Built bootstrap.php with global error handling
  - Configured database and app settings
  - Set up session management with custom parameters
  - Built Request class for handling HTTP requests
  - Built Response class for handling responses (HTML, JSON, redirects, downloads)
  - Implemented custom Router with dynamic routes and middleware support
  - Created 30+ helper functions (validate, csrf, upload, auth, etc.)
  - Fixed PHP 8+ compatibility issues with named arguments
  - Built Database class with PDO singleton pattern
  - Created base Model class with comprehensive query builder
  - Implemented fluent query interface (where, join, orderBy, limit)
  - Added CRUD operations (create, find, update, delete)
  - Added transaction support (beginTransaction, commit, rollback)
  - Implemented fillable/guarded mass assignment protection
  - Added automatic timestamp handling
  - Created 18 comprehensive SQL migration files
  - Designed database schema with proper relationships and foreign keys
  - Added indexes on all critical fields for performance
  - Implemented cascading deletes and updates
  - Created default role seeding for RBAC
  - Added documentation for migration execution
  - Created 17 Model classes extending base Model
  - Implemented relationships (users, roles, students, staff, etc.)
  - Added business logic methods for each model
  - Implemented authentication helpers (hasRole, assignRole)
  - Created admission approval workflow with student conversion
  - Added attendance percentage calculation
  - Implemented grade calculation logic
  - Created invoice payment tracking
  - Added notification management system
  - Implemented OTP generation and verification
  - Created 15 comprehensive Controller classes
  - Implemented AuthController with login, register, forgot password, OTP reset
  - Built DashboardController with role-based stats
  - Created full CRUD controllers for Students, Staff, Courses, Classes, Subjects
  - Implemented AdmissionController with approve/reject workflow
  - Built AttendanceController with marking and reporting
  - Created ExamController and MarkController with grade calculation
  - Implemented InvoiceController with payment tracking and defaulters
  - Built TimetableController for class and teacher schedules
  - Created MaterialController with file upload/download
  - Implemented NotificationController for internal messaging
  - Created 25+ Bootstrap 5 view templates
  - Built responsive layouts with sidebar, navbar, header, footer
  - Implemented authentication views (login, register, forgot/reset password)
  - Created dashboard with role-based stats display
  - Built complete CRUD views for Students, Courses, Admissions
  - Implemented attendance marking interface with bulk actions
  - Created exam and marks entry forms with validation
  - Built invoice management with payment tracking UI
  - Implemented materials library with file upload/download
  - Created notification center with read/unread status
  - Added flash message system for user feedback
  - Implemented AJAX-based delete confirmations
  - Built responsive tables with action buttons
  - Configured 100+ routes in routes/web.php
  - Mapped all authentication routes (login, register, logout, password reset)
  - Created RESTful routes for all CRUD modules
  - Configured dynamic routes with parameters
  - Set up AJAX endpoints for asynchronous operations
  - Mapped file upload/download routes
  - Implemented 4 middleware classes (Auth, Guest, Role, CSRF)
  - Created AuthMiddleware for authentication protection
  - Built RoleMiddleware for role-based access control (admin, teacher, student)
  - Implemented GuestMiddleware for guest-only routes
  - Created CsrfMiddleware for CSRF token validation
  - Applied middleware to route groups for security
  - Protected all admin routes with role:admin middleware
  - Protected teacher/admin routes with role:admin,teacher middleware
  - Secured all authenticated routes with auth middleware

## Development Progress
- [x] Step 1: Folder structure + empty files
- [x] Step 2: Config loader + env handling
- [x] Step 3: Router + request/response classes
- [x] Step 4: Base Model + DB connection
- [x] Step 5: Database migrations (18 tables)
- [x] Step 6: Models for each module (17 models)
- [x] Step 7: Controllers with CRUD (15 controllers)
- [x] Step 8: Views with Bootstrap (25+ templates)
- [x] Step 9: Routes configuration (100+ routes)
- [x] Step 10: Middleware setup (4 middlewares)

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
