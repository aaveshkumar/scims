<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Class Details</h1>
    <div>
        <a href="/classes/<?= $class['id'] ?>/edit" class="btn btn-warning">
            <i class="bi bi-pencil me-2"></i>Edit
        </a>
        <a href="/classes" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Class Information</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <p class="mb-1 text-muted">Class Name</p>
                    <h4><?= htmlspecialchars($class['name']) ?></h4>
                </div>
                <div class="mb-3">
                    <p class="mb-1 text-muted">Status</p>
                    <span class="badge bg-<?= $class['status'] === 'active' ? 'success' : 'secondary' ?> fs-6">
                        <?= ucfirst($class['status']) ?>
                    </span>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-6">
                        <p class="mb-1 text-muted">Section</p>
                        <p><?= htmlspecialchars($class['section'] ?? 'N/A') ?></p>
                    </div>
                    <div class="col-6">
                        <p class="mb-1 text-muted">Academic Year</p>
                        <p><?= htmlspecialchars($class['academic_year']) ?></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <p class="mb-1 text-muted">Capacity</p>
                        <p><?= $class['capacity'] ?? 'N/A' ?> students</p>
                    </div>
                    <div class="col-6">
                        <p class="mb-1 text-muted">Room Number</p>
                        <p><?= htmlspecialchars($class['room_number'] ?? 'N/A') ?></p>
                    </div>
                </div>
                <div class="mb-0">
                    <p class="mb-1 text-muted">Course</p>
                    <p><?= htmlspecialchars($class['course_name'] ?? 'Not assigned') ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Description</h5>
            </div>
            <div class="card-body">
                <p><?= nl2br(htmlspecialchars($class['description'] ?? 'No description provided.')) ?></p>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h5 class="mb-0">Quick Actions</h5>
            </div>
            <div class="card-body">
                <a href="/timetable/view?class_id=<?= $class['id'] ?>" class="btn btn-outline-primary btn-sm mb-2 w-100">
                    <i class="bi bi-calendar3 me-2"></i>View Timetable
                </a>
                <a href="/students?class_id=<?= $class['id'] ?>" class="btn btn-outline-primary btn-sm mb-2 w-100">
                    <i class="bi bi-people me-2"></i>View Students
                </a>
                <a href="/subjects?class_id=<?= $class['id'] ?>" class="btn btn-outline-primary btn-sm w-100">
                    <i class="bi bi-book me-2"></i>View Subjects
                </a>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
