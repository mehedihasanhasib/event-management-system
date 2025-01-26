<?php ob_start() ?>

<div class="container my-5">
    <h1 class="text-center mb-4">Create a New Event</h1>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-body">
                    <form id="event-create-form" action="<?= route('event.store') ?>" method="POST">
                        <!-- Event Name -->
                        <div class="mb-3">
                            <label for="eventTitle" class="form-label">Event Title</label>
                            <input type="text" class="form-control" id="eventTitle" name="event_title" placeholder="Enter the event title" required>
                            <?php component('input-error', ['className' => ['event_titleError']]) ?>
                        </div>

                        <!-- Event Slug -->
                        <div class="mb-3">
                            <label for="eventName" class="form-label">Event Slug</label>
                            <input type="text" class="form-control" id="eventSlug" name="event_slug" placeholder="Enter slug" required>
                            <?php component('input-error', ['className' => ['event_slugError']]) ?>
                        </div>

                        <!-- Event Description -->
                        <div class="mb-3">
                            <label for="eventDescription" class="form-label">Event Description</label>
                            <textarea class="form-control" id="eventDescription" name="event_description" rows="4" placeholder="Provide a brief description of the event" required></textarea>
                            <?php component('input-error', ['className' => ['event_descriptionError']]) ?>
                        </div>

                        <!-- Event Date -->
                        <div class="mb-3">
                            <label for="eventDate" class="form-label">Event Date</label>
                            <input type="date" class="form-control" id="eventDate" name="event_date" required>
                            <?php component('input-error', ['className' => ['event_dateError']]) ?>
                        </div>

                        <!-- Event Time -->
                        <div class="mb-3">
                            <label for="eventTime" class="form-label">Event Time</label>
                            <input type="time" class="form-control" id="eventTime" name="event_time" required>
                            <?php component('input-error', ['className' => ['event_timeError']]) ?>
                        </div>

                        <!-- Event Location -->
                        <div class="mb-3">
                            <label class="form-label">Event Location</label>
                            <select class="form-select" name="location" required>
                                <option value="">Select Location</option>
                                <?php foreach ($locations as $location) : ?>
                                    <option value="<?= $location['id'] ?>"><?= $location['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php component('input-error', ['className' => ['locationError']]) ?>
                        </div>

                        <!-- Maximum Capacity -->
                        <div class="mb-3">
                            <label for="maxCapacity" class="form-label">Maximum Capacity</label>
                            <input type="number" class="form-control" id="maxCapacity" name="max_capacity" placeholder="Enter the maximum number of attendees" required>
                            <?php component('input-error', ['className' => ['max_capacityError']]) ?>
                        </div>

                        <!-- Banner -->
                        <div class="mb-3">
                            <label for="banner" class="form-label">Banner</label>
                            <input type="file" class="form-control" id="banner" name="banner" required>
                            <?php component('input-error', ['className' => ['bannerError']]) ?>
                            <div class="mt-3 d-flex justify-content-center">
                                <img id="banner-preview" src="" alt="Profile Picture Preview" style="max-width: 100%;max-height: 50vh;object-fit:cover;display: none;" />
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ?>


<?php ob_start() ?>
<script>
    $(document).ready(function() {
        const eventCreateForm = $("#event-create-form")
        const bannerInput = $("#banner")

        bannerInput.on("change", function(event) {
            preview(event, "banner-preview")
        })

        eventCreateForm.on("submit", function(event) {
            event.preventDefault()
            const url = $(this).attr("action")
            const formData = new FormData(this);
            submit(url, formData, function() {
                window.location.href = "<?= route('myevents') ?>"
            });
        })
    })
</script>
<?php $script = ob_get_clean() ?>


<?php
layout('master', compact('content', 'script'));
?>