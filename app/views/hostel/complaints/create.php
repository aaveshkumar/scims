<?php include __DIR__ . '/../../layouts/header.php'; ?>

<style>
    html[data-bs-theme="dark"] .card-header.bg-light {
        background-color: var(--bs-gray-800) !important;
        color: var(--bs-body-color) !important;
        border-color: var(--bs-border-color) !important;
    }
    
    html[data-bs-theme="dark"] .card-header.bg-light h6 {
        color: var(--bs-body-color) !important;
    }
</style>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-plus-circle me-2"></i>Register New Complaint</h2>
    <a href="/hostel/complaints" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back to Complaints
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <form method="POST" action="/hostel/complaints" class="card">
            <?= csrf_field() ?>
            
            <div class="card-body">
                <!-- Header Info -->
                <div class="alert alert-info" role="alert">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Please fill all required fields.</strong> This information will help us process your complaint efficiently.
                </div>

                <!-- Section 1: Hostel & Resident Information -->
                <div class="card mb-4 border-light">
                    <div class="card-header bg-light">
                        <h6 class="mb-0"><i class="bi bi-building me-2"></i>Hostel & Resident Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
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
                                    <small class="text-muted">Select the hostel where the complaint originated</small>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
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
                                    <small class="text-muted">Select the resident filing this complaint</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Complaint Details -->
                <div class="card mb-4 border-light">
                    <div class="card-header bg-light">
                        <h6 class="mb-0"><i class="bi bi-exclamation-triangle me-2"></i>Complaint Details</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="complaint_type" class="form-label">Complaint Type</label>
                                    <select id="complaint_type" name="complaint_type" class="form-select">
                                        <option value="">-- Select Type --</option>
                                        <option value="Maintenance Issue">Maintenance Issue</option>
                                        <option value="Cleanliness Problem">Cleanliness Problem</option>
                                        <option value="Noise Complaint">Noise Complaint</option>
                                        <option value="Utilities Issue">Utilities Issue</option>
                                        <option value="Safety Concern">Safety Concern</option>
                                        <option value="Other">Other</option>
                                    </select>
                                    <small class="text-muted">Select the category that best describes this complaint</small>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="priority" class="form-label">Priority *</label>
                                    <select id="priority" name="priority" class="form-select" required>
                                        <option value="medium" selected>Medium</option>
                                        <option value="high">High (Urgent)</option>
                                        <option value="low">Low (Can Wait)</option>
                                    </select>
                                    <small class="text-muted">Indicate the urgency level of this complaint</small>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Complaint Description *</label>
                            <textarea id="description" name="description" class="form-control" rows="5" required 
                                placeholder="Please provide detailed description of the complaint...&#10;Example: Ceiling fan in room 201 is not working since yesterday. It makes noise when switched on."></textarea>
                            <small class="text-muted">Be as detailed as possible to help us resolve the issue quickly</small>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Assignment & Remarks -->
                <div class="card mb-4 border-light">
                    <div class="card-header bg-light">
                        <h6 class="mb-0"><i class="bi bi-person-check me-2"></i>Assignment & Additional Info</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="assigned_to" class="form-label">Assign To (Optional)</label>
                                    <select id="assigned_to" name="assigned_to" class="form-select">
                                        <option value="">-- Unassigned --</option>
                                        <?php foreach ($staff as $member): ?>
                                            <option value="<?= $member['id'] ?>">
                                                <?= htmlspecialchars($member['name']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <small class="text-muted">Optionally assign this complaint to a staff member</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="remarks" class="form-label">Initial Remarks</label>
                                    <input type="text" id="remarks" name="remarks" class="form-control" 
                                        placeholder="e.g., Urgent - resident experiencing water leakage">
                                    <small class="text-muted">Add any initial remarks or notes about this complaint</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card-footer bg-light">
                <button type="submit" class="btn btn-success btn-lg">
                    <i class="bi bi-check-circle me-2"></i>Register Complaint
                </button>
                <a href="/hostel/complaints" class="btn btn-secondary btn-lg">
                    <i class="bi bi-x-circle me-2"></i>Cancel
                </a>
            </div>
        </form>
    </div>

    <!-- Sidebar: Instructions -->
    <div class="col-lg-4">
        <div class="card border-info mb-4">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0"><i class="bi bi-question-circle me-2"></i>Complaint Tips</h6>
            </div>
            <div class="card-body small">
                <div class="mb-3">
                    <strong>✓ Be Specific:</strong>
                    <p>Include room number, time, and specific details about the issue</p>
                </div>
                <div class="mb-3">
                    <strong>✓ Set Correct Priority:</strong>
                    <p>Use "High" only for urgent/safety issues</p>
                </div>
                <div class="mb-3">
                    <strong>✓ Keep Records:</strong>
                    <p>Your complaint number will help track progress</p>
                </div>
                <div class="alert alert-warning">
                    <small><strong>Note:</strong> All complaints are logged and tracked until resolved</small>
                </div>
            </div>
        </div>

        <div class="card border-success">
            <div class="card-header bg-success text-white">
                <h6 class="mb-0"><i class="bi bi-check2-circle me-2"></i>Required Fields</h6>
            </div>
            <div class="card-body small">
                <ul class="list-unstyled">
                    <li><i class="bi bi-asterisk text-danger"></i> Hostel</li>
                    <li><i class="bi bi-asterisk text-danger"></i> Resident</li>
                    <li><i class="bi bi-asterisk text-danger"></i> Priority</li>
                    <li><i class="bi bi-asterisk text-danger"></i> Description</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../layouts/footer.php'; ?>
