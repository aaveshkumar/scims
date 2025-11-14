<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Attendance Report</h1>
        <p class="text-muted mb-0"><?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?> - <?= htmlspecialchars($student['class_name'] ?? 'N/A') ?></p>
    </div>
    <div>
        <button onclick="window.print()" class="btn btn-primary me-2">
            <i class="bi bi-printer me-2"></i>Print
        </button>
        <a href="/attendance" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3 mb-3">
        <div class="card bg-success bg-opacity-10 border-success">
            <div class="card-body text-center">
                <h2 class="text-success"><?= $stats['present'] ?? 0 ?></h2>
                <p class="text-muted mb-0">Present</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-danger bg-opacity-10 border-danger">
            <div class="card-body text-center">
                <h2 class="text-danger"><?= $stats['absent'] ?? 0 ?></h2>
                <p class="text-muted mb-0">Absent</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-warning bg-opacity-10 border-warning">
            <div class="card-body text-center">
                <h2 class="text-warning"><?= $stats['late'] ?? 0 ?></h2>
                <p class="text-muted mb-0">Late</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <div class="card bg-primary bg-opacity-10 border-primary">
            <div class="card-body text-center">
                <h2 class="text-primary">
                    <?php
                    $total = $stats['total'] ?? 0;
                    $present = $stats['present'] ?? 0;
                    $percentage = $total > 0 ? round(($present / $total) * 100, 2) : 0;
                    echo $percentage;
                    ?>%
                </h2>
                <p class="text-muted mb-0">Attendance Rate</p>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <div class="row align-items-center">
            <div class="col">
                <h5 class="mb-0">Attendance Details</h5>
            </div>
            <div class="col-auto">
                <form method="GET" action="/attendance/report" class="row g-2">
                    <input type="hidden" name="student_id" value="<?= $student['id'] ?>">
                    <div class="col-auto">
                        <input type="date" name="start_date" class="form-control form-control-sm" value="<?= $start_date ?>">
                    </div>
                    <div class="col-auto">
                        <input type="date" name="end_date" class="form-control form-control-sm" value="<?= $end_date ?>">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Day</th>
                        <th>Status</th>
                        <th>Marked By</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($attendance)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">No attendance records found for the selected period</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($attendance as $record): ?>
                            <tr>
                                <td><?= date('M d, Y', strtotime($record['date'])) ?></td>
                                <td><?= date('l', strtotime($record['date'])) ?></td>
                                <td>
                                    <span class="badge bg-<?= match($record['status']) {
                                        'present' => 'success',
                                        'absent' => 'danger',
                                        'late' => 'warning',
                                        'excused' => 'info',
                                        default => 'secondary'
                                    } ?>">
                                        <?= ucfirst($record['status']) ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($record['marked_by_name'] ?? 'System') ?></td>
                                <td><?= date('h:i A', strtotime($record['created_at'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Student Information</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Name:</strong> <?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?></p>
                <p><strong>Admission Number:</strong> <?= htmlspecialchars($student['admission_number']) ?></p>
                <p><strong>Class:</strong> <?= htmlspecialchars($student['class_name'] ?? 'N/A') ?></p>
            </div>
            <div class="col-md-6 text-md-end">
                <p><strong>Report Period:</strong> <?= date('M d, Y', strtotime($start_date)) ?> to <?= date('M d, Y', strtotime($end_date)) ?></p>
                <p><strong>Total Days:</strong> <?= $stats['total'] ?? 0 ?></p>
                <p><strong>Attendance Rate:</strong> 
                    <span class="badge bg-<?= $percentage >= 75 ? 'success' : ($percentage >= 60 ? 'warning' : 'danger') ?> fs-6">
                        <?= $percentage ?>%
                    </span>
                </p>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .btn, form, nav, .sidebar { display: none !important; }
    .card { border: 1px solid #dee2e6 !important; }
}
</style>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
