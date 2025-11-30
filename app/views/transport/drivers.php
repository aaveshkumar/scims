<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-people me-2"></i>Driver Management</h2>
    <div>
        <a href="/transport/drivers/create" class="btn btn-primary me-2">
            <i class="bi bi-plus-circle me-2"></i>Add Driver
        </a>
        <a href="/transport/drivers/payroll" class="btn btn-success me-2">
            <i class="bi bi-cash-coin me-2"></i>Pay Drivers
        </a>
    </div>
</div>

<ul class="nav nav-tabs mb-4" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link" href="/transport/vehicles">
            <i class="bi bi-truck me-2"></i>Vehicles
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link active" href="/transport/drivers">
            <i class="bi bi-people me-2"></i>Drivers
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" href="/transport/routes">
            <i class="bi bi-geo-alt me-2"></i>Routes
        </a>
    </li>
</ul>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Drivers List</h5>
    </div>
    <div class="card-body">
        <?php if (empty($drivers)): ?>
            <div class="text-center text-muted py-5">
                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                <p>No drivers found.</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>License Number</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($drivers as $driver): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($driver['first_name'] . ' ' . $driver['last_name']) ?></strong></td>
                                <td><?= htmlspecialchars($driver['email']) ?></td>
                                <td><?= htmlspecialchars($driver['license_number'] ?? 'N/A') ?></td>
                                <td>
                                    <span class="badge bg-<?= ($driver['status'] ?? 'active') == 'active' ? 'success' : 'secondary' ?>">
                                        <?= ucfirst($driver['status'] ?? 'active') ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="/transport/drivers/<?= $driver['id'] ?>/edit" class="btn btn-outline-info btn-sm" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="/transport/drivers/<?= $driver['id'] ?>/edit" class="btn btn-outline-warning btn-sm" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="confirmDelete(<?= $driver['id'] ?>)" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<form id="deleteForm" method="POST" style="display: none;">
    <?= csrf_field() ?>
</form>

<script>
function confirmDelete(driverId) {
    if (confirm('Are you sure you want to delete this driver?')) {
        document.getElementById('deleteForm').action = '/transport/drivers/' + driverId + '/delete';
        document.getElementById('deleteForm').submit();
    }
}
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
