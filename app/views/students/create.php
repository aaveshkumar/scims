<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Add Student</h1>
    <a href="/students" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Student Information</h5>
    </div>
    <div class="card-body">
        <?php if (hasErrors()): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Please fix the following errors:</strong>
                <ul class="mb-0 mt-2">
                    <?php foreach (errors() as $field => $fieldErrors): ?>
                        <?php foreach ($fieldErrors as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <form method="POST" action="/students">
            <input type="hidden" name="_token" value="<?= csrf() ?>">
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">First Name *</label>
                    <input type="text" name="first_name" class="form-control <?= hasErrors('first_name') ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars(old('first_name', '')) ?>" required>
                    <?php if (hasErrors('first_name')): ?>
                        <div class="invalid-feedback d-block"><?= implode(' ', errors('first_name')) ?></div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Last Name *</label>
                    <input type="text" name="last_name" class="form-control <?= hasErrors('last_name') ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars(old('last_name', '')) ?>" required>
                    <?php if (hasErrors('last_name')): ?>
                        <div class="invalid-feedback d-block"><?= implode(' ', errors('last_name')) ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email *</label>
                    <input type="email" name="email" class="form-control <?= hasErrors('email') ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars(old('email', '')) ?>" required>
                    <?php if (hasErrors('email')): ?>
                        <div class="invalid-feedback d-block"><?= implode(' ', errors('email')) ?></div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Phone *</label>
                    <input type="tel" name="phone" class="form-control <?= hasErrors('phone') ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars(old('phone', '')) ?>" required>
                    <?php if (hasErrors('phone')): ?>
                        <div class="invalid-feedback d-block"><?= implode(' ', errors('phone')) ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="row">
                <div class="col-12 mb-3">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Automatic Password Generation:</strong> A temporary password will be automatically generated and sent to the student's email. The password expires in 7 days.
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Admission Number *</label>
                    <input type="text" name="admission_number" class="form-control <?= hasErrors('admission_number') ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars(old('admission_number', 'ADM' . date('Y') . rand(10000, 99999))) ?>" required>
                    <?php if (hasErrors('admission_number')): ?>
                        <div class="invalid-feedback d-block"><?= implode(' ', errors('admission_number')) ?></div>
                    <?php endif; ?>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Class *</label>
                    <select name="class_id" class="form-select <?= hasErrors('class_id') ? 'is-invalid' : '' ?>" required>
                        <option value="">Select Class</option>
                        <?php foreach ($classes as $class): ?>
                            <option value="<?= $class['id'] ?>" <?= old('class_id') == $class['id'] ? 'selected' : '' ?>><?= htmlspecialchars($class['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (hasErrors('class_id')): ?>
                        <div class="invalid-feedback d-block"><?= implode(' ', errors('class_id')) ?></div>
                    <?php endif; ?>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Roll Number *</label>
                    <input type="text" name="roll_number" class="form-control <?= hasErrors('roll_number') ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars(old('roll_number', '')) ?>" required>
                    <?php if (hasErrors('roll_number')): ?>
                        <div class="invalid-feedback d-block"><?= implode(' ', errors('roll_number')) ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Gender *</label>
                    <select name="gender" class="form-select <?= hasErrors('gender') ? 'is-invalid' : '' ?>" required>
                        <option value="">Select</option>
                        <option value="male" <?= old('gender') == 'male' ? 'selected' : '' ?>>Male</option>
                        <option value="female" <?= old('gender') == 'female' ? 'selected' : '' ?>>Female</option>
                        <option value="other" <?= old('gender') == 'other' ? 'selected' : '' ?>>Other</option>
                    </select>
                    <?php if (hasErrors('gender')): ?>
                        <div class="invalid-feedback d-block"><?= implode(' ', errors('gender')) ?></div>
                    <?php endif; ?>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Date of Birth *</label>
                    <input type="date" name="date_of_birth" class="form-control <?= hasErrors('date_of_birth') ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars(old('date_of_birth', '')) ?>" required>
                    <?php if (hasErrors('date_of_birth')): ?>
                        <div class="invalid-feedback d-block"><?= implode(' ', errors('date_of_birth')) ?></div>
                    <?php endif; ?>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Admission Date *</label>
                    <input type="date" name="admission_date" class="form-control <?= hasErrors('admission_date') ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars(old('admission_date', date('Y-m-d'))) ?>" required>
                    <?php if (hasErrors('admission_date')): ?>
                        <div class="invalid-feedback d-block"><?= implode(' ', errors('admission_date')) ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Address *</label>
                <textarea name="address" class="form-control <?= hasErrors('address') ? 'is-invalid' : '' ?>" rows="2" required><?= htmlspecialchars(old('address', '')) ?></textarea>
                <?php if (hasErrors('address')): ?>
                    <div class="invalid-feedback d-block"><?= implode(' ', errors('address')) ?></div>
                <?php endif; ?>
            </div>

            <h5 class="mt-4 mb-3">Guardian Information</h5>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Guardian Name *</label>
                    <input type="text" name="guardian_name" class="form-control <?= hasErrors('guardian_name') ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars(old('guardian_name', '')) ?>" required>
                    <?php if (hasErrors('guardian_name')): ?>
                        <div class="invalid-feedback d-block"><?= implode(' ', errors('guardian_name')) ?></div>
                    <?php endif; ?>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Guardian Phone *</label>
                    <input type="tel" name="guardian_phone" class="form-control <?= hasErrors('guardian_phone') ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars(old('guardian_phone', '')) ?>" required>
                    <?php if (hasErrors('guardian_phone')): ?>
                        <div class="invalid-feedback d-block"><?= implode(' ', errors('guardian_phone')) ?></div>
                    <?php endif; ?>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Guardian Email *</label>
                    <input type="email" name="guardian_email" class="form-control <?= hasErrors('guardian_email') ? 'is-invalid' : '' ?>" value="<?= htmlspecialchars(old('guardian_email', '')) ?>" required>
                    <?php if (hasErrors('guardian_email')): ?>
                        <div class="invalid-feedback d-block"><?= implode(' ', errors('guardian_email')) ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Blood Group *</label>
                    <select name="blood_group" class="form-select <?= hasErrors('blood_group') ? 'is-invalid' : '' ?>" required>
                        <option value="">Select</option>
                        <option value="A+">A+</option>
                        <option value="A-">A-</option>
                        <option value="B+">B+</option>
                        <option value="B-">B-</option>
                        <option value="O+">O+</option>
                        <option value="O-">O-</option>
                        <option value="AB+">AB+</option>
                        <option value="AB-">AB-</option>
                    </select>
                    <?php if (hasErrors('blood_group')): ?>
                        <div class="invalid-feedback d-block"><?= implode(' ', errors('blood_group')) ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Create Student
                </button>
                <a href="/students" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
