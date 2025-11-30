<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Add Questions to Quiz</h1>
        <p class="text-muted mb-0"><?= htmlspecialchars($quiz['title']) ?></p>
    </div>
    <a href="/quizzes/<?= $quiz['id'] ?>" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="/quizzes/<?= $quiz['id'] ?>/add-questions">
            <input type="hidden" name="_token" value="<?= csrf() ?>">

            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-question-circle me-2"></i>Available Questions from <?= htmlspecialchars($quiz['subject_name']) ?>
                </h6>
                
                <?php if (!empty($questions)): ?>
                    <div class="list-group">
                        <?php foreach ($questions as $index => $question): ?>
                            <?php $isSelected = in_array($question['id'], $existingIds); ?>
                            <label class="list-group-item">
                                <div class="d-flex">
                                    <input class="form-check-input me-2" type="checkbox" name="question_ids[]" 
                                           value="<?= $question['id'] ?>" <?= $isSelected ? 'checked disabled' : '' ?>>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1"><?= htmlspecialchars($question['question_text']) ?></h6>
                                        <small class="text-muted">
                                            Difficulty: <span class="badge bg-info"><?= ucfirst($question['difficulty_level'] ?? 'medium') ?></span>
                                            <?php if ($isSelected): ?>
                                                <span class="badge bg-success ms-2">Already Added</span>
                                            <?php endif; ?>
                                        </small>
                                    </div>
                                </div>
                            </label>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        No questions available for this subject. Please <a href="/question-bank/create">create questions</a> first.
                    </div>
                <?php endif; ?>
            </div>

            <!-- Form Actions -->
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary" <?= empty($questions) ? 'disabled' : '' ?>>
                    <i class="bi bi-check-circle me-2"></i>Add Selected Questions
                </button>
                <a href="/quizzes/<?= $quiz['id'] ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-x-circle me-2"></i>Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
