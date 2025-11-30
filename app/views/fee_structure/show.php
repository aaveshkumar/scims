<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Fee Structure Details</h1>
        <p class="text-muted mb-0"><?= htmlspecialchars($feeStructure['name']) ?></p>
    </div>
    <div>
        <a href="/fee-structure/<?= $feeStructure['id'] ?>/edit" class="btn btn-warning me-2">
            <i class="bi bi-pencil me-2"></i>Edit
        </a>
        <a href="/fee-structure" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Fee Information</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="fw-bold text-muted">Fee Structure Name</label>
                        <p><?= htmlspecialchars($feeStructure['name']) ?></p>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold text-muted">Fee Type</label>
                        <p><span class="badge bg-info"><?= ucfirst($feeStructure['fee_type']) ?></span></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="fw-bold text-muted">Amount</label>
                        <p class="h5 text-success">₹<?= number_format($feeStructure['amount'], 2) ?></p>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold text-muted">Status</label>
                        <p>
                            <span class="badge bg-<?= $feeStructure['status'] === 'active' ? 'success' : 'secondary' ?>">
                                <?= ucfirst($feeStructure['status']) ?>
                            </span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Academic Information</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="fw-bold text-muted">Academic Year</label>
                        <p><?= htmlspecialchars($feeStructure['academic_year']) ?></p>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold text-muted">Semester</label>
                        <p><?= $feeStructure['semester'] ? htmlspecialchars($feeStructure['semester']) : 'N/A' ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label class="fw-bold text-muted">Class</label>
                        <p><?= $feeStructure['class_name'] ? htmlspecialchars($feeStructure['class_name']) : 'All Classes' ?></p>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold text-muted">Due Date</label>
                        <p><?= $feeStructure['due_date'] ? date('M d, Y', strtotime($feeStructure['due_date'])) : 'N/A' ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card sticky-top" style="top: 20px;">
            <div class="card-header">
                <h5 class="mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <a href="/fee-structure/<?= $feeStructure['id'] ?>/edit" class="btn btn-warning w-100 mb-2">
                    <i class="bi bi-pencil me-2"></i>Edit This Fee Structure
                </a>
                <a href="/fee-structure" class="btn btn-outline-secondary w-100">
                    <i class="bi bi-list me-2"></i>View All Fee Structures
                </a>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
