<?php include __DIR__ . '/../../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Add New Resident</h2>
    <a href="/hostel/residents" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="/hostel/residents" class="needs-validation">
                    <?= csrf_field() ?>
                    
                    <!-- Student Selection -->
                    <div class="mb-4">
                        <h5 class="mb-3">Student Information</h5>
                        <div class="mb-3">
                            <label class="form-label">Select Student *</label>
                            <select name="student_id" class="form-select" required>
                                <option value="">Choose a student without hostel</option>
                                <?php foreach ($studentsWithoutHostel as $student): ?>
                                    <option value="<?= $student['id'] ?>">
                                        <?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?> (<?= $student['roll_number'] ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
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
                                        <option value="<?= $hostel['id'] ?>">
                                            <?= htmlspecialchars($hostel['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Room *</label>
                                <select name="room_id" class="form-select" id="room_id" required>
                                    <option value="">Select room from hostel above</option>
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
                                <input type="date" name="admission_date" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Checkout Date</label>
                                <input type="date" name="checkout_date" class="form-control">
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="mb-4">
                        <h5 class="mb-3">Contact Information</h5>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Guardian Contact</label>
                                <input type="tel" name="guardian_contact" class="form-control" placeholder="+91-XXXXXXXXXX">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Emergency Contact</label>
                                <input type="tel" name="emergency_contact" class="form-control" placeholder="Alternate contact">
                            </div>
                        </div>
                    </div>

                    <!-- Settings -->
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
                            <i class="bi bi-check-circle me-2"></i>Add Resident
                        </button>
                        <a href="/hostel/residents" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Help Panel -->
    <div class="col-lg-4">
        <div class="card bg-light">
            <div class="card-body">
                <h6 class="card-title"><i class="bi bi-info-circle me-2"></i>Resident Information</h6>
                <ul class="small text-muted">
                    <li><strong>Student:</strong> Select from available students</li>
                    <li><strong>Hostel:</strong> Choose the hostel first</li>
                    <li><strong>Room:</strong> Then select available room</li>
                    <li><strong>Admission:</strong> Date student checks in</li>
                    <li><strong>Checkout:</strong> Optional checkout date</li>
                </ul>
            </div>
        </div>
    </div>
</div>

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
    roomSelect.innerHTML = '<option value="">Select room</option>';
    
    if (hostelId && rooms[hostelId]) {
        rooms[hostelId].forEach(room => {
            const option = document.createElement('option');
            option.value = room.id;
            option.textContent = room.room_number + ' (' + room.room_type + ')';
            roomSelect.appendChild(option);
        });
    }
}
</script>

<?php include __DIR__ . '/../../layouts/footer.php'; ?>
