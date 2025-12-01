<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-chat-left-text me-2"></i>My Support Messages</h2>
    <a href="/support/create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>New Message
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Replied</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($messages)): ?>
                        <?php foreach ($messages as $index => $msg): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><strong><?= htmlspecialchars($msg['subject']) ?></strong></td>
                                <td>
                                    <?php 
                                    $badge = $msg['status'] == 'open' ? 'bg-warning' : ($msg['status'] == 'replied' ? 'bg-info' : 'bg-success');
                                    $label = ucfirst($msg['status']);
                                    ?>
                                    <span class="badge <?= $badge ?>"><?= $label ?></span>
                                </td>
                                <td><small><?= date('M d, Y', strtotime($msg['created_at'])) ?></small></td>
                                <td>
                                    <?php if ($msg['replied_at']): ?>
                                        <small><?= date('M d, Y', strtotime($msg['replied_at'])) ?></small>
                                    <?php else: ?>
                                        <span class="text-muted">—</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="/support/<?= $msg['id'] ?>" class="btn btn-sm btn-info" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                No support messages yet.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
