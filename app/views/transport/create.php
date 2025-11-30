<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0"><i class="bi bi-truck me-2"></i>Add New Vehicle</h1>
        <p class="text-muted mb-0">Register a new vehicle in the system</p>
    </div>
    <a href="/transport/vehicles" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="/transport/vehicles">
            <?= csrf_field() ?>
            
            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-truck me-2"></i>Vehicle Details
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Vehicle Number *</label>
                        <input type="text" name="vehicle_number" class="form-control" placeholder="e.g., DL01AB1234" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Vehicle Type *</label>
                        <select name="vehicle_type" class="form-select" required>
                            <option value="">-- Select Type --</option>
                            <option value="Bus">Bus</option>
                            <option value="Van">Van</option>
                            <option value="Car">Car</option>
                            <option value="Minibus">Minibus</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Manufacturer</label>
                        <input type="text" name="manufacturer" class="form-control" placeholder="e.g., Tata Motors">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Model</label>
                        <input type="text" name="model" class="form-control" placeholder="e.g., Starbus">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Year of Manufacture</label>
                        <input type="number" name="year" class="form-control" placeholder="e.g., 2020" min="1990">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Fuel Type</label>
                        <select name="fuel_type" class="form-select">
                            <option value="">-- Select Fuel Type --</option>
                            <option value="Petrol">Petrol</option>
                            <option value="Diesel">Diesel</option>
                            <option value="CNG">CNG</option>
                            <option value="Electric">Electric</option>
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
                        <input type="number" name="capacity" class="form-control" placeholder="e.g., 50" min="1" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Registration Date</label>
                        <input type="date" name="registration_date" class="form-control">
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
                        <input type="date" name="insurance_expiry" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Fitness Certificate Expiry</label>
                        <input type="date" name="fitness_expiry" class="form-control">
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
                        <option value="maintenance">Under Maintenance</option>
                    </select>
                </div>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Add Vehicle
                </button>
                <a href="/transport/vehicles" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>