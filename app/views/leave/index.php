<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-calendar-x me-2"></i>Leave Management</h2>
    <a href="/leave/create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Request Leave
    </a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="/leave" class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Filter by Status</label>
                <select name="status" class="form-select" onchange="this.form.submit()">
                    <option value="">All Status</option>
                    <option value="pending" <?= ($currentStatus == 'pending') ? 'selected' : '' ?>>Pending</option>
                    <option value="approved" <?= ($currentStatus == 'approved') ? 'selected' : '' ?>>Approved</option>
                    <option value="rejected" <?= ($currentStatus == 'rejected') ? 'selected' : '' ?>>Rejected</option>
                </select>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Leave Type</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Reason</th>
                        <th>Status</th>
                        <th>Applied Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($leaves)): ?>
                        <?php foreach ($leaves as $key => $leave): ?>
                            <tr>
                                <td><?= $key + 1 ?></td>
                                <td>
                                    <span class="badge bg-info"><?= ucfirst(str_replace('_', ' ', $leave['leave_type'])) ?></span>
                                </td>
                                <td><?= date('d M Y', strtotime($leave['start_date'])) ?></td>
                                <td><?= date('d M Y', strtotime($leave['end_date'])) ?></td>
                                <td><?= htmlspecialchars(substr($leave['reason'], 0, 50) . (strlen($leave['reason']) > 50 ? '...' : '')) ?></td>
                                <td>
                                    <?php 
                                    $statusClass = $leave['status'] === 'approved' ? 'success' : ($leave['status'] === 'rejected' ? 'danger' : 'warning');
                                    ?>
                                    <span class="badge bg-<?= $statusClass ?>"><?= ucfirst($leave['status']) ?></span>
                                </td>
                                <td><?= date('d M Y', strtotime($leave['created_at'])) ?></td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="/leave/<?= $leave['id'] ?>" class="btn btn-outline-primary" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <?php if ($leave['status'] === 'pending'): ?>
                                            <a href="/leave/<?= $leave['id'] ?>/edit" class="btn btn-outline-secondary" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <form method="POST" action="/leave/<?= $leave['id'] ?>" style="display:inline;" onsubmit="return confirm('Delete this leave request?');">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" class="btn btn-outline-danger btn-sm" title="Delete">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                No leave requests found. Click "Request Leave" to get started.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>