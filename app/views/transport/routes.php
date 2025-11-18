<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-geo-alt me-2"></i>Route Management</h2>
    <div>
        <a href="/transport" class="btn btn-secondary me-2">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRouteModal">
            <i class="bi bi-plus-circle me-2"></i>Add Route
        </button>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Route Name</th>
                        <th>Stops</th>
                        <th>Distance (km)</th>
                        <th>Fare</th>
                        <th>Assigned Vehicle</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($routes)): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                No routes found. Click "Add Route" to get started.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($routes as $route): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($route['route_name']) ?></strong></td>
                                <td><?= htmlspecialchars($route['stops']) ?></td>
                                <td><?= htmlspecialchars($route['distance_km'] ?? 'N/A') ?></td>
                                <td>₹<?= number_format($route['fare'] ?? 0, 2) ?></td>
                                <td><?= htmlspecialchars($route['vehicle_number'] ?? 'Unassigned') ?></td>
                                <td>
                                    <span class="badge bg-<?= $route['status'] == 'active' ? 'success' : 'secondary' ?>">
                                        <?= ucfirst($route['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-info">View</button>
                                    <button class="btn btn-sm btn-warning">Edit</button>
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
