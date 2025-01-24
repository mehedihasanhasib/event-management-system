<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="<?= route('home') ?>">Event Management</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <?php if (auth()): ?>
                    <li class="nav-item"><a class="nav-link" href="<?= "" ?>">My Events</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= "" ?>">My Bookings</a></li>
                    <li class="nav-item">
                        <form action="<?= route('logout') ?>" method="POST">
                            <button class="nav-link" href="<?= "" ?>">Log out</button>
                        </form>
                    </li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="<?= route('login') ?>">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= route('register') ?>">Register</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>