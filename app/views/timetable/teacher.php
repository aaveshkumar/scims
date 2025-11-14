<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">My Teaching Schedule</h1>
        <p class="text-muted mb-0">Academic Year: <?= $academicYear ?></p>
    </div>
    <a href="/timetable" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Time</th>
                        <th>Monday</th>
                        <th>Tuesday</th>
                        <th>Wednesday</th>
                        <th>Thursday</th>
                        <th>Friday</th>
                        <th>Saturday</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $timeSlots = [];
                    foreach ($schedule as $day => $periods) {
                        foreach ($periods as $period) {
                            $time = date('h:i A', strtotime($period['start_time'])) . ' - ' . date('h:i A', strtotime($period['end_time']));
                            if (!in_array($time, $timeSlots)) {
                                $timeSlots[] = $time;
                            }
                        }
                    }
                    sort($timeSlots);
                    
                    foreach ($timeSlots as $timeSlot): 
                    ?>
                        <tr>
                            <td class="fw-bold"><?= $timeSlot ?></td>
                            <?php foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'] as $day): ?>
                                <td>
                                    <?php
                                    $found = false;
                                    if (isset($schedule[$day])) {
                                        foreach ($schedule[$day] as $period) {
                                            $periodTime = date('h:i A', strtotime($period['start_time'])) . ' - ' . date('h:i A', strtotime($period['end_time']));
                                            if ($periodTime === $timeSlot) {
                                                $found = true;
                                                ?>
                                                <div class="p-2 bg-success bg-opacity-10 rounded">
                                                    <strong><?= htmlspecialchars($period['subject_name']) ?></strong><br>
                                                    <small class="text-muted">
                                                        <?= htmlspecialchars($period['class_name']) ?><br>
                                                        <?= htmlspecialchars($period['room_number'] ?? 'No room assigned') ?>
                                                    </small>
                                                </div>
                                                <?php
                                                break;
                                            }
                                        }
                                    }
                                    if (!$found) {
                                        echo '<span class="text-muted">Free</span>';
                                    }
                                    ?>
                                </td>
                            <?php endforeach; ?>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($timeSlots)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">
                                No classes scheduled yet
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
