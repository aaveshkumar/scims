<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-calendar-check me-2"></i>Holidays</h2>
    <a href="/calendar/holidays/create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Add Holiday
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Created By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($holidays)): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="bi bi-calendar-x fs-1 d-block mb-2"></i>
                                No holidays found. Click "Add Holiday" to get started.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($holidays as $holiday): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($holiday['name']) ?></strong></td>
                                <td><?= date('M d, Y', strtotime($holiday['start_date'])) ?></td>
                                <td><?= date('M d, Y', strtotime($holiday['end_date'])) ?></td>
                                <td>
                                    <span class="badge bg-secondary">
                                        <?= ucfirst(htmlspecialchars($holiday['holiday_type'] ?? 'holiday')) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-<?= $holiday['status'] === 'active' ? 'success' : 'secondary' ?>">
                                        <?= ucfirst($holiday['status']) ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($holiday['creator_name']) ?></td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="/calendar/holidays/<?= $holiday['id'] ?>" class="btn btn-outline-primary" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="/calendar/holidays/<?= $holiday['id'] ?>/edit" class="btn btn-outline-warning" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form method="POST" action="/calendar/holidays/<?= $holiday['id'] ?>/delete" style="display: inline;" onsubmit="return confirm('Delete this holiday?');">
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
