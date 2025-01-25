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
                <?php
                $events = [
                    [
                        "id" => 1,
                        "name" => "Tech Conference 2025",
                        "description" => "Join industry leaders to discuss the future of technology.",
                        "date" => "2025-02-25",
                        "location" => "New York City, NY",
                        "max_capacity" => 500,
                    ],
                    [
                        "id" => 2,
                        "name" => "Art & Culture Fest",
                        "description" => "Experience the best of art, music, and culture.",
                        "date" => "2025-03-10",
                        "location" => "Los Angeles, CA",
                        "max_capacity" => 300,
                    ],
                    [
                        "id" => 3,
                        "name" => "Startup Pitch Night",
                        "description" => "Watch entrepreneurs pitch their ideas to investors.",
                        "date" => "2025-04-05",
                        "location" => "San Francisco, CA",
                        "max_capacity" => 200,
                    ],
                ];

                if (!empty($events)) {
                    foreach ($events as $index => $event) {
                ?>
                        <tr>
                            <td><?= $index + 1; ?></td>
                            <td><?= htmlspecialchars($event['name']); ?></td>
                            <td><?= htmlspecialchars($event['description']); ?></td>
                            <td><?= htmlspecialchars($event['date']); ?></td>
                            <td><?= htmlspecialchars($event['location']); ?></td>
                            <td><?= htmlspecialchars($event['max_capacity']); ?></td>
                            <td>
                                <a href="event_edit.php?id=<?= $event['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="event_delete.php?id=<?= $event['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this event?');">Delete</a>
                            </td>
                        </tr>
                    <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="7" class="text-center">No events found</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php
$content = ob_get_clean();
layout('master', compact('content'));
?>