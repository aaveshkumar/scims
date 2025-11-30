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
- **Transport**: Vehicle management, driver profiles with license numbers, route planning, payroll processing.
- **HR**: Events management, recruitment with job positions, staff payroll with salary components.
- **Hostel**: Room management with multi-section forms, 26 dummy rooms across 5 hostels, residents tracking, visitors log, complaint system.

**System Design Choices:**
- **UI/UX**: Bootstrap 5 for consistent design across 90+ views, including responsive layouts. Dark/light mode toggle with `localStorage` persistence.
- **File Structure**: Industry-standard organization (`/app`, `/config`, `/database`, `/public`, `/routes`).
- **Database Schema**: Proper relationships, foreign keys, indexing, and cascading operations.

## Recent Updates (Session: Nov 30, 2025)

### Hostel Complaints Module - FIXED ✅
- **Fixed PostgreSQL FIELD() Function Error**: Changed MySQL `FIELD()` to PostgreSQL `CASE` statements
  - Lines 44-48: Fixed priority and status ordering in getAll()
  - Line 146: Fixed priority ordering in getDashboard()
- **5 Dummy Complaints Added** with realistic data (Maintenance, Cleanliness, Noise, Utilities, Safety)

### Hostel Visitors Module - COMPLETE ✅
- **Full CRUD Implementation** (`/hostel/visitors`):
  - Visitors list with search, date range filters
  - Statistics dashboard (Today Visitors, Active Visitors, This Month, Active Now)
  - Add visitor form with multi-section layout (Visitor Info, Resident & Purpose, Visit Schedule)
  - Edit visitor form with form pre-population
  - Delete with inline confirmation
  - Action buttons (Edit/Delete) for each visitor record
  - Add Visitor button in header for quick access
- **5 Dummy Visitors** already assigned to different residents
- **Fixed PostgreSQL Date Functions**:
  - `CURDATE()` → `CURRENT_DATE`
  - `MONTH(visit_date) = MONTH(CURDATE())` → `DATE_TRUNC('month', visit_date) = DATE_TRUNC('month', CURRENT_DATE)`
  - Updated getStatistics() method with null coalescing for safety
- **Dark Mode CSS**: All forms styled for dark mode compatibility

### Hostel Residents Module - COMPLETE ✅
- **Full CRUD Implementation** (`/hostel/residents`):
  - Residents list with search, hostel filter, status filter
  - Statistics dashboard (Total, Active, Inactive, Avg Stay duration)
  - Add resident form with multi-section layout (Student, Room, Dates, Contact)
  - Edit resident form with form pre-population
  - Delete with inline confirmation
- **9 Dummy Residents** already assigned to rooms across 5 hostels
- **5 New Students** created for additional resident assignments
- **Fixed Database Queries**: Changed to properly join students → users for name retrieval
- **Dynamic Room Selection**: Hostel dropdown triggers room filtering via JavaScript
- **Dark Mode CSS**: All forms styled for dark mode compatibility

### Dashboard Quick Actions - EXPANDED ✅
- Reorganized into **6 organized categories** with **26 quick action buttons**:
  - User Management (Add/View Students, Add/View Staff)
  - Academics (Attendance, Marks, Exams, Courses, Subjects)
  - Finance (Create/View Invoices)
  - Admissions & Hostel (New Admission, View Applications, **Add/View Residents**)
  - Transport & HR (Vehicles, Drivers, HR Events, Recruitment, Payroll)
  - Learning (Materials)
- Role-based display: Admins see all, others see limited options

### Complete Visitor CRUD Routes & Controller ✅
- **Routes Added** (routes/web.php):
  - `GET /hostel/visitors/create` → createVisitor form
  - `POST /hostel/visitors` → storeVisitor
  - `GET /hostel/visitors/{id}/edit` → editVisitor form
  - `POST /hostel/visitors/{id}` → updateVisitor
  - `POST /hostel/visitors/{id}/delete` → deleteVisitor
- **Controller Methods Added** (app/controllers/HostelController.php):
  - createVisitor() - displays create form with active residents dropdown
  - storeVisitor() - validates and creates visitor record (fixed auth()['id'] access)
  - editVisitor() - displays edit form with pre-populated data
  - updateVisitor() - validates and updates visitor record
  - deleteVisitor() - removes visitor with confirmation
- **Views Created**:
  - `/app/views/hostel/visitors/create.php` - multi-section add form
  - `/app/views/hostel/visitors/edit.php` - multi-section edit form
  - Updated `/app/views/hostel/visitors.php` - list with actions and Add button

### Critical SQL Query Fixes ✅
- **HostelVisitor Model**: Fixed 3 queries (getAll, find, getActiveVisitors) + getStatistics()
  - Changed from `s.first_name` to `u_s.first_name` (via students→users join)
  - Fixed PostgreSQL date: `CURDATE()` → `CURRENT_DATE`, `MONTH/YEAR()` → `DATE_TRUNC()`
  - Added null safety with `?? 0` in getStatistics()
