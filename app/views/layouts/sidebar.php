<!-- Sidebar -->
<div class="sidebar-container d-flex flex-column" style="width: 260px; min-height: 100vh; position: fixed; top: 0; left: 0; overflow-y: auto; overflow-x: hidden; z-index: 1000; scrollbar-width: none; -ms-overflow-style: none; background-color: var(--sidebar-bg);">
    <!-- Logo/Brand -->
    <div class="p-3 sidebar-header">
        <h4 class="mb-0 sidebar-title"><i class="bi bi-mortarboard-fill me-2"></i>SCIMS</h4>
        <small class="sidebar-subtitle">School Management</small>
    </div>

    <!-- Scrollable Menu Container -->
    <nav class="flex-grow-1" style="max-height: calc(100vh - 120px); overflow-y: auto; scrollbar-width: none; -ms-overflow-style: none;">
        <div class="list-group list-group-flush">
            <!-- Dashboard -->
            <a href="/dashboard" class="sidebar-link list-group-item list-group-item-action border-0">
                <i class="bi bi-speedometer2 me-2"></i>Dashboard
            </a>

            <?php if (hasRole('admin')): ?>
            
            <!-- Admissions Menu -->
            <div class="accordion accordion-flush" id="admissionsMenu">
                <div class="accordion-item sidebar-accordion-item border-0">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed sidebar-accordion-btn" type="button" data-bs-toggle="collapse" data-bs-target="#admissionsCollapse">
                            <i class="bi bi-file-earmark-text me-2"></i>Admissions
                        </button>
                    </h2>
                    <div id="admissionsCollapse" class="accordion-collapse collapse" data-bs-parent="#admissionsMenu">
                        <div class="accordion-body p-0">
                            <a href="/admissions" class="sidebar-link list-group-item list-group-item-action border-0 ps-4">All Applications</a>
                            <a href="/admissions/create" class="sidebar-link list-group-item list-group-item-action border-0 ps-4">New Application</a>
                            <a href="/admissions/statistics" class="sidebar-link list-group-item list-group-item-action border-0 ps-4">Statistics</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Users Menu -->
            <div class="accordion accordion-flush" id="usersMenu">
                <div class="accordion-item sidebar-accordion-item border-0">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed sidebar-accordion-btn" type="button" data-bs-toggle="collapse" data-bs-target="#usersCollapse">
                            <i class="bi bi-people me-2"></i>Users
                        </button>
                    </h2>
                    <div id="usersCollapse" class="accordion-collapse collapse" data-bs-parent="#usersMenu">
                        <div class="accordion-body p-0">
                            <a href="/students" class="sidebar-link list-group-item list-group-item-action border-0 ps-4">Students</a>
                            <a href="/staff" class="sidebar-link list-group-item list-group-item-action border-0 ps-4">Staff</a>
                            <a href="/roles" class="sidebar-link list-group-item list-group-item-action border-0 ps-4">Roles & Permissions</a>
                            <a href="/departments" class="sidebar-link list-group-item list-group-item-action border-0 ps-4">Departments</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Academic Menu -->
            <div class="accordion accordion-flush" id="academicMenu">
                <div class="accordion-item sidebar-accordion-item border-0">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed sidebar-accordion-btn" type="button" data-bs-toggle="collapse" data-bs-target="#academicCollapse">
                            <i class="bi bi-book me-2"></i>Academic
                        </button>
                    </h2>
                    <div id="academicCollapse" class="accordion-collapse collapse" data-bs-parent="#academicMenu">
                        <div class="accordion-body p-0">
                            <a href="/courses" class="sidebar-link list-group-item list-group-item-action border-0 ps-4">Courses</a>
                            <a href="/classes" class="sidebar-link list-group-item list-group-item-action border-0 ps-4">Classes</a>
                            <a href="/subjects" class="sidebar-link list-group-item list-group-item-action border-0 ps-4">Subjects</a>
                            <a href="/syllabus" class="sidebar-link list-group-item list-group-item-action border-0 ps-4">Syllabus</a>
                            <a href="/lesson-plans" class="sidebar-link list-group-item list-group-item-action border-0 ps-4">Lesson Plans</a>
                            <a href="/question-bank" class="sidebar-link list-group-item list-group-item-action border-0 ps-4">Question Bank</a>
                            <a href="/academic-calendar" class="sidebar-link list-group-item list-group-item-action border-0 ps-4">Calendar</a>
                        </div>
                    </div>
                </div>
            </div>

            <?php endif; ?>

            <!-- Operations Menu (Admin + Teacher) -->
            <?php if (hasRole('admin') || hasRole('teacher')): ?>
            <div class="accordion accordion-flush" id="operationsMenu">
                <div class="accordion-item sidebar-accordion-item border-0">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed sidebar-accordion-btn" type="button" data-bs-toggle="collapse" data-bs-target="#operationsCollapse">
                            <i class="bi bi-calendar3 me-2"></i>Operations
                        </button>
                    </h2>
                    <div id="operationsCollapse" class="accordion-collapse collapse" data-bs-parent="#operationsMenu">
                        <div class="accordion-body p-0">
                            <a href="/timetable" class="sidebar-link list-group-item list-group-item-action border-0 ps-4">Timetable</a>
                            <a href="/attendance" class="sidebar-link list-group-item list-group-item-action border-0 ps-4">Attendance</a>
                            <a href="/leave" class="sidebar-link list-group-item list-group-item-action border-0 ps-4">Leave Management</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Exams Menu -->
            <div class="accordion accordion-flush" id="examsMenu">
                <div class="accordion-item sidebar-accordion-item border-0">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed sidebar-accordion-btn" type="button" data-bs-toggle="collapse" data-bs-target="#examsCollapse">
                            <i class="bi bi-clipboard-check me-2"></i>Exams
                        </button>
                    </h2>
                    <div id="examsCollapse" class="accordion-collapse collapse" data-bs-parent="#examsMenu">
                        <div class="accordion-body p-0">
                            <a href="/exams" class="sidebar-link list-group-item list-group-item-action border-0 ps-4">Exam Schedule</a>
                            <a href="/marks" class="sidebar-link list-group-item list-group-item-action border-0 ps-4">Marks Entry</a>
                            <a href="/report-cards" class="sidebar-link list-group-item list-group-item-action border-0 ps-4">Report Cards</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <?php if (hasRole('admin')): ?>
            <!-- Finance Menu -->
            <div class="accordion accordion-flush" id="financeMenu">
                <div class="accordion-item sidebar-accordion-item border-0">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed sidebar-accordion-btn" type="button" data-bs-toggle="collapse" data-bs-target="#financeCollapse">
                            <i class="bi bi-cash-stack me-2"></i>Finance
                        </button>
                    </h2>
                    <div id="financeCollapse" class="accordion-collapse collapse" data-bs-parent="#financeMenu">
                        <div class="accordion-body p-0">
                            <a href="/invoices" class="sidebar-link list-group-item list-group-item-action border-0 ps-4">Invoices</a>
                            <a href="/fee-structure" class="sidebar-link list-group-item list-group-item-action border-0 ps-4">Fee Structure</a>
                            <a href="/expenses" class="sidebar-link list-group-item list-group-item-action border-0 ps-4">Expenses</a>
                            <a href="/payroll" class="sidebar-link list-group-item list-group-item-action border-0 ps-4">Payroll</a>
                            <a href="/budget" class="sidebar-link list-group-item list-group-item-action border-0 ps-4">Budget</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Learning (LMS) Menu -->
            <div class="accordion accordion-flush" id="lmsMenu">
                <div class="accordion-item sidebar-accordion-item border-0">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed sidebar-accordion-btn" type="button" data-bs-toggle="collapse" data-bs-target="#lmsCollapse">
                            <i class="bi bi-file-earmark-pdf me-2"></i>Learning
                        </button>
                    </h2>
                    <div id="lmsCollapse" class="accordion-collapse collapse" data-bs-parent="#lmsMenu">
                        <div class="accordion-body p-0">
                            <a href="/materials" class="sidebar-link list-group-item list-group-item-action border-0 ps-4">Study Materials</a>
                            <a href="/assignments" class="sidebar-link list-group-item list-group-item-action border-0 ps-4">Assignments</a>
                            <a href="/quizzes" class="sidebar-link list-group-item list-group-item-action border-0 ps-4">Quizzes</a>
                            <a href="/forums" class="sidebar-link list-group-item list-group-item-action border-0 ps-4">Discussion Forums</a>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (hasRole('admin')): ?>
            <!-- Library Menu -->
            <div class="accordion accordion-flush" id="libraryMenu">
                <div class="accordion-item sidebar-accordion-item border-0">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed sidebar-accordion-btn" type="button" data-bs-toggle="collapse" data-bs-target="#libraryCollapse">
                            <i class="bi bi-book-half me-2"></i>Library
                        </button>
                    </h2>
                    <div id="libraryCollapse" class="accordion-collapse collapse" data-bs-parent="#libraryMenu">
                        <div class="accordion-body p-0">
                            <a href="/library/books" class="sidebar-link list-group-item list-group-item-action border-0 ps-4">Books</a>
                            <a href="/library/issue" class="sidebar-link list-group-item list-group-item-action border-0 ps-4">Issue/Return</a>
                            <a href="/library/members" class="sidebar-link list-group-item list-group-item-action border-0 ps-4">Members</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transport Menu -->
            <div class="accordion accordion-flush" id="transportMenu">
                <div class="accordion-item sidebar-accordion-item border-0">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed sidebar-accordion-btn" type="button" data-bs-toggle="collapse" data-bs-target="#transportCollapse">
                            <i class="bi bi-bus-front me-2"></i>Transport
                        </button>
                    </h2>
                    <div id="transportCollapse" class="accordion-collapse collapse" data-bs-parent="#transportMenu">
                        <div class="accordion-body p-0">
                            <a href="/transport/vehicles" class="sidebar-link list-group-item list-group-item-action border-0 ps-4">Vehicles</a>
                            <a href="/transport/routes" class="sidebar-link list-group-item list-group-item-action border-0 ps-4">Routes</a>
                            <a href="/transport/assignments" class="sidebar-link list-group-item list-group-item-action border-0 ps-4">Student Routes</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hostel Menu -->
            <div class="accordion accordion-flush" id="hostelMenu">
                <div class="accordion-item sidebar-accordion-item border-0">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed sidebar-accordion-btn" type="button" data-bs-toggle="collapse" data-bs-target="#hostelCollapse">
                            <i class="bi bi-house me-2"></i>Hostel
                        </button>
                    </h2>
                    <div id="hostelCollapse" class="accordion-collapse collapse" data-bs-parent="#hostelMenu">
                        <div class="accordion-body p-0">
                            <a href="/hostel/rooms" class="sidebar-link list-group-item list-group-item-action border-0 ps-4">Rooms</a>
                            <a href="/hostel/residents" class="sidebar-link list-group-item list-group-item-action border-0 ps-4">Residents</a>
                            <a href="/hostel/visitors" class="sidebar-link list-group-item list-group-item-action border-0 ps-4">Visitors</a>
                            <a href="/hostel/complaints" class="sidebar-link list-group-item list-group-item-action border-0 ps-4">Complaints</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Inventory Menu -->
            <div class="accordion accordion-flush" id="inventoryMenu">
                <div class="accordion-item sidebar-accordion-item border-0">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed sidebar-accordion-btn" type="button" data-bs-toggle="collapse" data-bs-target="#inventoryCollapse">
                            <i class="bi bi-box-seam me-2"></i>Inventory
                        </button>
                    </h2>
                    <div id="inventoryCollapse" class="accordion-collapse collapse" data-bs-parent="#inventoryMenu">
                        <div class="accordion-body p-0">
                            <a href="/inventory/assets" class="sidebar-link list-group-item list-group-item-action border-0 ps-4">Assets</a>
                            <a href="/inventory/stock" class="sidebar-link list-group-item list-group-item-action border-0 ps-4">Stock</a>
                            <a href="/inventory/purchase-orders" class="sidebar-link list-group-item list-group-item-action border-0 ps-4">Purchase Orders</a>
                            <a href="/inventory/suppliers" class="sidebar-link list-group-item list-group-item-action border-0 ps-4">Suppliers</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Communication Menu -->
            <div class="accordion accordion-flush" id="communicationMenu">
                <div class="accordion-item sidebar-accordion-item border-0">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed sidebar-accordion-btn" type="button" data-bs-toggle="collapse" data-bs-target="#communicationCollapse">
                            <i class="bi bi-chat-dots me-2"></i>Communication
                        </button>
                    </h2>
                    <div id="communicationCollapse" class="accordion-collapse collapse" data-bs-parent="#communicationMenu">
                        <div class="accordion-body p-0">
                            <a href="/notifications" class="sidebar-link list-group-item list-group-item-action border-0 ps-4">Notifications</a>
                            <a href="/announcements" class="sidebar-link list-group-item list-group-item-action border-0 ps-4">Announcements</a>
                            <a href="/messages" class="sidebar-link list-group-item list-group-item-action border-0 ps-4">Messages</a>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (hasRole('admin')): ?>
            <!-- Reports Menu -->
            <div class="accordion accordion-flush" id="reportsMenu">
                <div class="accordion-item sidebar-accordion-item border-0">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed sidebar-accordion-btn" type="button" data-bs-toggle="collapse" data-bs-target="#reportsCollapse">
                            <i class="bi bi-graph-up me-2"></i>Reports
                        </button>
                    </h2>
                    <div id="reportsCollapse" class="accordion-collapse collapse" data-bs-parent="#reportsMenu">
                        <div class="accordion-body p-0">
                            <a href="/reports/attendance" class="sidebar-link list-group-item list-group-item-action border-0 ps-4">Attendance Reports</a>
                            <a href="/reports/academic" class="sidebar-link list-group-item list-group-item-action border-0 ps-4">Academic Reports</a>
                            <a href="/reports/financial" class="sidebar-link list-group-item list-group-item-action border-0 ps-4">Financial Reports</a>
                            <a href="/reports/custom" class="sidebar-link list-group-item list-group-item-action border-0 ps-4">Custom Reports</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Settings Menu -->
            <div class="accordion accordion-flush" id="settingsMenu">
                <div class="accordion-item sidebar-accordion-item border-0">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed sidebar-accordion-btn" type="button" data-bs-toggle="collapse" data-bs-target="#settingsCollapse">
                            <i class="bi bi-gear me-2"></i>Settings
                        </button>
                    </h2>
                    <div id="settingsCollapse" class="accordion-collapse collapse" data-bs-parent="#settingsMenu">
                        <div class="accordion-body p-0">
                            <a href="/settings" class="sidebar-link list-group-item list-group-item-action border-0 ps-4">System Settings</a>
                            <a href="/settings/backup" class="sidebar-link list-group-item list-group-item-action border-0 ps-4">Backup & Restore</a>
                            <a href="/settings/audit-logs" class="sidebar-link list-group-item list-group-item-action border-0 ps-4">Audit Logs</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- All Features -->
            <a href="/features" class="sidebar-link list-group-item list-group-item-action border-0">
                <i class="bi bi-grid me-2"></i>All Features
            </a>
        </div>
    </nav>

    <!-- User Info at Bottom -->
    <div class="p-3 sidebar-footer">
        <div class="d-flex align-items-center">
            <div class="flex-grow-1">
                <div class="fw-bold sidebar-user-name"><?= htmlspecialchars(auth()['first_name'] ?? 'User') ?></div>
                <small class="sidebar-user-role"><?= ucfirst(auth()['role'] ?? 'User') ?></small>
            </div>
            <a href="/logout" class="btn btn-sm sidebar-logout-btn" title="Logout">
                <i class="bi bi-box-arrow-right"></i>
            </a>
        </div>
    </div>
