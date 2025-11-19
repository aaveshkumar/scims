<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Staff Members</h1>
    <a href="/staff/create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Add Staff
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">All Staff Members</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Employee ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Designation</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($staff)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No staff members found</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($staff as $member): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($member['employee_id']) ?></strong></td>
                                <td><?= htmlspecialchars($member['first_name'] . ' ' . $member['last_name']) ?></td>
                                <td><?= htmlspecialchars($member['email']) ?></td>
                                <td><?= htmlspecialchars($member['phone']) ?></td>
                                <td><?= htmlspecialchars($member['designation']) ?></td>
                                <td>
                                    <span class="badge bg-<?= $member['status'] === 'active' ? 'success' : 'secondary' ?>" id="status-badge-<?= $member['id'] ?>">
                                        <?= ucfirst($member['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="/staff/<?= $member['id'] ?>" class="btn btn-sm btn-info" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="/staff/<?= $member['id'] ?>/edit" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button onclick="toggleStatus('staff', <?= $member['id'] ?>)" class="btn btn-sm btn-<?= $member['status'] === 'active' ? 'secondary' : 'success' ?>" title="Toggle Status">
                                        <i class="bi bi-<?= $member['status'] === 'active' ? 'x-circle' : 'check-circle' ?>"></i>
                                    </button>
                                    <button onclick="confirmDelete('/staff/<?= $member['id'] ?>')" class="btn btn-sm btn-danger" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
