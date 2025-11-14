<div class="sidebar text-white" style="width: 260px; min-height: 100vh; position: fixed; top: 0; left: 0; overflow-y: auto; z-index: 1000;">
    <div class="p-4 border-bottom" style="border-color: rgba(255,255,255,0.1) !important;">
        <h4 class="mb-0"><i class="bi bi-mortarboard-fill"></i> SCIMS</h4>
        <small class="text-white-50">School Management System</small>
    </div>
    
    <nav class="nav flex-column px-2 py-3">
        <a class="nav-link text-white fw-bold" href="/dashboard">
            <i class="bi bi-speedometer2 me-2"></i> Dashboard
        </a>
        
        <a class="nav-link text-white fw-bold" href="/features">
            <i class="bi bi-grid-3x3-gap me-2"></i> All Features
        </a>

        <?php if (hasRole('admin')): ?>
        <hr class="my-2" style="border-color: rgba(255,255,255,0.2);">
        
        <div class="text-white-50 text-uppercase small px-3 mt-3 mb-2 fw-bold">📋 Admissions</div>
        <a class="nav-link text-white" href="/admissions">
            <i class="bi bi-file-earmark-text me-2"></i> Applications
        </a>
        <a class="nav-link text-white" href="/admissions/create">
            <i class="bi bi-plus-circle me-2"></i> New Application
        </a>
        <a class="nav-link text-white" href="/admissions/waitlist">
            <i class="bi bi-hourglass-split me-2"></i> Waitlist
        </a>
        
        <div class="text-white-50 text-uppercase small px-3 mt-3 mb-2 fw-bold">🎓 Academic</div>
        <a class="nav-link text-white" href="/courses">
            <i class="bi bi-book me-2"></i> Courses
        </a>
        <a class="nav-link text-white" href="/classes">
            <i class="bi bi-building me-2"></i> Classes
        </a>
        <a class="nav-link text-white" href="/subjects">
            <i class="bi bi-journal-bookmark me-2"></i> Subjects
        </a>
        <a class="nav-link text-white" href="/syllabus">
            <i class="bi bi-file-text me-2"></i> Syllabus & Lessons
        </a>
        <a class="nav-link text-white" href="/question-bank">
            <i class="bi bi-question-square me-2"></i> Question Bank
        </a>
        
        <div class="text-white-50 text-uppercase small px-3 mt-3 mb-2 fw-bold">👥 Users</div>
        <a class="nav-link text-white" href="/students">
            <i class="bi bi-people me-2"></i> Students
        </a>
        <a class="nav-link text-white" href="/staff">
            <i class="bi bi-person-badge me-2"></i> Staff
        </a>
        <a class="nav-link text-white" href="/users">
            <i class="bi bi-person-gear me-2"></i> User Accounts
        </a>
        <a class="nav-link text-white" href="/roles">
            <i class="bi bi-shield-check me-2"></i> Roles & Permissions
        </a>
        <a class="nav-link text-white" href="/departments">
            <i class="bi bi-diagram-3 me-2"></i> Departments
        </a>
        <?php endif; ?>
        
        <?php if (hasRole('admin') || hasRole('teacher')): ?>
        <div class="text-white-50 text-uppercase small px-3 mt-3 mb-2 fw-bold">📊 Operations</div>
        <a class="nav-link text-white" href="/timetable">
            <i class="bi bi-calendar3 me-2"></i> Timetable
        </a>
        <a class="nav-link text-white" href="/attendance">
            <i class="bi bi-calendar-check me-2"></i> Attendance
        </a>
        <a class="nav-link text-white" href="/leaves">
            <i class="bi bi-calendar-x me-2"></i> Leave Management
        </a>
        <a class="nav-link text-white" href="/exams">
            <i class="bi bi-clipboard-check me-2"></i> Exams
        </a>
        <a class="nav-link text-white" href="/marks">
            <i class="bi bi-award me-2"></i> Marks Entry
        </a>
        <a class="nav-link text-white" href="/report-cards">
            <i class="bi bi-file-earmark-pdf me-2"></i> Report Cards
        </a>
        <?php endif; ?>
        
        <?php if (hasRole('admin')): ?>
        <div class="text-white-50 text-uppercase small px-3 mt-3 mb-2 fw-bold">💰 Finance</div>
        <a class="nav-link text-white" href="/fees">
            <i class="bi bi-cash-stack me-2"></i> Fee Structure
        </a>
        <a class="nav-link text-white" href="/invoices">
            <i class="bi bi-receipt me-2"></i> Invoices
        </a>
        <a class="nav-link text-white" href="/payments">
            <i class="bi bi-credit-card me-2"></i> Payment Gateway
        </a>
        <a class="nav-link text-white" href="/collections">
            <i class="bi bi-cash-coin me-2"></i> Collections
        </a>
        <a class="nav-link text-white" href="/payroll">
            <i class="bi bi-wallet2 me-2"></i> Payroll
        </a>
        <a class="nav-link text-white" href="/expenses">
            <i class="bi bi-clipboard-minus me-2"></i> Expenses
        </a>
        
        <div class="text-white-50 text-uppercase small px-3 mt-3 mb-2 fw-bold">📚 LMS</div>
        <a class="nav-link text-white" href="/materials">
            <i class="bi bi-file-earmark-pdf me-2"></i> Study Materials
        </a>
        <a class="nav-link text-white" href="/assignments">
            <i class="bi bi-journal-text me-2"></i> Assignments
        </a>
        <a class="nav-link text-white" href="/quizzes">
            <i class="bi bi-question-circle me-2"></i> Quizzes
        </a>
        <a class="nav-link text-white" href="/online-classes">
            <i class="bi bi-camera-video me-2"></i> Online Classes
        </a>
        
        <div class="text-white-50 text-uppercase small px-3 mt-3 mb-2 fw-bold">🏢 Facilities</div>
        <a class="nav-link text-white" href="/library">
            <i class="bi bi-book-half me-2"></i> Library
        </a>
        <a class="nav-link text-white" href="/transport">
            <i class="bi bi-bus-front me-2"></i> Transport
        </a>
        <a class="nav-link text-white" href="/hostel">
            <i class="bi bi-house me-2"></i> Hostel
        </a>
        <a class="nav-link text-white" href="/inventory">
            <i class="bi bi-box-seam me-2"></i> Inventory
        </a>
        
        <div class="text-white-50 text-uppercase small px-3 mt-3 mb-2 fw-bold">📢 Communication</div>
        <a class="nav-link text-white" href="/notifications">
            <i class="bi bi-bell me-2"></i> Notifications
        </a>
        <a class="nav-link text-white" href="/messages">
            <i class="bi bi-chat-dots me-2"></i> Messages
        </a>
        <a class="nav-link text-white" href="/announcements">
            <i class="bi bi-megaphone me-2"></i> Announcements
        </a>
        <a class="nav-link text-white" href="/sms">
            <i class="bi bi-phone me-2"></i> SMS
        </a>
        <a class="nav-link text-white" href="/email">
            <i class="bi bi-envelope me-2"></i> Email
        </a>
        <a class="nav-link text-white" href="/whatsapp">
            <i class="bi bi-whatsapp me-2"></i> WhatsApp
        </a>
        
        <div class="text-white-50 text-uppercase small px-3 mt-3 mb-2 fw-bold">📊 Reports</div>
        <a class="nav-link text-white" href="/reports/attendance">
            <i class="bi bi-graph-up me-2"></i> Attendance Reports
        </a>
        <a class="nav-link text-white" href="/reports/finance">
            <i class="bi bi-bar-chart me-2"></i> Finance Reports
        </a>
        <a class="nav-link text-white" href="/reports/academic">
            <i class="bi bi-mortarboard me-2"></i> Academic Reports
        </a>
        
        <div class="text-white-50 text-uppercase small px-3 mt-3 mb-2 fw-bold">⚙️ Settings</div>
        <a class="nav-link text-white" href="/settings">
            <i class="bi bi-gear me-2"></i> System Config
        </a>
        <a class="nav-link text-white" href="/branches">
            <i class="bi bi-diagram-3 me-2"></i> Multi-Branch
        </a>
        <a class="nav-link text-white" href="/integrations">
            <i class="bi bi-plug me-2"></i> Integrations
        </a>
        <a class="nav-link text-white" href="/backup">
            <i class="bi bi-cloud-download me-2"></i> Backup & Restore
        </a>
        <a class="nav-link text-white" href="/logs">
            <i class="bi bi-clock-history me-2"></i> Audit Logs
        </a>
        <?php else: ?>
        <div class="text-white-50 text-uppercase small px-3 mt-3 mb-2 fw-bold">📚 Learning</div>
        <a class="nav-link text-white" href="/materials">
            <i class="bi bi-file-earmark-pdf me-2"></i> Study Materials
        </a>
        <a class="nav-link text-white" href="/assignments">
            <i class="bi bi-journal-text me-2"></i> My Assignments
        </a>
        <a class="nav-link text-white" href="/timetable">
            <i class="bi bi-calendar3 me-2"></i> My Timetable
        </a>
        <a class="nav-link text-white" href="/notifications">
            <i class="bi bi-bell me-2"></i> Notifications
        </a>
        <?php endif; ?>

        <hr class="my-3" style="border-color: rgba(255,255,255,0.2);">
        
        <a class="nav-link text-white" href="/logout">
            <i class="bi bi-box-arrow-right me-2"></i> Logout
        </a>
    </nav>
</div>
