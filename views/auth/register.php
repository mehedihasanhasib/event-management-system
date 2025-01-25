<?php
ob_start()
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-dark text-white text-center">
                    <h4>Register</h4>
                </div>
                <div class="card-body">
                    <form id="registration-from" action="<?= route('register.store') ?>" method="POST">
                        <div class="mb-3">
                            <label for="fullName" class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" id="fullName" placeholder="Enter your full name" required />
                            <!-- <span class="text-danger nameError validationError"></span> -->
                            <?php component('input-error', ['className' => ["nameError"]]) ?>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email" required />
                            <?php component('input-error', ['className' => ["emailError"]]) ?>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="password" placeholder="Create a password" required />
                            <?php component('input-error', ['className' => ["passwordError"]]) ?>
                        </div>

                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password</label>
                            <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="Confirm password" required />
                            <?php component('input-error', ['className' => ["confirm_passwordError"]]) ?>
                        </div>

                        <div class="mb-3">
                            <label for="profile_picture" class="form-label">Choose Profile Picture</label>
                            <input type="file" , name="profile_picture" class="form-control" id="profile_picture" />
                            <?php component('input-error', ['className' => ["profile_pictureError"]]) ?>
                            <div class="mt-3">
                                <img id="profile-picture-preview" src="<?= asset('/images/user-avatar/default-avatar.png') ?>" alt="Profile Picture Preview" style="width: 100px; height: 100px; border-radius: 50%; object-fit:cover;" />
                            </div>
                        </div>

                        <div class=" d-grid">
                            <button type="submit" class="btn btn-success">Register</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <small>Already have an account? <a href="<?= route('login') ?>">Login here</a>.</small>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $content = ob_get_clean(); ?>

<?php ob_start() ?>
<script>
    $(document).ready(function() {
        const registrationForm = $("#registration-from")
        registrationForm.on("submit", function(event) {
            event.preventDefault()
            const url = $(this).attr("action")
            const formData = new FormData(this);
            submit(url, formData, function() {
                window.location.href = "<?= route('home') ?>"
            });
        })
    })
</script>
<?php $script = ob_get_clean() ?>

<?php
$title = "Register";
layout('guest', compact('content', 'title', 'script'));
?>