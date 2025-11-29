<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Add Subject</h1>
    <a href="/subjects" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Subject Information</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="/subjects">
            <input type="hidden" name="_token" value="<?= csrf() ?>">
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Subject Name *</label>
                    <input type="text" name="name" class="form-control" placeholder="e.g., Mathematics, Physics" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Subject Code *</label>
                    <input type="text" name="code" class="form-control" placeholder="e.g., MATH101" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Course *</label>
                    <select name="course_id" class="form-select" required>
                        <option value="">Select Course</option>
                        <?php if (!empty($courses)): ?>
                            <?php foreach ($courses as $course): ?>
                                <option value="<?= $course['id'] ?>"><?= htmlspecialchars($course['name']) ?></option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="">No courses available</option>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Class</label>
                    <select name="class_id" class="form-select">
                        <option value="">Select Class (Optional)</option>
                        <?php foreach ($classes as $class): ?>
                            <option value="<?= $class['id'] ?>"><?= htmlspecialchars($class['name']) ?></option>
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
                                <option value="<?= $teacher['id'] ?>">
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
                    <input type="number" name="credits" class="form-control" placeholder="e.g., 3" min="0" step="0.5">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Type</label>
                    <select name="type" class="form-select">
                        <option value="theory">Theory</option>
                        <option value="practical">Practical</option>
                        <option value="both">Both</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3" placeholder="Subject description, syllabus overview, etc."></textarea>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Add Subject
                </button>
                <a href="/subjects" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
