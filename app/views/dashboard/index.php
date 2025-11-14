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
    <div class="col-xl-6 col-md-6 mb-4">
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

    <div class="col-xl-6 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2" style="border-left: 4px solid #36b9cc;">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Admission Number</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stats['admission_number'] ?? 'N/A' ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="bi bi-card-text text-gray-300" style="font-size: 2rem;"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Quick Actions</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <?php if (hasRole('admin')): ?>
            <div class="col-md-3 mb-3">
                <a href="/students/create" class="btn btn-outline-primary w-100">
                    <i class="bi bi-person-plus"></i><br>Add Student
                </a>
            </div>
            <div class="col-md-3 mb-3">
                <a href="/admissions" class="btn btn-outline-success w-100">
                    <i class="bi bi-file-earmark-text"></i><br>Admissions
                </a>
            </div>
            <?php endif; ?>
            
            <?php if (hasRole('teacher') || hasRole('admin')): ?>
            <div class="col-md-3 mb-3">
                <a href="/attendance" class="btn btn-outline-info w-100">
                    <i class="bi bi-calendar-check"></i><br>Mark Attendance
                </a>
            </div>
            <div class="col-md-3 mb-3">
                <a href="/marks" class="btn btn-outline-warning w-100">
                    <i class="bi bi-award"></i><br>Enter Marks
                </a>
            </div>
            <?php endif; ?>
            
            <div class="col-md-3 mb-3">
                <a href="/materials" class="btn btn-outline-secondary w-100">
                    <i class="bi bi-file-earmark-pdf"></i><br>Materials
                </a>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
