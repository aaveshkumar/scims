<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Create Academic Calendar</h1>
        <p class="text-muted mb-0">Add a new academic year calendar</p>
    </div>
    <a href="/academic-calendar" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card">
    <div class="card-header" style="background-color: #000; color: #fff;">
        <h5 class="mb-0">Calendar Details</h5>
    </div>
    <div class="card-body">
        <form method="POST" action="/academic-calendar">
            <input type="hidden" name="_token" value="<?= csrf() ?>">
            
            <!-- Basic Information -->
            <div class="mb-4 pb-4 border-bottom">
                <h6 class="mb-3 text-primary">
                    <i class="bi bi-calendar-event me-2"></i>Basic Information
                </h6>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Academic Year *</label>
                        <input type="text" name="academic_year" class="form-control" required
                            placeholder="e.g., 2024-2025, 2024-25">
                        <small class="text-muted">Format: 2024-2025 or 2024-25</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Session Name</label>
                        <input type="text" name="session_name" class="form-control"
                            placeholder="e.g., Spring Semester, Fall Semester">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Calendar Start Date *</label>
                        <input type="date" name="start_date" class="form-control" required>
                        <small class="text-muted">When the academic year begins</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Calendar End Date *</label>
                        <input type="date" name="end_date" class="form-control" required>
                        <small class="text-muted">When the academic year ends</small>
                    </div>
                </div>
            </div>

            <!-- Session Dates -->
            <div class="mb-4 pb-4 border-bottom">
                <h6 class="mb-3 text-primary">
                    <i class="bi bi-calendar me-2"></i>Session & Teaching Dates
                </h6>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Session Start Date</label>
                        <input type="date" name="session_start" class="form-control">
                        <small class="text-muted">When classes/teaching begins</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Session End Date</label>
                        <input type="date" name="session_end" class="form-control">
                        <small class="text-muted">When teaching ends before exams</small>
                    </div>
                </div>
            </div>

            <!-- Exam Dates -->
            <div class="mb-4 pb-4 border-bottom">
                <h6 class="mb-3 text-primary">
                    <i class="bi bi-pencil-square me-2"></i>Exam Schedule
                </h6>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Exam Start Date</label>
                        <input type="date" name="exam_start" class="form-control">
                        <small class="text-muted">When exams begin</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Exam End Date</label>
                        <input type="date" name="exam_end" class="form-control">
                        <small class="text-muted">When exams conclude</small>
                    </div>
                </div>
            </div>

            <!-- Admission Dates -->
            <div class="mb-4 pb-4 border-bottom">
                <h6 class="mb-3 text-primary">
                    <i class="bi bi-file-earmark-text me-2"></i>Admission Schedule
                </h6>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Admission Start Date</label>
                        <input type="date" name="admission_start" class="form-control">
                        <small class="text-muted">When admissions open</small>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Admission End Date</label>
                        <input type="date" name="admission_end" class="form-control">
                        <small class="text-muted">When admissions close</small>
                    </div>
                </div>
            </div>

            <!-- Holidays & Events -->
            <div class="mb-4 pb-4 border-bottom">
                <h6 class="mb-3 text-primary">
                    <i class="bi bi-calendar2-heart me-2"></i>Holidays & Important Events
                </h6>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Holidays</label>
                    <textarea name="holidays" class="form-control" rows="3"
                        placeholder="e.g., Diwali: Oct 15&#10;Christmas: Dec 25&#10;New Year: Jan 1"></textarea>
                    <small class="text-muted">List important holidays (one per line with dates)</small>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Important Events</label>
                    <textarea name="important_events" class="form-control" rows="3"
                        placeholder="e.g., Parent-Teacher Meet: Sept 10&#10;Sports Day: Nov 20&#10;Annual Fest: Mar 15"></textarea>
                    <small class="text-muted">List important school events with dates</small>
                </div>
            </div>

            <!-- Additional Information -->
            <div class="mb-4 pb-4 border-bottom">
                <h6 class="mb-3 text-primary">
                    <i class="bi bi-info-circle me-2"></i>Additional Information
                </h6>
                
                <div class="mb-3">
                    <label class="form-label fw-bold">Notes/Remarks</label>
                    <textarea name="notes" class="form-control" rows="3"
                        placeholder="Any additional notes about this academic year&#10;e.g., Special arrangements, changes, or important information"></textarea>
                </div>
            </div>

            <!-- Status -->
            <div class="mb-4">
                <label class="form-label fw-bold">Status</label>
                <select name="status" class="form-select">
                    <option value="active" selected>Active (Current/Ongoing)</option>
                    <option value="draft">Draft (Planning)</option>
                    <option value="completed">Completed (Past)</option>
                </select>
            </div>

            <div class="d-flex gap-2 pt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle me-2"></i>Create Calendar
                </button>
                <a href="/academic-calendar" class="btn btn-secondary">
                    <i class="bi bi-x-circle me-2"></i>Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
