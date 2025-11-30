<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Edit Assignment</h1>
        <p class="text-muted mb-0">Update assignment details</p>
    </div>
    <a href="/assignments" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="/assignments/<?= $assignment['id'] ?>" class="needs-validation">
            <input type="hidden" name="_token" value="<?= csrf() ?>">

            <!-- Assignment Title & Details -->
            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-file-earmark me-2"></i>Assignment Details
                </h6>
                <div class="mb-3">
                    <label class="form-label fw-bold">Title *</label>
                    <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($assignment['title']) ?>" required>
                </div>
            </div>

            <!-- Subject & Class -->
            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-book me-2"></i>Subject & Class
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Subject</label>
                        <select name="subject_id" class="form-select" disabled>
                            <?php foreach ($subjects as $subject): ?>
                                <option value="<?= $subject['id'] ?>" <?= $assignment['subject_id'] == $subject['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($subject['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="text-muted">Cannot change after creation</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Class</label>
                        <select name="class_id" class="form-select" disabled>
                            <?php foreach ($classes as $class): ?>
                                <option value="<?= $class['id'] ?>" <?= $assignment['class_id'] == $class['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($class['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="text-muted">Cannot change after creation</small>
                    </div>
                </div>
            </div>

            <!-- Dates & Marks -->
            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-calendar me-2"></i>Timeline & Marks
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Due Date *</label>
                        <input type="date" name="due_date" class="form-control" value="<?= $assignment['due_date'] ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Total Marks</label>
                        <input type="number" name="total_marks" class="form-control" value="<?= $assignment['total_marks'] ?>" min="1">
                    </div>
                </div>
            </div>

            <!-- Description & Instructions -->
            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-file-text me-2"></i>Description & Instructions
                </h6>
                <div class="mb-3">
                    <label class="form-label fw-bold">Description</label>
                    <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($assignment['description'] ?? '') ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Instructions</label>
                    <textarea name="instructions" class="form-control" rows="3"><?= htmlspecialchars($assignment['instructions'] ?? '') ?></textarea>
                </div>
            </div>

            <!-- Status -->
            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-gear me-2"></i>Settings
                </h6>
                <div class="mb-3">
                    <label class="form-label fw-bold">Status</label>
                    <select name="status" class="form-select">
                        <option value="active" <?= $assignment['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                        <option value="draft" <?= $assignment['status'] === 'draft' ? 'selected' : '' ?>>Draft</option>
                    </select>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex gap-2 mt-5">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Update Assignment
                </button>
                <a href="/assignments/<?= $assignment['id'] ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-x-circle me-2"></i>Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<style>
[data-bs-theme="dark"] .text-muted {
    color: #a8b1bd !important;
}

[data-bs-theme="dark"] .form-label {
    color: #e9ecef;
}

[data-bs-theme="dark"] .form-control,
[data-bs-theme="dark"] .form-select {
    background-color: #2d3238;
    color: #e9ecef;
    border-color: #495057;
}

[data-bs-theme="dark"] .form-control:focus,
[data-bs-theme="dark"] .form-select:focus {
    background-color: #2d3238;
    color: #e9ecef;
    border-color: #5a8dee;
    box-shadow: 0 0 0 0.25rem rgba(90, 141, 238, 0.25);
}

[data-bs-theme="dark"] .form-select:disabled,
[data-bs-theme="dark"] .form-control:disabled {
    background-color: #1e2127;
    color: #6c757d;
    border-color: #495057;
}
</style>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
