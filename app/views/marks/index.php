<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Exam Marks</h1>
        <?php if (isset($exam)): ?>
            <p class="text-muted mb-0"><?= htmlspecialchars($exam['name']) ?> - <?= htmlspecialchars($exam['code']) ?></p>
        <?php endif; ?>
    </div>
    <div>
        <a href="/marks/enter?exam_id=<?= $exam['id'] ?? '' ?>" class="btn btn-success me-2">
            <i class="bi bi-pencil-square me-2"></i>Enter Marks
        </a>
        <a href="/marks" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Marks List</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Admission #</th>
                        <th>Student Name</th>
                        <th>Subject</th>
                        <th>Marks Obtained</th>
                        <th>Total Marks</th>
                        <th>Percentage</th>
                        <th>Grade</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($marks)): ?>
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">No marks entered yet</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($marks as $mark): ?>
                            <tr>
                                <td><?= htmlspecialchars($mark['admission_number']) ?></td>
                                <td><?= htmlspecialchars($mark['first_name'] . ' ' . $mark['last_name']) ?></td>
                                <td><?= htmlspecialchars($mark['subject_name']) ?></td>
                                <td><?= $mark['marks_obtained'] ?></td>
                                <td><?= $mark['total_marks'] ?></td>
                                <td>
                                    <?php 
                                    $percentage = ($mark['total_marks'] > 0) ? round(($mark['marks_obtained'] / $mark['total_marks']) * 100, 2) : 0;
                                    ?>
                                    <?= $percentage ?>%
                                </td>
                                <td>
                                    <span class="badge bg-<?= match($mark['grade']) {
                                        'A+', 'A' => 'success',
                                        'B+', 'B' => 'primary',
                                        'C+', 'C' => 'info',
                                        'D' => 'warning',
                                        default => 'danger'
                                    } ?>">
                                        <?= htmlspecialchars($mark['grade']) ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="/marks/report-card/<?= $mark['student_id'] ?>/<?= $mark['exam_id'] ?>" class="btn btn-sm btn-info">
                                        <i class="bi bi-file-earmark-text"></i> Report
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
