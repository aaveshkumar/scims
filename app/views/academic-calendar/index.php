<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Academic Calendar</h1>
        <p class="text-muted mb-0">Manage academic years and important dates</p>
    </div>
    <a href="/academic-calendar/create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Create Calendar
    </a>
</div>

<div class="card">
    <div class="card-header" style="background-color: #000; color: #fff;">
        <h5 class="mb-0">All Academic Years</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Academic Year</th>
                        <th>Session</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Exams</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($calendars && count($calendars) > 0): ?>
                        <?php foreach ($calendars as $cal): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($cal['academic_year']) ?></strong></td>
                                <td><?= htmlspecialchars($cal['session_name'] ?? '-') ?></td>
                                <td><?= $cal['start_date'] ? date('d M Y', strtotime($cal['start_date'])) : 'N/A' ?></td>
                                <td><?= $cal['end_date'] ? date('d M Y', strtotime($cal['end_date'])) : 'N/A' ?></td>
                                <td>
                                    <?php if ($cal['exam_start'] && $cal['exam_end']): ?>
                                        <?= date('d M', strtotime($cal['exam_start'])) ?> - <?= date('d M', strtotime($cal['exam_end'])) ?>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge bg-<?= $cal['status'] === 'active' ? 'success' : ($cal['status'] === 'completed' ? 'info' : 'warning') ?>">
                                        <?= ucfirst($cal['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="/academic-calendar/<?= $cal['id'] ?>" class="btn btn-sm btn-info" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="/academic-calendar/<?= $cal['id'] ?>/edit" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" action="/academic-calendar/<?= $cal['id'] ?>" style="display:inline;">
                                        <input type="hidden" name="_token" value="<?= csrf() ?>">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button type="submit" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Delete this calendar?');">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                No academic calendars available. Click "Create Calendar" to add one.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
