<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Student Details</h1>
    <div>
        <a href="/students/<?= $student['id'] ?>/edit" class="btn btn-warning">
            <i class="bi bi-pencil me-2"></i>Edit
        </a>
        <a href="/students" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-body text-center">
                <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px;">
                    <i class="bi bi-person-fill" style="font-size: 3rem;"></i>
                </div>
                <h5><?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?></h5>
                <p class="text-muted mb-1"><?= htmlspecialchars($student['admission_number']) ?></p>
                <span class="badge bg-<?= $student['status'] === 'active' ? 'success' : 'secondary' ?>">
                    <?= ucfirst($student['status']) ?>
                </span>
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
                        <strong>Email:</strong><br>
                        <?= htmlspecialchars($student['email']) ?>
                    </div>
                    <div class="col-md-6">
                        <strong>Phone:</strong><br>
                        <?= htmlspecialchars($student['phone'] ?? 'N/A') ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Gender:</strong><br>
                        <?= htmlspecialchars(ucfirst($student['gender'] ?? 'N/A')) ?>
                    </div>
                    <div class="col-md-6">
                        <strong>Date of Birth:</strong><br>
                        <?= htmlspecialchars($student['date_of_birth'] ?? 'N/A') ?>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Class:</strong><br>
                        <?= htmlspecialchars($student['class_name'] ?? 'N/A') ?>
                    </div>
                    <div class="col-md-6">
                        <strong>Roll Number:</strong><br>
                        <?= htmlspecialchars($student['roll_number'] ?? 'N/A') ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <strong>Address:</strong><br>
                        <?= htmlspecialchars($student['address'] ?? 'N/A') ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Guardian Information</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <strong>Name:</strong><br>
                        <?= htmlspecialchars($student['guardian_name'] ?? 'N/A') ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <strong>Phone:</strong><br>
                        <?= htmlspecialchars($student['guardian_phone'] ?? 'N/A') ?>
                    </div>
                    <div class="col-md-6">
                        <strong>Email:</strong><br>
                        <?= htmlspecialchars($student['guardian_email'] ?? 'N/A') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
