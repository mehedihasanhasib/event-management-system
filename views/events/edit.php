<?php ob_start() ?>
<div class="container my-5">
    <h1 class="text-center mb-4">Create a New Event</h1>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-body">
                    <form id="event-update-form" action="<?= route('event.update') ?>" method="POST">
                        <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                        <input type="hidden" name="_method" value="PUT">
                        <input type="hidden" name="id" value="<?= $event['id'] ?? '' ?>">
                        <!-- Event Name -->
                        <div class="mb-3">
                            <label for="eventTitle" class="form-label">Event Title</label><span class="text-danger">*</span>
                            <input type="text" class="form-control" id="eventTitle" name="event_title" value="<?= $event['title'] ?? '' ?>" placeholder="Enter the event title">
                            <?php component('input-error', ['className' => ['event_titleError']]) ?>
                        </div>

                        <!-- Event Slug -->
                        <div class="mb-3">
                            <label for="eventName" class="form-label">Event Slug</label><span class="text-danger">*</span>
                            <input type="text" class="form-control" id="eventSlug" name="event_slug" value="<?= $event['slug'] ?? '' ?>" placeholder="Enter slug" required>
                            <?php component('input-error', ['className' => ['event_slugError']]) ?>
                        </div>

                        <!-- Event Description -->
                        <div class="mb-3">
                            <label for="eventDescription" class="form-label">Event Description</label><span class="text-danger">*</span>
                            <textarea class="form-control" id="eventDescription" name="event_description" rows="7" placeholder="Provide a brief description of the event" required><?= $event['description'] ?? '' ?></textarea>
                            <?php component('input-error', ['className' => ['event_descriptionError']]) ?>
                        </div>

                        <!-- Event Date -->
                        <div class="mb-3">
                            <label for="eventDate" class="form-label">Event Date</label><span class="text-danger">*</span>
                            <input type="date" class="form-control" id="eventDate" name="event_date" value="<?= $event['date'] ?? '' ?>" required>
                            <?php component('input-error', ['className' => ['event_dateError']]) ?>
                        </div>

                        <!-- Event Time -->
                        <div class="mb-3">
                            <label for="eventTime" class="form-label">Event Time</label><span class="text-danger">*</span>
                            <input type="time" class="form-control" id="eventTime" name="event_time" value="<?= $event['time'] ?? '' ?>" required>
                            <?php component('input-error', ['className' => ['event_timeError']]) ?>
                        </div>

                        <!-- Event Location -->
                        <div class="mb-3">
                            <label class="form-label">Event Location</label><span class="text-danger">*</span>
                            <select class="form-select" name="location" required>
                                <option value="">Select Location</option>
                                <?php foreach ($locations as $location) : ?>
                                    <option <?= $location['id'] == $event['location_id'] ? 'selected' : '' ?> value="<?= $location['id'] ?>"><?= $location['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php component('input-error', ['className' => ['locationError']]) ?>
                        </div>

                        <!-- Maximum Capacity -->
                        <div class="mb-3">
                            <label for="maxCapacity" class="form-label">Maximum Capacity</label><span class="text-danger">*</span>
                            <input type="number" class="form-control" id="maxCapacity" name="max_capacity" value="<?= $event['capacity'] ?? '' ?>" placeholder="Enter the maximum number of attendees" required>
                            <?php component('input-error', ['className' => ['max_capacityError']]) ?>
                        </div>

                        <!-- Banner -->
                        <div class="mb-3">
                            <label for="banner" class="form-label">Banner</label><span class="text-danger">*</span>
                            <input type="file" class="form-control" id="banner" name="banner">
                            <?php component('input-error', ['className' => ['bannerError']]) ?>
                            <div class="mt-3 d-flex justify-content-center">
                                <img id="banner-preview" src="<?= asset($event['banner'] ?? DEFAULT_EVENT_BANNER) ?>" alt="Profile Picture Preview" style="max-width: 100%;max-height: 50vh;object-fit:cover;" />
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary btn-lg">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ?>


<?php ob_start() ?>
<script src="<?= asset('/js/slug-generate.js') ?>"></script>
<script>
    $(document).ready(function() {
        const eventCreateForm = $("#event-update-form")
        const bannerInput = $("#banner")
        const eventTitle = $("#eventTitle")
        const eventSlug = $("#eventSlug")

        bannerInput.on("change", function(event) {
            preview(event, "banner-preview")
        })

        eventTitle.on("change keypress", function(event) {
            slug(event, eventSlug)
        })

        eventCreateForm.on("submit", function(event) {
            event.preventDefault()
            const url = $(this).attr("action")
            const formData = new FormData(this);
            submit(url, formData, function() {
                window.location.href = "<?= route('creator.events') ?>"
            });
        })
    })
</script>
<?php $script = ob_get_clean() ?>


<?php
layout('master', compact('content', 'script'));
?>