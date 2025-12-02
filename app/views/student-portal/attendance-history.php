<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="mb-4">
    <h2><i class="bi bi-calendar-check me-2"></i>Attendance History</h2>
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Classes</div>
                <div class="h5 mb-0 font-weight-bold"><?= $stats['total'] ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Present</div>
                <div class="h5 mb-0 font-weight-bold"><?= $stats['present'] ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Absent</div>
                <div class="h5 mb-0 font-weight-bold"><?= $stats['absent'] ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Percentage</div>
                <div class="h5 mb-0 font-weight-bold"><?= $percentage ?>%</div>
            </div>
        </div>
    </div>
</div>

<?php if (empty($attendance)): ?>
    <div class="alert alert-info">No attendance records available</div>
<?php else: ?>
    <div class="card">
        <div class="card-header">
            <h6 class="mb-0">Attendance Details</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($attendance as $record): ?>
                            <tr>
                                <td><?= date('M d, Y', strtotime($record['date'])) ?></td>
                                <td>
                                    <?php
                                    if ($record['status'] === 'present') {
                                        echo '<span class="badge bg-success">Present</span>';
                                    } elseif ($record['status'] === 'absent') {
                                        echo '<span class="badge bg-danger">Absent</span>';
                                    } else {
                                        echo '<span class="badge bg-warning">Leave</span>';
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
