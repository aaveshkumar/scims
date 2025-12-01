<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-megaphone me-2"></i>Announcements</h2>
    <a href="/announcements/create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Add New
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Target Audience</th>
                        <th>Priority</th>
                        <th>Published Date</th>
                        <th>Visible</th>
                        <th>Views</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($announcements)): ?>
                        <?php foreach ($announcements as $index => $announcement): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td>
                                    <strong><?= htmlspecialchars($announcement['title']) ?></strong>
                                </td>
                                <td>
                                    <span class="badge bg-info">
                                        <?= htmlspecialchars($announcement['target_audience']) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php
                                    $priorityBadges = [
                                        'low' => 'bg-success',
                                        'normal' => 'bg-info',
                                        'high' => 'bg-warning',
                                        'urgent' => 'bg-danger'
                                    ];
                                    $badgeClass = $priorityBadges[$announcement['priority']] ?? 'bg-secondary';
                                    ?>
                                    <span class="badge <?= $badgeClass ?>">
                                        <?= ucfirst(htmlspecialchars($announcement['priority'])) ?>
                                    </span>
                                </td>
                                <td>
                                    <small><?= date('M d, Y', strtotime($announcement['published_date'])) ?></small>
                                </td>
                                <td>
                                    <?php if ($announcement['is_visible']): ?>
                                        <span class="badge bg-success">Visible</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Hidden</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="text-muted">
                                        <i class="bi bi-eye me-1"></i><?= $announcement['views_count'] ?? 0 ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="/announcements/<?= $announcement['id'] ?>" class="btn btn-sm btn-info" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="/announcements/<?= $announcement['id'] ?>/edit" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button onclick="confirmDelete('/announcements/<?= $announcement['id'] ?>', 'Delete this announcement?')" class="btn btn-sm btn-danger" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                No announcements found. Click "Add New" to get started.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
