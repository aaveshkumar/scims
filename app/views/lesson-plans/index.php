<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Lesson Plans</h1>
        <p class="text-muted mb-0">Manage all lesson plans for your courses</p>
    </div>
    <a href="/lesson-plans/create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Create Lesson Plan
    </a>
</div>

<div class="card">
    <div class="card-header" style="background-color: #000; color: #fff;">
        <h5 class="mb-0">All Lesson Plans</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Topic</th>
                        <th>Subject</th>
                        <th>Class</th>
                        <th>Date</th>
                        <th>Duration</th>
                        <th>Status</th>
                        <th>Difficulty</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($lessonPlans && count($lessonPlans) > 0): ?>
                        <?php foreach ($lessonPlans as $lesson): ?>
                            <tr>
                                <td><?= htmlspecialchars($lesson['topic'] ?? '') ?></td>
                                <td><?= htmlspecialchars($lesson['subject_name'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($lesson['class_name'] ?? 'N/A') ?></td>
                                <td><?= $lesson['lesson_date'] ? date('d M Y', strtotime($lesson['lesson_date'])) : 'N/A' ?></td>
                                <td><?= htmlspecialchars($lesson['duration'] ?? 'N/A') ?> mins</td>
                                <td>
                                    <span class="badge bg-<?= $lesson['status'] === 'active' ? 'success' : ($lesson['status'] === 'completed' ? 'info' : 'warning') ?>">
                                        <?= ucfirst($lesson['status'] ?? 'active') ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($lesson['difficulty_level']): ?>
                                        <span class="badge bg-<?= $lesson['difficulty_level'] === 'easy' ? 'info' : ($lesson['difficulty_level'] === 'hard' ? 'danger' : 'warning') ?>">
                                            <?= ucfirst($lesson['difficulty_level']) ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="/lesson-plans/<?= $lesson['id'] ?>" class="btn btn-sm btn-info" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="/lesson-plans/<?= $lesson['id'] ?>/edit" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" action="/lesson-plans/<?= $lesson['id'] ?>" style="display:inline;">
                                        <input type="hidden" name="_token" value="<?= csrf() ?>">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Delete this lesson plan?');">
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
                                No lesson plans available. Click "Create Lesson Plan" to add one.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
