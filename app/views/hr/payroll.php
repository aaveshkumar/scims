<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-credit-card me-2"></i>Payroll Management</h2>
    <a href="/hr/payroll/create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Add Payroll
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Staff Name</th>
                        <th>Month/Year</th>
                        <th>Basic Salary</th>
                        <th>Allowances</th>
                        <th>Deductions</th>
                        <th>Net Salary</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($payrolls)): ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                No payroll records found. Click "Add Payroll" to get started.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($payrolls as $pr): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($pr['staff_name']) ?></strong></td>
                                <td><?= htmlspecialchars($pr['month']) ?>/<?= $pr['year'] ?></td>
                                <td>₹<?= number_format($pr['basic_salary'], 2) ?></td>
                                <td><span class="text-success">₹<?= number_format($pr['allowances'], 2) ?></span></td>
                                <td><span class="text-danger">₹<?= number_format($pr['deductions'], 2) ?></span></td>
                                <td><strong>₹<?= number_format($pr['net_salary'], 2) ?></strong></td>
                                <td><span class="badge bg-<?= $pr['status'] === 'paid' ? 'success' : 'warning' ?>"><?= ucfirst($pr['status']) ?></span></td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="/hr/payroll/<?= $pr['id'] ?>" class="btn btn-outline-primary" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="/hr/payroll/<?= $pr['id'] ?>/edit" class="btn btn-outline-warning" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form method="POST" action="/hr/payroll/<?= $pr['id'] ?>/delete" style="display: inline;" onsubmit="return confirm('Delete this payroll record?');">
                                            <input type="hidden" name="_token" value="<?= csrf() ?>">
                                            <button type="submit" class="btn btn-outline-danger" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
