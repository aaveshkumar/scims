<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Admission Applications</h2>
    <div>
        <a href="/admissions/statistics" class="btn btn-info me-2">
            <i class="bi bi-graph-up me-2"></i>Statistics
        </a>
        <a href="/admissions/create" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>New Application
        </a>
    </div>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h3><?= $statistics['total'] ?></h3>
                <p class="mb-0">Total Applications</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <h3><?= $statistics['pending'] ?></h3>
                <p class="mb-0">Pending</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h3><?= $statistics['approved'] ?></h3>
                <p class="mb-0">Approved</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <h3><?= $statistics['rejected'] ?></h3>
                <p class="mb-0">Rejected</p>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="/admissions" class="row g-3">
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="all" <?= $status === 'all' ? 'selected' : '' ?>>All Status</option>
                    <option value="pending" <?= $status === 'pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="approved" <?= $status === 'approved' ? 'selected' : '' ?>>Approved</option>
                    <option value="rejected" <?= $status === 'rejected' ? 'selected' : '' ?>>Rejected</option>
                    <option value="waitlisted" <?= $status === 'waitlisted' ? 'selected' : '' ?>>Waitlisted</option>
                    <option value="completed" <?= $status === 'completed' ? 'selected' : '' ?>>Completed</option>
                </select>
            </div>
            <div class="col-md-6">
                <input type="text" name="search" class="form-control" placeholder="Search by name, email, application#" value="<?= htmlspecialchars($search) ?>">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search me-2"></i>Filter
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Applications List</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Application #</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Course</th>
                        <th>Class</th>
                        <th>Applied On</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($admissions)): ?>
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">No applications found</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($admissions as $admission): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($admission['application_number']) ?></strong></td>
                                <td><?= htmlspecialchars($admission['first_name'] . ' ' . $admission['last_name']) ?></td>
                                <td><?= htmlspecialchars($admission['email']) ?></td>
                                <td><?= htmlspecialchars($admission['course_name'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($admission['class_name'] ?? 'N/A') ?></td>
                                <td><?= date('M d, Y', strtotime($admission['created_at'])) ?></td>
                                <td>
                                    <?php
                                    $statusColors = [
                                        'pending' => 'warning',
                                        'approved' => 'success',
                                        'rejected' => 'danger',
                                        'waitlisted' => 'info',
                                        'completed' => 'primary'
                                    ];
                                    $color = $statusColors[$admission['status']] ?? 'secondary';
                                    ?>
                                    <span class="badge bg-<?= $color ?>"><?= ucfirst($admission['status']) ?></span>
                                </td>
                                <td>
                                    <a href="/admissions/<?= $admission['id'] ?>" class="btn btn-sm btn-info" title="View Details">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <?php if (($admission['status'] === 'pending' || $admission['status'] === 'waitlisted') && hasRole('admin')): ?>
                                        <a href="/admissions/<?= $admission['id'] ?>/edit" class="btn btn-sm btn-warning" title="Edit Application">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    <?php endif; ?>
                                    <?php if ($admission['status'] === 'pending' && hasRole('admin')): ?>
                                        <form method="POST" action="/admissions/<?= $admission['id'] ?>/approve" class="d-inline">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-sm btn-success" title="Approve" onclick="return confirm('Approve this application?')">
                                                <i class="bi bi-check-circle"></i>
                                            </button>
                                        </form>
                                        <button class="btn btn-sm btn-danger" title="Reject" data-bs-toggle="modal" data-bs-target="#rejectModal-<?= $admission['id'] ?>">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning" title="Waitlist" data-bs-toggle="modal" data-bs-target="#waitlistModal-<?= $admission['id'] ?>">
                                            <i class="bi bi-hourglass"></i>
                                        </button>
                                    <?php elseif ($admission['status'] === 'waitlisted' && hasRole('admin')): ?>
                                        <form method="POST" action="/admissions/<?= $admission['id'] ?>/approve" class="d-inline">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-sm btn-success" title="Approve from Waitlist" onclick="return confirm('Approve this application?')">
                                                <i class="bi bi-check-circle"></i>
                                            </button>
                                        </form>
                                    <?php elseif ($admission['status'] === 'approved' && hasRole('admin')): ?>
                                        <form method="POST" action="/admissions/<?= $admission['id'] ?>/convert" class="d-inline">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-sm btn-primary" title="Convert to Student" onclick="return confirm('Convert to student record?')">
                                                <i class="bi bi-person-check"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modals for Reject and Waitlist -->
<?php foreach ($admissions as $admission): ?>
    <?php if ($admission['status'] === 'pending'): ?>
    <!-- Reject Modal -->
    <div class="modal fade" id="rejectModal-<?= $admission['id'] ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="/admissions/<?= $admission['id'] ?>/reject">
                    <?= csrf_field() ?>
                    <div class="modal-header">
                        <h5>Reject Application</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <label>Reason for rejection *</label>
                        <textarea name="remarks" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-danger">Reject</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Waitlist Modal -->
    <div class="modal fade" id="waitlistModal-<?= $admission['id'] ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="/admissions/<?= $admission['id'] ?>/waitlist">
                    <?= csrf_field() ?>
                    <div class="modal-header">
                        <h5>Move to Waitlist</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <label>Remarks</label>
                        <textarea name="remarks" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning">Move to Waitlist</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?>
<?php endforeach; ?>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
