<?php ob_start() ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-dark text-white text-center">
                    <h4>Login</h4>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <?= component('input-error') ?>
                    </div>
                    <form id="login-from" action="<?= route('login.store') ?>" method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="password" placeholder="Enter your password" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>
                </div>
                <div class="text-center mb-3">
                    <small class="text-muted">Demo Account: <br> Email: demo@example.com <br> Password: 12345678</small>
                </div>
                <div class="card-footer text-center">
                    <small>Don't have an account? <a href="<?= route('register') ?>">Register here</a>.</small>
                </div>
            </div>
        </div>
    </div>
</div>

<?php ob_start() ?>
<script>
    $(document).ready(function() {
        const registrationForm = $("#login-from")
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
$content = ob_get_clean();
$title = "Login";
layout('guest', compact('content', 'title', 'script'));
?>