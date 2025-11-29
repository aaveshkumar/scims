<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Create Question</h1>
        <p class="text-muted mb-0">Add a new question to the question bank</p>
    </div>
    <a href="/question-bank" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card">
    <div class="card-header" style="background-color: #000; color: #fff;">
        <h5 class="mb-0">Question Details</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="/question-bank">
            <input type="hidden" name="_token" value="<?= csrf() ?>">
            
            <!-- Course Information -->
            <div class="mb-4 pb-4 border-bottom">
                <h6 class="mb-3 text-primary">
                    <i class="bi bi-book me-2"></i>Course Information
                </h6>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Subject *</label>
                        <select name="subject_id" class="form-select" required>
                            <option value="">-- Select Subject --</option>
                            <?php foreach ($subjects as $subject): ?>
                                <option value="<?= $subject['id'] ?>">
                                    <?= htmlspecialchars($subject['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Class/Grade *</label>
                        <select name="class_id" class="form-select" required>
                            <option value="">-- Select Class --</option>
                            <?php foreach ($classes as $class): ?>
                                <option value="<?= $class['id'] ?>">
                                    <?= htmlspecialchars($class['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Question Information -->
            <div class="mb-4 pb-4 border-bottom">
                <h6 class="mb-3 text-primary">
                    <i class="bi bi-question-circle me-2"></i>Question Details
                </h6>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Question Text *</label>
                    <textarea name="question_text" class="form-control" rows="4" required 
                        placeholder="e.g., What is the capital of France?"></textarea>
                    <small class="text-muted">The main question that students need to answer</small>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Question Type *</label>
                        <select name="question_type" class="form-select" required>
                            <option value="">-- Select Type --</option>
                            <option value="multiple_choice">Multiple Choice (MCQ)</option>
                            <option value="true_false">True/False</option>
                            <option value="short_answer">Short Answer</option>
                            <option value="long_answer">Long Answer/Essay</option>
                            <option value="fill_blanks">Fill in the Blanks</option>
                            <option value="matching">Matching</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Difficulty Level *</label>
                        <select name="difficulty_level" class="form-select" required>
                            <option value="">-- Select Level --</option>
                            <option value="easy">Easy</option>
                            <option value="medium">Medium</option>
                            <option value="hard">Hard</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Marks *</label>
                        <input type="number" name="marks" class="form-control" placeholder="e.g., 1, 2, 5" min="1" max="100" required>
                        <small class="text-muted">Mark value for this question</small>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Chapter/Topic</label>
                        <input type="text" name="chapter_topic" class="form-control" placeholder="e.g., Chapter 3: Geography">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Keywords</label>
                        <input type="text" name="keywords" class="form-control" placeholder="e.g., capital, city, country">
                        <small class="text-muted">Comma-separated keywords for searching</small>
                    </div>
                </div>
            </div>

            <!-- Multiple Choice Options -->
            <div class="mb-4 pb-4 border-bottom">
                <h6 class="mb-3 text-primary">
                    <i class="bi bi-list-ul me-2"></i>Multiple Choice Options (if applicable)
                </h6>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Option A</label>
                    <input type="text" name="option_a" class="form-control" placeholder="e.g., Paris">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Option B</label>
                    <input type="text" name="option_b" class="form-control" placeholder="e.g., London">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Option C</label>
                    <input type="text" name="option_c" class="form-control" placeholder="e.g., Berlin">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Option D</label>
                    <input type="text" name="option_d" class="form-control" placeholder="e.g., Rome">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Correct Answer</label>
                    <select name="correct_answer" class="form-select">
                        <option value="">-- Select Correct Answer --</option>
                        <option value="A">Option A</option>
                        <option value="B">Option B</option>
                        <option value="C">Option C</option>
                        <option value="D">Option D</option>
                        <option value="True">True</option>
                        <option value="False">False</option>
                    </select>
                </div>
            </div>

            <!-- Explanation & Feedback -->
            <div class="mb-4 pb-4 border-bottom">
                <h6 class="mb-3 text-primary">
                    <i class="bi bi-info-circle me-2"></i>Explanation & Feedback
                </h6>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Explanation/Solution</label>
                    <textarea name="explanation" class="form-control" rows="3" 
                        placeholder="e.g., Paris is the capital of France. It is located in the north-central part of the country and is known as the City of Light."></textarea>
                    <small class="text-muted">Detailed explanation for students to understand the answer</small>
                </div>
            </div>

            <!-- Status -->
            <div class="mb-4">
                <label class="form-label fw-bold">Status</label>
                <select name="status" class="form-select">
                    <option value="active" selected>Active (Ready to Use)</option>
                    <option value="draft">Draft (Under Review)</option>
                    <option value="inactive">Inactive (Archived)</option>
                </select>
            </div>

            <div class="d-flex gap-2 pt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Create Question
                </button>
                <a href="/question-bank" class="btn btn-secondary">
                    <i class="bi bi-x-circle me-2"></i>Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
