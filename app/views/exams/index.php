<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Examinations</h1>
    <a href="/exams/create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Create Exam
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">All Exams</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Exam Code</th>
                        <th>Name</th>
                        <th>Class</th>
                        <th>Type</th>
                        <th>Duration</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($exams)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">No exams found</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($exams as $exam): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($exam['code']) ?></strong></td>
                                <td><?= htmlspecialchars($exam['name']) ?></td>
                                <td><?= htmlspecialchars($exam['class_name'] ?? 'All Classes') ?></td>
                                <td>
                                    <span class="badge bg-info"><?= ucfirst($exam['exam_type']) ?></span>
                                </td>
                                <td>
                                    <?= date('M d', strtotime($exam['start_date'])) ?> - 
                                    <?= date('M d, Y', strtotime($exam['end_date'])) ?>
                                </td>
                                <td>
                                    <span class="badge bg-<?= match($exam['status']) {
                                        'scheduled' => 'primary',
                                        'ongoing' => 'warning',
                                        'completed' => 'success',
                                        default => 'secondary'
                                    } ?>">
                                        <?= ucfirst($exam['status']) ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="/exams/<?= $exam['id'] ?>" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="/exams/<?= $exam['id'] ?>/edit" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button onclick="confirmDelete('/exams/<?= $exam['id'] ?>')" class="btn btn-sm btn-danger">
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
