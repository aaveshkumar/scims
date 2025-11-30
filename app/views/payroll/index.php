<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-wallet2 me-2"></i>Payroll Management</h2>
    <a href="/payroll/create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Generate Payroll
    </a>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h6>Total Records</h6>
                <h3><?= $stats['total_records'] ?? 0 ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h6>Total Paid</h6>
                <h3>₹<?= number_format($stats['total_paid'] ?? 0, 0) ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <h6>Pending</h6>
                <h3><?= $stats['pending_count'] ?? 0 ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h6>This Month</h6>
                <h3>₹<?= number_format($stats['current_month_total'] ?? 0, 0) ?></h3>
            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <select name="staff_id" class="form-select">
                    <option value="">All Staff</option>
                    <?php foreach ($staff ?? [] as $member): ?>
                        <option value="<?= $member['id'] ?>" <?= ($filters['staff_id'] ?? '') == $member['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($member['first_name'] . ' ' . $member['last_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <select name="month" class="form-select">
                    <option value="">All Months</option>
                    <?php for ($m = 1; $m <= 12; $m++): ?>
                        <option value="<?= $m ?>" <?= ($filters['month'] ?? '') == $m ? 'selected' : '' ?>>
                            <?= date('F', mktime(0, 0, 0, $m, 1)) ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-md-2">
                <select name="year" class="form-select">
                    <option value="">All Years</option>
                    <?php for ($y = date('Y'); $y >= date('Y') - 5; $y--): ?>
                        <option value="<?= $y ?>" <?= ($filters['year'] ?? '') == $y ? 'selected' : '' ?>><?= $y ?></option>
                    <?php endfor; ?>
                </select>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="pending" <?= ($filters['status'] ?? '') == 'pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="paid" <?= ($filters['status'] ?? '') == 'paid' ? 'selected' : '' ?>>Paid</option>
                    <option value="hold" <?= ($filters['status'] ?? '') == 'hold' ? 'selected' : '' ?>>On Hold</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </form>
    </div>
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
                    <?php if (empty($payrollRecords)): ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                No payroll records found. Click "Generate Payroll" to get started.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($payrollRecords as $record): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($record['staff_name']) ?></strong></td>
                                <td><?= htmlspecialchars($record['month']) ?> <?= $record['year'] ?></td>
                                <td>₹<?= number_format($record['basic_salary'], 2) ?></td>
                                <td>₹<?= number_format($record['allowances'] ?? 0, 2) ?></td>
                                <td>₹<?= number_format($record['deductions'] ?? 0, 2) ?></td>
                                <td><strong>₹<?= number_format($record['net_salary'], 2) ?></strong></td>
                                <td>
                                    <span class="badge bg-<?= $record['status'] == 'paid' ? 'success' : ($record['status'] == 'pending' ? 'warning' : 'secondary') ?>">
                                        <?= ucfirst($record['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="/payroll/<?= $record['id'] ?>" class="btn btn-sm btn-info">View</a>
                                    <a href="/payroll/<?= $record['id'] ?>/edit" class="btn btn-sm btn-warning">Edit</a>
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