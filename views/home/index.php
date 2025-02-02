<?php ob_start() ?>
<style>
    .hero {
        background: linear-gradient(to right, #6a11cb, #2575fc);
        color: white;
        padding: 60px 20px;
        text-align: center;
    }

    .hero h1 {
        font-size: clamp(2rem, 2.5vw, 3rem) !important;
        font-weight: bold;
    }

    .hero p {
        font-size: 1.2rem;
        margin-top: 15px;
    }

    .event-card img {
        height: 25vh;
        object-fit: cover;
    }
</style>
<?php $style = ob_get_clean(); ?>

<?php ob_start(); ?>
<div class="hero">
    <h1>Welcome to the Event Management System</h1>
    <?php if (auth()): ?>
        <p>Discover, create, and join amazing events happening around you.</p>
    <?php else: ?>
        <a href="<?= route('login') ?>" class="btn btn-primary btn-lg mt-3 me-2">Login</a>
        <a href="<?= route('register') ?>" class="btn btn-secondary btn-lg mt-3">Register</a>
    <?php endif; ?>
</div>


<div class="container my-5">
    <h2 class="text-center mb-4">Popular Events</h2>
    <div class="row g-4">
        <?php foreach ($events as $event): ?>
            <?php component('event-card', ['event' => $event]) ?>
        <?php endforeach; ?>
    </div>

    <div class="d-flex justify-content-center mt-4">
        <a class="btn btn-success" href="<?= route('events') ?>">See More</a>
    </div>
</div>

<?php $content = ob_get_clean(); ?>
<?php layout('master', compact('content', 'style')); ?>