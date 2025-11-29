<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Edit Class</h1>
    <a href="/classes/<?= $class['id'] ?>" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Update Class Information</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="/classes/<?= $class['id'] ?>">
            <input type="hidden" name="_token" value="<?= csrf() ?>">

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Class Name *</label>
                    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($class['name']) ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Section</label>
                    <input type="text" name="section" class="form-control" value="<?= htmlspecialchars($class['section'] ?? '') ?>">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Course</label>
                    <select name="course_id" class="form-select">
                        <option value="">Select Course (Optional)</option>
                        <?php foreach ($courses as $course): ?>
                            <option value="<?= $course['id'] ?>" <?= $course['id'] == ($class['course_id'] ?? '') ? 'selected' : '' ?>>
                                <?= htmlspecialchars($course['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Academic Year *</label>
                    <input type="text" name="academic_year" class="form-control" value="<?= htmlspecialchars($class['academic_year']) ?>" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Capacity</label>
                    <input type="number" name="capacity" class="form-control" value="<?= $class['capacity'] ?? '' ?>" min="1">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Room Number</label>
                    <input type="text" name="room_number" class="form-control" value="<?= htmlspecialchars($class['room_number'] ?? '') ?>">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($class['description'] ?? '') ?></textarea>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Update Class
                </button>
                <a href="/classes/<?= $class['id'] ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
