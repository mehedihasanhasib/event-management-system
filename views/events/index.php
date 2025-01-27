<?php ob_start(); ?>

<div class="container my-5">
    <h1 class="text-center mb-4">Manage Events</h1>

    <!-- Add New Event Button -->
    <div class="mb-3 text-end">
        <a href="<?= route('event.create') ?>" class="btn btn-success">Create New Event</a>
    </div>

    <!-- Events Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Event Name</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Location</th>
                    <th>Max Capacity</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($events)): ?>
                    <?php foreach ($events as $index => $event): ?>
                        <tr>
                            <td><?= $index + 1; ?></td>
                            <td><?= htmlspecialchars($event['title']); ?></td>
                            <td><?= htmlspecialchars(substr($event['description'], 0, 70) . " ..."); ?></td>
                            <td><?= htmlspecialchars($event['date']); ?></td>
                            <td><?= htmlspecialchars($event['location_name']); ?></td>
                            <td><?= htmlspecialchars($event['capacity']); ?></td>
                            <td>
                                <a href="<?= route('event.edit') . "?id={$event['id']}" ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="event_delete.php?id=<?= $event['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this event?');">Delete</a>
                                <a href="<?= route('attendee.index') ?>" class="btn btn-sm btn-primary">Attendees</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">No events found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
$content = ob_get_clean();
layout('master', compact('content'));
?>