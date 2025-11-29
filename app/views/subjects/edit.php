<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Edit Subject</h1>
    <a href="/subjects/<?= $subject['id'] ?>" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Update Subject Information</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="/subjects/<?= $subject['id'] ?>">
            <input type="hidden" name="_token" value="<?= csrf() ?>">
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Subject Name *</label>
                    <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($subject['name']) ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Subject Code *</label>
                    <input type="text" name="code" class="form-control" value="<?= htmlspecialchars($subject['code']) ?>" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Course *</label>
                    <select name="course_id" class="form-select" required>
                        <option value="">Select Course</option>
                        <?php foreach ($courses as $course): ?>
                            <option value="<?= $course['id'] ?>" <?= $course['id'] == ($subject['course_id'] ?? '') ? 'selected' : '' ?>>
                                <?= htmlspecialchars($course['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Class</label>
                    <select name="class_id" class="form-select">
                        <option value="">Select Class</option>
                        <?php foreach ($classes as $class): ?>
                            <option value="<?= $class['id'] ?>" <?= $class['id'] == ($subject['class_id'] ?? '') ? 'selected' : '' ?>>
                                <?= htmlspecialchars($class['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Teacher</label>
                    <select name="teacher_id" class="form-select">
                        <option value="">Select Teacher (Optional)</option>
                        <?php if (!empty($teachers)): ?>
                            <?php foreach ($teachers as $teacher): ?>
                                <option value="<?= $teacher['id'] ?>" <?= $teacher['id'] == ($subject['teacher_id'] ?? '') ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($teacher['first_name'] . ' ' . $teacher['last_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="">No teachers available</option>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Credits</label>
                    <input type="number" name="credits" class="form-control" value="<?= $subject['credits'] ?? '' ?>" min="0" step="0.5">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Type</label>
                    <select name="type" class="form-select">
                        <option value="theory" <?= ($subject['type'] ?? 'theory') === 'theory' ? 'selected' : '' ?>>Theory</option>
                        <option value="practical" <?= ($subject['type'] ?? '') === 'practical' ? 'selected' : '' ?>>Practical</option>
                        <option value="both" <?= ($subject['type'] ?? '') === 'both' ? 'selected' : '' ?>>Both</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="active" <?= ($subject['status'] ?? 'active') === 'active' ? 'selected' : '' ?>>Active</option>
                        <option value="inactive" <?= ($subject['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($subject['description'] ?? '') ?></textarea>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Update Subject
                </button>
                <a href="/subjects/<?= $subject['id'] ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
