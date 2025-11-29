<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Learning Materials</h1>
    <?php if (hasRole('admin') || hasRole('teacher')): ?>
        <?php 
            $createUrl = '/materials/create';
            if (!empty($_GET['subject_id'])) {
                $createUrl .= '?subject_id=' . urlencode($_GET['subject_id']);
            } elseif (!empty($_GET['class_id'])) {
                $createUrl .= '?class_id=' . urlencode($_GET['class_id']);
            }
        ?>
        <a href="<?= $createUrl ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Upload Material
        </a>
    <?php endif; ?>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="/materials" class="row g-3">
            <div class="col-md-5">
                <select name="class_id" class="form-select">
                    <option value="">All Classes</option>
                    <?php foreach ($classes as $class): ?>
                        <option value="<?= $class['id'] ?>"><?= htmlspecialchars($class['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-5">
                <select name="subject_id" class="form-select">
                    <option value="">All Subjects</option>
                    <?php foreach ($subjects as $subject): ?>
                        <option value="<?= $subject['id'] ?>"><?= htmlspecialchars($subject['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search"></i> Filter
                </button>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <?php if (empty($materials)): ?>
        <div class="col-12">
            <div class="card">
                <div class="card-body text-center py-5 text-muted">
                    <i class="bi bi-file-earmark-pdf" style="font-size: 3rem;"></i>
                    <p class="mt-3">No materials found</p>
                </div>
            </div>
        </div>
    <?php else: ?>
        <?php foreach ($materials as $material): ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-start">
                            <div class="bg-primary bg-opacity-10 text-primary p-3 rounded me-3">
                                <i class="bi bi-file-earmark-pdf" style="font-size: 2rem;"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="card-title"><?= htmlspecialchars($material['title']) ?></h5>
                                <p class="text-muted small mb-2">
                                    <i class="bi bi-book me-1"></i><?= htmlspecialchars($material['subject_name'] ?? 'General') ?>
                                </p>
                                <p class="text-muted small mb-2">
                                    <i class="bi bi-person me-1"></i><?= htmlspecialchars($material['first_name'] . ' ' . $material['last_name']) ?>
                                </p>
                                <p class="text-muted small">
                                    <i class="bi bi-calendar me-1"></i><?= date('M d, Y', strtotime($material['created_at'])) ?>
                                </p>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="/materials/<?= $material['id'] ?>/download" class="btn btn-sm btn-primary">
                                <i class="bi bi-download me-1"></i> Download
                            </a>
                            <a href="/materials/<?= $material['id'] ?>" class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i>
                            </a>
                            <?php if (hasRole('admin') || $material['uploaded_by'] == auth()['id']): ?>
                                <button onclick="confirmDelete('/materials/<?= $material['id'] ?>')" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
