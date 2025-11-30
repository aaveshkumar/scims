<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Create Exam</h1>
    <a href="/exams" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Exam Details</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="/exams">
            <input type="hidden" name="_token" value="<?= csrf() ?>">
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Exam Name *</label>
                    <input type="text" name="name" class="form-control" placeholder="e.g., Mid Term Examination" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Exam Code *</label>
                    <input type="text" name="code" class="form-control" placeholder="e.g., MID-2024" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Exam Type *</label>
                    <select name="exam_type" class="form-select" required>
                        <option value="">Select Type</option>
                        <option value="midterm">Mid Term</option>
                        <option value="final">Final</option>
                        <option value="quiz">Quiz</option>
                        <option value="assignment">Assignment</option>
                        <option value="practical">Practical</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Class (Optional)</label>
                    <select name="class_id" class="form-select">
                        <option value="">All Classes</option>
                        <?php foreach ($classes as $class): ?>
                            <option value="<?= $class['id'] ?>"><?= htmlspecialchars($class['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Academic Year *</label>
                    <input type="text" name="academic_year" class="form-control" value="<?= date('Y') ?>" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Start Date *</label>
                    <input type="date" name="start_date" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">End Date *</label>
                    <input type="date" name="end_date" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Semester</label>
                    <select name="semester" class="form-select">
                        <option value="">Select Semester</option>
                        <option value="1">Semester 1</option>
                        <option value="2">Semester 2</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Total Marks *</label>
                    <input type="number" name="total_marks" class="form-control" value="100" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Passing Marks *</label>
                    <input type="number" name="passing_marks" class="form-control" value="40" required>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Create Exam
                </button>
                <a href="/exams" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