</div>

<style>
/* Theme-Aware Sidebar Styling */

/* Sidebar Layout Fixes */
.sidebar-container {
    box-sizing: border-box;
}

.sidebar-header {
    box-sizing: border-box;
    max-width: 100%;
    overflow: hidden;
}

.sidebar-header .sidebar-title {
    font-size: 1.25rem;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 100%;
}

.sidebar-header .sidebar-subtitle {
    display: block;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 100%;
}

.sidebar-footer {
    box-sizing: border-box;
    max-width: 100%;
    overflow: hidden;
}

.sidebar-footer .d-flex {
    max-width: 100%;
}

.sidebar-footer .sidebar-user-name,
.sidebar-footer .sidebar-user-role {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 180px;
}

/* CSS Variables for Sidebar */
:root {
    --sidebar-bg: #4e73df;
}

body.dark-mode {
    --sidebar-bg: #212529;
}

/* Light Mode Sidebar */
body:not(.dark-mode) .sidebar-container {
    background-color: #4e73df !important;
}

body:not(.dark-mode) .sidebar-header {
    border-bottom: 1px solid rgba(255, 255, 255, 0.15) !important;
}

body:not(.dark-mode) .sidebar-title,
body:not(.dark-mode) .sidebar-subtitle {
    color: #ffffff !important;
}

