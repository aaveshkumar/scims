<?php include __DIR__ . '/layouts/header.php'; ?>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center py-5">
            <div class="card shadow-lg border-0">
                <div class="card-body py-5">
                    <div class="mb-4">
                        <i class="bi bi-tools text-primary" style="font-size: 5rem;"></i>
                    </div>
                    
                    <h2 class="mb-3"><?= htmlspecialchars($module ?? 'Module') ?></h2>
                    
                    <p class="lead text-muted mb-4">
                        This module is currently under development and will be available soon.
                    </p>
                    
                    <div class="alert alert-info d-inline-block">
                        <i class="bi bi-info-circle me-2"></i>
                        The navigation structure is ready. Backend functionality is being implemented.
                    </div>
                    
                    <div class="mt-4">
                        <a href="/dashboard" class="btn btn-primary btn-lg">
                            <i class="bi bi-house-door me-2"></i>Back to Dashboard
                        </a>
                    </div>
                    
                    <div class="mt-5 pt-4 border-top">
                        <h5 class="mb-3">What's Coming:</h5>
                        <div class="row text-start">
                            <div class="col-md-6">
                                <ul class="list-unstyled">
                                    <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Full CRUD Operations</li>
                                    <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Advanced Filtering</li>
                                    <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Export to PDF/Excel</li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <ul class="list-unstyled">
                                    <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Real-time Notifications</li>
                                    <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Role-based Access</li>
                                    <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Mobile Responsive Design</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="mt-4">
                <small class="text-muted">
                    <i class="bi bi-lightbulb me-1"></i>
                    Have suggestions for this module? Contact your system administrator.
                </small>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/layouts/footer.php'; ?>
