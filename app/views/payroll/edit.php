<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Edit Payroll</h1>
        <p class="text-muted mb-0">Update payroll details</p>
    </div>
    <a href="/payroll" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="/payroll/<?= $payroll['id'] ?>" class="needs-validation">
            <input type="hidden" name="_token" value="<?= csrf() ?>">

            <!-- Employee Information -->
            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-person me-2"></i>Employee Information
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Employee Name</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($payroll['first_name'] . ' ' . $payroll['last_name']) ?>" disabled>
                        <small class="text-muted">Read-only</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Employee ID</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($payroll['employee_id']) ?>" disabled>
                        <small class="text-muted">Read-only</small>
                    </div>
                </div>
            </div>

            <!-- Salary Information -->
            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-currency-rupee me-2"></i>Salary Information
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Basic Salary *</label>
                        <div class="input-group">
                            <span class="input-group-text">₹</span>
                            <input type="number" name="basic_salary" class="form-control" step="0.01" min="0" value="<?= $payroll['basic_salary'] ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Allowances</label>
                        <div class="input-group">
                            <span class="input-group-text">₹</span>
                            <input type="number" name="allowances" class="form-control" step="0.01" min="0" value="<?= $payroll['allowances'] ?? 0 ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Deductions</label>
                        <div class="input-group">
                            <span class="input-group-text">₹</span>
                            <input type="number" name="deductions" class="form-control" step="0.01" min="0" value="<?= $payroll['deductions'] ?? 0 ?>">
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Gross Salary</label>
                        <div class="input-group">
                            <span class="input-group-text">₹</span>
                            <input type="text" class="form-control" value="<?= number_format($payroll['gross_salary'], 2) ?>" disabled>
                        </div>
                        <small class="text-muted">Auto-calculated (Basic + Allowances)</small>
                    </div>
                </div>
            </div>

            <!-- Payment Details -->
            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-credit-card me-2"></i>Payment Details
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Payment Date</label>
                        <input type="date" name="payment_date" class="form-control" value="<?= $payroll['payment_date'] ?? '' ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Payment Method</label>
                        <select name="payment_method" class="form-select">
                            <option value="">-- Select Method --</option>
                            <option value="Cash" <?= ($payroll['payment_method'] ?? '') === 'Cash' ? 'selected' : '' ?>>Cash</option>
                            <option value="Check" <?= ($payroll['payment_method'] ?? '') === 'Check' ? 'selected' : '' ?>>Check</option>
                            <option value="Bank Transfer" <?= ($payroll['payment_method'] ?? '') === 'Bank Transfer' ? 'selected' : '' ?>>Bank Transfer</option>
                            <option value="Digital Payment" <?= ($payroll['payment_method'] ?? '') === 'Digital Payment' ? 'selected' : '' ?>>Digital Payment</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Status -->
            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-toggles me-2"></i>Status
                </h6>
                <select name="status" class="form-select">
                    <option value="pending" <?= ($payroll['status'] ?? '') === 'pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="paid" <?= ($payroll['status'] ?? '') === 'paid' ? 'selected' : '' ?>>Paid</option>
                    <option value="hold" <?= ($payroll['status'] ?? '') === 'hold' ? 'selected' : '' ?>>On Hold</option>
                </select>
            </div>

            <!-- Remarks -->
            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-file-text me-2"></i>Remarks
                </h6>
                <textarea name="remarks" class="form-control" rows="3"><?= htmlspecialchars($payroll['remarks'] ?? '') ?></textarea>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex gap-2 mt-5">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Update Payroll
                </button>
                <a href="/payroll/<?= $payroll['id'] ?>" class="btn btn-outline-secondary">
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
