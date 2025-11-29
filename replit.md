# School/College/Institution Management System (SCIMS)

## Overview
SCIMS is a comprehensive, production-level ERP system designed for managing educational institutions. Built with Core PHP 8+ using a custom MVC architecture, it offers a complete suite of modules for administration, academics, finance, and communication. Its purpose is to streamline institutional operations, provide a robust platform for managing students, staff, and parents, and offer features like admissions, attendance, exams, fees, and an integrated LMS.

## User Preferences
- Strict MVC architecture
- No frameworks or external libraries
- Use only Core PHP features
- PDO for all database operations
- Bootstrap for UI
- Step-by-step development with confirmation at each stage

## System Architecture
The system is built on a custom MVC (Model-View-Controller) architecture, ensuring a clear separation of concerns.

**Technical Implementations:**
- **Backend**: Core PHP 8.4 (OOP)
- **Frontend**: Bootstrap 5 + Vanilla JavaScript for a responsive and modern UI.
- **Database**: MySQL, accessed via PDO for all operations, emphasizing prepared statements for security.
- **Authentication**: Session-based with Role-Based Access Control (RBAC) for managing user permissions.
- **Security**: Implements PDO prepared statements, CSRF protection, and robust password hashing.
- **Custom Router**: Developed from scratch to handle dynamic routes and middleware.
- **Session Management**: Utilizes native PHP sessions for user authentication.

**Feature Specifications:**
- **Authentication & Security**: Includes login, logout, password reset, and RBAC.
- **User Management**: Comprehensive CRUD operations for Students, Staff, and Parents.
- **Admissions**: Public application form, document upload, and an approval workflow.
- **Academics**: Manages Courses, Classes, Subjects, and teacher-subject mappings.
- **Timetable**: Allows creation and management of class and teacher schedules with room mapping.
- **Attendance**: Supports daily and period-wise attendance tracking.
- **Exams & Marks**: Features exam creation, marks entry, and report card generation.
- **Fees & Finance**: Handles fee structures, invoicing, and payment tracking.
- **LMS**: Provides functionality for uploading and managing study materials.
- **Notifications**: An internal system for institution-wide communications.

**System Design Choices:**
- **UI/UX**: Utilizes Bootstrap 5 for consistent design patterns across all 82 views, including responsive layouts with a sidebar, navbar, header, and footer. Dark/light mode toggle with `localStorage` persistence is implemented.
- **File Structure**: Adheres to an industry-standard organization (`/app`, `/config`, `/database`, `/public`, `/routes`).
- **Database Schema**: Designed with proper relationships, foreign keys, indexing for performance, and cascading deletes/updates.

## External Dependencies
- **Database**: MySQL (Remote via PDO)
- **Frontend Framework**: Bootstrap 5

## Recent Changes (November 29, 2025)

### Course Management Module - Critical Fixes
- **Fixed 500 Error on Courses List**: Null status handling with null coalesce operators
- **Fixed Delete Button**: Implemented form-based POST with _method=DELETE override
- **Added Status Field to Edit Form**: Dropdown to change course active/inactive status
- **Database Cleanup**: Updated 3 courses with NULL status to 'active'
- **Method Override Support**: Added _method parameter handling in Request class for REST operations

### Student Management Module - Critical Fixes
- **Fixed Student Edit 404 Error**: Removed _method=PUT from edit form (route expects POST)
- **Fixed Student Delete JSON Response**: Changed destroy() to use redirect instead of JSON response
- **Student Status Toggle**: AJAX endpoint working correctly
- **Edit Form Now Saves**: Student updates persist to database without 404 errors

### Timetable Module - Critical Fixes
- **Fixed 500 Error on Timetable View**: Removed MySQL FIELD() function, replaced with PostgreSQL CASE statement
- **Fixed Teacher Name Display**: Added CONCAT() for proper teacher name formatting
- **PostgreSQL Compatibility**: Updated SQL query to be database-agnostic

### Files Modified:
- `app/views/courses/index.php` - Fixed null status display, added delete button
- `app/views/courses/edit.php` - Added status dropdown selector
- `app/views/students/edit.php` - Removed _method=PUT (use standard POST)
- `app/views/layouts/footer.php` - Replaced fetch DELETE with form-based submission
- `app/helpers/Request.php` - Added _method override support for PUT/DELETE
- `app/controllers/StudentController.php` - Changed destroy() to redirect, fixed delete
- `app/models/Timetable.php` - Fixed PostgreSQL compatibility, proper field aliasing

