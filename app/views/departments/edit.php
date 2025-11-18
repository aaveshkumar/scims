<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-diagram-3 me-2"></i>Edit Department</h2>
    <a href="/departments" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back to Departments
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Department Information</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="/departments/<?= $department['id'] ?>">
                    <?= csrf_field() ?>
                    
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label">Department Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($department['name']) ?>" required>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Department Code <span class="text-danger">*</span></label>
                            <input type="text" name="code" class="form-control" value="<?= htmlspecialchars($department['code'] ?? '') ?>" required>
                            <small class="form-text text-muted">Will be auto-uppercased</small>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($department['description'] ?? '') ?></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Department Head</label>
                            <select name="head_id" class="form-select">
                                <option value="">Select Department Head</option>
                                <?php if (!empty($staff)): ?>
                                    <?php foreach ($staff as $s): ?>
                                        <option value="<?= $s['id'] ?>" <?= ($department['head_id'] ?? null) == $s['id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($s['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="active" <?= ($department['status'] ?? '') === 'active' ? 'selected' : '' ?>>Active</option>
                                <option value="inactive" <?= ($department['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                            </select>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>Update Department
                        </button>
                        <a href="/departments" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Department Details</h6>
            </div>
            <div class="card-body">
                <p class="mb-2"><strong>Created:</strong><br><?= date('M d, Y g:i A', strtotime($department['created_at'])) ?></p>
                <p class="mb-0"><strong>Last Updated:</strong><br><?= date('M d, Y g:i A', strtotime($department['updated_at'])) ?></p>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
