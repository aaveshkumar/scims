<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-truck me-2"></i>Transport Management</h2>
    <a href="/transport/create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Add New Vehicle
    </a>
</div>

<ul class="nav nav-tabs mb-4" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link active" href="/transport/vehicles">
            <i class="bi bi-truck me-2"></i>Vehicles
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" href="/transport/drivers">
            <i class="bi bi-people me-2"></i>Drivers
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" href="/transport/routes">
            <i class="bi bi-geo-alt me-2"></i>Routes
        </a>
    </li>
</ul>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h6>Total Vehicles</h6>
                <h3><?= $stats['total_vehicles'] ?? 0 ?></h3>
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
                <h6>Active Vehicles</h6>
                <h3><?= $stats['active_vehicles'] ?? 0 ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <h6>Expiring Soon</h6>
                <h3><?= $stats['expiring_soon'] ?? 0 ?></h3>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search vehicles..." value="<?= htmlspecialchars($filters['search'] ?? '') ?>">
            </div>
            <div class="col-md-3">
                <select name="vehicle_type" class="form-select">
                    <option value="">All Types</option>
                    <option value="Bus" <?= ($filters['vehicle_type'] ?? '') == 'Bus' ? 'selected' : '' ?>>Bus</option>
                    <option value="Van" <?= ($filters['vehicle_type'] ?? '') == 'Van' ? 'selected' : '' ?>>Van</option>
                    <option value="Car" <?= ($filters['vehicle_type'] ?? '') == 'Car' ? 'selected' : '' ?>>Car</option>
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
                        <th>Vehicle Number</th>
                        <th>Type</th>
                        <th>Model</th>
                        <th>Capacity</th>
                        <th>Insurance Expiry</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($vehicles)): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                No vehicles found. Click "Add New Vehicle" to get started.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($vehicles as $vehicle): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($vehicle['vehicle_number']) ?></strong></td>
                                <td><?= htmlspecialchars($vehicle['vehicle_type'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($vehicle['model'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($vehicle['capacity']) ?></td>
                                <td><?= $vehicle['insurance_expiry'] ? date('M d, Y', strtotime($vehicle['insurance_expiry'])) : 'N/A' ?></td>
                                <td>
                                    <span class="badge bg-<?= $vehicle['status'] == 'active' ? 'success' : 'secondary' ?>">
                                        <?= ucfirst($vehicle['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="/transport/vehicles/<?= $vehicle['id'] ?>" class="btn btn-sm btn-info">View</a>
                                    <a href="/transport/vehicles/<?= $vehicle['id'] ?>/edit" class="btn btn-sm btn-warning">Edit</a>
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
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <i class="bi bi-geo-alt display-4 text-primary"></i>
                <h5 class="mt-2">Routes</h5>
                <a href="/transport/routes" class="btn btn-primary">Manage Routes</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <i class="bi bi-people display-4 text-success"></i>
                <h5 class="mt-2">Assignments</h5>
                <a href="/transport/assignments" class="btn btn-success">View Assignments</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <i class="bi bi-tools display-4 text-warning"></i>
                <h5 class="mt-2">Maintenance</h5>
                <a href="/transport/maintenance" class="btn btn-warning">View Records</a>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>