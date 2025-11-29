<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">
        <?php if ($classId): ?>
            Class Subjects
        <?php else: ?>
            All Subjects
        <?php endif; ?>
    </h1>
    <a href="/subjects/create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Add Subject
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">
            <?php if ($classId): ?>
                Subjects in Class
            <?php else: ?>
                All Subjects
            <?php endif; ?>
        </h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Subject Name</th>
                        <th>Class</th>
                        <th>Teacher</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($subjects)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No subjects found</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($subjects as $subject): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($subject['code']) ?></strong></td>
                                <td><?= htmlspecialchars($subject['name']) ?></td>
                                <td><?= htmlspecialchars($subject['class_name'] ?? 'All Classes') ?></td>
                                <td><?= htmlspecialchars($subject['teacher_name'] ?? 'Not assigned') ?></td>
                                <td>
                                    <span class="badge bg-info">
                                        <?= ucfirst($subject['subject_type'] ?? 'theory') ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-<?= $subject['status'] === 'active' ? 'success' : 'secondary' ?>">
                                        <?= ucfirst($subject['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="/subjects/<?= $subject['id'] ?>" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="/subjects/<?= $subject['id'] ?>/edit" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button onclick="confirmDelete('/subjects/<?= $subject['id'] ?>')" class="btn btn-sm btn-danger">
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
