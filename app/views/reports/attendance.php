<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-graph-up me-2"></i>Attendance Reports</h2>
    <a href="/reports/attendance/create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Add Attendance
    </a>
</div>

<!-- Filter Form -->
<div class="card mb-4">
    <div class="card-header">
        <h6 class="mb-0">Filter Attendance</h6>
    </div>
    <div class="card-body">
        <form method="GET" action="/reports/attendance">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Select Date</label>
                    <select name="date" class="form-select">
                        <option value="">-- All Dates --</option>
                        <?php if (!empty($dates)): ?>
                            <?php foreach ($dates as $d): ?>
                                <option value="<?= $d['date'] ?>" <?= ($selectedDate == $d['date']) ? 'selected' : '' ?>>
                                    <?= date('M d, Y', strtotime($d['date'])) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Select Class</label>
                    <select name="class_id" class="form-select">
                        <option value="">-- All Classes --</option>
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
                    <label class="form-label">&nbsp;</label>
                    <div>
                        <button type="submit" class="btn btn-info w-100">
                            <i class="bi bi-search me-2"></i>Filter Records
                        </button>
                    </div>
                </div>
            </div>
            <?php if ($selectedDate || $selectedClass): ?>
                <div class="text-end">
                    <a href="/reports/attendance" class="btn btn-secondary btn-sm">
                        <i class="bi bi-x-circle me-1"></i>Clear Filters
                    </a>
                </div>
            <?php endif; ?>
        </form>
    </div>
</div>

<!-- Summary Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-primary"><?= $summary['total'] ?? 0 ?></h3>
                <p class="mb-0">Total Records</p>
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
                <h3 class="text-warning"><?= $summary['late'] ?? 0 ?></h3>
                <p class="mb-0">Late</p>
            </div>
        </div>
    </div>
</div>

<!-- Data Table -->
<div class="card">
    <div class="card-header">
        <h6 class="mb-0">
            <?php if ($selectedDate || $selectedClass): ?>
                Filtered Attendance Records
                <?php if ($selectedClass): ?>
                    - Class: <?= htmlspecialchars($selectedClass) ?>
                <?php endif; ?>
                <?php if ($selectedDate): ?>
                    - Date: <?= date('M d, Y', strtotime($selectedDate)) ?>
                <?php endif; ?>
            <?php else: ?>
                Recent Attendance Records
            <?php endif; ?>
        </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student</th>
                        <th>Class</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Remarks</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($records)): ?>
                        <?php foreach ($records as $index => $record): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= htmlspecialchars(($record['first_name'] ?? 'N/A') . ' ' . ($record['last_name'] ?? '')) ?></td>
                                <td><?= htmlspecialchars($record['class_name'] ?? 'N/A') ?></td>
                                <td><?= date('M d, Y', strtotime($record['date'])) ?></td>
                                <td>
                                    <?php 
                                    $badge = $record['status'] == 'present' ? 'bg-success' : ($record['status'] == 'absent' ? 'bg-danger' : 'bg-warning');
                                    ?>
                                    <span class="badge <?= $badge ?>"><?= ucfirst($record['status']) ?></span>
                                </td>
                                <td><?= htmlspecialchars($record['remarks'] ?? '-') ?></td>
                                <td>
                                    <a href="/reports/attendance/<?= $record['id'] ?>/view" class="btn btn-sm btn-info" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="/reports/attendance/<?= $record['id'] ?>/edit" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" action="/reports/attendance/<?= $record['id'] ?>/delete" style="display:inline;">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this record?')" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">No attendance records found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
