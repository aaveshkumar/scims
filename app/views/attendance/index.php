<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="mb-4">
    <h1 class="h3 mb-0">Attendance Management</h1>
    <p class="text-muted">Mark and view attendance records</p>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Mark Attendance</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="/attendance/mark">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Class *</label>
                    <select name="class_id" class="form-select" required>
                        <option value="">Select Class</option>
                        <?php foreach ($classes as $class): ?>
                            <option value="<?= $class['id'] ?>"><?= htmlspecialchars($class['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Date *</label>
                    <input type="date" name="date" class="form-control" value="<?= date('Y-m-d') ?>" required>
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-arrow-right me-2"></i>Mark
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">View Attendance Records</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="/attendance" class="row g-3 mb-4">
            <div class="col-md-5">
                <label class="form-label">Class</label>
                <select name="class_id" class="form-select">
                    <option value="">All Classes</option>
                    <?php foreach ($classes as $class): ?>
                        <option value="<?= $class['id'] ?>" <?= (isset($_GET['class_id']) && $_GET['class_id'] == $class['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($class['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Date</label>
                <input type="date" name="date" class="form-control" value="<?= $_GET['date'] ?? date('Y-m-d') ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label">&nbsp;</label>
                <button type="submit" class="btn btn-secondary w-100">
                    <i class="bi bi-search me-2"></i>View Records
                </button>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Class</th>
                        <th>Student</th>
                        <th>Status</th>
                        <th>Marked By</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $classId = $_GET['class_id'] ?? null;
                    $date = $_GET['date'] ?? date('Y-m-d');
                    
                    if ($classId):
                        $records = db()->fetchAll(
                            "SELECT a.*, c.name as class_name, CONCAT(u.first_name, ' ', u.last_name) as student_name, 
                                    CONCAT(mu.first_name, ' ', mu.last_name) as marked_by_name
                             FROM attendance a
                             JOIN classes c ON a.class_id = c.id
                             JOIN students s ON a.student_id = s.id
                             JOIN users u ON s.user_id = u.id
                             JOIN users mu ON a.marked_by = mu.id
                             WHERE a.class_id = ? AND a.date = ? AND a.period IS NULL
                             ORDER BY u.first_name, u.last_name",
                            [$classId, $date]
                        );
                        
                        if (!empty($records)):
                            foreach ($records as $record):
                    ?>
                        <tr>
                            <td><?= date('d M Y', strtotime($record['date'])) ?></td>
                            <td><?= htmlspecialchars($record['class_name']) ?></td>
                            <td><?= htmlspecialchars($record['student_name']) ?></td>
                            <td>
                                <span class="badge bg-<?= $record['status'] === 'present' ? 'success' : ($record['status'] === 'absent' ? 'danger' : 'warning') ?>">
                                    <?= ucfirst($record['status']) ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($record['marked_by_name']) ?></td>
                        </tr>
                    <?php
                            endforeach;
                        else:
                    ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-3">No attendance records found for this date and class</td>
                        </tr>
                    <?php
                        endif;
                    else:
                    ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-3">Select a class to view attendance records</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
