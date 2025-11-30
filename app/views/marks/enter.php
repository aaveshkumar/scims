<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Enter Marks</h1>
        <p class="text-muted mb-0">
            <?= htmlspecialchars($exam['name']) ?> - 
            <?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?>
        </p>
    </div>
    <a href="/marks?exam_id=<?= $exam['id'] ?>" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Subject-wise Marks Entry</h5>
        <small class="text-muted d-block mt-1">Enter marks for each subject below</small>
    </div>
    <div class="card-body">
        <?php if (empty($subjects)): ?>
            <div class="alert alert-warning" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                No subjects found for this student's class. Please add subjects first.
            </div>
        <?php else: ?>
        <form id="marksForm">
            <input type="hidden" name="exam_id" value="<?= $exam['id'] ?>">
            <input type="hidden" name="student_id" value="<?= $student['id'] ?>">
            <input type="hidden" name="_token" value="<?= csrf() ?>"

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Subject</th>
                            <th>Total Marks</th>
                            <th>Marks Obtained</th>
                            <th>Grade</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($subjects as $subject): ?>
                            <?php 
                            $existingMark = $marksMap[$subject['id']] ?? null;
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($subject['name']) ?></td>
                                <td>
                                    <input type="number" name="marks[<?= $subject['id'] ?>][total_marks]" 
                                           class="form-control form-control-sm" style="width: 100px;"
                                           value="<?= $existingMark['total_marks'] ?? $exam['total_marks'] ?>">
                                </td>
                                <td>
                                    <input type="number" name="marks[<?= $subject['id'] ?>][marks_obtained]" 
                                           class="form-control form-control-sm" style="width: 100px;"
                                           value="<?= $existingMark['marks_obtained'] ?? '' ?>"
                                           min="0" max="<?= $exam['total_marks'] ?>">
                                </td>
                                <td>
                                    <span class="badge bg-secondary">
                                        <?= $existingMark['grade'] ?? '-' ?>
                                    </span>
                                </td>
                                <td>
                                    <input type="text" name="marks[<?= $subject['id'] ?>][remarks]" 
                                           class="form-control form-control-sm" 
                                           value="<?= htmlspecialchars($existingMark['remarks'] ?? '') ?>"
                                           placeholder="Optional">
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-4 d-flex gap-2 justify-content-center">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-save me-2"></i>Save Marks
                </button>
                <a href="/marks?exam_id=<?= $exam['id'] ?>" class="btn btn-secondary btn-lg">
                    <i class="bi bi-x-circle me-2"></i>Cancel
                </a>
            </div>
        </form>
        <?php endif; ?>
    </div>
</div>

<?php if (!empty($subjects)): ?>
<script>
document.getElementById('marksForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const csrfToken = formData.get('_token');
    const data = {
        exam_id: formData.get('exam_id'),
        student_id: formData.get('student_id'),
        _token: csrfToken,
        marks: {}
    };

    formData.forEach((value, key) => {
        const match = key.match(/marks\[(\d+)\]\[(.+)\]/);
        if (match) {
            const subjectId = match[1];
            const field = match[2];
            if (!data.marks[subjectId]) {
                data.marks[subjectId] = {};
            }
            data.marks[subjectId][field] = value;
        }
    });

    // Show loading state
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    submitBtn.disabled = true;
    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Saving...';

    fetch('/marks/store', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': csrfToken
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
            // Show success message
            const alert = document.createElement('div');
            alert.className = 'alert alert-success alert-dismissible fade show';
            alert.innerHTML = `
                <i class="bi bi-check-circle me-2"></i>
                <strong>Success!</strong> Marks saved successfully!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.body.insertBefore(alert, document.body.firstChild);
            
            // Redirect after 1.5 seconds
            setTimeout(() => {
                window.location.href = '/marks?exam_id=<?= $exam['id'] ?>';
            }, 1500);
        } else {
            showError(result.message || 'Failed to save marks');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showError('An error occurred while saving marks: ' + error.message);
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
    });
});

function showError(message) {
    const alert = document.createElement('div');
    alert.className = 'alert alert-danger alert-dismissible fade show';
    alert.innerHTML = `
        <i class="bi bi-exclamation-triangle me-2"></i>
        <strong>Error!</strong> ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    document.body.insertBefore(alert, document.body.firstChild);
    window.scrollTo(0, 0);
}
</script>
<?php endif; ?>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
