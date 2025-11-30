<?php include __DIR__ . '/../../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Hostel Rooms Management</h2>
    <a href="/hostel/rooms/create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Add Room
    </a>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <input type="text" name="search" class="form-control" placeholder="Search room number..." value="<?= $_GET['search'] ?? '' ?>">
            </div>
            <div class="col-md-3">
                <select name="hostel_id" class="form-select">
                    <option value="">All Hostels</option>
                    <?php foreach ($hostels as $hostel): ?>
                        <option value="<?= $hostel['id'] ?>" <?= ($_GET['hostel_id'] ?? '') == $hostel['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($hostel['name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="active" <?= ($_GET['status'] ?? '') == 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= ($_GET['status'] ?? '') == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                </select>
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
                <h6 class="text-muted">Total Rooms</h6>
                <h3><?= $stats['total'] ?? 0 ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Active Rooms</h6>
                <h3><?= $stats['active'] ?? 0 ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Total Capacity</h6>
                <h3><?= $stats['capacity'] ?? 0 ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Occupied</h6>
                <h3><?= $stats['occupied'] ?? 0 ?></h3>
            </div>
        </div>
    </div>
</div>

<?php if (empty($rooms)): ?>
    <div class="alert alert-info">
        <p>No rooms found.</p>
    </div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Room Number</th>
                    <th>Hostel</th>
                    <th>Type</th>
                    <th>Capacity</th>
                    <th>Floor</th>
                    <th>Fee</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rooms as $room): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($room['room_number']) ?></strong></td>
                        <td><?= htmlspecialchars($room['hostel_name'] ?? 'N/A') ?></td>
                        <td>
                            <span class="badge bg-info">
                                <?= ucfirst(htmlspecialchars($room['room_type'] ?? 'N/A')) ?>
                            </span>
                        </td>
                        <td><?= $room['capacity'] ?? 0 ?></td>
                        <td><?= $room['floor_number'] ?? 1 ?></td>
                        <td>₹<?= number_format($room['room_fee'] ?? 0, 2) ?></td>
                        <td>
                            <span class="badge bg-<?= ($room['status'] ?? 'active') == 'active' ? 'success' : 'secondary' ?>">
                                <?= ucfirst($room['status'] ?? 'active') ?>
                            </span>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="/hostel/rooms/<?= $room['id'] ?>/edit" class="btn btn-outline-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="/hostel/rooms/<?= $room['id'] ?>/delete" style="display: inline;">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Delete this room?')">
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

<?php include __DIR__ . '/../../layouts/footer.php'; ?>
