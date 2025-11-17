<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Report Cards</h1>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Student Report Cards</h5>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label">Select Class</label>
                <select class="form-select">
                    <option value="">Choose class...</option>
                    <option>Class 10-A</option>
                    <option>Class 10-B</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Select Exam</label>
                <select class="form-select">
                    <option value="">Choose exam...</option>
                    <option>Mid Term 2025</option>
                    <option>Final Term 2025</option>
                </select>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button class="btn btn-primary">
                    <i class="bi bi-search me-2"></i>Generate Report Cards
                </button>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Roll No</th>
                        <th>Student Name</th>
                        <th>Class</th>
                        <th>Percentage</th>
                        <th>Grade</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="bi bi-file-text fs-1 d-block mb-2"></i>
                            Select class and exam to generate report cards.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
