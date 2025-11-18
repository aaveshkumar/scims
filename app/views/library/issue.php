<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2><i class="bi bi-arrow-left-right me-2"></i>Issue/Return Books</h2>
        <p class="text-muted mb-0">Manage book issuance and returns</p>
    </div>
    <a href="/library/books" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back to Books
    </a>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h6 class="card-subtitle mb-2 opacity-75">Total Issued</h6>
                <h3 class="card-title mb-0"><?php echo $stats['total_issued']; ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h6 class="card-subtitle mb-2 opacity-75">Total Returned</h6>
                <h3 class="card-title mb-0"><?php echo $stats['total_returned']; ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <h6 class="card-subtitle mb-2 opacity-75">Overdue</h6>
                <h3 class="card-title mb-0"><?php echo $stats['overdue_count']; ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-dark">
            <div class="card-body">
                <h6 class="card-subtitle mb-2">Pending Fines</h6>
                <h3 class="card-title mb-0">Rs. <?php echo number_format($stats['total_fines'], 2); ?></h3>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bi bi-box-arrow-right me-2"></i>Issue Book</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="/library/issue">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    
                    <div class="mb-3">
                        <label for="user_id" class="form-label">Library Member <span class="text-danger">*</span></label>
                        <select class="form-select" id="user_id" name="user_id" required>
                            <option value="">Select Member</option>
                            <?php foreach ($members as $member): ?>
                                <option value="<?php echo $member['user_id']; ?>">
                                    <?php echo htmlspecialchars($member['name']); ?> 
                                    (<?php echo htmlspecialchars($member['member_number']); ?>) - 
                                    <?php echo htmlspecialchars($member['user_role']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="book_id" class="form-label">Book <span class="text-danger">*</span></label>
                        <select class="form-select" id="book_id" name="book_id" required>
                            <option value="">Select Book</option>
                            <?php foreach ($availableBooks as $book): ?>
                                <option value="<?php echo $book['id']; ?>">
                                    <?php echo htmlspecialchars($book['title']); ?> - 
                                    <?php echo htmlspecialchars($book['author']); ?>
                                    (Available: <?php echo $book['available_copies']; ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="issue_date" class="form-label">Issue Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="issue_date" name="issue_date" 
                               value="<?php echo date('Y-m-d'); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="due_date" class="form-label">Due Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="due_date" name="due_date" 
                               value="<?php echo date('Y-m-d', strtotime('+14 days')); ?>" required>
                        <small class="text-muted">Default: 14 days from issue date</small>
                    </div>

                    <div class="mb-3">
                        <label for="remarks" class="form-label">Remarks (Optional)</label>
                        <textarea class="form-control" id="remarks" name="remarks" rows="2" 
                                  placeholder="Any special notes..."></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-check-circle me-2"></i>Issue Book
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-box-arrow-in-left me-2"></i>Return Book</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="/library/return">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    
                    <div class="mb-3">
                        <label for="issue_id" class="form-label">Issued Record <span class="text-danger">*</span></label>
                        <select class="form-select" id="issue_id" name="issue_id" required>
                            <option value="">Select Issued Record</option>
                            <?php 
                            $issuedBooks = array_filter($issues, function($i) { return $i['status'] == 'issued'; });
                            foreach ($issuedBooks as $issue): 
                                $isOverdue = strtotime($issue['due_date']) < time();
                            ?>
                                <option value="<?php echo $issue['id']; ?>">
                                    <?php echo htmlspecialchars($issue['user_name']); ?> - 
                                    <?php echo htmlspecialchars($issue['book_title']); ?>
                                    (Due: <?php echo date('M d', strtotime($issue['due_date'])); ?>)
                                    <?php echo $isOverdue ? ' - OVERDUE' : ''; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="alert alert-info small">
                        <strong><i class="bi bi-info-circle me-1"></i>Note:</strong> Fine of Rs. 5 per day will be automatically calculated for overdue returns
                    </div>

                    <button type="submit" class="btn btn-success w-100">
                        <i class="bi bi-check-circle me-2"></i>Return Book
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Filter and Tabs -->
<div class="card mb-4">
    <div class="card-body">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link <?php echo empty($filters['status']) ? 'active' : ''; ?>" 
                   href="/library/issue">All Issues</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($filters['status'] ?? '') == 'issued' ? 'active' : ''; ?>" 
                   href="/library/issue?status=issued">Currently Issued</a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo ($filters['status'] ?? '') == 'returned' ? 'active' : ''; ?>" 
                   href="/library/issue?status=returned">Returned</a>
            </li>
        </ul>
    </div>
</div>

<!-- Overdue Books Alert -->
<?php if (!empty($overdueIssues)): ?>
    <div class="alert alert-danger">
        <h6 class="alert-heading"><i class="bi bi-exclamation-triangle me-2"></i>Overdue Books (<?php echo count($overdueIssues); ?>)</h6>
        <ul class="mb-0">
            <?php foreach (array_slice($overdueIssues, 0, 5) as $overdue): ?>
                <li>
                    <strong><?php echo htmlspecialchars($overdue['user_name']); ?></strong> - 
                    <?php echo htmlspecialchars($overdue['book_title']); ?> 
                    (Due: <?php echo date('M d, Y', strtotime($overdue['due_date'])); ?>)
                </li>
            <?php endforeach; ?>
            <?php if (count($overdueIssues) > 5): ?>
                <li class="text-muted">...and <?php echo count($overdueIssues) - 5; ?> more</li>
            <?php endif; ?>
        </ul>
    </div>
<?php endif; ?>

<!-- Issues Table -->
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Book Issues</h5>
        <form method="GET" class="d-flex gap-2">
            <input type="text" name="search" class="form-control form-control-sm" style="width: 250px;"
                   placeholder="Search..." value="<?php echo htmlspecialchars($filters['search'] ?? ''); ?>">
            <button type="submit" class="btn btn-sm btn-primary">Search</button>
        </form>
    </div>
    <div class="card-body">
        <?php if (empty($issues)): ?>
            <div class="text-center text-muted py-5">
                <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                <h5>No issues found</h5>
                <p>Start by issuing books to library members</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Member</th>
                            <th>Book</th>
                            <th>Issue Date</th>
                            <th>Due Date</th>
                            <th>Return Date</th>
                            <th>Fine</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($issues as $issue): 
                            $isOverdue = ($issue['status'] == 'issued' && strtotime($issue['due_date']) < time());
                        ?>
                            <tr class="<?php echo $isOverdue ? 'table-danger' : ''; ?>">
                                <td><?php echo $issue['id']; ?></td>
                                <td>
                                    <strong><?php echo htmlspecialchars($issue['user_name']); ?></strong><br>
                                    <small class="text-muted"><?php echo htmlspecialchars($issue['user_email']); ?></small>
                                </td>
                                <td>
                                    <strong><?php echo htmlspecialchars($issue['book_title']); ?></strong><br>
                                    <small class="text-muted"><?php echo htmlspecialchars($issue['author']); ?></small>
                                </td>
                                <td><?php echo date('M d, Y', strtotime($issue['issue_date'])); ?></td>
                                <td>
                                    <?php echo date('M d, Y', strtotime($issue['due_date'])); ?>
                                    <?php if ($isOverdue): ?>
                                        <br><span class="badge bg-danger">OVERDUE</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($issue['return_date']): ?>
                                        <?php echo date('M d, Y', strtotime($issue['return_date'])); ?>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($issue['fine_amount'] > 0): ?>
                                        <span class="badge bg-warning">Rs. <?php echo number_format($issue['fine_amount'], 2); ?></span>
                                        <?php if (!$issue['fine_paid']): ?>
                                            <br><small class="text-danger">Unpaid</small>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($issue['status'] == 'issued'): ?>
                                        <span class="badge bg-primary">Issued</span>
                                    <?php else: ?>
                                        <span class="badge bg-success">Returned</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($issue['status'] == 'issued'): ?>
                                        <form method="POST" action="/library/return" style="display: inline;">
                                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                            <input type="hidden" name="issue_id" value="<?php echo $issue['id']; ?>">
                                            <button type="submit" class="btn btn-sm btn-success" 
                                                    onclick="return confirm('Mark this book as returned?');">
                                                <i class="bi bi-box-arrow-in-left"></i> Return
                                            </button>
                                        </form>
                                    <?php elseif ($issue['fine_amount'] > 0 && !$issue['fine_paid']): ?>
                                        <form method="POST" action="/library/pay-fine" style="display: inline;">
                                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                            <input type="hidden" name="issue_id" value="<?php echo $issue['id']; ?>">
                                            <button type="submit" class="btn btn-sm btn-warning">
                                                <i class="bi bi-cash"></i> Pay Fine
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
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
