<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-shield-check me-2"></i>Roles & Permissions</h2>
    <a href="/roles/create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Add New Role
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="GET" action="/roles" class="mb-3">
            <div class="row">
                <div class="col-md-9">
                    <input type="text" name="search" class="form-control" placeholder="Search roles..." value="<?= htmlspecialchars($filters['search'] ?? '') ?>">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-2"></i>Search
                    </button>
                </div>
            </div>
        </form>
        
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Display Name</th>
                        <th>Description</th>
                        <th>Created</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($roles)): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                No roles found. Click "Add New Role" to get started.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($roles as $index => $role): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><span class="badge bg-primary"><?= htmlspecialchars($role['name']) ?></span></td>
                                <td><?= htmlspecialchars($role['display_name']) ?></td>
                                <td><?= htmlspecialchars(substr($role['description'] ?? '', 0, 50)) ?><?= strlen($role['description'] ?? '') > 50 ? '...' : '' ?></td>
                                <td><?= date('M d, Y', strtotime($role['created_at'])) ?></td>
                                <td class="text-end">
                                    <a href="/roles/<?= $role['id'] ?>" class="btn btn-sm btn-info" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="/roles/<?= $role['id'] ?>/edit" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" action="/roles/<?= $role['id'] ?>/delete" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this role?');">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <?php if (!empty($roles)): ?>
            <div class="mt-3 text-muted">
                <small>Total: <?= count($roles) ?> role(s)</small>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
