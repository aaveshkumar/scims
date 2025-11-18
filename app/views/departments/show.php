<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-diagram-3 me-2"></i>Department Details</h2>
    <div>
        <a href="/departments/<?= $department['id'] ?>/edit" class="btn btn-warning">
            <i class="bi bi-pencil me-2"></i>Edit
        </a>
        <a href="/departments" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Department Information</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Department Name:</strong>
                    </div>
                    <div class="col-md-8">
                        <?= htmlspecialchars($department['name']) ?>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Department Code:</strong>
                    </div>
                    <div class="col-md-8">
                        <span class="badge bg-secondary"><?= htmlspecialchars($department['code'] ?? 'N/A') ?></span>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Department Head:</strong>
                    </div>
                    <div class="col-md-8">
                        <?php if ($department['head_name']): ?>
                            <?= htmlspecialchars($department['head_name']) ?><br>
                            <small class="text-muted"><?= htmlspecialchars($department['head_email'] ?? '') ?></small>
                        <?php else: ?>
                            <em class="text-muted">No head assigned</em>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Status:</strong>
                    </div>
                    <div class="col-md-8">
                        <?php if ($department['status'] === 'active'): ?>
                            <span class="badge bg-success">Active</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Inactive</span>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Description:</strong>
                    </div>
                    <div class="col-md-8">
                        <?= $department['description'] ? htmlspecialchars($department['description']) : '<em class="text-muted">No description provided</em>' ?>
                    </div>
                </div>
                
                <hr>
                
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Created:</strong>
                    </div>
                    <div class="col-md-8">
                        <?= date('F d, Y g:i A', strtotime($department['created_at'])) ?>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4">
                        <strong>Last Updated:</strong>
                    </div>
                    <div class="col-md-8">
                        <?= date('F d, Y g:i A', strtotime($department['updated_at'])) ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">Staff Members in this Department</h5>
            </div>
            <div class="card-body">
                <?php if (empty($staff)): ?>
                    <p class="text-muted mb-0">No staff members assigned to this department.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Employee ID</th>
                                    <th>Designation</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($staff as $member): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($member['name']) ?></td>
                                        <td><?= htmlspecialchars($member['employee_id'] ?? 'N/A') ?></td>
                                        <td><?= htmlspecialchars($member['designation'] ?? 'N/A') ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <p class="text-muted small mb-0 mt-2">Total: <?= count($staff) ?> staff member(s)</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card border-danger">
            <div class="card-header bg-danger text-white">
                <h6 class="mb-0"><i class="bi bi-exclamation-triangle me-2"></i>Danger Zone</h6>
            </div>
            <div class="card-body">
                <p class="small">Deleting this department is permanent and cannot be undone.</p>
                <form method="POST" action="/departments/<?= $department['id'] ?>/delete" onsubmit="return confirm('Are you absolutely sure you want to delete this department? This action cannot be undone.');">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-danger w-100" <?= !empty($staff) ? 'disabled title="Cannot delete - staff are assigned to this department"' : '' ?>>
                        <i class="bi bi-trash me-2"></i>Delete Department
                    </button>
                </form>
                <?php if (!empty($staff)): ?>
                    <small class="text-danger d-block mt-2">Cannot delete: <?= count($staff) ?> staff member(s) assigned</small>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
