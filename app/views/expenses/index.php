<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0"><i class="bi bi-receipt me-2"></i>Expenses</h1>
        <p class="text-muted mb-0">Manage organizational expenses</p>
    </div>
    <a href="/expenses/create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Add New Expense
    </a>
</div>

<div class="card mb-4">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-4">
                <input type="text" class="form-control" id="searchInput" placeholder="Search by vendor or description...">
            </div>
            <div class="col-md-3">
                <select class="form-select" id="categoryFilter">
                    <option value="">All Categories</option>
                    <?php foreach ($categories as $key => $label): ?>
                        <option value="<?= htmlspecialchars($key) ?>"><?= htmlspecialchars($label) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select" id="statusFilter">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-outline-primary w-100" onclick="applyFilters()">
                    <i class="bi bi-search me-1"></i>Filter
                </button>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date</th>
                        <th>Category</th>
                        <th>Vendor</th>
                        <th>Description</th>
                        <th class="text-end">Amount</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($expenses)): ?>
                        <?php $total = 0; ?>
                        <?php foreach ($expenses as $expense): ?>
                            <?php $total += $expense['amount']; ?>
                            <tr>
                                <td>
                                    <small class="text-muted">EXP-<?= str_pad($expense['id'], 4, '0', STR_PAD_LEFT) ?></small>
                                </td>
                                <td>
                                    <?= date('M d, Y', strtotime($expense['expense_date'])) ?>
                                </td>
                                <td>
                                    <span class="badge bg-info"><?= htmlspecialchars($expense['category']) ?></span>
                                </td>
                                <td><?= htmlspecialchars($expense['vendor'] ?: 'N/A') ?></td>
                                <td>
                                    <small><?= substr(htmlspecialchars($expense['description'] ?: 'No description'), 0, 50) ?>...</small>
                                </td>
                                <td class="text-end fw-bold">₹<?= number_format($expense['amount'], 2) ?></td>
                                <td>
                                    <span class="badge bg-<?php
                                        if ($expense['status'] === 'approved') echo 'success';
                                        elseif ($expense['status'] === 'rejected') echo 'danger';
                                        else echo 'warning';
                                    ?>">
                                        <?= ucfirst($expense['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="/expenses/<?= $expense['id'] ?>" class="btn btn-outline-primary" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="/expenses/<?= $expense['id'] ?>/edit" class="btn btn-outline-warning" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form method="POST" action="/expenses/<?= $expense['id'] ?>/delete" style="display: inline;" onsubmit="return confirm('Delete this expense?');">
                                            <input type="hidden" name="_token" value="<?= csrf() ?>">
                                            <button type="submit" class="btn btn-outline-danger" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <tr class="table-light fw-bold">
                            <td colspan="5" class="text-end">Total Expenses:</td>
                            <td class="text-end">₹<?= number_format($total, 2) ?></td>
                            <td colspan="2"></td>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-5">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                <p class="mb-0">No expenses found.</p>
                                <small>Click "Add New Expense" to create one.</small>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function applyFilters() {
    const category = document.getElementById('categoryFilter').value;
    const status = document.getElementById('statusFilter').value;
    let url = '/expenses';
    const params = [];
    
    if (category) params.push('category=' + encodeURIComponent(category));
    if (status) params.push('status=' + encodeURIComponent(status));
    
    if (params.length) url += '?' + params.join('&');
    window.location.href = url;
}
</script>

<style>
[data-bs-theme="dark"] .table-light {
    background-color: #3a3f47 !important;
}
</style>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
