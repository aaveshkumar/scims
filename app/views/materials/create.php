<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Upload Study Material</h1>
    <a href="/materials" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Material Details</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="/materials" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="<?= csrf() ?>">
            
            <div class="mb-3">
                <label class="form-label">Title *</label>
                <input type="text" name="title" class="form-control" placeholder="e.g., Chapter 5 Notes, Assignment 1" required>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Class *</label>
                    <select name="class_id" class="form-select" required>
                        <option value="">Select Class</option>
                        <?php foreach ($classes as $class): ?>
                            <option value="<?= $class['id'] ?>"><?= htmlspecialchars($class['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Subject</label>
                    <select name="subject_id" class="form-select">
                        <option value="">Select Subject (Optional)</option>
                        <?php foreach ($subjects as $subject): ?>
                            <option value="<?= $subject['id'] ?>"><?= htmlspecialchars($subject['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Material Type *</label>
                <select name="type" class="form-select" required>
                    <option value="notes">Lecture Notes</option>
                    <option value="assignment">Assignment</option>
                    <option value="syllabus">Syllabus</option>
                    <option value="reference">Reference Material</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3" placeholder="Brief description of the material"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Upload File *</label>
                <input type="file" name="file" class="form-control" accept=".pdf,.doc,.docx,.ppt,.pptx,.txt,.jpg,.jpeg,.png" required>
                <small class="text-muted">Allowed: PDF, DOC, DOCX, PPT, PPTX, TXT, JPG, PNG (Max: 5MB)</small>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-upload me-2"></i>Upload Material
                </button>
                <a href="/materials" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
