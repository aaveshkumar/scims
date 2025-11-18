<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container-fluid">
    <div class="mb-4">
        <h2 class="mb-2">All Features</h2>
        <p class="text-muted">Comprehensive list of all features and modules available in this School Management System</p>
    </div>

    <div class="row">
        <!-- NEW FEATURE: School Calendar & Holiday Management -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm border-warning" style="border-width: 3px !important;">
                <div class="card-header bg-warning text-dark position-relative">
                    <h5 class="mb-0"><i class="bi bi-calendar-event me-2"></i>School Calendar & Holidays <span class="badge bg-danger ms-2"><i class="bi bi-star-fill"></i> NEW</span></h5>
                </div>
                <div class="card-body bg-light">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><i class="bi bi-star text-warning me-2"></i><strong>School Calendar Management</strong></li>
                        <li class="mb-2"><i class="bi bi-star text-warning me-2"></i><strong>Holiday Scheduling</strong></li>
                        <li class="mb-2"><i class="bi bi-star text-warning me-2"></i><strong>Multi-day Events</strong></li>
                        <li class="mb-2"><i class="bi bi-star text-warning me-2"></i><strong>Event Categories & Color-Coding</strong></li>
                        <li class="mb-2"><i class="bi bi-star text-warning me-2"></i><strong>Class/Department-Specific Events</strong></li>
                        <li class="mb-2"><i class="bi bi-star text-warning me-2"></i><strong>Recurring Holiday Support</strong></li>
                    </ul>
                    <a href="/calendar" class="btn btn-sm btn-warning mt-2">Access Module</a>
                </div>
            </div>
        </div>

        <!-- NEW FEATURE: HR Events & Management -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm border-info" style="border-width: 3px !important;">
                <div class="card-header bg-info text-white position-relative">
                    <h5 class="mb-0"><i class="bi bi-calendar-week me-2"></i>HR Events & Management <span class="badge bg-danger ms-2"><i class="bi bi-star-fill"></i> NEW</span></h5>
                </div>
                <div class="card-body bg-light">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><i class="bi bi-star text-info me-2"></i><strong>Staff Event Management</strong></li>
                        <li class="mb-2"><i class="bi bi-star text-info me-2"></i><strong>HR Holiday Management</strong></li>
                        <li class="mb-2"><i class="bi bi-star text-info me-2"></i><strong>Meeting & Training Scheduling</strong></li>
                        <li class="mb-2"><i class="bi bi-star text-info me-2"></i><strong>Event Participant Tracking</strong></li>
                        <li class="mb-2"><i class="bi bi-star text-info me-2"></i><strong>Attendance Marking for Events</strong></li>
                        <li class="mb-2"><i class="bi bi-star text-info me-2"></i><strong>Department-Level Events</strong></li>
                    </ul>
                    <a href="/hr/events" class="btn btn-sm btn-info mt-2">Access Module</a>
                </div>
            </div>
        </div>

        <!-- NEW FEATURE: Enhanced Announcements & Notice Board -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm border-primary" style="border-width: 3px !important;">
                <div class="card-header bg-primary text-white position-relative">
                    <h5 class="mb-0"><i class="bi bi-megaphone me-2"></i>Notice Board & Announcements <span class="badge bg-danger ms-2"><i class="bi bi-star-fill"></i> NEW</span></h5>
                </div>
                <div class="card-body bg-light">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><i class="bi bi-star text-primary me-2"></i><strong>Enhanced Notice Board</strong></li>
                        <li class="mb-2"><i class="bi bi-star text-primary me-2"></i><strong>Priority Levels (Urgent/High/Normal)</strong></li>
                        <li class="mb-2"><i class="bi bi-star text-primary me-2"></i><strong>Visibility Controls</strong></li>
                        <li class="mb-2"><i class="bi bi-star text-primary me-2"></i><strong>Pin Important Announcements</strong></li>
                        <li class="mb-2"><i class="bi bi-star text-primary me-2"></i><strong>File Attachments</strong></li>
                        <li class="mb-2"><i class="bi bi-star text-primary me-2"></i><strong>Auto-Expiry & Archiving</strong></li>
                    </ul>
                    <a href="/announcements" class="btn btn-sm btn-primary mt-2">Access Module</a>
                </div>
            </div>
        </div>

        <!-- Admissions Module -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-file-earmark-text me-2"></i>Admissions</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Online Application Form</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Application Management</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Document Upload</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Approval Workflow</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Waitlist Management</li>
                    </ul>
                    <a href="/admissions" class="btn btn-sm btn-outline-primary mt-2">Access Module</a>
                </div>
            </div>
        </div>

        <!-- Academic Management -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-book me-2"></i>Academic Management</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Courses Management</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Classes & Sections</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Subject Management</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Syllabus & Lesson Plans</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Question Bank</li>
                    </ul>
                    <a href="/courses" class="btn btn-sm btn-outline-success mt-2">Access Module</a>
                </div>
            </div>
        </div>

        <!-- User Management -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="bi bi-people me-2"></i>User Management</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Student Management</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Staff/Teachers Management</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>User Accounts</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Roles & Permissions (RBAC)</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Department Management</li>
                    </ul>
                    <a href="/students" class="btn btn-sm btn-outline-info mt-2">Access Module</a>
                </div>
            </div>
        </div>

        <!-- Timetable & Attendance -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="bi bi-calendar3 me-2"></i>Operations</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Timetable Scheduling</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Attendance Tracking</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Leave Management</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Room Allocation</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Period-wise Attendance</li>
                    </ul>
                    <a href="/timetable" class="btn btn-sm btn-outline-warning mt-2">Access Module</a>
                </div>
            </div>
        </div>

        <!-- Exams & Results -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0"><i class="bi bi-clipboard-check me-2"></i>Exams & Results</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Exam Scheduling</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Marks Entry</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Grade Calculation</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Report Card Generation</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Result Analytics</li>
                    </ul>
                    <a href="/exams" class="btn btn-sm btn-outline-danger mt-2">Access Module</a>
                </div>
            </div>
        </div>

        <!-- Finance & Fees -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0"><i class="bi bi-cash-stack me-2"></i>Finance & Fees</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Fee Structure Management</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Invoice Generation</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Payment Gateway Integration</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Fee Collections</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Expense Tracking</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Staff Payroll</li>
                    </ul>
                    <a href="/invoices" class="btn btn-sm btn-outline-dark mt-2">Access Module</a>
                </div>
            </div>
        </div>

        <!-- Learning Management System -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-file-earmark-pdf me-2"></i>Learning Management</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Study Materials</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Assignments</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Quizzes & Tests</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Online Classes (Zoom/Meet)</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>File Upload/Download</li>
                    </ul>
                    <a href="/materials" class="btn btn-sm btn-outline-primary mt-2">Access Module</a>
                </div>
            </div>
        </div>

        <!-- Library Management -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-book-half me-2"></i>Library</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Book Management</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Issue/Return Books</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Member Management</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Fine Calculation</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Stock Management</li>
                    </ul>
                    <a href="/library" class="btn btn-sm btn-outline-success mt-2">Access Module</a>
                </div>
            </div>
        </div>

        <!-- Transport Management -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="bi bi-bus-front me-2"></i>Transport</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Vehicle Management</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Route Management</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Driver Assignment</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>GPS Tracking</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Maintenance Records</li>
                    </ul>
                    <a href="/transport" class="btn btn-sm btn-outline-info mt-2">Access Module</a>
                </div>
            </div>
        </div>

        <!-- Hostel Management -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0"><i class="bi bi-house me-2"></i>Hostel</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Room Allocation</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Resident Management</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Mess Management</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Visitor Tracking</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Complaint Management</li>
                    </ul>
                    <a href="/hostel" class="btn btn-sm btn-outline-warning mt-2">Access Module</a>
                </div>
            </div>
        </div>

        <!-- Inventory Management -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0"><i class="bi bi-box-seam me-2"></i>Inventory</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Asset Management</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Stock Tracking</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Purchase Orders</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Supplier Management</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Depreciation Tracking</li>
                    </ul>
                    <a href="/inventory" class="btn btn-sm btn-outline-danger mt-2">Access Module</a>
                </div>
            </div>
        </div>

        <!-- Communication -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0"><i class="bi bi-chat-dots me-2"></i>Communication</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Internal Notifications</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>SMS Integration</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Email Management</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>WhatsApp Integration</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Announcements</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Messaging System</li>
                    </ul>
                    <a href="/notifications" class="btn btn-sm btn-outline-dark mt-2">Access Module</a>
                </div>
            </div>
        </div>

        <!-- Reports & Analytics -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-graph-up me-2"></i>Reports & Analytics</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Attendance Reports</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Academic Performance</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Financial Reports</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Fee Collection Reports</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Custom Reports</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Export to PDF/Excel</li>
                    </ul>
                    <a href="/reports/attendance" class="btn btn-sm btn-outline-primary mt-2">Access Module</a>
                </div>
            </div>
        </div>

        <!-- System Settings -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-gear me-2"></i>System Settings</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>System Configuration</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Multi-Branch Support</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Third-Party Integrations</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Backup & Restore</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Audit Logs</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Security Settings</li>
                    </ul>
                    <a href="/settings" class="btn btn-sm btn-outline-success mt-2">Access Module</a>
                </div>
            </div>
        </div>

        <!-- Profile Management -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="bi bi-person-circle me-2"></i>Profile & Security</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>My Profile</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Edit Profile</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Change Password</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Document Management</li>
                        <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Security Settings</li>
                    </ul>
                    <a href="/profile" class="btn btn-sm btn-outline-info mt-2">Access Module</a>
                </div>
            </div>
        </div>
    </div>

    <div class="alert alert-info mt-4">
        <h5><i class="bi bi-info-circle me-2"></i>Feature Status Legend</h5>
        <div class="row">
            <div class="col-md-6">
                <p class="mb-2"><i class="bi bi-check-circle text-success me-2"></i><strong>Fully Implemented:</strong> Dashboard, Students, Staff, Courses, Classes, Subjects, Admissions, Timetable, Attendance, Exams, Marks, Invoices, Materials, Notifications, Profile</p>
            </div>
            <div class="col-md-6">
                <p class="mb-2"><i class="bi bi-tools text-warning me-2"></i><strong>Under Development:</strong> Library, Transport, Hostel, Inventory, Fee Structure, Payroll, Assignments, Quizzes, Online Classes, Advanced Reports, System Settings</p>
            </div>
        </div>
    </div>

    <div class="card bg-light mt-4">
        <div class="card-body">
            <h5 class="card-title">System Statistics</h5>
            <div class="row text-center">
                <div class="col-md-3">
                    <h3 class="text-primary">22</h3>
                    <p class="text-muted mb-0">Total Modules</p>
                </div>
                <div class="col-md-3">
                    <h3 class="text-success">18</h3>
                    <p class="text-muted mb-0">Active Modules</p>
                </div>
                <div class="col-md-3">
                    <h3 class="text-info">70+</h3>
                    <p class="text-muted mb-0">Features</p>
                </div>
                <div class="col-md-3">
                    <h3 class="text-warning">100%</h3>
                    <p class="text-muted mb-0">Navigation Ready</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
