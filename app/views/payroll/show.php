<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Payroll Details</h1>
        <p class="text-muted mb-0">Payroll #<?= htmlspecialchars($payroll['payroll_number']) ?></p>
    </div>
    <div>
        <a href="/payroll/<?= $payroll['id'] ?>/edit" class="btn btn-warning me-2">
            <i class="bi bi-pencil me-2"></i>Edit
        </a>
        <a href="/payroll" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Employee Information</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="fw-bold text-muted">Employee Name</label>
                        <p><?= htmlspecialchars($payroll['first_name'] . ' ' . $payroll['last_name']) ?></p>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold text-muted">Employee ID</label>
                        <p><?= htmlspecialchars($payroll['employee_id']) ?></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="fw-bold text-muted">Designation</label>
                        <p><?= htmlspecialchars($payroll['designation'] ?? 'N/A') ?></p>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold text-muted">Month/Year</label>
                        <p><?= htmlspecialchars($payroll['month']) ?> <?= $payroll['year'] ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Salary Details</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="fw-bold text-muted">Basic Salary</label>
                        <p class="h5">₹<?= number_format($payroll['basic_salary'], 2) ?></p>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold text-muted">Allowances</label>
                        <p class="h5 text-success">+ ₹<?= number_format($payroll['allowances'] ?? 0, 2) ?></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="fw-bold text-muted">Deductions</label>
                        <p class="h5 text-danger">- ₹<?= number_format($payroll['deductions'] ?? 0, 2) ?></p>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold text-muted">Gross Salary</label>
                        <p class="h5">₹<?= number_format($payroll['gross_salary'], 2) ?></p>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <label class="fw-bold text-muted">Net Salary</label>
                        <p class="h4 text-success">₹<?= number_format($payroll['net_salary'], 2) ?></p>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold text-muted">Status</label>
                        <p>
                            <span class="badge bg-<?= $payroll['status'] === 'paid' ? 'success' : 'warning' ?>">
                                <?= ucfirst($payroll['status']) ?>
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Payment Information</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="fw-bold text-muted">Payment Date</label>
                        <p><?= $payroll['payment_date'] ? date('M d, Y', strtotime($payroll['payment_date'])) : 'Not yet paid' ?></p>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold text-muted">Payment Method</label>
                        <p><?= htmlspecialchars($payroll['payment_method'] ?? 'N/A') ?></p>
                    </div>
                </div>
            </div>
        </div>

        <?php if (!empty($payroll['remarks'])): ?>
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Remarks</h5>
                </div>
                <div class="card-body">
                    <p><?= nl2br(htmlspecialchars($payroll['remarks'])) ?></p>
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
                <a href="/payroll/<?= $payroll['id'] ?>/edit" class="btn btn-warning w-100 mb-2">
                    <i class="bi bi-pencil me-2"></i>Edit Payroll
                </a>
                <a href="/payroll" class="btn btn-outline-secondary w-100">
                    <i class="bi bi-list me-2"></i>View All
                </a>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
