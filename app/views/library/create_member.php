<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-person-plus me-2"></i>Add Library Member</h2>
    <a href="/library/members" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back to Members
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Library Membership Form</h5>
            </div>
            <div class="card-body">
                <?php if (empty($users)): ?>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>No Available Users</strong><br>
                        All users in the system are already library members. To add a new member, please create a new user account first.
                    </div>
                    <a href="/users/create" class="btn btn-primary">
                        <i class="bi bi-person-plus me-2"></i>Create New User
                    </a>
                <?php else: ?>
                    <form method="POST" action="/library/members">
                        <?= csrf_field() ?>
                        
                        <div class="mb-3">
                            <label class="form-label">Select User <span class="text-danger">*</span></label>
                            <select name="user_id" class="form-select" required>
                                <option value="">Choose a user...</option>
                                <?php foreach ($users as $user): ?>
                                    <option value="<?= $user['id'] ?>">
                                        <?= htmlspecialchars($user['name']) ?> 
                                        (<?= htmlspecialchars($user['email']) ?>) 
                                        - <?= htmlspecialchars($user['role_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <small class="form-text text-muted">
                                Select from users who are not already library members.
                            </small>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Membership Type <span class="text-danger">*</span></label>
                                <select name="membership_type" class="form-select" required>
                                    <option value="">Select type...</option>
                                    <option value="student">Student</option>
                                    <option value="standard">Standard</option>
                                    <option value="premium">Premium</option>
                                </select>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Member Number</label>
                                <input type="text" name="member_number" class="form-control" 
                                       placeholder="Leave blank for auto-generation">
                                <small class="form-text text-muted">Auto-generated if left empty</small>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Join Date <span class="text-danger">*</span></label>
                                <input type="date" name="join_date" class="form-control" 
                                       value="<?= date('Y-m-d') ?>" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Expiry Date</label>
                                <input type="date" name="expiry_date" class="form-control" 
                                       value="<?= date('Y-m-d', strtotime('+1 year')) ?>">
                                <small class="form-text text-muted">Leave blank for no expiry</small>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Maximum Books <span class="text-danger">*</span></label>
                                <input type="number" name="max_books" class="form-control" 
                                       value="3" min="1" max="10" required>
                                <small class="form-text text-muted">Number of books user can borrow</small>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status <span class="text-danger">*</span></label>
                                <select name="status" class="form-select" required>
                                    <option value="active" selected>Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Notes</label>
                            <textarea name="notes" class="form-control" rows="3" 
                                      placeholder="Any special notes about this membership..."></textarea>
                        </div>
                        
                        <hr class="my-4">
                        
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Add Member
                            </button>
                            <a href="/library/members" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-info-circle me-2"></i>Membership Types</h6>
            </div>
            <div class="card-body">
                <p class="mb-2"><strong>Student:</strong><br>
                   <small class="text-muted">For enrolled students. Limited borrowing period.</small>
                </p>
                <p class="mb-2"><strong>Standard:</strong><br>
                   <small class="text-muted">For staff and regular members. Standard benefits.</small>
                </p>
                <p class="mb-0"><strong>Premium:</strong><br>
                   <small class="text-muted">Extended borrowing period and higher book limits.</small>
                </p>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-lightbulb me-2"></i>Tips</h6>
            </div>
            <div class="card-body">
                <ul class="small mb-0">
                    <li>Member numbers are auto-generated if not specified</li>
                    <li>Set expiry date to control membership duration</li>
                    <li>Adjust max books based on membership type</li>
                    <li>Users can only have one library membership</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
