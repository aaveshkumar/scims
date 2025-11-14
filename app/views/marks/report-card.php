<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Report Card</h1>
        <p class="text-muted mb-0"><?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?></p>
    </div>
    <div>
        <button onclick="window.print()" class="btn btn-primary me-2">
            <i class="bi bi-printer me-2"></i>Print
        </button>
        <a href="/marks?exam_id=<?= $exam['id'] ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="text-center mb-4">
            <h2>School Management System</h2>
            <h4>Academic Report Card</h4>
            <p class="text-muted"><?= htmlspecialchars($exam['name']) ?> - <?= htmlspecialchars($exam['academic_year']) ?></p>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <p><strong>Student Name:</strong> <?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?></p>
                <p><strong>Admission Number:</strong> <?= htmlspecialchars($student['admission_number']) ?></p>
                <p><strong>Class:</strong> <?= htmlspecialchars($student['class_name'] ?? 'N/A') ?></p>
            </div>
            <div class="col-md-6 text-md-end">
                <p><strong>Exam:</strong> <?= htmlspecialchars($exam['name']) ?></p>
                <p><strong>Exam Code:</strong> <?= htmlspecialchars($exam['code']) ?></p>
                <p><strong>Academic Year:</strong> <?= htmlspecialchars($exam['academic_year']) ?></p>
            </div>
        </div>

        <div class="table-responsive mb-4">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Subject</th>
                        <th class="text-center">Total Marks</th>
                        <th class="text-center">Marks Obtained</th>
                        <th class="text-center">Grade</th>
                        <th>Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($marks)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">No marks available</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($marks as $mark): ?>
                            <tr>
                                <td><?= htmlspecialchars($mark['subject_name']) ?></td>
                                <td class="text-center"><?= $mark['total_marks'] ?></td>
                                <td class="text-center"><?= $mark['marks_obtained'] ?></td>
                                <td class="text-center">
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
                                <td><?= htmlspecialchars($mark['remarks'] ?? '-') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <th>Total</th>
                        <th class="text-center"><?= $total ?></th>
                        <th class="text-center"><?= $obtained ?></th>
                        <th colspan="2"></th>
                    </tr>
                    <tr>
                        <th colspan="2">Percentage</th>
                        <th class="text-center" colspan="3"><?= $percentage ?>%</th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="row">
            <div class="col-md-6">
                <p><strong>Overall Grade:</strong> 
                    <span class="badge bg-<?= $percentage >= 90 ? 'success' : ($percentage >= 75 ? 'primary' : ($percentage >= 60 ? 'info' : ($percentage >= 40 ? 'warning' : 'danger'))) ?> fs-6">
                        <?= $percentage >= 90 ? 'A+' : ($percentage >= 80 ? 'A' : ($percentage >= 70 ? 'B+' : ($percentage >= 60 ? 'B' : ($percentage >= 50 ? 'C' : ($percentage >= 40 ? 'D' : 'F'))))) ?>
                    </span>
                </p>
                <p><strong>Result:</strong> 
                    <span class="badge bg-<?= $percentage >= 40 ? 'success' : 'danger' ?> fs-6">
                        <?= $percentage >= 40 ? 'PASS' : 'FAIL' ?>
                    </span>
                </p>
            </div>
            <div class="col-md-6 text-md-end">
                <p><strong>Date:</strong> <?= date('M d, Y') ?></p>
            </div>
        </div>

        <div class="row mt-5 pt-4">
            <div class="col-md-4 text-center">
                <hr class="w-75 mx-auto">
                <p class="mb-0">Class Teacher</p>
            </div>
            <div class="col-md-4 text-center">
                <hr class="w-75 mx-auto">
                <p class="mb-0">Principal</p>
            </div>
            <div class="col-md-4 text-center">
                <hr class="w-75 mx-auto">
                <p class="mb-0">Parent/Guardian</p>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .btn, .d-flex > .btn-group, nav, .sidebar { display: none !important; }
    .card { border: none !important; box-shadow: none !important; }
}
</style>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
