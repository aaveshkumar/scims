<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-envelope-open me-2"></i><?= htmlspecialchars($message['subject']) ?></h2>
    <a href="/messages" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h6 class="mb-0">From: <strong><?= htmlspecialchars($sender['first_name'] . ' ' . $sender['last_name']) ?></strong></h6>
                        <small class="text-muted"><?= htmlspecialchars($sender['email']) ?></small>
                    </div>
                    <small class="text-muted"><?= date('M d, Y h:i A', strtotime($message['created_at'])) ?></small>
                </div>
            </div>
            <div class="card-body">
                <p><?= nl2br(htmlspecialchars($message['message_body'])) ?></p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Details</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted">Status</small>
                    <p>
                        <?php if ($message['is_read']): ?>
                            <span class="badge bg-success">Read</span>
                        <?php else: ?>
                            <span class="badge bg-primary">Unread</span>
                        <?php endif; ?>
                    </p>
                </div>
                <div class="mb-3">
                    <small class="text-muted">To</small>
                    <p><?= htmlspecialchars($receiver['first_name'] . ' ' . $receiver['last_name']) ?></p>
                </div>
                <?php if ($message['read_at']): ?>
                <div class="mb-3">
                    <small class="text-muted">Read At</small>
                    <p><?= date('M d, Y h:i A', strtotime($message['read_at'])) ?></p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="d-flex gap-2 mt-3">
            <a href="/messages/<?= $message['id'] ?>/edit" class="btn btn-primary w-100">
                <i class="bi bi-reply me-2"></i>Reply
            </a>
            <button onclick="confirmDelete('/messages/<?= $message['id'] ?>', 'Delete this message?')" class="btn btn-danger w-100">
                <i class="bi bi-trash me-2"></i>Delete
            </button>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
