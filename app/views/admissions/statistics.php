<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2>Admission Statistics</h2>
    <a href="/admissions" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back to Admissions
    </a>
</div>

<div class="row mb-4">
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body">
                <h2 class="text-primary"><?= $statistics['total'] ?></h2>
                <p class="text-muted mb-0">Total</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body">
                <h2 class="text-warning"><?= $statistics['pending'] ?></h2>
                <p class="text-muted mb-0">Pending</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body">
                <h2 class="text-success"><?= $statistics['approved'] ?></h2>
                <p class="text-muted mb-0">Approved</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body">
                <h2 class="text-danger"><?= $statistics['rejected'] ?></h2>
                <p class="text-muted mb-0">Rejected</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body">
                <h2 class="text-info"><?= $statistics['waitlisted'] ?></h2>
                <p class="text-muted mb-0">Waitlisted</p>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card text-center">
            <div class="card-body">
                <h2 class="text-secondary"><?= $statistics['completed'] ?></h2>
                <p class="text-muted mb-0">Completed</p>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Monthly Application Trends (Last 6 Months)</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Month</th>
                        <th>Total Applications</th>
                        <th>Pending</th>
                        <th>Approved</th>
                        <th>Rejected</th>
                        <th>Approval Rate</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($monthlyData)): ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">No data available</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($monthlyData as $data): ?>
                            <?php
                            $approvalRate = $data['total'] > 0 
                                ? round(($data['approved'] / $data['total']) * 100, 1) 
                                : 0;
                            ?>
                            <tr>
                                <td><strong><?= date('F Y', strtotime($data['month'] . '-01')) ?></strong></td>
                                <td><?= $data['total'] ?></td>
                                <td><span class="badge bg-warning"><?= $data['pending'] ?></span></td>
                                <td><span class="badge bg-success"><?= $data['approved'] ?></span></td>
                                <td><span class="badge bg-danger"><?= $data['rejected'] ?></span></td>
                                <td>
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar bg-success" style="width: <?= $approvalRate ?>%">
                                            <?= $approvalRate ?>%
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
