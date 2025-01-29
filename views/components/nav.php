<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <!-- Brand -->
        <a class="navbar-brand fw-bold" href="<?= route('home') ?>">Event Management</a>

        <!-- Toggler for mobile menu -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
            <!-- Left Side: Navigation Links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link <?= isActiveRoute(route('home')) ?>" href="<?= route('home') ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= isActiveRoute(route('events')) ?>" href="<?= route('events') ?>">Events</a>
                </li>
            </ul>

            <!-- Right Side: Authentication Links / User Dropdown -->
            <ul class="navbar-nav">
                <?php if (auth()): ?>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" id="userDropdown"
                            role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="<?= auth()['profile_picture'] ? asset(auth()['profile_picture']) : asset(DEFAULT_USER_AVATAR) ?>"
                                class="rounded-circle me-2" alt="User Avatar" width="40" height="40" style="object-fit: cover;">
                            <span class="d-none d-lg-inline"><?= auth()['name'] ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="<?= route('creator.events') ?>">My Events</a></li>
                            <li>
                                <form action="<?= route('logout') ?>" method="POST" class="d-inline">
                                    <button type="submit" class="dropdown-item">Log out</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link <?= isActiveRoute(route('login')) ?>" href="<?= route('login') ?>">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= isActiveRoute(route('register')) ?>" href="<?= route('register') ?>">Register</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>
