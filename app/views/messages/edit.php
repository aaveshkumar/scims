<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-reply me-2"></i>Reply to Message</h2>
    <a href="/messages" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card mb-3">
    <div class="card-header">
        <h6 class="mb-0">Original Message</h6>
    </div>
    <div class="card-body" style="background-color: #f8f9fa;">
        <h6><?= htmlspecialchars($message['subject']) ?></h6>
        <p class="mb-0"><?= nl2br(htmlspecialchars($message['message_body'])) ?></p>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="/messages/<?= $message['id'] ?>" data-no-loader>
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="PUT">
            
            <div class="mb-3">
                <label class="form-label">To *</label>
                <select name="receiver_id" class="form-select" required>
                    <option value="">Select recipient</option>
                    <?php foreach ($users as $user): ?>
                        <option value="<?= $user['id'] ?>" <?= $user['id'] == $message['receiver_id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Subject *</label>
                <input type="text" name="subject" class="form-control" required value="<?= htmlspecialchars($message['subject']) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Message *</label>
                <textarea name="message_body" class="form-control" rows="8" required><?= htmlspecialchars($message['message_body']) ?></textarea>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-send me-2"></i>Send Reply
                </button>
                <a href="/messages" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
