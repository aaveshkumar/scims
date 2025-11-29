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
                                            <?php if (hasRole('admin')): ?>
                                                <button type="button" class="btn btn-outline-success btn-sm" title="Approve" data-bs-toggle="modal" data-bs-target="#approveModal<?= $leave['id'] ?>">
                                                    <i class="bi bi-check-circle"></i>
                                                </button>
                                                <button type="button" class="btn btn-outline-warning btn-sm" title="Reject" data-bs-toggle="modal" data-bs-target="#rejectModal<?= $leave['id'] ?>">
                                                    <i class="bi bi-x-circle"></i>
                                                </button>
                                            <?php else: ?>
                                                <a href="/leave/<?= $leave['id'] ?>/edit" class="btn btn-outline-secondary btn-sm" title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                            <?php endif; ?>
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

<!-- Admin Approval/Rejection Modals -->
<?php if (hasRole('admin') && !empty($leaves)): ?>
    <?php foreach ($leaves as $leave): ?>
        <?php if ($leave['status'] === 'pending'): ?>
            <!-- Approve Modal -->
            <div class="modal fade" id="approveModal<?= $leave['id'] ?>" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Approve Leave Request</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form method="POST" action="/leave/<?= $leave['id'] ?>/approve">
                            <?= csrf_field() ?>
                            <div class="modal-body">
                                <p class="text-muted mb-3">Approving leave request for <strong><?php 
                                    $user = db()->fetchOne("SELECT first_name, last_name FROM users WHERE id = ?", [(int)$leave['user_id']]);
                                    echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']);
                                ?></strong></p>
                                <div class="mb-3">
                                    <label class="form-label">Remarks (Optional)</label>
                                    <textarea name="remarks" class="form-control" rows="3" placeholder="Add any remarks..."></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-check-circle me-2"></i>Approve
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Reject Modal -->
            <div class="modal fade" id="rejectModal<?= $leave['id'] ?>" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Reject Leave Request</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form method="POST" action="/leave/<?= $leave['id'] ?>/reject">
                            <?= csrf_field() ?>
                            <div class="modal-body">
                                <p class="text-muted mb-3">Rejecting leave request for <strong><?php 
                                    $user = db()->fetchOne("SELECT first_name, last_name FROM users WHERE id = ?", [(int)$leave['user_id']]);
                                    echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']);
                                ?></strong></p>
                                <div class="mb-3">
                                    <label class="form-label">Remarks (Required)</label>
                                    <textarea name="remarks" class="form-control" rows="3" placeholder="Reason for rejection..." required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-warning">
                                    <i class="bi bi-x-circle me-2"></i>Reject
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>

<?php include __DIR__ . '/../layouts/footer.php'; ?>