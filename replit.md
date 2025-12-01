# School/College/Institution Management System (SCIMS)

## Overview
SCIMS is a comprehensive ERP system for educational institutions. Built with Core PHP 8+ using a custom MVC architecture, it aims to streamline operations across administration, academics, finance, and communication. The system supports managing students, staff, and parents, with features for admissions, attendance, exams, fees, and an integrated Learning Management System (LMS). This project delivers a robust, production-level platform designed for efficient institutional management.

## User Preferences
- Strict MVC architecture
- No frameworks or external libraries
- Use only Core PHP features
- PDO for all database operations
- Bootstrap for UI
- Step-by-step development with confirmation at each stage

## System Architecture
The system employs a custom MVC architecture for clear separation of concerns, ensuring maintainability and scalability.

**UI/UX Decisions:**
- **Frontend**: Bootstrap 5 for consistent, responsive design with a dark/light mode toggle.
- **File Structure**: Standardized organization (`/app`, `/config`, `/database`, `/public`, `/routes`).

**Technical Implementations:**
- **Backend**: Core PHP 8.4 (Object-Oriented Programming).
- **Database**: PostgreSQL (Neon) with PDO for secure interactions using prepared statements.
- **Authentication**: Session-based with Role-Based Access Control (RBAC).
- **Security**: PDO prepared statements, CSRF protection, and robust password hashing.
- **Custom Router**: Handles dynamic routing and middleware integration.
- **Session Management**: Native PHP sessions.

**Feature Specifications:**
- **Core Modules**: Authentication & Security, User Management (Students, Staff, Parents), Admissions, Academics (Courses, Classes, Subjects, Timetable), Attendance, Exams & Marks, Assignments, Quizzes, Fees & Finance, LMS (Study materials, Question bank, Lesson plans, Syllabus), Notifications, Announcements, Messaging, and Support/Contact Admin.
- **Operational Modules**: Transport (Vehicles, Drivers, Routes), HR (Events, Recruitment, Payroll), Hostel (Rooms, Residents, Visitors, Complaints), Inventory (Assets, Stock, Purchase Orders, Suppliers).
- **Reporting**: Comprehensive reporting for Attendance, Academics, and Finance, including CRUD operations for attendance records.

**System Design Choices:**
- **Database Schema**: Designed with proper relationships, foreign keys, indexing, and cascading operations for data integrity.

## External Dependencies
- **Database**: PostgreSQL (Neon) accessed via PHP's PDO extension.
- **Frontend Framework**: Bootstrap 5 for UI components and responsiveness.
- **Icons**: Bootstrap Icons 1.11.0.