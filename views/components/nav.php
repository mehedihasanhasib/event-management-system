<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="<?php route('home') ?>">Event Management</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <?php if (auth()): ?>
                <div class="dropdown ms-auto">
                    <!-- <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"> -->
                    <img src="<?= \Core\Auth::user()['image'] ?? asset('images/user-avatar/default-avatar.png') ?>" alt="User Avatar rounded-full" width="40" height="40" class="rounded-circle me-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <?php echo \Core\Auth::user()['name'] ?>
                    <!-- </button> -->
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </div>
            <?php else: ?>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="<?= route('login') ?>">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= route('register') ?>">Register</a></li>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</nav>