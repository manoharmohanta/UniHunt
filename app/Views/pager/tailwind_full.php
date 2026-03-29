<?php $pager->setSurroundCount(2) ?>

<nav aria-label="Page navigation" class="flex flex-col sm:flex-row items-center justify-between gap-4">
    <div class="flex-shrink-0">
        <p class="text-sm text-slate-500 font-medium">
            Showing page <span><?= $pager->getCurrentPageNumber() ?></span> of
            <span><?= $pager->getPageCount() ?></span>
        </p>
    </div>

    <div class="flex flex-wrap items-center justify-center sm:justify-end gap-1">
        <?php if ($pager->hasPrevious()): ?>
            <a href="<?= $pager->getFirst() ?>" aria-label="First"
                class="inline-flex items-center px-2 py-2 border border-slate-200 text-sm font-medium rounded-xl text-slate-500 bg-white hover:bg-slate-50 transition-colors">
                <span class="material-symbols-outlined text-base">first_page</span>
            </a>
            <a href="<?= $pager->getPrevious() ?>" aria-label="Previous"
                class="inline-flex items-center px-2 py-2 border border-slate-200 text-sm font-medium rounded-xl text-slate-500 bg-white hover:bg-slate-50 transition-colors">
                <span class="material-symbols-outlined text-base">chevron_left</span>
            </a>
        <?php endif ?>

        <?php foreach ($pager->links() as $link): ?>
            <a href="<?= $link['uri'] ?>"
                class="inline-flex items-center px-4 py-2 border text-sm font-bold rounded-xl transition-all <?= $link['active'] ? 'bg-indigo-600 border-indigo-600 text-white shadow-lg shadow-indigo-100' : 'bg-white border-slate-200 text-slate-600 hover:border-slate-300 hover:bg-slate-100' ?>">
                <?= $link['title'] ?>
            </a>
        <?php endforeach ?>

        <?php if ($pager->hasNext()): ?>
            <a href="<?= $pager->getNext() ?>" aria-label="Next"
                class="inline-flex items-center px-2 py-2 border border-slate-200 text-sm font-medium rounded-xl text-slate-500 bg-white hover:bg-slate-50 transition-colors">
                <span class="material-symbols-outlined text-base">chevron_right</span>
            </a>
            <a href="<?= $pager->getLast() ?>" aria-label="Last"
                class="inline-flex items-center px-2 py-2 border border-slate-200 text-sm font-medium rounded-xl text-slate-500 bg-white hover:bg-slate-50 transition-colors">
                <span class="material-symbols-outlined text-base">last_page</span>
            </a>
        <?php endif ?>
    </div>
</nav>