<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-file-text me-2"></i>Syllabus Management</h2>
    <a href="/syllabus/create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Add New
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-6">
                <input type="text" class="form-control" placeholder="Search...">
            </div>
            <div class="col-md-3">
                <select class="form-select">
                    <option>All Status</option>
                    <option>Active</option>
                    <option>Inactive</option>
                </select>
            </div>
            <div class="col-md-3">
                <button class="btn btn-primary w-100">
                    <i class="bi bi-search me-2"></i>Search
                </button>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($syllabuses)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                No records found. Click "Add New" to get started.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php $i = 1; foreach ($syllabuses as $syllabus): ?>
                            <tr>
                                <td><?= $i++ ?></td>
                                <td><strong><?= htmlspecialchars($syllabus['title']) ?></strong></td>
                                <td>
                                    <span class="badge bg-<?= $syllabus['status'] === 'active' ? 'success' : ($syllabus['status'] === 'draft' ? 'warning' : 'secondary') ?>">
                                        <?= ucfirst($syllabus['status']) ?>
                                    </span>
                                </td>
                                <td><?= date('M d, Y', strtotime($syllabus['created_at'])) ?></td>
                                <td>
                                    <a href="/syllabus/<?= $syllabus['id'] ?>" class="btn btn-sm btn-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="/syllabus/<?= $syllabus['id'] ?>/edit" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <button onclick="confirmDelete('/syllabus/<?= $syllabus['id'] ?>')" class="btn btn-sm btn-danger">
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