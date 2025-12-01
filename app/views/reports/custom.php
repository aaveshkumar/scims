<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-graph-up me-2"></i>Custom Reports</h2>
</div>

<div class="card">
    <div class="card-body">
        <p class="text-muted mb-4">Create custom reports by selecting filters below:</p>
        
        <form method="POST" action="/reports/custom">
            <?= csrf_field() ?>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Report Type</label>
                    <select name="report_type" class="form-select">
                        <option value="">Select Report Type</option>
                        <option value="attendance">Attendance</option>
                        <option value="academic">Academic</option>
                        <option value="financial">Financial</option>
                        <option value="students">Students</option>
                        <option value="staff">Staff</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Date Range</label>
                    <select name="date_range" class="form-select">
                        <option value="">Select Date Range</option>
                        <option value="today">Today</option>
                        <option value="week">This Week</option>
                        <option value="month">This Month</option>
                        <option value="year">This Year</option>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Class</label>
                    <select name="class_id" class="form-select">
                        <option value="">All Classes</option>
                        <option value="1">Class 1A</option>
                        <option value="2">Class 2B</option>
                        <option value="3">Class 3C</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-search me-2"></i>Generate Report
            </button>
        </form>
    </div>
</div>

<div class="card mt-4">
    <div class="card-body">
        <p class="text-muted text-center">
            <i class="bi bi-info-circle me-2"></i>
            Select filters above and click "Generate Report" to create a custom report
        </p>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
