<?php ob_start() ?>
<style>
    .event-card img {
        height: 25vh;
        object-fit: cover;
    }

    /* General pagination styles */
    .pagination {
        display: flex;
        list-style: none;
        padding: 0;
    }

    .page-item {
        margin: 0 5px;
    }

    .page-link {
        display: block;
        padding: 8px 12px;
        text-decoration: none;
        color: #007bff;
        border: 1px solid #ddd;
        border-radius: 5px;
        transition: background-color 0.3s, color 0.3s;
    }

    .page-link:hover {
        background-color: #f0f0f0;
        color: #0056b3;
    }

    /* Disabled links */
    a[aria-disabled="true"] {
        pointer-events: none;
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Active page styling */
    .page-link[aria-current="page"] {
        background-color: #007bff;
        color: #fff;
        font-weight: bold;
        pointer-events: none;
        border-color: #007bff;
    }
</style>
<?php $style = ob_get_clean(); ?>

<?php ob_start(); ?>
<div class="container my-5">
    <!-- Filter Form -->
    <form id="filterForm" class="mb-4" method="GET" action="<?= route('events') ?>">
        <div class="row">
            <div class="col-md-4">
                <input type="text" class="form-control" name="title" value="<?= $_GET['title'] ?? '' ?>" placeholder="Search By Title">
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control" name="location" value="<?= $_GET['location'] ?? '' ?>" placeholder="Search By Location">
            </div>
            <div class="col-md-3">
                <input type="date" class="form-control" value="<?= $_GET['date'] ?? '' ?>" name="date">
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
            <?php
            $currentPage = $events['pagination']['current_page'];
            $totalPages = $events['pagination']['total_pages'];
            $previous = max(1, $currentPage - 1);
            $next = min($totalPages, $currentPage + 1);
            $queryString = $_GET;
            unset($queryString['page']);
            $queryString = http_build_query($queryString) . "&";
            ?>

            <!-- Previous Link -->
            <li class="page-item">
                <a
                    class="page-link"
                    href="<?= $currentPage > 1 ? route('events') . "?{$queryString}page={$previous}" : '#' ?>"
                    aria-disabled="<?= $currentPage == 1 ? 'true' : 'false' ?>"
                    aria-label="Previous Page">
                    Previous
                </a>
            </li>

            <!-- Page Links -->
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item">
                    <a
                        class="page-link"
                        href="<?= $i != $currentPage ? route('events') . "?{$queryString}page={$i}" : '#' ?>"
                        aria-current="<?= $i == $currentPage ? 'page' : 'false' ?>"
                        aria-disabled="<?= $i == $currentPage ? 'true' : 'false' ?>"
                        aria-label="Go to page <?= $i ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>

            <!-- Next Link -->
            <li class="page-item">
                <a
                    class="page-link"
                    href="<?= $currentPage < $totalPages ? route('events') . "?{$queryString}page={$next}" : '#' ?>"
                    aria-disabled="<?= $currentPage == $totalPages ? 'true' : 'false' ?>"
                    aria-label="Next Page">
                    Next
                </a>
            </li>
        </ul>
    </nav>
</div>

<?php ob_start() ?>
<script>
    $("#filterForm").on("submit", function(event) {
        event.preventDefault();
        // get all fields value, remove empty field's name attribute
        const inputs = $(this).find("input")

        inputs.each(function(index, input) {
            if (!input.value) {
                input.removeAttribute("name");
            }
        })

        this.submit();

    })
</script>

<?php $script = ob_get_clean(); ?>

<?php $content = ob_get_clean(); ?>
<?php layout('master', compact('content', 'style', 'script')); ?>