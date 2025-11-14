<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Staff Details</h1>
    <div>
        <a href="/staff/<?= $staff['id'] ?>/edit" class="btn btn-warning">
            <i class="bi bi-pencil me-2"></i>Edit
        </a>
        <a href="/staff" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="bi bi-person-circle" style="font-size: 5rem; color: #6c757d;"></i>
                </div>
                <h4><?= htmlspecialchars($staff['first_name'] . ' ' . $staff['last_name']) ?></h4>
                <p class="text-muted mb-2"><?= htmlspecialchars($staff['designation']) ?></p>
                <span class="badge bg-<?= $staff['status'] === 'active' ? 'success' : 'secondary' ?> mb-3">
                    <?= ucfirst($staff['status']) ?>
                </span>
                <hr>
                <p class="mb-1"><strong>Employee ID:</strong></p>
                <p><?= htmlspecialchars($staff['employee_id']) ?></p>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Personal Information</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-1 text-muted">Email</p>
                        <p><?= htmlspecialchars($staff['email']) ?></p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1 text-muted">Phone</p>
                        <p><?= htmlspecialchars($staff['phone']) ?></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-1 text-muted">Gender</p>
                        <p><?= ucfirst($staff['gender'] ?? 'N/A') ?></p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1 text-muted">Date of Birth</p>
                        <p><?= $staff['date_of_birth'] ? date('M d, Y', strtotime($staff['date_of_birth'])) : 'N/A' ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <p class="mb-1 text-muted">Address</p>
                        <p><?= htmlspecialchars($staff['address'] ?? 'N/A') ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Employment Details</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-1 text-muted">Department</p>
                        <p><?= htmlspecialchars($staff['department'] ?? 'N/A') ?></p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1 text-muted">Qualification</p>
                        <p><?= htmlspecialchars($staff['qualification'] ?? 'N/A') ?></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-1 text-muted">Experience</p>
                        <p><?= $staff['experience_years'] ?? 'N/A' ?> years</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1 text-muted">Joining Date</p>
                        <p><?= $staff['joining_date'] ? date('M d, Y', strtotime($staff['joining_date'])) : 'N/A' ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-1 text-muted">Salary</p>
                        <p><?= $staff['salary'] ? '$' . number_format($staff['salary'], 2) : 'N/A' ?></p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1 text-muted">Emergency Contact</p>
                        <p><?= htmlspecialchars($staff['emergency_contact'] ?? 'N/A') ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Banking Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p class="mb-1 text-muted">Bank Name</p>
                        <p><?= htmlspecialchars($staff['bank_name'] ?? 'N/A') ?></p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1 text-muted">Account Number</p>
                        <p><?= htmlspecialchars($staff['account_number'] ?? 'N/A') ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
