<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="row mb-4">
    <div class="col-md-8">
        <h2><i class="bi bi-eye me-2"></i>View Attendance Record</h2>
    </div>
    <div class="col-md-4 text-end">
        <a href="/reports/attendance" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label text-muted">Student</label>
                <p class="h5"><?= htmlspecialchars(($record['first_name'] ?? 'N/A') . ' ' . ($record['last_name'] ?? '')) ?></p>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label text-muted">Class</label>
                <p class="h5"><?= htmlspecialchars($record['class_name'] ?? 'N/A') ?></p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label text-muted">Date</label>
                <p class="h5"><?= date('M d, Y', strtotime($record['date'])) ?></p>
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label text-muted">Status</label>
                <p class="h5">
                    <?php 
                    $badge = $record['status'] == 'present' ? 'bg-success' : ($record['status'] == 'absent' ? 'bg-danger' : 'bg-warning');
                    ?>
                    <span class="badge <?= $badge ?> fs-6"><?= ucfirst($record['status']) ?></span>
                </p>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label text-muted">Remarks</label>
            <p class="h5"><?= htmlspecialchars($record['remarks'] ?? 'No remarks') ?></p>
        </div>

        <div class="mt-4">
            <a href="/reports/attendance/<?= $record['id'] ?>/edit" class="btn btn-warning">
                <i class="bi bi-pencil me-2"></i>Edit Record
            </a>
            <a href="/reports/attendance" class="btn btn-secondary">Back to List</a>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
