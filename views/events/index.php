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
                    <th>Total Attendees</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($events)): ?>
                    <?php foreach ($events as $index => $event): ?>
                        <tr>
                            <td><?= $index + 1; ?></td>
                            <td><?= htmlspecialchars($event['title']); ?></td>
                            <td><?= htmlspecialchars(substr($event['description'], 0, 50) . " ..."); ?></td>
                            <td><?= htmlspecialchars($event['date']); ?></td>
                            <td><?= htmlspecialchars($event['location_name']); ?></td>
                            <td class="text-center"><?= htmlspecialchars($event['capacity']); ?></td>
                            <td class="text-center"><?= htmlspecialchars($event['total_attendees']); ?></td>
                            <td class="d-flex gap-1">
                                <a href="<?= route('attendee.index', ['id' => $event['id']]) ?>" class="btn btn-sm btn-primary">Attendees</a>
                                <a href="<?= route('event.edit', ['id' => $event['id']]) ?>" class="btn btn-sm btn-warning">Edit</a>
                                <form id="event-delete-form" action="<?= route('event.delete', ['id' => $event['id']]) ?>" method="POST">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
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

<?php ob_start() ?>
<script>
    $(document).ready(function(event) {
        // Delete event
        $('#event-delete-form').on('submit', function(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: 'You will not be able to recover this event.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            })
        })
    })
</script>

<?php if (\App\Core\Session::has('message')): ?>
    <script>
        const status = "<?= \App\Core\Session::get('status') ?>";
        const message = "<?= \App\Core\Session::get('message') ?>";

        if (status) {
            Swal.fire({
                title: 'Success',
                text: message,
                icon: 'success',
            })
        } else {
            Swal.fire({
                title: 'Error',
                text: message,
                icon: 'error',
            })
        }
    </script>
<?php endif; ?>

<?php $script = ob_get_clean() ?>

<?php
$content = ob_get_clean();
layout('master', compact('content', 'script'));
?>