<?php ob_start() ?>
<style>
    .hero {
        background: linear-gradient(to right, #6a11cb, #2575fc);
        color: white;
        padding: 60px 20px;
        text-align: center;
    }

    .hero h1 {
        font-size: 3rem;
        font-weight: bold;
    }

    .hero p {
        font-size: 1.2rem;
        margin-top: 15px;
    }

    .event-card img {
        height: 200px;
        object-fit: cover;
    }
</style>
<?php $style = ob_get_clean(); ?>

<?php ob_start(); ?>
<div class="hero">
    <h1>Welcome to the Event Management System</h1>
    <p>Discover, create, and join amazing events happening around you.</p>
    <a href="/login" class="btn btn-primary btn-lg mt-3 me-2">Login</a>
    <a href="/register" class="btn btn-secondary btn-lg mt-3">Register</a>
</div>


<div class="container my-5">
    <h2 class="text-center mb-4">Upcoming Events</h2>
    <div class="row g-4">
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card event-card shadow">
                <img src="https://picsum.photos/400/200" class="card-img-top" alt="Event 1">
                <div class="card-body">
                    <h5 class="card-title">Tech Conference 2025</h5>
                    <p class="card-text">Join industry leaders to discuss the future of technology. Networking opportunities available!</p>
                    <p><strong>Date:</strong> Feb 25, 2025</p>
                    <a href="#" class="btn btn-primary">Register Now</a>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card event-card shadow">
                <img src="https://picsum.photos/400/200" class="card-img-top" alt="Event 2">
                <div class="card-body">
                    <h5 class="card-title">Art & Culture Fest</h5>
                    <p class="card-text">Experience the best of art, music, and culture in this one-of-a-kind festival.</p>
                    <p><strong>Date:</strong> Mar 10, 2025</p>
                    <a href="#" class="btn btn-primary">Register Now</a>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card event-card shadow">
                <img src="https://picsum.photos/400/200" class="card-img-top" alt="Event 3">
                <div class="card-body">
                    <h5 class="card-title">Startup Pitch Night</h5>
                    <p class="card-text">Watch entrepreneurs pitch their ideas to investors and get inspired by their stories.</p>
                    <p><strong>Date:</strong> Apr 5, 2025</p>
                    <a href="#" class="btn btn-primary">Register Now</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $content = ob_get_clean(); ?>
<?php layout('master', compact('content', 'style')); ?>