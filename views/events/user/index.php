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

    .offcanvas {
        max-width: 300px;
    }

    .sorting-dropdown {
        min-width: 200px;
    }
</style>
<?php $style = ob_get_clean(); ?>

<?php ob_start(); ?>
<div class="container my-5">
    <!-- Top bar with filter toggle and sorting -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <!-- Filter toggle button (mobile) using Bootstrap's data attributes -->
        <button class="btn btn-primary d-md-none"
            type="button"
            data-bs-toggle="offcanvas"
            data-bs-target="#filterOffcanvas">
            <i class="fas fa-filter"></i> Filters
        </button>

        <!-- Sorting dropdown -->
        <div class="dropdown ms-auto">
            <button class="btn btn-outline-secondary dropdown-toggle sorting-dropdown"
                type="button"
                data-bs-toggle="dropdown">
                Sort By
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="<?= $_SERVER['PATH_INFO'] . "?" . http_build_query(array_merge($_GET, ['sort' => 'asc'])) ?>">Recent</a></li>
                <li><a class="dropdown-item" href="<?= $_SERVER['PATH_INFO'] . "?" . http_build_query(array_merge($_GET, ['sort' => 'desc'])) ?>">Late</a></li>
            </ul>
        </div>
    </div>

    <?php
    $title = $_GET['title'] ?? "";
    $date_from = $_GET['date_from'] ?? "";
    $date_to = $_GET['date_to'] ?? "";
    $location_id = $_GET['location'] ?? 0;
    ?>

    <!-- Offcanvas Filter (mobile) -->
    <div class="offcanvas offcanvas-start" id="filterOffcanvas">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Filters</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <?php component('event-filter', [
                'title' => $title,
                'date_from' => $date_from,
                'date_to' => $date_to,
                'location_id' => $location_id,
                'locations' => $locations,
            ]) ?>
        </div>
    </div>

    <!-- Desktop filter -->
    <div class="d-none d-md-block mb-4">
        <?php component('event-filter', [
            'title' => $title,
            'date_from' => $date_from,
            'date_to' => $date_to,
            'location_id' => $location_id,
            'locations' => $locations,
        ]) ?>
    </div>

    <!-- Events grid -->
    <div class="row g-4">
        <?php foreach ($events['data'] as $event): ?>
            <?php component('event-card', ['event' => $event]) ?>
        <?php endforeach; ?>
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
        $(".filterForm").on("submit", function(event) {
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