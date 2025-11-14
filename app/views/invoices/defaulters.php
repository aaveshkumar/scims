<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Fee Defaulters</h1>
        <p class="text-muted mb-0">Students with overdue payments</p>
    </div>
    <div>
        <button onclick="window.print()" class="btn btn-primary me-2">
            <i class="bi bi-printer me-2"></i>Print Report
        </button>
        <a href="/invoices" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <div class="row text-center">
            <div class="col-md-4">
                <div class="p-3">
                    <h2 class="text-danger"><?= count($defaulters) ?></h2>
                    <p class="text-muted mb-0">Total Defaulters</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3">
                    <h2 class="text-warning">
                        $<?= number_format(array_sum(array_column($defaulters, 'total_outstanding')), 2) ?>
                    </h2>
                    <p class="text-muted mb-0">Total Outstanding</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-3">
                    <h2 class="text-primary">
                        <?= count(array_filter($defaulters, fn($d) => $d['days_overdue'] > 30)) ?>
                    </h2>
                    <p class="text-muted mb-0">30+ Days Overdue</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Defaulter List</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Admission #</th>
                        <th>Student Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Overdue Invoices</th>
                        <th>Total Outstanding</th>
                        <th>Days Overdue</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($defaulters)): ?>
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <i class="bi bi-check-circle text-success" style="font-size: 3rem;"></i>
                                <p class="mt-2 text-muted">No defaulters found! All payments are up to date.</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($defaulters as $defaulter): ?>
                            <tr>
                                <td><?= htmlspecialchars($defaulter['admission_number']) ?></td>
                                <td>
                                    <strong><?= htmlspecialchars($defaulter['first_name'] . ' ' . $defaulter['last_name']) ?></strong>
                                </td>
                                <td><?= htmlspecialchars($defaulter['email']) ?></td>
                                <td><?= htmlspecialchars($defaulter['phone']) ?></td>
                                <td>
                                    <span class="badge bg-danger"><?= $defaulter['overdue_count'] ?></span>
                                </td>
                                <td>
                                    <strong class="text-danger">$<?= number_format($defaulter['total_outstanding'], 2) ?></strong>
                                </td>
                                <td>
                                    <span class="badge bg-<?= $defaulter['days_overdue'] > 30 ? 'danger' : 'warning' ?>">
                                        <?= $defaulter['days_overdue'] ?> days
                                    </span>
                                </td>
                                <td>
                                    <a href="/students/<?= $defaulter['student_id'] ?>" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="/invoices?student_id=<?= $defaulter['student_id'] ?>" class="btn btn-sm btn-primary">
                                        <i class="bi bi-receipt"></i> Invoices
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
                <?php if (!empty($defaulters)): ?>
                    <tfoot class="table-light">
                        <tr>
                            <th colspan="5" class="text-end">Grand Total:</th>
                            <th class="text-danger">
                                $<?= number_format(array_sum(array_column($defaulters, 'total_outstanding')), 2) ?>
                            </th>
                            <th colspan="2"></th>
                        </tr>
                    </tfoot>
                <?php endif; ?>
            </table>
        </div>
    </div>
</div>

<style>
@media print {
    .btn, nav, .sidebar { display: none !important; }
    .card { border: 1px solid #dee2e6 !important; }
}
</style>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
