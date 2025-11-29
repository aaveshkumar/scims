<?php include __DIR__ . '/../layouts/header.php'; ?>

<style>
    html[data-bs-theme="dark"] .nav-link {
        color: white !important;
    }
    html[data-bs-theme="dark"] .nav-link:hover {
        color: white !important;
    }
    html[data-bs-theme="dark"] .nav-link.active {
        color: white !important;
    }
</style>

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
        <ul class="nav nav-tabs mb-3" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link <?= empty($subjectId) ? 'active' : '' ?>" id="class-tab" data-bs-toggle="tab" data-bs-target="#class-search" type="button" role="tab">By Class</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link <?= !empty($subjectId) ? 'active' : '' ?>" id="subject-tab" data-bs-toggle="tab" data-bs-target="#subject-search" type="button" role="tab">By Subject</button>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade <?= empty($subjectId) ? 'show active' : '' ?>" id="class-search" role="tabpanel">
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

            <div class="tab-pane fade <?= !empty($subjectId) ? 'show active' : '' ?>" id="subject-search" role="tabpanel">
                <form method="GET" action="/timetable" class="row g-3">
                    <div class="col-md-5">
                        <select name="subject_id" class="form-select" required>
                            <option value="">Select a subject to view timetable</option>
                            <?php foreach ($subjects as $subj): ?>
                                <option value="<?= $subj['id'] ?>" <?= $subjectId == $subj['id'] ? 'selected' : '' ?>><?= htmlspecialchars($subj['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <input type="number" name="academic_year" class="form-control" placeholder="Academic Year" value="<?= $academicYear ?>" required>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-search"></i> View
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php if ($subjectId && !empty($schedule)): ?>
<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">
            <?= htmlspecialchars($subject['name']) ?> - <?= htmlspecialchars($subject['code']) ?> (<?= $academicYear ?>)
        </h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Time</th>
                        <th>Monday</th>
                        <th>Tuesday</th>
                        <th>Wednesday</th>
                        <th>Thursday</th>
                        <th>Friday</th>
                        <th>Saturday</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $timeSlots = [];
                    foreach ($schedule as $day => $periods) {
                        foreach ($periods as $period) {
                            $time = date('h:i A', strtotime($period['start_time'])) . ' - ' . date('h:i A', strtotime($period['end_time']));
                            if (!in_array($time, $timeSlots)) {
                                $timeSlots[] = $time;
                            }
                        }
                    }
                    sort($timeSlots);
                    
                    foreach ($timeSlots as $timeSlot): 
                    ?>
                        <tr>
                            <td class="fw-bold"><?= $timeSlot ?></td>
                            <?php foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'] as $day): ?>
                                <td>
                                    <?php
                                    $found = false;
                                    if (isset($schedule[$day])) {
                                        foreach ($schedule[$day] as $period) {
                                            $periodTime = date('h:i A', strtotime($period['start_time'])) . ' - ' . date('h:i A', strtotime($period['end_time']));
                                            if ($periodTime === $timeSlot) {
                                                $found = true;
                                                ?>
                                                <div class="p-2 bg-success bg-opacity-10 rounded">
                                                    <strong><?= htmlspecialchars($period['class_name']) ?></strong><br>
                                                    <small class="text-muted">
                                                        <?= htmlspecialchars($period['teacher_name'] ?? 'No teacher') ?><br>
                                                        <?= htmlspecialchars($period['room_number'] ?? 'No room') ?>
                                                    </small>
                                                </div>
                                                <?php
                                                break;
                                            }
                                        }
                                    }
                                    if (!$found) {
                                        echo '<span class="text-muted">-</span>';
                                    }
                                    ?>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php elseif ($subjectId && empty($schedule)): ?>
<div class="alert alert-info">
    <strong>No timetable found</strong> for <?= htmlspecialchars($subject['name']) ?> in <?= $academicYear ?>
</div>
<?php endif; ?>

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