body:not(.dark-mode) .sidebar-link {
    background-color: transparent !important;
    color: #ffffff !important;
}

body:not(.dark-mode) .sidebar-link:hover {
    background-color: rgba(255, 255, 255, 0.1) !important;
    color: #ffffff !important;
}

body:not(.dark-mode) .sidebar-accordion-item {
    background-color: transparent !important;
}

body:not(.dark-mode) .sidebar-accordion-btn {
    background-color: transparent !important;
    color: #ffffff !important;
}

body:not(.dark-mode) .sidebar-accordion-btn:hover {
    background-color: rgba(255, 255, 255, 0.1) !important;
}

body:not(.dark-mode) .sidebar-accordion-btn:not(.collapsed) {
    background-color: rgba(255, 255, 255, 0.15) !important;
    color: #ffffff !important;
}

body:not(.dark-mode) .sidebar-container .accordion-body {
    background-color: transparent !important;
}

body:not(.dark-mode) .sidebar-footer {
    border-top: 1px solid rgba(255, 255, 255, 0.15) !important;
}

body:not(.dark-mode) .sidebar-user-name,
body:not(.dark-mode) .sidebar-user-role {
    color: #ffffff !important;
}

body:not(.dark-mode) .sidebar-logout-btn {
    border-color: #ffffff !important;
    color: #ffffff !important;
}

