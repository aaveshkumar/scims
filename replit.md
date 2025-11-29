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
- **Database**: MySQL, accessed via PDO with prepared statements for security.
- **Authentication**: Session-based with Role-Based Access Control (RBAC).
- **Security**: PDO prepared statements, CSRF protection, and robust password hashing.
- **Custom Router**: Handles dynamic routes and middleware.
- **Session Management**: Native PHP sessions.

**Feature Specifications:**
- **Authentication & Security**: Login, logout, password reset, RBAC.
- **User Management**: CRUD for Students, Staff, and Parents.
- **Admissions**: Public application form, document upload, approval workflow.
- **Academics**: Manages Courses, Classes, Subjects, teacher-subject mappings.
- **Timetable**: Creation and management of class/teacher schedules.
- **Attendance**: Daily and period-wise tracking.
- **Exams & Marks**: Exam creation, marks entry, report card generation.
- **Fees & Finance**: Fee structures, invoicing, payment tracking.
- **LMS**: Study material management.
- **Notifications**: Internal communication system.

**System Design Choices:**
- **UI/UX**: Bootstrap 5 for consistent design across 82 views, including responsive layouts. Dark/light mode toggle with `localStorage` persistence.
- **File Structure**: Industry-standard organization (`/app`, `/config`, `/database`, `/public`, `/routes`).
- **Database Schema**: Proper relationships, foreign keys, indexing, and cascading operations.

## Recent Updates (Session: Nov 29, 2025)
- **Syllabus Module**: Complete CRUD with show/edit views, database integration
- **Lesson Plans Module**: Comprehensive form with detailed placeholders, database model, CRUD operations
- **LessonPlan Model Fix**: Uses fetchAll()/fetchOne() for proper array returns instead of PDOStatement
- **Theme Toggle**: Fully functional dark/light mode in navbar with localStorage persistence
- **Database**: Migrated from MySQL to PostgreSQL (Neon), all models updated for proper data handling

## External Dependencies
- **Database**: PostgreSQL (Neon) via PDO
- **Frontend Framework**: Bootstrap 5
- **Icons**: Bootstrap Icons 1.11.0
- **Features**: Dark/Light mode toggle, CSRF protection, session-based RBAC