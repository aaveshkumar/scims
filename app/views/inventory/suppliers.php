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
                        <th>City</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($suppliers)): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
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
                                <td><?= htmlspecialchars($supplier['city'] ?? 'N/A') ?></td>
                                <td>
                                    <span class="badge bg-<?= ($supplier['status'] ?? 'active') == 'active' ? 'success' : 'secondary' ?>">
                                        <?= ucfirst($supplier['status'] ?? 'active') ?>
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-info" title="View Details" data-bs-toggle="modal" data-bs-target="#viewSupplierModal" data-supplier-id="<?= $supplier['id'] ?>" onclick="showSupplierDetails(this)">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-warning" title="Edit" data-bs-toggle="modal" data-bs-target="#editSupplierModal" data-supplier-id="<?= $supplier['id'] ?>" onclick="loadSupplierForEdit(this)">
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
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- View Supplier Modal (Single reusable modal) -->
<div class="modal fade" id="viewSupplierModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-eye me-2"></i>Supplier Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="supplierDetailsContent">
                    <p class="text-muted">Loading...</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Supplier Modal (Single reusable modal) -->
<div class="modal fade" id="editSupplierModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="POST" id="editSupplierForm">
                <?= csrf_field() ?>
                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-pencil me-2"></i>Edit Supplier</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Supplier Code *</label>
                            <input type="text" name="supplier_code" id="editSupplierCode" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Company Name *</label>
                            <input type="text" name="name" id="editSupplierName" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Contact Person</label>
                            <input type="text" name="contact_person" id="editContactPerson" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" id="editPhone" class="form-control">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" id="editEmail" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" id="editAddress" class="form-control" rows="2"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">City</label>
                            <input type="text" name="city" id="editCity" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Country</label>
                            <input type="text" name="country" id="editCountry" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label">Payment Terms</label>
                            <input type="text" name="payment_terms" id="editPaymentTerms" class="form-control">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" id="editStatus" class="form-select">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
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

<!-- Store all supplier data in hidden elements for quick access -->
<?php foreach ($suppliers ?? [] as $supplier): ?>
    <div class="d-none" id="supplierData<?= $supplier['id'] ?>" data-supplier="<?= htmlspecialchars(json_encode($supplier), ENT_QUOTES, 'UTF-8') ?>"></div>
<?php endforeach; ?>

<script>
function showSupplierDetails(button) {
    const supplierId = button.getAttribute('data-supplier-id');
    const supplierDataElement = document.getElementById('supplierData' + supplierId);
    const supplier = JSON.parse(supplierDataElement.getAttribute('data-supplier'));
    
    const statusBadge = supplier.status === 'active' ? 'success' : 'secondary';
    
    const html = `
        <div class="row mb-3">
            <div class="col-md-6">
                <p><strong>Code:</strong></p>
                <p>${supplier.supplier_code}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Status:</strong></p>
                <p><span class="badge bg-${statusBadge}">${supplier.status.charAt(0).toUpperCase() + supplier.status.slice(1)}</span></p>
            </div>
        </div>
        <hr>
        <div class="row mb-3">
            <div class="col-md-12">
                <p><strong>Company Name:</strong></p>
                <p>${supplier.name}</p>
            </div>
        </div>
        <hr>
        <div class="row mb-3">
            <div class="col-md-6">
                <p><strong>Contact Person:</strong></p>
                <p>${supplier.contact_person || 'N/A'}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Phone:</strong></p>
                <p>${supplier.phone || 'N/A'}</p>
            </div>
        </div>
        <hr>
        <div class="row mb-3">
            <div class="col-md-12">
                <p><strong>Email:</strong></p>
                <p>${supplier.email || 'N/A'}</p>
            </div>
        </div>
        <hr>
        <div class="row mb-3">
            <div class="col-md-12">
                <p><strong>Address:</strong></p>
                <p>${supplier.address || 'N/A'}</p>
            </div>
        </div>
        <hr>
        <div class="row mb-3">
            <div class="col-md-6">
                <p><strong>City:</strong></p>
                <p>${supplier.city || 'N/A'}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Country:</strong></p>
                <p>${supplier.country || 'N/A'}</p>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <p><strong>Payment Terms:</strong></p>
                <p>${supplier.payment_terms || 'N/A'}</p>
            </div>
        </div>
    `;
    
    document.getElementById('supplierDetailsContent').innerHTML = html;
}

function loadSupplierForEdit(button) {
    const supplierId = button.getAttribute('data-supplier-id');
    const supplierDataElement = document.getElementById('supplierData' + supplierId);
    const supplier = JSON.parse(supplierDataElement.getAttribute('data-supplier'));
    
    document.getElementById('editSupplierCode').value = supplier.supplier_code;
    document.getElementById('editSupplierName').value = supplier.name;
    document.getElementById('editContactPerson').value = supplier.contact_person || '';
    document.getElementById('editPhone').value = supplier.phone || '';
    document.getElementById('editEmail').value = supplier.email || '';
    document.getElementById('editAddress').value = supplier.address || '';
    document.getElementById('editCity').value = supplier.city || '';
    document.getElementById('editCountry').value = supplier.country || '';
    document.getElementById('editPaymentTerms').value = supplier.payment_terms || '';
    document.getElementById('editStatus').value = supplier.status || 'active';
    
    document.getElementById('editSupplierForm').action = '/inventory/suppliers/' + supplierId;
}
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
