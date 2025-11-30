<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Edit Exam</h1>
    <a href="/exams/<?= $exam['id'] ?>" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Update Exam Details</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="/exams/<?= $exam['id'] ?>">
            <input type="hidden" name="_token" value="<?= csrf() ?>">
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Exam Name *</label>
                    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($exam['name']) ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Exam Code *</label>
                    <input type="text" name="code" class="form-control" value="<?= htmlspecialchars($exam['code']) ?>" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Exam Type *</label>
                    <select name="exam_type" class="form-select" required>
                        <option value="mid_term" <?= $exam['exam_type'] === 'mid_term' ? 'selected' : '' ?>>Mid Term</option>
                        <option value="final" <?= $exam['exam_type'] === 'final' ? 'selected' : '' ?>>Final</option>
                        <option value="quarterly" <?= $exam['exam_type'] === 'quarterly' ? 'selected' : '' ?>>Quarterly</option>
                        <option value="half_yearly" <?= $exam['exam_type'] === 'half_yearly' ? 'selected' : '' ?>>Half Yearly</option>
                        <option value="annual" <?= $exam['exam_type'] === 'annual' ? 'selected' : '' ?>>Annual</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Class</label>
                    <select name="class_id" class="form-select">
                        <option value="">All Classes</option>
                        <?php foreach ($classes as $class): ?>
                            <option value="<?= $class['id'] ?>" <?= $class['id'] == ($exam['class_id'] ?? '') ? 'selected' : '' ?>>
                                <?= htmlspecialchars($class['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Academic Year *</label>
                    <input type="text" name="academic_year" class="form-control" value="<?= htmlspecialchars($exam['academic_year']) ?>" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Start Date *</label>
                    <input type="date" name="start_date" class="form-control" value="<?= $exam['start_date'] ?>" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">End Date *</label>
                    <input type="date" name="end_date" class="form-control" value="<?= $exam['end_date'] ?>" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Status *</label>
                    <select name="status" class="form-select" required>
                        <option value="scheduled" <?= $exam['status'] === 'scheduled' ? 'selected' : '' ?>>Scheduled</option>
                        <option value="ongoing" <?= $exam['status'] === 'ongoing' ? 'selected' : '' ?>>Ongoing</option>
                        <option value="completed" <?= $exam['status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($exam['description'] ?? '') ?></textarea>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Update Exam
                </button>
                <a href="/exams/<?= $exam['id'] ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
