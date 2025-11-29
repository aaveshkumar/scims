<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Edit Lesson Plan</h1>
        <p class="text-muted mb-0">Update your lesson details</p>
    </div>
    <a href="/lesson-plans" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card">
    <div class="card-header" style="background-color: #000; color: #fff;">
        <h5 class="mb-0">Edit Lesson</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="/lesson-plans/<?= $lessonPlan['id'] ?>">
            <input type="hidden" name="_token" value="<?= csrf() ?>">
            
            <!-- Course Information -->
            <div class="mb-4 pb-4 border-bottom">
                <h6 class="mb-3 text-primary">
                    <i class="bi bi-book me-2"></i>Course Information
                </h6>
                
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Subject *</label>
                        <select name="subject_id" class="form-select" required>
                            <option value="">-- Select Subject --</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Class/Grade *</label>
                        <select name="class_id" class="form-select" required>
                            <option value="">-- Select Class --</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Lesson Date *</label>
                        <input type="date" name="lesson_date" class="form-control" value="<?= htmlspecialchars($lessonPlan['lesson_date'] ?? '') ?>" required>
                    </div>
                </div>
            </div>

            <!-- Lesson Topic & Duration -->
            <div class="mb-4 pb-4 border-bottom">
                <h6 class="mb-3 text-primary">
                    <i class="bi bi-pencil-square me-2"></i>Lesson Topic & Duration
                </h6>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Lesson Topic/Title *</label>
                    <input type="text" name="topic" class="form-control" value="<?= htmlspecialchars($lessonPlan['topic'] ?? '') ?>" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Duration (minutes) *</label>
                        <input type="number" name="duration" class="form-control" value="<?= htmlspecialchars($lessonPlan['duration'] ?? '') ?>" min="15" max="180" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Period Number</label>
                        <input type="number" name="period_number" class="form-control" value="<?= htmlspecialchars($lessonPlan['period_number'] ?? '') ?>" min="1" max="8">
                    </div>
                </div>
            </div>

            <!-- Learning Objectives -->
            <div class="mb-4 pb-4 border-bottom">
                <h6 class="mb-3 text-primary">
                    <i class="bi bi-target me-2"></i>Learning Objectives
                </h6>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Learning Outcomes *</label>
                    <textarea name="learning_outcomes" class="form-control" rows="4" required><?= htmlspecialchars($lessonPlan['learning_outcomes'] ?? '') ?></textarea>
                </div>
            </div>

            <!-- Content & Activities -->
            <div class="mb-4 pb-4 border-bottom">
                <h6 class="mb-3 text-primary">
                    <i class="bi bi-list-ul me-2"></i>Content & Activities
                </h6>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Introduction/Hook *</label>
                    <textarea name="introduction" class="form-control" rows="3" required><?= htmlspecialchars($lessonPlan['introduction'] ?? '') ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Main Content *</label>
                    <textarea name="content" class="form-control" rows="4" required><?= htmlspecialchars($lessonPlan['content'] ?? '') ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Classroom Activities</label>
                    <textarea name="activities" class="form-control" rows="3"><?= htmlspecialchars($lessonPlan['activities'] ?? '') ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Conclusion/Summary</label>
                    <textarea name="conclusion" class="form-control" rows="3"><?= htmlspecialchars($lessonPlan['conclusion'] ?? '') ?></textarea>
                </div>
            </div>

            <!-- Assessment & Materials -->
            <div class="mb-4 pb-4 border-bottom">
                <h6 class="mb-3 text-primary">
                    <i class="bi bi-file-earmark-check me-2"></i>Assessment & Materials
                </h6>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Assessment Method</label>
                    <textarea name="assessment_method" class="form-control" rows="2"><?= htmlspecialchars($lessonPlan['assessment_method'] ?? '') ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Resources & Materials Needed</label>
                    <textarea name="resources" class="form-control" rows="3"><?= htmlspecialchars($lessonPlan['resources'] ?? '') ?></textarea>
                </div>
            </div>

            <!-- Additional Information -->
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Homework Assignment</label>
                    <textarea name="homework" class="form-control" rows="2"><?= htmlspecialchars($lessonPlan['homework'] ?? '') ?></textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Remarks/Notes</label>
                    <textarea name="remarks" class="form-control" rows="2"><?= htmlspecialchars($lessonPlan['remarks'] ?? '') ?></textarea>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Status</label>
                    <select name="status" class="form-select">
                        <option value="draft" <?= ($lessonPlan['status'] ?? '') === 'draft' ? 'selected' : '' ?>>Draft</option>
                        <option value="active" <?= ($lessonPlan['status'] ?? '') === 'active' ? 'selected' : '' ?>>Active</option>
                        <option value="completed" <?= ($lessonPlan['status'] ?? '') === 'completed' ? 'selected' : '' ?>>Completed</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Difficulty Level</label>
                    <select name="difficulty_level" class="form-select">
                        <option value="">-- Select Level --</option>
                        <option value="easy" <?= ($lessonPlan['difficulty_level'] ?? '') === 'easy' ? 'selected' : '' ?>>Easy</option>
                        <option value="medium" <?= ($lessonPlan['difficulty_level'] ?? '') === 'medium' ? 'selected' : '' ?>>Medium</option>
                        <option value="hard" <?= ($lessonPlan['difficulty_level'] ?? '') === 'hard' ? 'selected' : '' ?>>Hard</option>
                    </select>
                </div>
            </div>

            <div class="d-flex gap-2 pt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Update Lesson Plan
                </button>
                <a href="/lesson-plans" class="btn btn-secondary">
                    <i class="bi bi-x-circle me-2"></i>Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
