<div class="sidebar text-white" style="width: 250px;">
    <div class="p-4">
        <h4 class="mb-0"><i class="bi bi-mortarboard-fill"></i> SCIMS</h4>
        <small class="text-white-50">School Management</small>
    </div>
    
    <nav class="nav flex-column px-3">
        <a class="nav-link" href="/dashboard">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <?php if (hasRole('admin')): ?>
        <hr class="my-2" style="border-color: rgba(255,255,255,0.2);">
        
        <div class="text-white-50 text-uppercase small px-3 mt-3 mb-2">Admissions</div>
        <a class="nav-link" href="/admissions">
            <i class="bi bi-file-earmark-text"></i> Applications
        </a>
        
        <div class="text-white-50 text-uppercase small px-3 mt-3 mb-2">Academic</div>
        <a class="nav-link" href="/courses">
            <i class="bi bi-book"></i> Courses
        </a>
        <a class="nav-link" href="/classes">
            <i class="bi bi-building"></i> Classes
        </a>
        <a class="nav-link" href="/subjects">
            <i class="bi bi-journal-bookmark"></i> Subjects
        </a>
        
        <div class="text-white-50 text-uppercase small px-3 mt-3 mb-2">Users</div>
        <a class="nav-link" href="/students">
            <i class="bi bi-people"></i> Students
        </a>
        <a class="nav-link" href="/staff">
            <i class="bi bi-person-badge"></i> Staff
        </a>
        <?php endif; ?>
        
        <?php if (hasRole('admin') || hasRole('teacher')): ?>
        <div class="text-white-50 text-uppercase small px-3 mt-3 mb-2">Operations</div>
        <a class="nav-link" href="/attendance">
            <i class="bi bi-calendar-check"></i> Attendance
        </a>
        <a class="nav-link" href="/exams">
            <i class="bi bi-clipboard-check"></i> Exams
        </a>
        <a class="nav-link" href="/marks">
            <i class="bi bi-award"></i> Marks
        </a>
        <a class="nav-link" href="/timetable">
            <i class="bi bi-calendar3"></i> Timetable
        </a>
        <?php endif; ?>
        
        <?php if (hasRole('admin')): ?>
        <div class="text-white-50 text-uppercase small px-3 mt-3 mb-2">Finance</div>
        <a class="nav-link" href="/invoices">
            <i class="bi bi-receipt"></i> Invoices
        </a>
        <?php endif; ?>
        
        <div class="text-white-50 text-uppercase small px-3 mt-3 mb-2">Resources</div>
        <a class="nav-link" href="/materials">
            <i class="bi bi-file-earmark-pdf"></i> Materials
        </a>
        
        <a class="nav-link" href="/notifications">
            <i class="bi bi-bell"></i> Notifications
        </a>
    </nav>
</div>
