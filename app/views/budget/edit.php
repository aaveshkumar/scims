<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Edit Budget</h1>
        <p class="text-muted mb-0">Update budget details</p>
    </div>
    <a href="/budget" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="/budget/<?= $budget['id'] ?>" class="needs-validation">
            <input type="hidden" name="_token" value="<?= csrf() ?>">

            <!-- Budget Allocation -->
            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-tag me-2"></i>Budget Information
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Category *</label>
                        <select name="category" class="form-select" required>
                            <option value="">-- Select Category --</option>
                            <?php foreach ($categories as $key => $label): ?>
                                <option value="<?= htmlspecialchars($key) ?>" <?= $budget['category'] === $key ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($label) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="text-muted">Department or area of expenditure</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Academic Year *</label>
                        <input type="text" name="academic_year" class="form-control" value="<?= htmlspecialchars($budget['academic_year']) ?>" required>
                        <small class="text-muted">Format: YYYY-YYYY</small>
                    </div>
                </div>
            </div>

            <!-- Financial Details -->
            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-currency-rupee me-2"></i>Financial Details
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Allocated Amount *</label>
                        <div class="input-group">
                            <span class="input-group-text">₹</span>
                            <input type="number" name="allocated_amount" class="form-control" step="0.01" min="0" value="<?= $budget['allocated_amount'] ?>" required>
                        </div>
                        <small class="text-muted">Total budget to allocate</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Amount Spent</label>
                        <div class="input-group">
                            <span class="input-group-text">₹</span>
                            <input type="number" name="spent_amount" class="form-control" step="0.01" min="0" value="<?= $budget['spent_amount'] ?? 0 ?>">
                        </div>
                        <small class="text-muted">Amount spent so far</small>
                    </div>
                </div>
            </div>

            <!-- Period & Status -->
            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-calendar me-2"></i>Period & Status
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Period</label>
                        <select name="period" class="form-select">
                            <option value="">-- Select Period --</option>
                            <option value="Annual" <?= ($budget['period'] ?? '') === 'Annual' ? 'selected' : '' ?>>Annual</option>
                            <option value="Semester" <?= ($budget['period'] ?? '') === 'Semester' ? 'selected' : '' ?>>Semester</option>
                            <option value="Quarterly" <?= ($budget['period'] ?? '') === 'Quarterly' ? 'selected' : '' ?>>Quarterly</option>
                            <option value="Monthly" <?= ($budget['period'] ?? '') === 'Monthly' ? 'selected' : '' ?>>Monthly</option>
                        </select>
                        <small class="text-muted">Budget duration</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Status</label>
                        <select name="status" class="form-select">
                            <option value="active" <?= ($budget['status'] ?? '') === 'active' ? 'selected' : '' ?>>Active</option>
                            <option value="pending" <?= ($budget['status'] ?? '') === 'pending' ? 'selected' : '' ?>>Pending</option>
                        </select>
                        <small class="text-muted">Budget status</small>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-file-text me-2"></i>Description
                </h6>
                <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($budget['description'] ?? '') ?></textarea>
                <small class="text-muted">Additional notes or details</small>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex gap-2 mt-5">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Update Budget
                </button>
                <a href="/budget/<?= $budget['id'] ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-x-circle me-2"></i>Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<style>
[data-bs-theme="dark"] .text-muted {
    color: #a8b1bd !important;
}

[data-bs-theme="dark"] .form-label {
    color: #e9ecef;
}

[data-bs-theme="dark"] .form-control,
[data-bs-theme="dark"] .form-select {
    background-color: #2d3238;
    color: #e9ecef;
    border-color: #495057;
}

[data-bs-theme="dark"] .form-control:focus,
[data-bs-theme="dark"] .form-select:focus {
    background-color: #2d3238;
    color: #e9ecef;
    border-color: #5a8dee;
    box-shadow: 0 0 0 0.25rem rgba(90, 141, 238, 0.25);
}

[data-bs-theme="dark"] .input-group-text {
    background-color: #3a3f47;
    color: #e9ecef;
    border-color: #495057;
}
</style>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
