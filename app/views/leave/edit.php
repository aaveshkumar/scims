<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-pencil me-2"></i>Edit Leave Request</h2>
    <a href="/leave" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="/leave/<?= $leave['id'] ?>">
            <?= csrf_field() ?>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Leave Type *</label>
                    <select name="leave_type" class="form-select" required>
                        <option value="">Select Leave Type</option>
                        <option value="sick" <?= ($leave['leave_type'] === 'sick') ? 'selected' : '' ?>>Sick Leave</option>
                        <option value="casual" <?= ($leave['leave_type'] === 'casual') ? 'selected' : '' ?>>Casual Leave</option>
                        <option value="earned" <?= ($leave['leave_type'] === 'earned') ? 'selected' : '' ?>>Earned Leave</option>
                        <option value="maternity" <?= ($leave['leave_type'] === 'maternity') ? 'selected' : '' ?>>Maternity Leave</option>
                        <option value="paternity" <?= ($leave['leave_type'] === 'paternity') ? 'selected' : '' ?>>Paternity Leave</option>
                        <option value="study" <?= ($leave['leave_type'] === 'study') ? 'selected' : '' ?>>Study Leave</option>
                        <option value="other" <?= ($leave['leave_type'] === 'other') ? 'selected' : '' ?>>Other</option>
                    </select>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">Duration (Days) *</label>
                    <input type="number" name="duration" class="form-control" min="1" 
                        value="<?php 
                            $start = new DateTime($leave['start_date']);
                            $end = new DateTime($leave['end_date']);
                            $interval = $start->diff($end);
                            echo $interval->days + 1;
                        ?>" required>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Start Date *</label>
                    <input type="date" name="start_date" class="form-control" 
                        value="<?= $leave['start_date'] ?>" required>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label class="form-label">End Date *</label>
                    <input type="date" name="end_date" class="form-control" 
                        value="<?= $leave['end_date'] ?>" required>
                </div>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Reason for Leave *</label>
                <textarea name="reason" class="form-control" rows="4" required><?= htmlspecialchars($leave['reason']) ?></textarea>
            </div>
            
            <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i>
                You can only edit pending leave requests. Once approved or rejected, requests cannot be modified.
            </div>
            
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Update Request
                </button>
                <a href="/leave" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
