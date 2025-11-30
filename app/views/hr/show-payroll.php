<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Payroll Record</h1>
        <p class="text-muted mb-0"><?= htmlspecialchars($payroll['staff_name']) ?></p>
    </div>
    <div>
        <a href="/hr/payroll/<?= $payroll['id'] ?>/edit" class="btn btn-warning me-2">
            <i class="bi bi-pencil me-2"></i>Edit
        </a>
        <form method="POST" action="/hr/payroll/<?= $payroll['id'] ?>/delete" style="display: inline;" onsubmit="return confirm('Delete this payroll record?');">
            <input type="hidden" name="_token" value="<?= csrf() ?>">
            <button type="submit" class="btn btn-danger me-2">
                <i class="bi bi-trash me-2"></i>Delete
            </button>
        </form>
        <a href="/hr/payroll" class="btn btn-secondary">Back</a>
    </div>
</div>

<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card">
            <div class="card-body text-center">
                <label class="fw-bold text-muted">Basic Salary</label>
                <h4>₹<?= number_format($payroll['basic_salary'], 2) ?></h4>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card">
            <div class="card-body text-center">
                <label class="fw-bold text-muted">Allowances</label>
                <h4 class="text-success">₹<?= number_format($payroll['allowances'], 2) ?></h4>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card">
            <div class="card-body text-center">
                <label class="fw-bold text-muted">Deductions</label>
                <h4 class="text-danger">₹<?= number_format($payroll['deductions'], 2) ?></h4>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <label class="fw-bold">Net Salary</label>
                <h4>₹<?= number_format($payroll['net_salary'], 2) ?></h4>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-4">
                <label class="fw-bold text-muted">Period</label>
                <p><?= htmlspecialchars($payroll['month']) ?> <?= $payroll['year'] ?></p>
            </div>
            <div class="col-md-4">
                <label class="fw-bold text-muted">Payment Date</label>
                <p><?= $payroll['payment_date'] ? date('M d, Y', strtotime($payroll['payment_date'])) : 'Not set' ?></p>
            </div>
            <div class="col-md-4">
                <label class="fw-bold text-muted">Status</label>
                <p><span class="badge bg-<?= $payroll['status'] === 'paid' ? 'success' : 'warning' ?>"><?= ucfirst($payroll['status']) ?></span></p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <label class="fw-bold text-muted">Payment Method</label>
                <p><?= htmlspecialchars($payroll['payment_method'] ?? 'Not specified') ?></p>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
