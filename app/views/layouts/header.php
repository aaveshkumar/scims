<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?= csrf_token() ?>">
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
        }
        [data-bs-theme="light"] body {
            background-color: #f8f9fc;
        }
        [data-bs-theme="dark"] body {
            background-color: #1a1d20 !important;
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
        [data-bs-theme="light"] .card-header {
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
        /* Light Mode Navbar */
        [data-bs-theme="light"] .navbar.topbar,
        .navbar.topbar {
            height: 4.375rem;
            background-color: #4e73df !important;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        [data-bs-theme="light"] .navbar.topbar .nav-link,
        .navbar.topbar .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
        }
        [data-bs-theme="light"] .navbar.topbar .nav-link:hover,
        .navbar.topbar .nav-link:hover {
            color: #fff !important;
        }
        [data-bs-theme="light"] .navbar.topbar .navbar-text,
        .navbar.topbar .navbar-text {
            color: rgba(255, 255, 255, 0.9) !important;
        }
        [data-bs-theme="light"] .navbar.topbar .navbar-text strong,
        .navbar.topbar .navbar-text strong {
            color: #fff !important;
        }
        [data-bs-theme="light"] .navbar.topbar .text-muted,
        .navbar.topbar .text-muted {
            color: rgba(255, 255, 255, 0.7) !important;
        }
        [data-bs-theme="light"] .navbar.topbar .badge,
        .navbar.topbar .badge {
            color: #fff !important;
        }
        [data-bs-theme="light"] .navbar.topbar .dropdown-toggle::after,
        .navbar.topbar .dropdown-toggle::after {
            color: rgba(255, 255, 255, 0.9);
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
            background-color: #2d3238 !important;
            color: #e9ecef !important;
        }
        [data-bs-theme="dark"] .card-body {
            background-color: #2d3238 !important;
            color: #e9ecef !important;
        }
        [data-bs-theme="dark"] .card-header {
            background-color: #3a3f47 !important;
            border-bottom-color: #4a5058 !important;
            color: #e9ecef !important;
        }
        /* Dark Mode Navbar */
        [data-bs-theme="dark"] .navbar.topbar {
            background-color: #2d3238 !important;
            border-bottom-color: #3a3f47 !important;
        }
        [data-bs-theme="dark"] .navbar.topbar .nav-link {
            color: #a8b1bd !important;
        }
        [data-bs-theme="dark"] .navbar.topbar .nav-link:hover {
            color: #e9ecef !important;
        }
        [data-bs-theme="dark"] .navbar.topbar .navbar-text {
            color: #a8b1bd !important;
        }
        [data-bs-theme="dark"] .navbar.topbar .navbar-text strong {
            color: #e9ecef !important;
        }
        [data-bs-theme="dark"] .navbar.topbar .text-muted {
            color: rgba(168, 177, 189, 0.7) !important;
        }
        [data-bs-theme="dark"] .navbar.topbar .badge {
            color: #fff !important;
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
            color: #e9ecef !important;
        }
        [data-bs-theme="dark"] .nav-link:hover {
            color: #fff !important;
        }
        [data-bs-theme="dark"] .nav-tabs .nav-link {
            color: #e9ecef !important;
        }
        [data-bs-theme="dark"] .nav-tabs .nav-link:hover {
            color: #fff !important;
        }
        [data-bs-theme="dark"] .nav-tabs .nav-link.active {
            color: #fff !important;
            border-bottom-color: #5a8dee;
        }
        [data-bs-theme="dark"] .notification-unread {
            background-color: #3a3f47 !important;
            color: #e9ecef !important;
        }
        [data-bs-theme="dark"] .notification-unread h6,
        [data-bs-theme="dark"] .notification-unread p,
        [data-bs-theme="dark"] .notification-unread small {
            color: #e9ecef !important;
        }
        [data-bs-theme="dark"] .list-group-item {
            background-color: #2d3238 !important;
            border-color: #3a3f47 !important;
            color: #e9ecef !important;
        }
        [data-bs-theme="dark"] .list-group-item h6 {
            color: #e9ecef !important;
        }
        [data-bs-theme="dark"] .list-group-item p {
            color: #e9ecef !important;
        }
        [data-bs-theme="dark"] .list-group-item small {
            color: #a8b1bd !important;
        }
        [data-bs-theme="dark"] .list-group-item .text-muted {
            color: #a8b1bd !important;
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
        
        #page-loader {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }
        #page-loader.active {
            display: flex;
        }
        .loader-spinner {
            width: 50px;
            height: 50px;
            border: 4px solid rgba(255, 255, 255, 0.3);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Light Mode Only - Black text on white backgrounds */
        [data-bs-theme="light"] .card {
            color: #000 !important;
            background-color: #fff !important;
        }
        [data-bs-theme="light"] .card-body, 
        [data-bs-theme="light"] .card-text {
            color: #000 !important;
        }
        [data-bs-theme="light"] .card-header {
            color: #000 !important;
            background-color: #f8f9fc !important;
        }
        [data-bs-theme="light"] .table tbody td {
            color: #000 !important;
        }
        [data-bs-theme="light"] .form-label {
            color: #000 !important;
        }
        [data-bs-theme="light"] .form-control, 
        [data-bs-theme="light"] .form-select {
            color: #000 !important;
            background-color: #fff !important;
        }
        [data-bs-theme="light"] .form-control::placeholder {
            color: #999 !important;
        }
        [data-bs-theme="light"] .dropdown-menu {
            color: #000 !important;
            background-color: #fff !important;
        }
        [data-bs-theme="light"] .dropdown-item {
            color: #000 !important;
        }
        [data-bs-theme="light"] .dropdown-item:hover, 
        [data-bs-theme="light"] .dropdown-item.active {
            color: #000 !important;
        }
        [data-bs-theme="light"] textarea.form-control {
            color: #000 !important;
        }
        [data-bs-theme="light"] .nav-tabs .nav-link {
            color: #000 !important;
        }
        [data-bs-theme="light"] .nav-tabs .nav-link.active {
            color: #000 !important;
        }
    </style>
</head>
<body>
    <div id="page-loader">
        <div class="loader-spinner"></div>
    </div>
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
