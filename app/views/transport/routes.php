<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-geo-alt me-2"></i>Route Management</h2>
    <div>
        <a href="/transport/routes/create" class="btn btn-primary me-2">
            <i class="bi bi-plus-circle me-2"></i>Add Route
        </a>
    </div>
</div>

<ul class="nav nav-tabs mb-4" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link" href="/transport/vehicles">
            <i class="bi bi-truck me-2"></i>Vehicles
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" href="/transport/drivers">
            <i class="bi bi-people me-2"></i>Drivers
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link active" href="/transport/routes">
            <i class="bi bi-geo-alt me-2"></i>Routes
        </a>
    </li>
</ul>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h6>Total Routes</h6>
                <h3><?= $stats['total_routes'] ?? 0 ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h6>Active Vehicles</h6>
                <h3><?= count($availableVehicles) ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h6>Available Drivers</h6>
                <h3><?= count($drivers) ?></h3>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Routes List</h5>
    </div>
    <div class="card-body">
        <?php if (empty($routes)): ?>
            <div class="text-center text-muted py-5">
                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                <p>No routes configured yet.</p>
                <p class="small">Routes are managed through the Route Management system.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Route Name</th>
                            <th>Route Number</th>
                            <th>Start Point</th>
                            <th>End Point</th>
                            <th>Distance</th>
                            <th>Fare</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($routes as $route): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($route['route_name'] ?? 'N/A') ?></strong></td>
                                <td><?= htmlspecialchars($route['route_number'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($route['start_point'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($route['end_point'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($route['distance'] ?? 'N/A') ?> km</td>
                                <td>₹<?= number_format($route['fare'] ?? 0, 2) ?></td>
                                <td>
                                    <span class="badge bg-<?= ($route['status'] ?? 'active') == 'active' ? 'success' : 'secondary' ?>">
                                        <?= ucfirst($route['status'] ?? 'active') ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="/transport/routes/<?= $route['id'] ?>" class="btn btn-outline-info btn-sm" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="/transport/routes/<?= $route['id'] ?>/edit" class="btn btn-outline-warning btn-sm" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form method="POST" action="/transport/routes/<?= $route['id'] ?>/delete" style="display: inline;">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure you want to delete this route?')" title="Delete">
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
    </div>
</div>


<?php include __DIR__ . '/../layouts/footer.php'; ?>
