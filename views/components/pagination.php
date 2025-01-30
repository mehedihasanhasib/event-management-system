<ul class="pagination">
    <!-- Previous Link -->
    <li class="page-item">
        <a
            class="page-link"
            href="<?= route('events') . "?{$queryString}page=1" ?>"
            aria-disabled="<?= $currentPage == 1 ? 'true' : 'false' ?>"
            aria-label="First">
            First
        </a>
    </li>

    <!-- Page Links -->
    <?php if ($totalPages > 5): ?>
        <?php for ($i = 1 + ($currentPage - 2); $i < 5 + ($currentPage - 2); $i++): ?>
            <?php if ($i != 0): ?>
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
            <?php endif; ?>
        <?php endfor; ?>
        <?php if ($currentPage != $totalPages): ?>
            <li class="nav-item">
                <a href="#" class="page-link" aria-disabled="true">...</a>
            </li>
        <?php endif; ?>
    <?php else: ?>
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
    <?php endif; ?>

    <!-- Next Link -->
    <li class="page-item">
        <a
            class="page-link"
            href="<?= route('events') . "?{$queryString}page={$totalPages}" ?>"
            aria-disabled="<?= $currentPage == $totalPages ? 'true' : 'false' ?>"
            aria-label="Last">
            Last
        </a>
    </li>
</ul>