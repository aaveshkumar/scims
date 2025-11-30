<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0"><i class="bi bi-calculator me-2"></i>Budget Planning</h1>
        <p class="text-muted mb-0">Manage departmental and annual budgets</p>
    </div>
    <a href="/budget/create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Create Budget
    </a>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h6>Total Budgets</h6>
                <h3><?= $stats['total_budgets'] ?? 0 ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h6>Total Allocated</h6>
                <h3>₹<?= number_format($stats['total_allocated'] ?? 0, 0) ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <h6>Total Spent</h6>
                <h3>₹<?= number_format($stats['total_spent'] ?? 0, 0) ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h6>Remaining</h6>
                <h3>₹<?= number_format($stats['remaining'] ?? 0, 0) ?></h3>
            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-4">
                <select name="category" class="form-select">
                    <option value="">All Categories</option>
                    <?php foreach ($categories as $key => $label): ?>
                        <option value="<?= htmlspecialchars($key) ?>" <?= ($request->get('category') ?? '') === $key ? 'selected' : '' ?>>
                            <?= htmlspecialchars($label) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="active" <?= ($request->get('status') ?? '') === 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="pending" <?= ($request->get('status') ?? '') === 'pending' ? 'selected' : '' ?>>Pending</option>
                </select>
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search me-2"></i>Filter
                </button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Budget Number</th>
                        <th>Category</th>
                        <th>Academic Year</th>
                        <th>Allocated</th>
                        <th>Spent</th>
                        <th>Remaining</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($budgets)): ?>
                        <?php foreach ($budgets as $budget): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($budget['budget_number']) ?></strong></td>
                                <td><span class="badge bg-secondary"><?= htmlspecialchars($budget['category']) ?></span></td>
                                <td><?= htmlspecialchars($budget['academic_year']) ?></td>
                                <td>₹<?= number_format($budget['allocated_amount'], 2) ?></td>
                                <td>₹<?= number_format($budget['spent_amount'] ?? 0, 2) ?></td>
                                <td>₹<?= number_format(($budget['allocated_amount'] - ($budget['spent_amount'] ?? 0)), 2) ?></td>
                                <td>
                                    <span class="badge bg-<?= $budget['status'] === 'active' ? 'success' : 'warning' ?>">
                                        <?= ucfirst($budget['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="/budget/<?= $budget['id'] ?>" class="btn btn-outline-primary" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="/budget/<?= $budget['id'] ?>/edit" class="btn btn-outline-warning" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form method="POST" action="/budget/<?= $budget['id'] ?>/delete" style="display: inline;" onsubmit="return confirm('Delete this budget?');">
                                            <input type="hidden" name="_token" value="<?= csrf() ?>">
                                            <button type="submit" class="btn btn-outline-danger" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-5">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                <p class="mb-0">No budgets found.</p>
                                <small>Click "Create Budget" to add one.</small>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>