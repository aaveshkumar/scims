<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-diagram-3 me-2"></i>Create New Department</h2>
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
                <form method="POST" action="/departments">
                    <?= csrf_field() ?>
                    
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label">Department Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" placeholder="e.g., Computer Science, Mathematics" required>
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Department Code <span class="text-danger">*</span></label>
                            <input type="text" name="code" class="form-control" placeholder="e.g., CS, MATH" required>
                            <small class="form-text text-muted">Will be auto-uppercased</small>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="4" placeholder="Describe the department's scope and activities..."></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Department Head</label>
                            <select name="head_id" class="form-select">
                                <option value="">Select Department Head</option>
                                <?php if (!empty($staff)): ?>
                                    <?php foreach ($staff as $s): ?>
                                        <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['name']) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>Create Department
                        </button>
                        <a href="/departments" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card bg-light">
            <div class="card-body">
                <h6 class="card-title"><i class="bi bi-info-circle me-2"></i>Important Notes</h6>
                <ul class="small mb-0">
                    <li>Department codes should be unique and short (2-6 characters)</li>
                    <li>Codes are automatically converted to uppercase</li>
                    <li>Department heads must be active staff members</li>
                    <li>Inactive departments are hidden from most operations</li>
                </ul>
            </div>
        </div>
        
        <div class="card mt-3 border-primary">
            <div class="card-body">
                <h6 class="card-title text-primary"><i class="bi bi-lightbulb me-2"></i>Examples</h6>
                <div class="small">
                    <div class="mb-2">
                        <strong>Name:</strong> Computer Science<br>
                        <strong>Code:</strong> CS
                    </div>
                    <div class="mb-2">
                        <strong>Name:</strong> English & Literature<br>
                        <strong>Code:</strong> ENG
                    </div>
                    <div>
                        <strong>Name:</strong> Physical Education<br>
                        <strong>Code:</strong> PE
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
