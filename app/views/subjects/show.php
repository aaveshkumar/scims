<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Subject Details</h1>
    <div>
        <a href="/subjects/<?= $subject['id'] ?>/edit" class="btn btn-warning">
            <i class="bi bi-pencil me-2"></i>Edit
        </a>
        <a href="/subjects" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Subject Information</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <p class="mb-1 text-muted">Subject Name</p>
                    <h4><?= htmlspecialchars($subject['name']) ?></h4>
                </div>
                <div class="mb-3">
                    <p class="mb-1 text-muted">Subject Code</p>
                    <p class="fs-5"><strong><?= htmlspecialchars($subject['code']) ?></strong></p>
                </div>
                <div class="mb-3">
                    <p class="mb-1 text-muted">Status</p>
                    <span class="badge bg-<?= $subject['status'] === 'active' ? 'success' : 'secondary' ?> fs-6">
                        <?= ucfirst($subject['status']) ?>
                    </span>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-6">
                        <p class="mb-1 text-muted">Class</p>
                        <p><?= htmlspecialchars($subject['class_name'] ?? 'N/A') ?></p>
                    </div>
                    <div class="col-6">
                        <p class="mb-1 text-muted">Subject Type</p>
                        <p><?= ucfirst($subject['subject_type'] ?? 'theory') ?></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <p class="mb-1 text-muted">Total Marks</p>
                        <p><?= $subject['total_marks'] ?? 'N/A' ?></p>
                    </div>
                    <div class="col-6">
                        <p class="mb-1 text-muted">Passing Marks</p>
                        <p><?= $subject['passing_marks'] ?? 'N/A' ?></p>
                    </div>
                </div>
                <div class="mb-0">
                    <p class="mb-1 text-muted">Assigned Teacher</p>
                    <p><?= htmlspecialchars($subject['teacher_name'] ?? 'Not assigned') ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Description</h5>
            </div>
            <div class="card-body">
                <p><?= nl2br(htmlspecialchars($subject['description'] ?? 'No description provided.')) ?></p>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <a href="/materials?subject_id=<?= $subject['id'] ?>" class="btn btn-outline-primary btn-sm mb-2 w-100">
                    <i class="bi bi-file-earmark-text me-2"></i>View Study Materials
                </a>
                <a href="/timetable?subject_id=<?= $subject['id'] ?>" class="btn btn-outline-primary btn-sm w-100">
                    <i class="bi bi-calendar3 me-2"></i>View Timetable
                </a>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
