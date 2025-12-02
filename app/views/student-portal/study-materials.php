<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="mb-4">
    <h2><i class="bi bi-book-fill me-2"></i>Study Materials</h2>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="/student-portal/materials">
            <div class="row">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="Search materials..." value="<?= htmlspecialchars($search ?? '') ?>">
                </div>
                <div class="col-md-4">
                    <select name="subject" class="form-select">
                        <option value="">All Subjects</option>
                        <?php foreach ($subjects as $subj): ?>
                            <option value="<?= $subj['id'] ?>" <?= $subject == $subj['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($subj['name']) ?>
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

<?php if (empty($materials)): ?>
    <div class="alert alert-info">No study materials available</div>
<?php else: ?>
    <div class="row">
        <?php foreach ($materials as $material): ?>
            <div class="col-md-6 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($material['title']) ?></h5>
                        <p class="card-text text-muted"><?= htmlspecialchars($material['subject_name']) ?></p>
                        <p class="card-text"><?= htmlspecialchars(substr($material['content'] ?? '', 0, 100)) ?>...</p>
                        <div class="text-muted small">Posted: <?= date('M d, Y', strtotime($material['created_at'])) ?></div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
