<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0"><?= htmlspecialchars($route['route_name']) ?></h1>
        <p class="text-muted mb-0">Route Details</p>
    </div>
    <div>
        <a href="/transport/routes/<?= $route['id'] ?>/edit" class="btn btn-warning me-2">
            <i class="bi bi-pencil me-2"></i>Edit
        </a>
        <a href="/transport/routes" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Route Information</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="text-muted small">Route Name</label>
                    <p class="fw-bold"><?= htmlspecialchars($route['route_name']) ?></p>
                </div>
                <div class="mb-3">
                    <label class="text-muted small">Route Number</label>
                    <p class="fw-bold"><?= htmlspecialchars($route['route_number']) ?></p>
                </div>
                <div class="mb-3">
                    <label class="text-muted small">Start Point</label>
                    <p class="fw-bold"><?= htmlspecialchars($route['start_point']) ?></p>
                </div>
                <div class="mb-3">
                    <label class="text-muted small">End Point</label>
                    <p class="fw-bold"><?= htmlspecialchars($route['end_point']) ?></p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Financial & Status</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="text-muted small">Distance (km)</label>
                    <p class="fw-bold"><?= htmlspecialchars($route['distance']) ?> km</p>
                </div>
                <div class="mb-3">
                    <label class="text-muted small">Fare (₹)</label>
                    <p class="fw-bold">₹<?= number_format($route['fare'], 2) ?></p>
                </div>
                <div class="mb-3">
                    <label class="text-muted small">Status</label>
                    <p><span class="badge bg-<?= $route['status'] == 'active' ? 'success' : 'secondary' ?>"><?= ucfirst($route['status']) ?></span></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
