<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Edit Course</h1>
    <a href="/courses/<?= $course['id'] ?>" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Update Course Information</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="/courses/<?= $course['id'] ?>">
            <input type="hidden" name="_token" value="<?= csrf() ?>">
            <input type="hidden" name="_method" value="PUT">
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Course Name *</label>
                    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($course['name']) ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Course Code *</label>
                    <input type="text" name="code" class="form-control" value="<?= htmlspecialchars($course['code']) ?>" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Duration (Years) *</label>
                <input type="number" name="duration_years" class="form-control" value="<?= $course['duration_years'] ?>" min="1" max="10" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4"><?= htmlspecialchars($course['description'] ?? '') ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="active" <?= $course['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= $course['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Update Course
                </button>
                <a href="/courses/<?= $course['id'] ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
