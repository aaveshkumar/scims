<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Material Details</h1>
    <div>
        <a href="/materials/<?= $material['id'] ?>/download" class="btn btn-success me-2">
            <i class="bi bi-download me-2"></i>Download
        </a>
        <a href="/materials" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><?= htmlspecialchars($material['title']) ?></h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-1 text-muted">Class</p>
                        <p><?= htmlspecialchars($material['class_name'] ?? 'All Classes') ?></p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1 text-muted">Subject</p>
                        <p><?= htmlspecialchars($material['subject_name'] ?? 'General') ?></p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-1 text-muted">Material Type</p>
                        <span class="badge bg-primary"><?= ucfirst($material['type']) ?></span>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1 text-muted">File Type</p>
                        <span class="badge bg-info"><?= strtoupper(pathinfo($material['file_path'], PATHINFO_EXTENSION)) ?></span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-1 text-muted">Uploaded By</p>
                        <p><?= htmlspecialchars($material['first_name'] . ' ' . $material['last_name']) ?></p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1 text-muted">Upload Date</p>
                        <p><?= date('M d, Y h:i A', strtotime($material['created_at'])) ?></p>
                    </div>
                </div>

                <div class="mb-3">
                    <p class="mb-1 text-muted">Description</p>
                    <p><?= nl2br(htmlspecialchars($material['description'] ?? 'No description provided.')) ?></p>
                </div>

                <hr>

                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <i class="bi bi-file-earmark-arrow-down me-2"></i>
                        <span class="text-muted">Downloads: <?= $material['downloads'] ?? 0 ?></span>
                    </div>
                    <div>
                        <i class="bi bi-hdd me-2"></i>
                        <span class="text-muted">Size: <?= round(($material['file_size'] ?? 0) / 1024, 2) ?> KB</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">File Preview</h5>
            </div>
            <div class="card-body text-center">
                <?php
                $extension = strtolower(pathinfo($material['file_path'], PATHINFO_EXTENSION));
                $icon = match($extension) {
                    'pdf' => 'bi-file-earmark-pdf text-danger',
                    'doc', 'docx' => 'bi-file-earmark-word text-primary',
                    'ppt', 'pptx' => 'bi-file-earmark-ppt text-warning',
                    'jpg', 'jpeg', 'png' => 'bi-file-earmark-image text-success',
                    'txt' => 'bi-file-earmark-text text-secondary',
                    default => 'bi-file-earmark text-muted'
                };
                ?>
                <i class="bi <?= $icon ?>" style="font-size: 5rem;"></i>
                <h5 class="mt-3"><?= strtoupper($extension) ?> File</h5>
                <p class="text-muted"><?= basename($material['file_path']) ?></p>
                
                <a href="/materials/<?= $material['id'] ?>/download" class="btn btn-success w-100 mt-3">
                    <i class="bi bi-download me-2"></i>Download File
                </a>

                <?php if (hasRole('admin') || $material['uploaded_by'] == auth()['id']): ?>
                    <button onclick="confirmDelete('/materials/<?= $material['id'] ?>')" class="btn btn-danger w-100 mt-2">
                        <i class="bi bi-trash me-2"></i>Delete
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
