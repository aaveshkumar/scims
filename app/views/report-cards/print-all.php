<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Print All Report Cards</h1>
        <p class="text-muted mb-0"><?= htmlspecialchars($class['name']) ?> - <?= htmlspecialchars($exam['name']) ?></p>
    </div>
    <div>
        <button onclick="window.print()" class="btn btn-primary me-2">
            <i class="bi bi-printer me-2"></i>Print
        </button>
        <a href="/report-cards?class_id=<?= $class['id'] ?>&exam_id=<?= $exam['id'] ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>
</div>

<!-- Print All Cards -->
<div id="printContainer">
    <?php foreach ($students as $index => $student): 
        $marks = $marksByStudent[$student['student_id']] ?? [];
        $total = 0;
        $obtained = 0;
        
        foreach ($marks as $mark) {
            $total += $mark['total_marks'];
            $obtained += $mark['marks_obtained'];
        }
        
        $percentage = $total > 0 ? round(($obtained / $total) * 100, 2) : 0;
    ?>
        <div class="card mb-4 report-card-item" style="page-break-after: always;">
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
                            <p class="mb-0"><strong><?= htmlspecialchars($student['class_name']) ?></strong></p>
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
                    <table class="table table-bordered" style="font-size: 0.9rem;">
                        <thead class="table-light">
                            <tr>
                                <th>Subject</th>
                                <th class="text-center" style="width: 80px;">Total</th>
                                <th class="text-center" style="width: 80px;">Obtained</th>
                                <th class="text-center" style="width: 80px;">%</th>
                                <th class="text-center" style="width: 60px;">Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($marks)): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-3 text-muted">No marks available</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($marks as $mark): 
                                    $markPercentage = ($mark['total_marks'] > 0) ? round(($mark['marks_obtained'] / $mark['total_marks']) * 100, 1) : 0;
                                ?>
                                    <tr>
                                        <td><?= htmlspecialchars($mark['subject_name']) ?></td>
                                        <td class="text-center"><?= (int)$mark['total_marks'] ?></td>
                                        <td class="text-center"><strong><?= (int)$mark['marks_obtained'] ?></strong></td>
                                        <td class="text-center"><strong><?= $markPercentage ?>%</strong></td>
                                        <td class="text-center">
                                            <span class="badge bg-<?= match($mark['grade']) {
                                                'A+', 'A' => 'success',
                                                'B+', 'B' => 'primary',
                                                'C' => 'info',
                                                'D' => 'warning',
                                                default => 'danger'
                                            } ?>">
                                                <?= htmlspecialchars($mark['grade']) ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                        <tfoot class="table-light">
                            <tr class="fw-bold">
                                <td>TOTAL</td>
                                <td class="text-center"><?= (int)$total ?></td>
                                <td class="text-center"><?= (int)$obtained ?></td>
                                <td class="text-center" colspan="2"><?= $percentage ?>%</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Summary -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card bg-light border-0">
                            <div class="card-body text-center p-2">
                                <p class="text-muted small mb-1">PERCENTAGE</p>
                                <h5 class="mb-0"><?= $percentage ?>%</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-light border-0">
                            <div class="card-body text-center p-2">
                                <p class="text-muted small mb-1">GRADE</p>
                                <h5 class="mb-0">
                                    <span class="badge bg-<?= $percentage >= 90 ? 'success' : ($percentage >= 75 ? 'primary' : ($percentage >= 60 ? 'info' : ($percentage >= 40 ? 'warning' : 'danger'))) ?>">
                                        <?= $percentage >= 90 ? 'A+' : ($percentage >= 80 ? 'A' : ($percentage >= 70 ? 'B+' : ($percentage >= 60 ? 'B' : ($percentage >= 50 ? 'C' : ($percentage >= 40 ? 'D' : 'F'))))) ?>
                                    </span>
                                </h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-light border-0">
                            <div class="card-body text-center p-2">
                                <p class="text-muted small mb-1">RESULT</p>
                                <h5 class="mb-0">
                                    <span class="badge bg-<?= $percentage >= 40 ? 'success' : 'danger' ?>">
                                        <?= $percentage >= 40 ? 'PASS' : 'FAIL' ?>
                                    </span>
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Signatures -->
                <div class="row mt-5 pt-4 border-top" style="font-size: 0.85rem;">
                    <div class="col-md-4 text-center">
                        <div style="height: 50px;"></div>
                        <hr style="width: 80%; margin: 0 auto;">
                        <p class="text-muted small mb-0 mt-1">Class Teacher</p>
                    </div>
                    <div class="col-md-4 text-center">
                        <div style="height: 50px;"></div>
                        <hr style="width: 80%; margin: 0 auto;">
                        <p class="text-muted small mb-0 mt-1">Principal / Head</p>
                    </div>
                    <div class="col-md-4 text-center">
                        <div style="height: 50px;"></div>
                        <hr style="width: 80%; margin: 0 auto;">
                        <p class="text-muted small mb-0 mt-1">Parent / Guardian</p>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<style>
@media print {
    body, .card, .card-body, table {
        background: white !important;
        color: black !important;
    }
    .btn, nav, .sidebar { display: none !important; }
    .card {
        border: 1px solid #ddd !important;
        box-shadow: none !important;
        page-break-inside: avoid;
        page-break-after: always;
    }
    .report-card-item {
        page-break-inside: avoid;
        page-break-after: always;
    }
    .text-muted { color: #666 !important; }
    .table-light { background-color: #f8f9fa !important; }
    .badge { color: white !important; }
    .d-flex > div:not(.card-body) { display: none !important; }
}

@media (prefers-color-scheme: dark) {
    @media print {
        body, .card, .card-body, table, .report-card-item {
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
