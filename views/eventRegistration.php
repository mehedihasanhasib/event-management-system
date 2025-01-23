<?php ob_start(); ?>

<div class="container my-5">
    <h1 class="text-center mb-4">Event Registration</h1>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-body">
                    <form action="process_registration.php" method="POST">
                        <!-- Event Name -->
                        <div class="mb-3">
                            <label for="eventName" class="form-label">Event Name</label>
                            <select class="form-select" id="eventName" name="event_name" required>
                                <option value="" disabled selected>Select an event</option>
                                <option value="Tech Conference 2025">Tech Conference 2025</option>
                                <option value="Art & Culture Fest">Art & Culture Fest</option>
                                <option value="Startup Pitch Night">Startup Pitch Night</option>
                            </select>
                        </div>

                        <!-- Attendee Name -->
                        <div class="mb-3">
                            <label for="attendeeName" class="form-label">Your Name</label>
                            <input type="text" class="form-control" id="attendeeName" name="attendee_name" placeholder="Enter your full name" required>
                        </div>

                        <!-- Attendee Email -->
                        <div class="mb-3">
                            <label for="attendeeEmail" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="attendeeEmail" name="attendee_email" placeholder="Enter your email address" required>
                        </div>

                        <!-- Phone Number -->
                        <div class="mb-3">
                            <label for="phoneNumber" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="phoneNumber" name="phone_number" placeholder="Enter your phone number" required>
                        </div>

                        <!-- Additional Notes -->
                        <div class="mb-3">
                            <label for="additionalNotes" class="form-label">Additional Notes (Optional)</label>
                            <textarea class="form-control" id="additionalNotes" name="additional_notes" rows="3" placeholder="Any additional information"></textarea>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">Register</button>
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