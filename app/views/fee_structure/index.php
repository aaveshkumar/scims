<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-cash-stack me-2"></i>Fee Structure Management</h2>
    <a href="/fee-structure/create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Add Fee Structure
    </a>
</div>

<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h6>Total Templates</h6>
                <h3><?= $stats['total_templates'] ?? 0 ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h6>Active Templates</h6>
                <h3><?= $stats['active_templates'] ?? 0 ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h6>Total Amount</h6>
                <h3>₹<?= number_format($stats['total_amount'] ?? 0, 0) ?></h3>
            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-4">
                <select name="class_id" class="form-select">
                    <option value="">All Classes</option>
                    <?php foreach ($classes ?? [] as $class): ?>
                        <option value="<?= $class['id'] ?>" <?= ($filters['class_id'] ?? '') == $class['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($class['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <select name="academic_year" class="form-select">
                    <option value="">All Years</option>
                    <?php foreach ($academicYears ?? [] as $year): ?>
                        <option value="<?= htmlspecialchars($year['academic_year']) ?>" <?= ($filters['academic_year'] ?? '') == $year['academic_year'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($year['academic_year']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="active" <?= ($filters['status'] ?? '') == 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= ($filters['status'] ?? '') == 'inactive' ? 'selected' : '' ?>>Inactive</option>
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
                        <th>Fee Name</th>
                        <th>Class</th>
                        <th>Academic Year</th>
                        <th>Amount</th>
                        <th>Due Date</th>
                        <th>Fine/Day</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($feeTemplates)): ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                No fee structures found. Click "Add Fee Structure" to get started.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($feeTemplates as $template): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($template['name']) ?></strong></td>
                                <td><?= htmlspecialchars($template['class_name'] ?? 'All Classes') ?></td>
                                <td><?= htmlspecialchars($template['academic_year']) ?></td>
                                <td>₹<?= number_format($template['amount'], 2) ?></td>
                                <td><?= $template['due_date'] ? date('M d, Y', strtotime($template['due_date'])) : 'N/A' ?></td>
                                <td>₹<?= number_format($template['fine_per_day'] ?? 0, 2) ?></td>
                                <td>
                                    <span class="badge bg-<?= $template['status'] == 'active' ? 'success' : 'secondary' ?>">
                                        <?= ucfirst($template['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="/fee-structure/<?= $template['id'] ?>" class="btn btn-sm btn-info">View</a>
                                    <a href="/fee-structure/<?= $template['id'] ?>/edit" class="btn btn-sm btn-warning">Edit</a>
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