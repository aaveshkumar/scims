<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0"><?= htmlspecialchars($lessonPlan['topic'] ?? 'Lesson Plan') ?></h1>
        <p class="text-muted mb-0">Lesson Details</p>
    </div>
    <div>
        <a href="/lesson-plans/<?= $lessonPlan['id'] ?>/edit" class="btn btn-warning me-2">
            <i class="bi bi-pencil me-2"></i>Edit
        </a>
        <a href="/lesson-plans" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-3">
                <h6 class="text-muted">Subject</h6>
                <p><?= htmlspecialchars($lessonPlan['subject_name'] ?? 'N/A') ?></p>
            </div>
            <div class="col-md-3">
                <h6 class="text-muted">Class</h6>
                <p><?= htmlspecialchars($lessonPlan['class_name'] ?? 'N/A') ?></p>
            </div>
            <div class="col-md-3">
                <h6 class="text-muted">Lesson Date</h6>
                <p><?= htmlspecialchars($lessonPlan['lesson_date'] ?? 'N/A') ?></p>
            </div>
            <div class="col-md-3">
                <h6 class="text-muted">Status</h6>
                <span class="badge bg-<?= $lessonPlan['status'] === 'active' ? 'success' : 'warning' ?>">
                    <?= ucfirst($lessonPlan['status'] ?? 'N/A') ?>
                </span>
            </div>
        </div>

        <hr>

        <?php if ($lessonPlan['learning_outcomes']): ?>
        <div class="mb-4">
            <h6 class="fw-bold">Learning Outcomes</h6>
            <p><?= nl2br(htmlspecialchars($lessonPlan['learning_outcomes'])) ?></p>
        </div>
        <?php endif; ?>

        <?php if ($lessonPlan['introduction']): ?>
        <div class="mb-4">
            <h6 class="fw-bold">Introduction/Hook</h6>
            <p><?= nl2br(htmlspecialchars($lessonPlan['introduction'])) ?></p>
        </div>
        <?php endif; ?>

        <?php if ($lessonPlan['content']): ?>
        <div class="mb-4">
            <h6 class="fw-bold">Main Content</h6>
            <p><?= nl2br(htmlspecialchars($lessonPlan['content'])) ?></p>
        </div>
        <?php endif; ?>

        <?php if ($lessonPlan['activities']): ?>
        <div class="mb-4">
            <h6 class="fw-bold">Classroom Activities</h6>
            <p><?= nl2br(htmlspecialchars($lessonPlan['activities'])) ?></p>
        </div>
        <?php endif; ?>

        <?php if ($lessonPlan['conclusion']): ?>
        <div class="mb-4">
            <h6 class="fw-bold">Conclusion/Summary</h6>
            <p><?= nl2br(htmlspecialchars($lessonPlan['conclusion'])) ?></p>
        </div>
        <?php endif; ?>

        <?php if ($lessonPlan['homework']): ?>
        <div class="mb-4">
            <h6 class="fw-bold">Homework Assignment</h6>
            <p><?= nl2br(htmlspecialchars($lessonPlan['homework'])) ?></p>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
