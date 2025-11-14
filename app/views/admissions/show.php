<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Admission Application Details</h1>
    <div>
        <?php if ($admission['status'] === 'pending' && hasRole('admin')): ?>
            <button onclick="approveAdmission(<?= $admission['id'] ?>)" class="btn btn-success me-2">
                <i class="bi bi-check-circle me-2"></i>Approve
            </button>
            <button onclick="rejectAdmission(<?= $admission['id'] ?>)" class="btn btn-danger me-2">
                <i class="bi bi-x-circle me-2"></i>Reject
            </button>
        <?php endif; ?>
        <a href="/admissions" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Applicant Information</h5>
                <span class="badge bg-<?= match($admission['status']) {
                    'pending' => 'warning',
                    'approved' => 'success',
                    'rejected' => 'danger',
                    default => 'secondary'
                } ?> fs-6">
                    <?= ucfirst($admission['status']) ?>
                </span>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-1 text-muted">Full Name</p>
                        <p><strong><?= htmlspecialchars($admission['first_name'] . ' ' . $admission['last_name']) ?></strong></p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1 text-muted">Application Number</p>
                        <p><strong><?= htmlspecialchars($admission['application_number']) ?></strong></p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-1 text-muted">Email</p>
                        <p><?= htmlspecialchars($admission['email']) ?></p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1 text-muted">Phone</p>
                        <p><?= htmlspecialchars($admission['phone']) ?></p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <p class="mb-1 text-muted">Date of Birth</p>
                        <p><?= date('M d, Y', strtotime($admission['date_of_birth'])) ?></p>
                    </div>
                    <div class="col-md-4">
                        <p class="mb-1 text-muted">Gender</p>
                        <p><?= ucfirst($admission['gender']) ?></p>
                    </div>
                    <div class="col-md-4">
                        <p class="mb-1 text-muted">Previous School</p>
                        <p><?= htmlspecialchars($admission['previous_school'] ?? 'N/A') ?></p>
                    </div>
                </div>

                <div class="mb-0">
                    <p class="mb-1 text-muted">Address</p>
                    <p><?= htmlspecialchars($admission['address']) ?></p>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Academic Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-1 text-muted">Applied Course</p>
                        <p><?= htmlspecialchars($admission['course_name'] ?? 'Not specified') ?></p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1 text-muted">Applied Class</p>
                        <p><?= htmlspecialchars($admission['class_name'] ?? 'Not specified') ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Guardian Information</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-1 text-muted">Guardian Name</p>
                        <p><?= htmlspecialchars($admission['guardian_name']) ?></p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1 text-muted">Guardian Phone</p>
                        <p><?= htmlspecialchars($admission['guardian_phone']) ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-1 text-muted">Guardian Email</p>
                        <p><?= htmlspecialchars($admission['guardian_email'] ?? 'N/A') ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Application Timeline</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <p class="mb-1 text-muted">Submitted On</p>
                    <p><?= date('M d, Y h:i A', strtotime($admission['created_at'])) ?></p>
                </div>
                
                <?php if ($admission['reviewed_at']): ?>
                    <div class="mb-3">
                        <p class="mb-1 text-muted">Reviewed On</p>
                        <p><?= date('M d, Y h:i A', strtotime($admission['reviewed_at'])) ?></p>
                    </div>
                    <div class="mb-0">
                        <p class="mb-1 text-muted">Reviewed By</p>
                        <p><?= htmlspecialchars(($admission['reviewer_first_name'] ?? '') . ' ' . ($admission['reviewer_last_name'] ?? '')) ?: 'N/A' ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($admission['remarks']): ?>
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Remarks</h5>
                </div>
                <div class="card-body">
                    <p><?= nl2br(htmlspecialchars($admission['remarks'])) ?></p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
function approveAdmission(id) {
    if (confirm('Are you sure you want to approve this admission?')) {
        fetch(`/admissions/${id}/approve`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: '_token=<?= csrf() ?>'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Admission approved successfully!');
                window.location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        });
    }
}

function rejectAdmission(id) {
    const remarks = prompt('Enter rejection reason (optional):');
    if (remarks !== null) {
        fetch(`/admissions/${id}/reject`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `_token=<?= csrf() ?>&remarks=${encodeURIComponent(remarks)}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Admission rejected.');
                window.location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        });
    }
}
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
