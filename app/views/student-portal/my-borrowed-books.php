<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="mb-4">
    <h2><i class="bi bi-bookmark-fill me-2"></i>My Borrowed Books</h2>
</div>

<ul class="nav nav-tabs mb-3" role="tablist">
    <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#currently-borrowed">Currently Borrowed</a></li>
    <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#returned">Return History</a></li>
</ul>

<div class="tab-content">
    <div id="currently-borrowed" class="tab-pane fade show active">
        <?php if (empty($borrowed)): ?>
            <div class="alert alert-info">You haven't borrowed any books yet</div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Book Title</th>
                            <th>Author</th>
                            <th>Issue Date</th>
                            <th>Due Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($borrowed as $book): ?>
                            <tr>
                                <td><?= htmlspecialchars($book['title']) ?></td>
                                <td><?= htmlspecialchars($book['author']) ?></td>
                                <td><?= date('M d, Y', strtotime($book['issue_date'])) ?></td>
                                <td>
                                    <strong class="<?= strtotime($book['due_date']) < time() ? 'text-danger' : '' ?>">
                                        <?= date('M d, Y', strtotime($book['due_date'])) ?>
                                    </strong>
                                </td>
                                <td>
                                    <?php if (strtotime($book['due_date']) < time()): ?>
                                        <span class="badge bg-danger">Overdue</span>
                                    <?php else: ?>
                                        <span class="badge bg-success">On Time</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <div id="returned" class="tab-pane fade">
        <?php if (empty($returned)): ?>
            <div class="alert alert-info">No returned books yet</div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Book Title</th>
                            <th>Author</th>
                            <th>Returned Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($returned as $book): ?>
                            <tr>
                                <td><?= htmlspecialchars($book['title']) ?></td>
                                <td><?= htmlspecialchars($book['author']) ?></td>
                                <td><?= date('M d, Y', strtotime($book['return_date'])) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
