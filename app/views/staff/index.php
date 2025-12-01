<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Staff Members</h1>
    <a href="/staff/create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Add Staff
    </a>
</div>

<?php if (empty($staffByRole)): ?>
<div class="card">
    <div class="card-body text-center py-5 text-muted">
        <p class="mb-0">No staff members found</p>
    </div>
</div>
<?php else: ?>
    <?php foreach ($staffByRole as $role => $members): ?>
    <div class="card mb-4">
        <div class="card-header" style="background-color: #f8f9fa; border-bottom: 2px solid #dee2e6;">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <span class="badge bg-primary me-2"><?= count($members) ?></span>
                    <?= ucfirst($role) ?>
                </h5>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
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
                        <?php foreach ($members as $member): ?>
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
                                    <button onclick="confirmDelete('/staff/<?= $member['id'] ?>', 'Are you sure you want to delete this staff member?', this)" class="btn btn-sm btn-danger" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
