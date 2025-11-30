<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-briefcase me-2"></i>Recruitment Positions</h2>
    <a href="/hr/recruitment/create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Add Position
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Position</th>
                        <th>Department</th>
                        <th>Vacancies</th>
                        <th>Status</th>
                        <th>Posted By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($positions)): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                No positions found. Click "Add Position" to get started.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($positions as $pos): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($pos['title']) ?></strong></td>
                                <td><?= htmlspecialchars($pos['department']) ?></td>
                                <td><?= $pos['number_of_positions'] ?></td>
                                <td><span class="badge bg-<?= $pos['status'] === 'open' ? 'success' : ($pos['status'] === 'closed' ? 'danger' : 'secondary') ?>"><?= ucfirst($pos['status']) ?></span></td>
                                <td><?= htmlspecialchars($pos['created_by_name']) ?></td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="/hr/recruitment/<?= $pos['id'] ?>" class="btn btn-outline-primary" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="/hr/recruitment/<?= $pos['id'] ?>/edit" class="btn btn-outline-warning" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form method="POST" action="/hr/recruitment/<?= $pos['id'] ?>/delete" style="display: inline;" onsubmit="return confirm('Delete this position?');">
                                            <input type="hidden" name="_token" value="<?= csrf() ?>">
                                            <button type="submit" class="btn btn-outline-danger" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
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
