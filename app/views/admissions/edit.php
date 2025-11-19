<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="bi bi-pencil me-2"></i>Edit Admission Application</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Important:</strong> Please fill out all required fields (*) carefully. Your application number will be generated upon submission. Save it for tracking your application status.
                    </div>

                    <form method="POST" action="/admissions/<?= $admission['id'] ?>" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <input type="hidden" name="_method" value="PUT">

                        <h5 class="border-bottom pb-2 mb-3">Personal Information</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="first_name" class="form-label">First Name *</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" value="<?= htmlspecialchars($admission['first_name']) ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="last_name" class="form-label">Last Name *</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" value="<?= htmlspecialchars($admission['last_name']) ?>" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address *</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($admission['email']) ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone Number *</label>
                                <input type="tel" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($admission['phone']) ?>" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="date_of_birth" class="form-label">Date of Birth *</label>
                                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="<?= htmlspecialchars($admission['date_of_birth']) ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="gender" class="form-label">Gender *</label>
                                <select class="form-select" id="gender" name="gender" required>
                                    <option value="">Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address *</label>
                            <textarea class="form-control" id="address" name="address" rows="2" required></textarea>
                        </div>

                        <h5 class="border-bottom pb-2 mb-3 mt-4">Academic Information</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="course_id" class="form-label">Course *</label>
                                <select class="form-select" id="course_id" name="course_id" required>
                                    <option value="">Select Course</option>
                                    <?php foreach ($courses as $course): ?>
                                        <option value="<?= $course['id'] ?>"><?= htmlspecialchars($course['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="class_id" class="form-label">Class *</label>
                                <select class="form-select" id="class_id" name="class_id" required>
                                    <option value="">Select Class</option>
                                    <?php foreach ($classes as $class): ?>
                                        <option value="<?= $class['id'] ?>"><?= htmlspecialchars($class['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="previous_school" class="form-label">Previous School</label>
                                <input type="text" class="form-control" id="previous_school" name="previous_school">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="previous_grade" class="form-label">Previous Grade/Class</label>
                                <input type="text" class="form-control" id="previous_grade" name="previous_grade">
                            </div>
                        </div>

                        <h5 class="border-bottom pb-2 mb-3 mt-4">Guardian Information</h5>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="guardian_name" class="form-label">Guardian Name *</label>
                                <input type="text" class="form-control" id="guardian_name" name="guardian_name" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="guardian_phone" class="form-label">Guardian Phone *</label>
                                <input type="tel" class="form-control" id="guardian_phone" name="guardian_phone" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="guardian_email" class="form-label">Guardian Email</label>
                                <input type="email" class="form-control" id="guardian_email" name="guardian_email">
                            </div>
                        </div>

                        <h5 class="border-bottom pb-2 mb-3 mt-4">Upload Documents</h5>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="photo" class="form-label">Passport Photo</label>
                                <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                                <small class="text-muted">JPG, PNG (Max 2MB)</small>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="id_proof" class="form-label">ID Proof</label>
                                <input type="file" class="form-control" id="id_proof" name="id_proof" accept=".pdf,.jpg,.jpeg,.png">
                                <small class="text-muted">PDF, JPG (Max 5MB)</small>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="birth_certificate" class="form-label">Birth Certificate</label>
                                <input type="file" class="form-control" id="birth_certificate" name="birth_certificate" accept=".pdf,.jpg,.jpeg,.png">
                                <small class="text-muted">PDF, JPG (Max 5MB)</small>
                            </div>
                        </div>

                        <div class="alert alert-warning mt-3">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            By submitting this application, you confirm that all information provided is accurate and complete.
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="<?= isAuth() && hasRole('admin') ? '/admissions' : '/admission/track' ?>" class="btn btn-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-send me-2"></i>Submit Application
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
