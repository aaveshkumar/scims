<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-people me-2"></i>Driver Management</h2>
    <div>
        <a href="/transport/drivers/create" class="btn btn-primary me-2">
            <i class="bi bi-plus-circle me-2"></i>Add Driver
        </a>
        <a href="/transport/vehicles" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>
</div>

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
