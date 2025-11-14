<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Classes</h1>
    <a href="/classes/create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Add Class
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">All Classes</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Class Name</th>
                        <th>Course</th>
                        <th>Section</th>
                        <th>Capacity</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($classes)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No classes found</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($classes as $class): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($class['name']) ?></strong></td>
                                <td><?= htmlspecialchars($class['course_name'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($class['section'] ?? 'N/A') ?></td>
                                <td><?= $class['capacity'] ?? 'N/A' ?></td>
                                <td>
                                    <span class="badge bg-<?= $class['status'] === 'active' ? 'success' : 'secondary' ?>">
                                        <?= ucfirst($class['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="/classes/<?= $class['id'] ?>" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="/classes/<?= $class['id'] ?>/edit" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button onclick="confirmDelete('/classes/<?= $class['id'] ?>')" class="btn btn-sm btn-danger">
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
