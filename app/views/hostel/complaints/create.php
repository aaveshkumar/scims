<?php include __DIR__ . '/../../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-plus-circle me-2"></i>Add Complaint</h2>
    <a href="/hostel/complaints" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back to Complaints
    </a>
</div>

<form method="POST" action="/hostel/complaints" class="card">
    <?= csrf_field() ?>
    
    <div class="card-body">
        <!-- Hostel & Resident -->
        <div class="row mb-4">
            <div class="col-md-6">
                <h6 class="text-muted mb-3">Hostel & Resident</h6>
                
                <div class="mb-3">
                    <label for="hostel_id" class="form-label">Hostel *</label>
                    <select id="hostel_id" name="hostel_id" class="form-select" required>
                        <option value="">-- Select Hostel --</option>
                        <?php foreach ($hostels as $hostel): ?>
                            <option value="<?= $hostel['id'] ?>">
                                <?= htmlspecialchars($hostel['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label for="resident_id" class="form-label">Resident *</label>
                    <select id="resident_id" name="resident_id" class="form-select" required>
                        <option value="">-- Select Resident --</option>
                        <?php foreach ($residents as $resident): ?>
                            <option value="<?= $resident['id'] ?>">
                                <?= htmlspecialchars($resident['first_name'] . ' ' . $resident['last_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            
            <div class="col-md-6">
                <h6 class="text-muted mb-3">Complaint Details</h6>
                
                <div class="mb-3">
                    <label for="complaint_type" class="form-label">Type</label>
                    <select id="complaint_type" name="complaint_type" class="form-select">
                        <option value="">-- Select Type --</option>
                        <?php foreach ($types as $type): ?>
                            <option value="<?= $type ?>">
                                <?= htmlspecialchars($type) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label for="priority" class="form-label">Priority</label>
                    <select id="priority" name="priority" class="form-select">
                        <option value="medium" selected>Medium</option>
                        <option value="high">High</option>
                        <option value="low">Low</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Assignment -->
        <div class="row mb-4">
            <div class="col-md-6">
                <h6 class="text-muted mb-3">Assignment</h6>
                
                <div class="mb-3">
                    <label for="assigned_to" class="form-label">Assign To</label>
                    <select id="assigned_to" name="assigned_to" class="form-select">
                        <option value="">-- Unassigned --</option>
                        <?php foreach ($staff as $member): ?>
                            <option value="<?= $member['id'] ?>">
                                <?= htmlspecialchars($member['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>

        <!-- Description & Remarks -->
        <div class="row mb-4">
            <div class="col-md-12">
                <h6 class="text-muted mb-3">Description & Remarks</h6>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Description *</label>
                    <textarea id="description" name="description" class="form-control" rows="4" required placeholder="Describe the complaint in detail..."></textarea>
                </div>
                
                <div class="mb-3">
                    <label for="remarks" class="form-label">Remarks</label>
                    <textarea id="remarks" name="remarks" class="form-control" rows="2" placeholder="Additional remarks (optional)..."></textarea>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card-footer bg-light">
        <button type="submit" class="btn btn-success">
            <i class="bi bi-check-circle me-2"></i>Register Complaint
        </button>
        <a href="/hostel/complaints" class="btn btn-secondary">
            <i class="bi bi-x-circle me-2"></i>Cancel
        </a>
    </div>
</form>

<?php include __DIR__ . '/../../layouts/footer.php'; ?>
