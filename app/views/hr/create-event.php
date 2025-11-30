<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Create HR Event</h1>
        <p class="text-muted mb-0">Add a new HR event</p>
    </div>
    <a href="/hr/events" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="/hr/events/create">
            <input type="hidden" name="_token" value="<?= csrf() ?>">
            
            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-briefcase me-2"></i>Event Details
                </h6>
                <div class="mb-3">
                    <label class="form-label fw-bold">Title *</label>
                    <input type="text" name="title" class="form-control" placeholder="e.g., Team Building Activity" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Description</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>
            </div>

            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-calendar me-2"></i>Event Information
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Event Date *</label>
                        <input type="date" name="event_date" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Event Type</label>
                        <select name="event_type" class="form-select">
                            <option value="training">Training</option>
                            <option value="meeting">Meeting</option>
                            <option value="workshop">Workshop</option>
                            <option value="social">Social Event</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Location</label>
                    <input type="text" name="location" class="form-control" placeholder="Event location">
                </div>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Create Event
                </button>
                <a href="/hr/events" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
