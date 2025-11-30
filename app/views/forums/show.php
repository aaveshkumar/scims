<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0"><?= htmlspecialchars($forum['title']) ?></h1>
        <p class="text-muted mb-0">Created by <?= htmlspecialchars($forum['creator_name']) ?></p>
    </div>
    <div>
        <a href="/forums/<?= $forum['id'] ?>/edit" class="btn btn-warning me-2">
            <i class="bi bi-pencil me-2"></i>Edit
        </a>
        <form method="POST" action="/forums/<?= $forum['id'] ?>/delete" style="display: inline;" onsubmit="return confirm('Delete this forum?');">
            <input type="hidden" name="_token" value="<?= csrf() ?>">
            <button type="submit" class="btn btn-danger me-2">
                <i class="bi bi-trash me-2"></i>Delete
            </button>
        </form>
        <a href="/forums" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Forum Information</h5>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="fw-bold text-muted">Subject</label>
                <p><?= htmlspecialchars($forum['subject_name'] ?? 'General') ?></p>
            </div>
            <div class="col-md-6">
                <label class="fw-bold text-muted">Class</label>
                <p><?= htmlspecialchars($forum['class_name'] ?? 'All') ?></p>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="fw-bold text-muted">Status</label>
                <p><span class="badge bg-<?= $forum['status'] === 'active' ? 'success' : 'secondary' ?>"><?= ucfirst($forum['status']) ?></span></p>
            </div>
            <div class="col-md-6">
                <label class="fw-bold text-muted">Created</label>
                <p><?= date('M d, Y h:i A', strtotime($forum['created_at'])) ?></p>
            </div>
        </div>
    </div>
</div>

<?php if (!empty($forum['description'])): ?>
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Description</h5>
        </div>
        <div class="card-body">
            <p><?= nl2br(htmlspecialchars($forum['description'])) ?></p>
        </div>
    </div>
<?php endif; ?>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
