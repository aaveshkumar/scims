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
        <h5 class="mb-0">Student Marks Status</h5>
        <small class="text-muted d-block mt-1">View and manage marks for all students</small>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Admission #</th>
                        <th>Student Name</th>
                        <th>Class</th>
                        <th>Subjects</th>
                        <th>Avg %</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($students)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No active students found</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($students as $student): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($student['admission_number']) ?></strong></td>
                                <td><?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?></td>
                                <td><?= htmlspecialchars($student['class_name'] ?? 'N/A') ?></td>
                                <td>
                                    <span class="badge bg-<?= ($student['marks_count'] > 0) ? 'success' : 'secondary' ?>">
                                        <?= (int)$student['marks_count'] ?> subject(s)
                                    </span>
                                </td>
                                <td>
                                    <?php if ($student['marks_count'] > 0): ?>
                                        <strong><?= htmlspecialchars($student['avg_percentage'] ?? '0') ?>%</strong>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($student['marks_count'] > 0): ?>
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle me-1"></i>Completed
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-warning">
                                            <i class="bi bi-clock me-1"></i>Pending
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="/marks/enter?exam_id=<?= $exam['id'] ?>&student_id=<?= $student['id'] ?>" class="btn btn-sm btn-primary">
                                        <i class="bi bi-pencil-square me-1"></i><?= ($student['marks_count'] > 0) ? 'Edit' : 'Enter' ?>
                                    </a>
                                    <?php if ($student['marks_count'] > 0): ?>
                                        <a href="/marks/report-card/<?= $student['id'] ?>/<?= $exam['id'] ?>" class="btn btn-sm btn-info">
                                            <i class="bi bi-file-earmark-text me-1"></i>Report
                                        </a>
                                    <?php endif; ?>
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
