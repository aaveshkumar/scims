<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'School Management System' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #858796;
            --success-color: #1cc88a;
            --danger-color: #e74a3b;
            --warning-color: #f6c23e;
            --info-color: #36b9cc;
        }
        body {
            font-family: 'Nunito', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f8f9fc;
        }
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, var(--primary-color) 10%, #224abe 100%);
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 0.75rem 1rem;
            border-radius: 0.35rem;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
        }
        .sidebar .nav-link i {
            margin-right: 0.5rem;
            width: 20px;
        }
        .card {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        .card-header {
            background-color: #f8f9fc;
            border-bottom: 1px solid #e3e6f0;
            padding: 0.75rem 1.25rem;
            font-weight: 600;
        }
        .btn {
            border-radius: 0.35rem;
            padding: 0.375rem 1rem;
        }
        .table {
            color: #858796;
        }
        .table thead th {
            border-bottom: 2px solid #e3e6f0;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.75rem;
            color: var(--primary-color);
        }
        .badge {
            padding: 0.35em 0.65em;
            font-weight: 600;
        }
        .topbar {
            height: 4.375rem;
            background-color: #fff;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        
        /* Dark Mode Styles */
        [data-bs-theme="dark"] {
            --primary-color: #5a8dee;
            --secondary-color: #a8b1bd;
            --success-color: #28c76f;
            --danger-color: #ea5455;
            --warning-color: #ff9f43;
            --info-color: #00cfe8;
        }
        [data-bs-theme="dark"] body {
            background-color: #1a1d20 !important;
            color: #e9ecef !important;
        }
        [data-bs-theme="dark"] .card {
            background-color: #2d3238;
            color: #e9ecef !important;
        }
        [data-bs-theme="dark"] .card-header {
            background-color: #3a3f47;
            border-bottom-color: #4a5058;
            color: #e9ecef !important;
        }
        [data-bs-theme="dark"] .topbar,
        [data-bs-theme="dark"] .navbar {
            background-color: #2d3238 !important;
            border-bottom-color: #3a3f47 !important;
        }
        [data-bs-theme="dark"] .table {
            color: #e9ecef !important;
        }
        [data-bs-theme="dark"] .table thead th {
            color: #5a8dee !important;
            border-bottom-color: #3a3f47;
        }
        [data-bs-theme="dark"] .table tbody td {
            color: #e9ecef !important;
        }
        [data-bs-theme="dark"] .form-control,
        [data-bs-theme="dark"] .form-select {
            background-color: #3a3f47;
            border-color: #4a5058;
            color: #e9ecef !important;
        }
        [data-bs-theme="dark"] .form-control::placeholder {
            color: #6c757d !important;
        }
        [data-bs-theme="dark"] .form-control:focus,
        [data-bs-theme="dark"] .form-select:focus {
            background-color: #3a3f47;
            color: #e9ecef !important;
            border-color: #5a8dee;
        }
        [data-bs-theme="dark"] .form-label {
            color: #e9ecef !important;
        }
        [data-bs-theme="dark"] .dropdown-menu {
            background-color: #2d3238;
            border-color: #3a3f47;
        }
        [data-bs-theme="dark"] .dropdown-item {
            color: #e9ecef !important;
        }
        [data-bs-theme="dark"] .dropdown-item:hover {
            background-color: #3a3f47;
            color: #fff !important;
        }
        [data-bs-theme="dark"] .dropdown-header {
            color: #a8b1bd !important;
        }
        [data-bs-theme="dark"] .nav-link {
            color: #a8b1bd !important;
        }
        [data-bs-theme="dark"] .nav-link:hover {
            color: #e9ecef !important;
        }
        [data-bs-theme="dark"] h1,
        [data-bs-theme="dark"] h2,
        [data-bs-theme="dark"] h3,
        [data-bs-theme="dark"] h4,
        [data-bs-theme="dark"] h5,
        [data-bs-theme="dark"] h6 {
            color: #e9ecef !important;
        }
        [data-bs-theme="dark"] p,
        [data-bs-theme="dark"] span,
        [data-bs-theme="dark"] div {
            color: #e9ecef;
        }
        [data-bs-theme="dark"] .text-muted {
            color: #a8b1bd !important;
        }
        [data-bs-theme="dark"] .btn-primary {
            background-color: #5a8dee;
            border-color: #5a8dee;
        }
        [data-bs-theme="dark"] .btn-outline-primary {
            color: #5a8dee;
            border-color: #5a8dee;
        }
        [data-bs-theme="dark"] .btn-outline-primary:hover {
            background-color: #5a8dee;
            color: #fff;
        }
        [data-bs-theme="dark"] .alert {
            color: #e9ecef;
        }
    </style>
</head>
<body>
    <div class="d-flex">
        <?php if (isAuth()): ?>
            <?php include __DIR__ . '/sidebar.php'; ?>
        <?php endif; ?>
        
        <div class="flex-grow-1" style="<?= isAuth() ? 'margin-left: 260px;' : '' ?>">
            <?php if (isAuth()): ?>
                <?php include __DIR__ . '/navbar.php'; ?>
            <?php endif; ?>
            
            <div class="container-fluid p-4">
                <?php if (isset($_SESSION['flash'])): ?>
                    <?php foreach ($_SESSION['flash'] as $type => $message): ?>
                        <div class="alert alert-<?= $type === 'error' ? 'danger' : $type ?> alert-dismissible fade show" role="alert">
                            <?= htmlspecialchars($message) ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endforeach; ?>
                    <?php unset($_SESSION['flash']); ?>
                <?php endif; ?>
