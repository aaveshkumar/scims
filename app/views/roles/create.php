<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-shield-check me-2"></i>Create New Role</h2>
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
                <form method="POST" action="/roles">
                    <?= csrf_field() ?>
                    
                    <div class="mb-3">
                        <label class="form-label">Role Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="e.g., administrator, teacher, student" required>
                        <small class="form-text text-muted">Lowercase with underscores. Will be auto-formatted.</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Display Name <span class="text-danger">*</span></label>
                        <input type="text" name="display_name" class="form-control" placeholder="e.g., Administrator, Teacher, Student" required>
                        <small class="form-text text-muted">Human-readable name shown in the interface.</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="4" placeholder="Describe the role's purpose and permissions..."></textarea>
                    </div>
                    
                    <hr class="my-4">
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>Create Role
                        </button>
                        <a href="/roles" class="btn btn-secondary">Cancel</a>
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
                    <li>Role names should be unique and descriptive</li>
                    <li>Use lowercase with underscores for role names</li>
                    <li>Display names are shown to users in the interface</li>
                    <li>Descriptions help clarify the role's purpose</li>
                </ul>
            </div>
        </div>
        
        <div class="card mt-3 border-primary">
            <div class="card-body">
                <h6 class="card-title text-primary"><i class="bi bi-lightbulb me-2"></i>Examples</h6>
                <div class="small">
                    <div class="mb-2">
                        <strong>Name:</strong> <code>super_admin</code><br>
                        <strong>Display:</strong> Super Administrator
                    </div>
                    <div class="mb-2">
                        <strong>Name:</strong> <code>class_teacher</code><br>
                        <strong>Display:</strong> Class Teacher
                    </div>
                    <div>
                        <strong>Name:</strong> <code>parent</code><br>
                        <strong>Display:</strong> Parent/Guardian
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
