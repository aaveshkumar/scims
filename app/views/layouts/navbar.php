<nav class="topbar navbar navbar-expand navbar-light bg-white border-bottom mb-4 shadow-sm">
    <div class="container-fluid">
        <button class="btn btn-link d-md-none" id="sidebarToggle">
            <i class="bi bi-list fs-4"></i>
        </button>

        <div class="d-flex align-items-center">
            <span class="text-muted small">
                <?php 
                $user = auth();
                $roleName = 'User';
                if (hasRole('admin')) $roleName = 'Administrator';
                elseif (hasRole('teacher')) $roleName = 'Teacher';
                elseif (hasRole('student')) $roleName = 'Student';
                ?>
                Welcome, <strong><?= htmlspecialchars($user['first_name'] . ' ' . $user['last_name']) ?></strong> 
                <span class="badge bg-primary ms-2"><?= $roleName ?></span>
            </span>
        </div>

        <ul class="navbar-nav ms-auto">
            <!-- Theme Toggle -->
            <li class="nav-item me-3">
                <button class="btn btn-link nav-link" id="themeToggle" title="Toggle Dark Mode">
                    <i class="bi bi-moon-stars-fill fs-5" id="themeIcon"></i>
                </button>
            </li>

            <!-- Quick Actions Dropdown -->
            <?php if (hasRole('admin')): ?>
            <li class="nav-item dropdown me-3">
                <a class="nav-link dropdown-toggle" href="#" id="quickActionsDropdown" role="button" data-bs-toggle="dropdown">
                    <i class="bi bi-lightning-fill text-warning"></i> Quick Actions
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow">
                    <li><h6 class="dropdown-header">Create New</h6></li>
                    <li><a class="dropdown-item" href="/students/create"><i class="bi bi-person-plus me-2"></i> New Student</a></li>
                    <li><a class="dropdown-item" href="/staff/create"><i class="bi bi-person-badge me-2"></i> New Staff</a></li>
                    <li><a class="dropdown-item" href="/courses/create"><i class="bi bi-book me-2"></i> New Course</a></li>
                    <li><a class="dropdown-item" href="/classes/create"><i class="bi bi-building me-2"></i> New Class</a></li>
                    <li><a class="dropdown-item" href="/subjects/create"><i class="bi bi-journal-bookmark me-2"></i> New Subject</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="/invoices/create"><i class="bi bi-receipt me-2"></i> Create Invoice</a></li>
                    <li><a class="dropdown-item" href="/admissions/create"><i class="bi bi-file-earmark-text me-2"></i> New Admission</a></li>
                    <li><a class="dropdown-item" href="/exams/create"><i class="bi bi-clipboard-check me-2"></i> New Exam</a></li>
                </ul>
            </li>
            <?php endif; ?>

            <!-- Reports Menu -->
            <?php if (hasRole('admin') || hasRole('teacher')): ?>
            <li class="nav-item dropdown me-3">
                <a class="nav-link dropdown-toggle" href="#" id="reportsDropdown" role="button" data-bs-toggle="dropdown">
                    <i class="bi bi-graph-up"></i> Reports
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow">
                    <li><h6 class="dropdown-header">Academic Reports</h6></li>
                    <li><a class="dropdown-item" href="/attendance/report"><i class="bi bi-calendar-check me-2"></i> Attendance Report</a></li>
                    <li><a class="dropdown-item" href="/marks"><i class="bi bi-award me-2"></i> Marks Report</a></li>
                    <?php if (hasRole('admin')): ?>
                    <li><hr class="dropdown-divider"></li>
                    <li><h6 class="dropdown-header">Finance Reports</h6></li>
                    <li><a class="dropdown-item" href="/invoices/defaulters"><i class="bi bi-exclamation-triangle me-2"></i> Defaulters</a></li>
                    <li><a class="dropdown-item" href="/invoices"><i class="bi bi-receipt me-2"></i> Fee Collection</a></li>
                    <?php endif; ?>
                </ul>
            </li>
            <?php endif; ?>

            <!-- Notifications -->
            <li class="nav-item dropdown me-3" style="position: relative;">
                <a class="nav-link" href="/notifications" id="notificationLink">
                    <i class="bi bi-bell fs-5" style="position: relative;"></i>
                    <span class="badge rounded-pill bg-danger" style="font-size: 0.55rem; position: absolute; top: 0; right: 0; padding: 1px 3px; line-height: 1; min-width: 14px; height: 14px; display: flex; align-items: center; justify-content: center; transform: translate(50%, -50%);" id="notificationCount">
                        0
                    </span>
                </a>
            </li>

            <!-- User Dropdown -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <span class="ms-2 d-none d-lg-inline fw-bold">
                        <?= htmlspecialchars(auth()['first_name'] ?? 'User') ?>
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow">
                    <li><h6 class="dropdown-header">My Account</h6></li>
                    <li><a class="dropdown-item" href="/dashboard"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a></li>
                    <li><a class="dropdown-item" href="/profile"><i class="bi bi-person me-2"></i> My Profile</a></li>
                    <li><a class="dropdown-item" href="/profile/documents"><i class="bi bi-file-earmark me-2"></i> My Documents</a></li>
                    <li><a class="dropdown-item" href="/profile/change-password"><i class="bi bi-key me-2"></i> Change Password</a></li>
                    <li><a class="dropdown-item" href="/notifications"><i class="bi bi-bell me-2"></i> Notifications</a></li>
                    <?php if (hasRole('admin')): ?>
                    <li><hr class="dropdown-divider"></li>
                    <li><h6 class="dropdown-header">Administration</h6></li>
                    <li><a class="dropdown-item" href="/settings"><i class="bi bi-gear me-2"></i> System Settings</a></li>
                    <li><a class="dropdown-item" href="/logs"><i class="bi bi-clock-history me-2"></i> Audit Logs</a></li>
                    <li><a class="dropdown-item" href="/integrations"><i class="bi bi-plug me-2"></i> Integrations</a></li>
                    <?php endif; ?>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="/logout"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
