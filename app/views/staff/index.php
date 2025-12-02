<?php include __DIR__ . '/../layouts/header.php'; ?>

<!-- Store new password globally for modal access -->
<script>
    window.credentialsMap = {};
    <?php if (isset($_SESSION['new_password']) && isset($_SESSION['new_staff_email'])): ?>
        window.credentialsMap['<?= htmlspecialchars($_SESSION['new_staff_email']) ?>'] = '<?= htmlspecialchars($_SESSION['new_password']) ?>';
    <?php endif; ?>
</script>

<!-- Show temporary password if just created (display only once) -->
<?php if (isset($_SESSION['new_password']) && isset($_SESSION['new_staff_email'])): ?>
    <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <strong><i class="bi bi-key-fill me-2"></i>New Staff Member Created Successfully!</strong>
                <p class="mb-2 mt-2">
                    <strong>Email:</strong> <?= htmlspecialchars($_SESSION['new_staff_email']) ?><br>
                    <strong>Temporary Password:</strong> 
                    <code style="background: #f0f0f0; padding: 5px 10px; border-radius: 3px; font-weight: bold; font-size: 1.1em;" id="newStaffPassword">
                        <?= htmlspecialchars($_SESSION['new_password']) ?>
                    </code>
                </p>
                <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="copyNewPassword()">
                    <i class="bi bi-clipboard me-1"></i>Copy Password
                </button>
                <p class="mb-0 text-muted small mt-2">
                    ⏱️ Password expires in 7 days. Share this with the staff member or they can use "Forgot Password" to reset it.
                </p>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
    <?php 
        // Clear after showing (display only once)
        unset($_SESSION['new_password'], $_SESSION['new_staff_email'], $_SESSION['show_password_modal']);
    ?>
<?php endif; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Staff Members</h1>
    <a href="/staff/create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Add Staff
    </a>
</div>

<!-- Category Filter -->
<?php if (!empty($staffByRole)): ?>
<div class="mb-4">
    <div class="btn-group" role="group">
        <button type="button" class="btn btn-outline-primary category-filter active" data-role="all">
            <i class="bi bi-funnel me-2"></i>All Categories
        </button>
        <?php foreach (array_keys($staffByRole) as $role): ?>
            <button type="button" class="btn btn-outline-primary category-filter" data-role="<?= $role ?>">
                <?= ucfirst($role) ?> (<?= count($staffByRole[$role]) ?>)
            </button>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<?php if (empty($staffByRole)): ?>
<div class="card">
    <div class="card-body text-center py-5 text-muted">
        <p class="mb-0">No staff members found</p>
    </div>
</div>
<?php else: ?>
    <?php foreach ($staffByRole as $role => $members): ?>
    <div class="card mb-4 role-section" data-role="<?= $role ?>">
        <div class="card-header" style="background-color: #f8f9fa; border-bottom: 2px solid #dee2e6;">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <span class="badge bg-primary me-2"><?= count($members) ?></span>
                    <?= ucfirst($role) ?>
                </h5>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Employee ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Designation</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($members as $member): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($member['employee_id']) ?></strong></td>
                                <td><?= htmlspecialchars($member['first_name'] . ' ' . $member['last_name']) ?></td>
                                <td><?= htmlspecialchars($member['email']) ?></td>
                                <td><?= htmlspecialchars($member['phone']) ?></td>
                                <td><?= htmlspecialchars($member['designation']) ?></td>
                                <td>
                                    <span class="badge bg-info">
                                        <?= ucfirst($member['role']) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-<?= $member['status'] === 'active' ? 'success' : 'secondary' ?>" id="status-badge-<?= $member['id'] ?>">
                                        <?= ucfirst($member['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="/staff/<?= $member['id'] ?>" class="btn btn-sm btn-info" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="/staff/<?= $member['id'] ?>/edit" class="btn btn-sm btn-warning" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-primary" title="View Credentials" data-bs-toggle="modal" data-bs-target="#credentialsModal" onclick="showCredentials('<?= htmlspecialchars($member['email']) ?>', '<?= htmlspecialchars($member['first_name'] . ' ' . $member['last_name']) ?>')">
                                        <i class="bi bi-info-circle"></i>
                                    </button>
                                    <form method="POST" action="/staff/<?= $member['id'] ?>/resend-password" style="display: inline;">
                                        <input type="hidden" name="_token" value="<?= csrf() ?>">
                                        <button type="submit" class="btn btn-sm btn-success" title="Resend Password" onclick="return confirm('Send new password to <?= htmlspecialchars($member['email']) ?>?')">
                                            <i class="bi bi-key-fill"></i>
                                        </button>
                                    </form>
                                    <button onclick="confirmDelete('/staff/<?= $member['id'] ?>', 'Are you sure you want to delete this staff member?', this)" class="btn btn-sm btn-danger" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
<?php endif; ?>

<style>
.category-filter {
    color: white !important;
}

.category-filter:hover {
    color: white !important;
}
</style>

<script>
document.querySelectorAll('.category-filter').forEach(button => {
    button.addEventListener('click', function() {
        const selectedRole = this.getAttribute('data-role');
        
        // Update active button
        document.querySelectorAll('.category-filter').forEach(b => {
            b.classList.remove('active');
        });
        this.classList.add('active');
        
        // Filter sections
        document.querySelectorAll('.role-section').forEach(section => {
            const sectionRole = section.getAttribute('data-role');
            if (selectedRole === 'all' || sectionRole === selectedRole) {
                section.style.display = 'block';
            } else {
                section.style.display = 'none';
            }
        });
    });
});
</script>

<!-- Credentials Modal -->
<div class="modal fade" id="credentialsModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="bi bi-key-fill me-2"></i>Staff Credentials</h5>
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
                        <small id="noteText">Password is temporary and expires in 7 days. Staff can use "Forgot Password" to set a permanent password.</small>
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
    let password = window.credentialsMap[email];
    let noteText = document.getElementById('noteText');
    
    if (password) {
        // Newly created staff - show password
        document.getElementById('credPassword').textContent = password;
        noteText.textContent = 'Password is temporary and expires in 7 days. Staff can use "Forgot Password" to set a permanent password.';
    } else {
        // Old staff - suggest resend
        document.getElementById('credPassword').textContent = '(Password not available)';
        noteText.textContent = 'For existing staff, click the green 🔑 button to generate and resend a new temporary password.';
    }
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
    const pwd = document.getElementById('newStaffPassword').textContent;
    navigator.clipboard.writeText(pwd).then(() => {
        alert('Password copied!');
    });
}
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
