<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Create New Quiz</h1>
        <p class="text-muted mb-0">Design a comprehensive assessment for students</p>
    </div>
    <a href="/quizzes" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="/quizzes" class="needs-validation">
            <input type="hidden" name="_token" value="<?= csrf() ?>">

            <!-- Quiz Title & Details -->
            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-file-earmark me-2"></i>Quiz Details
                </h6>
                <div class="mb-3">
                    <label class="form-label fw-bold">Title *</label>
                    <input type="text" name="title" class="form-control" placeholder="e.g., Chapter 3: Quadratic Equations Quiz" required>
                    <small class="text-muted">Descriptive title that reflects quiz content</small>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Description</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Provide a brief overview of what topics this quiz covers..."></textarea>
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
                        <label class="form-label fw-bold">Subject *</label>
                        <select name="subject_id" class="form-select" required>
                            <option value="">-- Select Subject --</option>
                            <?php foreach ($subjects as $subject): ?>
                                <option value="<?= $subject['id'] ?>">
                                    <?= htmlspecialchars($subject['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Class *</label>
                        <select name="class_id" class="form-select" required>
                            <option value="">-- Select Class --</option>
                            <?php foreach ($classes as $class): ?>
                                <option value="<?= $class['id'] ?>">
                                    <?= htmlspecialchars($class['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
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
                        <input type="datetime-local" name="start_time" class="form-control">
                        <small class="text-muted">When students can begin the quiz</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">End Date & Time</label>
                        <input type="datetime-local" name="end_time" class="form-control">
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
                        <input type="number" name="duration_minutes" class="form-control" value="30" min="5" required>
                        <small class="text-muted">How long students have to complete the quiz</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Total Marks *</label>
                        <input type="number" name="total_marks" class="form-control" value="10" min="1" required>
                        <small class="text-muted">Maximum score for this quiz</small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Passing Marks</label>
                        <input type="number" name="passing_marks" class="form-control" placeholder="e.g., 5">
                        <small class="text-muted">Minimum marks to pass (optional)</small>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Create Quiz
                </button>
                <a href="/quizzes" class="btn btn-outline-secondary">
                    <i class="bi bi-x-circle me-2"></i>Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>