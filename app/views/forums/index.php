<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-chat-square-text me-2"></i>Discussion Forums</h2>
    <a href="/forums/create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Create Forum
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Subject</th>
                        <th>Class</th>
                        <th>Created By</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($forums)): ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                No forums found. Click "Create Forum" to get started.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($forums as $forum): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($forum['title']) ?></strong></td>
                                <td><?= htmlspecialchars($forum['subject_name'] ?? 'General') ?></td>
                                <td><?= htmlspecialchars($forum['class_name'] ?? 'All') ?></td>
                                <td><?= htmlspecialchars($forum['creator_name']) ?></td>
                                <td>
                                    <span class="badge bg-<?= $forum['status'] === 'active' ? 'success' : 'secondary' ?>">
                                        <?= ucfirst($forum['status']) ?>
                                    </span>
                                </td>
                                <td><?= date('M d, Y', strtotime($forum['created_at'])) ?></td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="/forums/<?= $forum['id'] ?>" class="btn btn-outline-primary" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="/forums/<?= $forum['id'] ?>/edit" class="btn btn-outline-warning" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form method="POST" action="/forums/<?= $forum['id'] ?>/delete" style="display: inline;" onsubmit="return confirm('Delete this forum?');">
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