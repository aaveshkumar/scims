<?php include __DIR__ . '/../layouts/header.php'; ?>

<style>
    html[data-bs-theme="dark"] .card-header.bg-light {
        background-color: var(--bs-gray-800) !important;
        color: var(--bs-body-color) !important;
        border-color: var(--bs-border-color) !important;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-box me-2"></i>Stock Management</h2>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addStockModal">
        <i class="bi bi-plus-circle me-2"></i>Add Stock Item
    </button>
</div>

<!-- Navigation Tabs -->
<ul class="nav nav-tabs mb-4">
    <li class="nav-item">
        <a class="nav-link" href="/inventory/assets"><i class="bi bi-diagram-3 me-1"></i>Assets</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="/inventory/stock"><i class="bi bi-box me-1"></i>Stock</a>
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
        <div class="card bg-warning text-dark">
            <div class="card-body">
                <h6>Low Stock Items</h6>
                <h3><?= $stats['low_stock'] ?? 0 ?></h3>
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

<!-- Stock Table -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Item Code</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Unit</th>
                        <th>Quantity</th>
                        <th>Reorder Level</th>
                        <th>Unit Price</th>
                        <th>Total Value</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($items)): ?>
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                No stock items found. Click "Add Stock Item" to get started.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($item['item_code']) ?></strong></td>
                                <td><?= htmlspecialchars($item['name']) ?></td>
                                <td><?= htmlspecialchars($item['category'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($item['unit'] ?? 'piece') ?></td>
                                <td>
                                    <?php
                                    $qtyClass = 'text-success';
                                    if ($item['quantity'] == 0) $qtyClass = 'text-danger';
                                    elseif ($item['quantity'] <= ($item['reorder_level'] ?? 10)) $qtyClass = 'text-warning';
                                    ?>
                                    <strong class="<?= $qtyClass ?>"><?= $item['quantity'] ?></strong>
                                </td>
                                <td><?= $item['reorder_level'] ?? 10 ?></td>
                                <td>₹<?= number_format($item['unit_price'] ?? 0, 2) ?></td>
                                <td>₹<?= number_format(($item['quantity'] ?? 0) * ($item['unit_price'] ?? 0), 2) ?></td>
                                <td>
                                    <?php
                                    $statusBadge = match($item['status'] ?? 'in_stock') {
                                        'in_stock' => 'success',
                                        'low_stock' => 'warning',
                                        'out_of_stock' => 'danger',
                                        default => 'secondary'
                                    };
                                    ?>
                                    <span class="badge bg-<?= $statusBadge ?>">
                                        <?= str_replace('_', ' ', ucfirst($item['status'] ?? 'in_stock')) ?>
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-warning" title="Edit" data-bs-toggle="modal" data-bs-target="#editStockModal<?= $item['id'] ?>">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <form method="POST" action="/inventory/stock/<?= $item['id'] ?>/delete" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this item?');">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            
                            <!-- Edit Modal for each item -->
                            <div class="modal fade" id="editStockModal<?= $item['id'] ?>" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <form method="POST" action="/inventory/stock/<?= $item['id'] ?>">
                                            <?= csrf_field() ?>
                                            <div class="modal-header">
                                                <h5 class="modal-title"><i class="bi bi-pencil me-2"></i>Edit Stock Item</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Item Code *</label>
                                                        <input type="text" name="item_code" class="form-control" value="<?= htmlspecialchars($item['item_code']) ?>" required>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Name *</label>
                                                        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($item['name']) ?>" required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Category</label>
                                                        <input type="text" name="category" class="form-control" value="<?= htmlspecialchars($item['category'] ?? '') ?>">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Unit</label>
                                                        <select name="unit" class="form-select">
                                                            <option value="piece" <?= ($item['unit'] ?? '') == 'piece' ? 'selected' : '' ?>>Piece</option>
                                                            <option value="kg" <?= ($item['unit'] ?? '') == 'kg' ? 'selected' : '' ?>>Kilogram</option>
                                                            <option value="litre" <?= ($item['unit'] ?? '') == 'litre' ? 'selected' : '' ?>>Litre</option>
                                                            <option value="box" <?= ($item['unit'] ?? '') == 'box' ? 'selected' : '' ?>>Box</option>
                                                            <option value="pack" <?= ($item['unit'] ?? '') == 'pack' ? 'selected' : '' ?>>Pack</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4 mb-3">
                                                        <label class="form-label">Quantity</label>
                                                        <input type="number" name="quantity" class="form-control" value="<?= $item['quantity'] ?? 0 ?>" min="0">
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <label class="form-label">Reorder Level</label>
                                                        <input type="number" name="reorder_level" class="form-control" value="<?= $item['reorder_level'] ?? 10 ?>" min="0">
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <label class="form-label">Unit Price (₹)</label>
                                                        <input type="number" name="unit_price" class="form-control" value="<?= $item['unit_price'] ?? 0 ?>" min="0" step="0.01">
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Location</label>
                                                    <input type="text" name="location" class="form-control" value="<?= htmlspecialchars($item['location'] ?? '') ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Description</label>
                                                    <textarea name="description" class="form-control" rows="2"><?= htmlspecialchars($item['description'] ?? '') ?></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Update Item</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Stock Modal -->
<div class="modal fade" id="addStockModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="/inventory/stock">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Add New Stock Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Basic Information -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Basic Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Item Code *</label>
                                    <input type="text" name="item_code" class="form-control" placeholder="e.g., STK-001" required>
                                    <small class="text-muted">Unique identifier for the item</small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Item Name *</label>
                                    <input type="text" name="name" class="form-control" placeholder="e.g., Printer Paper A4" required>
                                    <small class="text-muted">Descriptive name for the item</small>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Category</label>
                                    <input type="text" name="category" class="form-control" placeholder="e.g., Office Supplies">
                                    <small class="text-muted">Group similar items together</small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Unit of Measurement</label>
                                    <select name="unit" class="form-select">
                                        <option value="piece">Piece</option>
                                        <option value="kg">Kilogram</option>
                                        <option value="litre">Litre</option>
                                        <option value="box">Box</option>
                                        <option value="pack">Pack</option>
                                        <option value="ream">Ream</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quantity & Pricing -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="bi bi-currency-rupee me-2"></i>Quantity & Pricing</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Initial Quantity</label>
                                    <input type="number" name="quantity" class="form-control" value="0" min="0" placeholder="e.g., 100">
                                    <small class="text-muted">Current stock quantity</small>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Reorder Level</label>
                                    <input type="number" name="reorder_level" class="form-control" value="10" min="0" placeholder="e.g., 20">
                                    <small class="text-muted">Alert when stock falls below this</small>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Unit Price (₹)</label>
                                    <input type="number" name="unit_price" class="form-control" value="0" min="0" step="0.01" placeholder="e.g., 250.00">
                                    <small class="text-muted">Price per unit</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Location & Description -->
                    <div class="card">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="bi bi-geo-alt me-2"></i>Location & Details</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Storage Location</label>
                                <input type="text" name="location" class="form-control" placeholder="e.g., Store Room A, Shelf 3">
                                <small class="text-muted">Where this item is stored</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="2" placeholder="e.g., High quality 80gsm printer paper, 500 sheets per ream"></textarea>
                                <small class="text-muted">Additional details about the item</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success"><i class="bi bi-check-circle me-2"></i>Add Item</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
