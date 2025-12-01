<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Asset Details</h2>
    <div>
        <a href="/inventory/assets/<?= $asset['id'] ?>/edit" class="btn btn-warning">
            <i class="bi bi-pencil me-2"></i>Edit
        </a>
        <a href="/inventory" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><?= htmlspecialchars($asset['name']) ?></h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th class="w-25">Asset Code:</th>
                        <td><?= htmlspecialchars($asset['asset_code']) ?></td>
                    </tr>
                    <tr>
                        <th>Category:</th>
                        <td><?= htmlspecialchars($asset['category']) ?></td>
                    </tr>
                    <tr>
                        <th>Description:</th>
                        <td><?= htmlspecialchars($asset['description']) ?></td>
                    </tr>
                    <tr>
                        <th>Location:</th>
                        <td><?= htmlspecialchars($asset['location']) ?></td>
                    </tr>
                    <tr>
                        <th>Condition:</th>
                        <td>
                            <?php
                            $conditionBadgeClass = match($asset['condition']) {
                                'excellent' => 'success',
                                'good' => 'info',
                                'fair' => 'warning',
                                'poor' => 'danger',
                                default => 'secondary'
                            };
                            ?>
                            <span class="badge bg-<?= $conditionBadgeClass ?>"><?= ucfirst($asset['condition']) ?></span>
                        </td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td>
                            <span class="badge bg-<?= $asset['status'] === 'active' ? 'success' : 'danger' ?>">
                                <?= ucfirst($asset['status']) ?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Assigned To:</th>
                        <td><?= htmlspecialchars($asset['assigned_to_name'] ?? 'Unassigned') ?></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Financial Details</h5>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th class="w-25">Purchase Date:</th>
                        <td><?= $asset['purchase_date'] ? date('d-m-Y', strtotime($asset['purchase_date'])) : 'N/A' ?></td>
                    </tr>
                    <tr>
                        <th>Purchase Cost:</th>
                        <td>₹ <?= number_format($asset['purchase_cost'] ?? 0, 2) ?></td>
                    </tr>
                    <tr>
                        <th>Current Value:</th>
                        <td>₹ <?= number_format($asset['current_value'] ?? 0, 2) ?></td>
                    </tr>
                    <tr>
                        <th>Depreciation Rate:</th>
                        <td><?= htmlspecialchars($asset['depreciation_rate'] ?? 0) ?>% per year</td>
                    </tr>
                    <tr>
                        <th>Warranty Expiry:</th>
                        <td><?= $asset['warranty_expiry'] ? date('d-m-Y', strtotime($asset['warranty_expiry'])) : 'No warranty' ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card bg-light">
            <div class="card-header">
                <h5 class="mb-0">Actions</h5>
            </div>
            <div class="card-body d-flex flex-column gap-2">
                <a href="/inventory/assets/<?= $asset['id'] ?>/edit" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil me-2"></i>Edit Asset
                </a>
                <form method="POST" action="/inventory/assets/<?= $asset['id'] ?>/delete" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this asset?');">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-danger btn-sm w-100">
                        <i class="bi bi-trash me-2"></i>Delete Asset
                    </button>
                </form>
                <a href="/inventory" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-left me-2"></i>Back to Assets
                </a>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
