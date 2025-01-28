<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <div class="collapse navbar-collapse d-flex justify-content-between">
            <div class="d-flex align-items-center gap-4">
                <div>
                    <a class="navbar-brand" href="<?= route('home') ?>">Event Management</a>

                </div>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link <?= isActiveRoute(route('home')) ?>" href="<?= route('home') ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= isActiveRoute(route('events')) ?>" href="<?= route('events') ?>">Events</a>
                    </li>
                </ul>
            </div>
            <ul class="navbar-nav">
                <?php if (auth()): ?>
                    <div class="dropdown">
                        <a
                            href="#"
                            class="d-flex align-items-center text-decoration-none dropdown-toggle"
                            id="userDropdown"
                            data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <div class="icon-circle">
                                <img
                                    src="<?= auth()['profile_picture'] ? asset(auth()['profile_picture']) : asset(DEFAULT_USER_AVATAR) ?>"
                                    class="rounded-circle me-2"
                                    alt="User Avatar"
                                    style="width: 40px; height: 40px; object-fit: cover;">
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item" href="<?= route('myevents') ?>">My Events</a>
                            </li>
                            <li>
                                <form action="<?= route('logout') ?>" method="POST" class="d-inline">
                                    <button type="submit" class="dropdown-item">Log out</button>
                                </form>
                            </li>
                        </ul>
                    </div>
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