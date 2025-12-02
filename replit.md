# SCIMS - School/College Institution Management System

## Project Overview
Comprehensive school management system built with Core PHP 8+ custom MVC architecture featuring role-based access control, student portal, and multi-role authentication.

## Current Status: Development Phase

### Completed Features (14/25)
✅ **Core System:**
- Role-based authentication (Student, Teacher, Parent, HR, Admin)
- Multi-role login with role selection dropdown
- Admin-only dashboard with statistics

✅ **Student Portal (10/25 Features):**
1. Combined Student Dashboard with quick links
2. My Marks & Grades
3. Attendance History
4. My Timetable
5. Assignments
6. Study Materials
7. Quizzes/Tests
8. Library - Browse Books
9. My Borrowed Books
10. Announcements

### Remaining Features (14/25)
❌ Exam Schedule, Report Card, Question Bank, Syllabus
❌ Hostel Information, Hostel Complaints
❌ Notifications, Messages, Discussion Forums
❌ Fee Information, Support/Help, My Profile, Change Password

## Authentication & Security

### Login System
- **Multi-role login:** Student, Teacher, Parent, HR
- **Admin login blocked** from regular login form
- **Database validation:** Users must be registered in their role-specific tables
  - Students: Must exist in `students` table with status='active'
  - Teachers/HR: Must exist in `staff` table with status='active'
  - Parents: Must be registered as guardians or have parent role

### Access Control
- **Only Admins Can Add:**
  - ✅ Students (protected in StudentController)
  - ✅ Teachers/Staff (protected in StaffController)
  - ✅ Parents (added via staff/guardian system)
- **Only Admins Can Manage:**
  - ✅ Promote entire classes (bulk update)
  - ✅ View class-based student lists
- Route-level protection: `middleware: 'role:admin'`
- Controller-level checks: `hasRole('admin')` in create/store methods

## Database Structure

### Key Tables
- `users` - All system users
- `user_roles` - Role assignments
- `students` - Student records (user_id FK)
- `staff` - Teacher/HR/Staff records (user_id FK)
- `roles` - System roles (admin, teacher, student, parent, hr)

### Role-Based Registration
- **Student:** Created in `students` table when admin adds student
- **Teacher:** Created in `staff` table when admin adds staff
- **HR:** Created in `staff` table when admin adds staff with HR role
- **Parent:** Registered via guardian fields in `students` table
- **Admin:** System role, cannot login through regular form

## Sidebar Structure (Student Portal)

### Menu Categories (Organized)
1. **Dashboard** (Direct link to main dashboard)
2. **Academic** (Marks, Attendance, Exam Schedule, Report Card, Question Bank)
3. **Learning** (Timetable, Assignments, Materials, Quizzes, Syllabus)
4. **Library** (Browse Books, Borrowed Books)
5. **Hostel** (Information, Complaints)
6. **Communication** (Announcements, Notifications, Messages, Forums)
7. **Settings** (Fees, Support, Profile, Change Password) - *Last Menu*

## User Preferences
- MVC architecture with clean separation of concerns
- Bootstrap 5 responsive UI with Bootstrap Icons
- Role-based middleware for route protection
- Form validation & error handling
- Transaction support for critical operations

## Recent Changes (Dec 2, 2025)
- ✅ Added "Login As" role dropdown to login form
- ✅ Implemented role-specific database registration validation
- ✅ Added admin-only authorization for student/staff creation
- ✅ Organized student portal with 6 category menus
- ✅ Moved Settings menu to the bottom (last option)
- ✅ Removed duplicate student dashboard link
- ✅ Added 10 working student portal features
- ✅ **NEW: Class-Based Student Management**
  - Display all active classes with student counts in grid view
  - Click any class to view its students in a table
  - View student details, credentials, and manage per-class enrollment
- ✅ **NEW: Bulk Class Promotion Feature**
  - Promote entire classes to next year (e.g., Class 4 → Class 5)
  - One-click bulk update for all students in a class
  - Admin-only with confirmation dialog
  - Perfect for end-of-year class advancement

## Admin Management Features ✅
- ✅ **Students Page:**
  - Grid view: All classes with student counts
  - Click class → View all students in that class
  - Add/Edit/Delete students per class
  - View credentials, resend passwords
  - Promote entire class to next year (bulk)
- ✅ **Promotion System:**
  - Select class → Choose target class → Confirm
  - All students moved in one action
  - Ideal for year-end advancement

## TODO for Next Sessions
1. Build remaining 14 student portal features
2. Implement teacher/parent dashboards & features
3. Create HR management dashboard
4. Add parent communication portal
5. Implement notifications system
6. Add parent-teacher communication module

## Routes Protected By Role
- `/students/*` - admin only
- `/staff/*` - admin only
- `/student-portal/*` - student only
- `/teacher/*` - teacher only (when implemented)
- `/admin/*` - admin only
- `/dashboard` - authenticated users (role-specific display)

## Testing Notes
- Test multi-role login: Use different roles when logging in
- Verify non-admins cannot access `/students/create` or `/staff/create`
- Check that unregistered users cannot login
- Confirm role-based dashboard display works correctly
