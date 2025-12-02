<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="mb-4">
    <h2><i class="bi bi-graph-up me-2"></i>My Marks & Grades</h2>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="/student-portal/marks">
            <div class="row">
                <div class="col-md-8">
                    <label>Select Exam</label>
                    <select name="exam_id" class="form-select" onchange="this.form.submit()">
                        <?php foreach ($exams as $exam): ?>
                            <option value="<?= $exam['id'] ?>" <?= $exam['id'] == $selectedExamId ? 'selected' : '' ?>>
                                <?= htmlspecialchars($exam['name']) ?> (<?= date('M Y', strtotime($exam['date'])) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </form>
    </div>
</div>

<?php if (empty($marks)): ?>
    <div class="alert alert-info">No marks available for this exam</div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>Subject</th>
                    <th class="text-center">Marks</th>
                    <th class="text-center">Grade</th>
                </tr>
            </thead>
            <tbody>
                <?php $totalMarks = 0; $count = 0; ?>
                <?php foreach ($marks as $mark): ?>
                    <?php $totalMarks += $mark['marks']; $count++; ?>
                    <tr>
                        <td><?= htmlspecialchars($mark['subject_name']) ?></td>
                        <td class="text-center"><strong><?= $mark['marks'] ?></strong></td>
                        <td class="text-center">
                            <?php
                            $percent = ($mark['marks'] / 100) * 100;
                            if ($percent >= 90) echo '<span class="badge bg-success">A+</span>';
                            elseif ($percent >= 80) echo '<span class="badge bg-success">A</span>';
                            elseif ($percent >= 70) echo '<span class="badge bg-info">B</span>';
                            elseif ($percent >= 60) echo '<span class="badge bg-warning">C</span>';
                            else echo '<span class="badge bg-danger">F</span>';
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr class="table-light">
                    <th>Average</th>
                    <th class="text-center"><strong><?= round($totalMarks / $count, 2) ?></strong></th>
                    <th></th>
                </tr>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
