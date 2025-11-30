<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Forum Details</h1>
        <p class="text-muted mb-0">Discussion forum information</p>
    </div>
    <div>
        <a href="/forums/<?= $id ?>/edit" class="btn btn-warning me-2">
            <i class="bi bi-pencil me-2"></i>Edit
        </a>
        <form method="POST" action="/forums/<?= $id ?>/delete" style="display: inline;" onsubmit="return confirm('Delete this forum?');">
            <input type="hidden" name="_token" value="<?= csrf() ?>">
            <button type="submit" class="btn btn-danger me-2">
                <i class="bi bi-trash me-2"></i>Delete
            </button>
        </form>
        <a href="/forums" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <h5>Forum Information</h5>
        <hr>
        <p><strong>ID:</strong> <?= htmlspecialchars($id) ?></p>
        <p class="text-muted">Forum details and discussion information will appear here once the forum is created.</p>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
