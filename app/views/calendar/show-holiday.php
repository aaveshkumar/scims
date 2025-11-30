<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0"><?= htmlspecialchars($holiday['name']) ?></h1>
        <p class="text-muted mb-0">Created by <?= htmlspecialchars($holiday['creator_name']) ?></p>
    </div>
    <div>
        <a href="/calendar/holidays/<?= $holiday['id'] ?>/edit" class="btn btn-warning me-2">
            <i class="bi bi-pencil me-2"></i>Edit
        </a>
        <form method="POST" action="/calendar/holidays/<?= $holiday['id'] ?>/delete" style="display: inline;" onsubmit="return confirm('Delete this holiday?');">
            <input type="hidden" name="_token" value="<?= csrf() ?>">
            <button type="submit" class="btn btn-danger me-2">
                <i class="bi bi-trash me-2"></i>Delete
            </button>
        </form>
        <a href="/calendar/holidays" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Holiday Information</h5>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="fw-bold text-muted">Start Date</label>
                <p><?= date('M d, Y', strtotime($holiday['start_date'])) ?></p>
            </div>
            <div class="col-md-6">
                <label class="fw-bold text-muted">End Date</label>
                <p><?= date('M d, Y', strtotime($holiday['end_date'])) ?></p>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="fw-bold text-muted">Type</label>
                <p><span class="badge bg-secondary"><?= ucfirst(htmlspecialchars($holiday['holiday_type'] ?? 'holiday')) ?></span></p>
            </div>
            <div class="col-md-6">
                <label class="fw-bold text-muted">Status</label>
                <p><span class="badge bg-<?= $holiday['status'] === 'active' ? 'success' : 'secondary' ?>"><?= ucfirst($holiday['status']) ?></span></p>
            </div>
        </div>
    </div>
</div>

<?php if (!empty($holiday['description'])): ?>
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Description</h5>
        </div>
        <div class="card-body">
            <p><?= nl2br(htmlspecialchars($holiday['description'])) ?></p>
        </div>
    </div>
<?php endif; ?>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
