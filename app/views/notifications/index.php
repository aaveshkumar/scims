<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Notifications</h1>
    <button onclick="markAllRead()" class="btn btn-primary">
        <i class="bi bi-check-all me-2"></i>Mark All as Read
    </button>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">All Notifications</h5>
    </div>
    <div class="card-body p-0">
        <?php if (empty($notifications)): ?>
            <div class="text-center py-5 text-muted">
                <i class="bi bi-bell-slash" style="font-size: 3rem;"></i>
                <p class="mt-3">No notifications</p>
            </div>
        <?php else: ?>
            <div class="list-group list-group-flush">
                <?php foreach ($notifications as $notification): ?>
                    <div class="list-group-item <?= $notification['is_read'] ? '' : 'bg-light' ?>">
                        <div class="d-flex w-100 justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">
                                    <?php if (!$notification['is_read']): ?>
                                        <span class="badge bg-primary me-2">New</span>
                                    <?php endif; ?>
                                    <?= htmlspecialchars($notification['title']) ?>
                                </h6>
                                <p class="mb-1"><?= htmlspecialchars($notification['message']) ?></p>
                                <small class="text-muted">
                                    <i class="bi bi-clock me-1"></i>
                                    <?= date('M d, Y h:i A', strtotime($notification['created_at'])) ?>
                                </small>
                            </div>
                            <?php if (!$notification['is_read']): ?>
                                <button onclick="markAsRead(<?= $notification['id'] ?>)" 
                                        class="btn btn-sm btn-outline-primary ms-3">
                                    <i class="bi bi-check"></i>
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
function markAsRead(id) {
    fetch(`/notifications/${id}/mark-as-read`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}

function markAllRead() {
    fetch('/notifications/mark-all-read', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    });
}
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
