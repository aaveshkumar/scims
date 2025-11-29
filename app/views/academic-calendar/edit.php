<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Edit Academic Calendar</h1>
        <p class="text-muted mb-0">Update calendar details</p>
    </div>
    <a href="/academic-calendar" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card">
    <div class="card-header" style="background-color: #000; color: #fff;">
        <h5 class="mb-0">Calendar Details</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="/academic-calendar/<?= $calendar['id'] ?>">
            <input type="hidden" name="_token" value="<?= csrf() ?>">
            
            <!-- Basic Information -->
            <div class="mb-4 pb-4 border-bottom">
                <h6 class="mb-3 text-primary">
                    <i class="bi bi-calendar-event me-2"></i>Basic Information
                </h6>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Academic Year *</label>
                        <input type="text" name="academic_year" class="form-control" value="<?= htmlspecialchars($calendar['academic_year']) ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Session Name</label>
                        <input type="text" name="session_name" class="form-control" value="<?= htmlspecialchars($calendar['session_name'] ?? '') ?>">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Calendar Start Date *</label>
                        <input type="date" name="start_date" class="form-control" value="<?= $calendar['start_date'] ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Calendar End Date *</label>
                        <input type="date" name="end_date" class="form-control" value="<?= $calendar['end_date'] ?>" required>
                    </div>
                </div>
            </div>

            <!-- Session Dates -->
            <div class="mb-4 pb-4 border-bottom">
                <h6 class="mb-3 text-primary">
                    <i class="bi bi-calendar me-2"></i>Session & Teaching Dates
                </h6>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Session Start Date</label>
                        <input type="date" name="session_start" class="form-control" value="<?= $calendar['session_start'] ?? '' ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Session End Date</label>
                        <input type="date" name="session_end" class="form-control" value="<?= $calendar['session_end'] ?? '' ?>">
                    </div>
                </div>
            </div>

            <!-- Exam Dates -->
            <div class="mb-4 pb-4 border-bottom">
                <h6 class="mb-3 text-primary">
                    <i class="bi bi-pencil-square me-2"></i>Exam Schedule
                </h6>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Exam Start Date</label>
                        <input type="date" name="exam_start" class="form-control" value="<?= $calendar['exam_start'] ?? '' ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Exam End Date</label>
                        <input type="date" name="exam_end" class="form-control" value="<?= $calendar['exam_end'] ?? '' ?>">
                    </div>
                </div>
            </div>

            <!-- Admission Dates -->
            <div class="mb-4 pb-4 border-bottom">
                <h6 class="mb-3 text-primary">
                    <i class="bi bi-file-earmark-text me-2"></i>Admission Schedule
                </h6>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Admission Start Date</label>
                        <input type="date" name="admission_start" class="form-control" value="<?= $calendar['admission_start'] ?? '' ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Admission End Date</label>
                        <input type="date" name="admission_end" class="form-control" value="<?= $calendar['admission_end'] ?? '' ?>">
                    </div>
                </div>
            </div>

            <!-- Holidays & Events -->
            <div class="mb-4 pb-4 border-bottom">
                <h6 class="mb-3 text-primary">
                    <i class="bi bi-calendar2-heart me-2"></i>Holidays & Important Events
                </h6>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Holidays</label>
                    <textarea name="holidays" class="form-control" rows="3"><?= htmlspecialchars($calendar['holidays'] ?? '') ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Important Events</label>
                    <textarea name="important_events" class="form-control" rows="3"><?= htmlspecialchars($calendar['important_events'] ?? '') ?></textarea>
                </div>
            </div>

            <!-- Additional Information -->
            <div class="mb-4 pb-4 border-bottom">
                <h6 class="mb-3 text-primary">
                    <i class="bi bi-info-circle me-2"></i>Additional Information
                </h6>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Notes/Remarks</label>
                    <textarea name="notes" class="form-control" rows="3"><?= htmlspecialchars($calendar['notes'] ?? '') ?></textarea>
                </div>
            </div>

            <!-- Status -->
            <div class="mb-4">
                <label class="form-label fw-bold">Status</label>
                <select name="status" class="form-select">
                    <option value="active" <?= $calendar['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="draft" <?= $calendar['status'] === 'draft' ? 'selected' : '' ?>>Draft</option>
                    <option value="completed" <?= $calendar['status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
                </select>
            </div>

            <div class="d-flex gap-2 pt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Update Calendar
                </button>
                <a href="/academic-calendar" class="btn btn-secondary">
                    <i class="bi bi-x-circle me-2"></i>Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
