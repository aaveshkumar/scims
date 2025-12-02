<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="mb-4">
    <h2><i class="bi bi-calendar3 me-2"></i>My Timetable</h2>
</div>

<?php if (empty($timetable)): ?>
    <div class="alert alert-info">No timetable available</div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>Day</th>
                    <th>Subject</th>
                    <th>Teacher</th>
                    <th>Time</th>
                    <th>Room</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($timetable as $slot): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($slot['day']) ?></strong></td>
                        <td><?= htmlspecialchars($slot['subject_name']) ?></td>
                        <td><?= htmlspecialchars($slot['teacher_name'] ?? 'TBD') ?></td>
                        <td><?= date('h:i A', strtotime($slot['start_time'])) ?> - <?= date('h:i A', strtotime($slot['end_time'])) ?></td>
                        <td><?= htmlspecialchars($slot['room_number'] ?? 'N/A') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php include __DIR__ . '/../layouts/footer.php'; ?>
