<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-diagram-3 me-2"></i>Departments</h2>
    <a href="/departments/create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Add New Department
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="GET" action="/departments" class="mb-3">
            <div class="row">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="Search departments..." value="<?= htmlspecialchars($filters['search'] ?? '') ?>">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="active" <?= ($filters['status'] ?? '') === 'active' ? 'selected' : '' ?>>Active</option>
                        <option value="inactive" <?= ($filters['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                    </select>
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
                        <th>Code</th>
                        <th>Name</th>
                        <th>Department Head</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($departments)): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                No departments found. Click "Add New Department" to get started.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($departments as $index => $dept): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><span class="badge bg-secondary"><?= htmlspecialchars($dept['code'] ?? 'N/A') ?></span></td>
                                <td><strong><?= htmlspecialchars($dept['name']) ?></strong></td>
                                <td><?= htmlspecialchars($dept['head_name'] ?? '-') ?></td>
                                <td>
                                    <?php if ($dept['status'] === 'active'): ?>
                                        <span class="badge bg-success">Active</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= date('M d, Y', strtotime($dept['created_at'])) ?></td>
                                <td class="text-end">
                                    <a href="/departments/<?= $dept['id'] ?>" class="btn btn-sm btn-info" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="/departments/<?= $dept['id'] ?>/edit" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" action="/departments/<?= $dept['id'] ?>/delete" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this department?');">
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
        
        <?php if (!empty($departments)): ?>
            <div class="mt-3 text-muted">
                <small>Total: <?= count($departments) ?> department(s)</small>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
