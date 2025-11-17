<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Lesson Plans</h1>
    <a href="/lesson-plans/create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Create Lesson Plan
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">All Lesson Plans</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Subject</th>
                        <th>Class</th>
                        <th>Topic</th>
                        <th>Date</th>
                        <th>Teacher</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            No lesson plans available. Click "Create Lesson Plan" to add one.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
