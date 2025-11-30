<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0"><?= htmlspecialchars($quiz['title']) ?></h1>
        <p class="text-muted mb-0">Subject: <?= htmlspecialchars($quiz['subject_name']) ?> • Class: <?= htmlspecialchars($quiz['class_name']) ?></p>
    </div>
    <div>
        <a href="/quizzes/<?= $quiz['id'] ?>/edit" class="btn btn-warning me-2">
            <i class="bi bi-pencil me-2"></i>Edit
        </a>
        <form method="POST" action="/quizzes/<?= $quiz['id'] ?>/delete" style="display: inline;" onsubmit="return confirm('Delete this quiz? This action cannot be undone.');">
            <input type="hidden" name="_token" value="<?= csrf() ?>">
            <button type="submit" class="btn btn-danger me-2">
                <i class="bi bi-trash me-2"></i>Delete
            </button>
        </form>
        <a href="/quizzes" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <!-- Quiz Info -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Quiz Information</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="fw-bold text-muted">Teacher</label>
                        <p><?= htmlspecialchars($quiz['teacher_name']) ?></p>
                    </div>
                    <div class="col-md-6">
                        <label class="fw-bold text-muted">Status</label>
                        <p><span class="badge bg-<?= $quiz['status'] === 'active' ? 'success' : ($quiz['status'] === 'draft' ? 'warning' : 'secondary') ?>"><?= ucfirst($quiz['status']) ?></span></p>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="fw-bold text-muted">Duration</label>
                        <p><?= $quiz['duration_minutes'] ?> minutes</p>
                    </div>
                    <div class="col-md-4">
                        <label class="fw-bold text-muted">Total Marks</label>
                        <p><?= $quiz['total_marks'] ?></p>
                    </div>
                    <div class="col-md-4">
                        <label class="fw-bold text-muted">Passing Marks</label>
                        <p><?= $quiz['passing_marks'] ?? 'Not set' ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Schedule -->
        <?php if (!empty($quiz['start_time']) || !empty($quiz['end_time'])): ?>
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Schedule</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="fw-bold text-muted">Start Date & Time</label>
                            <p><?= $quiz['start_time'] ? date('d M Y, h:i A', strtotime($quiz['start_time'])) : 'Not scheduled' ?></p>
                        </div>
                        <div class="col-md-6">
                            <label class="fw-bold text-muted">End Date & Time</label>
                            <p><?= $quiz['end_time'] ? date('d M Y, h:i A', strtotime($quiz['end_time'])) : 'Not scheduled' ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Description -->
        <?php if (!empty($quiz['description'])): ?>
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Description</h5>
                </div>
                <div class="card-body">
                    <p><?= nl2br(htmlspecialchars($quiz['description'])) ?></p>
                </div>
            </div>
        <?php endif; ?>

        <!-- Questions -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Questions (<?= count($questions ?? []) ?>)</h5>
                <a href="/quizzes/<?= $quiz['id'] ?>/add-questions" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus-circle me-1"></i>Add Questions
                </a>
            </div>
            <div class="card-body">
                <?php if (!empty($questions)): ?>
                    <div class="list-group">
                        <?php foreach ($questions as $index => $q): ?>
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between">
                                    <h6 class="mb-2">Q<?= $index + 1 ?>. <?= htmlspecialchars($q['question_text']) ?></h6>
                                    <small class="text-muted"><?= ucfirst($q['question_type']) ?></small>
                                </div>
                                <?php if ($q['question_type'] === 'multiple_choice'): ?>
                                    <ul class="mb-2">
                                        <li><?= htmlspecialchars($q['option_a']) ?></li>
                                        <li><?= htmlspecialchars($q['option_b']) ?></li>
                                        <li><?= htmlspecialchars($q['option_c']) ?></li>
                                        <li><?= htmlspecialchars($q['option_d']) ?></li>
                                    </ul>
                                    <small class="text-success">Correct Answer: <?= htmlspecialchars($q['correct_answer']) ?></small>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-muted">No questions added yet. <a href="/question-bank">Add questions</a></p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Attempts -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Student Attempts (<?= count($attempts ?? []) ?>)</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($attempts)): ?>
                    <div class="table-responsive">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr>
                                    <th>Student Name</th>
                                    <th>Roll Number</th>
                                    <th>Marks Obtained</th>
                                    <th>Status</th>
                                    <th>Attempted On</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($attempts as $attempt): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($attempt['first_name'] . ' ' . $attempt['last_name']) ?></td>
                                        <td><?= htmlspecialchars($attempt['roll_number']) ?></td>
                                        <td><?= $attempt['marks_obtained'] ?? '-' ?></td>
                                        <td>
                                            <span class="badge bg-<?= $attempt['status'] === 'completed' ? 'success' : 'warning' ?>">
                                                <?= ucfirst($attempt['status']) ?>
                                            </span>
                                        </td>
                                        <td><?= $attempt['attempted_at'] ? date('d M Y', strtotime($attempt['attempted_at'])) : '-' ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-muted">No attempts yet. Students can attempt the quiz once it's active.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Sidebar Stats -->
    <div class="col-md-4">
        <div class="card mb-4 bg-primary text-white">
            <div class="card-body">
                <h6 class="card-title">Total Questions</h6>
                <h2><?= count($questions ?? []) ?></h2>
            </div>
        </div>
        
        <div class="card mb-4 bg-success text-white">
            <div class="card-body">
                <h6 class="card-title">Total Attempts</h6>
                <h2><?= count($attempts ?? []) ?></h2>
            </div>
        </div>

        <?php if (!empty($attempts)): ?>
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h6 class="card-title">Average Score</h6>
                    <h2>
                        <?php 
                            $completed = array_filter($attempts, fn($a) => $a['status'] === 'completed');
                            if (!empty($completed)) {
                                $avg = array_sum(array_column($completed, 'marks_obtained')) / count($completed);
                                echo round($avg, 1);
                            } else {
                                echo '-';
                            }
                        ?>
                    </h2>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
