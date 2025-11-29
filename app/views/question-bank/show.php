<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">View Question</h1>
        <p class="text-muted mb-0">Question Details</p>
    </div>
    <div>
        <a href="/question-bank/<?= $question['id'] ?>/edit" class="btn btn-warning me-2">
            <i class="bi bi-pencil me-2"></i>Edit
        </a>
        <a href="/question-bank" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-3">
                <h6 class="text-muted">Subject</h6>
                <p><?= htmlspecialchars($question['subject_name'] ?? 'N/A') ?></p>
            </div>
            <div class="col-md-3">
                <h6 class="text-muted">Class</h6>
                <p><?= htmlspecialchars($question['class_name'] ?? 'N/A') ?></p>
            </div>
            <div class="col-md-3">
                <h6 class="text-muted">Type</h6>
                <p><?= ucfirst(str_replace('_', ' ', $question['question_type'] ?? 'N/A')) ?></p>
            </div>
            <div class="col-md-3">
                <h6 class="text-muted">Status</h6>
                <span class="badge bg-<?= $question['status'] === 'active' ? 'success' : 'warning' ?>">
                    <?= ucfirst($question['status']) ?>
                </span>
            </div>
        </div>

        <hr>

        <div class="mb-4">
            <h6 class="fw-bold">Question</h6>
            <p><?= nl2br(htmlspecialchars($question['question_text'])) ?></p>
        </div>

        <?php if ($question['option_a']): ?>
        <div class="mb-4">
            <h6 class="fw-bold">Options</h6>
            <div class="ms-3">
                <p><strong>A:</strong> <?= htmlspecialchars($question['option_a']) ?></p>
                <p><strong>B:</strong> <?= htmlspecialchars($question['option_b'] ?? 'N/A') ?></p>
                <p><strong>C:</strong> <?= htmlspecialchars($question['option_c'] ?? 'N/A') ?></p>
                <p><strong>D:</strong> <?= htmlspecialchars($question['option_d'] ?? 'N/A') ?></p>
            </div>
        </div>

        <div class="mb-4">
            <h6 class="fw-bold">Correct Answer</h6>
            <p><?= htmlspecialchars($question['correct_answer'] ?? 'N/A') ?></p>
        </div>
        <?php endif; ?>

        <?php if ($question['explanation']): ?>
        <div class="mb-4">
            <h6 class="fw-bold">Explanation</h6>
            <p><?= nl2br(htmlspecialchars($question['explanation'])) ?></p>
        </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-6">
                <h6 class="text-muted">Marks</h6>
                <p><?= htmlspecialchars($question['marks'] ?? 'N/A') ?></p>
            </div>
            <div class="col-md-6">
                <h6 class="text-muted">Difficulty Level</h6>
                <p><?= htmlspecialchars($question['difficulty_level'] ?? 'N/A') ?></p>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
