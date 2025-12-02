<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <p class="text-muted mb-0">Welcome back, <?= htmlspecialchars($user['first_name']) ?>!</p>
    </div>
</div>

<?php if (hasRole('admin')): ?>
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2" style="border-left: 4px solid #4e73df;">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Students</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stats['total_students'] ?? 0 ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-people text-gray-300" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2" style="border-left: 4px solid #1cc88a;">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Staff</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stats['total_staff'] ?? 0 ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-person-badge text-gray-300" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2" style="border-left: 4px solid #36b9cc;">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Classes</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stats['total_classes'] ?? 0 ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-building text-gray-300" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2" style="border-left: 4px solid #f6c23e;">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pending Admissions</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stats['pending_admissions'] ?? 0 ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-file-earmark-text text-gray-300" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php if (hasRole('teacher')): ?>
<div class="row">
    <div class="col-xl-6 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2" style="border-left: 4px solid #4e73df;">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">My Subjects</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stats['my_subjects'] ?? 0 ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-journal-bookmark text-gray-300" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2" style="border-left: 4px solid #1cc88a;">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Today's Attendance</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stats['today_attendance'] ?? 0 ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-calendar-check text-gray-300" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<?php if (hasRole('student')): ?>
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2" style="border-left: 4px solid #4e73df;">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Attendance</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stats['attendance_percentage'] ?? 0 ?>%</div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-calendar-check text-gray-300" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2" style="border-left: 4px solid #36b9cc;">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Admission #</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stats['admission_number'] ?? 'N/A' ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-card-text text-gray-300" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2" style="border-left: 4px solid #1cc88a;">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">My Marks</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><a href="/student-portal/marks" class="text-decoration-none">View</a></div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-graph-up text-gray-300" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2" style="border-left: 4px solid #f6c23e;">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Fees</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><a href="/student-portal/fees" class="text-decoration-none">View</a></div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-receipt text-gray-300" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-lightning-fill text-warning me-2"></i>Quick Actions</h5>
    </div>
    <div class="card-body">
        <?php if (hasRole('admin')): ?>
        <!-- User Management -->
        <div class="mb-4">
            <h6 class="text-muted mb-3"><i class="bi bi-people me-2"></i>User Management</h6>
            <div class="row">
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-2">
                    <a href="/students/create" class="btn btn-sm btn-outline-primary w-100">
                        <i class="bi bi-person-plus"></i><br><small>Add Student</small>
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-2">
                    <a href="/students" class="btn btn-sm btn-outline-primary w-100">
                        <i class="bi bi-people"></i><br><small>View Students</small>
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-2">
                    <a href="/staff/create" class="btn btn-sm btn-outline-primary w-100">
                        <i class="bi bi-person-badge"></i><br><small>New Staff</small>
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-2">
                    <a href="/staff" class="btn btn-sm btn-outline-primary w-100">
                        <i class="bi bi-people-fill"></i><br><small>View Staff</small>
                    </a>
                </div>
            </div>
        </div>

        <!-- Academics -->
        <div class="mb-4">
            <h6 class="text-muted mb-3"><i class="bi bi-book me-2"></i>Academics</h6>
            <div class="row">
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-2">
                    <a href="/attendance" class="btn btn-sm btn-outline-info w-100">
                        <i class="bi bi-calendar-check"></i><br><small>Attendance</small>
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-2">
                    <a href="/marks" class="btn btn-sm btn-outline-info w-100">
                        <i class="bi bi-award"></i><br><small>Enter Marks</small>
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-2">
                    <a href="/exams/create" class="btn btn-sm btn-outline-info w-100">
                        <i class="bi bi-clipboard-check"></i><br><small>New Exam</small>
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-2">
                    <a href="/courses/create" class="btn btn-sm btn-outline-info w-100">
                        <i class="bi bi-book"></i><br><small>New Course</small>
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-2">
                    <a href="/subjects/create" class="btn btn-sm btn-outline-info w-100">
                        <i class="bi bi-journal-bookmark"></i><br><small>New Subject</small>
                    </a>
                </div>
            </div>
        </div>

        <!-- Finance -->
        <div class="mb-4">
            <h6 class="text-muted mb-3"><i class="bi bi-cash-coin me-2"></i>Finance</h6>
            <div class="row">
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-2">
                    <a href="/invoices/create" class="btn btn-sm btn-outline-success w-100">
                        <i class="bi bi-receipt"></i><br><small>Create Invoice</small>
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-2">
                    <a href="/invoices" class="btn btn-sm btn-outline-success w-100">
                        <i class="bi bi-receipt-cutoff"></i><br><small>View Invoices</small>
                    </a>
                </div>
            </div>
        </div>

        <!-- Admissions & Hostel -->
        <div class="mb-4">
            <h6 class="text-muted mb-3"><i class="bi bi-house me-2"></i>Admissions & Hostel</h6>
            <div class="row">
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-2">
                    <a href="/admissions/create" class="btn btn-sm btn-outline-warning w-100">
                        <i class="bi bi-file-earmark-text"></i><br><small>New Admission</small>
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-2">
                    <a href="/admissions" class="btn btn-sm btn-outline-warning w-100">
                        <i class="bi bi-inbox"></i><br><small>View Applications</small>
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-2">
                    <a href="/hostel/residents/create" class="btn btn-sm btn-outline-warning w-100">
                        <i class="bi bi-house"></i><br><small>Add Resident</small>
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-2">
                    <a href="/hostel/residents" class="btn btn-sm btn-outline-warning w-100">
                        <i class="bi bi-house-fill"></i><br><small>View Residents</small>
                    </a>
                </div>
            </div>
        </div>

        <!-- Transport & HR -->
        <div class="mb-4">
            <h6 class="text-muted mb-3"><i class="bi bi-truck me-2"></i>Transport & HR</h6>
            <div class="row">
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-2">
                    <a href="/transport/vehicles" class="btn btn-sm btn-outline-danger w-100">
                        <i class="bi bi-truck"></i><br><small>Vehicles</small>
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-2">
                    <a href="/transport/drivers" class="btn btn-sm btn-outline-danger w-100">
                        <i class="bi bi-person-badge"></i><br><small>Drivers</small>
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-2">
                    <a href="/hr/events" class="btn btn-sm btn-outline-danger w-100">
                        <i class="bi bi-calendar-event"></i><br><small>HR Events</small>
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-2">
                    <a href="/hr/recruitment" class="btn btn-sm btn-outline-danger w-100">
                        <i class="bi bi-briefcase"></i><br><small>Recruitment</small>
                    </a>
                </div>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-2">
                    <a href="/hr/payroll" class="btn btn-sm btn-outline-danger w-100">
                        <i class="bi bi-cash"></i><br><small>Payroll</small>
                    </a>
                </div>
            </div>
        </div>

        <!-- Learning -->
        <div class="mb-0">
            <h6 class="text-muted mb-3"><i class="bi bi-book-fill me-2"></i>Learning</h6>
            <div class="row">
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-2">
                    <a href="/materials" class="btn btn-sm btn-outline-secondary w-100">
                        <i class="bi bi-file-earmark-pdf"></i><br><small>Materials</small>
                    </a>
                </div>
            </div>
        </div>
        <?php else: ?>
        <!-- Non-admin Quick Actions -->
        <div class="row">
            <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-2">
                <a href="/attendance" class="btn btn-sm btn-outline-info w-100">
                    <i class="bi bi-calendar-check"></i><br><small>Attendance</small>
                </a>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-2">
                <a href="/marks" class="btn btn-sm btn-outline-warning w-100">
                    <i class="bi bi-award"></i><br><small>Marks</small>
                </a>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-2">
                <a href="/materials" class="btn btn-sm btn-outline-secondary w-100">
                    <i class="bi bi-file-earmark-pdf"></i><br><small>Materials</small>
                </a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>

