<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-people me-2"></i>Hostel Visitors Management</h2>
    <a href="/hostel/visitors/create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Add Visitor
    </a>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control" placeholder="Search visitor name..." value="<?= $_GET['search'] ?? '' ?>">
            </div>
            <div class="col-md-3">
                <input type="date" name="date_from" class="form-control" value="<?= $_GET['date_from'] ?? '' ?>">
            </div>
            <div class="col-md-3">
                <input type="date" name="date_to" class="form-control" value="<?= $_GET['date_to'] ?? '' ?>">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-outline-primary w-100">
                    <i class="bi bi-search me-2"></i>Search
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
                <h6 class="text-muted">Today Visitors</h6>
                <h3><?= $stats['today_visitors'] ?? 0 ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Active Visitors</h6>
                <h3><?= $stats['active_visitors'] ?? 0 ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">This Month</h6>
                <h3><?= $stats['this_month'] ?? 0 ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Active Now</h6>
                <h3><?= count($activeVisitors ?? []) ?></h3>
            </div>
        </div>
    </div>
</div>

<?php if (empty($visitors)): ?>
    <div class="alert alert-info">
        <p>No visitors found.</p>
    </div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Visitor Name</th>
                    <th>Phone</th>
                    <th>Student Name</th>
                    <th>Visit Date</th>
                    <th>Entry Time</th>
                    <th>Exit Time</th>
                    <th>Purpose</th>
                    <th>ID Proof</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($visitors as $visitor): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($visitor['visitor_name']) ?></strong></td>
                        <td><?= htmlspecialchars($visitor['visitor_phone'] ?? '-') ?></td>
                        <td><?= htmlspecialchars(($visitor['student_first_name'] ?? '') . ' ' . ($visitor['student_last_name'] ?? '')) ?></td>
                        <td><?= date('d M Y', strtotime($visitor['visit_date'])) ?></td>
                        <td><?= date('H:i', strtotime($visitor['entry_time'])) ?></td>
                        <td><?= $visitor['exit_time'] ? date('H:i', strtotime($visitor['exit_time'])) : '-' ?></td>
                        <td><?= htmlspecialchars($visitor['purpose'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($visitor['visitor_id_proof'] ?? '-') ?></td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="/hostel/visitors/<?= $visitor['id'] ?>/edit" class="btn btn-outline-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="/hostel/visitors/<?= $visitor['id'] ?>/delete" style="display: inline;">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Delete this visitor?')" title="Delete">
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
