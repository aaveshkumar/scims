<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Edit Recruitment Position</h1>
        <p class="text-muted mb-0">Update position details</p>
    </div>
    <a href="/hr/recruitment" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="/hr/recruitment/<?= $position['id'] ?>/edit">
            <input type="hidden" name="_token" value="<?= csrf() ?>">
            
            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-briefcase me-2"></i>Position Details
                </h6>
                <div class="mb-3">
                    <label class="form-label fw-bold">Job Title *</label>
                    <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($position['title']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Department *</label>
                    <input type="text" name="department" class="form-control" value="<?= htmlspecialchars($position['department']) ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Description</label>
                    <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($position['description'] ?? '') ?></textarea>
                </div>
            </div>

            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-list-check me-2"></i>Requirements
                </h6>
                <div class="mb-3">
                    <label class="form-label fw-bold">Requirements</label>
                    <textarea name="requirements" class="form-control" rows="3"><?= htmlspecialchars($position['requirements'] ?? '') ?></textarea>
                </div>
            </div>

            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-gear me-2"></i>Settings
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Number of Positions *</label>
                        <input type="number" name="number_of_positions" class="form-control" value="<?= $position['number_of_positions'] ?>" min="1" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Status</label>
                        <select name="status" class="form-select">
                            <option value="open" <?= $position['status'] === 'open' ? 'selected' : '' ?>>Open</option>
                            <option value="closed" <?= $position['status'] === 'closed' ? 'selected' : '' ?>>Closed</option>
                            <option value="on_hold" <?= $position['status'] === 'on_hold' ? 'selected' : '' ?>>On Hold</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Update Position
                </button>
                <a href="/hr/recruitment" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
