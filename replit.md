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

## Recent Changes (November 18, 2025)

### Database Tables Created
- Created `library_members` table for library membership management
- Created `departments` table for department management
- Previously created 12 tables: books, book_issues, vehicles, routes, hostels, hostel_rooms, assets, stock_items, fee_templates, payroll, assignments, quizzes

### SQL Query Fixes
- Fixed 21+ SQL queries across 9 files that were referencing non-existent `u.name` or `u.role_name` columns
- Updated all queries to use `CONCAT(u.first_name, ' ', u.last_name)` for user names
- Fixed `u.role` references - users table doesn't have `role` column, uses `user_roles` junction table
- Fixed staff table queries - staff has `user_id` not `first_name/last_name`, requires JOIN with users table
- Files fixed: BookIssue, LibraryMember, LibraryController (createMember), DepartmentController (create, edit, show), Hostel, Asset, Route, Payroll, HostelVisitor, HostelComplaint

**Database Schema Verified:**
- `users` table: has `first_name`, `last_name` (no `role` column)
- `user_roles` junction table: links users to roles via `user_id` and `role_id`
- `roles` table: has `name`, `display_name`, `description`
- `staff` table: has `user_id` (no `first_name/last_name`), links to users via `user_id`

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
- All views now display dynamic data from database
- Added helpful instructions, examples, and validation feedback
- Implemented proper error states and empty states

### Route Additions
- Added RESTful routes for library books: show, edit, update, delete
- Added routes for library member management: create, store
- Added full CRUD routes for roles: index, create, store, show, edit, update, destroy
- Added full CRUD routes for departments: index, create, store, show, edit, update, destroy
- All routes follow RESTful conventions with proper CSRF protection

### Current Status
- All 10 modules fully operational: Library, Transport, Hostel, Inventory, Fee Structure, Payroll, Assignments, Quizzes, Roles, Departments
- Database: 47 tables total (46 + departments)
- Server running successfully with no errors
- All CRUD operations tested and working