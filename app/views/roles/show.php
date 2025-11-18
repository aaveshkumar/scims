<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-shield-check me-2"></i>Role Details</h2>
    <div>
        <a href="/roles/<?= $role['id'] ?>/edit" class="btn btn-warning">
            <i class="bi bi-pencil me-2"></i>Edit
        </a>
        <a href="/roles" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Role Information</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Role Name:</strong>
                    </div>
                    <div class="col-md-8">
                        <span class="badge bg-primary"><?= htmlspecialchars($role['name']) ?></span>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Display Name:</strong>
                    </div>
                    <div class="col-md-8">
                        <?= htmlspecialchars($role['display_name']) ?>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Description:</strong>
                    </div>
                    <div class="col-md-8">
                        <?= $role['description'] ? htmlspecialchars($role['description']) : '<em class="text-muted">No description provided</em>' ?>
                    </div>
                </div>
                
                <hr>
                
                <div class="row mb-3">
                    <div class="col-md-4">
                        <strong>Created:</strong>
                    </div>
                    <div class="col-md-8">
                        <?= date('F d, Y g:i A', strtotime($role['created_at'])) ?>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4">
                        <strong>Last Updated:</strong>
                    </div>
                    <div class="col-md-8">
                        <?= date('F d, Y g:i A', strtotime($role['updated_at'])) ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">Users with this Role</h5>
            </div>
            <div class="card-body">
                <?php if (empty($users)): ?>
                    <p class="text-muted mb-0">No users assigned to this role.</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($user['name']) ?></td>
                                        <td><?= htmlspecialchars($user['email']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <p class="text-muted small mb-0 mt-2">Total: <?= count($users) ?> user(s)</p>
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
                <p class="small">Deleting this role is permanent and cannot be undone.</p>
                <form method="POST" action="/roles/<?= $role['id'] ?>/delete" onsubmit="return confirm('Are you absolutely sure you want to delete this role? This action cannot be undone.');">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-danger w-100" <?= !empty($users) ? 'disabled title="Cannot delete - users are assigned to this role"' : '' ?>>
                        <i class="bi bi-trash me-2"></i>Delete Role
                    </button>
                </form>
                <?php if (!empty($users)): ?>
                    <small class="text-danger d-block mt-2">Cannot delete: <?= count($users) ?> user(s) assigned</small>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
