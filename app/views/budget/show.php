<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Budget Details</h1>
        <p class="text-muted mb-0"><?= htmlspecialchars($budget['budget_number']) ?></p>
    </div>
    <div>
        <a href="/budget/<?= $budget['id'] ?>/edit" class="btn btn-warning me-2">
            <i class="bi bi-pencil me-2"></i>Edit
        </a>
        <a href="/budget" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Budget Information</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="fw-bold text-muted">Category</label>
                        <p><?= htmlspecialchars($budget['category']) ?></p>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold text-muted">Budget Number</label>
                        <p><?= htmlspecialchars($budget['budget_number']) ?></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="fw-bold text-muted">Academic Year</label>
                        <p><?= htmlspecialchars($budget['academic_year']) ?></p>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold text-muted">Period</label>
                        <p><?= htmlspecialchars($budget['period'] ?: 'N/A') ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Financial Summary</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="fw-bold text-muted">Allocated Amount</label>
                        <p class="h5 text-primary">₹<?= number_format($budget['allocated_amount'], 2) ?></p>
                    </div>
                    <div class="col-md-4">
                        <label class="fw-bold text-muted">Spent Amount</label>
                        <p class="h5 text-danger">₹<?= number_format($budget['spent_amount'] ?? 0, 2) ?></p>
                    </div>
                    <div class="col-md-4">
                        <label class="fw-bold text-muted">Remaining</label>
                        <p class="h5 text-success">₹<?= number_format($budget['allocated_amount'] - ($budget['spent_amount'] ?? 0), 2) ?></p>
                    </div>
                </div>
                <div class="progress mb-3">
                    <?php 
                        $percentage = ($budget['spent_amount'] ?? 0) / $budget['allocated_amount'] * 100;
                        $barClass = $percentage > 90 ? 'bg-danger' : ($percentage > 70 ? 'bg-warning' : 'bg-success');
                    ?>
                    <div class="progress-bar <?= $barClass ?>" style="width: <?= $percentage ?>%">
                        <?= number_format($percentage, 1) ?>%
                    </div>
                </div>
            </div>
        </div>

        <?php if (!empty($budget['description'])): ?>
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Description</h5>
                </div>
                <div class="card-body">
                    <p><?= nl2br(htmlspecialchars($budget['description'])) ?></p>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="col-md-4">
        <div class="card sticky-top" style="top: 20px;">
            <div class="card-header">
                <h5 class="mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <strong>Status:</strong> <span class="badge bg-<?= $budget['status'] === 'active' ? 'success' : 'warning' ?>"><?= ucfirst($budget['status']) ?></span>
                </div>
                <a href="/budget/<?= $budget['id'] ?>/edit" class="btn btn-warning w-100 mb-2">
                    <i class="bi bi-pencil me-2"></i>Edit Budget
                </a>
                <a href="/budget" class="btn btn-outline-secondary w-100">
                    <i class="bi bi-list me-2"></i>View All
                </a>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
