# Database Migrations

This directory contains SQL migration files for the School Management System database.

## Tables Overview

1. **roles** - User role definitions (admin, teacher, student, parent, accountant, hr)
2. **users** - Main authentication table
3. **user_roles** - User-to-role mapping (many-to-many)
4. **courses** - Course definitions (e.g., BSc Computer Science)
5. **classes** - Class/section information
6. **subjects** - Subject information with teacher mapping
7. **students** - Extended student profile data
8. **staff** - Extended staff profile data
9. **admissions** - Admission applications
10. **timetables** - Class schedules
11. **attendance** - Student attendance records
12. **exams** - Exam definitions
13. **marks** - Student marks/grades
14. **fees_structures** - Fee structure definitions
15. **invoices** - Fee invoices and payment tracking
16. **materials** - Learning materials (LMS)
17. **notifications** - Internal notification system
18. **otp_resets** - Password reset OTP tokens

## How to Run Migrations

### Option 1: Using MySQL Command Line

```bash
# Navigate to the database/migrations directory
cd database/migrations

# Run all migrations
mysql -u your_username -p your_database < run_migrations.sql
```

### Option 2: Run Individual Migrations

```bash
mysql -u your_username -p your_database < 001_create_roles_table.sql
mysql -u your_username -p your_database < 002_create_users_table.sql
# ... and so on
```

### Option 3: Using PHPMyAdmin or MySQL Workbench

1. Open your database management tool
2. Select your database
3. Copy and paste each migration file content and execute

## Important Notes

- **Order matters**: Run migrations in numerical order (001, 002, 003...) due to foreign key dependencies
- **Rollback**: To drop all tables, run in reverse order or use `DROP DATABASE` and recreate
- **Character Set**: All tables use `utf8mb4` for proper Unicode support
- **Engine**: All tables use InnoDB for transaction support and foreign keys
- **Indexes**: Critical fields are indexed for performance
- **Foreign Keys**: Cascading deletes and updates are configured appropriately

## Default Data

The roles table includes 6 default roles:
- Admin
- Teacher  
- Student
- Parent
- Accountant
- HR Manager

## Database Configuration

Update your `.env` file with your MySQL credentials:

```
DB_HOST=your_host
DB_PORT=3306
DB_NAME=scims_db
DB_USER=your_username
DB_PASSWORD=your_password
```
