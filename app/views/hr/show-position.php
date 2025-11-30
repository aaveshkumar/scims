<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0"><?= htmlspecialchars($position['title']) ?></h1>
        <p class="text-muted mb-0"><?= htmlspecialchars($position['department']) ?> Department</p>
    </div>
    <div>
        <a href="/hr/recruitment/<?= $position['id'] ?>/edit" class="btn btn-warning me-2">
            <i class="bi bi-pencil me-2"></i>Edit
        </a>
        <form method="POST" action="/hr/recruitment/<?= $position['id'] ?>/delete" style="display: inline;" onsubmit="return confirm('Delete this position?');">
            <input type="hidden" name="_token" value="<?= csrf() ?>">
            <button type="submit" class="btn btn-danger me-2">
                <i class="bi bi-trash me-2"></i>Delete
            </button>
        </form>
        <a href="/hr/recruitment" class="btn btn-secondary">Back</a>
    </div>
</div>

<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card">
            <div class="card-body">
                <label class="fw-bold text-muted">Vacancies</label>
                <h3><?= $position['number_of_positions'] ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card">
            <div class="card-body">
                <label class="fw-bold text-muted">Status</label>
                <p><span class="badge bg-<?= $position['status'] === 'open' ? 'success' : ($position['status'] === 'closed' ? 'danger' : 'secondary') ?>"><?= ucfirst($position['status']) ?></span></p>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-body">
                <label class="fw-bold text-muted">Posted By</label>
                <p><?= htmlspecialchars($position['created_by_name']) ?></p>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Description</h5>
    </div>
    <div class="card-body">
        <p><?= nl2br(htmlspecialchars($position['description'] ?? 'Not provided')) ?></p>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Requirements</h5>
    </div>
    <div class="card-body">
        <p><?= nl2br(htmlspecialchars($position['requirements'] ?? 'Not specified')) ?></p>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
