<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Course Details</h1>
    <div>
        <a href="/courses/<?= $course['id'] ?>/edit" class="btn btn-warning">
            <i class="bi bi-pencil me-2"></i>Edit
        </a>
        <a href="/courses" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Course Information</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <p class="mb-1 text-muted">Course Name</p>
                    <h4><?= htmlspecialchars($course['name']) ?></h4>
                </div>
                <div class="mb-3">
                    <p class="mb-1 text-muted">Course Code</p>
                    <p class="fs-5"><strong><?= htmlspecialchars($course['code']) ?></strong></p>
                </div>
                <div class="mb-3">
                    <p class="mb-1 text-muted">Duration</p>
                    <p><?= $course['duration_years'] ?> Year(s)</p>
                </div>
                <div class="mb-0">
                    <p class="mb-1 text-muted">Status</p>
                    <span class="badge bg-<?= $course['status'] === 'active' ? 'success' : 'secondary' ?> fs-6">
                        <?= ucfirst($course['status']) ?>
                    </span>
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
                <p><?= nl2br(htmlspecialchars($course['description'] ?? 'No description provided.')) ?></p>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
