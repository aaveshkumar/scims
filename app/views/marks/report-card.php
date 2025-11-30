<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Report Card</h1>
        <p class="text-muted mb-0"><?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?></p>
    </div>
    <div>
        <button onclick="window.print()" class="btn btn-primary me-2">
            <i class="bi bi-printer me-2"></i>Print Report
        </button>
        <a href="/marks?exam_id=<?= $exam['id'] ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body p-4">
        <!-- Header -->
        <div class="text-center mb-4 pb-3 border-bottom">
            <h2 class="mb-1">School Management System</h2>
            <h4 class="text-primary mb-2">Academic Report Card</h4>
            <p class="text-muted mb-0"><?= htmlspecialchars($exam['name']) ?> - Academic Year: <?= htmlspecialchars($exam['academic_year']) ?></p>
        </div>

        <!-- Student Information -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="mb-2">
                    <span class="text-muted small">STUDENT NAME</span>
                    <p class="mb-0"><strong><?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?></strong></p>
                </div>
                <div class="mb-2">
                    <span class="text-muted small">ADMISSION NUMBER</span>
                    <p class="mb-0"><strong><?= htmlspecialchars($student['admission_number']) ?></strong></p>
                </div>
                <div>
                    <span class="text-muted small">CLASS</span>
                    <p class="mb-0"><strong><?= htmlspecialchars($student['class_name'] ?? 'N/A') ?></strong></p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-2">
                    <span class="text-muted small">EXAM NAME</span>
                    <p class="mb-0"><strong><?= htmlspecialchars($exam['name']) ?></strong></p>
                </div>
                <div class="mb-2">
                    <span class="text-muted small">EXAM CODE</span>
                    <p class="mb-0"><strong><?= htmlspecialchars($exam['code']) ?></strong></p>
                </div>
                <div>
                    <span class="text-muted small">DATE</span>
                    <p class="mb-0"><strong><?= date('M d, Y') ?></strong></p>
                </div>
            </div>
        </div>

        <!-- Marks Table -->
        <div class="table-responsive mb-4">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Subject</th>
                        <th class="text-center" style="width: 120px;">Total Marks</th>
                        <th class="text-center" style="width: 130px;">Marks Obtained</th>
                        <th class="text-center" style="width: 100px;">Percentage</th>
                        <th class="text-center" style="width: 80px;">Grade</th>
                        <th style="width: 150px;">Remarks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($marks)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No marks available</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($marks as $mark): 
                            $markPercentage = ($mark['total_marks'] > 0) ? round(($mark['marks_obtained'] / $mark['total_marks']) * 100, 1) : 0;
                        ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($mark['subject_name']) ?></strong></td>
                                <td class="text-center"><?= (int)$mark['total_marks'] ?></td>
                                <td class="text-center"><strong><?= (int)$mark['marks_obtained'] ?></strong></td>
                                <td class="text-center"><strong><?= $markPercentage ?>%</strong></td>
                                <td class="text-center">
                                    <span class="badge bg-<?= match($mark['grade']) {
                                        'A+', 'A' => 'success',
                                        'B+', 'B' => 'primary',
                                        'C+', 'C' => 'info',
                                        'D' => 'warning',
                                        default => 'danger'
                                    } ?> fs-6">
                                        <?= htmlspecialchars($mark['grade']) ?>
                                    </span>
                                </td>
                                <td><?= htmlspecialchars($mark['remarks'] ?? '-') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
                <tfoot class="table-light">
                    <tr class="fw-bold">
                        <td>TOTAL / OVERALL</td>
                        <td class="text-center"><?= (int)$total ?></td>
                        <td class="text-center"><?= (int)$obtained ?></td>
                        <td class="text-center" colspan="2"><?= $percentage ?>%</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <!-- Summary Section -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card bg-light border-0">
                    <div class="card-body text-center">
                        <p class="text-muted small mb-1">OVERALL PERCENTAGE</p>
                        <h3 class="mb-0"><?= $percentage ?>%</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-light border-0">
                    <div class="card-body text-center">
                        <p class="text-muted small mb-1">OVERALL GRADE</p>
                        <h3 class="mb-0">
                            <span class="badge bg-<?= $percentage >= 90 ? 'success' : ($percentage >= 75 ? 'primary' : ($percentage >= 60 ? 'info' : ($percentage >= 40 ? 'warning' : 'danger'))) ?> fs-5">
                                <?= $percentage >= 90 ? 'A+' : ($percentage >= 80 ? 'A' : ($percentage >= 70 ? 'B+' : ($percentage >= 60 ? 'B' : ($percentage >= 50 ? 'C' : ($percentage >= 40 ? 'D' : 'F'))))) ?>
                            </span>
                        </h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-light border-0">
                    <div class="card-body text-center">
                        <p class="text-muted small mb-1">RESULT</p>
                        <h3 class="mb-0">
                            <span class="badge bg-<?= $percentage >= 40 ? 'success' : 'danger' ?> fs-5">
                                <?= $percentage >= 40 ? 'PASS' : 'FAIL' ?>
                            </span>
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grade Scale -->
        <div class="card bg-light border-0 mb-4">
            <div class="card-header bg-transparent border-0">
                <p class="text-muted small mb-0 fw-bold">GRADE SCALE</p>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-2">
                        <p class="small mb-0">90-100%</p>
                        <span class="badge bg-success fs-6">A+</span>
                    </div>
                    <div class="col-md-2">
                        <p class="small mb-0">80-89%</p>
                        <span class="badge bg-success fs-6">A</span>
                    </div>
                    <div class="col-md-2">
                        <p class="small mb-0">70-79%</p>
                        <span class="badge bg-primary fs-6">B+</span>
                    </div>
                    <div class="col-md-2">
                        <p class="small mb-0">60-69%</p>
                        <span class="badge bg-primary fs-6">B</span>
                    </div>
                    <div class="col-md-2">
                        <p class="small mb-0">50-59%</p>
                        <span class="badge bg-info fs-6">C</span>
                    </div>
                    <div class="col-md-2">
                        <p class="small mb-0">Below 50%</p>
                        <span class="badge bg-danger fs-6">F</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Signature Section -->
        <div class="row mt-5 pt-4 border-top">
            <div class="col-md-4 text-center">
                <div style="height: 80px;"></div>
                <hr style="width: 80%; margin: 0 auto;">
                <p class="text-muted small mb-0 mt-2">Class Teacher</p>
            </div>
            <div class="col-md-4 text-center">
                <div style="height: 80px;"></div>
                <hr style="width: 80%; margin: 0 auto;">
                <p class="text-muted small mb-0 mt-2">Principal / Head</p>
            </div>
            <div class="col-md-4 text-center">
                <div style="height: 80px;"></div>
                <hr style="width: 80%; margin: 0 auto;">
                <p class="text-muted small mb-0 mt-2">Parent / Guardian</p>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .btn, nav, .sidebar, .d-flex > *:not(.card-body) { display: none !important; }
    .card { 
        border: 1px solid #ddd !important; 
        box-shadow: none !important; 
        page-break-inside: avoid;
    }
    body {
        background: white;
    }
    .card-body {
        padding: 20px;
    }
}

@media (prefers-color-scheme: dark) {
    @media print {
        body, .card, .card-body, table {
            background: white !important;
            color: black !important;
        }
        .table { color: black !important; }
        .text-muted { color: #666 !important; }
        .table-light { background-color: #f8f9fa !important; }
        .badge { color: white !important; }
    }
}
</style>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