### Class Management Module - Critical Fixes
- **Fixed Class Edit 404 Error**: Removed _method=PUT from edit form (route expects POST)
- **Fixed Class Delete JSON Response**: Changed destroy() to use redirect instead of JSON response
- **Added Missing Code Field**: Added Class Code input field (required) to fix validation error
- **Added Status Dropdown**: Added status selector to toggle active/inactive in edit form
- **All Class CRUD Operations**: CREATE/READ/UPDATE/DELETE fully functional

### Timetable Module - Critical Fixes
- **Fixed Teachers Dropdown Empty**: Changed query from user_roles to staff table (5 teachers now showing)
- **Fixed Day of Week Constraint Error**: Changed dropdown values from capitalized to lowercase (matching database check constraint)
- **Fixed Timetable Entries Not Displaying**: Changed view.php day loop from Capitalized to lowercase for proper matching
- **Fixed Empty Integer Fields**: Convert empty strings to NULL for teacher_id, room_number, semester
- **Fixed Timetable Delete**: Changed destroy() from JSON response to redirect
- **Added Sunday Option**: Added missing Sunday to day of week dropdown
- **Multiple Day Selection**: Changed form from single-day dropdown to multi-select checkboxes (can select 1-7 days at once)
- **Fixed Teacher Name Display**: Added NULL check in CONCAT to handle missing users, changed ORDER BY CASE to use lowercase day names

### Student Module - Additional Fixes (Nov 29, 2025)
- **Fixed Student Update Gender Error**: Convert empty optional fields (gender, date_of_birth, address) to NULL instead of empty string
- **Status Toggle Verified**: Route, method, and CSRF handling all properly configured

### Additional Bug Fixes (Nov 29, 2025 - Final)
- **Class Student Filtering**: Students index now filters by class_id parameter (?class_id=30)
- **Toggle Status AJAX**: Verified AuthMiddleware returns JSON for AJAX requests
- **Gender Field NULL**: Empty optional fields (gender, date_of_birth, address) convert to NULL

### Module CRUD Status:
✅ **Courses** - CREATE/READ/UPDATE/DELETE all working
✅ **Students** - CREATE/READ/UPDATE/DELETE all working, Status toggle working, Class filtering working
✅ **Timetable** - CREATE/READ/DELETE all working without errors (multiple day selection with checkboxes)
✅ **Classes** - CREATE/READ/UPDATE/DELETE all working without errors, View students filter working

## Previous Changes (November 18, 2025)

### Database Tables Created
- Created `library_members` table for library membership management
- Created `departments` table for department management
- Previously created 12 tables: books, book_issues, vehicles, routes, hostels, hostel_rooms, assets, stock_items, fee_templates, payroll, assignments, quizzes

### SQL Query Fixes
- Fixed 21+ SQL queries across 9 files that were referencing non-existent `u.name` or `u.role_name` columns
- Updated all queries to use `CONCAT(u.first_name, ' ', u.last_name)` for user names
- Fixed `u.role` references - users table doesn't have `role` column, uses `user_roles` junction table
- Fixed staff table queries - staff has `user_id` not `first_name/last_name`, requires JOIN with users table
- Files fixed: BookIssue, LibraryMember (getAll query), LibraryController (createMember), DepartmentController (create, edit, show), Hostel, Asset, Route, Payroll, HostelVisitor, HostelComplaint
- Fixed LibraryMember::getAll() to include user_role with proper JOIN to user_roles and roles tables

**Database Schema Verified:**
- `users` table: has `first_name`, `last_name` (no `role` column)
- `user_roles` junction table: links users to roles via `user_id` and `role_id`
- `roles` table: has `name`, `display_name`, `description`
- `staff` table: has `user_id` (no `first_name/last_name`), links to users via `user_id`
- `staff` table: has `department` VARCHAR column (NOT a foreign key to departments.id - this is a known limitation)
- `departments` table: standalone table with `id`, `name`, `code`, `head_id` (user.id reference)

