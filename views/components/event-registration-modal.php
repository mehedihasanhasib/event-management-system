<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#eventRegistrationModal">
    Launch demo modal
</button> -->

<!-- Modal -->
<div class="modal fade" id="eventRegistrationModal" tabindex="-1" aria-labelledby="eventRegistrationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="eventRegistrationModalLabel">Register for <?= htmlspecialchars($event['title']) ?></h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-body p-4">
                    <div class="alert alert-warning d-flex align-items-center mb-4" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <div>
                            Only 3 seats remaining! Complete your registration soon.
                        </div>
                    </div>

                    <form id="eventRegistrationForm" method="POST" action="<?= route('attendee.store') ?>">
                        <input type="hidden" name="event_id" value="<?= $event['id'] ?>">
                        <div class="mb-4">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control form-control-lg" placeholder="John">
                                    <?php component('input-error', ['className' => ['nameError']]) ?>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email Address</label>
                                    <input type="email" name="email" class="form-control form-control-lg" placeholder="john@example.com">
                                    <?php component('input-error', ['className' => ['emailError']]) ?>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Location</label>
                                    <select name="location" class="form-select form-select-lg">
                                        <option value="">Select Location</option>
                                        <?php foreach ($locations as $location): ?>
                                            <option value="<?= $location['id'] ?>"><?= $location['name'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php component('input-error', ['className' => ['locationError']]) ?>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Phone Number</label>
                                    <input type="tel" name="phone_number" class="form-control form-control-lg" placeholder="01900000000">
                                    <?php component('input-error', ['className' => ['phone_numberError']]) ?>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" id="submitButton" class="btn btn-primary">Register</button>
            </div>
        </div>
    </div>
</div>