<?php include __DIR__ . '/../layouts/header.php'; ?>

<style>
    html[data-bs-theme="dark"] .card-header.bg-light {
        background-color: var(--bs-gray-800) !important;
        color: var(--bs-body-color) !important;
        border-color: var(--bs-border-color) !important;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-people me-2"></i>Supplier Management</h2>
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addSupplierModal">
        <i class="bi bi-plus-circle me-2"></i>Add Supplier
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
        <a class="nav-link" href="/inventory/purchase-orders"><i class="bi bi-cart me-1"></i>Purchase Orders</a>
    </li>
    <li class="nav-item">
        <a class="nav-link active" href="/inventory/suppliers"><i class="bi bi-people me-1"></i>Suppliers</a>
    </li>
</ul>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h6>Active Suppliers</h6>
                <h3><?= $stats['total_suppliers'] ?? 0 ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h6>Total Purchases</h6>
                <h3>₹<?= number_format($stats['total_purchases'] ?? 0, 0) ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h6>Active Orders</h6>
                <h3><?= $stats['active_orders'] ?? 0 ?></h3>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card mb-3">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search by name, code, or contact..." value="<?= htmlspecialchars($filters['search'] ?? '') ?>">
            </div>
            <div class="col-md-3">
                <select name="city" class="form-select">
                    <option value="">All Cities</option>
                    <?php foreach ($cities ?? [] as $city): ?>
                        <option value="<?= htmlspecialchars($city['city']) ?>" <?= ($filters['city'] ?? '') == $city['city'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($city['city']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="active" <?= ($filters['status'] ?? '') == 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= ($filters['status'] ?? '') == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </form>
    </div>
</div>

<!-- Suppliers Table -->
<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Company Name</th>
                        <th>Contact Person</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>City</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($suppliers)): ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                No suppliers found. Click "Add Supplier" to get started.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($suppliers as $supplier): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($supplier['supplier_code']) ?></strong></td>
                                <td><?= htmlspecialchars($supplier['name']) ?></td>
                                <td><?= htmlspecialchars($supplier['contact_person'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($supplier['phone'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($supplier['email'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($supplier['city'] ?? 'N/A') ?></td>
                                <td>
                                    <span class="badge bg-<?= ($supplier['status'] ?? 'active') == 'active' ? 'success' : 'secondary' ?>">
                                        <?= ucfirst($supplier['status'] ?? 'active') ?>
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-info" title="View" data-bs-toggle="modal" data-bs-target="#viewSupplierModal<?= $supplier['id'] ?>">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-warning" title="Edit" data-bs-toggle="modal" data-bs-target="#editSupplierModal<?= $supplier['id'] ?>">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <form method="POST" action="/inventory/suppliers/<?= $supplier['id'] ?>/delete" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this supplier?');">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            
                            <!-- View Modal -->
                            <div class="modal fade" id="viewSupplierModal<?= $supplier['id'] ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title"><i class="bi bi-eye me-2"></i>Supplier Details</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <table class="table table-borderless">
                                                <tr><th>Code:</th><td><?= htmlspecialchars($supplier['supplier_code']) ?></td></tr>
                                                <tr><th>Company:</th><td><?= htmlspecialchars($supplier['name']) ?></td></tr>
                                                <tr><th>Contact Person:</th><td><?= htmlspecialchars($supplier['contact_person'] ?? 'N/A') ?></td></tr>
                                                <tr><th>Phone:</th><td><?= htmlspecialchars($supplier['phone'] ?? 'N/A') ?></td></tr>
                                                <tr><th>Email:</th><td><?= htmlspecialchars($supplier['email'] ?? 'N/A') ?></td></tr>
                                                <tr><th>Address:</th><td><?= htmlspecialchars($supplier['address'] ?? 'N/A') ?></td></tr>
                                                <tr><th>City:</th><td><?= htmlspecialchars($supplier['city'] ?? 'N/A') ?></td></tr>
                                                <tr><th>Country:</th><td><?= htmlspecialchars($supplier['country'] ?? 'N/A') ?></td></tr>
                                                <tr><th>Payment Terms:</th><td><?= htmlspecialchars($supplier['payment_terms'] ?? 'N/A') ?></td></tr>
                                                <tr><th>Status:</th><td><span class="badge bg-<?= ($supplier['status'] ?? 'active') == 'active' ? 'success' : 'secondary' ?>"><?= ucfirst($supplier['status'] ?? 'active') ?></span></td></tr>
                                            </table>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Edit Modal -->
                            <div class="modal fade" id="editSupplierModal<?= $supplier['id'] ?>" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <form method="POST" action="/inventory/suppliers/<?= $supplier['id'] ?>">
                                            <?= csrf_field() ?>
                                            <div class="modal-header">
                                                <h5 class="modal-title"><i class="bi bi-pencil me-2"></i>Edit Supplier</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Supplier Code *</label>
                                                        <input type="text" name="supplier_code" class="form-control" value="<?= htmlspecialchars($supplier['supplier_code']) ?>" required>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Company Name *</label>
                                                        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($supplier['name']) ?>" required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Contact Person</label>
                                                        <input type="text" name="contact_person" class="form-control" value="<?= htmlspecialchars($supplier['contact_person'] ?? '') ?>">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Phone</label>
                                                        <input type="text" name="phone" class="form-control" value="<?= htmlspecialchars($supplier['phone'] ?? '') ?>">
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Email</label>
                                                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($supplier['email'] ?? '') ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Address</label>
                                                    <textarea name="address" class="form-control" rows="2"><?= htmlspecialchars($supplier['address'] ?? '') ?></textarea>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">City</label>
                                                        <input type="text" name="city" class="form-control" value="<?= htmlspecialchars($supplier['city'] ?? '') ?>">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Country</label>
                                                        <input type="text" name="country" class="form-control" value="<?= htmlspecialchars($supplier['country'] ?? '') ?>">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-8 mb-3">
                                                        <label class="form-label">Payment Terms</label>
                                                        <input type="text" name="payment_terms" class="form-control" value="<?= htmlspecialchars($supplier['payment_terms'] ?? '') ?>">
                                                    </div>
                                                    <div class="col-md-4 mb-3">
                                                        <label class="form-label">Status</label>
                                                        <select name="status" class="form-select">
                                                            <option value="active" <?= ($supplier['status'] ?? 'active') == 'active' ? 'selected' : '' ?>>Active</option>
                                                            <option value="inactive" <?= ($supplier['status'] ?? '') == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-primary">Update Supplier</button>
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

<!-- Add Supplier Modal -->
<div class="modal fade" id="addSupplierModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" action="/inventory/suppliers">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Add New Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Company Info -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="bi bi-building me-2"></i>Company Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Supplier Code *</label>
                                    <input type="text" name="supplier_code" class="form-control" placeholder="e.g., SUP-001" required>
                                    <small class="text-muted">Unique identifier for the supplier</small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Company Name *</label>
                                    <input type="text" name="name" class="form-control" placeholder="e.g., ABC Stationery Supplies" required>
                                    <small class="text-muted">Full legal name of the company</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Info -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="bi bi-person me-2"></i>Contact Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Contact Person</label>
                                    <input type="text" name="contact_person" class="form-control" placeholder="e.g., John Smith">
                                    <small class="text-muted">Primary contact name</small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="text" name="phone" class="form-control" placeholder="e.g., +91 9876543210">
                                    <small class="text-muted">Contact phone number</small>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" placeholder="e.g., supplier@company.com">
                                <small class="text-muted">Business email address</small>
                            </div>
                        </div>
                    </div>

                    <!-- Address Info -->
                    <div class="card mb-3">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="bi bi-geo-alt me-2"></i>Address Details</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Address</label>
                                <textarea name="address" class="form-control" rows="2" placeholder="e.g., 123 Industrial Area, Sector 5"></textarea>
                                <small class="text-muted">Full street address</small>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">City</label>
                                    <input type="text" name="city" class="form-control" placeholder="e.g., Mumbai">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Country</label>
                                    <input type="text" name="country" class="form-control" placeholder="e.g., India" value="India">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Terms -->
                    <div class="card">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="bi bi-credit-card me-2"></i>Payment Terms</h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Payment Terms</label>
                                <input type="text" name="payment_terms" class="form-control" placeholder="e.g., Net 30 days, 50% advance">
                                <small class="text-muted">Specify payment conditions agreed with supplier</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success"><i class="bi bi-check-circle me-2"></i>Add Supplier</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
