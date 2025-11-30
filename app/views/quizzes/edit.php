<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Edit Quiz</h1>
        <p class="text-muted mb-0">Update quiz details</p>
    </div>
    <a href="/quizzes" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="/quizzes/<?= $quiz['id'] ?>" class="needs-validation">
            <input type="hidden" name="_token" value="<?= csrf() ?>">

            <!-- Quiz Title & Details -->
            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-file-earmark me-2"></i>Quiz Details
                </h6>
                <div class="mb-3">
                    <label class="form-label fw-bold">Title *</label>
                    <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($quiz['title']) ?>" required>
                    <small class="text-muted">Descriptive title that reflects quiz content</small>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Description</label>
                    <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($quiz['description'] ?? '') ?></textarea>
                    <small class="text-muted">Help students understand the scope of the quiz</small>
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
                                <option value="<?= $subject['id'] ?>" <?= $quiz['subject_id'] == $subject['id'] ? 'selected' : '' ?>>
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
                                <option value="<?= $class['id'] ?>" <?= $quiz['class_id'] == $class['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($class['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="text-muted">Cannot change after creation</small>
                    </div>
                </div>
            </div>

            <!-- Quiz Schedule -->
            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-calendar-event me-2"></i>Quiz Schedule
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Start Date & Time</label>
                        <input type="datetime-local" name="start_time" class="form-control" 
                               value="<?= $quiz['start_time'] ? date('Y-m-d\TH:i', strtotime($quiz['start_time'])) : '' ?>">
                        <small class="text-muted">When students can begin the quiz</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">End Date & Time</label>
                        <input type="datetime-local" name="end_time" class="form-control"
                               value="<?= $quiz['end_time'] ? date('Y-m-d\TH:i', strtotime($quiz['end_time'])) : '' ?>">
                        <small class="text-muted">When the quiz closes</small>
                    </div>
                </div>
            </div>

            <!-- Duration & Marks -->
            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-hourglass-end me-2"></i>Duration & Marks
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Duration (Minutes) *</label>
                        <input type="number" name="duration_minutes" class="form-control" value="<?= $quiz['duration_minutes'] ?>" min="5" required>
                        <small class="text-muted">How long students have to complete the quiz</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Total Marks *</label>
                        <input type="number" name="total_marks" class="form-control" value="<?= $quiz['total_marks'] ?>" min="1" required>
                        <small class="text-muted">Maximum score for this quiz</small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Passing Marks</label>
                        <input type="number" name="passing_marks" class="form-control" value="<?= $quiz['passing_marks'] ?? '' ?>">
                        <small class="text-muted">Minimum marks to pass (optional)</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Status</label>
                        <select name="status" class="form-select">
                            <option value="draft" <?= $quiz['status'] === 'draft' ? 'selected' : '' ?>>Draft</option>
                            <option value="active" <?= $quiz['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                            <option value="closed" <?= $quiz['status'] === 'closed' ? 'selected' : '' ?>>Closed</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Update Quiz
                </button>
                <a href="/quizzes/<?= $quiz['id'] ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-x-circle me-2"></i>Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
