<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0"><?= htmlspecialchars($syllabus['title']) ?></h1>
        <p class="text-muted mb-0">Syllabus Details</p>
    </div>
    <div>
        <a href="/syllabus/<?= $syllabus['id'] ?>/edit" class="btn btn-warning me-2">
            <i class="bi bi-pencil me-2"></i>Edit
        </a>
        <a href="/syllabus" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <h6 class="text-muted">Status</h6>
                <span class="badge bg-<?= $syllabus['status'] === 'active' ? 'success' : ($syllabus['status'] === 'draft' ? 'warning' : 'secondary') ?>">
                    <?= ucfirst($syllabus['status']) ?>
                </span>
            </div>
            <div class="col-md-6">
                <h6 class="text-muted">Academic Year</h6>
                <p><?= htmlspecialchars($syllabus['academic_year'] ?? 'N/A') ?></p>
            </div>
        </div>

        <?php if ($syllabus['overview']): ?>
        <div class="mb-4 pb-4 border-bottom">
            <h6 class="fw-bold">Overview</h6>
            <p><?= nl2br(htmlspecialchars($syllabus['overview'])) ?></p>
        </div>
        <?php endif; ?>

        <?php if ($syllabus['learning_outcomes']): ?>
        <div class="mb-4 pb-4 border-bottom">
            <h6 class="fw-bold">Learning Outcomes</h6>
            <p><?= nl2br(htmlspecialchars($syllabus['learning_outcomes'])) ?></p>
        </div>
        <?php endif; ?>

        <?php if ($syllabus['topics_covered']): ?>
        <div class="mb-4 pb-4 border-bottom">
            <h6 class="fw-bold">Topics Covered</h6>
            <p><?= nl2br(htmlspecialchars($syllabus['topics_covered'])) ?></p>
        </div>
        <?php endif; ?>

        <?php if ($syllabus['assessment_methods']): ?>
        <div class="mb-4 pb-4 border-bottom">
            <h6 class="fw-bold">Assessment Methods</h6>
            <p><?= nl2br(htmlspecialchars($syllabus['assessment_methods'])) ?></p>
        </div>
        <?php endif; ?>

        <?php if ($syllabus['grading_scale']): ?>
        <div class="mb-4 pb-4 border-bottom">
            <h6 class="fw-bold">Grading Scale</h6>
            <p><?= htmlspecialchars($syllabus['grading_scale']) ?></p>
        </div>
        <?php endif; ?>

        <?php if ($syllabus['recommended_resources']): ?>
        <div class="mb-4 pb-4 border-bottom">
            <h6 class="fw-bold">Recommended Resources</h6>
            <p><?= nl2br(htmlspecialchars($syllabus['recommended_resources'])) ?></p>
        </div>
        <?php endif; ?>

        <?php if ($syllabus['prerequisites']): ?>
        <div class="mb-4 pb-4 border-bottom">
            <h6 class="fw-bold">Prerequisites</h6>
            <p><?= htmlspecialchars($syllabus['prerequisites']) ?></p>
        </div>
        <?php endif; ?>

        <?php if ($syllabus['duration']): ?>
        <div class="mb-4">
            <h6 class="fw-bold">Duration</h6>
            <p><?= htmlspecialchars($syllabus['duration']) ?></p>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