body:not(.dark-mode) .sidebar-logout-btn:hover {
    background-color: #ffffff !important;
    color: #4e73df !important;
}

/* Dark Mode Sidebar */
body.dark-mode .sidebar-container {
    background-color: #212529 !important;
}

body.dark-mode .sidebar-header {
    border-bottom: 1px solid rgba(233, 236, 239, 0.1) !important;
}

body.dark-mode .sidebar-title,
body.dark-mode .sidebar-subtitle {
    color: #e9ecef !important;
}

body.dark-mode .sidebar-link {
    background-color: transparent !important;
    color: #e9ecef !important;
}

body.dark-mode .sidebar-link:hover {
    background-color: rgba(233, 236, 239, 0.1) !important;
    color: #e9ecef !important;
}

body.dark-mode .sidebar-accordion-item {
    background-color: transparent !important;
}

body.dark-mode .sidebar-accordion-btn {
    background-color: transparent !important;
    color: #e9ecef !important;
}

body.dark-mode .sidebar-accordion-btn:hover {
    background-color: rgba(233, 236, 239, 0.05) !important;
}

body.dark-mode .sidebar-accordion-btn:not(.collapsed) {
    background-color: rgba(233, 236, 239, 0.15) !important;
    color: #e9ecef !important;
}

body.dark-mode .sidebar-container .accordion-body {
    background-color: transparent !important;
}

