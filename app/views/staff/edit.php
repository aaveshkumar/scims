<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Edit Staff Member</h1>
    <a href="/staff/<?= $staff['id'] ?>" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Update Staff Information</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="/staff/<?= $staff['id'] ?>">
            <input type="hidden" name="_token" value="<?= csrf() ?>">
            <input type="hidden" name="_method" value="PUT">
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">First Name *</label>
                    <input type="text" name="first_name" class="form-control" value="<?= htmlspecialchars($staff['first_name']) ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Last Name *</label>
                    <input type="text" name="last_name" class="form-control" value="<?= htmlspecialchars($staff['last_name']) ?>" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email *</label>
                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($staff['email']) ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Phone *</label>
                    <input type="tel" name="phone" class="form-control" value="<?= htmlspecialchars($staff['phone']) ?>" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Designation *</label>
                    <input type="text" name="designation" class="form-control" value="<?= htmlspecialchars($staff['designation']) ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Department</label>
                    <select name="department" class="form-select">
                        <option value="">Select Department</option>
                        <?php foreach ($departments as $dept): ?>
                            <option value="<?= htmlspecialchars($dept['name']) ?>" <?= ($staff['department'] ?? '') === $dept['name'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($dept['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <?php if (auth() && auth()->hasRole('admin')): ?>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select">
                        <option value="teacher" <?= ($staff['current_role'] ?? '') === 'teacher' ? 'selected' : '' ?>>Teacher</option>
                        <option value="admin" <?= ($staff['current_role'] ?? '') === 'admin' ? 'selected' : '' ?>>Admin</option>
                        <option value="accountant" <?= ($staff['current_role'] ?? '') === 'accountant' ? 'selected' : '' ?>>Accountant</option>
                        <option value="librarian" <?= ($staff['current_role'] ?? '') === 'librarian' ? 'selected' : '' ?>>Librarian</option>
                    </select>
                </div>
            </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Gender</label>
                    <select name="gender" class="form-select">
                        <option value="">Select Gender</option>
                        <option value="male" <?= $staff['gender'] === 'male' ? 'selected' : '' ?>>Male</option>
                        <option value="female" <?= $staff['gender'] === 'female' ? 'selected' : '' ?>>Female</option>
                        <option value="other" <?= $staff['gender'] === 'other' ? 'selected' : '' ?>>Other</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Date of Birth</label>
                    <input type="date" name="date_of_birth" class="form-control" value="<?= $staff['date_of_birth'] ?? '' ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="active" <?= $staff['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                        <option value="inactive" <?= $staff['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label">Qualification</label>
                    <input type="text" name="qualification" class="form-control" value="<?= htmlspecialchars($staff['qualification'] ?? '') ?>">
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Experience (Years)</label>
                    <input type="number" name="experience_years" class="form-control" value="<?= $staff['experience_years'] ?? '' ?>" min="0" step="0.5">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Salary</label>
                    <input type="number" name="salary" class="form-control" value="<?= $staff['salary'] ?? '' ?>" step="0.01">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Emergency Contact</label>
                    <input type="tel" name="emergency_contact" class="form-control" value="<?= htmlspecialchars($staff['emergency_contact'] ?? '') ?>">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Bank Name</label>
                    <input type="text" name="bank_name" class="form-control" value="<?= htmlspecialchars($staff['bank_name'] ?? '') ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Account Number</label>
                    <input type="text" name="account_number" class="form-control" value="<?= htmlspecialchars($staff['account_number'] ?? '') ?>">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Address</label>
                <textarea name="address" class="form-control" rows="2"><?= htmlspecialchars($staff['address'] ?? '') ?></textarea>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Update Staff Member
                </button>
                <a href="/staff/<?= $staff['id'] ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
