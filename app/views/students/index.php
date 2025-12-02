<?php include __DIR__ . '/../layouts/header.php'; ?>

<!-- Show temporary password if just created -->
<?php if (isset($_SESSION['new_password']) && isset($_SESSION['new_student_email'])): ?>
    <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <strong><i class="bi bi-key-fill me-2"></i>New Student Created Successfully!</strong>
                <p class="mb-2 mt-2">
                    <strong>Email:</strong> <?= htmlspecialchars($_SESSION['new_student_email']) ?><br>
                    <strong>Temporary Password:</strong> 
                    <code style="background: #f0f0f0; padding: 5px 10px; border-radius: 3px; font-weight: bold; font-size: 1.1em;" id="newStudentPassword">
                        <?= htmlspecialchars($_SESSION['new_password']) ?>
                    </code>
                </p>
                <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="copyNewPassword()">
                    <i class="bi bi-clipboard me-1"></i>Copy Password
                </button>
                <p class="mb-0 text-muted small mt-2">
                    ⏱️ Password expires in 7 days. Share this with the student or they can use "Forgot Password" to reset it.
                </p>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    <?php unset($_SESSION['new_password'], $_SESSION['new_student_email'], $_SESSION['show_password_modal']); ?>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Students</h1>
    <a href="/students/create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Add Student
    </a>
</div>

