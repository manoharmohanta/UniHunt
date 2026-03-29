<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-200 flex justify-between items-center gap-4">
        <h2 class="text-lg font-bold text-slate-900 whitespace-nowrap">All Blogs</h2>

        <div class="flex items-center gap-3 flex-1 justify-end">
            <form action="<?= base_url('admin/blogs') ?>" method="GET" class="flex items-center gap-2 w-full max-w-xs">
                <div class="relative group flex-1">
                    <input type="text" name="search" value="<?= esc($search ?? '') ?>" placeholder="Search blogs..."
                        class="pl-10 pr-10 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all w-full group-hover:bg-white">
                    <span
                        class="material-symbols-outlined absolute left-3 top-2.5 text-slate-400 text-sm group-hover:text-indigo-500 transition-colors">search</span>
                    <?php if (!empty($search)): ?>
                        <a href="<?= base_url('admin/blogs') ?>"
                            class="absolute right-3 top-2.5 text-slate-400 hover:text-rose-500 transition-colors">
                            <span class="material-symbols-outlined text-sm">close</span>
                        </a>
                    <?php endif; ?>
                </div>
                <button type="submit"
                    class="px-4 py-2 bg-slate-800 text-white text-sm font-semibold rounded-xl hover:bg-slate-900 transition-all shadow-sm">
                    Search
                </button>
            </form>

            <a href="<?= base_url('admin/blogs/create') ?>"
                class="flex-shrink-0 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium transition-colors inline-flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">add</span> New Post
            </a>
        </div>
    </div>

    <div id="blogs-container">
        <?= view('admin/blogs_table', ['blogs' => $blogs, 'pager' => $pager]) ?>
    </div>
</div>
</div>

<?= $this->endSection() ?>