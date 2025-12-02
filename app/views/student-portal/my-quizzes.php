<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="mb-4">
    <h2><i class="bi bi-question-circle me-2"></i>Available Quizzes</h2>
</div>

<?php if (empty($quizzes)): ?>
    <div class="alert alert-info">No quizzes available</div>
<?php else: ?>
    <div class="row">
        <?php foreach ($quizzes as $quiz): ?>
            <div class="col-md-6 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($quiz['title']) ?></h5>
                        <p class="card-text text-muted"><?= htmlspecialchars($quiz['subject_name']) ?></p>
                        <div class="mb-2">
                            <small><strong>Questions:</strong> <?= $quiz['total_questions'] ?></small><br>
                            <small><strong>Duration:</strong> <?= $quiz['duration_minutes'] ?> minutes</small>
                        </div>
                        <a href="/quizzes/<?= $quiz['id'] ?>" class="btn btn-sm btn-primary">
                            <i class="bi bi-play-circle me-1"></i>Take Quiz
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
