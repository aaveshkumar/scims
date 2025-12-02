<?php include __DIR__ . '/../layouts/header.php'; ?>

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

<?php include __DIR__ . '/../layouts/footer.php'; ?>
