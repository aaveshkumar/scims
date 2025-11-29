<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Edit Question</h1>
        <p class="text-muted mb-0">Update question details</p>
    </div>
    <a href="/question-bank" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card">
    <div class="card-header" style="background-color: #000; color: #fff;">
        <h5 class="mb-0">Edit Question</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="/question-bank/<?= $question['id'] ?>">
            <input type="hidden" name="_token" value="<?= csrf() ?>">
            
            <!-- Course Information -->
            <div class="mb-4 pb-4 border-bottom">
                <h6 class="mb-3 text-primary">
                    <i class="bi bi-book me-2"></i>Course Information
                </h6>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Subject *</label>
                        <select name="subject_id" class="form-select" required>
                            <option value="">-- Select Subject --</option>
                            <?php foreach ($subjects as $subject): ?>
                                <option value="<?= $subject['id'] ?>" <?= $question['subject_id'] == $subject['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($subject['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Class/Grade *</label>
                        <select name="class_id" class="form-select" required>
                            <option value="">-- Select Class --</option>
                            <?php foreach ($classes as $class): ?>
                                <option value="<?= $class['id'] ?>" <?= $question['class_id'] == $class['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($class['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Question Information -->
            <div class="mb-4 pb-4 border-bottom">
                <h6 class="mb-3 text-primary">
                    <i class="bi bi-question-circle me-2"></i>Question Details
                </h6>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Question Text *</label>
                    <textarea name="question_text" class="form-control" rows="4" required><?= htmlspecialchars($question['question_text']) ?></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Question Type *</label>
                        <select name="question_type" class="form-select" required>
                            <option value="">-- Select Type --</option>
                            <option value="multiple_choice" <?= $question['question_type'] === 'multiple_choice' ? 'selected' : '' ?>>Multiple Choice</option>
                            <option value="true_false" <?= $question['question_type'] === 'true_false' ? 'selected' : '' ?>>True/False</option>
                            <option value="short_answer" <?= $question['question_type'] === 'short_answer' ? 'selected' : '' ?>>Short Answer</option>
                            <option value="long_answer" <?= $question['question_type'] === 'long_answer' ? 'selected' : '' ?>>Long Answer</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Difficulty Level *</label>
                        <select name="difficulty_level" class="form-select" required>
                            <option value="">-- Select Level --</option>
                            <option value="easy" <?= $question['difficulty_level'] === 'easy' ? 'selected' : '' ?>>Easy</option>
                            <option value="medium" <?= $question['difficulty_level'] === 'medium' ? 'selected' : '' ?>>Medium</option>
                            <option value="hard" <?= $question['difficulty_level'] === 'hard' ? 'selected' : '' ?>>Hard</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Marks *</label>
                        <input type="number" name="marks" class="form-control" value="<?= htmlspecialchars($question['marks'] ?? '') ?>" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Chapter/Topic</label>
                        <input type="text" name="chapter_topic" class="form-control" value="<?= htmlspecialchars($question['chapter_topic'] ?? '') ?>">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Keywords</label>
                        <input type="text" name="keywords" class="form-control" value="<?= htmlspecialchars($question['keywords'] ?? '') ?>">
                    </div>
                </div>
            </div>

            <!-- Multiple Choice Options -->
            <div class="mb-4 pb-4 border-bottom">
                <h6 class="mb-3 text-primary">
                    <i class="bi bi-list-ul me-2"></i>Multiple Choice Options
                </h6>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Option A</label>
                    <input type="text" name="option_a" class="form-control" value="<?= htmlspecialchars($question['option_a'] ?? '') ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Option B</label>
                    <input type="text" name="option_b" class="form-control" value="<?= htmlspecialchars($question['option_b'] ?? '') ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Option C</label>
                    <input type="text" name="option_c" class="form-control" value="<?= htmlspecialchars($question['option_c'] ?? '') ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Option D</label>
                    <input type="text" name="option_d" class="form-control" value="<?= htmlspecialchars($question['option_d'] ?? '') ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Correct Answer</label>
                    <select name="correct_answer" class="form-select">
                        <option value="">-- Select Correct Answer --</option>
                        <option value="A" <?= $question['correct_answer'] === 'A' ? 'selected' : '' ?>>Option A</option>
                        <option value="B" <?= $question['correct_answer'] === 'B' ? 'selected' : '' ?>>Option B</option>
                        <option value="C" <?= $question['correct_answer'] === 'C' ? 'selected' : '' ?>>Option C</option>
                        <option value="D" <?= $question['correct_answer'] === 'D' ? 'selected' : '' ?>>Option D</option>
                    </select>
                </div>
            </div>

            <!-- Explanation -->
            <div class="mb-4 pb-4 border-bottom">
                <h6 class="mb-3 text-primary">
                    <i class="bi bi-info-circle me-2"></i>Explanation & Feedback
                </h6>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Explanation/Solution</label>
                    <textarea name="explanation" class="form-control" rows="3"><?= htmlspecialchars($question['explanation'] ?? '') ?></textarea>
                </div>
            </div>

            <!-- Status -->
            <div class="mb-4">
                <label class="form-label fw-bold">Status</label>
                <select name="status" class="form-select">
                    <option value="active" <?= $question['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="draft" <?= $question['status'] === 'draft' ? 'selected' : '' ?>>Draft</option>
                    <option value="inactive" <?= $question['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>

            <div class="d-flex gap-2 pt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Update Question
                </button>
                <a href="/question-bank" class="btn btn-secondary">
                    <i class="bi bi-x-circle me-2"></i>Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
