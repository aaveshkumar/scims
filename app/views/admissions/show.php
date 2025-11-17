<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Application Details</h2>
    <div>
        <?php if ($admission['status'] === 'pending' && hasRole('admin')): ?>
            <form method="POST" action="/admissions/<?= $admission['id'] ?>/approve" class="d-inline">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-check-circle me-2"></i>Approve
                </button>
            </form>
            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal">
                <i class="bi bi-x-circle me-2"></i>Reject
            </button>
            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#waitlistModal">
                <i class="bi bi-hourglass me-2"></i>Waitlist
            </button>
        <?php endif; ?>
        <?php if ($admission['status'] === 'approved' && hasRole('admin')): ?>
            <form method="POST" action="/admissions/<?= $admission['id'] ?>/convert" class="d-inline">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-person-check me-2"></i>Convert to Student
                </button>
            </form>
        <?php endif; ?>
        <a href="/admissions" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5>Personal Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Application Number:</strong> <?= htmlspecialchars($admission['application_number']) ?></p>
                        <p><strong>Name:</strong> <?= htmlspecialchars($admission['first_name'] . ' ' . $admission['last_name']) ?></p>
                        <p><strong>Email:</strong> <?= htmlspecialchars($admission['email']) ?></p>
                        <p><strong>Phone:</strong> <?= htmlspecialchars($admission['phone']) ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>DOB:</strong> <?= date('M d, Y', strtotime($admission['date_of_birth'])) ?></p>
                        <p><strong>Gender:</strong> <?= ucfirst($admission['gender']) ?></p>
                        <p><strong>Address:</strong> <?= htmlspecialchars($admission['address']) ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5>Academic & Guardian Information</h5>
            </div>
            <div class="card-body">
                <p><strong>Course:</strong> <?= htmlspecialchars($admission['course_name'] ?? 'N/A') ?></p>
                <p><strong>Class:</strong> <?= htmlspecialchars($admission['class_name'] ?? 'N/A') ?></p>
                <p><strong>Previous School:</strong> <?= htmlspecialchars($admission['previous_school'] ?? 'N/A') ?></p>
                <hr>
                <p><strong>Guardian Name:</strong> <?= htmlspecialchars($admission['guardian_name']) ?></p>
                <p><strong>Guardian Phone:</strong> <?= htmlspecialchars($admission['guardian_phone']) ?></p>
                <p><strong>Guardian Email:</strong> <?= htmlspecialchars($admission['guardian_email'] ?? 'N/A') ?></p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5>Status</h5>
            </div>
            <div class="card-body text-center">
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
                <h3><span class="badge bg-<?= $color ?>"><?= ucfirst($admission['status']) ?></span></h3>
                <p class="text-muted">Applied on: <?= date('M d, Y', strtotime($admission['created_at'])) ?></p>
                <?php if ($admission['reviewed_at']): ?>
                <p class="text-muted">Reviewed on: <?= date('M d, Y', strtotime($admission['reviewed_at'])) ?></p>
                <p>by <?= htmlspecialchars($admission['reviewer_first_name'] . ' ' . $admission['reviewer_last_name']) ?></p>
                <?php endif; ?>
                <?php if ($admission['remarks']): ?>
                <hr>
                <p><strong>Remarks:</strong></p>
                <p><?= htmlspecialchars($admission['remarks']) ?></p>
                <?php endif; ?>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Timeline</h5>
            </div>
            <div class="card-body">
                <?php foreach ($timeline as $event): ?>
                <div class="mb-3">
                    <i class="bi bi-<?= $event['icon'] ?> text-<?= $event['color'] ?>"></i>
                    <strong><?= $event['action'] ?></strong>
                    <br><small class="text-muted"><?= date('M d, Y h:i A', strtotime($event['date'])) ?></small>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal">
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
                    <button type="submit" class="btn btn-danger">Reject Application</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Waitlist Modal -->
<div class="modal fade" id="waitlistModal">
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

<?php include __DIR__ . '/../layouts/footer.php'; ?>