<?php if (!$classId): ?>
    <!-- Classes Grid View -->
    <div class="row mb-4">
        <?php foreach ($classes as $class): ?>
            <div class="col-md-4 mb-3">
                <div class="card h-100 cursor-pointer" onclick="selectClass(<?= $class['id'] ?>)" style="cursor: pointer; transition: all 0.3s;">
                    <div class="card-body text-center">
                        <h5 class="card-title"><?= htmlspecialchars($class['name']) ?></h5>
                        <p class="card-text display-6 mb-2"><?= $class['student_count'] ?></p>
                        <small class="text-muted">Students</small>
                    </div>
                    <div class="card-footer bg-light text-center">
                        <button class="btn btn-sm btn-warning me-2" onclick="promoteClass(event, <?= $class['id'] ?>, '<?= htmlspecialchars($class['name']) ?>')">
                            <i class="bi bi-arrow-up me-1"></i>Promote to Next Year
                        </button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <!-- Students List View -->
    <div class="mb-3">
        <a href="/students" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to Classes
        </a>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Students in <?= htmlspecialchars($classes[array_search($classId, array_column($classes, 'id'))]['name'] ?? 'Class') ?></h5>
        </div>
        <div class="card-body">
            <?php if (empty($students)): ?>
                <div class="text-center py-4 text-muted">
                    <p>No students found in this class</p>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Admission #</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Roll #</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($students as $student): ?>
                                <tr>
                                    <td><?= htmlspecialchars($student['admission_number'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars(($student['first_name'] ?? '') . ' ' . ($student['last_name'] ?? '')) ?></td>
                                    <td><?= htmlspecialchars($student['email'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($student['phone'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($student['roll_number'] ?? 'N/A') ?></td>
                                    <td>
                                        <span class="badge bg-<?= $student['status'] === 'active' ? 'success' : 'secondary' ?>" id="status-badge-<?= $student['id'] ?>">
                                            <?= ucfirst($student['status']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="/students/<?= $student['id'] ?>" class="btn btn-sm btn-info" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="/students/<?= $student['id'] ?>/edit" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-primary" title="View Credentials" data-bs-toggle="modal" data-bs-target="#credentialsModal" onclick="showCredentials('<?= htmlspecialchars($student['email']) ?>', '<?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?>', <?= $student['id'] ?>)">
                                            <i class="bi bi-info-circle"></i>
                                        </button>
                                        <form method="POST" action="/students/<?= $student['id'] ?>/resend-password" style="display: inline;">
                                            <input type="hidden" name="_token" value="<?= csrf() ?>">
                                            <button type="submit" class="btn btn-sm btn-success" title="Resend Password" onclick="return confirm('Send new password to <?= htmlspecialchars($student['email']) ?>?')">
                                                <i class="bi bi-key-fill"></i>
                                            </button>
                                        </form>
                                        <button onclick="confirmDelete('/students/<?= $student['id'] ?>?class_id=<?= $classId ?>', 'Are you sure you want to remove this student from class?', this)" class="btn btn-sm btn-danger" title="Remove from Class">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>

<!-- Credentials Modal -->
<div class="modal fade" id="credentialsModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="bi bi-key-fill me-2"></i>Student Credentials</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p><strong>Name:</strong> <span id="credName"></span></p>
                <p><strong>Email:</strong> <span id="credEmail"></span></p>
                <p class="mb-1"><strong>Temporary Password:</strong></p>
                <div class="alert alert-warning mb-3" id="passwordDisplay">
                    <code id="credPassword" style="background: #fff3cd; padding: 8px 12px; border-radius: 3px; font-weight: bold; font-size: 1.1em; word-break: break-all;">
                    </code>
                </div>
                <div class="alert alert-info mb-0" id="passwordNote">
                    <p class="mb-0">
                        <small id="noteText">Password is temporary and expires in 7 days. Student can use "Forgot Password" to set a permanent password.</small>
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="copyBoth()">
                    <i class="bi bi-clipboard me-1"></i>Copy Email & Password
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Promotion Modal -->
<div class="modal fade" id="promotionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title"><i class="bi bi-arrow-up me-2"></i>Promote Class to Next Year</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" id="promotionForm">
                <input type="hidden" name="_token" value="<?= csrf() ?>">
                <input type="hidden" name="from_class_id" id="fromClassId">
                <div class="modal-body">
                    <p><strong>From Class:</strong> <span id="fromClassName"></span></p>
                    <p class="text-danger">⚠️ All students in this class will be moved to the selected class.</p>
                    <div class="mb-3">
                        <label class="form-label">Move to Class *</label>
                        <select name="to_class_id" id="toClassId" class="form-select" required>
                            <option value="">Select Target Class</option>
                            <?php foreach ($classes as $class): ?>
                                <option value="<?= $class['id'] ?>"><?= htmlspecialchars($class['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-arrow-up me-1"></i>Promote All Students
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function selectClass(classId) {
    window.location.href = '/students?class_id=' + classId;
}

function promoteClass(event, classId, className) {
    event.stopPropagation();
    document.getElementById('fromClassId').value = classId;
    document.getElementById('fromClassName').textContent = className;
    const modal = new bootstrap.Modal(document.getElementById('promotionModal'));
    modal.show();
}

function showCredentials(email, name, studentId) {
    document.getElementById('credName').textContent = name;
    document.getElementById('credEmail').textContent = email;
    document.getElementById('credPassword').textContent = '(Loading...)';
    
    fetch(`/api/students/${studentId}/temporary-password`)
        .then(r => r.json())
        .then(data => {
            let noteText = document.getElementById('noteText');
            if (data.password && !data.password.includes('Check the blue alert')) {
                document.getElementById('credPassword').textContent = data.password;
                if (data.expires_at) {
                    noteText.textContent = 'Password expires: ' + new Date(data.expires_at).toLocaleDateString();
                }
            } else {
                document.getElementById('credPassword').textContent = '(Password not available)';
                noteText.textContent = 'Click the green 🔑 button to generate and resend a new temporary password.';
            }
        })
        .catch(e => {
            console.error('Error:', e);
            document.getElementById('credPassword').textContent = '(Error loading password)';
        });
}

function copyBoth() {
    const email = document.getElementById('credEmail').textContent;
    const password = document.getElementById('credPassword').textContent;
    const text = `Email: ${email}\nPassword: ${password}`;
    navigator.clipboard.writeText(text).then(() => {
        alert('Copied to clipboard!');
    });
}

function copyNewPassword() {
    const pwd = document.getElementById('newStudentPassword').textContent;
    navigator.clipboard.writeText(pwd).then(() => {
        alert('Password copied!');
    });
}

document.getElementById('promotionForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const fromClassId = document.getElementById('fromClassId').value;
    const toClassId = document.getElementById('toClassId').value;
    
    if (!toClassId) {
        alert('Please select a target class');
        return;
    }
    
    if (confirm('Are you sure? This will move ALL students from this class to the selected class.')) {
        this.action = '/students/promote/' + fromClassId;
        this.submit();
    }
});
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
