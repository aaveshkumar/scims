<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Courses</h1>
    <a href="/courses/create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Add Course
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">All Courses</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Duration</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($courses)): ?>
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">No courses found</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($courses as $course): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($course['code']) ?></strong></td>
                                <td><?= htmlspecialchars($course['name']) ?></td>
                                <td><?= $course['duration_years'] ?> Year(s)</td>
                                <td>
                                    <span class="badge bg-<?= $course['status'] === 'active' ? 'success' : 'secondary' ?>">
                                        <?= ucfirst($course['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="/courses/<?= $course['id'] ?>" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="/courses/<?= $course['id'] ?>/edit" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button onclick="confirmDelete('/courses/<?= $course['id'] ?>')" class="btn btn-sm btn-danger">
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
