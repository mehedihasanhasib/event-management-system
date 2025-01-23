<?php ob_start() ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-dark text-white text-center">
                    <h4>Register</h4>
                </div>
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <label for="fullName" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="fullName" placeholder="Enter your full name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" placeholder="Enter your email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" placeholder="Create a password" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">Register</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <small>Already have an account? <a href="<?php route('login') ?>">Login here</a>.</small>
                </div>
            </div>
        </div>
    </div>
</div>


<?php
$title = "Register";
$content = ob_get_clean();
layout('guest', compact('content', 'title'));
?>