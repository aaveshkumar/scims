<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Edit Payroll</h1>
        <p class="text-muted mb-0">Update payroll record</p>
    </div>
    <a href="/hr/payroll" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="/hr/payroll/<?= $payroll['id'] ?>/edit">
            <input type="hidden" name="_token" value="<?= csrf() ?>">
            
            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-person me-2"></i>Staff Information
                </h6>
                <div class="mb-3">
                    <label class="form-label fw-bold">Staff *</label>
                    <select name="staff_id" class="form-select" required>
                        <?php foreach ($staff as $s): ?>
                            <option value="<?= $s['id'] ?>" <?= $payroll['staff_id'] == $s['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($s['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-calendar me-2"></i>Period Information
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Month *</label>
                        <input type="text" name="month" class="form-control" value="<?= htmlspecialchars($payroll['month']) ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Year *</label>
                        <input type="number" name="year" class="form-control" value="<?= $payroll['year'] ?>" min="2020" max="2100" required>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-calculator me-2"></i>Salary Details
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Basic Salary *</label>
                        <input type="number" name="basic_salary" class="form-control" step="0.01" value="<?= $payroll['basic_salary'] ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Allowances</label>
                        <input type="number" name="allowances" class="form-control" step="0.01" value="<?= $payroll['allowances'] ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Deductions</label>
                        <input type="number" name="deductions" class="form-control" step="0.01" value="<?= $payroll['deductions'] ?>">
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-credit-card me-2"></i>Payment Information
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Payment Date</label>
                        <input type="date" name="payment_date" class="form-control" value="<?= $payroll['payment_date'] ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Payment Method</label>
                        <input type="text" name="payment_method" class="form-control" value="<?= htmlspecialchars($payroll['payment_method'] ?? '') ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Status</label>
                        <select name="status" class="form-select">
                            <option value="pending" <?= $payroll['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="paid" <?= $payroll['status'] === 'paid' ? 'selected' : '' ?>>Paid</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Update Payroll
                </button>
                <a href="/hr/payroll" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
