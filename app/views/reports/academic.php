<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-graph-up me-2"></i>Academic Reports</h2>
</div>

<!-- Summary Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-primary"><?= $summary['total'] ?? 0 ?></h3>
                <p class="mb-0">Total Records</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-info"><?= round($summary['avg_marks'] ?? 0, 2) ?></h3>
                <p class="mb-0">Average Marks</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-success"><?= $summary['highest'] ?? 0 ?></h3>
                <p class="mb-0">Highest Marks</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center">
            <div class="card-body">
                <h3 class="text-warning"><?= $summary['lowest'] ?? 0 ?></h3>
                <p class="mb-0">Lowest Marks</p>
            </div>
        </div>
    </div>
</div>

<!-- Data Table -->
<div class="card">
    <div class="card-header">
        <h6 class="mb-0">Student Marks Records</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Student</th>
                        <th>Subject</th>
                        <th>Exam</th>
                        <th>Marks</th>
                        <th>Grade</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($records)): ?>
                        <?php foreach ($records as $index => $record): ?>
                            <tr>
                                <td><?= $index + 1 ?></td>
                                <td><?= htmlspecialchars(($record['first_name'] ?? 'N/A') . ' ' . ($record['last_name'] ?? '')) ?></td>
                                <td><?= htmlspecialchars($record['subject_name'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($record['exam_name'] ?? 'N/A') ?></td>
                                <td><?= $record['marks_obtained'] ?? 0 ?></td>
                                <td>
                                    <strong><?= htmlspecialchars($record['grade'] ?? 'N/A') ?></strong>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">No marks records found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
