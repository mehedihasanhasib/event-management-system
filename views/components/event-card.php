<?php
$title = htmlspecialchars($event['title']);
$description = htmlspecialchars($event['description']);
$banner = htmlspecialchars($event['banner']);
$date = htmlspecialchars($event['date']);
?>

<div class="col-12 col-md-6 col-lg-4">
    <div class="card event-card shadow">
        <img src="<?= asset($banner) ?>" class="card-img-top" alt="<?= $title ?>">
        <div class="card-body">
            <h5 class="card-title"><?= strlen($title) > 30 ? substr($title, 0, 30) . " ..." : $title ?></h5>
            <p class="card-text"><?= strlen($description) > 45 ?  substr($description, 0, 45) . " ..." : $description ?></p>
            <p><strong>Date:</strong> <?= $date ?></p>
            <div class="d-flex justify-content-end align-items-center">
                <!-- <a href="#" class="btn btn-primary">Register Now</a> -->
                <a href="<?= route('event.show', ['slug' => $event['slug']]) ?>" class="btn btn-primary">Details</a>
            </div>
        </div>
    </div>
</div>