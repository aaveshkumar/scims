<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-exclamation-circle me-2"></i>Hostel Complaints Management</h2>
    <a href="/hostel/complaints/create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Add Complaint
    </a>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <select name="hostel_id" class="form-select">
                    <option value="">All Hostels</option>
                    <?php foreach ($hostels as $hostel): ?>
                        <option value="<?= $hostel['id'] ?>" <?= ($filters['hostel_id'] ?? '') == $hostel['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($hostel['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="pending" <?= ($filters['status'] ?? '') == 'pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="in_progress" <?= ($filters['status'] ?? '') == 'in_progress' ? 'selected' : '' ?>>In Progress</option>
                    <option value="resolved" <?= ($filters['status'] ?? '') == 'resolved' ? 'selected' : '' ?>>Resolved</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="priority" class="form-select">
                    <option value="">All Priority</option>
                    <option value="high" <?= ($filters['priority'] ?? '') == 'high' ? 'selected' : '' ?>>High</option>
                    <option value="medium" <?= ($filters['priority'] ?? '') == 'medium' ? 'selected' : '' ?>>Medium</option>
                    <option value="low" <?= ($filters['priority'] ?? '') == 'low' ? 'selected' : '' ?>>Low</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-outline-primary w-100">
                    <i class="bi bi-search me-2"></i>Filter
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Stats -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Total Complaints</h6>
                <h3><?= $stats['total'] ?? 0 ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Pending</h6>
                <h3><?= $stats['pending'] ?? 0 ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">In Progress</h6>
                <h3><?= $stats['in_progress'] ?? 0 ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Resolved</h6>
                <h3><?= $stats['resolved'] ?? 0 ?></h3>
            </div>
        </div>
    </div>
</div>

<?php if (empty($complaints)): ?>
    <div class="alert alert-info">
        <p>No complaints found.</p>
    </div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Resident</th>
                    <th>Type</th>
                    <th>Description</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Assigned To</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($complaints as $complaint): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($complaint['student_first_name'] . ' ' . $complaint['student_last_name']) ?></strong></td>
                        <td><?= htmlspecialchars($complaint['complaint_type'] ?? '-') ?></td>
                        <td><?= htmlspecialchars(substr($complaint['description'], 0, 30)) ?>...</td>
                        <td>
                            <span class="badge bg-<?= ($complaint['priority'] ?? 'medium') == 'high' ? 'danger' : (($complaint['priority'] ?? 'medium') == 'low' ? 'success' : 'warning') ?>">
                                <?= ucfirst($complaint['priority'] ?? 'medium') ?>
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-<?= ($complaint['status'] ?? 'pending') == 'resolved' ? 'success' : (($complaint['status'] ?? 'pending') == 'in_progress' ? 'info' : 'warning') ?>">
                                <?= ucfirst(str_replace('_', ' ', $complaint['status'] ?? 'pending')) ?>
                            </span>
                        </td>
                        <td><?= htmlspecialchars($complaint['assigned_to_name'] ?? 'Unassigned') ?></td>
                        <td><?= date('d M Y', strtotime($complaint['created_at'])) ?></td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="/hostel/complaints/<?= $complaint['id'] ?>/edit" class="btn btn-outline-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="/hostel/complaints/<?= $complaint['id'] ?>/delete" style="display: inline;">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Delete this complaint?')" title="Delete">
                                        <i class="bi bi-trash"></i>
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

<?php include __DIR__ . '/../layouts/footer.php'; ?>
