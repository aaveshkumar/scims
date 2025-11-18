<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2><i class="bi bi-book-half me-2"></i>Library Management - Books</h2>
        <p class="text-muted mb-0">Manage library books and catalog</p>
    </div>
    <a href="/library/books/create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Add New Book
    </a>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h6 class="card-subtitle mb-2 opacity-75">Total Books</h6>
                <h3 class="card-title mb-0"><?php echo $stats['total_books']; ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h6 class="card-subtitle mb-2 opacity-75">Total Copies</h6>
                <h3 class="card-title mb-0"><?php echo $stats['total_copies']; ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h6 class="card-subtitle mb-2 opacity-75">Available</h6>
                <h3 class="card-title mb-0"><?php echo $stats['available_copies']; ?></h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-dark">
            <div class="card-body">
                <h6 class="card-subtitle mb-2">Currently Issued</h6>
                <h3 class="card-title mb-0"><?php echo $stats['issued_books']; ?></h3>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="/library/books">
            <div class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" 
                           placeholder="Search by title, author, or ISBN..." 
                           value="<?php echo htmlspecialchars($filters['search'] ?? ''); ?>">
                </div>
                <div class="col-md-3">
                    <select name="category" class="form-select">
                        <option value="">All Categories</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?php echo htmlspecialchars($cat['category']); ?>" 
                                    <?php echo ($filters['category'] ?? '') == $cat['category'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cat['category']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="active" <?php echo ($filters['status'] ?? '') == 'active' ? 'selected' : ''; ?>>Active</option>
                        <option value="inactive" <?php echo ($filters['status'] ?? '') == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-2"></i>Search
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Books Table -->
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Books Catalog</h5>
    </div>
    <div class="card-body">
        <?php if (empty($books)): ?>
            <div class="text-center text-muted py-5">
                <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                <h5>No books found</h5>
                <p>Start by adding books to your library catalog</p>
                <a href="/library/books/create" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>Add First Book
                </a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>ISBN</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Category</th>
                            <th>Publisher</th>
                            <th>Copies</th>
                            <th>Available</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($books as $book): ?>
                            <tr>
                                <td><?php echo $book['id']; ?></td>
                                <td>
                                    <small class="text-muted"><?php echo htmlspecialchars($book['isbn'] ?? 'N/A'); ?></small>
                                </td>
                                <td>
                                    <strong><?php echo htmlspecialchars($book['title']); ?></strong>
                                </td>
                                <td><?php echo htmlspecialchars($book['author']); ?></td>
                                <td>
                                    <span class="badge bg-info">
                                        <?php echo htmlspecialchars($book['category'] ?? 'General'); ?>
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted"><?php echo htmlspecialchars($book['publisher'] ?? 'N/A'); ?></small>
                                </td>
                                <td>
                                    <span class="badge bg-primary"><?php echo $book['total_copies']; ?></span>
                                </td>
                                <td>
                                    <?php if ($book['available_copies'] > 0): ?>
                                        <span class="badge bg-success"><?php echo $book['available_copies']; ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">0</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($book['status'] == 'active'): ?>
                                        <span class="badge bg-success">Active</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="/library/books/<?php echo $book['id']; ?>" 
                                           class="btn btn-sm btn-info" title="View">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="/library/books/<?php echo $book['id']; ?>/edit" 
                                           class="btn btn-sm btn-warning" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form method="POST" action="/library/books/<?php echo $book['id']; ?>/delete" 
                                              style="display: inline;" 
                                              onsubmit="return confirm('Are you sure you want to delete this book?');">
                                            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
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
