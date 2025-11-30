<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Add New Holiday</h1>
        <p class="text-muted mb-0">Create a new holiday entry</p>
    </div>
    <a href="/calendar/holidays" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="/calendar/holidays/create" class="needs-validation">
            <input type="hidden" name="_token" value="<?= csrf() ?>">
            
            <!-- Holiday Details -->
            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-calendar-check me-2"></i>Holiday Details
                </h6>
                <div class="mb-3">
                    <label class="form-label fw-bold">Holiday Name *</label>
                    <input type="text" name="name" class="form-control" placeholder="e.g., Diwali, Christmas, New Year" required>
                    <small class="text-muted">Name of the holiday</small>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Description</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Additional details about the holiday"></textarea>
                </div>
            </div>

            <!-- Dates -->
            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-calendar me-2"></i>Duration
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Start Date *</label>
                        <input type="date" name="start_date" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">End Date *</label>
                        <input type="date" name="end_date" class="form-control" required>
                    </div>
                </div>
            </div>

            <!-- Type & Status -->
            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-gear me-2"></i>Settings
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Holiday Type</label>
                        <select name="holiday_type" class="form-select">
                            <option value="holiday">Holiday</option>
                            <option value="festival">Festival</option>
                            <option value="vacation">Vacation</option>
                            <option value="special">Special</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Status</label>
                        <select name="status" class="form-select">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Create Holiday
                </button>
                <a href="/calendar/holidays" class="btn btn-outline-secondary">
                    <i class="bi bi-x-circle me-2"></i>Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
