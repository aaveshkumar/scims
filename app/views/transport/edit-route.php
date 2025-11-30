<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Edit Route</h1>
        <p class="text-muted mb-0">Update route information</p>
    </div>
    <a href="/transport/routes" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="/transport/routes/<?= $route['id'] ?>">
            <?= csrf_field() ?>
            
            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-geo-alt me-2"></i>Route Details
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Route Name *</label>
                        <input type="text" name="route_name" class="form-control" value="<?= htmlspecialchars($route['route_name']) ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Route Number *</label>
                        <input type="text" name="route_number" class="form-control" value="<?= htmlspecialchars($route['route_number']) ?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Start Point *</label>
                        <input type="text" name="start_point" class="form-control" value="<?= htmlspecialchars($route['start_point']) ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">End Point *</label>
                        <input type="text" name="end_point" class="form-control" value="<?= htmlspecialchars($route['end_point']) ?>" required>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-speedometer me-2"></i>Distance & Fare
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Distance (km)</label>
                        <input type="number" name="distance" class="form-control" value="<?= htmlspecialchars($route['distance']) ?>" step="0.1" min="0">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Fare (₹)</label>
                        <input type="number" name="fare" class="form-control" value="<?= htmlspecialchars($route['fare']) ?>" step="0.01" min="0">
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-gear me-2"></i>Settings
                </h6>
                <div class="mb-3">
                    <label class="form-label fw-bold">Status</label>
                    <select name="status" class="form-select">
                        <option value="active" <?= $route['status'] == 'active' ? 'selected' : '' ?>>Active</option>
                        <option value="inactive" <?= $route['status'] == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                        <option value="suspended" <?= $route['status'] == 'suspended' ? 'selected' : '' ?>>Suspended</option>
                    </select>
                </div>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Update Route
                </button>
                <a href="/transport/routes" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
