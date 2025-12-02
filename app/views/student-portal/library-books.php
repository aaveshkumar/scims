<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="mb-4">
    <h2><i class="bi bi-book me-2"></i>Library - Available Books</h2>
    <p class="text-muted">Browse and borrow books from our library</p>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="/student-portal/library/books">
            <div class="row">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="Search by title or author..." value="<?= htmlspecialchars($search ?? '') ?>">
                </div>
                <div class="col-md-4">
                    <select name="category" class="form-select">
                        <option value="">All Categories</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= htmlspecialchars($cat['category']) ?>" <?= ($category === $cat['category']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['category']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Search</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <?php if (empty($books)): ?>
        <div class="col-12">
            <div class="alert alert-info">No books available at the moment</div>
        </div>
    <?php else: ?>
        <?php foreach ($books as $book): ?>
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($book['title']) ?></h5>
                        <p class="card-text text-muted"><?= htmlspecialchars($book['author']) ?></p>
                        <div class="mb-2">
                            <span class="badge bg-info"><?= htmlspecialchars($book['category'] ?? 'General') ?></span>
                            <span class="badge bg-success"><?= $book['available_copies'] ?> Available</span>
                        </div>
                        <p class="text-sm text-muted"><?= htmlspecialchars(substr($book['description'] ?? '', 0, 100)) ?>...</p>
                    </div>
                    <div class="card-footer bg-white">
                        <form method="POST" action="/student-portal/library/request-book" class="d-inline">
                            <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                            <input type="hidden" name="book_id" value="<?= $book['id'] ?>">
                            <button type="submit" class="btn btn-sm btn-primary">
                                <i class="bi bi-bookmark me-1"></i>Request Book
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
