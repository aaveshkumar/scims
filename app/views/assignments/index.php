<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-journal-text me-2"></i>Assignment Management</h2>
    <a href="/assignments/create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Create Assignment
    </a>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h6>Total Assignments</h6>
                <h3><?= $stats['total_assignments'] ?? 0 ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h6>Active</h6>
                <h3><?= $stats['active_assignments'] ?? 0 ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <h6>Pending Review</h6>
                <h3><?= $stats['pending_submissions'] ?? 0 ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h6>Graded</h6>
                <h3><?= $stats['graded_submissions'] ?? 0 ?></h3>
            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-4">
                <select name="subject_id" class="form-select">
                    <option value="">All Subjects</option>
                    <?php foreach ($subjects ?? [] as $subject): ?>
                        <option value="<?= $subject['id'] ?>" <?= ($filters['subject_id'] ?? '') == $subject['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($subject['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <select name="class_id" class="form-select">
                    <option value="">All Classes</option>
                    <?php foreach ($classes ?? [] as $class): ?>
                        <option value="<?= $class['id'] ?>" <?= ($filters['class_id'] ?? '') == $class['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($class['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="active" <?= ($filters['status'] ?? '') == 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="closed" <?= ($filters['status'] ?? '') == 'closed' ? 'selected' : '' ?>>Closed</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Subject</th>
                        <th>Class</th>
                        <th>Assigned Date</th>
                        <th>Due Date</th>
                        <th>Total Marks</th>
                        <th>Submissions</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($assignments)): ?>
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                No assignments found. Click "Create Assignment" to get started.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($assignments as $assignment): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($assignment['title']) ?></strong></td>
                                <td><?= htmlspecialchars($assignment['subject_name'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($assignment['class_name'] ?? 'N/A') ?></td>
                                <td><?= date('M d, Y', strtotime($assignment['assigned_date'])) ?></td>
                                <td><?= date('M d, Y', strtotime($assignment['due_date'])) ?></td>
                                <td><?= htmlspecialchars($assignment['total_marks']) ?></td>
                                <td><?= $assignment['submission_count'] ?? 0 ?></td>
                                <td>
                                    <span class="badge bg-<?= $assignment['status'] == 'active' ? 'success' : 'secondary' ?>">
                                        <?= ucfirst($assignment['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="/assignments/<?= $assignment['id'] ?>" class="btn btn-sm btn-info">View</a>
                                    <a href="/assignments/<?= $assignment['id'] ?>/edit" class="btn btn-sm btn-warning">Edit</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>