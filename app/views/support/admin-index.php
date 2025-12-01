<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-headset me-2"></i>Support Tickets - Admin</h2>
    <a href="/dashboard" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Dashboard
    </a>
</div>

<!-- Status Summary -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-warning"><?= count(array_filter($messages, fn($m) => $m['status'] == 'open')) ?></h3>
                <p class="mb-0"><i class="bi bi-exclamation-circle me-2"></i>Open</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-info"><?= count(array_filter($messages, fn($m) => $m['status'] == 'replied')) ?></h3>
                <p class="mb-0"><i class="bi bi-chat-dots me-2"></i>Replied</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-success"><?= count(array_filter($messages, fn($m) => $m['status'] == 'resolved')) ?></h3>
                <p class="mb-0"><i class="bi bi-check-circle me-2"></i>Resolved</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3><?= count($messages) ?></h3>
                <p class="mb-0"><i class="bi bi-chat-left-text me-2"></i>Total</p>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Replied</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($messages)): ?>
                        <?php foreach ($messages as $index => $msg): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td>
                                    <?php 
                                    $userModel = new User();
                                    $user = $userModel->find($msg['user_id']);
                                    if ($user): ?>
                                        <strong><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></strong><br>
                                        <small class="text-muted"><?= htmlspecialchars($user['email']) ?></small>
                                    <?php else: ?>
                                        <em>Unknown User</em>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars(substr($msg['subject'], 0, 40)) ?></td>
                                <td>
                                    <span class="badge bg-<?= $msg['status'] == 'open' ? 'warning' : ($msg['status'] == 'replied' ? 'info' : 'success') ?>">
                                        <?= ucfirst($msg['status']) ?>
                                    </span>
                                </td>
                                <td><small><?= date('M d, Y', strtotime($msg['created_at'])) ?></small></td>
                                <td>
                                    <?php if ($msg['replied_at']): ?>
                                        <small><?= date('M d, Y', strtotime($msg['replied_at'])) ?></small>
                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="/support/<?= $msg['id'] ?>" class="btn btn-sm btn-info" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <?php if ($msg['status'] !== 'resolved'): ?>
                                    <a href="/support/<?= $msg['id'] ?>/reply" class="btn btn-sm btn-primary" title="Reply">
                                        <i class="bi bi-reply"></i>
                                    </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                No support messages.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
