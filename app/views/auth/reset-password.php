<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - SCIMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8">
                <div class="card border-0 shadow-lg" style="border-radius: 1rem;">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <i class="bi bi-shield-lock-fill text-primary" style="font-size: 3rem;"></i>
                            <h3 class="mt-3 fw-bold">Reset Password</h3>
                            <p class="text-muted">Enter OTP and new password</p>
                        </div>

                        <?php if (isset($_SESSION['flash'])): ?>
                            <?php foreach ($_SESSION['flash'] as $type => $message): ?>
                                <div class="alert alert-<?= $type === 'error' ? 'danger' : $type ?>">
                                    <?= htmlspecialchars($message) ?>
                                </div>
                            <?php endforeach; ?>
                            <?php unset($_SESSION['flash']); ?>
                        <?php endif; ?>

                        <form method="POST" action="/reset-password">
                            <input type="hidden" name="_token" value="<?= csrf() ?>">
                            <input type="hidden" name="email" value="<?= htmlspecialchars($email ?? '') ?>">
                            
                            <div class="mb-3">
                                <label class="form-label">OTP Code</label>
                                <input type="text" name="otp" class="form-control" placeholder="Enter 6-digit OTP" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">New Password</label>
                                <input type="password" name="password" class="form-control" minlength="6" placeholder="Enter new password" required>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 py-2 mb-3">
                                <i class="bi bi-check-circle me-2"></i> Reset Password
                            </button>
                        </form>

                        <div class="text-center">
                            <a href="/login" class="text-decoration-none"><i class="bi bi-arrow-left me-2"></i>Back to Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
