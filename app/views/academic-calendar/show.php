<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0"><?= htmlspecialchars($calendar['academic_year']) ?></h1>
        <p class="text-muted mb-0">Calendar Details</p>
    </div>
    <div>
        <a href="/academic-calendar/<?= $calendar['id'] ?>/edit" class="btn btn-warning me-2">
            <i class="bi bi-pencil me-2"></i>Edit
        </a>
        <a href="/academic-calendar" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header" style="background-color: #000; color: #fff;">
                <h5 class="mb-0">Calendar Information</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6 class="text-muted">Calendar Period</h6>
                        <p><?= $calendar['start_date'] ? date('d M Y', strtotime($calendar['start_date'])) : 'N/A' ?> - <?= $calendar['end_date'] ? date('d M Y', strtotime($calendar['end_date'])) : 'N/A' ?></p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">Session</h6>
                        <p><?= htmlspecialchars($calendar['session_name'] ?? 'N/A') ?></p>
                    </div>
                </div>

                <?php if ($calendar['session_start']): ?>
                <div class="mb-3">
                    <h6 class="fw-bold">Teaching Period</h6>
                    <p><?= date('d M Y', strtotime($calendar['session_start'])) ?> - <?= $calendar['session_end'] ? date('d M Y', strtotime($calendar['session_end'])) : 'N/A' ?></p>
                </div>
                <?php endif; ?>

                <?php if ($calendar['exam_start']): ?>
                <div class="mb-3">
                    <h6 class="fw-bold">Exam Schedule</h6>
                    <p><?= date('d M Y', strtotime($calendar['exam_start'])) ?> - <?= $calendar['exam_end'] ? date('d M Y', strtotime($calendar['exam_end'])) : 'N/A' ?></p>
                </div>
                <?php endif; ?>

                <?php if ($calendar['admission_start']): ?>
                <div class="mb-3">
                    <h6 class="fw-bold">Admission Period</h6>
                    <p><?= date('d M Y', strtotime($calendar['admission_start'])) ?> - <?= $calendar['admission_end'] ? date('d M Y', strtotime($calendar['admission_end'])) : 'N/A' ?></p>
                </div>
                <?php endif; ?>

                <?php if ($calendar['holidays']): ?>
                <div class="mb-3">
                    <h6 class="fw-bold">Holidays</h6>
                    <p><?= nl2br(htmlspecialchars($calendar['holidays'])) ?></p>
                </div>
                <?php endif; ?>

                <?php if ($calendar['important_events']): ?>
                <div class="mb-3">
                    <h6 class="fw-bold">Important Events</h6>
                    <p><?= nl2br(htmlspecialchars($calendar['important_events'])) ?></p>
                </div>
                <?php endif; ?>

                <?php if ($calendar['notes']): ?>
                <div class="mb-3">
                    <h6 class="fw-bold">Notes</h6>
                    <p><?= nl2br(htmlspecialchars($calendar['notes'])) ?></p>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header" style="background-color: #000; color: #fff;">
                <h5 class="mb-0">Status</h5>
            </div>
            <div class="card-body">
                <span class="badge bg-<?= $calendar['status'] === 'active' ? 'success' : 'info' ?> fs-6">
                    <?= ucfirst($calendar['status']) ?>
                </span>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
