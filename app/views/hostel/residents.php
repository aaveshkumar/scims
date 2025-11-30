<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Hostel Residents Management</h2>
    <a href="/hostel/residents/create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Add Resident
    </a>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control" placeholder="Search name or roll number..." value="<?= $_GET['search'] ?? '' ?>">
            </div>
            <div class="col-md-3">
                <select name="hostel_id" class="form-select">
                    <option value="">All Hostels</option>
                    <?php foreach ($hostels as $hostel): ?>
                        <option value="<?= $hostel['id'] ?>" <?= ($_GET['hostel_id'] ?? '') == $hostel['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($hostel['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="active" <?= ($_GET['status'] ?? '') == 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= ($_GET['status'] ?? '') == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-outline-primary w-100">
                    <i class="bi bi-search me-2"></i>Search
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Stats -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Total Residents</h6>
                <h3><?= $stats['total'] ?? 0 ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Active Residents</h6>
                <h3><?= $stats['active'] ?? 0 ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Inactive</h6>
                <h3><?= $stats['inactive'] ?? 0 ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Avg. Stay</h6>
                <h3><?= $stats['avg_stay'] ?? 0 ?> days</h3>
            </div>
        </div>
    </div>
</div>

<?php if (empty($residents)): ?>
    <div class="alert alert-info">
        <p>No residents found.</p>
    </div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Roll Number</th>
                    <th>Hostel</th>
                    <th>Room</th>
                    <th>Admission Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($residents as $resident): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($resident['first_name'] . ' ' . $resident['last_name']) ?></strong></td>
                        <td><?= htmlspecialchars($resident['roll_number']) ?></td>
                        <td><?= htmlspecialchars($resident['hostel_name']) ?></td>
                        <td><?= htmlspecialchars($resident['room_number']) ?></td>
                        <td><?= date('d M Y', strtotime($resident['admission_date'])) ?></td>
                        <td>
                            <span class="badge bg-<?= ($resident['status'] ?? 'active') == 'active' ? 'success' : 'secondary' ?>">
                                <?= ucfirst($resident['status'] ?? 'active') ?>
                            </span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="/hostel/residents/<?= $resident['id'] ?>/edit" class="btn btn-outline-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="/hostel/residents/<?= $resident['id'] ?>/delete" style="display: inline;">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Remove this resident?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
