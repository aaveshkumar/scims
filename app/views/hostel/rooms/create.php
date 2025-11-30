<?php include __DIR__ . '/../../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Add New Room</h2>
    <a href="/hostel/rooms" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="/hostel/rooms" class="needs-validation">
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
                                        <option value="<?= $hostel['id'] ?>">
                                            <?= htmlspecialchars($hostel['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Room Number *</label>
                                <input type="text" name="room_number" class="form-control" placeholder="e.g., A-101, B-205" required>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Room Type *</label>
                                <select name="room_type" class="form-select" required>
                                    <option value="">Select Type</option>
                                    <?php foreach ($roomTypes as $key => $label): ?>
                                        <option value="<?= $key ?>"><?= $label ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Capacity (Students) *</label>
                                <input type="number" name="capacity" class="form-control" min="1" max="10" required placeholder="Number of students">
                            </div>
                        </div>
                    </div>

                    <!-- Location & Facilities Section -->
                    <div class="mb-4">
                        <h5 class="mb-3">Location & Facilities</h5>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Floor Number</label>
                                <input type="number" name="floor_number" class="form-control" min="1" value="1" placeholder="Floor number">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Monthly Fee (₹)</label>
                                <input type="number" name="room_fee" class="form-control" min="0" step="0.01" placeholder="0.00">
                            </div>
                        </div>
                    </div>

                    <!-- Settings Section -->
                    <div class="mb-4">
                        <h5 class="mb-3">Settings</h5>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="active" selected>Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>Save Room
                        </button>
                        <a href="/hostel/rooms" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Help Panel -->
    <div class="col-lg-4">
        <div class="card bg-light">
            <div class="card-body">
                <h6 class="card-title"><i class="bi bi-info-circle me-2"></i>Room Information</h6>
                <ul class="small text-muted">
                    <li><strong>Room Number:</strong> Unique identifier (e.g., A-101)</li>
                    <li><strong>Room Type:</strong> Single (1 student), Double (2), Triple (3), Quad (4)</li>
                    <li><strong>Capacity:</strong> Maximum students allowed</li>
                    <li><strong>Floor:</strong> Which floor is the room on</li>
                    <li><strong>Rent:</strong> Monthly rent per room</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../layouts/footer.php'; ?>
