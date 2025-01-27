<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="<?= route('home') ?>">Event Management</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
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
                                    src=" <?= auth()['profile_picture'] ? asset(auth()['profile_picture']) : asset('images/user-avatar/default-avatar.png') ?>"
                                    class="rounded-circle me-2"
                                    alt="User Avatar"
                                    style="width: 40px; height: 40px;object-fit: cover;">
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
                    <li class="nav-item"><a class="nav-link" href="<?= route('login') ?>">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= route('register') ?>">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>