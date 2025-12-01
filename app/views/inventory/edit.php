<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Edit Asset</h2>
    <a href="/inventory" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="/inventory/assets/<?= $asset['id'] ?>">
            <?= csrf_field() ?>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Asset Code *</label>
                        <input type="text" name="asset_code" class="form-control" value="<?= htmlspecialchars($asset['asset_code']) ?>" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Name *</label>
                        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($asset['name']) ?>" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <input type="text" name="category" class="form-control" value="<?= htmlspecialchars($asset['category'] ?? '') ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Location</label>
                        <input type="text" name="location" class="form-control" value="<?= htmlspecialchars($asset['location'] ?? '') ?>">
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($asset['description'] ?? '') ?></textarea>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Purchase Date</label>
                        <input type="date" name="purchase_date" class="form-control" value="<?= $asset['purchase_date'] ? date('Y-m-d', strtotime($asset['purchase_date'])) : '' ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Warranty Expiry Date</label>
                        <input type="date" name="warranty_expiry" class="form-control" value="<?= $asset['warranty_expiry'] ? date('Y-m-d', strtotime($asset['warranty_expiry'])) : '' ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Purchase Cost (₹)</label>
                        <input type="number" name="purchase_cost" class="form-control" step="0.01" value="<?= htmlspecialchars($asset['purchase_cost'] ?? '') ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Current Value (₹)</label>
                        <input type="number" name="current_value" class="form-control" step="0.01" value="<?= htmlspecialchars($asset['current_value'] ?? '') ?>">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Depreciation Rate (%) per year</label>
                        <input type="number" name="depreciation_rate" class="form-control" step="0.01" value="<?= htmlspecialchars($asset['depreciation_rate'] ?? '') ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Condition</label>
                        <select name="item_condition" class="form-select">
                            <option value="excellent" <?= ($asset['condition'] ?? '') === 'excellent' ? 'selected' : '' ?>>Excellent</option>
                            <option value="good" <?= ($asset['condition'] ?? '') === 'good' ? 'selected' : '' ?>>Good</option>
                            <option value="fair" <?= ($asset['condition'] ?? '') === 'fair' ? 'selected' : '' ?>>Fair</option>
                            <option value="poor" <?= ($asset['condition'] ?? '') === 'poor' ? 'selected' : '' ?>>Poor</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Assigned To</label>
                        <select name="assigned_to" class="form-select">
                            <option value="">-- Select User --</option>
                            <?php foreach ($users as $user): ?>
                                <option value="<?= $user['id'] ?>" <?= ($asset['assigned_to'] ?? '') == $user['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($user['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="active" <?= ($asset['status'] ?? '') === 'active' ? 'selected' : '' ?>>Active</option>
                            <option value="inactive" <?= ($asset['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Update Asset
                </button>
                <a href="/inventory" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