- **HostelComplaint Model**: Fixed 2 queries (getAll, find) + resolve()
  - Same students→users join pattern for name retrieval
  - Fixed PostgreSQL date: `CURDATE()` → `CURRENT_DATE`
- **Query Pattern**: Added alias renaming (u_s for student user, u_a for assigned user)

### Transport Module - COMPLETE ✅
- **Vehicles**: 5 dummy vehicles with full CRUD, view/edit/delete buttons
- **Drivers**: 5 dummy drivers with license numbers (DL-2024-001 through DL-2024-005), payroll processing
- **Routes**: 5 dummy routes with auto-populated details
- Inline delete forms for each row to prevent routing conflicts
- All forms use POST with CSRF protection
- Navigation tabs: Vehicles, Drivers, Routes

### Hostel Rooms Module - COMPLETE ✅
- **Fixed 500 Error**: Query column issue - changed 4 queries from `name` to `CONCAT(first_name, ' ', last_name)`
- **Rooms Management** (`/hostel/rooms`):
  - List view with filters (Hostel, Status), statistics dashboard
  - Add room form with 3 sections: Basic Info (Hostel, Room #, Type, Capacity), Location (Floor, Fee), Settings (Status)
  - Edit room form with same structure
  - Delete with inline confirmation
- **26 Dummy Rooms**: Distributed across 5 hostels with varying capacity levels
- Column fix: Uses `room_fee` (not `rent`) - correct database column

### HR Module - COMPLETE ✅
- **HR Events**: Full CRUD, 5 dummy events (Onboarding, Team Building, Performance Review, Professional Workshop, Policy Update)
- **Recruitment**: Full CRUD for job positions, 5 dummy positions (Senior Teacher, Accountant, HR Manager, Lab Tech, Admin)
- **Payroll**: Full CRUD using existing payroll table (basic_salary, allowances, deductions, net_salary), 4+ dummy payroll records
- Routes properly ordered (specific before parameterized) to prevent route matching conflicts
- All controllers use db()->fetchAll/fetchOne with proper staff/user joins
- Multi-section forms: Staff Info, Period/Details, Salary Info, Settings
- Tables display with view/edit/delete buttons and inline confirmation dialogs

## Critical Bug Fixes & Implementation Details

### Database & Query Fixes
- **auth() Function**: Changed from auth()->user()['id'] to auth()['id'] - auth() returns array from $_SESSION, not object
- **Database Joins**: Fixed student name queries to properly join students → users tables
- **User Name Queries**: Changed 4 queries in HostelController from `SELECT id, name` to `SELECT id, CONCAT(first_name, ' ', last_name) as name` for compatibility
- **Column Names**: Verified and used correct column names (e.g., `room_fee` not `rent`, `first_name`/`last_name` not `name`)
- **PostgreSQL Compatibility**: All queries use CURRENT_DATE, INTERVAL syntax (not MySQL CURDATE/DATE_ADD)

### Route Ordering (CRITICAL)
- **Specific routes MUST come BEFORE parameterized routes**
- Example order: `/transport/vehicles` → `/transport/vehicles/{id}/edit` → `/transport/vehicles/{id}/delete` → `/transport/{id}` (catch-all)
- **Current Routes Structure**:
  - /hostel/rooms (roomsIndex)
  - /hostel/rooms/create (createRoom)
  - /hostel/rooms/{id}/edit (editRoom)
  - /hostel/rooms/{id} (updateRoom/deleteRoom)
  - /hostel (index - generic)
  - /hostel/{id} (show - generic catch-all)

### Form Patterns - Inline Delete
- Each delete button in tables is now an inline form with direct action URL
- Pattern: `<form method="POST" action="/path/{id}/delete" style="display: inline;">` + `onclick="return confirm('...')"`
- Eliminates JavaScript complexity and routing conflicts

## External Dependencies
- **Database**: PostgreSQL (Neon) via PDO
- **Frontend Framework**: Bootstrap 5
- **Icons**: Bootstrap Icons 1.11.0
- **Features**: Dark/Light mode toggle, CSRF protection, session-based RBAC, loader animations

## Test Credentials
- Admin: `admin@test.local` / `password123`
- Teacher: `teacher@test.local` / `password123`
- Student: `student@test.local` / `password123`
- HR: `hr@test.local` / `password123`

## Module Implementation Status
- ✅ Authentication & Dashboard
- ✅ Student Management
- ✅ Staff Management
- ✅ Academics (Courses, Classes, Subjects)
- ✅ Attendance
- ✅ Exams & Marks
- ✅ Assignments & Quizzes
- ✅ Finance & Fees
- ✅ Calendar & Timetable
- ✅ Transport (Vehicles, Drivers, Routes)
- ✅ HR (Events, Recruitment, Payroll)
- ✅ Hostel (Rooms, Residents, Visitors, Complaints)
- ✅ LMS (Materials, Resources)
- ⏳ Reports (Partial)
- ⏳ Notifications (Partial)
