<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Question Bank</h1>
    <a href="/question-bank/create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Add Question
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">All Questions</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Question</th>
                        <th>Subject</th>
                        <th>Type</th>
                        <th>Difficulty</th>
                        <th>Marks</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="bi bi-question-circle fs-1 d-block mb-2"></i>
                            No questions available. Click "Add Question" to create one.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
