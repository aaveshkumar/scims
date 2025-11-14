<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Fee Invoices</h1>
    <div>
        <a href="/invoices/defaulters" class="btn btn-warning">
            <i class="bi bi-exclamation-triangle me-2"></i>Defaulters
        </a>
        <a href="/invoices/create" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Create Invoice
        </a>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <div class="btn-group" role="group">
            <a href="/invoices?status=all" class="btn btn-<?= $status === 'all' ? 'primary' : 'outline-primary' ?>">
                All
            </a>
            <a href="/invoices?status=unpaid" class="btn btn-<?= $status === 'unpaid' ? 'danger' : 'outline-danger' ?>">
                Unpaid
            </a>
            <a href="/invoices?status=partial" class="btn btn-<?= $status === 'partial' ? 'warning' : 'outline-warning' ?>">
                Partial
            </a>
            <a href="/invoices?status=paid" class="btn btn-<?= $status === 'paid' ? 'success' : 'outline-success' ?>">
                Paid
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Invoice List</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Invoice #</th>
                        <th>Student</th>
                        <th>Admission #</th>
                        <th>Total Amount</th>
                        <th>Paid</th>
                        <th>Balance</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($invoices)): ?>
                        <tr>
                            <td colspan="9" class="text-center py-4 text-muted">No invoices found</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($invoices as $invoice): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($invoice['invoice_number']) ?></strong></td>
                                <td><?= htmlspecialchars($invoice['first_name'] . ' ' . $invoice['last_name']) ?></td>
                                <td><?= htmlspecialchars($invoice['admission_number']) ?></td>
                                <td>₹<?= number_format($invoice['total_amount'], 2) ?></td>
                                <td>₹<?= number_format($invoice['amount_paid'], 2) ?></td>
                                <td>₹<?= number_format($invoice['balance'], 2) ?></td>
                                <td><?= date('M d, Y', strtotime($invoice['due_date'])) ?></td>
                                <td>
                                    <span class="badge bg-<?= match($invoice['payment_status']) {
                                        'paid' => 'success',
                                        'partial' => 'warning',
                                        'unpaid' => 'danger',
                                        default => 'secondary'
                                    } ?>">
                                        <?= ucfirst($invoice['payment_status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="/invoices/<?= $invoice['id'] ?>" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <?php if ($invoice['balance'] > 0): ?>
                                        <button onclick="recordPayment(<?= $invoice['id'] ?>, <?= $invoice['balance'] ?>)" 
                                                class="btn btn-sm btn-success">
                                            <i class="bi bi-cash"></i>
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function recordPayment(invoiceId, balance) {
    const amount = prompt(`Enter payment amount (Balance: ₹${balance.toFixed(2)}):`);
    if (amount && !isNaN(amount)) {
        const method = prompt('Payment method (cash/card/upi/bank):') || 'cash';
        
        fetch(`/invoices/${invoiceId}/payment`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                amount: parseFloat(amount),
                payment_method: method
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Payment recorded successfully!');
                location.reload();
            } else {
                alert(data.message || 'Failed to record payment');
            }
        })
        .catch(error => {
            alert('An error occurred');
            console.error(error);
        });
    }
}
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
