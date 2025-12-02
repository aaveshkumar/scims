<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="mb-4">
    <h2><i class="bi bi-speedometer2 me-2"></i>My Dashboard</h2>
    <p class="text-muted">Welcome, <?= htmlspecialchars($student['first_name']) ?></p>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Attendance</div>
                <div class="h5 mb-0 font-weight-bold"><?= $attendance['total'] > 0 ? round(($attendance['present'] / $attendance['total']) * 100, 1) : 0 ?>%</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Admission Number</div>
                <div class="h5 mb-0 font-weight-bold"><?= htmlspecialchars($student['admission_number']) ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Class</div>
                <div class="h5 mb-0 font-weight-bold"><?= htmlspecialchars($student['class_name'] ?? 'N/A') ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Recent Marks</div>
                <div class="h5 mb-0 font-weight-bold"><?= count($marks) ?> exams</div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Recent Marks</h6>
            </div>
            <div class="card-body">
                <?php if (empty($marks)): ?>
                    <p class="text-muted mb-0">No marks available yet</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Exam</th>
                                    <th>Subject</th>
                                    <th>Marks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($marks as $mark): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($mark['exam_name']) ?></td>
                                        <td><?= htmlspecialchars($mark['subject_name']) ?></td>
                                        <td><strong><?= $mark['marks'] ?></strong></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Upcoming Assignments</h6>
            </div>
            <div class="card-body">
                <?php if (empty($assignments)): ?>
                    <p class="text-muted mb-0">No upcoming assignments</p>
                <?php else: ?>
                    <div class="list-group">
                        <?php foreach ($assignments as $assignment): ?>
                            <a href="/assignments/<?= $assignment['id'] ?>" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1"><?= htmlspecialchars($assignment['title']) ?></h6>
                                    <small class="text-muted"><?= date('M d', strtotime($assignment['due_date'])) ?></small>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
