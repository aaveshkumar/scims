<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Academic Calendar</h1>
    <a href="/academic-calendar/create" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Add Event
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Academic Year 2025-2026</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Event</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            <i class="bi bi-calendar3 fs-1 d-block mb-2"></i>
                            No events scheduled. Click "Add Event" to create one.
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
