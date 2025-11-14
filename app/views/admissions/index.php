<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Admission Applications</h1>
    <a href="/admissions/create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>New Application
    </a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <div class="btn-group" role="group">
            <a href="/admissions?status=all" class="btn btn-<?= $status === 'all' ? 'primary' : 'outline-primary' ?>">
                All
            </a>
            <a href="/admissions?status=pending" class="btn btn-<?= $status === 'pending' ? 'warning' : 'outline-warning' ?>">
                Pending
            </a>
            <a href="/admissions?status=approved" class="btn btn-<?= $status === 'approved' ? 'success' : 'outline-success' ?>">
                Approved
            </a>
            <a href="/admissions?status=rejected" class="btn btn-<?= $status === 'rejected' ? 'danger' : 'outline-danger' ?>">
                Rejected
            </a>
        </div>
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
                        <th>Applied On</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($admissions)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No applications found</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($admissions as $admission): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($admission['application_number']) ?></strong></td>
                                <td><?= htmlspecialchars($admission['first_name'] . ' ' . $admission['last_name']) ?></td>
                                <td><?= htmlspecialchars($admission['email']) ?></td>
                                <td><?= htmlspecialchars($admission['course_name'] ?? 'N/A') ?></td>
                                <td><?= date('M d, Y', strtotime($admission['created_at'])) ?></td>
                                <td>
                                    <span class="badge bg-<?= match($admission['status']) {
                                        'pending' => 'warning',
                                        'approved' => 'success',
                                        'rejected' => 'danger',
                                        default => 'secondary'
                                    } ?>">
                                        <?= ucfirst($admission['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="/admissions/<?= $admission['id'] ?>" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <?php if ($admission['status'] === 'pending' && hasRole('admin')): ?>
                                        <button onclick="approveAdmission(<?= $admission['id'] ?>)" class="btn btn-sm btn-success">
                                            <i class="bi bi-check-circle"></i>
                                        </button>
                                        <button onclick="rejectAdmission(<?= $admission['id'] ?>)" class="btn btn-sm btn-danger">
                                            <i class="bi bi-x-circle"></i>
                                        </button>
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

<script>
function approveAdmission(id) {
    if (confirm('Approve this admission? This will create a student account.')) {
        fetch(`/admissions/${id}/approve`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            alert('An error occurred');
            console.error(error);
        });
    }
}

function rejectAdmission(id) {
    const remarks = prompt('Reason for rejection:');
    if (remarks) {
        fetch(`/admissions/${id}/reject`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ remarks: remarks })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            alert('An error occurred');
            console.error(error);
        });
    }
}
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
