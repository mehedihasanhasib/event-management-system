<?php ob_start() ?>
<div class="container my-5">
    <!-- Event Title and Hero Section -->
    <div class="card shadow-lg border-0 mb-4 overflow-hidden">
        <div class="row g-0">
            <div class="col-md-6 position-relative">
                <img src="<?= htmlspecialchars($event['banner']) ?? DEFAULT_EVENT_BANNER ?>"
                    class="img-fluid" alt="Event Image"
                    style="object-fit: cover; height: 100%; min-height: 400px; width: 100%;">
                <div class="position-absolute bottom-0 start-0 w-100 bg-gradient-dark p-3 text-white"
                    style="background: linear-gradient(to top, rgba(0,0,0,0.8), rgba(0,0,0,0));">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-calendar-event"></i>
                        <span class="fw-semibold"><?= htmlspecialchars(date("F j, Y", strtotime($event['date']))) ?></span>
                        <span class="mx-2">•</span>
                        <i class="bi bi-clock"></i>
                        <span class="fw-semibold"><?= htmlspecialchars(date("g:i A", strtotime($event['time']))) ?></span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card-body p-4">
                    <h1 class="card-title display-5 fw-bold mb-4"><?= htmlspecialchars($event['title']) ?></h1>

                    <!-- Organizer Info -->
                    <div class="d-flex align-items-center mb-4">
                        <div class="position-relative me-3">
                            <img src="<?= htmlspecialchars($event['organizer_profile_picture'] ?? DEFAULT_USER_AVATAR) ?>"
                                class="rounded-circle"
                                alt="Organizer"
                                style="width: 60px; height: 60px; object-fit: cover;">
                            <span class="position-absolute bottom-0 end-0 bg-success rounded-circle p-1"
                                style="width: 12px; height: 12px;"
                                title="Verified Organizer"></span>
                        </div>
                        <div>
                            <h6 class="mb-1">Organized by</h6>
                            <p class="fw-bold mb-0"><?= htmlspecialchars($event['organizer_name']) ?></p>
                        </div>
                    </div>

                    <!-- Location -->
                    <div class="mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-geo-alt-fill text-primary me-2"></i>
                            <h6 class="fw-bold mb-0"><?= htmlspecialchars($event['location_name']) ?></h6>
                        </div>
                        <p class="text-muted small mb-0"><?= htmlspecialchars($event['location_address'] ?? '') ?></p>
                    </div>

                    <!-- Available Seats -->
                    <div class="mb-4">
                        <div class="card bg-light border-0">
                            <div class="card-body">
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <h6 class="fw-bold mb-1">Available Seats</h6>
                                        <p class="mb-0 text-primary fw-bold">
                                            <?= htmlspecialchars($event['capacity']) ?> / <?= htmlspecialchars($event['capacity']) ?>
                                        </p>
                                    </div>
                                    <i class="bi bi-people-fill fs-3 text-primary"></i>
                                </div>
                                <?php /*if ($event['available_seats'] <= 3): ?>
                                <div class="mt-2">
                                    <small class="text-danger">
                                        <i class="bi bi-exclamation-circle-fill"></i>
                                        Only <?= htmlspecialchars(0) ?> seats left!
                                    </small>
                                </div>
                                <?php endif;*/ ?>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                        <button class="btn btn-primary btn-lg px-4 me-md-2">
                            <i class="bi bi-ticket-perforated me-2"></i>Register Now
                        </button>
                        <button class="btn btn-outline-secondary btn-lg px-4">
                            <i class="bi bi-share me-2"></i>Share
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Event Details -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4">
                    <h2 class="fw-bold mb-4">About This Event</h2>
                    <div class="event-description">
                        <?= nl2br(htmlspecialchars($event['description'])) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $content = ob_get_clean() ?>

<?php layout('master', compact('content')); ?>