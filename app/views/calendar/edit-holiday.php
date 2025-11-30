<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Edit Holiday</h1>
        <p class="text-muted mb-0">Update holiday details</p>
    </div>
    <a href="/calendar/holidays" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="/calendar/holidays/<?= $holiday['id'] ?>/edit" class="needs-validation">
            <input type="hidden" name="_token" value="<?= csrf() ?>">
            
            <!-- Holiday Details -->
            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-calendar-check me-2"></i>Holiday Details
                </h6>
                <div class="mb-3">
                    <label class="form-label fw-bold">Holiday Name *</label>
                    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($holiday['name']) ?>" required>
                    <small class="text-muted">Name of the holiday</small>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold">Description</label>
                    <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($holiday['description'] ?? '') ?></textarea>
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
                        <input type="date" name="start_date" class="form-control" value="<?= $holiday['start_date'] ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">End Date *</label>
                        <input type="date" name="end_date" class="form-control" value="<?= $holiday['end_date'] ?>" required>
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
                            <option value="holiday" <?= $holiday['holiday_type'] === 'holiday' ? 'selected' : '' ?>>Holiday</option>
                            <option value="festival" <?= $holiday['holiday_type'] === 'festival' ? 'selected' : '' ?>>Festival</option>
                            <option value="vacation" <?= $holiday['holiday_type'] === 'vacation' ? 'selected' : '' ?>>Vacation</option>
                            <option value="special" <?= $holiday['holiday_type'] === 'special' ? 'selected' : '' ?>>Special</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Status</label>
                        <select name="status" class="form-select">
                            <option value="active" <?= $holiday['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                            <option value="inactive" <?= $holiday['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Update Holiday
                </button>
                <a href="/calendar/holidays" class="btn btn-outline-secondary">
                    <i class="bi bi-x-circle me-2"></i>Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
