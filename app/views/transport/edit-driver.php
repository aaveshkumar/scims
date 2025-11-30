<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Edit Driver</h1>
        <p class="text-muted mb-0">Update driver information</p>
    </div>
    <a href="/transport/drivers" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="/transport/drivers/<?= $driver['id'] ?>">
            <?= csrf_field() ?>
            
            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-person me-2"></i>Personal Information
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">First Name *</label>
                        <input type="text" name="first_name" class="form-control" value="<?= htmlspecialchars($driver['first_name']) ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Last Name *</label>
                        <input type="text" name="last_name" class="form-control" value="<?= htmlspecialchars($driver['last_name']) ?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Email *</label>
                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($driver['email']) ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Phone</label>
                        <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($driver['phone'] ?? '') ?>">
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-card-text me-2"></i>License Information
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">License Number *</label>
                        <input type="text" name="license_number" class="form-control" value="<?= htmlspecialchars($driver['license_number'] ?? '') ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">License Expiry Date</label>
                        <input type="date" name="license_expiry" class="form-control" value="<?= htmlspecialchars($driver['license_expiry'] ?? '') ?>">
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-lock me-2"></i>Account Settings
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Status</label>
                        <select name="status" class="form-select">
                            <option value="active" <?= ($driver['status'] ?? 'active') == 'active' ? 'selected' : '' ?>>Active</option>
                            <option value="inactive" <?= ($driver['status'] ?? 'active') == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Update Driver
                </button>
                <a href="/transport/drivers" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
