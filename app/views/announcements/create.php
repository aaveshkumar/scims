<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-plus-circle me-2"></i>Create Announcement</h2>
    <a href="/announcements" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="/announcements">
            <?= csrf_field() ?>
            
            <div class="mb-3">
                <label class="form-label">Title *</label>
                <input type="text" name="title" class="form-control" required placeholder="Enter announcement title">
            </div>

            <div class="mb-3">
                <label class="form-label">Content *</label>
                <textarea name="content" class="form-control" rows="5" required placeholder="Enter announcement content"></textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Target Audience *</label>
                    <select name="target_audience" class="form-select" required>
                        <option value="">Select target audience</option>
                        <option value="all">All</option>
                        <option value="students">Students</option>
                        <option value="staff">Staff</option>
                        <option value="parents">Parents</option>
                        <option value="teachers">Teachers</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Priority *</label>
                    <select name="priority" class="form-select" required>
                        <option value="low">Low</option>
                        <option value="normal" selected>Normal</option>
                        <option value="high">High</option>
                        <option value="urgent">Urgent</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Published Date *</label>
                    <input type="datetime-local" name="published_date" class="form-control" required value="<?= date('Y-m-d\TH:i') ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Expiry Date</label>
                    <input type="datetime-local" name="expiry_date" class="form-control">
                </div>
            </div>

            <div class="mb-3">
                <div class="form-check">
                    <input type="checkbox" name="is_visible" class="form-check-input" id="isVisible" checked>
                    <label class="form-check-label" for="isVisible">
                        Make Announcement Visible
                    </label>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Create
                </button>
                <a href="/announcements" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
