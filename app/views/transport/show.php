<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0"><?= htmlspecialchars($vehicle['vehicle_number']) ?></h1>
        <p class="text-muted mb-0"><?= htmlspecialchars($vehicle['manufacturer'] . ' ' . $vehicle['model']) ?></p>
    </div>
    <div>
        <a href="/transport/vehicles/<?= $vehicle['id'] ?>/edit" class="btn btn-warning me-2">
            <i class="bi bi-pencil me-2"></i>Edit
        </a>
        <form method="POST" action="/transport/vehicles/<?= $vehicle['id'] ?>/delete" style="display: inline;" onsubmit="return confirm('Delete this vehicle?');">
            <?= csrf_field() ?>
            <button type="submit" class="btn btn-danger me-2">
                <i class="bi bi-trash me-2"></i>Delete
            </button>
        </form>
        <a href="/transport/vehicles" class="btn btn-secondary">Back</a>
    </div>
</div>

<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card">
            <div class="card-body text-center">
                <label class="fw-bold text-muted">Vehicle Type</label>
                <h5><?= htmlspecialchars($vehicle['vehicle_type']) ?></h5>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card">
            <div class="card-body text-center">
                <label class="fw-bold text-muted">Year</label>
                <h5><?= $vehicle['year'] ?></h5>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card">
            <div class="card-body text-center">
                <label class="fw-bold text-muted">Capacity</label>
                <h5><?= $vehicle['capacity'] ?> Seats</h5>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card">
            <div class="card-body text-center">
                <label class="fw-bold text-muted">Status</label>
                <h5><span class="badge bg-<?= $vehicle['status'] === 'active' ? 'success' : ($vehicle['status'] === 'maintenance' ? 'warning' : 'danger') ?>"><?= ucfirst($vehicle['status']) ?></span></h5>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Vehicle Information</h5>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="fw-bold text-muted">Manufacturer</label>
                <p><?= htmlspecialchars($vehicle['manufacturer'] ?? 'N/A') ?></p>
            </div>
            <div class="col-md-6">
                <label class="fw-bold text-muted">Model</label>
                <p><?= htmlspecialchars($vehicle['model'] ?? 'N/A') ?></p>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="fw-bold text-muted">Fuel Type</label>
                <p><?= htmlspecialchars($vehicle['fuel_type'] ?? 'N/A') ?></p>
            </div>
            <div class="col-md-6">
                <label class="fw-bold text-muted">Registration Date</label>
                <p><?= $vehicle['registration_date'] ? date('M d, Y', strtotime($vehicle['registration_date'])) : 'Not set' ?></p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-shield-check me-2"></i>Insurance</h6>
            </div>
            <div class="card-body">
                <label class="fw-bold text-muted">Expiry Date</label>
                <p><?= $vehicle['insurance_expiry'] ? date('M d, Y', strtotime($vehicle['insurance_expiry'])) : 'Not set' ?></p>
                <?php if ($vehicle['insurance_expiry']): ?>
                    <span class="badge bg-<?= strtotime($vehicle['insurance_expiry']) < strtotime('+30 days') ? 'danger' : 'success' ?>">
                        <?= strtotime($vehicle['insurance_expiry']) < strtotime('+30 days') ? 'Expiring Soon' : 'Valid' ?>
                    </span>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-check-circle me-2"></i>Fitness Certificate</h6>
            </div>
            <div class="card-body">
                <label class="fw-bold text-muted">Expiry Date</label>
                <p><?= $vehicle['fitness_expiry'] ? date('M d, Y', strtotime($vehicle['fitness_expiry'])) : 'Not set' ?></p>
                <?php if ($vehicle['fitness_expiry']): ?>
                    <span class="badge bg-<?= strtotime($vehicle['fitness_expiry']) < strtotime('+30 days') ? 'danger' : 'success' ?>">
                        <?= strtotime($vehicle['fitness_expiry']) < strtotime('+30 days') ? 'Expiring Soon' : 'Valid' ?>
                    </span>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
