<?php ob_start() ?>
<style>
    .event-card img {
        height: 25vh;
        object-fit: cover;
    }
</style>
<?php $style = ob_get_clean(); ?>

<?php ob_start(); ?>
<div class="container my-5">
    <!-- Filter Form -->
    <form class="mb-4" method="get" action="events_list.php">
        <div class="row">
            <div class="col-md-3">
                <input type="text" class="form-control" name="event_name" placeholder="Event Name" value="">
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" name="location" placeholder="Location" value="">
            </div>
            <div class="col-md-2">
                <input type="date" class="form-control" name="start_date" value="">
            </div>
            <div class="col-md-2">
                <input type="date" class="form-control" name="end_date" value="">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </div>
    </form>
    <div class="row g-4">
        <?php foreach ($events['data'] as $event): ?>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="card event-card shadow">
                    <img src="<?= $event['banner'] ?>" class="card-img-top" alt="<?= $event['title'] ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?= $event['title'] ?></h5>
                        <p class="card-text"><?= substr($event['description'], 0, 50) . " ..." ?></p>
                        <p><strong>Date:</strong> <?= $event['date'] ?></p>
                        <div>
                            <a href="#" class="btn btn-primary">Register Now</a>
                            <a href="#" class="btn btn-secondary">Details</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<!-- Pagination Controls -->
<div class="d-flex justify-content-center mt-4">
    <nav>
        <ul class="pagination">
            <?php $previous = $events['pagination']['current_page'] - 1 ?>
            <?php $next = $events['pagination']['current_page'] + 1 ?>
            <li class="page-item">
                <a class="page-link" href="<?= route('events') . "?page={$previous}" ?>">Previous</a>
            </li>
            <?php for ($i = 1; $i < $events['pagination']['total_pages']; $i++): ?>

                <li class="page-item">
                    <a class="page-link" href="<?= route('events') . "?page={$i}" ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
            <li class="page-item">
                <a class="page-link" href="<?= route('events') . "?page={$next}" ?>">Next</a>
            </li>
            <!-- <li class="page-item">
                <a class="page-link" href="events_list.php?page=2">2</a>
            </li>
            <li class="page-item active">
                <a class="page-link" href="events_list.php?page=3">3</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="events_list.php?page=4">4</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="events_list.php?page=5">Next</a>
            </li> -->
        </ul>
    </nav>
</div>

<?php $content = ob_get_clean(); ?>
<?php layout('master', compact('content', 'style')); ?>