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
        /* padding: 8px 12px; */
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
    <form id="filterForm" class="mb-4 p-3 border rounded shadow-sm" method="GET" action="<?= route('events') ?>">
        <?php
        $title = $_GET['title'] ?? "";
        $date_from = $_GET['date_from'] ?? "";
        $date_to = $_GET['date_to'] ?? "";
        $location_id = $_GET['location'] ?? 0;
        ?>
        <div class="row g-3">
            <!-- Title -->
            <div class="col-md-3">
                <label class="form-label fw-semibold">Title</label>
                <input type="text" class="form-control" name="title" value="<?= $title ?>" placeholder="Search By Title">
            </div>

            <!-- Location -->
            <div class="col-md-3">
                <label class="form-label fw-semibold">Location</label>
                <select class="form-select" name="location">
                    <option value="">Select Location</option>
                    <?php foreach ($locations as $location) : ?>
                        <option <?= $location['id'] == $location_id ? 'selected' : '' ?> value="<?= $location['id'] ?>"><?= $location['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Date From -->
            <div class="col-md-3">
                <label class="form-label fw-semibold">Date From</label>
                <input type="date" class="form-control" name="date_from" value="<?= $date_from ?>" name="date_from">
            </div>

            <!-- Date To -->
            <div class="col-md-3">
                <label class="form-label fw-semibold">Date To</label>
                <input type="date" class="form-control" name="date_to" value="<?= $date_to ?>" name="date_to">
            </div>

            <!-- Submit Button -->
            <div class="col-12 d-flex gap-2 text-end">
                <a href="<?= route('events') ?>" class="btn btn-secondary btn-lg w-100" id="resetFilter">Reset</a>
                <button type="submit" class="btn btn-primary btn-lg w-100">Filter</button>
            </div>
        </div>
    </form>
    <div class="row g-4">
        <?php foreach ($events['data'] as $event): ?>
            <?php component('event-card', ['event' => $event]) ?>
        <?php endforeach; ?>
    </div>
</div>

<!-- Pagination Controls -->
<div class="d-flex justify-content-center mt-4">
    <?php
    $currentPage = $events['pagination']['current_page'];
    $totalPages = $events['pagination']['total_pages'];
    $previous = max(1, $currentPage - 1);
    $next = min($totalPages, $currentPage + 1);
    $queryString = $_GET;
    unset($queryString['page']);
    $queryString = http_build_query($queryString) . "&";

    component('pagination', [
        'currentPage' => $currentPage,
        'totalPages' => $totalPages,
        'previous' => $previous,
        'next' => $next,
        'queryString' => $queryString
    ])
    ?>
</div>

<?php ob_start() ?>
<script>
    $("#filterForm").on("submit", function(event) {
        event.preventDefault();

        const dateFrom = $("input[name='date_from']").val().trim();
        const dateTo = $("input[name='date_to']").val().trim();

        if ((dateFrom && !dateTo) || (!dateFrom && dateTo)) {
            alert("Please provide both 'Date From' and 'Date To' fields, or leave both empty.");
            return;
        }

        let formData = $(this).serializeArray();

        formData = formData.filter(function(field) {
            return field.value.trim() !== "";
        });

        const filteredFormData = new URLSearchParams();
        formData.forEach(function(field) {
            filteredFormData.append(field.name, field.value);
        });

        const actionUrl = $(this).attr("action");
        window.location.href = `${actionUrl}?${filteredFormData.toString()}`;
    });
</script>

<?php $script = ob_get_clean(); ?>

<?php $content = ob_get_clean(); ?>
<?php layout('master', compact('content', 'style', 'script')); ?>