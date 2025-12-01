# School/College/Institution Management System (SCIMS)

## Overview
SCIMS is a comprehensive ERP system for educational institutions, built with Core PHP 8+ using a custom MVC architecture. It aims to streamline operations through modules for administration, academics, finance, and communication. The system provides capabilities for managing students, staff, and parents, with features for admissions, attendance, exams, fees, and an integrated Learning Management System (LMS). The project offers a robust, production-level platform designed for efficient institutional management.

## User Preferences
- Strict MVC architecture
- No frameworks or external libraries
- Use only Core PHP features
- PDO for all database operations
- Bootstrap for UI
- Step-by-step development with confirmation at each stage

## System Architecture
The system employs a custom MVC architecture for clear separation of concerns, ensuring maintainability and scalability.

**Technical Implementations:**
- **Backend**: Core PHP 8.4 (Object-Oriented Programming).
- **Frontend**: Bootstrap 5 and Vanilla JavaScript for a responsive user interface.
- **Database**: PostgreSQL (Neon), with all interactions managed via PDO using prepared statements for security.
- **Authentication**: Session-based system with Role-Based Access Control (RBAC) to manage user permissions.
- **Security**: Includes PDO prepared statements, CSRF protection, and robust password hashing.
- **Custom Router**: Handles dynamic routing and integrates middleware for request processing.
- **Session Management**: Utilizes native PHP sessions.

**Feature Specifications:**
- **Core Modules**: Authentication & Security, User Management (Students, Staff, Parents), Admissions, Academics (Courses, Classes, Subjects, Timetable), Attendance, Exams & Marks, Assignments, Quizzes, Fees & Finance, LMS (Study materials, Question bank, Lesson plans, Syllabus), Notifications.
- **Operational Modules**: Transport (Vehicles, Drivers, Routes), HR (Events, Recruitment, Payroll), Hostel (Rooms, Residents, Visitors, Complaints), Inventory (Assets, Stock, Purchase Orders, Suppliers).

**System Design Choices:**
- **UI/UX**: Bootstrap 5 ensures a consistent and responsive design across all views, featuring a dark/light mode toggle with `localStorage` persistence.
- **File Structure**: Adheres to industry standards with a logical organization (`/app`, `/config`, `/database`, `/public`, `/routes`).
- **Database Schema**: Designed with proper relationships, foreign keys, indexing, and cascading operations for data integrity.

## Recent Fixes & Updates (December 1, 2025)

### Notifications Module Enhancements
1. **Dark Mode Styling** - Fixed notification background colors in dark mode
   - Unread notifications now show darker background (#3a3f47) in dark mode instead of white
   - List items properly themed for dark mode with correct text colors
   
2. **Notification Counter Badge** - Implemented dynamic unread notification count
   - Badge displays unread notification count in navbar
   - Updates in real-time when notifications are marked as read
   - Auto-refreshes every 30 seconds
   - Shows only when there are unread notifications
   
3. **Database Query Fixes** - Fixed PostgreSQL boolean type handling
   - Changed `is_read = 0` to `is_read = false` (proper boolean comparison)
   - Changed `is_read = 1` to `is_read = true` (proper boolean assignment)
   - Applied fixes across: `markAsRead()`, `markAllAsRead()`, `getUnreadCount()` methods

### Files Modified
- `app/views/notifications/index.php` - Added dark mode class, improved styling
- `app/views/layouts/header.php` - Added dark mode CSS for notifications
- `app/views/layouts/navbar.php` - Added ID to notification badge for dynamic updates
- `app/views/layouts/footer.php` - Added JavaScript to fetch and update notification count
- `app/models/Notification.php` - Fixed boolean comparisons in SQL queries

### Dummy Data Status
- **11 meaningful notifications** added for admin user (ID: 53)
- **9 unread**, **2 read** notifications available
- All CRUD operations fully functional

## External Dependencies
- **Database**: PostgreSQL (Neon) accessed via PHP's PDO extension.
- **Frontend Framework**: Bootstrap 5 for UI components and responsiveness.
- **Icons**: Bootstrap Icons 1.11.0.