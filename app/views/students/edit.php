<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Edit Student</h1>
    <a href="/students/<?= $student['id'] ?>" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Update Student Information</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="/students/<?= $student['id'] ?>">
            <input type="hidden" name="_token" value="<?= csrf() ?>">

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">First Name *</label>
                    <input type="text" name="first_name" class="form-control" value="<?= htmlspecialchars($student['first_name']) ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Last Name *</label>
                    <input type="text" name="last_name" class="form-control" value="<?= htmlspecialchars($student['last_name']) ?>" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email *</label>
                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($student['email']) ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Phone *</label>
                    <input type="tel" name="phone" class="form-control" value="<?= htmlspecialchars($student['phone'] ?? '') ?>" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Class</label>
                    <select name="class_id" class="form-select">
                        <option value="">Select Class</option>
                        <?php foreach ($classes as $class): ?>
                            <option value="<?= $class['id'] ?>" <?= $class['id'] == $student['class_id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($class['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Roll Number</label>
                    <input type="text" name="roll_number" class="form-control" value="<?= htmlspecialchars($student['roll_number'] ?? '') ?>">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Gender</label>
                    <select name="gender" class="form-select">
                        <option value="">Select</option>
                        <option value="male" <?= $student['gender'] === 'male' ? 'selected' : '' ?>>Male</option>
                        <option value="female" <?= $student['gender'] === 'female' ? 'selected' : '' ?>>Female</option>
                        <option value="other" <?= $student['gender'] === 'other' ? 'selected' : '' ?>>Other</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="active" <?= $student['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                        <option value="inactive" <?= $student['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Date of Birth</label>
                    <input type="date" name="date_of_birth" class="form-control" value="<?= htmlspecialchars($student['date_of_birth'] ?? '') ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Blood Group</label>
                    <select name="blood_group" class="form-select">
                        <option value="">Select</option>
                        <?php foreach(['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'] as $bg): ?>
                            <option value="<?= $bg ?>" <?= ($student['blood_group'] ?? '') === $bg ? 'selected' : '' ?>><?= $bg ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Address</label>
                <textarea name="address" class="form-control" rows="2"><?= htmlspecialchars($student['address'] ?? '') ?></textarea>
            </div>

            <h5 class="mt-4 mb-3">Guardian Information</h5>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Guardian Name</label>
                    <input type="text" name="guardian_name" class="form-control" value="<?= htmlspecialchars($student['guardian_name'] ?? '') ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Guardian Phone</label>
                    <input type="tel" name="guardian_phone" class="form-control" value="<?= htmlspecialchars($student['guardian_phone'] ?? '') ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Guardian Email</label>
                    <input type="email" name="guardian_email" class="form-control" value="<?= htmlspecialchars($student['guardian_email'] ?? '') ?>">
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Update Student
                </button>
                <a href="/students/<?= $student['id'] ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
