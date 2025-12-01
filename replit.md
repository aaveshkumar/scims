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
   - Positioned exactly at top-right corner of bell icon, touching it
   - Updates in real-time when notifications are marked as read
   - Auto-refreshes every 30 seconds
   - Shows only when there are unread notifications
   
3. **Clickable Notifications** - Notifications link to relevant pages
   - Click notification → auto-marks as read → navigates to relevant page
   - CSRF token properly integrated in fetch requests
   - Link field in database allows dynamic routing

4. **Database Query Fixes** - Fixed PostgreSQL boolean type handling
   - Changed `is_read = 0` to `is_read = false` (proper boolean comparison)
   - Changed `is_read = 1` to `is_read = true` (proper boolean assignment)
   - Applied fixes across: `markAsRead()`, `markAllAsRead()`, `getUnreadCount()` methods

### Announcements Module Implementation
1. **Model Created** - `app/models/Announcement.php`
   - `getAllActive()` - Get all visible announcements
   - `getByUser()` - Get announcements by publisher
   - `incrementViews()` - Track announcement views

2. **Controller Created** - `app/controllers/AnnouncementController.php`
   - Full CRUD operations: Create, Read, Update, Delete
   - Validation for required fields
   - Error handling with user-friendly messages

3. **Routes Added** - `routes/web.php`
   - `GET /announcements` - List all announcements
   - `GET /announcements/create` - Create form
   - `POST /announcements` - Store new announcement
   - `GET /announcements/{id}` - View announcement
   - `GET /announcements/{id}/edit` - Edit form
   - `PUT /announcements/{id}` - Update announcement
   - `DELETE /announcements/{id}` - Delete announcement

4. **Views Created**
   - `index.php` - List announcements with priority badges, visibility status, view count
   - `create.php` - Form to create new announcement (title, content, audience, priority, dates)
   - `show.php` - View single announcement with details panel
   - `edit.php` - Edit existing announcement

5. **Dummy Data Added** - 10 meaningful announcements
   - Academic Calendar Released (High Priority)
   - School Closed for Maintenance
   - Mid-Term Exam Results
   - Sports Day Registration
   - Fee Payment Due (URGENT)
   - Library Opening Ceremony
   - Staff Development Workshop
   - Admissions for 2026-27
   - COVID Safety Guidelines
   - Parent-Teacher Meeting

### Files Modified
- `app/views/notifications/index.php` - Added dark mode class, improved styling
- `app/views/layouts/header.php` - Added dark mode CSS for notifications
- `app/views/layouts/navbar.php` - Fixed notification badge positioning to touch bell icon
- `app/views/layouts/footer.php` - Added JavaScript to fetch and update notification count
- `app/models/Notification.php` - Fixed boolean comparisons, added `getUnreadNotifications()` method
- `app/controllers/NotificationController.php` - Fixed database access, CSRF integration
- `routes/web.php` - Added announcements CRUD routes

### Messages Module Implementation
1. **Model Created** - `app/models/Message.php`
   - `getSentMessages()` - Get all messages sent by user
   - `getReceivedMessages()` - Get all received messages
   - `getUnreadMessages()` - Get unread messages
   - `getUnreadCount()` - Count unread messages
   - `markAsRead()` - Mark message as read
   - `getUserInfo()`, `getAllUsers()` - Public helper methods for fetching user data

2. **Controller Created** - `app/controllers/MessageController.php`
   - Full CRUD operations with proper authorization
   - Both senders can edit their messages, receivers can reply
   - Auto-mark as read when viewing

3. **Routes Added** - `/messages` endpoints
   - Inbox with sent/received messages
   - Compose and reply functionality
   - View and edit with proper authorization

4. **Dummy Data** - 10 meaningful messages between valid users

### Support Messages/Contact Admin Module Implementation
1. **Database Table** - `support_messages`
   - user_id, subject, message, status, admin_reply, admin_replied_by, replied_at
   - Proper foreign keys and cascading operations

2. **Model Created** - `app/models/SupportMessage.php`
   - `getForUser()` - Get messages by user with direct SQL queries
   - `getForAdmin()` - Get all tickets for admin dashboard
   - `addReply()` - Add admin response to ticket
   - `getUserInfo()`, `getAdminInfo()` - Get user/admin details

3. **Controller Created** - `app/controllers/SupportMessageController.php`
   - Full CRUD with role-based access
   - Users (students/teachers/drivers/parents) can send support messages
   - Admin can view all tickets and reply
   - Manual validation with user-friendly error messages

4. **Views Created** - 5 views for complete workflow
   - `index.php` - User inbox showing support messages
   - `create.php` - Compose new message form
   - `show.php` - View message details and admin reply
   - `admin-index.php` - Admin dashboard with status summary and ticket list
   - `reply.php` - Admin reply form with original message context

5. **Routes Added** - `/support` endpoints
   - User routes: view inbox, send message, view details
   - Admin routes: view all tickets, reply, manage tickets

6. **Navbar Integration**
   - Chat bubble icon (💬) for students/teachers/drivers/parents
   - Headset icon (🎧) for admin support tickets
   - Icons in top navbar between Reports and Notifications

7. **Dummy Data** - 10 meaningful support tickets
   - Various statuses (open/replied/resolved)
   - Real user IDs (34, 35, 36, 37, 38, 39, 40, 42, 44, 45)
   - Admin replies for some tickets

8. **Features Implemented**
   - ✅ Role-based access control (admin/user differentiation)
   - ✅ Status tracking (open → replied → resolved)
   - ✅ Auto-redirect logic (single /support endpoint handles both user and admin)
   - ✅ Input validation with error messages
   - ✅ Direct SQL queries (stable and efficient)
   - ✅ Proper error handling and logging
   - ✅ Safe data handling with null checks and type validation

### Dummy Data Status
- **Notifications**: 11 meaningful notifications - 9 unread, 2 read
- **Announcements**: 10 announcements with varied priorities and audiences
- **Messages**: 10 messages between users
- **Support Messages**: 10 tickets (5 open/replied, 5 resolved)
- All CRUD operations fully functional for all modules

## External Dependencies
- **Database**: PostgreSQL (Neon) accessed via PHP's PDO extension.
- **Frontend Framework**: Bootstrap 5 for UI components and responsiveness.
- **Icons**: Bootstrap Icons 1.11.0.