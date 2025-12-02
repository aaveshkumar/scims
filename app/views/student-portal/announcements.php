<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="mb-4">
    <h2><i class="bi bi-megaphone me-2"></i>Announcements</h2>
</div>

<?php if (empty($announcements)): ?>
    <div class="alert alert-info">No announcements available</div>
<?php else: ?>
    <div class="row">
        <?php foreach ($announcements as $announcement): ?>
            <div class="col-md-12 mb-3">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="card-title"><?= htmlspecialchars($announcement['title']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars(substr($announcement['content'] ?? '', 0, 200)) ?>...</p>
                                <small class="text-muted">By <?= htmlspecialchars($announcement['author_name']) ?> on <?= date('M d, Y h:i A', strtotime($announcement['created_at'])) ?></small>
                            </div>
                            <span class="badge bg-primary">Announcement</span>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
