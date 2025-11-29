<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Mark Attendance</h1>
        <p class="text-muted mb-0"><?= htmlspecialchars($class['name']) ?> - <?= date('F d, Y', strtotime($date)) ?></p>
    </div>
    <a href="/attendance" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Students List</h5>
        <div>
            <button type="button" onclick="markAll('present')" class="btn btn-sm btn-success">
                <i class="bi bi-check-all"></i> All Present
            </button>
            <button type="button" onclick="markAll('absent')" class="btn btn-sm btn-danger">
                <i class="bi bi-x-lg"></i> All Absent
            </button>
        </div>
    </div>
    <div class="card-body">
        <form id="attendanceForm">
            <input type="hidden" name="class_id" value="<?= $class['id'] ?>">
            <input type="hidden" name="date" value="<?= $date ?>">
            
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Roll No.</th>
                            <th>Admission No.</th>
                            <th>Student Name</th>
                            <th class="text-center">Attendance</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($students)): ?>
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">No students found in this class</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($students as $student): ?>
                                <tr>
                                    <td><?= htmlspecialchars($student['roll_number'] ?? '-') ?></td>
                                    <td><?= htmlspecialchars($student['admission_number']) ?></td>
                                    <td><?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?></td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group">
                                            <input type="radio" class="btn-check" name="attendance[<?= $student['id'] ?>]" value="present" 
                                                   id="present_<?= $student['id'] ?>" <?= ($student['attendance_status'] ?? '') === 'present' ? 'checked' : '' ?>>
                                            <label class="btn btn-outline-success" for="present_<?= $student['id'] ?>">
                                                <i class="bi bi-check-circle"></i> Present
                                            </label>

                                            <input type="radio" class="btn-check" name="attendance[<?= $student['id'] ?>]" value="absent" 
                                                   id="absent_<?= $student['id'] ?>" <?= ($student['attendance_status'] ?? '') === 'absent' ? 'checked' : '' ?>>
                                            <label class="btn btn-outline-danger" for="absent_<?= $student['id'] ?>">
                                                <i class="bi bi-x-circle"></i> Absent
                                            </label>

                                            <input type="radio" class="btn-check" name="attendance[<?= $student['id'] ?>]" value="late" 
                                                   id="late_<?= $student['id'] ?>" <?= ($student['attendance_status'] ?? '') === 'late' ? 'checked' : '' ?>>
                                            <label class="btn btn-outline-warning" for="late_<?= $student['id'] ?>">
                                                <i class="bi bi-clock"></i> Late
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if (!empty($students)): ?>
                <div class="mt-4 text-center">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-save me-2"></i>Save Attendance
                    </button>
                </div>
            <?php endif; ?>
        </form>
    </div>
</div>

<script>
function markAll(status) {
    document.querySelectorAll(`input[value="${status}"]`).forEach(input => {
        input.checked = true;
    });
}

document.getElementById('attendanceForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const data = {};
    formData.forEach((value, key) => {
        if (key.startsWith('attendance[')) {
            const studentId = key.match(/\d+/)[0];
            if (!data.attendance) data.attendance = {};
            data.attendance[studentId] = value;
        } else {
            data[key] = value;
        }
    });

    // Get CSRF token from meta tag
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
    if (csrfToken) {
        data._token = csrfToken;
    }

    fetch('/attendance/store', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify(data)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(result => {
        if (result.success) {
            alert('Attendance saved successfully!');
            window.location.href = '/attendance';
        } else {
            alert(result.message || 'Failed to save attendance');
        }
    })
    .catch(error => {
        alert('An error occurred: ' + error.message);
        console.error(error);
    });
});
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
