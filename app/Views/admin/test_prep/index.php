<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="mb-8 flex items-center justify-between">
    <div>
        <h2 class="text-2xl font-bold text-slate-800">Test Prep Exams</h2>
        <p class="text-slate-500 text-sm mt-1">Manage standard exams and their modules</p>
    </div>
    <!-- Placeholder for potential future "Add Exam" button -->
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    <?php if (!empty($exams)): ?>
        <?php foreach ($exams as $exam): ?>
            <div class="group bg-white rounded-2xl p-6 border border-slate-200 shadow-sm hover:shadow-md transition-all hover:-translate-y-1">
                <div class="flex items-start justify-between mb-4">
                    <div class="size-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <span class="material-symbols-outlined text-2xl">school</span>
                    </div>
                    <span class="px-2 py-1 rounded-md bg-slate-100 text-slate-500 text-xs font-bold uppercase tracking-wide">
                        <?= esc($exam['slug']) ?>
                    </span>
                </div>
                
                <h3 class="text-lg font-bold text-slate-800 mb-2"><?= esc($exam['name']) ?></h3>
                <p class="text-slate-400 text-sm mb-6">Manage modules and questions for <?= esc($exam['name']) ?>.</p>

                <a href="<?= base_url('admin/test-prep/modules/' . $exam['id']) ?>" 
                   class="flex items-center justify-center gap-2 w-full py-2.5 rounded-xl bg-indigo-50 text-indigo-600 font-semibold hover:bg-indigo-600 hover:text-white transition-colors">
                    <span>View Modules</span>
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-span-full py-12 text-center bg-white rounded-2xl border border-dashed border-slate-300">
            <div class="inline-flex items-center justify-center size-16 rounded-full bg-slate-50 text-slate-400 mb-4">
                <span class="material-symbols-outlined text-3xl">sentiment_dissatisfied</span>
            </div>
            <h3 class="text-lg font-medium text-slate-900 mb-1">No Exams Found</h3>
            <p class="text-slate-500">Please run the seeder to populate default exams.</p>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>