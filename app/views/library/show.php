<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2><i class="bi bi-book me-2"></i><?php echo htmlspecialchars($book['title']); ?></h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/library/books">Library</a></li>
                <li class="breadcrumb-item active">Book Details</li>
            </ol>
        </nav>
    </div>
    <div>
        <a href="/library/books/<?php echo $book['id']; ?>/edit" class="btn btn-warning">
            <i class="bi bi-pencil me-2"></i>Edit
        </a>
        <a href="/library/books" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Book Information</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-1 text-muted small">Title</p>
                        <p class="fw-bold"><?php echo htmlspecialchars($book['title']); ?></p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1 text-muted small">Author</p>
                        <p class="fw-bold"><?php echo htmlspecialchars($book['author']); ?></p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-1 text-muted small">ISBN</p>
                        <p><?php echo htmlspecialchars($book['isbn'] ?? 'Not available'); ?></p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1 text-muted small">Publisher</p>
                        <p><?php echo htmlspecialchars($book['publisher'] ?? 'Not available'); ?></p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <p class="mb-1 text-muted small">Publication Year</p>
                        <p><?php echo $book['publication_year'] ?? 'N/A'; ?></p>
                    </div>
                    <div class="col-md-4">
                        <p class="mb-1 text-muted small">Category</p>
                        <p><span class="badge bg-info"><?php echo htmlspecialchars($book['category'] ?? 'General'); ?></span></p>
                    </div>
                    <div class="col-md-4">
                        <p class="mb-1 text-muted small">Price</p>
                        <p>Rs. <?php echo number_format($book['price'] ?? 0, 2); ?></p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-1 text-muted small">Shelf Location</p>
                        <p><?php echo htmlspecialchars($book['location'] ?? 'Not assigned'); ?></p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1 text-muted small">Status</p>
                        <p>
                            <?php if ($book['status'] == 'active'): ?>
                                <span class="badge bg-success">Active</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">Inactive</span>
                            <?php endif; ?>
                        </p>
                    </div>
                </div>

                <?php if (!empty($book['description'])): ?>
                    <div class="mb-0">
                        <p class="mb-1 text-muted small">Description</p>
                        <p><?php echo nl2br(htmlspecialchars($book['description'])); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Issue History -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Issue History</h5>
            </div>
            <div class="card-body">
                <?php if (empty($issues)): ?>
                    <p class="text-muted text-center py-4">No issue history available</p>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-hover table-sm">
                            <thead class="table-light">
                                <tr>
                                    <th>Member</th>
                                    <th>Issue Date</th>
                                    <th>Due Date</th>
                                    <th>Return Date</th>
                                    <th>Fine</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($issues as $issue): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($issue['user_name']); ?></td>
                                        <td><?php echo date('M d, Y', strtotime($issue['issue_date'])); ?></td>
                                        <td><?php echo date('M d, Y', strtotime($issue['due_date'])); ?></td>
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
                                            <?php else: ?>
                                                <span class="text-muted">-</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($issue['status'] == 'issued'): ?>
                                                <span class="badge bg-warning">Issued</span>
                                            <?php else: ?>
                                                <span class="badge bg-success">Returned</span>
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
    </div>

    <div class="col-lg-4">
        <div class="card bg-primary text-white mb-3">
            <div class="card-body text-center">
                <h6 class="card-subtitle mb-2 opacity-75">Total Copies</h6>
                <h2 class="card-title mb-0"><?php echo $book['total_copies']; ?></h2>
            </div>
        </div>

        <div class="card bg-success text-white mb-3">
            <div class="card-body text-center">
                <h6 class="card-subtitle mb-2 opacity-75">Available</h6>
                <h2 class="card-title mb-0"><?php echo $book['available_copies']; ?></h2>
            </div>
        </div>

        <div class="card bg-warning text-dark mb-3">
            <div class="card-body text-center">
                <h6 class="card-subtitle mb-2">Currently Issued</h6>
                <h2 class="card-title mb-0"><?php echo $book['total_copies'] - $book['available_copies']; ?></h2>
            </div>
        </div>

        <div class="card bg-light">
            <div class="card-body">
                <h6 class="card-title"><i class="bi bi-clock me-2"></i>Timestamps</h6>
                <ul class="list-unstyled mb-0 small">
                    <li class="mb-2">
                        <strong>Added:</strong><br>
                        <?php echo date('M d, Y h:i A', strtotime($book['created_at'])); ?>
                    </li>
                    <li class="mb-0">
                        <strong>Last Updated:</strong><br>
                        <?php echo date('M d, Y h:i A', strtotime($book['updated_at'])); ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
