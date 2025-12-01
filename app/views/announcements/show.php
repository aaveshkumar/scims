<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-megaphone me-2"></i><?= htmlspecialchars($announcement['title']) ?></h2>
    <a href="/announcements" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-body">
                <div class="mb-3">
                    <h6 class="text-muted">Content</h6>
                    <p><?= nl2br(htmlspecialchars($announcement['content'])) ?></p>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-muted">Target Audience</h6>
                        <p>
                            <span class="badge bg-info">
                                <?= htmlspecialchars($announcement['target_audience']) ?>
                            </span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Priority</h6>
                        <p>
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
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-muted">Published Date</h6>
                        <p><?= date('M d, Y h:i A', strtotime($announcement['published_date'])) ?></p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Expiry Date</h6>
                        <p>
                            <?php if ($announcement['expiry_date']): ?>
                                <?= date('M d, Y h:i A', strtotime($announcement['expiry_date'])) ?>
                            <?php else: ?>
                                <span class="text-muted">No expiry</span>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mb-3">
            <div class="card-header">
                <h6 class="mb-0">Details</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted">Visibility</small>
                    <p>
                        <?php if ($announcement['is_visible']): ?>
                            <span class="badge bg-success">Visible</span>
                        <?php else: ?>
                            <span class="badge bg-danger">Hidden</span>
                        <?php endif; ?>
                    </p>
                </div>
                <div class="mb-3">
                    <small class="text-muted">Views</small>
                    <p>
                        <i class="bi bi-eye me-1"></i><strong><?= $announcement['views_count'] ?? 0 ?></strong>
                    </p>
                </div>
                <div class="mb-3">
                    <small class="text-muted">Created At</small>
                    <p><?= date('M d, Y h:i A', strtotime($announcement['created_at'])) ?></p>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2">
            <a href="/announcements/<?= $announcement['id'] ?>/edit" class="btn btn-warning w-100">
                <i class="bi bi-pencil me-2"></i>Edit
            </a>
            <button onclick="confirmDelete('/announcements/<?= $announcement['id'] ?>', 'Delete this announcement?')" class="btn btn-danger w-100">
                <i class="bi bi-trash me-2"></i>Delete
            </button>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
