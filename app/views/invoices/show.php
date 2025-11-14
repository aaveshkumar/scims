<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Invoice Details</h1>
        <p class="text-muted mb-0">Invoice #<?= htmlspecialchars($invoice['invoice_number']) ?></p>
    </div>
    <div>
        <button onclick="window.print()" class="btn btn-primary me-2">
            <i class="bi bi-printer me-2"></i>Print
        </button>
        <a href="/invoices" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <h4>School Management System</h4>
                <p class="text-muted mb-0">Official Fee Invoice</p>
            </div>
            <div class="col-md-6 text-md-end">
                <h5>INVOICE</h5>
                <p class="mb-0"><strong>#<?= htmlspecialchars($invoice['invoice_number']) ?></strong></p>
                <p class="text-muted mb-0">Date: <?= date('M d, Y', strtotime($invoice['created_at'])) ?></p>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <h6>Bill To:</h6>
                <p class="mb-1"><strong><?= htmlspecialchars($invoice['first_name'] . ' ' . $invoice['last_name']) ?></strong></p>
                <p class="mb-1"><?= htmlspecialchars($invoice['email']) ?></p>
                <p class="mb-1">Admission #: <?= htmlspecialchars($invoice['admission_number']) ?></p>
            </div>
            <div class="col-md-6 text-md-end">
                <p><strong>Due Date:</strong> <?= date('M d, Y', strtotime($invoice['due_date'])) ?></p>
                <p><strong>Status:</strong> 
                    <span class="badge bg-<?= match($invoice['payment_status']) {
                        'paid' => 'success',
                        'partial' => 'warning',
                        'unpaid' => 'danger',
                        default => 'secondary'
                    } ?> fs-6">
                        <?= ucfirst($invoice['payment_status']) ?>
                    </span>
                </p>
            </div>
        </div>

        <div class="table-responsive mb-4">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Description</th>
                        <th class="text-end">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Fee Amount</td>
                        <td class="text-end">$<?= number_format($invoice['amount'], 2) ?></td>
                    </tr>
                    <?php if ($invoice['discount'] > 0): ?>
                        <tr>
                            <td>Discount</td>
                            <td class="text-end text-success">-$<?= number_format($invoice['discount'], 2) ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ($invoice['tax'] > 0): ?>
                        <tr>
                            <td>Tax</td>
                            <td class="text-end">$<?= number_format($invoice['tax'], 2) ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <th>Total Amount</th>
                        <th class="text-end">$<?= number_format($invoice['total_amount'], 2) ?></th>
                    </tr>
                    <tr>
                        <th>Amount Paid</th>
                        <th class="text-end text-success">$<?= number_format($invoice['amount_paid'], 2) ?></th>
                    </tr>
                    <tr>
                        <th>Balance Due</th>
                        <th class="text-end <?= $invoice['balance'] > 0 ? 'text-danger' : 'text-success' ?>">
                            $<?= number_format($invoice['balance'], 2) ?>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <?php if ($invoice['balance'] > 0 && hasRole('admin', 'accountant')): ?>
            <div class="card bg-light">
                <div class="card-body">
                    <h6 class="mb-3">Record Payment</h6>
                    <form id="paymentForm" class="row g-3">
                        <input type="hidden" name="_token" value="<?= csrf() ?>">
                        <div class="col-md-4">
                            <label class="form-label">Amount</label>
                            <input type="number" name="amount" class="form-control" step="0.01" max="<?= $invoice['balance'] ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Payment Method</label>
                            <select name="payment_method" class="form-select" required>
                                <option value="">Select Method</option>
                                <option value="cash">Cash</option>
                                <option value="card">Card</option>
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="cheque">Cheque</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Transaction ID</label>
                            <input type="text" name="transaction_id" class="form-control">
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-cash me-2"></i>Record Payment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        <?php endif; ?>

        <div class="row mt-4">
            <div class="col-12 text-center text-muted">
                <p class="mb-0">Thank you for your payment</p>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('paymentForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('/invoices/<?= $invoice['id'] ?>/payment', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Payment recorded successfully!');
            window.location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    });
});
</script>

<style>
@media print {
    .btn, #paymentForm, nav, .sidebar { display: none !important; }
    .card { border: none !important; box-shadow: none !important; }
}
</style>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
