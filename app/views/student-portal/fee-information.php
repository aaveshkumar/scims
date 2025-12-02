<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="mb-4">
    <h2><i class="bi bi-receipt me-2"></i>Fee Information</h2>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Invoices</div>
                <div class="h5 mb-0 font-weight-bold"><?= $summary['total_invoices'] ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Paid</div>
                <div class="h5 mb-0 font-weight-bold">Rs. <?= number_format($summary['total_paid'] ?? 0, 2) ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Pending</div>
                <div class="h5 mb-0 font-weight-bold">Rs. <?= number_format($summary['total_pending'] ?? 0, 2) ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Paid Count</div>
                <div class="h5 mb-0 font-weight-bold"><?= $summary['paid_count'] ?>/<?= $summary['total_invoices'] ?></div>
            </div>
        </div>
    </div>
</div>

<?php if (empty($invoices)): ?>
    <div class="alert alert-info">No invoices available</div>
<?php else: ?>
    <div class="card">
        <div class="card-header">
            <h6 class="mb-0">Invoice Details</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Invoice #</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($invoices as $invoice): ?>
                            <tr>
                                <td><?= htmlspecialchars($invoice['invoice_number'] ?? 'INV-' . $invoice['id']) ?></td>
                                <td>Rs. <?= number_format($invoice['amount'] ?? 0, 2) ?></td>
                                <td>
                                    <?php
                                    if ($invoice['status'] === 'paid') {
                                        echo '<span class="badge bg-success">Paid</span>';
                                    } elseif ($invoice['status'] === 'pending') {
                                        echo '<span class="badge bg-warning">Pending</span>';
                                    } else {
                                        echo '<span class="badge bg-danger">Overdue</span>';
                                    }
                                    ?>
                                </td>
                                <td><?= date('M d, Y', strtotime($invoice['created_at'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
