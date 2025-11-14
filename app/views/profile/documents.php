<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>My Documents</h2>
        <div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadModal">
                <i class="bi bi-cloud-upload me-2"></i>Upload Document
            </button>
            <a href="/profile" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back to Profile
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Uploaded Documents</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Upload important documents like ID proof, certificates, and academic records here. Maximum file size: 5MB.
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Document Name</th>
                                    <th>Type</th>
                                    <th>Upload Date</th>
                                    <th>Size</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $uploadDir = __DIR__ . '/../../../public/uploads/documents/';
                                $files = [];
                                if (is_dir($uploadDir)) {
                                    $files = array_diff(scandir($uploadDir), ['.', '..']);
                                }
                                
                                if (empty($files)): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <i class="bi bi-folder2-open fs-1 text-muted d-block mb-2"></i>
                                        <p class="text-muted">No documents uploaded yet. Click "Upload Document" to get started.</p>
                                    </td>
                                </tr>
                                <?php else: 
                                    foreach ($files as $file):
                                        $filePath = $uploadDir . $file;
                                        $fileSize = filesize($filePath);
                                        $uploadDate = date('M d, Y', filemtime($filePath));
                                        $extension = pathinfo($file, PATHINFO_EXTENSION);
                                ?>
                                <tr>
                                    <td>
                                        <i class="bi bi-file-earmark-pdf me-2 text-danger"></i>
                                        <?= htmlspecialchars($file) ?>
                                    </td>
                                    <td><span class="badge bg-secondary"><?= strtoupper($extension) ?></span></td>
                                    <td><?= $uploadDate ?></td>
                                    <td><?= number_format($fileSize / 1024, 2) ?> KB</td>
                                    <td>
                                        <a href="/uploads/documents/<?= $file ?>" class="btn btn-sm btn-outline-primary" download>
                                            <i class="bi bi-download"></i>
                                        </a>
                                        <button class="btn btn-sm btn-outline-danger" onclick="deleteDocument('<?= $file ?>')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Upload Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Document</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="/profile/upload-document" enctype="multipart/form-data">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="document" class="form-label">Select Document *</label>
                        <input type="file" class="form-control" id="document" name="document" 
                               accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required>
                        <small class="text-muted">Supported formats: PDF, DOC, DOCX, JPG, PNG (Max 5MB)</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-cloud-upload me-2"></i>Upload
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function deleteDocument(filename) {
    if (confirm('Are you sure you want to delete this document?')) {
        alert('Delete functionality will be implemented soon.');
    }
}
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
