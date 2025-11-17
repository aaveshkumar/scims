<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Leave Management</h1>
    <a href="/leaves/create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Apply for Leave
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Leave Applications</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Employee</th>
                        <th>Leave Type</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Days</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="bi bi-calendar-x fs-1 d-block mb-2"></i>
                            No leave applications. Click "Apply for Leave" to submit one.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
