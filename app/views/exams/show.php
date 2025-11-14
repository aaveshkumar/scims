<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Exam Details</h1>
    <div>
        <a href="/exams/<?= $exam['id'] ?>/edit" class="btn btn-warning">
            <i class="bi bi-pencil me-2"></i>Edit
        </a>
        <a href="/exams" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Exam Information</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <p class="mb-1 text-muted">Exam Name</p>
                    <h4><?= htmlspecialchars($exam['name']) ?></h4>
                </div>
                <div class="mb-3">
                    <p class="mb-1 text-muted">Exam Code</p>
                    <p class="fs-5"><strong><?= htmlspecialchars($exam['code']) ?></strong></p>
                </div>
                <div class="mb-3">
                    <p class="mb-1 text-muted">Status</p>
                    <span class="badge bg-<?= match($exam['status']) {
                        'scheduled' => 'primary',
                        'ongoing' => 'warning',
                        'completed' => 'success',
                        default => 'secondary'
                    } ?> fs-6">
                        <?= ucfirst($exam['status']) ?>
                    </span>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-6">
                        <p class="mb-1 text-muted">Exam Type</p>
                        <p><?= ucwords(str_replace('_', ' ', $exam['exam_type'])) ?></p>
                    </div>
                    <div class="col-6">
                        <p class="mb-1 text-muted">Class</p>
                        <p><?= htmlspecialchars($exam['class_name'] ?? 'All Classes') ?></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <p class="mb-1 text-muted">Start Date</p>
                        <p><?= date('M d, Y', strtotime($exam['start_date'])) ?></p>
                    </div>
                    <div class="col-6">
                        <p class="mb-1 text-muted">End Date</p>
                        <p><?= date('M d, Y', strtotime($exam['end_date'])) ?></p>
                    </div>
                </div>
                <div class="mb-0">
                    <p class="mb-1 text-muted">Academic Year</p>
                    <p><?= htmlspecialchars($exam['academic_year']) ?></p>
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
                <p><?= nl2br(htmlspecialchars($exam['description'] ?? 'No description provided.')) ?></p>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <a href="/marks?exam_id=<?= $exam['id'] ?>" class="btn btn-outline-primary btn-sm mb-2 w-100">
                    <i class="bi bi-pencil-square me-2"></i>Enter/View Marks
                </a>
                <a href="/marks/enter?exam_id=<?= $exam['id'] ?>" class="btn btn-outline-success btn-sm w-100">
                    <i class="bi bi-file-earmark-text me-2"></i>Generate Report Cards
                </a>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
