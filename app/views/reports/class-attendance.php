<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-people-fill me-2"></i>Class Attendance Report</h2>
    <a href="/reports/attendance" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<!-- Filter Form -->
<div class="card mb-4">
    <div class="card-header">
        <h6 class="mb-0">Select Class & Date</h6>
    </div>
    <div class="card-body">
        <form method="GET" action="/reports/class-attendance">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Select Class <span class="text-danger">*</span></label>
                    <select name="class_id" class="form-select" required>
                        <option value="">-- Select Class --</option>
                        <?php if (!empty($classes)): ?>
                            <?php foreach ($classes as $class): ?>
                                <option value="<?= $class['id'] ?>" <?= ($selectedClass == $class['id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($class['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Select Date <span class="text-danger">*</span></label>
                    <input type="date" name="date" class="form-control" value="<?= $selectedDate ?? date('Y-m-d') ?>" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">&nbsp;</label>
                    <div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-search me-2"></i>Generate Report
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<?php if ($selectedClass && $selectedDate && !empty($roster)): ?>
<!-- Summary Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-primary"><?= $summary['total'] ?? 0 ?></h3>
                <p class="mb-0">Total Students</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-success"><?= $summary['present'] ?? 0 ?></h3>
                <p class="mb-0">Present</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-danger"><?= $summary['absent'] ?? 0 ?></h3>
                <p class="mb-0">Absent</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-warning"><?= ($summary['leave_count'] ?? 0) + ($summary['late'] ?? 0) ?></h3>
                <p class="mb-0">Leave/Late</p>
            </div>
        </div>
    </div>
</div>

<!-- Class Attendance Table -->
<div class="card">
    <div class="card-header">
        <h6 class="mb-0">
            Attendance for <?= htmlspecialchars($className ?? 'Class') ?> - <?= date('M d, Y', strtotime($selectedDate)) ?>
        </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-light">
                    <tr>
                        <th style="width: 10%;">Roll No</th>
                        <th style="width: 25%;">Student Name</th>
                        <th style="width: 25%;">Father Name</th>
                        <th style="width: 15%;">Status</th>
                        <th style="width: 25%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($roster as $student): ?>
                        <tr>
                            <td><?= htmlspecialchars($student['roll_number'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars(($student['first_name'] ?? '') . ' ' . ($student['last_name'] ?? '')) ?></td>
                            <td><?= htmlspecialchars($student['guardian_name'] ?? 'N/A') ?></td>
                            <td>
                                <?php 
                                if ($student['status']) {
                                    $badgeClass = match($student['status']) {
                                        'present' => 'bg-success',
                                        'absent' => 'bg-danger',
                                        'leave' => 'bg-info',
                                        'late' => 'bg-warning',
                                        default => 'bg-secondary'
                                    };
                                    echo '<span class="badge ' . $badgeClass . '">' . ucfirst($student['status']) . '</span>';
                                } else {
                                    echo '<span class="badge bg-secondary">Not Marked</span>';
                                }
                                ?>
                            </td>
                            <td>
                                <?php if ($student['attendance_id']): ?>
                                    <a href="/reports/attendance/<?= $student['attendance_id'] ?>/view" class="btn btn-sm btn-info" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="/reports/attendance/<?= $student['attendance_id'] ?>/edit" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                <?php else: ?>
                                    <button class="btn btn-sm btn-success mark-attendance" data-student-id="<?= $student['student_id'] ?>" 
                                            data-class-id="<?= $selectedClass ?>" data-date="<?= $selectedDate ?>" title="Mark Attendance">
                                        <i class="bi bi-plus-circle"></i> Mark
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php elseif ($selectedClass && $selectedDate): ?>
    <div class="alert alert-info">
        <i class="bi bi-info-circle me-2"></i>No students found for the selected class.
    </div>
<?php endif; ?>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