<?php if (hasRole('student')): ?>
<div class="card">
    <div class="card-header">
        <h5 class="mb-0"><i class="bi bi-lightning-fill text-info me-2"></i>Quick Links</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-2">
                <a href="/student-portal/marks" class="btn btn-sm btn-outline-info w-100">
                    <i class="bi bi-graph-up"></i><br><small>My Marks</small>
                </a>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-2">
                <a href="/student-portal/attendance" class="btn btn-sm btn-outline-info w-100">
                    <i class="bi bi-calendar-check"></i><br><small>Attendance</small>
                </a>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-2">
                <a href="/student-portal/assignments" class="btn btn-sm btn-outline-info w-100">
                    <i class="bi bi-file-text"></i><br><small>Assignments</small>
                </a>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-2">
                <a href="/student-portal/materials" class="btn btn-sm btn-outline-info w-100">
                    <i class="bi bi-book"></i><br><small>Materials</small>
                </a>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-2">
                <a href="/student-portal/library/books" class="btn btn-sm btn-outline-info w-100">
                    <i class="bi bi-book-half"></i><br><small>Library</small>
                </a>
            </div>
            <div class="col-lg-2 col-md-3 col-sm-4 col-6 mb-2">
                <a href="/student-portal/fees" class="btn btn-sm btn-outline-info w-100">
                    <i class="bi bi-receipt"></i><br><small>Fee Info</small>
                </a>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
