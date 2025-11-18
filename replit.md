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
- Previously created 12 tables: books, book_issues, vehicles, routes, hostels, hostel_rooms, assets, stock_items, fee_templates, payroll, assignments, quizzes

### SQL Query Fixes
- Fixed 21 SQL queries across 8 model files that were referencing non-existent `u.name` column
- Updated all queries to use `CONCAT(u.first_name, ' ', u.last_name)` for user names
- Models fixed: BookIssue, LibraryMember, Hostel, Asset, Route, Payroll, HostelVisitor, HostelComplaint

### Route Additions
- Added RESTful routes for library books: show, edit, update, delete
- Added routes for library member management: create, store
- Routes now support full CRUD operations for library module

### Current Status
- All 8 extended modules fully operational: Library, Transport, Hostel, Inventory, Fee Structure, Payroll, Assignments, Quizzes
- Database: 46 tables total (45 + library_members)
- Server running successfully with no errors