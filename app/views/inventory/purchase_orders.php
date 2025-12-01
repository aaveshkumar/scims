<?php include __DIR__ . '/../layouts/header.php'; ?>

<style>
    html[data-bs-theme="dark"] .card-header.bg-light {
        background-color: var(--bs-gray-800) !important;
        color: var(--bs-body-color) !important;
        border-color: var(--bs-border-color) !important;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-cart me-2"></i>Purchase Orders</h2>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPOModal">
        <i class="bi bi-plus-circle me-2"></i>Create Purchase Order
    </button>
</div>

<!-- Navigation Tabs -->
<ul class="nav nav-tabs mb-4">
    <li class="nav-item">
        <a class="nav-link" href="/inventory/assets"><i class="bi bi-diagram-3 me-1"></i>Assets</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/inventory/stock"><i class="bi bi-box me-1"></i>Stock</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="/inventory/purchase-orders"><i class="bi bi-cart me-1"></i>Purchase Orders</a>
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
                <h6>Total Orders</h6>
                <h3><?= $stats['total_orders'] ?? 0 ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-dark">
            <div class="card-body">
                <h6>Pending</h6>
                <h3><?= $stats['pending'] ?? 0 ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h6>Approved</h6>
                <h3><?= $stats['approved'] ?? 0 ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h6>This Month Value</h6>
                <h3>₹<?= number_format($stats['this_month_value'] ?? 0, 0) ?></h3>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card mb-3">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control" placeholder="Search PO number..." value="<?= htmlspecialchars($filters['search'] ?? '') ?>">
            </div>
            <div class="col-md-3">
                <select name="supplier_id" class="form-select">
                    <option value="">All Suppliers</option>
                    <?php foreach ($suppliers ?? [] as $supplier): ?>
                        <option value="<?= $supplier['id'] ?>" <?= ($filters['supplier_id'] ?? '') == $supplier['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($supplier['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="pending" <?= ($filters['status'] ?? '') == 'pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="approved" <?= ($filters['status'] ?? '') == 'approved' ? 'selected' : '' ?>>Approved</option>
                    <option value="received" <?= ($filters['status'] ?? '') == 'received' ? 'selected' : '' ?>>Received</option>
                    <option value="cancelled" <?= ($filters['status'] ?? '') == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </form>
    </div>
</div>

<!-- Purchase Orders Table -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>PO Number</th>
                        <th>Supplier</th>
                        <th>Order Date</th>
                        <th>Expected Delivery</th>
                        <th>Total Amount</th>
                        <th>Created By</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($orders)): ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                No purchase orders found. Click "Create Purchase Order" to get started.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($order['po_number']) ?></strong></td>
                                <td><?= htmlspecialchars($order['supplier_name'] ?? 'N/A') ?></td>
                                <td><?= $order['order_date'] ? date('d M Y', strtotime($order['order_date'])) : 'N/A' ?></td>
                                <td><?= $order['expected_delivery'] ? date('d M Y', strtotime($order['expected_delivery'])) : 'N/A' ?></td>
                                <td>₹<?= number_format($order['total_amount'] ?? 0, 2) ?></td>
                                <td><?= htmlspecialchars($order['created_by_name'] ?? 'N/A') ?></td>
                                <td>
                                    <?php
                                    $statusBadge = match($order['status'] ?? 'pending') {
                                        'pending' => 'warning',
                                        'approved' => 'success',
                                        'received' => 'info',
                                        'cancelled' => 'danger',
                                        default => 'secondary'
                                    };
                                    ?>
                                    <span class="badge bg-<?= $statusBadge ?>">
                                        <?= ucfirst($order['status'] ?? 'pending') ?>
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-info" title="View" data-bs-toggle="modal" data-bs-target="#viewPOModal<?= $order['id'] ?>">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <?php if ($order['status'] == 'pending'): ?>
                                        <form method="POST" action="/inventory/purchase-orders/<?= $order['id'] ?>/approve" style="display: inline;">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-sm btn-success" title="Approve">
                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                    <form method="POST" action="/inventory/purchase-orders/<?= $order['id'] ?>/delete" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this purchase order?');">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            
                            <!-- View Modal -->
                            <div class="modal fade" id="viewPOModal<?= $order['id'] ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title"><i class="bi bi-eye me-2"></i>Purchase Order Details</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table table-borderless">
                                                <tr><th>PO Number:</th><td><?= htmlspecialchars($order['po_number']) ?></td></tr>
                                                <tr><th>Supplier:</th><td><?= htmlspecialchars($order['supplier_name'] ?? 'N/A') ?></td></tr>
                                                <tr><th>Order Date:</th><td><?= $order['order_date'] ? date('d M Y', strtotime($order['order_date'])) : 'N/A' ?></td></tr>
                                                <tr><th>Expected Delivery:</th><td><?= $order['expected_delivery'] ? date('d M Y', strtotime($order['expected_delivery'])) : 'N/A' ?></td></tr>
                                                <tr><th>Total Amount:</th><td>₹<?= number_format($order['total_amount'] ?? 0, 2) ?></td></tr>
                                                <tr><th>Status:</th><td><span class="badge bg-<?= $statusBadge ?>"><?= ucfirst($order['status'] ?? 'pending') ?></span></td></tr>
                                                <tr><th>Created By:</th><td><?= htmlspecialchars($order['created_by_name'] ?? 'N/A') ?></td></tr>
                                                <tr><th>Remarks:</th><td><?= htmlspecialchars($order['remarks'] ?? 'No remarks') ?></td></tr>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
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

<!-- Add PO Modal -->
<div class="modal fade" id="addPOModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="/inventory/purchase-orders">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Create Purchase Order</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Supplier Info -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="bi bi-people me-2"></i>Supplier Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Supplier *</label>
                                <select name="supplier_id" class="form-select" required>
                                    <option value="">-- Select Supplier --</option>
                                    <?php foreach ($suppliers ?? [] as $supplier): ?>
                                        <option value="<?= $supplier['id'] ?>"><?= htmlspecialchars($supplier['name']) ?> (<?= htmlspecialchars($supplier['supplier_code']) ?>)</option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="text-muted">Choose the supplier for this order</small>
                            </div>
                        </div>
                    </div>

                    <!-- Order Dates -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="bi bi-calendar me-2"></i>Order Dates</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Order Date *</label>
                                    <input type="date" name="order_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
                                    <small class="text-muted">Date when order is placed</small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Expected Delivery</label>
                                    <input type="date" name="expected_delivery" class="form-control">
                                    <small class="text-muted">Expected delivery date from supplier</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Remarks -->
                    <div class="card">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="bi bi-chat-text me-2"></i>Additional Details</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Remarks</label>
                                <textarea name="remarks" class="form-control" rows="3" placeholder="e.g., Urgent order for upcoming event, need express shipping"></textarea>
                                <small class="text-muted">Any special instructions or notes for this order</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success"><i class="bi bi-check-circle me-2"></i>Create Order</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
