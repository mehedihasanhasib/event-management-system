<?php ob_start() ?>

<div class="container my-5">
    <h1 class="text-center mb-4">Create a New Event</h1>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-body">
                    <form action="process_event_create.php" method="POST">
                        <!-- Event Name -->
                        <div class="mb-3">
                            <label for="eventName" class="form-label">Event Name</label>
                            <input type="text" class="form-control" id="eventName" name="event_name" placeholder="Enter the event name" required>
                        </div>

                        <!-- Event Description -->
                        <div class="mb-3">
                            <label for="eventDescription" class="form-label">Event Description</label>
                            <textarea class="form-control" id="eventDescription" name="event_description" rows="4" placeholder="Provide a brief description of the event" required></textarea>
                        </div>

                        <!-- Event Date -->
                        <div class="mb-3">
                            <label for="eventDate" class="form-label">Event Date</label>
                            <input type="date" class="form-control" id="eventDate" name="event_date" required>
                        </div>

                        <!-- Event Time -->
                        <div class="mb-3">
                            <label for="eventTime" class="form-label">Event Time</label>
                            <input type="time" class="form-control" id="eventTime" name="event_time" required>
                        </div>

                        <!-- Event Location -->
                        <div class="mb-3">
                            <label for="eventLocation" class="form-label">Event Location</label>
                            <input type="text" class="form-control" id="eventLocation" name="event_location" placeholder="Enter the event location" required>
                        </div>

                        <!-- Maximum Capacity -->
                        <div class="mb-3">
                            <label for="maxCapacity" class="form-label">Maximum Capacity</label>
                            <input type="number" class="form-control" id="maxCapacity" name="max_capacity" placeholder="Enter the maximum number of attendees" required>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">Create Event</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
layout('master', compact('content'));
?>