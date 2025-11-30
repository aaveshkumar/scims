<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Edit Vehicle</h1>
        <p class="text-muted mb-0">Update vehicle information</p>
    </div>
    <a href="/transport/vehicles" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="/transport/vehicles/<?= $vehicle['id'] ?>">
            <?= csrf_field() ?>
            
            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-truck me-2"></i>Vehicle Details
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Vehicle Number *</label>
                        <input type="text" name="vehicle_number" class="form-control" value="<?= htmlspecialchars($vehicle['vehicle_number']) ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Vehicle Type *</label>
                        <select name="vehicle_type" class="form-select" required>
                            <option value="Bus" <?= $vehicle['vehicle_type'] === 'Bus' ? 'selected' : '' ?>>Bus</option>
                            <option value="Van" <?= $vehicle['vehicle_type'] === 'Van' ? 'selected' : '' ?>>Van</option>
                            <option value="Car" <?= $vehicle['vehicle_type'] === 'Car' ? 'selected' : '' ?>>Car</option>
                            <option value="Minibus" <?= $vehicle['vehicle_type'] === 'Minibus' ? 'selected' : '' ?>>Minibus</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Manufacturer</label>
                        <input type="text" name="manufacturer" class="form-control" value="<?= htmlspecialchars($vehicle['manufacturer'] ?? '') ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Model</label>
                        <input type="text" name="model" class="form-control" value="<?= htmlspecialchars($vehicle['model'] ?? '') ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Year of Manufacture</label>
                        <input type="number" name="year" class="form-control" value="<?= $vehicle['year'] ?? '' ?>" min="1990">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Fuel Type</label>
                        <select name="fuel_type" class="form-select">
                            <option value="">-- Select Fuel Type --</option>
                            <option value="Petrol" <?= ($vehicle['fuel_type'] ?? '') === 'Petrol' ? 'selected' : '' ?>>Petrol</option>
                            <option value="Diesel" <?= ($vehicle['fuel_type'] ?? '') === 'Diesel' ? 'selected' : '' ?>>Diesel</option>
                            <option value="CNG" <?= ($vehicle['fuel_type'] ?? '') === 'CNG' ? 'selected' : '' ?>>CNG</option>
                            <option value="Electric" <?= ($vehicle['fuel_type'] ?? '') === 'Electric' ? 'selected' : '' ?>>Electric</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-people me-2"></i>Capacity & Registration
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Seating Capacity *</label>
                        <input type="number" name="capacity" class="form-control" value="<?= $vehicle['capacity'] ?>" min="1" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Registration Date</label>
                        <input type="date" name="registration_date" class="form-control" value="<?= $vehicle['registration_date'] ?? '' ?>">
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-shield-check me-2"></i>Certifications & Expiry
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Insurance Expiry</label>
                        <input type="date" name="insurance_expiry" class="form-control" value="<?= $vehicle['insurance_expiry'] ?? '' ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Fitness Certificate Expiry</label>
                        <input type="date" name="fitness_expiry" class="form-control" value="<?= $vehicle['fitness_expiry'] ?? '' ?>">
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
                        <option value="active" <?= $vehicle['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                        <option value="inactive" <?= $vehicle['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                        <option value="maintenance" <?= $vehicle['status'] === 'maintenance' ? 'selected' : '' ?>>Under Maintenance</option>
                    </select>
                </div>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Update Vehicle
                </button>
                <a href="/transport/vehicles" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
