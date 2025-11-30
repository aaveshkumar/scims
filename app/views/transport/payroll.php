<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-cash-coin me-2"></i>Driver Payroll</h2>
    <a href="/transport/drivers" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Pay Drivers</h5>
    </div>
    <div class="card-body">
        <?php if (empty($drivers)): ?>
            <div class="text-center text-muted py-5">
                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                <p>No drivers found.</p>
            </div>
        <?php else: ?>
            <form method="POST" action="/transport/drivers/payroll/submit">
                <?= csrf_field() ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Driver Name</th>
                                <th>Basic Salary (₹)</th>
                                <th>Allowances (₹)</th>
                                <th>Deductions (₹)</th>
                                <th>Net Salary (₹)</th>
                                <th>Payment Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($drivers as $driver): ?>
                                <tr>
                                    <td><?= htmlspecialchars($driver['first_name'] . ' ' . $driver['last_name']) ?></td>
                                    <td>
                                        <input type="number" name="basic_salary[<?= $driver['id'] ?>]" class="form-control form-control-sm" value="15000" step="100" min="0">
                                    </td>
                                    <td>
                                        <input type="number" name="allowances[<?= $driver['id'] ?>]" class="form-control form-control-sm" value="2000" step="100" min="0">
                                    </td>
                                    <td>
                                        <input type="number" name="deductions[<?= $driver['id'] ?>]" class="form-control form-control-sm" value="500" step="100" min="0">
                                    </td>
                                    <td>
                                        <span class="badge bg-info">Calculated</span>
                                    </td>
                                    <td>
                                        <input type="date" name="payment_date[<?= $driver['id'] ?>]" class="form-control form-control-sm" value="<?= date('Y-m-d') ?>">
                                    </td>
                                    <td>
                                        <select name="status[<?= $driver['id'] ?>]" class="form-select form-select-sm">
                                            <option value="pending">Pending</option>
                                            <option value="paid" selected>Paid</option>
                                            <option value="cancelled">Cancelled</option>
                                        </select>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i>Process Payroll
                    </button>
                    <a href="/transport/drivers" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
