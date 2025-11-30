<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Exam Marks</h1>
        <?php if (isset($exam)): ?>
            <p class="text-muted mb-0"><?= htmlspecialchars($exam['name']) ?> - <?= htmlspecialchars($exam['code']) ?></p>
        <?php endif; ?>
    </div>
    <div>
        <button class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#selectStudentModal">
            <i class="bi bi-pencil-square me-2"></i>Enter Marks
        </button>
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

<!-- Select Student Modal -->
<div class="modal fade" id="selectStudentModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Select Student to Enter Marks</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="studentSearch" placeholder="Search student by name or admission number...">
                </div>
                <div class="student-list" style="max-height: 400px; overflow-y: auto;">
                    <?php 
                    // Fetch all active students
                    $students = db()->fetchAll(
                        "SELECT s.id, s.admission_number, u.first_name, u.last_name 
                         FROM students s
                         INNER JOIN users u ON s.user_id = u.id
                         WHERE s.status = 'active'
                         ORDER BY u.first_name, u.last_name"
                    );
                    ?>
                    <?php if (empty($students)): ?>
                        <p class="text-muted">No active students found.</p>
                    <?php else: ?>
                        <div class="list-group">
                            <?php foreach ($students as $student): ?>
                                <a href="/marks/enter?exam_id=<?= $exam['id'] ?>&student_id=<?= $student['id'] ?>" class="list-group-item list-group-item-action student-item">
                                    <div>
                                        <strong><?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?></strong>
                                        <small class="text-muted d-block"><?= htmlspecialchars($student['admission_number']) ?></small>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('studentSearch');
    const studentItems = document.querySelectorAll('.student-item');
    
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const query = this.value.toLowerCase();
            studentItems.forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(query) ? '' : 'none';
            });
        });
    }
});
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
