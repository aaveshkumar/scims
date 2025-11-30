<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Edit Event</h1>
        <p class="text-muted mb-0">Update event details</p>
    </div>
    <a href="/calendar" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="/calendar/<?= $event['id'] ?>/edit" class="needs-validation">
            <input type="hidden" name="_token" value="<?= csrf() ?>">
            
            <!-- Event Details -->
            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-calendar-event me-2"></i>Event Details
                </h6>
                <div class="mb-3">
                    <label class="form-label fw-bold">Title *</label>
                    <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($event['title']) ?>" required>
                    <small class="text-muted">Clear event title</small>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Description</label>
                    <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($event['description'] ?? '') ?></textarea>
                </div>
            </div>

            <!-- Date & Time -->
            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-clock me-2"></i>Date & Time
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Event Date *</label>
                        <input type="date" name="event_date" class="form-control" value="<?= $event['event_date'] ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Event Type</label>
                        <select name="event_type" class="form-select">
                            <option value="event" <?= $event['event_type'] === 'event' ? 'selected' : '' ?>>Event</option>
                            <option value="holiday" <?= $event['event_type'] === 'holiday' ? 'selected' : '' ?>>Holiday</option>
                            <option value="exam" <?= $event['event_type'] === 'exam' ? 'selected' : '' ?>>Exam</option>
                            <option value="meeting" <?= $event['event_type'] === 'meeting' ? 'selected' : '' ?>>Meeting</option>
                            <option value="deadline" <?= $event['event_type'] === 'deadline' ? 'selected' : '' ?>>Deadline</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Start Time</label>
                        <input type="time" name="start_time" class="form-control" value="<?= $event['start_time'] ?? '' ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">End Time</label>
                        <input type="time" name="end_time" class="form-control" value="<?= $event['end_time'] ?? '' ?>">
                    </div>
                </div>
            </div>

            <!-- Location -->
            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-geo-alt me-2"></i>Location
                </h6>
                <div class="mb-3">
                    <label class="form-label fw-bold">Location</label>
                    <input type="text" name="location" class="form-control" value="<?= htmlspecialchars($event['location'] ?? '') ?>">
                </div>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Update Event
                </button>
                <a href="/calendar" class="btn btn-outline-secondary">
                    <i class="bi bi-x-circle me-2"></i>Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
