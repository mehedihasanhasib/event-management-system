<ul class="pagination">
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