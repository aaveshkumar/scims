<div class="sidebar text-white" style="width: 260px; min-height: 100vh; position: fixed; top: 0; left: 0; overflow-y: auto; z-index: 1000;">
    <div class="p-4 border-bottom" style="border-color: rgba(255,255,255,0.1) !important;">
        <h4 class="mb-0"><i class="bi bi-mortarboard-fill"></i> SCIMS</h4>
        <small class="text-white-50">School Management System</small>
    </div>
    
    <nav class="nav flex-column px-2 py-3">
        <a class="nav-link text-white fw-bold" href="/dashboard">
            <i class="bi bi-speedometer2 me-2"></i> Dashboard
        </a>

        <?php if (hasRole('admin')): ?>
        <hr class="my-2" style="border-color: rgba(255,255,255,0.2);">
        
        <div class="text-white-50 text-uppercase small px-3 mt-3 mb-2 fw-bold">📋 Admissions</div>
        <a class="nav-link text-white" href="/admissions">
            <i class="bi bi-file-earmark-text me-2"></i> All Applications
        </a>
        <a class="nav-link text-white" href="/admissions/create">
            <i class="bi bi-plus-circle me-2"></i> New Application
        </a>
        
        <div class="text-white-50 text-uppercase small px-3 mt-3 mb-2 fw-bold">🎓 Academic Management</div>
        <a class="nav-link text-white" href="/courses">
            <i class="bi bi-book me-2"></i> Courses
        </a>
        <a class="nav-link text-white" href="/classes">
            <i class="bi bi-building me-2"></i> Classes
        </a>
        <a class="nav-link text-white" href="/subjects">
            <i class="bi bi-journal-bookmark me-2"></i> Subjects
        </a>
        
        <div class="text-white-50 text-uppercase small px-3 mt-3 mb-2 fw-bold">👥 User Management</div>
        <a class="nav-link text-white" href="/students">
            <i class="bi bi-people me-2"></i> Students
        </a>
        <a class="nav-link text-white" href="/staff">
            <i class="bi bi-person-badge me-2"></i> Staff Members
        </a>
        <?php endif; ?>
        
        <?php if (hasRole('admin') || hasRole('teacher')): ?>
        <div class="text-white-50 text-uppercase small px-3 mt-3 mb-2 fw-bold">📊 Operations</div>
        <a class="nav-link text-white" href="/attendance">
            <i class="bi bi-calendar-check me-2"></i> Attendance
        </a>
        <a class="nav-link text-white" href="/attendance/mark">
            <i class="bi bi-check-square me-2"></i> Mark Attendance
        </a>
        <a class="nav-link text-white" href="/attendance/report">
            <i class="bi bi-graph-up me-2"></i> Attendance Report
        </a>
        <a class="nav-link text-white" href="/exams">
            <i class="bi bi-clipboard-check me-2"></i> Exams
        </a>
        <a class="nav-link text-white" href="/marks">
            <i class="bi bi-award me-2"></i> Enter Marks
        </a>
        <a class="nav-link text-white" href="/timetable">
            <i class="bi bi-calendar3 me-2"></i> Timetable
        </a>
        <?php endif; ?>
        
        <?php if (hasRole('admin')): ?>
        <div class="text-white-50 text-uppercase small px-3 mt-3 mb-2 fw-bold">💰 Finance</div>
        <a class="nav-link text-white" href="/invoices">
            <i class="bi bi-receipt me-2"></i> All Invoices
        </a>
        <a class="nav-link text-white" href="/invoices/create">
            <i class="bi bi-plus-circle me-2"></i> Create Invoice
        </a>
        <a class="nav-link text-white" href="/invoices/defaulters">
            <i class="bi bi-exclamation-triangle me-2"></i> Defaulters
        </a>
        <?php endif; ?>
        
        <div class="text-white-50 text-uppercase small px-3 mt-3 mb-2 fw-bold">📚 Resources</div>
        <a class="nav-link text-white" href="/materials">
            <i class="bi bi-file-earmark-pdf me-2"></i> Study Materials
        </a>
        <?php if (hasRole('admin') || hasRole('teacher')): ?>
        <a class="nav-link text-white" href="/materials/create">
            <i class="bi bi-cloud-upload me-2"></i> Upload Material
        </a>
        <?php endif; ?>
        
        <a class="nav-link text-white" href="/notifications">
            <i class="bi bi-bell me-2"></i> Notifications
            <?php 
            $unreadCount = 0; // TODO: Get actual unread count
            if ($unreadCount > 0): ?>
                <span class="badge bg-danger ms-2"><?= $unreadCount ?></span>
            <?php endif; ?>
        </a>

        <hr class="my-3" style="border-color: rgba(255,255,255,0.2);">
        
        <a class="nav-link text-white" href="/logout">
            <i class="bi bi-box-arrow-right me-2"></i> Logout
        </a>
    </nav>
</div>
