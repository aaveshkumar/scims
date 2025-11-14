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
        <h5 class="mb-0">Subject-wise Marks</h5>
    </div>
    <div class="card-body">
        <form id="marksForm">
            <input type="hidden" name="exam_id" value="<?= $exam['id'] ?>">
            <input type="hidden" name="student_id" value="<?= $student['id'] ?>">

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

            <div class="mt-4 text-center">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-save me-2"></i>Save Marks
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('marksForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const data = {
        exam_id: formData.get('exam_id'),
        student_id: formData.get('student_id'),
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

    fetch('/marks/store', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            alert('Marks saved successfully!');
            window.location.href = '/marks?exam_id=<?= $exam['id'] ?>';
        } else {
            alert(result.message || 'Failed to save marks');
        }
    })
    .catch(error => {
        alert('An error occurred');
        console.error(error);
    });
});
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
