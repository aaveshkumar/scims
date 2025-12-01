<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="row">
    <div class="col-md-10 mx-auto">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="bi bi-reply-fill me-2"></i>Reply to Support Message</h2>
            <a href="/support" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back
            </a>
        </div>

        <!-- Original Message -->
        <div class="card mb-3">
            <div class="card-header bg-light">
                <h6 class="mb-0"><i class="bi bi-person me-2"></i><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></h6>
                <small class="text-muted"><?= htmlspecialchars($user['email']) ?></small>
            </div>
            <div class="card-body">
                <h5><?= htmlspecialchars($message['subject']) ?></h5>
                <p><?= nl2br(htmlspecialchars($message['message'])) ?></p>
            </div>
        </div>

        <!-- Reply Form -->
        <div class="card">
            <div class="card-body">
                <form method="POST" action="/support/<?= $message['id'] ?>/reply">
                    <?= csrf_field() ?>
                    
                    <div class="mb-3">
                        <label class="form-label">Your Reply *</label>
                        <textarea name="admin_reply" class="form-control" rows="8" required 
                                  placeholder="Type your response here..."><?= htmlspecialchars($_POST['admin_reply'] ?? '') ?></textarea>
                        <?php if (isset($errors['admin_reply'])): ?>
                            <div class="text-danger small mt-1"><?= $errors['admin_reply'][0] ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send me-2"></i>Send Reply
                        </button>
                        <a href="/support" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
