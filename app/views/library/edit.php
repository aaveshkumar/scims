<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="mb-4">
    <h2><i class="bi bi-pencil me-2"></i>Edit Book</h2>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/library/books">Library</a></li>
            <li class="breadcrumb-item active">Edit Book</li>
        </ol>
    </nav>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Book Information</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="/library/books/<?php echo $book['id']; ?>">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <input type="hidden" name="_method" value="PUT">
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="title" name="title" 
                                   value="<?php echo htmlspecialchars($book['title']); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="author" class="form-label">Author <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="author" name="author" 
                                   value="<?php echo htmlspecialchars($book['author']); ?>" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="isbn" class="form-label">ISBN</label>
                            <input type="text" class="form-control" id="isbn" name="isbn" 
                                   value="<?php echo htmlspecialchars($book['isbn'] ?? ''); ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="publisher" class="form-label">Publisher</label>
                            <input type="text" class="form-control" id="publisher" name="publisher" 
                                   value="<?php echo htmlspecialchars($book['publisher'] ?? ''); ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="publication_year" class="form-label">Publication Year</label>
                            <input type="number" class="form-control" id="publication_year" name="publication_year" 
                                   min="1900" max="<?php echo date('Y'); ?>" 
                                   value="<?php echo $book['publication_year'] ?? ''; ?>">
                        </div>
                        <div class="col-md-4">
                            <label for="category" class="form-label">Category</label>
                            <input type="text" class="form-control" id="category" name="category" 
                                   list="categories" value="<?php echo htmlspecialchars($book['category'] ?? ''); ?>">
                            <datalist id="categories">
                                <option value="Fiction">
                                <option value="Non-Fiction">
                                <option value="Science">
                                <option value="Technology">
                                <option value="History">
                                <option value="Biography">
                                <option value="Reference">
                            </datalist>
                        </div>
                        <div class="col-md-4">
                            <label for="price" class="form-label">Price (Rs.)</label>
                            <input type="number" class="form-control" id="price" name="price" 
                                   step="0.01" min="0" value="<?php echo $book['price'] ?? '0'; ?>">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="total_copies" class="form-label">Total Copies <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="total_copies" name="total_copies" 
                                   min="1" value="<?php echo $book['total_copies']; ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label for="available_copies" class="form-label">Available Copies <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="available_copies" name="available_copies" 
                                   min="0" value="<?php echo $book['available_copies']; ?>" required>
                            <small class="text-muted">Cannot exceed total copies</small>
                        </div>
                        <div class="col-md-4">
                            <label for="location" class="form-label">Shelf Location</label>
                            <input type="text" class="form-control" id="location" name="location" 
                                   value="<?php echo htmlspecialchars($book['location'] ?? ''); ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3"><?php echo htmlspecialchars($book['description'] ?? ''); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status">
                            <option value="active" <?php echo ($book['status'] == 'active') ? 'selected' : ''; ?>>Active</option>
                            <option value="inactive" <?php echo ($book['status'] == 'inactive') ? 'selected' : ''; ?>>Inactive</option>
                        </select>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-2"></i>Update Book
                        </button>
                        <a href="/library/books" class="btn btn-secondary">
                            <i class="bi bi-x-circle me-2"></i>Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card bg-light mb-3">
            <div class="card-body">
                <h6 class="card-title"><i class="bi bi-info-circle me-2"></i>Book Status</h6>
                <ul class="list-unstyled mb-0 small">
                    <li class="mb-2"><strong>Created:</strong> <?php echo date('M d, Y', strtotime($book['created_at'])); ?></li>
                    <li class="mb-2"><strong>Last Updated:</strong> <?php echo date('M d, Y', strtotime($book['updated_at'])); ?></li>
                    <li class="mb-2"><strong>Issued Copies:</strong> <?php echo $book['total_copies'] - $book['available_copies']; ?></li>
                </ul>
            </div>
        </div>
        
        <div class="card bg-warning">
            <div class="card-body">
                <h6 class="card-title"><i class="bi bi-exclamation-triangle me-2"></i>Warning</h6>
                <p class="small mb-0">Be careful when reducing total copies. Make sure it doesn't go below currently issued copies.</p>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
