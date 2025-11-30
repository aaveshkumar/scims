<?php include __DIR__ . '/../../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-pencil me-2"></i>Edit Visitor</h2>
    <a href="/hostel/visitors" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back to Visitors
    </a>
</div>

<form method="POST" action="/hostel/visitors/<?= $visitor['id'] ?>" class="card">
    <?= csrf_field() ?>
    
    <div class="card-body">
        <!-- Resident & Visitor Info -->
        <div class="row mb-4">
            <div class="col-md-6">
                <h6 class="text-muted mb-3">Visitor Information</h6>
                
                <div class="mb-3">
                    <label for="visitor_name" class="form-label">Visitor Name *</label>
                    <input type="text" id="visitor_name" name="visitor_name" class="form-control" value="<?= htmlspecialchars($visitor['visitor_name']) ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="visitor_phone" class="form-label">Phone Number</label>
                    <input type="tel" id="visitor_phone" name="visitor_phone" class="form-control" value="<?= htmlspecialchars($visitor['visitor_phone'] ?? '') ?>">
                </div>
                
                <div class="mb-3">
                    <label for="visitor_id_proof" class="form-label">ID Proof</label>
                    <input type="text" id="visitor_id_proof" name="visitor_id_proof" class="form-control" value="<?= htmlspecialchars($visitor['visitor_id_proof'] ?? '') ?>" placeholder="e.g., PAN, Aadhaar">
                </div>
            </div>
            
            <div class="col-md-6">
                <h6 class="text-muted mb-3">Resident & Purpose</h6>
                
                <div class="mb-3">
                    <label for="resident_id" class="form-label">Select Resident *</label>
                    <select id="resident_id" name="resident_id" class="form-select" required>
                        <option value="">-- Choose a Resident --</option>
                        <?php foreach ($residents as $resident): ?>
                            <option value="<?= $resident['id'] ?>" <?= $resident['id'] == $visitor['resident_id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($resident['first_name'] . ' ' . $resident['last_name']) ?> (<?= $resident['room_number'] ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label for="purpose" class="form-label">Purpose of Visit</label>
                    <input type="text" id="purpose" name="purpose" class="form-control" value="<?= htmlspecialchars($visitor['purpose'] ?? '') ?>" placeholder="e.g., Regular visit, Birthday">
                </div>
            </div>
        </div>

        <!-- Visit Dates & Times -->
        <div class="row mb-4">
            <div class="col-md-12">
                <h6 class="text-muted mb-3">Visit Schedule</h6>
            </div>
            
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="visit_date" class="form-label">Visit Date *</label>
                    <input type="date" id="visit_date" name="visit_date" class="form-control" value="<?= $visitor['visit_date'] ?>" required>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="mb-3">
                    <label for="entry_time" class="form-label">Entry Time *</label>
                    <input type="time" id="entry_time" name="entry_time" class="form-control" value="<?= substr($visitor['entry_time'], 0, 5) ?>" required>
                </div>
            </div>
            
            <div class="col-md-3">
                <div class="mb-3">
                    <label for="exit_time" class="form-label">Exit Time</label>
                    <input type="time" id="exit_time" name="exit_time" class="form-control" value="<?= $visitor['exit_time'] ? substr($visitor['exit_time'], 0, 5) : '' ?>">
                </div>
            </div>
        </div>
    </div>
    
    <div class="card-footer bg-light">
        <button type="submit" class="btn btn-success">
            <i class="bi bi-check-circle me-2"></i>Update Visitor
        </button>
        <a href="/hostel/visitors" class="btn btn-secondary">
            <i class="bi bi-x-circle me-2"></i>Cancel
        </a>
    </div>
</form>

<?php include __DIR__ . '/../../layouts/footer.php'; ?>
