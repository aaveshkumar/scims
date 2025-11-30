<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Expense Details</h1>
        <p class="text-muted mb-0">Expense #<?= htmlspecialchars($expense['expense_number']) ?></p>
    </div>
    <div>
        <a href="/expenses/<?= $expense['id'] ?>/edit" class="btn btn-warning me-2">
            <i class="bi bi-pencil me-2"></i>Edit
        </a>
        <a href="/expenses" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Expense Information</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="fw-bold text-muted">Expense Number</label>
                        <p><?= htmlspecialchars($expense['expense_number']) ?></p>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold text-muted">Category</label>
                        <p><span class="badge bg-info"><?= htmlspecialchars($expense['category']) ?></span></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="fw-bold text-muted">Expense Date</label>
                        <p><?= date('M d, Y', strtotime($expense['expense_date'])) ?></p>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold text-muted">Amount</label>
                        <p class="h5 text-success">₹<?= number_format($expense['amount'], 2) ?></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="fw-bold text-muted">Vendor</label>
                        <p><?= htmlspecialchars($expense['vendor'] ?: 'N/A') ?></p>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold text-muted">Status</label>
                        <p>
                            <span class="badge bg-<?= $expense['status'] === 'approved' ? 'success' : ($expense['status'] === 'rejected' ? 'danger' : 'warning') ?>">
                                <?= ucfirst($expense['status']) ?>
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Payment Details</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="fw-bold text-muted">Payment Method</label>
                        <p><?= htmlspecialchars($expense['payment_method'] ?: 'N/A') ?></p>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold text-muted">Invoice Number</label>
                        <p><?= htmlspecialchars($expense['invoice_number'] ?: 'N/A') ?></p>
                    </div>
                </div>
            </div>
        </div>

        <?php if (!empty($expense['description'])): ?>
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Description</h5>
                </div>
                <div class="card-body">
                    <p><?= nl2br(htmlspecialchars($expense['description'])) ?></p>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="col-md-4">
        <div class="card sticky-top" style="top: 20px;">
            <div class="card-header">
                <h5 class="mb-0">Actions</h5>
            </div>
            <div class="card-body">
                <a href="/expenses/<?= $expense['id'] ?>/edit" class="btn btn-warning w-100 mb-2">
                    <i class="bi bi-pencil me-2"></i>Edit Expense
                </a>
                <form method="POST" action="/expenses/<?= $expense['id'] ?>/delete" onsubmit="return confirm('Delete this expense?');">
                    <input type="hidden" name="_token" value="<?= csrf() ?>">
                    <button type="submit" class="btn btn-danger w-100 mb-2">
                        <i class="bi bi-trash me-2"></i>Delete
                    </button>
                </form>
                <a href="/expenses" class="btn btn-outline-secondary w-100">
                    <i class="bi bi-list me-2"></i>View All
                </a>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
