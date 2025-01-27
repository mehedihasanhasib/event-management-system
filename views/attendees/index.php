<?php ob_start() ?>

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Attendee List</h1>
        <a href="export_csv.php" class="btn btn-success">
            <i class="bi bi-file-earmark-excel me-2"></i>Export to CSV
        </a>
    </div>

    <!-- Event Details -->
    <div class="mb-4">
        <h3>Event: Tech Conference 2025</h3>
        <p class="m-0"><strong>Date:</strong> February 25, 2025</p>
        <p><strong>Location:</strong> New York City, NY</p>
    </div>

    <!-- Filter Section -->
    <div class="py-4">
        <form class="row g-3">
            <div class="col-md-4">
                <input type="text" class="form-control" placeholder="Search by name..." name="name">
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" placeholder="Filter by location..." name="location">
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" placeholder="Search by phone..." name="phone">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Search</button>
            </div>
        </form>
    </div>

    <!-- Attendee Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Registration Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Example attendee data (Replace this with database query results)
                $attendees = [
                    [
                        "id" => 1,
                        "name" => "John Doe",
                        "email" => "john.doe@example.com",
                        "phone" => "123-456-7890",
                        "registration_date" => "2025-01-15",
                    ],
                    [
                        "id" => 2,
                        "name" => "Jane Smith",
                        "email" => "jane.smith@example.com",
                        "phone" => "987-654-3210",
                        "registration_date" => "2025-01-16",
                    ],
                    [
                        "id" => 3,
                        "name" => "Mark Taylor",
                        "email" => "mark.taylor@example.com",
                        "phone" => "555-678-1234",
                        "registration_date" => "2025-01-17",
                    ],
                ];

                if (!empty($attendees)) {
                    foreach ($attendees as $index => $attendee) {
                ?>
                        <tr>
                            <td><?= $index + 1; ?></td>
                            <td><?= htmlspecialchars($attendee['name']); ?></td>
                            <td><?= htmlspecialchars($attendee['email']); ?></td>
                            <td><?= htmlspecialchars($attendee['phone']); ?></td>
                            <td><?= htmlspecialchars($attendee['registration_date']); ?></td>
                            <td>
                                <a href="attendee_edit.php?id=<?= $attendee['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                <a href="attendee_delete.php?id=<?= $attendee['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to remove this attendee?');">Remove</a>
                            </td>
                        </tr>
                    <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="6" class="text-center">No attendees found</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php
$content = ob_get_clean();
layout('master', compact('content'));
