<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Create New Syllabus</h1>
        <p class="text-muted mb-0">Define course content, learning objectives, and assessment criteria</p>
    </div>
    <a href="/syllabus" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card">
    <div class="card-header" style="background-color: #000; color: #fff;">
        <h5 class="mb-0">Syllabus Details</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="/syllabus">
            <input type="hidden" name="_token" value="<?= csrf() ?>">
            
            <!-- Course Selection Section -->
            <div class="mb-4 pb-4 border-bottom">
                <h6 class="mb-3 text-primary">
                    <i class="bi bi-book me-2"></i>Course Information
                </h6>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Subject *</label>
                        <select name="subject_id" class="form-select" required>
                            <option value="">-- Select Subject --</option>
                            <option value="mathematics">Mathematics</option>
                            <option value="english">English</option>
                            <option value="science">Science</option>
                        </select>
                        <small class="text-muted d-block mt-1">
                            <i class="bi bi-info-circle"></i> Choose the subject this syllabus covers
                        </small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Class/Grade *</label>
                        <select name="class_id" class="form-select" required>
                            <option value="">-- Select Class --</option>
                            <option value="class_10">Class X</option>
                            <option value="class_12">Class XII</option>
                        </select>
                        <small class="text-muted d-block mt-1">
                            <i class="bi bi-info-circle"></i> The class or grade level for this syllabus
                        </small>
                    </div>
                </div>
            </div>

            <!-- Syllabus Title and Overview -->
            <div class="mb-4 pb-4 border-bottom">
                <h6 class="mb-3 text-primary">
                    <i class="bi bi-pencil-square me-2"></i>Syllabus Title & Overview
                </h6>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Syllabus Title *</label>
                    <input type="text" name="title" class="form-control" placeholder="e.g., Advanced Mathematics Curriculum 2024-2025" required>
                    <small class="text-muted d-block mt-1">
                        <i class="bi bi-info-circle"></i> Give a descriptive title for this course syllabus
                    </small>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Overview / Course Description</label>
                    <textarea name="overview" class="form-control" rows="3" placeholder="e.g., This course covers algebra, geometry, trigonometry, and calculus fundamentals. Students will develop problem-solving skills and mathematical reasoning."></textarea>
                    <small class="text-muted d-block mt-1">
                        <i class="bi bi-info-circle"></i> Provide a general overview of what the course is about
                    </small>
                </div>
            </div>

            <!-- Learning Objectives -->
            <div class="mb-4 pb-4 border-bottom">
                <h6 class="mb-3 text-primary">
                    <i class="bi bi-target me-2"></i>Learning Objectives
                </h6>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Learning Outcomes</label>
                    <textarea name="learning_outcomes" class="form-control" rows="3" placeholder="e.g., • Understand fundamental algebraic concepts&#10;• Solve linear and quadratic equations&#10;• Apply trigonometric ratios to real-world problems"></textarea>
                    <small class="text-muted d-block mt-1">
                        <i class="bi bi-info-circle"></i> List key skills and knowledge students will gain (use bullet points)
                    </small>
                </div>
            </div>

            <!-- Topics and Content -->
            <div class="mb-4 pb-4 border-bottom">
                <h6 class="mb-3 text-primary">
                    <i class="bi bi-list-ul me-2"></i>Topics & Content Covered
                </h6>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Topics Covered</label>
                    <textarea name="topics_covered" class="form-control" rows="3" placeholder="e.g., • Unit 1: Linear Equations&#10;• Unit 2: Quadratic Functions&#10;• Unit 3: Polynomials&#10;• Unit 4: Trigonometry"></textarea>
                    <small class="text-muted d-block mt-1">
                        <i class="bi bi-info-circle"></i> List all major topics/units covered in this course
                    </small>
                </div>
            </div>

            <!-- Assessment & Evaluation -->
            <div class="mb-4 pb-4 border-bottom">
                <h6 class="mb-3 text-primary">
                    <i class="bi bi-file-earmark-check me-2"></i>Assessment & Evaluation
                </h6>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Assessment Methods</label>
                    <textarea name="assessment_methods" class="form-control" rows="3" placeholder="e.g., • Class Tests: 20%&#10;• Mid-semester Exam: 30%&#10;• Final Exam: 40%&#10;• Projects & Assignments: 10%"></textarea>
                    <small class="text-muted d-block mt-1">
                        <i class="bi bi-info-circle"></i> Describe how students will be evaluated (include weightage if applicable)
                    </small>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Passing Criteria / Grading Scale</label>
                    <input type="text" name="grading_scale" class="form-control" placeholder="e.g., A: 90-100, B: 80-89, C: 70-79, D: 60-69, F: Below 60">
                    <small class="text-muted d-block mt-1">
                        <i class="bi bi-info-circle"></i> Define the grading system and passing marks
                    </small>
                </div>
            </div>

            <!-- Resources & Materials -->
            <div class="mb-4 pb-4 border-bottom">
                <h6 class="mb-3 text-primary">
                    <i class="bi bi-book-half me-2"></i>Resources & Materials
                </h6>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Recommended Books & Materials</label>
                    <textarea name="recommended_resources" class="form-control" rows="3" placeholder="e.g., • Textbook: Advanced Mathematics by Author Name&#10;• Reference: Calculus Essentials&#10;• Online: Khan Academy, Coursera"></textarea>
                    <small class="text-muted d-block mt-1">
                        <i class="bi bi-info-circle"></i> List textbooks, reference books, and online resources for students
                    </small>
                </div>
            </div>

            <!-- Prerequisites & Duration -->
            <div class="row mb-4 pb-4 border-bottom">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Prerequisites</label>
                    <input type="text" name="prerequisites" class="form-control" placeholder="e.g., Basic algebra, Functions knowledge">
                    <small class="text-muted d-block mt-1">
                        <i class="bi bi-info-circle"></i> What students should know before taking this course
                    </small>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Course Duration</label>
                    <input type="text" name="duration" class="form-control" placeholder="e.g., 1 academic year, 6 months">
                    <small class="text-muted d-block mt-1">
                        <i class="bi bi-info-circle"></i> Total duration of the course
                    </small>
                </div>
            </div>

            <!-- General Settings -->
            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Academic Year</label>
                    <input type="text" name="academic_year" class="form-control" placeholder="e.g., 2024-2025" required>
                    <small class="text-muted d-block mt-1">
                        <i class="bi bi-info-circle"></i> Academic year this syllabus applies to
                    </small>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Status</label>
                    <select name="status" class="form-select">
                        <option value="active" selected>Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="draft">Draft</option>
                    </select>
                    <small class="text-muted d-block mt-1">
                        <i class="bi bi-info-circle"></i> Set whether this syllabus is active or still in draft
                    </small>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="d-flex gap-2 pt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Create Syllabus
                </button>
                <a href="/syllabus" class="btn btn-secondary">
                    <i class="bi bi-x-circle me-2"></i>Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>