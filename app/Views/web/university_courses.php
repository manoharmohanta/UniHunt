<?= view('web/include/header', ['title' => 'Programs at ' . $university['name'] . ' - UniHunt', 'bodyClass' => 'bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 antialiased flex flex-col min-h-screen']) ?>

<div class="flex-grow w-full max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumbs -->
    <nav aria-label="Breadcrumb" class="flex mb-8">
        <ol class="flex items-center space-x-2">
            <li><a class="text-text-muted hover:text-primary text-sm font-medium" href="<?= base_url() ?>">Home</a></li>
            <li><span class="text-text-muted text-sm">/</span></li>
            <li><a class="text-text-muted hover:text-primary text-sm font-medium"
                    href="<?= base_url('universities') ?>">Universities</a></li>
            <li><span class="text-text-muted text-sm">/</span></li>
            <li><a class="text-text-muted hover:text-primary text-sm font-medium"
                    href="<?= base_url('universities/' . $university['country_slug'] . '/' . $university['slug']) ?>">
                    <?= esc($university['name']) ?>
                </a></li>
            <li><span class="text-text-muted text-sm">/</span></li>
            <li><span class="text-text-main dark:text-white text-sm font-medium">All Programs</span></li>
        </ol>
    </nav>

    <!-- Header Section -->
    <div class="mb-10">
        <h1 class="text-3xl md:text-5xl font-black text-primary dark:text-white mb-4">
            Discover Programs at <br class="hidden md:block">
            <span class="text-secondary">
                <?= esc($university['name']) ?>
            </span>
        </h1>
        <p class="text-slate-500 dark:text-slate-400 text-lg max-w-2xl">
            Browse through our comprehensive list of undergraduate, postgraduate, and research programs. Filter to find
            the perfect course for your career goals.
        </p>
    </div>

    <!-- Courses Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php if (!empty($courses)): ?>
            <?php foreach ($courses as $course): ?>
                <div
                    class="group bg-surface-light dark:bg-surface-dark border border-slate-100 dark:border-slate-800 rounded-2xl p-6 shadow-soft hover:shadow-soft-hover transition-all duration-300 flex flex-col h-full border-b-4 border-b-transparent hover:border-b-primary">
                    <div class="flex items-center justify-between mb-4">
                        <span
                            class="bg-primary/10 text-primary dark:text-primary-light text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest">
                            <?= esc($course['level']) ?>
                        </span>
                        <?php if ($course['stem']): ?>
                            <div class="flex items-center gap-1 text-emerald-500">
                                <span class="material-symbols-outlined text-[18px]">verified</span>
                                <span class="text-[10px] font-black uppercase tracking-tighter">STEM</span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <h3
                        class="text-xl font-bold text-slate-900 dark:text-white mb-2 leading-tight group-hover:text-primary transition-colors">
                        <?= esc($course['name']) ?>
                    </h3>

                    <div class="flex items-center gap-2 text-slate-400 text-sm mb-6">
                        <span class="material-symbols-outlined text-[18px]">category</span>
                        <span>
                            <?= esc($course['field']) ?>
                        </span>
                    </div>

                    <hr class="border-slate-100 dark:border-slate-800 mb-6 border-dashed">

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <span
                                class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Duration</span>
                            <div class="flex items-center gap-1 font-bold text-slate-700 dark:text-slate-200">
                                <span class="material-symbols-outlined text-[18px] text-primary">schedule</span>
                                <span>
                                    <?= esc($course['duration_months']) ?> Months
                                </span>
                            </div>
                        </div>
                        <div>
                            <span
                                class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block mb-1">Tuition</span>
                            <div class="flex items-center gap-1 font-bold text-slate-700 dark:text-slate-200">
                                <span class="material-symbols-outlined text-[18px] text-primary">payments</span>
                                <span>
                                    <?= $course['tuition_fee'] ? format_currency_price($course['tuition_fee'], $university['country_currency']) : 'N/A' ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-auto pt-2">
                        <a href="<?= base_url('courses/' . $university['country_slug'] . '/' . $university['slug'] . '/' . url_title($course['name'], '-', true)) ?>"
                            class="w-full inline-flex items-center justify-center gap-2 py-3 bg-slate-50 dark:bg-slate-800/50 hover:bg-primary hover:text-white text-slate-700 dark:text-slate-300 font-bold rounded-xl transition-all group-hover:bg-primary group-hover:text-white shadow-soft">
                            <span>View Details</span>
                            <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div
                class="col-span-full py-20 text-center bg-surface-light dark:bg-surface-dark rounded-3xl border border-dashed border-slate-200 dark:border-slate-700">
                <span class="material-symbols-outlined text-6xl text-slate-300 mb-4 block">school</span>
                <h3 class="text-xl font-bold text-slate-700 dark:text-slate-200 mb-2">No Programs Listed Yet</h3>
                <p class="text-slate-400 max-w-sm mx-auto">We are currently updating our course catalog for
                    <?= esc($university['name']) ?>. Please check back later.
                </p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= view('web/include/footer') ?>