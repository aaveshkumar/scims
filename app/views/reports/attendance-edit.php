<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="row mb-4">
    <div class="col-md-8">
        <h2><i class="bi bi-pencil me-2"></i>Edit Attendance Record</h2>
    </div>
    <div class="col-md-4 text-end">
        <a href="/reports/attendance" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="/reports/attendance/<?= $record['id'] ?>/update">
            <?= csrf_field() ?>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Student</label>
                    <select name="student_id" class="form-select" required>
                        <?php foreach ($students as $student): ?>
                            <option value="<?= $student['id'] ?>" <?= $student['id'] == $record['student_id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Class</label>
                    <select name="class_id" class="form-select" required>
                        <?php foreach ($classes as $class): ?>
                            <option value="<?= $class['id'] ?>" <?= $class['id'] == $record['class_id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($class['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Date</label>
                    <input type="date" name="date" class="form-control" value="<?= $record['date'] ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select" required>
                        <option value="present" <?= $record['status'] == 'present' ? 'selected' : '' ?>>Present</option>
                        <option value="absent" <?= $record['status'] == 'absent' ? 'selected' : '' ?>>Absent</option>
                        <option value="late" <?= $record['status'] == 'late' ? 'selected' : '' ?>>Late</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Remarks</label>
                <textarea name="remarks" class="form-control" rows="3"><?= htmlspecialchars($record['remarks'] ?? '') ?></textarea>
            </div>

            <button type="submit" class="btn btn-success">
                <i class="bi bi-save me-2"></i>Update Record
            </button>
            <a href="/reports/attendance" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
