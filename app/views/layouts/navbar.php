<nav class="topbar navbar navbar-expand navbar-light bg-white border-bottom mb-4 shadow-sm" style="margin-left: 260px;">
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
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="/invoices/create"><i class="bi bi-receipt me-2"></i> Create Invoice</a></li>
                    <li><a class="dropdown-item" href="/admissions/create"><i class="bi bi-file-earmark-text me-2"></i> New Admission</a></li>
                </ul>
            </li>
            <?php endif; ?>

            <!-- Notifications -->
            <li class="nav-item dropdown me-3">
                <a class="nav-link position-relative" href="/notifications">
                    <i class="bi bi-bell fs-5"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
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
                    <li><a class="dropdown-item" href="/notifications"><i class="bi bi-bell me-2"></i> Notifications</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="/logout"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
