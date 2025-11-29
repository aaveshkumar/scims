<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Create Lesson Plan</h1>
        <p class="text-muted mb-0">Plan your class session with detailed objectives and content</p>
    </div>
    <a href="/lesson-plans" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card">
    <div class="card-header" style="background-color: #000; color: #fff;">
        <h5 class="mb-0">Lesson Details</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="/lesson-plans">
            <input type="hidden" name="_token" value="<?= csrf() ?>">
            
            <!-- Course Information -->
            <div class="mb-4 pb-4 border-bottom">
                <h6 class="mb-3 text-primary">
                    <i class="bi bi-book me-2"></i>Course Information
                </h6>
                
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Subject *</label>
                        <select name="subject_id" class="form-select" required>
                            <option value="">-- Select Subject --</option>
                            <option value="">Mathematics</option>
                            <option value="">English</option>
                            <option value="">Science</option>
                            <option value="">History</option>
                        </select>
                        <small class="text-muted">e.g., Mathematics, English, Science</small>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Class/Grade *</label>
                        <select name="class_id" class="form-select" required>
                            <option value="">-- Select Class --</option>
                            <option value="">Class 10-A</option>
                            <option value="">Class 10-B</option>
                            <option value="">Class 11-A</option>
                        </select>
                        <small class="text-muted">e.g., Class 10-A, Class 11-B</small>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label fw-bold">Lesson Date *</label>
                        <input type="date" name="lesson_date" class="form-control" required>
                        <small class="text-muted">When this lesson will be taught</small>
                    </div>
                </div>
            </div>

            <!-- Lesson Topic & Duration -->
            <div class="mb-4 pb-4 border-bottom">
                <h6 class="mb-3 text-primary">
                    <i class="bi bi-pencil-square me-2"></i>Lesson Topic & Duration
                </h6>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Lesson Topic/Title *</label>
                    <input type="text" name="topic" class="form-control" placeholder="e.g., Introduction to Quadratic Equations" required>
                    <small class="text-muted">Clear, concise title of what you'll teach</small>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Duration (minutes) *</label>
                        <input type="number" name="duration" class="form-control" placeholder="45" min="15" max="180" required>
                        <small class="text-muted">e.g., 45, 60, 90</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Period Number</label>
                        <input type="number" name="period_number" class="form-control" placeholder="1" min="1" max="8">
                        <small class="text-muted">Which period of the day (1, 2, 3, etc.)</small>
                    </div>
                </div>
            </div>

            <!-- Learning Objectives -->
            <div class="mb-4 pb-4 border-bottom">
                <h6 class="mb-3 text-primary">
                    <i class="bi bi-target me-2"></i>Learning Objectives
                </h6>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Learning Outcomes *</label>
                    <textarea name="learning_outcomes" class="form-control" rows="4" placeholder="By the end of this lesson, students will be able to:&#10;- Understand the concept of...&#10;- Apply the formula for...&#10;- Solve problems involving..." required></textarea>
                    <small class="text-muted">What students should be able to do after this lesson. One outcome per line.</small>
                </div>
            </div>

            <!-- Content & Activities -->
            <div class="mb-4 pb-4 border-bottom">
                <h6 class="mb-3 text-primary">
                    <i class="bi bi-list-ul me-2"></i>Content & Activities
                </h6>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Introduction/Hook *</label>
                    <textarea name="introduction" class="form-control" rows="3" placeholder="How will you grab students' attention?&#10;e.g., 'Start with a real-world problem about...'" required></textarea>
                    <small class="text-muted">How you'll start the lesson to engage students</small>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Main Content *</label>
                    <textarea name="content" class="form-control" rows="4" placeholder="Detailed content to cover:&#10;- Concept 1: Explanation and examples&#10;- Concept 2: Theory and applications&#10;- Concept 3: Key formulas" required></textarea>
                    <small class="text-muted">Core concepts and explanations</small>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Classroom Activities</label>
                    <textarea name="activities" class="form-control" rows="3" placeholder="Interactive activities:&#10;- Group discussion (15 mins)&#10;- Problem-solving exercise (20 mins)&#10;- Class presentation (10 mins)"></textarea>
                    <small class="text-muted">Exercises, discussions, group work, etc.</small>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Conclusion/Summary</label>
                    <textarea name="conclusion" class="form-control" rows="3" placeholder="How will you wrap up?&#10;- Recap key points&#10;- Address common misconceptions&#10;- Preview next lesson"></textarea>
                    <small class="text-muted">How you'll summarize and conclude the lesson</small>
                </div>
            </div>

            <!-- Assessment & Materials -->
            <div class="mb-4 pb-4 border-bottom">
                <h6 class="mb-3 text-primary">
                    <i class="bi bi-file-earmark-check me-2"></i>Assessment & Materials
                </h6>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Assessment Method</label>
                    <textarea name="assessment_method" class="form-control" rows="2" placeholder="How will you assess learning?&#10;e.g., Quiz, class discussion, worksheet, practical test"></textarea>
                    <small class="text-muted">How you'll check if students understand</small>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Resources & Materials Needed</label>
                    <textarea name="resources" class="form-control" rows="3" placeholder="Materials and resources:&#10;- Textbook: Chapter 5&#10;- Whiteboard markers, calculators&#10;- Projector for slides&#10;- Online simulation tools"></textarea>
                    <small class="text-muted">Books, equipment, technology, handouts, etc.</small>
                </div>
            </div>

            <!-- Additional Information -->
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Homework Assignment</label>
                    <textarea name="homework" class="form-control" rows="2" placeholder="e.g., Solve exercises 1-15 from textbook page 45"></textarea>
                    <small class="text-muted">What students should do after class</small>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Remarks/Notes</label>
                    <textarea name="remarks" class="form-control" rows="2" placeholder="Any additional notes, tips, or special instructions"></textarea>
                    <small class="text-muted">Extra notes or instructions</small>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Status</label>
                    <select name="status" class="form-select">
                        <option value="draft">Draft (Not yet ready)</option>
                        <option value="active" selected>Active (Ready to teach)</option>
                        <option value="completed">Completed (Already taught)</option>
                    </select>
                    <small class="text-muted">Mark as Draft if still planning</small>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Difficulty Level</label>
                    <select name="difficulty_level" class="form-select">
                        <option value="">-- Select Level --</option>
                        <option value="easy">Easy</option>
                        <option value="medium">Medium</option>
                        <option value="hard">Hard</option>
                    </select>
                </div>
            </div>

            <div class="d-flex gap-2 pt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Create Lesson Plan
                </button>
                <a href="/lesson-plans" class="btn btn-secondary">
                    <i class="bi bi-x-circle me-2"></i>Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
