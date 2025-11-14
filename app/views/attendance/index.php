<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="mb-4">
    <h1 class="h3 mb-0">Attendance Management</h1>
    <p class="text-muted">Mark and view attendance records</p>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Select Class to Mark Attendance</h5>
    </div>
    <div class="card-body">
        <form method="GET" action="/attendance/mark">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Class *</label>
                    <select name="class_id" class="form-select" required>
                        <option value="">Select Class</option>
                        <?php foreach ($classes as $class): ?>
                            <option value="<?= $class['id'] ?>"><?= htmlspecialchars($class['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Date *</label>
                    <input type="date" name="date" class="form-control" value="<?= date('Y-m-d') ?>" required>
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-arrow-right me-2"></i>Next
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
