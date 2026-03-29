<?= view('web/include/header', [
    'title' => 'AI Education Tools | UniHunt',
    'bodyClass' => 'bg-background-light font-display text-text-main antialiased transition-colors duration-200'
]) ?>

<main class="flex-grow py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">

        <!-- Header -->
        <div class="text-center mb-12">
            <span
                class="inline-block py-1 px-3 rounded-full bg-primary/10 text-primary text-xs font-bold uppercase tracking-wider mb-4">
                Powered by Advanced AI
            </span>
            <h1 class="text-3xl md:text-5xl font-black text-text-main tracking-tight mb-4">
                AI Application Tools
            </h1>
            <p class="text-lg text-text-muted max-w-2xl mx-auto">
                Supercharge your study abroad journey with our suite of AI-powered tools unique to UniHunt.
            </p>
        </div>

        <!-- Tool Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            <!-- Resume Builder -->
            <div
                class="group relative p-6 bg-surface-light border border-border-light rounded-2xl transition-all duration-300 hover:shadow-soft hover:border-primary/50 hover:-translate-y-1">
                <div class="flex justify-between items-start mb-4">
                    <div
                        class="w-12 h-12 rounded-xl bg-secondary/10 text-secondary flex items-center justify-center group-hover:bg-primary group-hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-2xl">description</span>
                    </div>
                    <?php if ($paymentEnabled && isset($aiTools[2]) && $aiTools[2]['price'] > 0): ?>
                        <span
                            class="bg-indigo-50 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400 px-3 py-1 rounded-full text-xs font-bold ring-1 ring-inset ring-indigo-500/20">₹<?= number_format($aiTools[2]['price'], 2) ?></span>
                    <?php endif; ?>
                </div>
                <h3 class="text-lg font-bold text-text-main mb-2">Resume Builder</h3>
                <p class="text-sm text-text-muted leading-relaxed mb-4">Create an ATS-friendly, university-standard
                    academic resume in minutes.</p>
                <a href="<?= base_url('ai-tools/resume-builder-form') ?>"
                    class="inline-flex items-center text-primary font-bold text-sm hover:underline">
                    Try Now <span class="material-symbols-outlined text-base ml-1">arrow_forward</span>
                </a>
            </div>

            <!-- SOP Generator -->
            <div
                class="group relative p-6 bg-surface-light border border-border-light rounded-2xl transition-all duration-300 hover:shadow-soft hover:border-primary/50 hover:-translate-y-1">
                <div class="flex justify-between items-start mb-4">
                    <div
                        class="w-12 h-12 rounded-xl bg-primary/10 text-primary flex items-center justify-center group-hover:bg-primary group-hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-2xl">note_add</span>
                    </div>
                    <?php if ($paymentEnabled && isset($aiTools[5]) && $aiTools[5]['price'] > 0): ?>
                        <span
                            class="bg-indigo-50 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400 px-3 py-1 rounded-full text-xs font-bold ring-1 ring-inset ring-indigo-500/20">₹<?= number_format($aiTools[5]['price'], 2) ?></span>
                    <?php endif; ?>
                </div>
                <h3 class="text-lg font-bold text-text-main mb-2">SOP Generator</h3>
                <p class="text-sm text-text-muted leading-relaxed mb-4">Craft a compelling Statement of Purpose tailored
                    to your dream university.</p>
                <a href="<?= base_url('ai-tools/sop-generator-form') ?>"
                    class="inline-flex items-center text-primary font-bold text-sm hover:underline">
                    Try Now <span class="material-symbols-outlined text-base ml-1">arrow_forward</span>
                </a>
            </div>

            <!-- LOR Generator -->
            <div
                class="group relative p-6 bg-surface-light border border-border-light rounded-2xl transition-all duration-300 hover:shadow-soft hover:border-primary/50 hover:-translate-y-1">
                <div class="flex justify-between items-start mb-4">
                    <div
                        class="w-12 h-12 rounded-xl bg-purple-500/10 text-purple-500 flex items-center justify-center group-hover:bg-primary group-hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-2xl">history_edu</span>
                    </div>
                    <?php if ($paymentEnabled && isset($aiTools[1]) && $aiTools[1]['price'] > 0): ?>
                        <span
                            class="bg-indigo-50 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400 px-3 py-1 rounded-full text-xs font-bold ring-1 ring-inset ring-indigo-500/20">₹<?= number_format($aiTools[1]['price'], 2) ?></span>
                    <?php endif; ?>
                </div>
                <h3 class="text-lg font-bold text-text-main mb-2">LOR Generator</h3>
                <p class="text-sm text-text-muted leading-relaxed mb-4">Draft professional Letters of Recommendation for
                    your referees.</p>
                <a href="<?= base_url('ai-tools/lor-generator-form') ?>"
                    class="inline-flex items-center text-primary font-bold text-sm hover:underline">
                    Try Now <span class="material-symbols-outlined text-base ml-1">arrow_forward</span>
                </a>
            </div>

            <!-- Visa Check -->
            <div
                class="group relative p-6 bg-surface-light border border-border-light rounded-2xl transition-all duration-300 hover:shadow-soft hover:border-primary/50 hover:-translate-y-1">
                <div class="flex justify-between items-start mb-4">
                    <div
                        class="w-12 h-12 rounded-xl bg-teal-500/10 text-teal-500 flex items-center justify-center group-hover:bg-primary group-hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-2xl">airplane_ticket</span>
                    </div>
                    <?php if ($paymentEnabled && isset($aiTools[4]) && $aiTools[4]['price'] > 0): ?>
                        <span
                            class="bg-indigo-50 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400 px-3 py-1 rounded-full text-xs font-bold ring-1 ring-inset ring-indigo-500/20">₹<?= number_format($aiTools[4]['price'], 2) ?></span>
                    <?php endif; ?>
                </div>
                <h3 class="text-lg font-bold text-text-main mb-2">Visa Plan Generator</h3>
                <p class="text-sm text-text-muted leading-relaxed mb-4">Get a comprehensive visa checklist, travel
                    itinerary, and tips.</p>
                <a href="<?= base_url('ai-tools/visa-checker-form') ?>"
                    class="inline-flex items-center text-primary font-bold text-sm hover:underline">
                    Try Now <span class="material-symbols-outlined text-base ml-1">arrow_forward</span>
                </a>
            </div>

            <!-- Career Predictor -->
            <div
                class="group relative p-6 bg-surface-light border border-border-light rounded-2xl transition-all duration-300 hover:shadow-soft hover:border-primary/50 hover:-translate-y-1">
                <div class="flex justify-between items-start mb-4">
                    <div
                        class="w-12 h-12 rounded-xl bg-pink-500/10 text-pink-500 flex items-center justify-center group-hover:bg-primary group-hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-2xl">trending_up</span>
                    </div>
                    <?php if ($paymentEnabled && isset($aiTools[3]) && $aiTools[3]['price'] > 0): ?>
                        <span
                            class="bg-indigo-50 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400 px-3 py-1 rounded-full text-xs font-bold ring-1 ring-inset ring-indigo-500/20">₹<?= number_format($aiTools[3]['price'], 2) ?></span>
                    <?php endif; ?>
                </div>
                <h3 class="text-lg font-bold text-text-main mb-2">Career Predictor</h3>
                <p class="text-sm text-text-muted leading-relaxed mb-4">Forecast your future job roles, salary, and
                    career growth curve.</p>
                <a href="<?= base_url('ai-tools/career-predictor-form') ?>"
                    class="inline-flex items-center text-primary font-bold text-sm hover:underline">
                    Try Now <span class="material-symbols-outlined text-base ml-1">arrow_forward</span>
                </a>
            </div>

            <!-- Mock Interview -->
            <div
                class="group relative p-6 bg-surface-light border border-border-light rounded-2xl transition-all duration-300 hover:shadow-soft hover:border-primary/50 hover:-translate-y-1">
                <div class="flex justify-between items-start mb-4">
                    <div
                        class="w-12 h-12 rounded-xl bg-indigo-500/10 text-indigo-500 flex items-center justify-center group-hover:bg-primary group-hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-2xl">mic</span>
                    </div>
                    <?php if ($paymentEnabled && isset($aiTools[6]) && $aiTools[6]['price'] > 0): ?>
                        <span
                            class="bg-indigo-50 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400 px-3 py-1 rounded-full text-xs font-bold ring-1 ring-inset ring-indigo-500/20">₹<?= number_format($aiTools[6]['price'], 2) ?></span>
                    <?php endif; ?>
                </div>
                <h3 class="text-lg font-bold text-text-main mb-2">AI Mock Interview</h3>
                <p class="text-sm text-text-muted leading-relaxed mb-4">Practice with a realistic AI interviewer and get
                    instant feedback.</p>
                <a href="<?= base_url('ai-tools/mock-interview') ?>"
                    class="inline-flex items-center text-primary font-bold text-sm hover:underline">
                    Try Now <span class="material-symbols-outlined text-base ml-1">arrow_forward</span>
                </a>
            </div>

        </div>

        <!-- Mock Tests Section -->
        <div class="mt-16 space-y-12">
            <div>
                <h2 class="text-2xl font-bold text-text-main mb-6 flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">translate</span>
                    English Proficiency Tests
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php
                    $english_tests = [
                        ['name' => 'IELTS Academic', 'bg' => 'bg-red-500/10', 'color' => 'text-red-500', 'icon' => 'language', 'link' => 'ielts'],
                        ['name' => 'PTE Academic', 'bg' => 'bg-orange-500/10', 'color' => 'text-orange-500', 'icon' => 'record_voice_over', 'link' => 'pte'],
                        ['name' => 'TOEFL iBT', 'bg' => 'bg-cyan-500/10', 'color' => 'text-cyan-500', 'icon' => 'public', 'link' => 'toefl'],
                        ['name' => 'Duolingo Test', 'bg' => 'bg-green-500/10', 'color' => 'text-green-500', 'icon' => 'translate', 'link' => 'duolingo'],
                    ];
                    ?>

                    <?php foreach ($english_tests as $test): ?>
                        <div
                            class="group relative flex items-center gap-4 p-4 bg-surface-light border border-border-light rounded-xl hover:shadow-md transition-all">
                            <div
                                class="w-12 h-12 rounded-lg <?= $test['bg'] ?> <?= $test['color'] ?> flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-2xl"><?= $test['icon'] ?></span>
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <h4 class="font-bold text-text-main"><?= $test['name'] ?></h4>
                                    <?php if ($paymentEnabled && isset($aiTools[10]) && $aiTools[10]['price'] > 0): ?>
                                        <span
                                            class="bg-indigo-50 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400 px-2 py-0.5 rounded text-[10px] font-bold ring-1 ring-inset ring-indigo-500/20">₹<?= number_format($aiTools[10]['price'], 2) ?></span>
                                    <?php endif; ?>
                                </div>
                                <a href="<?= base_url('ai-tools/' . $test['link']) ?>"
                                    class="text-xs font-bold text-primary hover:underline mt-1 inline-block">Start Test</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div>
                <h2 class="text-2xl font-bold text-text-main mb-6 flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">analytics</span>
                    Analytical & Entrance Tests
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php
                    $analytical_tests = [
                        ['name' => 'GRE General', 'bg' => 'bg-purple-500/10', 'color' => 'text-purple-500', 'icon' => 'calculate', 'link' => 'gre'],
                        ['name' => 'GMAT Focus', 'bg' => 'bg-blue-500/10', 'color' => 'text-blue-500', 'icon' => 'analytics', 'link' => 'gmat'],
                        ['name' => 'Digital SAT', 'bg' => 'bg-pink-500/10', 'color' => 'text-pink-500', 'icon' => 'edit_note', 'link' => 'sat'],
                        ['name' => 'ACT Test', 'bg' => 'bg-yellow-500/10', 'color' => 'text-yellow-500', 'icon' => 'school', 'link' => 'act'],
                    ];
                    ?>

                    <?php foreach ($analytical_tests as $test): ?>
                        <div
                            class="group relative flex items-center gap-4 p-4 bg-surface-light border border-border-light rounded-xl hover:shadow-md transition-all">
                            <div
                                class="w-12 h-12 rounded-lg <?= $test['bg'] ?> <?= $test['color'] ?> flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-2xl"><?= $test['icon'] ?></span>
                            </div>
                            <div class="flex-1">
                                <div class="flex justify-between items-start">
                                    <h4 class="font-bold text-text-main"><?= $test['name'] ?></h4>
                                    <?php if ($paymentEnabled && isset($aiTools[10]) && $aiTools[10]['price'] > 0): ?>
                                        <span
                                            class="bg-indigo-50 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400 px-2 py-0.5 rounded text-[10px] font-bold ring-1 ring-inset ring-indigo-500/20">₹<?= number_format($aiTools[10]['price'], 2) ?></span>
                                    <?php endif; ?>
                                </div>
                                <a href="<?= base_url('ai-tools/' . $test['link']) ?>"
                                    class="text-xs font-bold text-primary hover:underline mt-1 inline-block">Start Test</a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

    </div>
</main>

<?= view('web/include/footer') ?>