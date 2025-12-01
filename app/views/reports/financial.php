<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-graph-up me-2"></i>Financial Reports</h2>
</div>

<!-- Summary Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-primary"><?= $summary['total'] ?? 0 ?></h3>
                <p class="mb-0">Total Invoices</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-info">₹<?= number_format($summary['total_amount'] ?? 0, 2) ?></h3>
                <p class="mb-0">Total Amount</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-success">₹<?= number_format($summary['paid'] ?? 0, 2) ?></h3>
                <p class="mb-0">Amount Paid</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-danger">₹<?= number_format($summary['pending'] ?? 0, 2) ?></h3>
                <p class="mb-0">Amount Pending</p>
            </div>
        </div>
    </div>
</div>

<!-- Data Table -->
<div class="card">
    <div class="card-header">
        <h6 class="mb-0">Invoice Records</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student</th>
                        <th>Total Amount</th>
                        <th>Date</th>
                        <th>Balance</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($records)): ?>
                        <?php foreach ($records as $index => $record): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= htmlspecialchars(($record['first_name'] ?? 'N/A') . ' ' . ($record['last_name'] ?? '')) ?></td>
                                <td>₹<?= number_format($record['total_amount'] ?? 0, 2) ?></td>
                                <td><?= date('M d, Y', strtotime($record['created_at'])) ?></td>
                                <td>₹<?= number_format($record['balance'] ?? 0, 2) ?></td>
                                <td>
                                    <?php 
                                    $badge = ($record['balance'] ?? 0) == 0 ? 'bg-success' : 'bg-warning';
                                    $status = ($record['balance'] ?? 0) == 0 ? 'Paid' : 'Pending';
                                    ?>
                                    <span class="badge <?= $badge ?>"><?= $status ?></span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">No invoice records found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
