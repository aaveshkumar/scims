<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-building me-2"></i>Hostel Management</h2>
    <a href="/hostel/create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Add New Hostel
    </a>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h6>Total Hostels</h6>
                <h3><?= $stats['total_hostels'] ?? 0 ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h6>Total Capacity</h6>
                <h3><?= $stats['total_capacity'] ?? 0 ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h6>Occupied</h6>
                <h3><?= $stats['occupied_beds'] ?? 0 ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <h6>Available</h6>
                <h3><?= $stats['available_beds'] ?? 0 ?></h3>
            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-5">
                <input type="text" name="search" class="form-control" placeholder="Search hostels..." value="<?= htmlspecialchars($filters['search'] ?? '') ?>">
            </div>
            <div class="col-md-3">
                <select name="gender" class="form-select">
                    <option value="">All Genders</option>
                    <option value="male" <?= ($filters['gender'] ?? '') == 'male' ? 'selected' : '' ?>>Male</option>
                    <option value="female" <?= ($filters['gender'] ?? '') == 'female' ? 'selected' : '' ?>>Female</option>
                </select>
            </div>
            <div class="col-md-2">
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
                        <th>Hostel Name</th>
                        <th>Type</th>
                        <th>Gender</th>
                        <th>Capacity</th>
                        <th>Occupied</th>
                        <th>Available</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($hostels)): ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                No hostels found. Click "Add New Hostel" to get started.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($hostels as $hostel): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($hostel['name']) ?></strong></td>
                                <td><?= htmlspecialchars($hostel['type'] ?? 'N/A') ?></td>
                                <td>
                                    <span class="badge bg-<?= $hostel['gender'] == 'male' ? 'primary' : 'danger' ?>">
                                        <?= ucfirst($hostel['gender']) ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($hostel['capacity'] ?? 0) ?></td>
                                <td><?= htmlspecialchars($hostel['occupied_beds'] ?? 0) ?></td>
                                <td><?= ($hostel['capacity'] ?? 0) - ($hostel['occupied_beds'] ?? 0) ?></td>
                                <td>
                                    <span class="badge bg-<?= $hostel['status'] == 'active' ? 'success' : 'secondary' ?>">
                                        <?= ucfirst($hostel['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="/hostel/<?= $hostel['id'] ?>/rooms" class="btn btn-sm btn-info">Rooms</a>
                                    <a href="/hostel/<?= $hostel['id'] ?>/edit" class="btn btn-sm btn-warning">Edit</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body text-center">
                <i class="bi bi-door-open display-4 text-primary"></i>
                <h5 class="mt-2">Room Management</h5>
                <a href="/hostel/rooms" class="btn btn-primary">Manage Rooms</a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body text-center">
                <i class="bi bi-people display-4 text-success"></i>
                <h5 class="mt-2">Allocations</h5>
                <a href="/hostel/allocations" class="btn btn-success">View Allocations</a>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>