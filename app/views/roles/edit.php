<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-shield-check me-2"></i>Edit Role</h2>
    <a href="/roles" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back to Roles
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Role Information</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="/roles/<?= $role['id'] ?>">
                    <?= csrf_field() ?>
                    
                    <div class="mb-3">
                        <label class="form-label">Role Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($role['name']) ?>" required>
                        <small class="form-text text-muted">Lowercase with underscores. Will be auto-formatted.</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Display Name <span class="text-danger">*</span></label>
                        <input type="text" name="display_name" class="form-control" value="<?= htmlspecialchars($role['display_name']) ?>" required>
                        <small class="form-text text-muted">Human-readable name shown in the interface.</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($role['description'] ?? '') ?></textarea>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>Update Role
                        </button>
                        <a href="/roles" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Role Details</h6>
            </div>
            <div class="card-body">
                <p class="mb-2"><strong>Created:</strong><br><?= date('M d, Y g:i A', strtotime($role['created_at'])) ?></p>
                <p class="mb-0"><strong>Last Updated:</strong><br><?= date('M d, Y g:i A', strtotime($role['updated_at'])) ?></p>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
