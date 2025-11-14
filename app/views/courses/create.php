<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Add Course</h1>
    <a href="/courses" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Course Information</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="/courses">
            <input type="hidden" name="_token" value="<?= csrf() ?>">
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Course Name *</label>
                    <input type="text" name="name" class="form-control" placeholder="e.g., Bachelor of Science" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Course Code *</label>
                    <input type="text" name="code" class="form-control" placeholder="e.g., BSC" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Duration (Years) *</label>
                <input type="number" name="duration_years" class="form-control" min="1" max="10" value="3" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Create Course
                </button>
                <a href="/courses" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
