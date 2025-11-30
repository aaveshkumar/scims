<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Edit Fee Structure</h1>
        <p class="text-muted mb-0">Update fee structure details</p>
    </div>
    <a href="/fee-structure" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Fee Structure Details</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="/fee-structure/<?= $feeStructure['id'] ?>" class="needs-validation">
            <input type="hidden" name="_token" value="<?= csrf() ?>">
            
            <!-- Basic Information -->
            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-info-circle me-2"></i>Basic Information
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Fee Structure Name *</label>
                        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($feeStructure['name']) ?>" required>
                        <small class="text-muted">Unique name to identify this fee structure</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Fee Type *</label>
                        <select name="fee_type" class="form-select" required>
                            <option value="">-- Select Fee Type --</option>
                            <option value="tuition" <?= $feeStructure['fee_type'] === 'tuition' ? 'selected' : '' ?>>Tuition</option>
                            <option value="exam" <?= $feeStructure['fee_type'] === 'exam' ? 'selected' : '' ?>>Exam</option>
                            <option value="library" <?= $feeStructure['fee_type'] === 'library' ? 'selected' : '' ?>>Library</option>
                            <option value="lab" <?= $feeStructure['fee_type'] === 'lab' ? 'selected' : '' ?>>Lab</option>
                            <option value="transport" <?= $feeStructure['fee_type'] === 'transport' ? 'selected' : '' ?>>Transport</option>
                            <option value="hostel" <?= $feeStructure['fee_type'] === 'hostel' ? 'selected' : '' ?>>Hostel</option>
                            <option value="other" <?= $feeStructure['fee_type'] === 'other' ? 'selected' : '' ?>>Other</option>
                        </select>
                        <small class="text-muted">Category of this fee</small>
                    </div>
                </div>
            </div>

            <!-- Class & Academic Information -->
            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-book me-2"></i>Academic Information
                </h6>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Class (Optional)</label>
                        <select name="class_id" class="form-select">
                            <option value="">-- Not Applicable --</option>
                            <?php if (!empty($classes)): ?>
                                <?php foreach ($classes as $class): ?>
                                    <option value="<?= $class['id'] ?>" <?= $feeStructure['class_id'] == $class['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($class['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <small class="text-muted">Select if applicable to a specific class</small>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Academic Year *</label>
                        <input type="text" name="academic_year" class="form-control" value="<?= htmlspecialchars($feeStructure['academic_year']) ?>" placeholder="e.g., 2024-2025" required>
                        <small class="text-muted">Format: YYYY-YYYY</small>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Semester (Optional)</label>
                        <select name="semester" class="form-select">
                            <option value="">-- Not Applicable --</option>
                            <option value="1st" <?= $feeStructure['semester'] === '1st' ? 'selected' : '' ?>>1st Semester</option>
                            <option value="2nd" <?= $feeStructure['semester'] === '2nd' ? 'selected' : '' ?>>2nd Semester</option>
                            <option value="annual" <?= $feeStructure['semester'] === 'annual' ? 'selected' : '' ?>>Annual</option>
                        </select>
                        <small class="text-muted">If applicable</small>
                    </div>
                </div>
            </div>

            <!-- Financial Information -->
            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-currency-rupee me-2"></i>Financial Information
                </h6>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Amount *</label>
                        <div class="input-group">
                            <span class="input-group-text">₹</span>
                            <input type="number" name="amount" class="form-control" step="0.01" min="0" value="<?= $feeStructure['amount'] ?>" required>
                        </div>
                        <small class="text-muted">Fee amount in rupees</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Due Date (Optional)</label>
                        <input type="date" name="due_date" class="form-control" value="<?= $feeStructure['due_date'] ?? '' ?>">
                        <small class="text-muted">Payment deadline for this fee</small>
                    </div>
                </div>
            </div>

            <!-- Status -->
            <div class="mb-4">
                <h6 class="text-uppercase text-muted mb-3">
                    <i class="bi bi-toggles me-2"></i>Status
                </h6>
                <select name="status" class="form-select" required>
                    <option value="active" <?= $feeStructure['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= $feeStructure['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                </select>
                <small class="text-muted">Active fee structures are available for use</small>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex gap-2 mt-5">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Update Fee Structure
                </button>
                <a href="/fee-structure/<?= $feeStructure['id'] ?>" class="btn btn-outline-secondary">
                    <i class="bi bi-x-circle me-2"></i>Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<style>
[data-bs-theme="dark"] .text-muted {
    color: #a8b1bd !important;
}

[data-bs-theme="dark"] .form-label {
    color: #e9ecef;
}

[data-bs-theme="dark"] .form-control,
[data-bs-theme="dark"] .form-select {
    background-color: #2d3238;
    color: #e9ecef;
    border-color: #495057;
}

[data-bs-theme="dark"] .form-control:focus,
[data-bs-theme="dark"] .form-select:focus {
    background-color: #2d3238;
    color: #e9ecef;
    border-color: #5a8dee;
    box-shadow: 0 0 0 0.25rem rgba(90, 141, 238, 0.25);
}

[data-bs-theme="dark"] .input-group-text {
    background-color: #3a3f47;
    color: #e9ecef;
    border-color: #495057;
}
</style>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
