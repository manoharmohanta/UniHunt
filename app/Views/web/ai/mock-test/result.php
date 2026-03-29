<?= view('web/include/header', ['title' => $title]) ?>

<main class="flex-grow bg-gray-50 dark:bg-[#0b1120] py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto space-y-8">
        
        <!-- Header -->
        <div class="text-center">
            <span class="inline-flex items-center gap-2 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 px-3 py-1 rounded-full text-sm font-bold mb-4">
                <span class="material-symbols-outlined text-base">check_circle</span> Analysis Complete
            </span>
            <h1 class="text-3xl font-black text-text-main dark:text-white">Assessment Results</h1>
            <p class="text-text-muted mt-2">Here is your AI-generated performance report.</p>
        </div>

        <!-- Score Card -->
        <div class="bg-white dark:bg-card-dark rounded-3xl shadow-lg border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="bg-primary p-8 text-center bg-[url('https://grainy-gradients.vercel.app/noise.svg')] bg-cover relative">
                <div class="absolute inset-0 bg-primary/90"></div>
                <div class="relative z-10">
                    <p class="text-white/80 font-medium mb-2 uppercase tracking-wide text-xs">Overall Score</p>
                    <div class="text-6xl font-black text-white mb-2">
                        <?= esc($summary['total_score'] ?? 'N/A') ?>
                    </div>
                    <p class="text-white/90 text-sm font-medium">Estimated Proficiency</p>
                </div>
            </div>
            
            <div class="p-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Breakdown -->
                <?php if (!empty($summary['breakdown'])): ?>
                    <?php foreach ($summary['breakdown'] as $section => $score): ?>
                    <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-xl border border-gray-100 dark:border-gray-700 text-center">
                        <h4 class="text-xs font-bold text-text-muted uppercase tracking-wider mb-1"><?= esc($section) ?></h4>
                        <span class="text-2xl font-bold text-text-main dark:text-white"><?= esc($score) ?></span>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Detailed Feedback -->
        <div class="bg-white dark:bg-card-dark rounded-3xl shadow-lg border border-gray-100 dark:border-gray-700 p-8">
            <h3 class="text-xl font-bold text-text-main dark:text-white mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">insights</span> Detailed Feedback
            </h3>
            
            <div class="prose dark:prose-invert max-w-none text-text-main dark:text-gray-300 leading-relaxed">
                <?php if (is_array($report)): ?>
                    <!-- If report is structured json -->
                    <?php foreach ($report as $key => $val): ?>
                        <div class="mb-4">
                            <h4 class="font-bold capitalize"><?= esc($key) ?></h4>
                            <p><?= esc(is_string($val) ? $val : json_encode($val)) ?></p>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <!-- If report is raw string -->
                    <?= nl2br(esc($report ?? 'No feedback generated.')) ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex justify-center gap-4">
            <a href="<?= base_url('dashboard') ?>" class="px-6 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-text-main dark:text-white font-bold rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                Back to Dashboard
            </a>
            <a href="<?= base_url('ai-tools/mock-take/' . $attempt['test_type']) ?>" class="px-6 py-3 bg-primary hover:bg-primary-hover text-white font-bold rounded-xl transition-colors shadow-lg hover:shadow-primary/30">
                Retake Test
            </a>
        </div>

    </div>
</main>

<?= view('web/include/footer') ?>