### Controllers Implemented
- **RoleController**: Full CRUD implementation with database operations
  - index: Lists all roles with search functionality
  - create/store: Add new roles with validation
  - show: View role details and assigned users
  - edit/update: Modify existing roles
  - destroy: Delete roles (with protection if users assigned)
  
- **DepartmentController**: Full CRUD implementation with database operations
  - index: Lists all departments with search and status filters
  - create/store: Add new departments with department head assignment
  - show: View department details and assigned staff
  - edit/update: Modify existing departments
  - destroy: Delete departments (with protection if staff assigned)

### Views Created/Updated
- **Roles Module**: index.php, create.php, edit.php, show.php (all with improved UI/UX)
- **Departments Module**: index.php, create.php, edit.php, show.php (all with improved UI/UX)
- **Library Module**: create_member.php (library membership form with user selection)
- All views now display dynamic data from database
- Added helpful instructions, examples, and validation feedback
- Implemented proper error states and empty states

### Route Additions
- Added RESTful routes for library books: show, edit, update, delete
- Added routes for library member management: create, store
- Added full CRUD routes for roles: index, create, store, show, edit, update, destroy
- Added full CRUD routes for departments: index, create, store, show, edit, update, destroy
- All routes follow RESTful conventions with proper CSRF protection

### Known Limitations
- **Staff-Department Relationship**: The `staff.department` column is VARCHAR (text), not a foreign key to `departments.id`. This means:
  - Cannot reliably query staff by department ID
  - Department show page cannot display assigned staff members
  - To fix properly: would need to add `department_id` foreign key column to staff table
  - Current workaround: Department CRUD works, but staff assignment is not enforced

### Bug Fixes (November 19, 2025)

#### Session 1 - Database & Core Issues
- **Admissions - Duplicate email error**: Fixed conversion logic to check if user exists before creating new account, reuses existing user if email matches
- **Admissions - Waiting list approve/reject**: Added approve/reject buttons for waitlisted applicants (previously only pending had these options)
- **Students - Update error**: Fixed "Student not found" by explicitly selecting columns to avoid id column conflict in JOIN query
- **Students - Delete error**: Added check for foreign key constraints with helpful error message suggesting to mark inactive instead
- **Status toggle system-wide**: Implemented toggle status functionality for students, staff, and library members with:
  - Backend routes and controllers (toggleStatus methods)
  - Frontend toggle buttons in index pages
  - JavaScript function to handle AJAX toggle requests
- **Department staff assignment**: Changed staff create/edit forms to use department dropdown instead of text input, loads active departments from database
- **Staff edit ID conflict**: Fixed SELECT query to avoid id column overwriting by explicitly selecting columns
- Fixed `auth()->id()` calls in LibraryController - changed to `auth()['id']` since auth() returns array, not object
- Fixed book issue and return functionality in library module

#### Session 2 - CSRF, Loading & Edit Features
- **CSRF Token Validation**: Updated CsrfMiddleware to support AJAX requests by checking:
  - X-CSRF-TOKEN header
  - _token in JSON body
  - _token in POST data
  - Returns proper JSON error for AJAX requests (403) instead of redirecting
- **CSRF Meta Tag**: Added CSRF token meta tag to header for all authenticated pages
- **Global Loading Indicator**: Implemented loading spinner for all page navigations with:
  - Fixed overlay with spinner animation
  - Shows on link clicks (excludes # links, javascript:, _blank targets)
  - Hides on page load and back navigation
  - Checks for element existence before initializing
- **Delete Confirmation**: Updated confirmDelete function to include CSRF token in headers and body
- **Status Toggle**: Enhanced toggleStatus function with proper CSRF token handling and error messages
- **Admissions Edit**: Added edit functionality for pending/waitlisted applications with:
  - Edit and update controller methods (admin only)
  - Edit view with pre-filled values
  - Routes for GET /admissions/{id}/edit and PUT /admissions/{id}
  - Edit button in admission show page (only for admin role)
  - Authorization checks to ensure only admins can edit

### Current Status
- All 10 modules fully operational: Library, Transport, Hostel, Inventory, Fee Structure, Payroll, Assignments, Quizzes, Roles, Departments
- Database: 47 tables total
- Server running successfully with no errors
- All CRUD operations tested and working
- Library member creation: ✓ Working with proper role display
- Library book issue/return: ✓ Working with proper auth integration
- Departments management: ✓ Working (with staff assignment limitation noted above)