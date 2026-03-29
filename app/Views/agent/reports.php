<?= view('web/include/header', ['title' => $title]) ?>

<div class="flex min-h-screen bg-gray-50 dark:bg-background-dark">
    <?= view('agent/include/sidebar') ?>

    <main class="flex-1 p-6 md:p-10">
        <div class="max-w-6xl mx-auto">
            <header class="mb-10">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Ad Performance Reports</h1>
                <p class="text-gray-600 dark:text-gray-400">Detailed analytics of your active campaigns.</p>
            </header>

            <div class="space-y-8">
                <?php foreach ($ads as $ad): ?>
                    <div
                        class="bg-white dark:bg-card-dark rounded-3xl border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">
                        <div class="p-8">
                            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                                <div>
                                    <h2 class="text-xl font-bold dark:text-white mb-1"><?= esc($ad['title']) ?></h2>
                                    <div class="flex items-center gap-3">
                                        <span
                                            class="text-xs text-gray-500 font-medium uppercase tracking-wider"><?= esc($ad['format']) ?></span>
                                        <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                                        <span
                                            class="text-xs text-gray-500 font-medium uppercase tracking-wider"><?= esc($ad['placement']) ?></span>
                                    </div>
                                </div>
                                <div class="px-4 py-2 bg-primary/5 dark:bg-primary/20 rounded-xl border border-primary/10">
                                    <span class="text-xs text-primary font-bold">Status:
                                        <?= strtoupper($ad['status']) ?></span>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <div class="p-6 rounded-2xl bg-gray-50 dark:bg-gray-800/50">
                                    <span class="text-xs text-gray-500 font-bold block mb-1">Impressions</span>
                                    <span
                                        class="text-2xl font-black dark:text-white"><?= number_format($ad['impressions']) ?></span>
                                </div>
                                <div class="p-6 rounded-2xl bg-gray-50 dark:bg-gray-800/50">
                                    <span class="text-xs text-gray-500 font-bold block mb-1">Total Clicks</span>
                                    <span
                                        class="text-2xl font-black dark:text-white"><?= number_format($ad['clicks']) ?></span>
                                </div>
                                <div class="p-6 rounded-2xl bg-gray-50 dark:bg-gray-800/50">
                                    <span class="text-xs text-gray-500 font-bold block mb-1">Click-Through Rate</span>
                                    <span class="text-2xl font-black text-primary">
                                        <?= ($ad['impressions'] > 0) ? number_format(($ad['clicks'] / $ad['impressions']) * 100, 2) : '0' ?>%
                                    </span>
                                </div>
                                <div class="p-6 rounded-2xl bg-gray-50 dark:bg-gray-800/50">
                                    <span class="text-xs text-gray-500 font-bold block mb-1">Budget Spent</span>
                                    <span
                                        class="text-2xl font-black dark:text-white">₹<?= number_format($ad['price_paid'], 2) ?></span>
                                </div>
                            </div>
                        </div>

                        <!-- Simple Progress visualization -->
                        <div class="px-8 pb-8">
                            <div class="text-[10px] font-bold text-gray-400 uppercase mb-2">Performance vs Average</div>
                            <div class="w-full h-2 bg-gray-100 dark:bg-gray-800 rounded-full overflow-hidden">
                                <div class="h-full bg-primary"
                                    style="width: <?= min(100, ($ad['clicks'] / max(1, $ad['impressions'])) * 2000) ?>%">
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <?php if (empty($ads)): ?>
                    <div
                        class="py-20 text-center bg-white dark:bg-card-dark rounded-3xl border-2 border-dashed border-gray-100 dark:border-gray-800">
                        <span class="material-symbols-outlined text-6xl text-gray-200 mb-4">analytics</span>
                        <p class="text-gray-500 font-medium">No active ad campaigns to report on.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
</div>

<?= view('web/include/footer') ?>