<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-envelope me-2"></i>Messages</h2>
    <a href="/messages/create" class="btn btn-primary">
        <i class="bi bi-pencil-square me-2"></i>New Message
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>From</th>
                        <th>Subject</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($messages)): ?>
                        <?php foreach ($messages as $index => $msg): ?>
                            <?php 
                            $sender = $msg['sender_id'] == auth()['id'] ? null : $msg;
                            $senderName = isset($sender) ? 'Sent to You' : 'You sent';
                            ?>
                            <tr <?= !$msg['is_read'] && $msg['receiver_id'] == auth()['id'] ? 'style="font-weight: bold; background-color: rgba(13, 110, 253, 0.05);"' : '' ?>>
                                <td><?= $index + 1 ?></td>
                                <td>
                                    <?php 
                                    if ($msg['sender_id'] == auth()['id']) {
                                        echo '<em>You sent</em>';
                                    } else {
                                        $user = $msg['_sender'] ?? null;
                                        if ($user) {
                                            echo '<strong>' . htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) . '</strong>';
                                        } else {
                                            echo '<em>Unknown</em>';
                                        }
                                    }
                                    ?>
                                </td>
                                <td><?= htmlspecialchars($msg['subject']) ?></td>
                                <td>
                                    <small><?= date('M d, Y h:i A', strtotime($msg['created_at'])) ?></small>
                                </td>
                                <td>
                                    <?php if ($msg['sender_id'] == auth()['id']): ?>
                                        <span class="badge bg-secondary">Sent</span>
                                    <?php elseif ($msg['is_read']): ?>
                                        <span class="badge bg-success">Read</span>
                                    <?php else: ?>
                                        <span class="badge bg-primary">Unread</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="/messages/<?= $msg['id'] ?>" class="btn btn-sm btn-info" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="/messages/<?= $msg['id'] ?>/edit" class="btn btn-sm btn-warning" title="Reply">
                                        <i class="bi bi-reply"></i>
                                    </a>
                                    <?php if ($msg['sender_id'] == auth()['id']): ?>
                                    <button onclick="confirmDelete('/messages/<?= $msg['id'] ?>', 'Delete this message?')" class="btn btn-sm btn-danger" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                No messages found.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
