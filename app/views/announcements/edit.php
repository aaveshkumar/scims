<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-pencil me-2"></i>Edit Announcement</h2>
    <a href="/announcements" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="/announcements/<?= $announcement['id'] ?>" data-no-loader>
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="PUT">
            
            <div class="mb-3">
                <label class="form-label">Title *</label>
                <input type="text" name="title" class="form-control" required value="<?= htmlspecialchars($announcement['title']) ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Content *</label>
                <textarea name="content" class="form-control" rows="5" required><?= htmlspecialchars($announcement['content']) ?></textarea>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Target Audience *</label>
                    <select name="target_audience" class="form-select" required>
                        <option value="">Select target audience</option>
                        <option value="all" <?= $announcement['target_audience'] == 'all' ? 'selected' : '' ?>>All</option>
                        <option value="students" <?= $announcement['target_audience'] == 'students' ? 'selected' : '' ?>>Students</option>
                        <option value="staff" <?= $announcement['target_audience'] == 'staff' ? 'selected' : '' ?>>Staff</option>
                        <option value="parents" <?= $announcement['target_audience'] == 'parents' ? 'selected' : '' ?>>Parents</option>
                        <option value="teachers" <?= $announcement['target_audience'] == 'teachers' ? 'selected' : '' ?>>Teachers</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Priority *</label>
                    <select name="priority" class="form-select" required>
                        <option value="low" <?= $announcement['priority'] == 'low' ? 'selected' : '' ?>>Low</option>
                        <option value="normal" <?= $announcement['priority'] == 'normal' ? 'selected' : '' ?>>Normal</option>
                        <option value="high" <?= $announcement['priority'] == 'high' ? 'selected' : '' ?>>High</option>
                        <option value="urgent" <?= $announcement['priority'] == 'urgent' ? 'selected' : '' ?>>Urgent</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Published Date *</label>
                    <input type="datetime-local" name="published_date" class="form-control" required value="<?= date('Y-m-d\TH:i', strtotime($announcement['published_date'])) ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Expiry Date</label>
                    <input type="datetime-local" name="expiry_date" class="form-control" value="<?= $announcement['expiry_date'] ? date('Y-m-d\TH:i', strtotime($announcement['expiry_date'])) : '' ?>">
                </div>
            </div>

            <div class="mb-3">
                <div class="form-check">
                    <input type="checkbox" name="is_visible" class="form-check-input" id="isVisible" <?= $announcement['is_visible'] ? 'checked' : '' ?>>
                    <label class="form-check-label" for="isVisible">
                        Make Announcement Visible
                    </label>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Update
                </button>
                <a href="/announcements" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
