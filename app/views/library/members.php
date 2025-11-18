<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2><i class="bi bi-people me-2"></i>Library Members</h2>
        <p class="text-muted mb-0">Manage library membership</p>
    </div>
    <a href="/library/members/create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Add Member
    </a>
</div>

<!-- Statistics -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h6 class="card-subtitle mb-2 opacity-75">Active Members</h6>
                <h3 class="card-title mb-0"><?php echo $stats['total_members']; ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-warning text-dark">
            <div class="card-body">
                <h6 class="card-subtitle mb-2">Expiring Soon</h6>
                <h3 class="card-title mb-0"><?php echo $stats['expiring_soon']; ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <h6 class="card-subtitle mb-2 opacity-75">Expired</h6>
                <h3 class="card-title mb-0"><?php echo $stats['expired_members']; ?></h3>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="/library/members">
            <div class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" 
                           placeholder="Search by name, email, or member number..." 
                           value="<?php echo htmlspecialchars($filters['search'] ?? ''); ?>">
                </div>
                <div class="col-md-3">
                    <select name="membership_type" class="form-select">
                        <option value="">All Types</option>
                        <option value="standard" <?php echo ($filters['membership_type'] ?? '') == 'standard' ? 'selected' : ''; ?>>Standard</option>
                        <option value="premium" <?php echo ($filters['membership_type'] ?? '') == 'premium' ? 'selected' : ''; ?>>Premium</option>
                        <option value="student" <?php echo ($filters['membership_type'] ?? '') == 'student' ? 'selected' : ''; ?>>Student</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="active" <?php echo ($filters['status'] ?? '') == 'active' ? 'selected' : ''; ?>>Active</option>
                        <option value="inactive" <?php echo ($filters['status'] ?? '') == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                        <option value="expired" <?php echo ($filters['status'] ?? '') == 'expired' ? 'selected' : ''; ?>>Expired</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-2"></i>Search
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Members Table -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Library Members</h5>
    </div>
    <div class="card-body">
        <?php if (empty($members)): ?>
            <div class="text-center text-muted py-5">
                <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                <h5>No members found</h5>
                <p>Start by adding library members</p>
                <a href="/library/members/create" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Add First Member
                </a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Member #</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Type</th>
                            <th>Max Books</th>
                            <th>Join Date</th>
                            <th>Expiry Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($members as $member): 
                            $isExpired = $member['expiry_date'] && strtotime($member['expiry_date']) < time();
                            $isExpiringSoon = $member['expiry_date'] && 
                                             strtotime($member['expiry_date']) < strtotime('+30 days') && 
                                             strtotime($member['expiry_date']) > time();
                        ?>
                            <tr class="<?php echo $isExpired ? 'table-danger' : ($isExpiringSoon ? 'table-warning' : ''); ?>">
                                <td><?php echo $member['id']; ?></td>
                                <td><span class="badge bg-info"><?php echo htmlspecialchars($member['member_number']); ?></span></td>
                                <td>
                                    <strong><?php echo htmlspecialchars($member['name']); ?></strong><br>
                                    <small class="text-muted"><?php echo htmlspecialchars($member['user_role']); ?></small>
                                </td>
                                <td><small><?php echo htmlspecialchars($member['email']); ?></small></td>
                                <td><span class="badge bg-secondary"><?php echo ucfirst($member['membership_type']); ?></span></td>
                                <td><?php echo $member['max_books']; ?></td>
                                <td><?php echo date('M d, Y', strtotime($member['join_date'])); ?></td>
                                <td>
                                    <?php if ($member['expiry_date']): ?>
                                        <?php echo date('M d, Y', strtotime($member['expiry_date'])); ?>
                                        <?php if ($isExpired): ?>
                                            <br><span class="badge bg-danger">Expired</span>
                                        <?php elseif ($isExpiringSoon): ?>
                                            <br><span class="badge bg-warning">Expiring Soon</span>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span class="text-muted">No expiry</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($member['status'] == 'active'): ?>
                                        <span class="badge bg-success">Active</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="/library/members/<?php echo $member['id']; ?>/edit" 
                                           class="btn btn-sm btn-warning" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <?php if ($isExpiringSoon || $isExpired): ?>
                                            <form method="POST" action="/library/members/<?php echo $member['id']; ?>/renew" style="display: inline;">
                                                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                                <button type="submit" class="btn btn-sm btn-success" title="Renew">
                                                    <i class="bi bi-arrow-clockwise"></i>
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
