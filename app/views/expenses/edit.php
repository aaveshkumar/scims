<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Edit Expense</h1>
        <p class="text-muted mb-0">Update expense details</p>
    </div>
    <a href="/expenses" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="/expenses/<?= $expense['id'] ?>" class="needs-validation">
            <input type="hidden" name="_token" value="<?= csrf() ?>">

            <!-- Basic Information -->
            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-info-circle me-2"></i>Basic Information
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Category *</label>
                        <select name="category" class="form-select" required>
                            <option value="">-- Select Category --</option>
                            <?php foreach ($categories as $key => $label): ?>
                                <option value="<?= htmlspecialchars($key) ?>" <?= $expense['category'] === $key ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($label) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="text-muted">Type of expense</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Expense Date *</label>
                        <input type="date" name="expense_date" class="form-control" value="<?= $expense['expense_date'] ?>" required>
                        <small class="text-muted">When was this expense incurred?</small>
                    </div>
                </div>
            </div>

            <!-- Vendor & Amount -->
            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-building me-2"></i>Vendor & Amount
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Vendor Name</label>
                        <input type="text" name="vendor" class="form-control" value="<?= htmlspecialchars($expense['vendor'] ?: '') ?>">
                        <small class="text-muted">Name of the vendor or supplier</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Amount *</label>
                        <div class="input-group">
                            <span class="input-group-text">₹</span>
                            <input type="number" name="amount" class="form-control" step="0.01" min="0" value="<?= $expense['amount'] ?>" required>
                        </div>
                        <small class="text-muted">Expense amount in rupees</small>
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
                        <label class="form-label fw-bold">Payment Method</label>
                        <select name="payment_method" class="form-select">
                            <option value="">-- Select Method --</option>
                            <?php foreach ($paymentMethods as $key => $label): ?>
                                <option value="<?= htmlspecialchars($key) ?>" <?= $expense['payment_method'] === $key ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($label) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="text-muted">How was this expense paid?</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Invoice Number</label>
                        <input type="text" name="invoice_number" class="form-control" value="<?= htmlspecialchars($expense['invoice_number'] ?: '') ?>">
                        <small class="text-muted">Reference invoice number</small>
                    </div>
                </div>
            </div>

            <!-- Description -->
            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-file-text me-2"></i>Description
                </h6>
                <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($expense['description'] ?: '') ?></textarea>
                <small class="text-muted">Any additional notes or details about this expense</small>
            </div>

            <!-- Status -->
            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-toggles me-2"></i>Status
                </h6>
                <select name="status" class="form-select">
                    <option value="pending" <?= $expense['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="approved" <?= $expense['status'] === 'approved' ? 'selected' : '' ?>>Approved</option>
                    <option value="rejected" <?= $expense['status'] === 'rejected' ? 'selected' : '' ?>>Rejected</option>
                </select>
                <small class="text-muted">Status of this expense</small>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex gap-2 mt-5">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Update Expense
                </button>
                <a href="/expenses/<?= $expense['id'] ?>" class="btn btn-outline-secondary">
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
