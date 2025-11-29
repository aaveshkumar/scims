<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Question Bank</h1>
        <p class="text-muted mb-0">Manage all exam questions</p>
    </div>
    <a href="/question-bank/create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Create Question
    </a>
</div>

<div class="card">
    <div class="card-header" style="background-color: #000; color: #fff;">
        <h5 class="mb-0">All Questions</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Question</th>
                        <th>Subject</th>
                        <th>Class</th>
                        <th>Type</th>
                        <th>Difficulty</th>
                        <th>Marks</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($questions && count($questions) > 0): ?>
                        <?php foreach ($questions as $q): ?>
                            <tr>
                                <td><?= htmlspecialchars(substr($q['question_text'], 0, 50)) . '...' ?></td>
                                <td><?= htmlspecialchars($q['subject_name'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($q['class_name'] ?? 'N/A') ?></td>
                                <td>
                                    <span class="badge bg-info">
                                        <?= ucfirst(str_replace('_', ' ', $q['question_type'] ?? 'N/A')) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-<?= $q['difficulty_level'] === 'easy' ? 'success' : ($q['difficulty_level'] === 'hard' ? 'danger' : 'warning') ?>">
                                        <?= ucfirst($q['difficulty_level'] ?? 'N/A') ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($q['marks'] ?? 'N/A') ?></td>
                                <td>
                                    <span class="badge bg-<?= $q['status'] === 'active' ? 'success' : ($q['status'] === 'draft' ? 'warning' : 'secondary') ?>">
                                        <?= ucfirst($q['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="/question-bank/<?= $q['id'] ?>" class="btn btn-sm btn-info" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="/question-bank/<?= $q['id'] ?>/edit" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" action="/question-bank/<?= $q['id'] ?>" style="display:inline;">
                                        <input type="hidden" name="_token" value="<?= csrf() ?>">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Delete this question?');">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                No questions available. Click "Create Question" to add one.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
