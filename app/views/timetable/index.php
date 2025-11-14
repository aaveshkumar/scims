<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Timetable Management</h1>
    <?php if (hasRole('admin')): ?>
        <a href="/timetable/create" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Add Timetable Entry
        </a>
    <?php endif; ?>
</div>

<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="/timetable/view" class="row g-3">
            <div class="col-md-10">
                <select name="class_id" class="form-select" required>
                    <option value="">Select a class to view timetable</option>
                    <?php foreach ($classes as $class): ?>
                        <option value="<?= $class['id'] ?>"><?= htmlspecialchars($class['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-search"></i> View
                </button>
            </div>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-body text-center">
                <i class="bi bi-calendar3 text-primary" style="font-size: 3rem;"></i>
                <h5 class="mt-3">Class Timetable</h5>
                <p class="text-muted">View and manage class schedules for all classes</p>
                <a href="/timetable/view?class_id=<?= $classes[0]['id'] ?? '' ?>" class="btn btn-outline-primary">
                    View Schedule
                </a>
            </div>
        </div>
    </div>

    <?php if (hasRole('teacher') || hasRole('admin')): ?>
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <i class="bi bi-person-workspace text-success" style="font-size: 3rem;"></i>
                    <h5 class="mt-3">My Timetable</h5>
                    <p class="text-muted">View your teaching schedule</p>
                    <a href="/timetable/teacher" class="btn btn-outline-success">
                        View My Schedule
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
