<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0"><?= htmlspecialchars($assignment['title']) ?></h1>
        <p class="text-muted mb-0">Subject: <?= htmlspecialchars($assignment['subject_name']) ?> • Class: <?= htmlspecialchars($assignment['class_name']) ?></p>
    </div>
    <div>
        <a href="/assignments/<?= $assignment['id'] ?>/edit" class="btn btn-warning me-2">
            <i class="bi bi-pencil me-2"></i>Edit
        </a>
        <form method="POST" action="/assignments/<?= $assignment['id'] ?>/delete" style="display: inline;" onsubmit="return confirm('Delete this assignment? This action cannot be undone.');">
            <input type="hidden" name="_token" value="<?= csrf() ?>">
            <button type="submit" class="btn btn-danger me-2">
                <i class="bi bi-trash me-2"></i>Delete
            </button>
        </form>
        <a href="/assignments" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <!-- Assignment Info -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Assignment Information</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="fw-bold text-muted">Assigned Date</label>
                        <p><?= date('d M Y', strtotime($assignment['assigned_date'])) ?></p>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold text-muted">Due Date</label>
                        <p class="text-<?= strtotime($assignment['due_date']) < time() ? 'danger' : 'success' ?>">
                            <?= date('d M Y', strtotime($assignment['due_date'])) ?>
                        </p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="fw-bold text-muted">Total Marks</label>
                        <p><?= $assignment['total_marks'] ?></p>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold text-muted">Status</label>
                        <p><span class="badge bg-<?= $assignment['status'] === 'active' ? 'success' : 'secondary' ?>"><?= ucfirst($assignment['status']) ?></span></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Description -->
        <?php if (!empty($assignment['description'])): ?>
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Description</h5>
                </div>
                <div class="card-body">
                    <p><?= nl2br(htmlspecialchars($assignment['description'])) ?></p>
                </div>
            </div>
        <?php endif; ?>

        <!-- Instructions -->
        <?php if (!empty($assignment['instructions'])): ?>
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Instructions</h5>
                </div>
                <div class="card-body">
                    <p><?= nl2br(htmlspecialchars($assignment['instructions'])) ?></p>
                </div>
            </div>
        <?php endif; ?>

        <!-- Submissions -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Student Submissions (<?= count($submissions) ?>)</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($submissions)): ?>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>Student Name</th>
                                    <th>Roll Number</th>
                                    <th>Submission Date</th>
                                    <th>Marks</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($submissions as $sub): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($sub['first_name'] . ' ' . $sub['last_name']) ?></td>
                                        <td><?= htmlspecialchars($sub['roll_number']) ?></td>
                                        <td><?= $sub['submission_date'] ? date('d M Y', strtotime($sub['submission_date'])) : 'Not submitted' ?></td>
                                        <td><?= $sub['marks_obtained'] ?? '-' ?></td>
                                        <td><span class="badge bg-<?= $sub['status'] === 'submitted' ? 'info' : 'success' ?>"><?= ucfirst($sub['status']) ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted text-center py-3">No submissions yet</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card sticky-top" style="top: 20px;">
            <div class="card-header">
                <h5 class="mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <a href="/assignments/<?= $assignment['id'] ?>/edit" class="btn btn-warning w-100 mb-2">
                    <i class="bi bi-pencil me-2"></i>Edit Assignment
                </a>
                <a href="/assignments" class="btn btn-outline-secondary w-100">
                    <i class="bi bi-list me-2"></i>View All
                </a>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
