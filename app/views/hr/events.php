<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-briefcase me-2"></i>HR Events</h2>
    <a href="/hr/events/create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Add Event
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Date</th>
                        <th>Location</th>
                        <th>Type</th>
                        <th>Created By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($events)): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                No HR events found. Click "Add Event" to get started.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($events as $event): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($event['title']) ?></strong></td>
                                <td><?= date('M d, Y', strtotime($event['event_date'])) ?></td>
                                <td><?= htmlspecialchars($event['location'] ?? '-') ?></td>
                                <td><span class="badge bg-info"><?= ucfirst($event['event_type']) ?></span></td>
                                <td><?= htmlspecialchars($event['creator_name']) ?></td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="/hr/events/<?= $event['id'] ?>" class="btn btn-outline-primary" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="/hr/events/<?= $event['id'] ?>/edit" class="btn btn-outline-warning" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form method="POST" action="/hr/events/<?= $event['id'] ?>/delete" style="display: inline;" onsubmit="return confirm('Delete this event?');">
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
