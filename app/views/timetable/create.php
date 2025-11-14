<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">Add Timetable Entry</h1>
    <a href="/timetable" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Timetable Details</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="/timetable">
            <input type="hidden" name="_token" value="<?= csrf() ?>">
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Class *</label>
                    <select name="class_id" class="form-select" required>
                        <option value="">Select Class</option>
                        <?php foreach ($classes as $class): ?>
                            <option value="<?= $class['id'] ?>"><?= htmlspecialchars($class['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Subject *</label>
                    <select name="subject_id" class="form-select" required>
                        <option value="">Select Subject</option>
                        <?php foreach ($subjects as $subject): ?>
                            <option value="<?= $subject['id'] ?>"><?= htmlspecialchars($subject['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Teacher</label>
                    <select name="teacher_id" class="form-select">
                        <option value="">Select Teacher (Optional)</option>
                        <?php foreach ($teachers as $teacher): ?>
                            <option value="<?= $teacher['id'] ?>">
                                <?= htmlspecialchars($teacher['first_name'] . ' ' . $teacher['last_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Day of Week *</label>
                    <select name="day_of_week" class="form-select" required>
                        <option value="">Select Day</option>
                        <option value="Monday">Monday</option>
                        <option value="Tuesday">Tuesday</option>
                        <option value="Wednesday">Wednesday</option>
                        <option value="Thursday">Thursday</option>
                        <option value="Friday">Friday</option>
                        <option value="Saturday">Saturday</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label">Start Time *</label>
                    <input type="time" name="start_time" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">End Time *</label>
                    <input type="time" name="end_time" class="form-control" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Room Number</label>
                    <input type="text" name="room_number" class="form-control" placeholder="e.g., Room 101">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Academic Year *</label>
                    <input type="text" name="academic_year" class="form-control" value="<?= date('Y') ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Semester</label>
                    <select name="semester" class="form-select">
                        <option value="">Select Semester (Optional)</option>
                        <option value="1">Semester 1</option>
                        <option value="2">Semester 2</option>
                    </select>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Add to Timetable
                </button>
                <a href="/timetable" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
