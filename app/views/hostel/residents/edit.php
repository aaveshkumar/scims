<?php include __DIR__ . '/../../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Edit Resident</h2>
    <a href="/hostel/residents" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="/hostel/residents/<?= $resident['id'] ?>" class="needs-validation">
                    <?= csrf_field() ?>
                    
                    <!-- Student Information -->
                    <div class="mb-4">
                        <h5 class="mb-3">Student Information</h5>
                        <div class="mb-3">
                            <label class="form-label">Student</label>
                            <input type="text" class="form-control" value="<?= htmlspecialchars($resident['first_name'] . ' ' . $resident['last_name']) ?> (<?= $resident['roll_number'] ?>)" disabled>
                            <small class="text-muted">Cannot change student assignment</small>
                        </div>
                    </div>

                    <!-- Room Assignment -->
                    <div class="mb-4">
                        <h5 class="mb-3">Room Assignment</h5>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Hostel *</label>
                                <select name="hostel_id" class="form-select" id="hostel_id" required onchange="updateRooms()">
                                    <option value="">Select Hostel</option>
                                    <?php foreach ($hostels as $hostel): ?>
                                        <option value="<?= $hostel['id'] ?>" <?= $hostel['id'] == $resident['hostel_id'] ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($hostel['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Room *</label>
                                <select name="room_id" class="form-select" id="room_id" required>
                                    <option value="">Select room from hostel above</option>
                                    <?php 
                                    $currentRoomId = $resident['room_id'];
                                    foreach ($availableRooms as $room): 
                                        if ($room['id'] == $currentRoomId || $room['hostel_id'] == $resident['hostel_id']):
                                    ?>
                                        <option value="<?= $room['id'] ?>" <?= $room['id'] == $currentRoomId ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($room['room_number'] . ' (' . $room['room_type'] . ')') ?>
                                        </option>
                                    <?php 
                                        endif;
                                    endforeach; 
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Dates Section -->
                    <div class="mb-4">
                        <h5 class="mb-3">Duration</h5>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Admission Date *</label>
                                <input type="date" name="admission_date" class="form-control" value="<?= $resident['admission_date'] ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Checkout Date</label>
                                <input type="date" name="checkout_date" class="form-control" value="<?= $resident['checkout_date'] ?? '' ?>">
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="mb-4">
                        <h5 class="mb-3">Contact Information</h5>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Guardian Contact</label>
                                <input type="tel" name="guardian_contact" class="form-control" placeholder="+91-XXXXXXXXXX" value="<?= $resident['guardian_contact'] ?? '' ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Emergency Contact</label>
                                <input type="tel" name="emergency_contact" class="form-control" placeholder="Alternate contact" value="<?= $resident['emergency_contact'] ?? '' ?>">
                            </div>
                        </div>
                    </div>

                    <!-- Settings -->
                    <div class="mb-4">
                        <h5 class="mb-3">Settings</h5>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="active" <?= ($resident['status'] ?? 'active') == 'active' ? 'selected' : '' ?>>Active</option>
                                <option value="inactive" <?= ($resident['status'] ?? 'active') == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                            </select>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle me-2"></i>Update Resident
                        </button>
                        <a href="/hostel/residents" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Help Panel -->
    <div class="col-lg-4">
        <div class="card bg-light" style="background-color: inherit !important;">
            <div class="card-body">
                <h6 class="card-title"><i class="bi bi-info-circle me-2"></i>Edit Resident</h6>
                <ul class="small text-muted">
                    <li><strong>Student:</strong> Fixed, cannot change</li>
                    <li><strong>Hostel:</strong> Change hostel if needed</li>
                    <li><strong>Room:</strong> Select new room from hostel</li>
                    <li><strong>Admission:</strong> Update admission date</li>
                    <li><strong>Checkout:</strong> Add checkout date to mark inactive</li>
                    <li><strong>Status:</strong> Mark active or inactive</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<style>
    html[data-bs-theme="dark"] .bg-light {
        background-color: #1e1e1e !important;
        border-color: #333 !important;
    }
    
    html[data-bs-theme="dark"] .card {
        background-color: #2d2d2d !important;
        border-color: #444 !important;
    }
</style>

<script>
const rooms = {
    <?php 
    $roomsByHostel = [];
    foreach ($availableRooms as $room) {
        if (!isset($roomsByHostel[$room['hostel_id']])) {
            $roomsByHostel[$room['hostel_id']] = [];
        }
        $roomsByHostel[$room['hostel_id']][] = $room;
    }
    foreach ($roomsByHostel as $hostelId => $roomList) {
        echo "$hostelId: " . json_encode($roomList) . ",";
    }
    ?>
};

function updateRooms() {
    const hostelId = document.getElementById('hostel_id').value;
    const roomSelect = document.getElementById('room_id');
    const currentRoomId = '<?= $resident['room_id'] ?>';
    roomSelect.innerHTML = '<option value="">Select room</option>';
    
    if (hostelId && rooms[hostelId]) {
        rooms[hostelId].forEach(room => {
            const option = document.createElement('option');
            option.value = room.id;
            option.textContent = room.room_number + ' (' + room.room_type + ')';
            if (room.id == currentRoomId) {
                option.selected = true;
            }
            roomSelect.appendChild(option);
        });
    }
}

// Initialize rooms on page load
document.addEventListener('DOMContentLoaded', function() {
    updateRooms();
});
</script>

<?php include __DIR__ . '/../../layouts/footer.php'; ?>
