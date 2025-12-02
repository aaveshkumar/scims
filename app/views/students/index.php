<?php include __DIR__ . '/../layouts/header.php'; ?>

<!-- Store new password globally for modal access -->
<script>
    window.credentialsMap = {};
    <?php if (isset($_SESSION['new_password']) && isset($_SESSION['new_student_email'])): ?>
        window.credentialsMap['<?= htmlspecialchars($_SESSION['new_student_email']) ?>'] = '<?= htmlspecialchars($_SESSION['new_password']) ?>';
    <?php endif; ?>
</script>

<!-- Show temporary password if just created (display only once) -->
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
    <?php 
        // Clear after showing (display only once)
        unset($_SESSION['new_password'], $_SESSION['new_student_email'], $_SESSION['show_password_modal']);
    ?>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">
        <?php if ($classId): ?>
            Class Students
        <?php else: ?>
            All Students
        <?php endif; ?>
    </h1>
    <a href="/students/create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Add Student
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <?php if ($classId): ?>
                Students in Class
            <?php else: ?>
                All Students
            <?php endif; ?>
        </h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Admission #</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Class</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($students)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No students found</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($students as $student): ?>
                            <tr>
                                <td><?= htmlspecialchars($student['admission_number'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars(($student['first_name'] ?? '') . ' ' . ($student['last_name'] ?? '')) ?></td>
                                <td><?= htmlspecialchars($student['email'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($student['phone'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($student['class_name'] ?? 'N/A') ?></td>
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
                                    <button type="button" class="btn btn-sm btn-primary" title="View Credentials" data-bs-toggle="modal" data-bs-target="#credentialsModal" onclick="showCredentials('<?= htmlspecialchars($student['email']) ?>', '<?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?>')">
                                        <i class="bi bi-info-circle"></i>
                                    </button>
                                    <form method="POST" action="/students/<?= $student['id'] ?>/resend-password" style="display: inline;">
                                        <input type="hidden" name="_token" value="<?= csrf() ?>">
                                        <button type="submit" class="btn btn-sm btn-success" title="Resend Password" onclick="return confirm('Send new password to <?= htmlspecialchars($student['email']) ?>?')">
                                            <i class="bi bi-key-fill"></i>
                                        </button>
                                    </form>
                                    <button onclick="confirmDelete('/students/<?= $student['id'] ?>' + window.location.search, 'Are you sure you want to delete this student?', this)" class="btn btn-sm btn-danger" title="<?= $classId ? 'Remove from Class' : 'Delete' ?>">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

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
                <div class="alert alert-warning mb-3">
                    <code id="credPassword" style="background: #fff3cd; padding: 8px 12px; border-radius: 3px; font-weight: bold; font-size: 1.1em; word-break: break-all;">
                    </code>
                </div>
                <div class="alert alert-info mb-0">
                    <p class="mb-0">
                        <small>Password is temporary and expires in 7 days. Student can use "Forgot Password" to set a permanent password.</small>
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

<script>
function showCredentials(email, name) {
    document.getElementById('credName').textContent = name;
    document.getElementById('credEmail').textContent = email;
    let password = window.credentialsMap[email] || '(No password available)';
    document.getElementById('credPassword').textContent = password;
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
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
