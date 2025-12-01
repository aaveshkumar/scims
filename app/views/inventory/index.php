<?php include __DIR__ . '/../layouts/header.php'; ?>

<style>
    html[data-bs-theme="dark"] .card-header.bg-light {
        background-color: var(--bs-gray-800) !important;
        color: var(--bs-body-color) !important;
        border-color: var(--bs-border-color) !important;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-box-seam me-2"></i>Asset Management</h2>
    <a href="/inventory/assets/create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Add New Asset
    </a>
</div>

<!-- Navigation Tabs -->
<ul class="nav nav-tabs mb-4">
    <li class="nav-item">
        <a class="nav-link active" href="/inventory/assets"><i class="bi bi-diagram-3 me-1"></i>Assets</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/inventory/stock"><i class="bi bi-box me-1"></i>Stock</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/inventory/purchase-orders"><i class="bi bi-cart me-1"></i>Purchase Orders</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/inventory/suppliers"><i class="bi bi-people me-1"></i>Suppliers</a>
    </li>
</ul>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h6>Total Assets</h6>
                <h3><?= $stats['total_assets'] ?? 0 ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h6>Total Value</h6>
                <h3>₹<?= number_format($stats['total_value'] ?? 0, 0) ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h6>Assigned Assets</h6>
                <h3><?= $stats['assigned_assets'] ?? 0 ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-dark">
            <div class="card-body">
                <h6>Warranty Expiring</h6>
                <h3><?= $stats['warranty_expiring'] ?? 0 ?></h3>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card mb-3">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search by code or name..." value="<?= htmlspecialchars($filters['search'] ?? '') ?>">
            </div>
            <div class="col-md-3">
                <select name="category" class="form-select">
                    <option value="">All Categories</option>
                    <?php foreach ($categories ?? [] as $cat): ?>
                        <option value="<?= htmlspecialchars($cat['category']) ?>" <?= ($filters['category'] ?? '') == $cat['category'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['category']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="active" <?= ($filters['status'] ?? '') == 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= ($filters['status'] ?? '') == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                    <option value="maintenance" <?= ($filters['status'] ?? '') == 'maintenance' ? 'selected' : '' ?>>Under Maintenance</option>
                    <option value="disposed" <?= ($filters['status'] ?? '') == 'disposed' ? 'selected' : '' ?>>Disposed</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </form>
    </div>
</div>

<!-- Assets Table -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Asset Code</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Location</th>
                        <th>Assigned To</th>
                        <th>Purchase Cost</th>
                        <th>Current Value</th>
                        <th>Condition</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($assets)): ?>
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                No assets found. Click "Add New Asset" to get started.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($assets as $asset): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($asset['asset_code']) ?></strong></td>
                                <td><?= htmlspecialchars($asset['name']) ?></td>
                                <td><?= htmlspecialchars($asset['category'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($asset['location'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($asset['assigned_to_name'] ?? 'Unassigned') ?></td>
                                <td>₹<?= number_format($asset['purchase_cost'] ?? 0, 2) ?></td>
                                <td>₹<?= number_format($asset['current_value'] ?? 0, 2) ?></td>
                                <td>
                                    <?php
                                    $conditionBadge = match($asset['condition'] ?? 'good') {
                                        'excellent' => 'success',
                                        'good' => 'primary',
                                        'fair' => 'warning',
                                        'poor' => 'danger',
                                        default => 'secondary'
                                    };
                                    ?>
                                    <span class="badge bg-<?= $conditionBadge ?>">
                                        <?= ucfirst($asset['condition'] ?? 'N/A') ?>
                                    </span>
                                </td>
                                <td>
                                    <?php
                                    $statusBadge = match($asset['status'] ?? 'active') {
                                        'active' => 'success',
                                        'inactive' => 'secondary',
                                        'maintenance' => 'warning',
                                        'disposed' => 'danger',
                                        default => 'secondary'
                                    };
                                    ?>
                                    <span class="badge bg-<?= $statusBadge ?>">
                                        <?= ucfirst($asset['status'] ?? 'N/A') ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="/inventory/assets/<?= $asset['id'] ?>" class="btn btn-sm btn-info" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="/inventory/assets/<?= $asset['id'] ?>/edit" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" action="/inventory/assets/<?= $asset['id'] ?>/delete" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this asset?');">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
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
