<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-calendar-x me-2"></i>Request Leave</h2>
    <a href="/leave" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="/leave">
            <?= csrf_field() ?>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Leave Type *</label>
                    <select name="leave_type" class="form-select" required>
                        <option value="">Select Leave Type</option>
                        <option value="sick">Sick Leave</option>
                        <option value="casual">Casual Leave</option>
                        <option value="earned">Earned Leave</option>
                        <option value="maternity">Maternity Leave</option>
                        <option value="paternity">Paternity Leave</option>
                        <option value="study">Study Leave</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Duration (Days) *</label>
                    <input type="number" name="duration" class="form-control" min="1" required>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Start Date *</label>
                    <input type="date" name="start_date" class="form-control" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">End Date *</label>
                    <input type="date" name="end_date" class="form-control" required>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Reason for Leave *</label>
                <textarea name="reason" class="form-control" rows="4" placeholder="Please provide details about your leave request..." required></textarea>
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Submit Request
                </button>
                <a href="/leave" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>