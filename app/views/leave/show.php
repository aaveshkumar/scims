<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-calendar-x me-2"></i>Leave Request Details</h2>
    <a href="/leave" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Leave Information</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label text-muted">Leave Type</label>
                        <p class="fs-6 fw-500">
                            <span class="badge bg-info"><?= ucfirst(str_replace('_', ' ', $leave['leave_type'])) ?></span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">Status</label>
                        <p class="fs-6 fw-500">
                            <?php 
                            $statusClass = $leave['status'] === 'approved' ? 'success' : ($leave['status'] === 'rejected' ? 'danger' : 'warning');
                            ?>
                            <span class="badge bg-<?= $statusClass ?>"><?= ucfirst($leave['status']) ?></span>
                        </p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label text-muted">Start Date</label>
                        <p class="fs-6 fw-500"><?= date('d M Y', strtotime($leave['start_date'])) ?></p>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted">End Date</label>
                        <p class="fs-6 fw-500"><?= date('d M Y', strtotime($leave['end_date'])) ?></p>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted">Reason for Leave</label>
                    <p class="fs-6 fw-500"><?= htmlspecialchars($leave['reason']) ?></p>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted">Applied On</label>
                    <p class="fs-6 fw-500"><?= date('d M Y, H:i A', strtotime($leave['created_at'])) ?></p>
                </div>

                <?php if ($leave['status'] !== 'pending'): ?>
                    <hr>
                    <?php if ($leave['approved_by']): ?>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label text-muted">Approved By</label>
                                <p class="fs-6 fw-500">
                                    <?php 
                                    $approver = db()->fetchOne("SELECT first_name, last_name FROM users WHERE id = ?", [(int)$leave['approved_by']]);
                                    echo htmlspecialchars($approver['first_name'] . ' ' . $approver['last_name']);
                                    ?>
                                </p>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($leave['remarks']): ?>
                        <div class="mb-3">
                            <label class="form-label text-muted">Remarks</label>
                            <p class="fs-6 fw-500"><?= htmlspecialchars($leave['remarks']) ?></p>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>

        <?php if ($leave['status'] === 'pending'): ?>
            <div class="mt-3">
                <a href="/leave/<?= $leave['id'] ?>/edit" class="btn btn-primary">
                    <i class="bi bi-pencil me-2"></i>Edit Request
                </a>
                <form method="POST" action="/leave/<?= $leave['id'] ?>" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this leave request?');">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash me-2"></i>Delete Request
                    </button>
                </form>
            </div>

            <?php if (hasRole('admin')): ?>
                <div class="mt-4 border-top pt-4">
                    <h5 class="mb-3">Admin Actions</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <button type="button" class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#approveModal">
                                <i class="bi bi-check-circle me-2"></i>Approve Request
                            </button>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn btn-warning w-100" data-bs-toggle="modal" data-bs-target="#rejectModal">
                                <i class="bi bi-x-circle me-2"></i>Reject Request
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Approve Modal -->
                <div class="modal fade" id="approveModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Approve Leave Request</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form method="POST" action="/leave/<?= $leave['id'] ?>/approve">
                                <?= csrf_field() ?>
                                <div class="modal-body">
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
                <div class="modal fade" id="rejectModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Reject Leave Request</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form method="POST" action="/leave/<?= $leave['id'] ?>/reject">
                                <?= csrf_field() ?>
                                <div class="modal-body">
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
        <?php endif; ?>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Summary</h5>
            </div>
            <div class="card-body">
                <p class="text-muted mb-2">
                    <i class="bi bi-calendar-check me-2"></i>
                    <strong><?php 
                        $start = new DateTime($leave['start_date']);
                        $end = new DateTime($leave['end_date']);
                        $interval = $start->diff($end);
                        $days = $interval->days + 1;
                        echo $days . ' Day' . ($days != 1 ? 's' : '');
                    ?></strong>
                </p>
                <p class="text-muted mb-2">
                    <i class="bi bi-calendar3 me-2"></i>
                    <strong><?= ucfirst(str_replace('_', ' ', $leave['leave_type'])) ?></strong>
                </p>
                <p class="text-muted">
                    <i class="bi bi-hourglass-split me-2"></i>
                    <strong><?= ucfirst($leave['status']) ?></strong>
                </p>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
