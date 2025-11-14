<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">New Admission Application</h1>
    <a href="/admissions" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Applicant Information</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="/admissions">
            <input type="hidden" name="_token" value="<?= csrf() ?>">
            
            <h6 class="mb-3 text-primary">Personal Details</h6>
            
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
                <div class="col-md-4 mb-3">
                    <label class="form-label">Date of Birth *</label>
                    <input type="date" name="date_of_birth" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Gender *</label>
                    <select name="gender" class="form-select" required>
                        <option value="">Select Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Previous School</label>
                    <input type="text" name="previous_school" class="form-control">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Address *</label>
                <textarea name="address" class="form-control" rows="2" required></textarea>
            </div>

            <h6 class="mb-3 mt-4 text-primary">Academic Information</h6>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Course</label>
                    <select name="course_id" class="form-select">
                        <option value="">Select Course (Optional)</option>
                        <?php foreach ($courses as $course): ?>
                            <option value="<?= $course['id'] ?>"><?= htmlspecialchars($course['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Class</label>
                    <select name="class_id" class="form-select">
                        <option value="">Select Class (Optional)</option>
                        <?php foreach ($classes as $class): ?>
                            <option value="<?= $class['id'] ?>"><?= htmlspecialchars($class['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <h6 class="mb-3 mt-4 text-primary">Guardian/Parent Information</h6>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Guardian Name *</label>
                    <input type="text" name="guardian_name" class="form-control" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Guardian Phone *</label>
                    <input type="tel" name="guardian_phone" class="form-control" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Guardian Email</label>
                <input type="email" name="guardian_email" class="form-control">
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Submit Application
                </button>
                <a href="/admissions" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
