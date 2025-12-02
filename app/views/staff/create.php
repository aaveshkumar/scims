<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Add Staff Member</h1>
    <a href="/staff" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Staff Information</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="/staff">
            <input type="hidden" name="_token" value="<?= csrf() ?>">
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">First Name *</label>
                    <input type="text" name="first_name" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Last Name *</label>
                    <input type="text" name="last_name" class="form-control" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email *</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Phone *</label>
                    <input type="tel" name="phone" class="form-control" required>
                </div>
            </div>

            <div class="row">
                <div class="col-12 mb-3">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Automatic Password Generation:</strong> A temporary password will be automatically generated and sent to the staff member's email. The password expires in 7 days.
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Employee ID *</label>
                    <input type="text" name="employee_id" class="form-control" value="EMP<?= date('Y') . rand(1000, 9999) ?>" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Designation *</label>
                    <input type="text" name="designation" class="form-control" placeholder="e.g., Teacher, Principal" required>
                </div>
                <?php if (hasRole('admin')): ?>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Role *</label>
                    <select name="role" class="form-select" required>
                        <?php foreach ($allRoles as $role): ?>
                            <option value="<?= htmlspecialchars($role['name']) ?>">
                                <?= htmlspecialchars(ucfirst($role['name'])) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php else: ?>
                <input type="hidden" name="role" value="teacher">
                <?php endif; ?>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Department</label>
                    <select name="department" class="form-select">
                        <option value="">Select Department</option>
                        <?php foreach ($departments as $dept): ?>
                            <option value="<?= htmlspecialchars($dept['name']) ?>">
                                <?= htmlspecialchars($dept['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Joining Date *</label>
                    <input type="date" name="joining_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Gender</label>
                    <select name="gender" class="form-select">
                        <option value="">Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Date of Birth</label>
                    <input type="date" name="date_of_birth" class="form-control">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Qualification</label>
                    <input type="text" name="qualification" class="form-control" placeholder="e.g., M.Sc., B.Ed.">
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Experience (Years)</label>
                    <input type="number" name="experience_years" class="form-control" min="0" step="0.5">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Salary</label>
                    <input type="number" name="salary" class="form-control" step="0.01">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Emergency Contact</label>
                    <input type="tel" name="emergency_contact" class="form-control">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Bank Name</label>
                    <input type="text" name="bank_name" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Account Number</label>
                    <input type="text" name="account_number" class="form-control">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Address</label>
                <textarea name="address" class="form-control" rows="2"></textarea>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Add Staff Member
                </button>
                <a href="/staff" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
