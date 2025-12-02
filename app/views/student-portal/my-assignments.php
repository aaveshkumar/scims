<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="mb-4">
    <h2><i class="bi bi-file-text me-2"></i>My Assignments</h2>
</div>

<ul class="nav nav-tabs mb-3" role="tablist">
    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#pending">Pending</a></li>
    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#completed">Completed</a></li>
</ul>

<div class="tab-content">
    <div id="pending" class="tab-pane fade show active">
        <?php if (empty($pending)): ?>
            <div class="alert alert-success">No pending assignments</div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($pending as $assignment): ?>
                    <div class="col-md-6 mb-3">
                        <div class="card border-warning">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($assignment['title']) ?></h5>
                                <p class="card-text text-muted"><?= htmlspecialchars(substr($assignment['description'] ?? '', 0, 100)) ?>...</p>
                                <div class="d-flex justify-content-between">
                                    <small>Due: <strong><?= date('M d, Y', strtotime($assignment['due_date'])) ?></strong></small>
                                    <span class="badge bg-warning">Pending</span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <div id="completed" class="tab-pane fade">
        <?php if (empty($completed)): ?>
            <div class="alert alert-info">No completed assignments</div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($completed as $assignment): ?>
                    <div class="col-md-6 mb-3">
                        <div class="card border-success">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($assignment['title']) ?></h5>
                                <div class="d-flex justify-content-between">
                                    <small>Due: <?= date('M d, Y', strtotime($assignment['due_date'])) ?></small>
                                    <span class="badge bg-success">Completed</span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
