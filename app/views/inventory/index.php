<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-box-seam me-2"></i>Inventory Management</h2>
    <a href="/inventory/create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Add New Item
    </a>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h6>Total Items</h6>
                <h3><?= $stats['total_items'] ?? 0 ?></h3>
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
        <div class="card bg-warning text-white">
            <div class="card-body">
                <h6>Low Stock</h6>
                <h3><?= $stats['low_stock_items'] ?? 0 ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <h6>Out of Stock</h6>
                <h3><?= $stats['out_of_stock'] ?? 0 ?></h3>
            </div>
        </div>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search items..." value="<?= htmlspecialchars($filters['search'] ?? '') ?>">
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
                    <option value="in_stock" <?= ($filters['status'] ?? '') == 'in_stock' ? 'selected' : '' ?>>In Stock</option>
                    <option value="low_stock" <?= ($filters['status'] ?? '') == 'low_stock' ? 'selected' : '' ?>>Low Stock</option>
                    <option value="out_of_stock" <?= ($filters['status'] ?? '') == 'out_of_stock' ? 'selected' : '' ?>>Out of Stock</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Category</th>
                        <th>SKU</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total Value</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($items)): ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                No items found. Click "Add New Item" to get started.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($item['item_name']) ?></strong></td>
                                <td><?= htmlspecialchars($item['category'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($item['sku'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($item['quantity']) ?></td>
                                <td>₹<?= number_format($item['unit_price'] ?? 0, 2) ?></td>
                                <td>₹<?= number_format(($item['quantity'] ?? 0) * ($item['unit_price'] ?? 0), 2) ?></td>
                                <td>
                                    <?php
                                    $status = 'in_stock';
                                    $badge = 'success';
                                    if ($item['quantity'] == 0) {
                                        $status = 'out_of_stock';
                                        $badge = 'danger';
                                    } elseif ($item['quantity'] <= ($item['reorder_level'] ?? 0)) {
                                        $status = 'low_stock';
                                        $badge = 'warning';
                                    }
                                    ?>
                                    <span class="badge bg-<?= $badge ?>">
                                        <?= str_replace('_', ' ', ucwords($status)) ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="/inventory/<?= $item['id'] ?>" class="btn btn-sm btn-info">View</a>
                                    <a href="/inventory/<?= $item['id'] ?>/edit" class="btn btn-sm btn-warning">Edit</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <i class="bi bi-diagram-3 display-4 text-primary"></i>
                <h5 class="mt-2">Asset Management</h5>
                <a href="/inventory/assets" class="btn btn-primary">Manage Assets</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <i class="bi bi-cart display-4 text-success"></i>
                <h5 class="mt-2">Purchase Orders</h5>
                <a href="/inventory/purchase-orders" class="btn btn-success">View Orders</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <i class="bi bi-bar-chart display-4 text-info"></i>
                <h5 class="mt-2">Stock Reports</h5>
                <a href="/inventory/reports" class="btn btn-info">View Reports</a>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>