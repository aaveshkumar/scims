<?php $hideLayout = !isAuth(); ?>
<?php if (!$hideLayout) include __DIR__ . '/../layouts/header.php'; ?>

<?php if ($hideLayout): ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Application - SCIMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 50px 0; }
    </style>
</head>
<body>
<?php endif; ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <?php if ($hideLayout): ?>
            <div class="text-center mb-4">
                <h2 class="text-white"><i class="bi bi-mortarboard-fill"></i> SCIMS</h2>
                <p class="text-white">School Management System</p>
            </div>
            <?php endif; ?>

            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="bi bi-search me-2"></i>Track Application Status</h4>
                </div>
                <div class="card-body">
                    <form method="GET" action="/admission/track" class="mb-4">
                        <div class="input-group input-group-lg">
                            <input type="text" class="form-control" name="number" 
                                   placeholder="Enter your Application Number (e.g., ADM20250001)" 
                                   value="<?= htmlspecialchars($applicationNumber) ?>" required>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-search me-2"></i>Track
                            </button>
                        </div>
                        <small class="text-muted">Enter the application number you received after submission</small>
                    </form>

                    <?php if ($applicationNumber && !$admission): ?>
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            No application found with number <strong><?= htmlspecialchars($applicationNumber) ?></strong>. 
                            Please check and try again.
                        </div>
                    <?php endif; ?>

                    <?php if ($admission): ?>
                        <div class="alert alert-success">
                            <i class="bi bi-check-circle me-2"></i>
                            Application found! Here's your status:
                        </div>

                        <div class="card bg-light mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Application Details</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Application Number:</strong> <?= htmlspecialchars($admission['application_number']) ?></p>
                                        <p><strong>Name:</strong> <?= htmlspecialchars($admission['first_name'] . ' ' . $admission['last_name']) ?></p>
                                        <p><strong>Email:</strong> <?= htmlspecialchars($admission['email']) ?></p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Course:</strong> <?= htmlspecialchars($admission['course_name'] ?? 'N/A') ?></p>
                                        <p><strong>Class:</strong> <?= htmlspecialchars($admission['class_name'] ?? 'N/A') ?></p>
                                        <p><strong>Applied Date:</strong> <?= date('M d, Y', strtotime($admission['created_at'])) ?></p>
                                    </div>
                                </div>
                                
                                <div class="mt-3">
                                    <strong>Status:</strong> 
                                    <?php
                                    $statusColors = [
                                        'pending' => 'warning',
                                        'approved' => 'success',
                                        'rejected' => 'danger',
                                        'waitlisted' => 'info',
                                        'completed' => 'primary'
                                    ];
                                    $color = $statusColors[$admission['status']] ?? 'secondary';
                                    ?>
                                    <span class="badge bg-<?= $color ?> fs-6"><?= ucfirst($admission['status']) ?></span>
                                </div>

                                <?php if ($admission['remarks']): ?>
                                <div class="mt-3">
                                    <strong>Remarks:</strong>
                                    <p class="mb-0"><?= htmlspecialchars($admission['remarks']) ?></p>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>

                        <?php if (!empty($timeline)): ?>
                        <h5>Application Timeline</h5>
                        <div class="timeline">
                            <?php foreach ($timeline as $index => $event): ?>
                            <div class="d-flex mb-3">
                                <div class="flex-shrink-0">
                                    <div class="bg-<?= $event['color'] ?> text-white rounded-circle d-flex align-items-center justify-content-center" 
                                         style="width: 40px; height: 40px;">
                                        <i class="bi bi-<?= $event['icon'] ?>"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0"><?= htmlspecialchars($event['action']) ?></h6>
                                    <small class="text-muted">
                                        <?= date('M d, Y h:i A', strtotime($event['date'])) ?> by <?= htmlspecialchars($event['user']) ?>
                                    </small>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>

                        <?php if ($admission['status'] === 'pending'): ?>
                        <div class="alert alert-info mt-4">
                            <i class="bi bi-info-circle me-2"></i>
                            Your application is under review. You will be notified once a decision is made.
                        </div>
                        <?php elseif ($admission['status'] === 'approved'): ?>
                        <div class="alert alert-success mt-4">
                            <i class="bi bi-check-circle me-2"></i>
                            Congratulations! Your application has been approved. Please contact the administration for next steps.
                        </div>
                        <?php elseif ($admission['status'] === 'completed'): ?>
                        <div class="alert alert-primary mt-4">
                            <i class="bi bi-person-check me-2"></i>
                            Your admission is complete! You can now login to the student portal with your credentials.
                        </div>
                        <?php endif; ?>

                        <div class="text-center mt-4">
                            <a href="/admission/track" class="btn btn-secondary">Track Another Application</a>
                            <?php if (!isAuth()): ?>
                            <a href="/admissions/create" class="btn btn-primary">Submit New Application</a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!$admission && !$applicationNumber): ?>
                        <div class="text-center text-muted">
                            <i class="bi bi-info-circle fs-1 d-block mb-3"></i>
                            <p>Enter your application number above to track your admission status</p>
                            <?php if (!isAuth()): ?>
                            <p class="mt-3">
                                <a href="/admissions/create" class="btn btn-primary">Submit New Application</a>
                            </p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if ($hideLayout): ?>
</body>
</html>
<?php else: ?>
<?php include __DIR__ . '/../layouts/footer.php'; ?>
<?php endif; ?>
