<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>My Profile</h2>
        <a href="/profile/edit" class="btn btn-primary">
            <i class="bi bi-pencil me-2"></i>Edit Profile
        </a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Personal Information</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="text-muted">First Name</label>
                            <p class="fw-bold"><?= htmlspecialchars($user['first_name'] ?? 'N/A') ?></p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted">Last Name</label>
                            <p class="fw-bold"><?= htmlspecialchars($user['last_name'] ?? 'N/A') ?></p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="text-muted">Email Address</label>
                            <p class="fw-bold"><?= htmlspecialchars($user['email']) ?></p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted">Phone Number</label>
                            <p class="fw-bold"><?= htmlspecialchars($user['phone'] ?? 'N/A') ?></p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="text-muted">Account Created</label>
                            <p class="fw-bold"><?= date('F d, Y', strtotime($user['created_at'])) ?></p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted">Last Updated</label>
                            <p class="fw-bold"><?= date('F d, Y', strtotime($user['updated_at'])) ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Security Settings</h5>
                </div>
                <div class="card-body">
                    <a href="/profile/change-password" class="btn btn-outline-primary">
                        <i class="bi bi-key me-2"></i>Change Password
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Profile Picture</h5>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto" style="width: 150px; height: 150px;">
                            <i class="bi bi-person-fill" style="font-size: 4rem;"></i>
                        </div>
                    </div>
                    <button class="btn btn-sm btn-outline-primary" disabled>
                        <i class="bi bi-upload me-2"></i>Upload Photo (Coming Soon)
                    </button>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Quick Links</h5>
                </div>
                <div class="card-body">
                    <a href="/profile/documents" class="btn btn-outline-secondary btn-sm w-100 mb-2">
                        <i class="bi bi-file-earmark me-2"></i>My Documents
                    </a>
                    <a href="/notifications" class="btn btn-outline-secondary btn-sm w-100">
                        <i class="bi bi-bell me-2"></i>Notifications
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
