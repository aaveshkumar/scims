<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="row">
    <div class="col-md-10 mx-auto">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="bi bi-envelope-open me-2"></i>Message Details</h2>
            <a href="/support" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back
            </a>
        </div>

        <!-- Original Message -->
        <div class="card mb-3">
            <div class="card-header bg-light">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="mb-0"><i class="bi bi-person me-2"></i><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></h6>
                        <small class="text-muted"><?= htmlspecialchars($user['email']) ?></small>
                    </div>
                    <div class="col-md-6 text-end">
                        <span class="badge bg-<?= $message['status'] == 'open' ? 'warning' : ($message['status'] == 'replied' ? 'info' : 'success') ?>">
                            <?= ucfirst($message['status']) ?>
                        </span>
                        <br>
                        <small class="text-muted"><?= date('M d, Y h:i A', strtotime($message['created_at'])) ?></small>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <h5><?= htmlspecialchars($message['subject']) ?></h5>
                <p><?= nl2br(htmlspecialchars($message['message'])) ?></p>
            </div>
        </div>

        <!-- Admin Reply -->
        <?php if ($message['admin_reply']): ?>
        <div class="card mb-3" style="border-left: 4px solid #0d6efd;">
            <div class="card-header bg-light">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="mb-0"><i class="bi bi-shield-check me-2"></i>Admin Reply</h6>
                        <small class="text-muted"><?= htmlspecialchars($admin['first_name'] . ' ' . $admin['last_name']) ?></small>
                    </div>
                    <div class="col-md-6 text-end">
                        <small class="text-muted"><?= date('M d, Y h:i A', strtotime($message['replied_at'])) ?></small>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <p><?= nl2br(htmlspecialchars($message['admin_reply'])) ?></p>
            </div>
        </div>
        <?php else: ?>
        <div class="alert alert-info">
            <i class="bi bi-hourglass me-2"></i>
            <strong>Pending Admin Response</strong> - Your message is awaiting admin review.
        </div>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
