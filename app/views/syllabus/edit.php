<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Edit Syllabus</h1>
        <p class="text-muted mb-0">Update course content and details</p>
    </div>
    <a href="/syllabus" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card">
    <div class="card-header" style="background-color: #000; color: #fff;">
        <h5 class="mb-0">Syllabus Details</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="/syllabus/<?= $syllabus['id'] ?>">
            <input type="hidden" name="_token" value="<?= csrf() ?>">
            
            <div class="mb-4 pb-4 border-bottom">
                <h6 class="mb-3 text-primary">
                    <i class="bi bi-book me-2"></i>Course Information
                </h6>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Subject</label>
                        <select name="subject_id" class="form-select">
                            <option value="">-- Select Subject --</option>
                            <?php foreach ($subjects as $subject): ?>
                                <option value="<?= $subject['id'] ?>" <?= $syllabus['subject_id'] == $subject['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($subject['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Class/Grade</label>
                        <select name="class_id" class="form-select">
                            <option value="">-- Select Class --</option>
                            <?php foreach ($classes as $class): ?>
                                <option value="<?= $class['id'] ?>" <?= $syllabus['class_id'] == $class['id'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($class['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mb-4 pb-4 border-bottom">
                <h6 class="mb-3 text-primary">
                    <i class="bi bi-pencil-square me-2"></i>Syllabus Title & Overview
                </h6>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Syllabus Title *</label>
                    <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($syllabus['title']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Overview / Course Description</label>
                    <textarea name="overview" class="form-control" rows="3"><?= htmlspecialchars($syllabus['overview'] ?? '') ?></textarea>
                </div>
            </div>

            <div class="mb-4 pb-4 border-bottom">
                <h6 class="mb-3 text-primary">
                    <i class="bi bi-target me-2"></i>Learning Objectives
                </h6>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Learning Outcomes</label>
                    <textarea name="learning_outcomes" class="form-control" rows="3"><?= htmlspecialchars($syllabus['learning_outcomes'] ?? '') ?></textarea>
                </div>
            </div>

            <div class="mb-4 pb-4 border-bottom">
                <h6 class="mb-3 text-primary">
                    <i class="bi bi-list-ul me-2"></i>Topics & Content Covered
                </h6>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Topics Covered</label>
                    <textarea name="topics_covered" class="form-control" rows="3"><?= htmlspecialchars($syllabus['topics_covered'] ?? '') ?></textarea>
                </div>
            </div>

            <div class="mb-4 pb-4 border-bottom">
                <h6 class="mb-3 text-primary">
                    <i class="bi bi-file-earmark-check me-2"></i>Assessment & Evaluation
                </h6>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Assessment Methods</label>
                    <textarea name="assessment_methods" class="form-control" rows="3"><?= htmlspecialchars($syllabus['assessment_methods'] ?? '') ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Passing Criteria / Grading Scale</label>
                    <input type="text" name="grading_scale" class="form-control" value="<?= htmlspecialchars($syllabus['grading_scale'] ?? '') ?>">
                </div>
            </div>

            <div class="mb-4 pb-4 border-bottom">
                <h6 class="mb-3 text-primary">
                    <i class="bi bi-book-half me-2"></i>Resources & Materials
                </h6>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Recommended Books & Materials</label>
                    <textarea name="recommended_resources" class="form-control" rows="3"><?= htmlspecialchars($syllabus['recommended_resources'] ?? '') ?></textarea>
                </div>
            </div>

            <div class="row mb-4 pb-4 border-bottom">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Prerequisites</label>
                    <input type="text" name="prerequisites" class="form-control" value="<?= htmlspecialchars($syllabus['prerequisites'] ?? '') ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Course Duration</label>
                    <input type="text" name="duration" class="form-control" value="<?= htmlspecialchars($syllabus['duration'] ?? '') ?>">
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Academic Year</label>
                    <input type="text" name="academic_year" class="form-control" value="<?= htmlspecialchars($syllabus['academic_year'] ?? '') ?>">
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Status</label>
                    <select name="status" class="form-select">
                        <option value="active" <?= $syllabus['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                        <option value="inactive" <?= $syllabus['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                        <option value="draft" <?= $syllabus['status'] === 'draft' ? 'selected' : '' ?>>Draft</option>
                    </select>
                </div>
            </div>

            <div class="d-flex gap-2 pt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Update Syllabus
                </button>
                <a href="/syllabus" class="btn btn-secondary">
                    <i class="bi bi-x-circle me-2"></i>Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
