<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Report Cards</h1>
        <p class="text-muted mb-0">Download and view student report cards by class and exam</p>
    </div>
</div>

<!-- Filter Section -->
<div class="card mb-4 filter-card">
    <div class="card-header">
        <h5 class="mb-0">Generate Report Cards</h5>
    </div>
    <div class="card-body">
        <form method="get" action="/report-cards" id="filterForm">
            <div class="row g-3">
                <div class="col-lg-5">
                    <label class="form-label fw-bold">
                        <i class="bi bi-building me-2"></i>Select Class
                    </label>
                    <select class="form-select form-select-lg dropdown-select" name="class_id" id="classSelect" onchange="submitFormWithLoader()">
                        <option value="">-- Choose a Class --</option>
                        <?php foreach ($classes as $class): ?>
                            <option value="<?= $class['id'] ?>" <?= ($selectedClassId == $class['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($class['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-lg-5">
                    <label class="form-label fw-bold">
                        <i class="bi bi-pencil-square me-2"></i>Select Exam
                    </label>
                    <select class="form-select form-select-lg dropdown-select" name="exam_id" id="examSelect" onchange="submitFormWithLoader()">
                        <option value="">-- Choose an Exam --</option>
                        <?php foreach ($exams as $exam): ?>
                            <option value="<?= $exam['id'] ?>" <?= ($selectedExamId == $exam['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($exam['name']) ?> (<?= htmlspecialchars($exam['academic_year']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-lg-2 d-flex align-items-end">
                    <?php if ($selectedClassId && $selectedExamId): ?>
                        <a href="/report-cards" class="btn btn-secondary btn-sm w-100">
                            <i class="bi bi-x-circle me-1"></i>Clear
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Loading Spinner (appears below filter) -->
<div id="loadingSpinner" class="text-center py-5 mb-4" style="display: none;">
    <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
        <span class="visually-hidden">Loading...</span>
    </div>
    <p class="text-muted mt-3">Loading student report cards...</p>
</div>

<!-- Results Section (hidden when loading) -->
<div class="card fade-in" id="resultsCard" style="display: none;">
    <div class="card-header">
        <h5 class="mb-0">
            <?php if ($selectedClassId && $selectedExamId): ?>
                Report Cards Generated
            <?php else: ?>
                Select Class and Exam to Generate
            <?php endif; ?>
        </h5>
    </div>
    <div class="card-body">
        <?php if (!$selectedClassId || !$selectedExamId): ?>
            <div class="text-center py-5 text-muted">
                <i class="bi bi-file-text fs-1 d-block mb-3"></i>
                <p class="fs-6">Select a class and exam to generate and view report cards</p>
            </div>
        <?php elseif (empty($reportCards)): ?>
            <div class="text-center py-5 text-muted">
                <i class="bi bi-inbox fs-1 d-block mb-3"></i>
                <p class="fs-6">No students found for this class or no marks entered yet</p>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Admission #</th>
                            <th>Student Name</th>
                            <th>Class</th>
                            <th>Percentage</th>
                            <th>Grade</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($reportCards as $card): ?>
                            <tr>
                                <td><strong><?= htmlspecialchars($card['admission_number']) ?></strong></td>
                                <td><?= htmlspecialchars($card['first_name'] . ' ' . $card['last_name']) ?></td>
                                <td><?= htmlspecialchars($card['class_name']) ?></td>
                                <td>
                                    <strong><?= htmlspecialchars($card['percentage'] ?? '0') ?>%</strong>
                                </td>
                                <td>
                                    <span class="badge bg-<?= match($card['grade']) {
                                        'A+', 'A' => 'success',
                                        'B+', 'B' => 'primary',
                                        'C' => 'info',
                                        'D' => 'warning',
                                        default => 'danger'
                                    } ?> fs-6">
                                        <?= htmlspecialchars($card['grade']) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($card['marks_count'] > 0): ?>
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle me-1"></i>Completed
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-warning">
                                            <i class="bi bi-hourglass-split me-1"></i>Pending
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($card['marks_count'] > 0): ?>
                                        <a href="/marks/report-card/<?= $card['student_id'] ?>/<?= $selectedExamId ?>" 
                                           class="btn btn-sm btn-primary" title="View Report Card">
                                            <i class="bi bi-file-earmark-pdf"></i>
                                        </a>
                                        <a href="/marks/report-card/<?= $card['student_id'] ?>/<?= $selectedExamId ?>" 
                                           class="btn btn-sm btn-secondary" 
                                           onclick="window.open(this.href); return false;" 
                                           title="Print Report Card">
                                            <i class="bi bi-printer"></i>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted small">N/A</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Bulk Actions -->
            <div class="mt-3 pt-3 border-top">
                <button class="btn btn-outline-primary btn-sm" onclick="printAll()">
                    <i class="bi bi-printer me-2"></i>Print All Report Cards
                </button>
                <button class="btn btn-outline-secondary btn-sm" onclick="downloadAll()">
                    <i class="bi bi-download me-2"></i>Download All as PDF
                </button>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const resultsCard = document.getElementById('resultsCard');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const classSelect = document.getElementById('classSelect');
    const examSelect = document.getElementById('examSelect');
    
    // Show results if we have selected class and exam
    const hasSelection = <?= ($selectedClassId && $selectedExamId) ? 'true' : 'false' ?>;
    if (hasSelection) {
        resultsCard.style.display = 'block';
        loadingSpinner.style.display = 'none';
    } else {
        resultsCard.style.display = 'block';
        loadingSpinner.style.display = 'none';
    }
    
    // Enable/disable exam dropdown based on class selection
    classSelect.addEventListener('change', function() {
        if (this.value) {
            examSelect.disabled = false;
        } else {
            examSelect.disabled = true;
            examSelect.value = '';
        }
    });
});

function submitFormWithLoader() {
    const resultsCard = document.getElementById('resultsCard');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const form = document.getElementById('filterForm');
    
    if (!resultsCard || !loadingSpinner || !form) {
        console.error('Required elements not found');
        return;
    }
    
    // Show loader and hide results
    loadingSpinner.style.display = 'block';
    resultsCard.style.display = 'none';
    
    // Scroll to loader
    setTimeout(() => {
        loadingSpinner.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }, 100);
    
    // Submit form after a brief delay for visual feedback
    setTimeout(() => {
        form.submit();
    }, 300);
}

function printAll() {
    const classIdValue = '<?= $selectedClassId ?>';
    const examIdValue = '<?= $selectedExamId ?>';
    
    if (!classIdValue || !examIdValue) {
        alert('Please select both class and exam first');
        return;
    }
    
    window.location.href = '/report-cards/print-all/' + classIdValue + '/' + examIdValue;
}

function downloadAll() {
    alert('Download functionality for bulk report cards coming soon!');
}
</script>

<style>
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.fade-in {
    animation: fadeIn 0.3s ease-in-out;
}

/* Filter card styling */
.filter-card {
    overflow: visible;
}

.filter-card .card-body {
    overflow: visible;
}

/* Dropdown select styling */
.dropdown-select {
    cursor: pointer;
    appearance: auto;
}

.dropdown-select:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.dropdown-select:disabled {
    background-color: #e9ecef;
    cursor: not-allowed;
    color: #6c757d;
    opacity: 1;
}

.dropdown-select option {
    background-color: white;
    color: black;
    padding: 5px;
}
</style>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
