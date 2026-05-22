<?php

use CodeIgniter\Pager\PagerRenderer;

/**
 * @var PagerRenderer $pager
 */

$pager->setSurroundCount(2);
?>

<nav aria-label="<?= lang('Pager.pageNavigation') ?>" class="mt-4">
    
    <ul class="pagination justify-content-center">

        <!-- První + Předchozí -->
        <?php if ($pager->hasPrevious()) : ?>

            <li class="page-item">
                <a 
                    class="page-link rounded-start"
                    href="<?= $pager->getFirst() ?>"
                    aria-label="<?= lang('Pager.first') ?>">
                    &laquo; První
                </a>
            </li>

            <li class="page-item">
                <a 
                    class="page-link"
                    href="<?= $pager->getPrevious() ?>"
                    aria-label="<?= lang('Pager.previous') ?>">
                    &lsaquo; Předchozí
                </a>
            </li>

        <?php endif ?>

        <!-- Čísla stránek -->
        <?php foreach ($pager->links() as $link) : ?>

            <li class="page-item <?= $link['active'] ? 'active' : '' ?>">

                <a 
                    class="page-link"
                    href="<?= $link['uri'] ?>">

                    <?= $link['title'] ?>

                </a>

            </li>

        <?php endforeach ?>

        <!-- Další + Poslední -->
        <?php if ($pager->hasNext()) : ?>

            <li class="page-item">
                <a 
                    class="page-link"
                    href="<?= $pager->getNext() ?>"
                    aria-label="<?= lang('Pager.next') ?>">
                    Další &rsaquo;
                </a>
            </li>

            <li class="page-item">
                <a 
                    class="page-link rounded-end"
                    href="<?= $pager->getLast() ?>"
                    aria-label="<?= lang('Pager.last') ?>">
                    Poslední &raquo;
                </a>
            </li>

        <?php endif ?>

    </ul>

</nav>