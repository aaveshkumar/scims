<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Add New Route</h1>
        <p class="text-muted mb-0">Create a new transport route</p>
    </div>
    <a href="/transport/routes" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="/transport/routes/store">
            <?= csrf_field() ?>
            
            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-geo-alt me-2"></i>Route Details
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Route Name *</label>
                        <input type="text" name="route_name" class="form-control" placeholder="e.g., Main City Route" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Route Number *</label>
                        <input type="text" name="route_number" class="form-control" placeholder="e.g., RT-001" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Start Point *</label>
                        <input type="text" name="start_point" class="form-control" placeholder="e.g., City Center" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">End Point *</label>
                        <input type="text" name="end_point" class="form-control" placeholder="e.g., Railway Station" required>
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
                        <input type="number" name="distance" class="form-control" placeholder="e.g., 15.5" step="0.1" min="0">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Fare (₹)</label>
                        <input type="number" name="fare" class="form-control" placeholder="e.g., 50" step="0.01" min="0">
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-people me-2"></i>Assignments
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Vehicle</label>
                        <select name="vehicle_id" class="form-select">
                            <option value="">-- Select Vehicle --</option>
                            <?php if (!empty($availableVehicles)): ?>
                                <?php foreach ($availableVehicles as $vehicle): ?>
                                    <option value="<?= $vehicle['id'] ?>"><?= htmlspecialchars($vehicle['vehicle_number']) ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Driver</label>
                        <select name="driver_id" class="form-select">
                            <option value="">-- Select Driver --</option>
                            <?php if (!empty($drivers)): ?>
                                <?php foreach ($drivers as $driver): ?>
                                    <option value="<?= $driver['id'] ?>"><?= htmlspecialchars($driver['name']) ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
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
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="suspended">Suspended</option>
                    </select>
                </div>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Create Route
                </button>
                <a href="/transport/routes" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
