<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="mb-8 flex items-center justify-between">
    <div>
        <div class="flex items-center gap-2 text-sm text-slate-500 mb-1">
            <a href="<?= base_url('admin/test-prep') ?>" class="hover:text-indigo-600 transition-colors">Exams</a>
            <span class="material-symbols-outlined text-[10px]">chevron_right</span>
            <span><?= esc($exam['name']) ?></span>
        </div>
        <h2 class="text-2xl font-bold text-slate-800">Modules: <?= esc($exam['name']) ?></h2>
    </div>
    <a href="<?= base_url('admin/test-prep') ?>"
        class="flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 rounded-xl text-slate-600 font-medium hover:bg-slate-50 transition-colors">
        <span class="material-symbols-outlined text-lg">arrow_back</span>
        Back to Exams
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php if (!empty($modules)): ?>
        <?php foreach ($modules as $module): ?>
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition-all">
                <div class="flex items-center gap-4 mb-4">
                    <div class="size-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <span class="material-symbols-outlined">library_books</span>
                    </div>
                </div>

                <h3 class="text-lg font-bold text-slate-800 mb-1"><?= esc($module['name']) ?></h3>
                <p class="text-slate-400 text-xs font-mono mb-6 bg-slate-50 inline-block px-1.5 py-0.5 rounded">
                    <?= esc($module['slug']) ?>
                </p>

                <div class="space-y-3">
                    <!-- Resource Based (Audio/Reading) -->
                    <a href="<?= base_url('admin/test-prep/resources/' . $module['id']) ?>"
                        class="flex items-center justify-center gap-2 w-full py-2.5 rounded-xl bg-slate-900 text-white font-medium hover:bg-slate-800 transition-colors">
                        <span class="material-symbols-outlined text-sm">folder</span>
                        <span>
                            <?= (strpos(strtolower($module['slug']), 'writing') !== false || strpos(strtolower($module['slug']), 'speaking') !== false) ? 'Manage Topics' : 'Manage Resources' ?>
                        </span>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-span-full py-12 text-center bg-white rounded-2xl border border-dashed border-slate-300">
            <div class="inline-flex items-center justify-center size-16 rounded-full bg-slate-50 text-slate-400 mb-4">
                <span class="material-symbols-outlined text-3xl">folder_off</span>
            </div>
            <h3 class="text-lg font-medium text-slate-900 mb-1">No Modules Found</h3>
            <p class="text-slate-500">This exam doesn't have any modules yet.</p>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>