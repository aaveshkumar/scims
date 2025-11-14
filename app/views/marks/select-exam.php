<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Select Exam</h1>
    <a href="/exams" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back to Exams
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Choose an exam to view or enter marks</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <?php if (empty($exams)): ?>
                <div class="col-12">
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-file-earmark-x" style="font-size: 3rem;"></i>
                        <p class="mt-3">No exams found. Please create an exam first.</p>
                        <a href="/exams/create" class="btn btn-primary mt-2">
                            <i class="bi bi-plus-circle me-2"></i>Create Exam
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($exams as $exam): ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($exam['name']) ?></h5>
                                <p class="text-muted mb-2"><?= htmlspecialchars($exam['code']) ?></p>
                                <p class="card-text">
                                    <small class="text-muted">
                                        <i class="bi bi-calendar3 me-1"></i>
                                        <?= date('M d', strtotime($exam['start_date'])) ?> - <?= date('M d, Y', strtotime($exam['end_date'])) ?>
                                    </small>
                                </p>
                                <p class="card-text">
                                    <span class="badge bg-<?= match($exam['status']) {
                                        'scheduled' => 'primary',
                                        'ongoing' => 'warning',
                                        'completed' => 'success',
                                        default => 'secondary'
                                    } ?>">
                                        <?= ucfirst($exam['status']) ?>
                                    </span>
                                    <?php if ($exam['class_name']): ?>
                                        <span class="badge bg-info"><?= htmlspecialchars($exam['class_name']) ?></span>
                                    <?php endif; ?>
                                </p>
                                <div class="mt-3">
                                    <a href="/marks?exam_id=<?= $exam['id'] ?>" class="btn btn-sm btn-primary w-100 mb-2">
                                        <i class="bi bi-eye me-1"></i> View Marks
                                    </a>
                                    <a href="/marks/enter?exam_id=<?= $exam['id'] ?>" class="btn btn-sm btn-success w-100">
                                        <i class="bi bi-pencil-square me-1"></i> Enter Marks
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
