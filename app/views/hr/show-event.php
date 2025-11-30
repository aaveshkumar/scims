<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0"><?= htmlspecialchars($event['title']) ?></h1>
        <p class="text-muted mb-0">Created by <?= htmlspecialchars($event['creator_name']) ?></p>
    </div>
    <div>
        <a href="/hr/events/<?= $event['id'] ?>/edit" class="btn btn-warning me-2">
            <i class="bi bi-pencil me-2"></i>Edit
        </a>
        <form method="POST" action="/hr/events/<?= $event['id'] ?>/delete" style="display: inline;" onsubmit="return confirm('Delete this event?');">
            <input type="hidden" name="_token" value="<?= csrf() ?>">
            <button type="submit" class="btn btn-danger me-2">
                <i class="bi bi-trash me-2"></i>Delete
            </button>
        </form>
        <a href="/hr/events" class="btn btn-secondary">Back</a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Event Information</h5>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="fw-bold text-muted">Date</label>
                <p><?= date('M d, Y', strtotime($event['event_date'])) ?></p>
            </div>
            <div class="col-md-6">
                <label class="fw-bold text-muted">Type</label>
                <p><span class="badge bg-info"><?= ucfirst($event['event_type']) ?></span></p>
            </div>
        </div>
        <div class="mb-3">
            <label class="fw-bold text-muted">Location</label>
            <p><?= htmlspecialchars($event['location'] ?? 'Not specified') ?></p>
        </div>
        <?php if (!empty($event['description'])): ?>
            <div>
                <label class="fw-bold text-muted">Description</label>
                <p><?= nl2br(htmlspecialchars($event['description'])) ?></p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