body.dark-mode .sidebar-footer {
    border-top: 1px solid rgba(233, 236, 239, 0.1) !important;
}

body.dark-mode .sidebar-user-name,
body.dark-mode .sidebar-user-role {
    color: #e9ecef !important;
}

body.dark-mode .sidebar-logout-btn {
    border-color: #e9ecef !important;
    color: #e9ecef !important;
}

body.dark-mode .sidebar-logout-btn:hover {
    background-color: #e9ecef !important;
    color: #2d3238 !important;
}

/* Custom scrollbar for sidebar - HIDDEN */
.sidebar-container::-webkit-scrollbar {
    width: 0px;
    display: none;
}

body:not(.dark-mode) .sidebar-container::-webkit-scrollbar-track {
    background: rgba(255, 255, 255, 0.1);
}

body:not(.dark-mode) .sidebar-container::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.3);
    border-radius: 3px;
}

body:not(.dark-mode) .sidebar-container::-webkit-scrollbar-thumb:hover {
    background: rgba(255, 255, 255, 0.5);
}

body.dark-mode .sidebar-container::-webkit-scrollbar-track {
    background: rgba(0, 0, 0, 0.2);
}

body.dark-mode .sidebar-container::-webkit-scrollbar-thumb {
    background: rgba(233, 236, 239, 0.2);
    border-radius: 3px;
}

body.dark-mode .sidebar-container::-webkit-scrollbar-thumb:hover {
    background: rgba(233, 236, 239, 0.3);
}

/* Sidebar-specific accordion styling */
.sidebar-container .accordion-button:focus {
    box-shadow: none;
}
</style>
