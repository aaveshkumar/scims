<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-people me-2"></i>Student Transport Assignments</h2>
    <div>
        <a href="/transport" class="btn btn-secondary me-2">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#assignStudentModal">
            <i class="bi bi-plus-circle me-2"></i>Assign Student
        </button>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search student..." value="<?= htmlspecialchars($filters['search'] ?? '') ?>">
            </div>
            <div class="col-md-3">
                <select name="route_id" class="form-select">
                    <option value="">All Routes</option>
                    <?php foreach ($routes ?? [] as $route): ?>
                        <option value="<?= $route['id'] ?>" <?= ($filters['route_id'] ?? '') == $route['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($route['route_name']) ?>
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
                        <th>Student</th>
                        <th>Class</th>
                        <th>Route</th>
                        <th>Pickup Point</th>
                        <th>Monthly Fee</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($assignments)): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                No assignments found. Click "Assign Student" to get started.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($assignments as $assignment): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($assignment['student_name']) ?></strong></td>
                                <td><?= htmlspecialchars($assignment['class_name'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($assignment['route_name']) ?></td>
                                <td><?= htmlspecialchars($assignment['pickup_point']) ?></td>
                                <td>₹<?= number_format($assignment['monthly_fee'] ?? 0, 2) ?></td>
                                <td>
                                    <span class="badge bg-<?= $assignment['status'] == 'active' ? 'success' : 'secondary' ?>">
                                        <?= ucfirst($assignment['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning">Edit</button>
                                    <button class="btn btn-sm btn-danger">Remove</button>
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
