<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="mb-4">
    <h2><i class="bi bi-cloud-download me-2"></i>Backup & Restore</h2>
    <p class="text-muted">Create, download, and restore database backups to protect your data</p>
</div>

<!-- Alert Box -->
<div class="alert alert-info" role="alert">
    <i class="bi bi-info-circle me-2"></i>
    <strong>Important:</strong> Regular backups are essential for data protection. Create backups before making major changes to your system.
</div>

<div class="row">
    <!-- Create Backup Section -->
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-plus-circle me-2"></i>Create New Backup</h5>
            </div>
            <div class="card-body">
                <p class="text-muted mb-3">Click the button below to create a complete backup of your database. This will create a SQL file that can be downloaded and restored later.</p>
                <form method="POST" action="/settings/backup/create" style="display: inline;">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-success btn-lg">
                        <i class="bi bi-download me-2"></i>Create Backup Now
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Restore Backup Section -->
    <div class="col-12 mb-4">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="bi bi-cloud-upload me-2"></i>Restore from Backup</h5>
            </div>
            <div class="card-body">
                <p class="text-muted mb-3">Upload a SQL backup file to restore your database to a previous state. <strong class="text-danger">Warning: This will overwrite all current data.</strong></p>
                <form method="POST" action="/settings/backup/restore" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Select Backup File (.sql)</label>
                        <input type="file" name="backup_file" class="form-control" accept=".sql" required>
                        <small class="text-muted">Only SQL files are accepted. Maximum size: 100MB</small>
                    </div>
                    <button type="submit" class="btn btn-warning" onclick="return confirm('Are you sure? This will overwrite all current data with the backup.');">
                        <i class="bi bi-arrow-repeat me-2"></i>Restore Backup
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Backup History -->
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Backup History</h5>
            </div>
            <div class="card-body">
                <?php if (empty($backups)): ?>
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                        <p>No backups found. Create your first backup by clicking the button above.</p>
                    </div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th><i class="bi bi-file-earmark me-1"></i>Filename</th>
                                    <th><i class="bi bi-calendar me-1"></i>Date Created</th>
                                    <th><i class="bi bi-hdd me-1"></i>Size</th>
                                    <th><i class="bi bi-gear me-1"></i>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($backups as $backup): ?>
                                    <tr>
                                        <td>
                                            <i class="bi bi-file-earmark-binary me-1"></i>
                                            <strong><?= htmlspecialchars($backup['name']) ?></strong>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark">
                                                <?= htmlspecialchars($backup['date']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?= formatBytes($backup['size']) ?>
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="/settings/backup/download/<?= urlencode($backup['name']) ?>" class="btn btn-sm btn-primary" title="Download">
                                                    <i class="bi bi-download me-1"></i>Download
                                                </a>
                                                <form method="POST" action="/settings/backup/delete/<?= urlencode($backup['name']) ?>" style="display: inline;">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this backup?');" title="Delete">
                                                        <i class="bi bi-trash me-1"></i>Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Tips Section -->
    <div class="col-12 mt-4">
        <div class="alert alert-light border">
            <h6 class="mb-3"><i class="bi bi-lightbulb me-2"></i>Backup Tips & Best Practices</h6>
            <ul class="mb-0 small">
                <li><strong>Regular Backups:</strong> Create backups at least once a week or before major changes</li>
                <li><strong>Store Safely:</strong> Download and store backups in a secure location outside this server</li>
                <li><strong>Test Restores:</strong> Periodically test restoring from backups to ensure they work</li>
                <li><strong>Document Changes:</strong> Keep notes about what changes were made before each backup</li>
                <li><strong>Automated Backups:</strong> Consider setting up automated daily backups for production systems</li>
            </ul>
        </div>
    </div>

    <!-- Back Button -->
    <div class="col-12 mt-4">
        <a href="/settings" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to Settings
        </a>
    </div>
</div>

<style>
    .card-header {
        padding: 0.75rem 1.25rem;
        border-bottom: 1px solid rgba(0,0,0,.125);
    }
    
    .card-header h5 {
        font-weight: 600;
    }
    
    .btn-group {
        display: flex;
        gap: 0.25rem;
    }
</style>

<?php

// Helper function to format bytes to human readable format
if (!function_exists('formatBytes')) {
    function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));

        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
?>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
