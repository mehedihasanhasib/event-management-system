<?php ob_start() ?>

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Attendee List</h1>
        <a href="<?= $_SERVER['PATH_INFO'] . "?" . http_build_query(array_merge($_GET, ['export' => true])) ?>" class="btn btn-success">
            <i class="bi bi-file-earmark-excel me-2"></i>Export to CSV
        </a>
    </div>

    <!-- Event Details -->
    <div class="mb-4">
        <h3>Event: <?= htmlspecialchars($event['title']) ?></h3>
        <p class="m-0"><strong>Date:</strong> <?= htmlspecialchars(date("F j, Y", strtotime($event['date']))) ?></p>
        <p><strong>Location:</strong> <?= htmlspecialchars($event['event_location']) ?></p>
    </div>

    <!-- Filter Section -->
    <div class="py-4">
        <form id="filterForm" method="GET" action="<?= route('attendee.index', ['id' => $event['id']]) ?>" class="row g-3">
            <?php
            $name = $_GET['name'] ?? '';
            $location_id = $_GET['location'] ?? 0;
            $phone = $_GET['phone'] ?? '';
            $email = $_GET['email'] ?? '';
            ?>
            <div class="col-md-3">
                <input type="text" class="form-control" value="<?= htmlspecialchars($name) ?>" placeholder="Search by name..." name="name">
            </div>
            <div class="col-md-3">
                <input type="email" class="form-control" value="<?= htmlspecialchars($email) ?>" placeholder="Search by email..." name="email">
            </div>
            <div class="col-md-2">
                <select class="form-select" name="location">
                    <option value="">Select Location</option>
                    <?php foreach ($locations as $location) : ?>
                        <option <?= $location['id'] == $location_id ? 'selected' : '' ?> value="<?= $location['id'] ?>"><?= $location['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <input type="text" class="form-control" value="<?= htmlspecialchars($phone) ?>" placeholder="Search by phone..." name="phone">
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary w-100">Search</button>
            </div>
            <div class="col-md-1">
                <a href="<?= route('attendee.index', ['id' => $event['id']]) ?>" class="btn btn-secondary w-100">Reset</a>
            </div>
        </form>
    </div>

    <!-- Attendee Table -->
    <div class="table-responsive">
        <table id="attendee-table" class="table table-bordered table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Attendee Location</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($attendees as $index => $attendee): ?>
                    <tr>
                        <td><?= $index + 1; ?></td>
                        <td><?= htmlspecialchars($attendee['name']); ?></td>
                        <td><?= htmlspecialchars($attendee['email']); ?></td>
                        <td><?= htmlspecialchars($attendee['phone_number']); ?></td>
                        <td><?= htmlspecialchars($attendee['location_name']); ?></td>
                    </tr>
                    <!-- <tr>
                    <td colspan="6" class="text-center">No attendees found</td>
                </tr> -->
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>
</div>

<?php ob_start() ?>
<script>
    $(document).ready(function() {

        $("#filterForm").on("submit", function(event) {
            event.preventDefault();

            let formData = $(this).serializeArray();

            formData = formData.filter(function(field) {
                return field.value.trim() !== "";
            });

            const filteredFormData = new URLSearchParams();
            formData.forEach(function(field) {
                filteredFormData.append(field.name, field.value);
            });

            const actionUrl = $(this).attr("action");

            window.location.href = `${actionUrl}?${filteredFormData.toString()}`;
        });

    })
</script>

<?php $script = ob_get_clean(); ?>

<?php
$content = ob_get_clean();
layout('master', compact('content', 'script'));
