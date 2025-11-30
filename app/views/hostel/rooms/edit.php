<?php include __DIR__ . '/../../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Edit Room</h2>
    <a href="/hostel/rooms" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="/hostel/rooms/<?= $room['id'] ?>" class="needs-validation">
                    <?= csrf_field() ?>
                    
                    <!-- Basic Information Section -->
                    <div class="mb-4">
                        <h5 class="mb-3">Basic Information</h5>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Hostel *</label>
                                <select name="hostel_id" class="form-select" required>
                                    <option value="">Select Hostel</option>
                                    <?php foreach ($hostels as $hostel): ?>
                                        <option value="<?= $hostel['id'] ?>" <?= $hostel['id'] == $room['hostel_id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($hostel['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Room Number *</label>
                                <input type="text" name="room_number" class="form-control" value="<?= htmlspecialchars($room['room_number']) ?>" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Room Type *</label>
                                <select name="room_type" class="form-select" required>
                                    <option value="">Select Type</option>
                                    <?php foreach ($roomTypes as $key => $label): ?>
                                        <option value="<?= $key ?>" <?= $key == $room['room_type'] ? 'selected' : '' ?>>
                                            <?= $label ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Capacity (Students) *</label>
                                <input type="number" name="capacity" class="form-control" min="1" max="10" value="<?= $room['capacity'] ?>" required>
                            </div>
                        </div>
                    </div>

                    <!-- Location & Facilities Section -->
                    <div class="mb-4">
                        <h5 class="mb-3">Location & Facilities</h5>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Floor Number</label>
                                <input type="number" name="floor_number" class="form-control" min="1" value="<?= $room['floor_number'] ?? 1 ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Monthly Fee (₹)</label>
                                <input type="number" name="room_fee" class="form-control" min="0" step="0.01" value="<?= $room['room_fee'] ?? 0 ?>">
                            </div>
                        </div>
                    </div>

                    <!-- Settings Section -->
                    <div class="mb-4">
                        <h5 class="mb-3">Settings</h5>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="active" <?= ($room['status'] ?? 'active') == 'active' ? 'selected' : '' ?>>Active</option>
                                <option value="inactive" <?= ($room['status'] ?? 'active') == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>Update Room
                        </button>
                        <a href="/hostel/rooms" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Info Panel -->
    <div class="col-lg-4">
        <div class="card bg-light" style="background-color: #f8f9fa !important;" data-bs-theme="light">
            <div class="card-body">
                <h6 class="card-title"><i class="bi bi-info-circle me-2"></i>Room Details</h6>
                <dl class="row mb-0 small">
                    <dt class="col-6">Created:</dt>
                    <dd class="col-6"><?= date('d M Y', strtotime($room['created_at'] ?? now())) ?></dd>
                </dl>
            </div>
        </div>
        
        <style>
            [data-bs-theme="dark"] .card.bg-light {
                background-color: #2a2a2a !important;
                color: #e0e0e0;
            }
            [data-bs-theme="dark"] .card.bg-light .card-title {
                color: #ffffff;
            }
            [data-bs-theme="dark"] .card.bg-light dt {
                color: #b0b0b0;
            }
            [data-bs-theme="dark"] .card.bg-light dd {
                color: #e0e0e0;
            }
        </style>
    </div>
</div>

<?php include __DIR__ . '/../../layouts/footer.php'; ?>
