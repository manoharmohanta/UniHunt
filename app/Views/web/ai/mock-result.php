<?= view('web/include/header', ['title' => 'Analysis Report | UniHunt', 'bodyClass' => 'bg-[#F9FAFB] dark:bg-slate-900 text-slate-900 font-display antialiased min-h-screen']) ?>

<style>
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-slide-up { animation: slideUp 0.5s ease-out forwards; }
    .glass-card {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }
    .dark .glass-card {
        background: rgba(15, 23, 42, 0.8);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }
    .score-circle { transition: stroke-dasharray 1s ease-out; }
</style>

<!-- Main Content -->
<main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 w-full relative">
    <!-- Background Accents -->
    <div class="absolute top-0 right-0 -z-10 w-96 h-96 bg-primary/5 rounded-full blur-3xl opacity-50"></div>
    <div class="absolute bottom-0 left-0 -z-10 w-64 h-64 bg-indigo-500/5 rounded-full blur-3xl opacity-30"></div>

    <!-- Breadcrumbs -->
    <nav aria-label="Breadcrumb" class="flex mb-8 animate-slide-up" style="animation-delay: 0.1s">
        <ol class="inline-flex items-center space-x-2 text-xs font-semibold tracking-wide uppercase">
            <li><a class="text-slate-400 hover:text-primary transition-colors" href="<?= base_url('dashboard') ?>">Dashboard</a></li>
            <li><span class="text-slate-300">/</span></li>
            <li><a class="text-slate-400 hover:text-primary transition-colors" href="<?= base_url('ai-tools/mock-interview') ?>">Mock Interviews</a></li>
            <li><span class="text-slate-300">/</span></li>
            <li aria-current="page"><span class="text-primary">Analysis Report</span></li>
        </ol>
    </nav>

    <!-- Page Header -->
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8 mb-12 animate-slide-up" style="animation-delay: 0.2s">
        <div class="space-y-3">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 text-primary text-[10px] font-bold uppercase tracking-widest border border-primary/20">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
                </span>
                AI Enhanced Analysis
            </div>
            <h1 class="text-4xl md:text-5xl font-black text-slate-900 dark:text-white tracking-tight leading-tight">
                Interview <span class="text-transparent bg-clip-text bg-gradient-to-r from-primary to-indigo-600">Analysis Report</span>
            </h1>
            <div class="flex flex-wrap items-center gap-6 text-sm font-medium text-slate-500 dark:text-slate-400">
                <span class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-[20px] text-slate-400 font-light">language</span>
                    <?= $session['country'] ?? 'Global' ?> Mission
                </span>
                <span class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-[20px] text-slate-400 font-light">badge</span>
                    <?= $session['visa_type'] ?? 'General' ?> Visa
                </span>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <button onclick="window.print()"
                class="group flex items-center gap-2 px-6 py-3 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-sm hover:shadow-md text-sm font-bold text-slate-700 dark:text-white transition-all hover:-translate-y-0.5 active:scale-95">
                <span class="material-symbols-outlined text-[20px] group-hover:scale-110 transition-transform">picture_as_pdf</span>
                Export Report
            </button>
        </div>
    </div>

    <!-- Dashboard Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- RIGHT COLUMN: Sidebar Stats & Score (4 Cols) - MOVED UP FOR MOBILE PRIORITY -->
        <div class="lg:col-span-4 lg:order-2 space-y-8 animate-slide-up" style="animation-delay: 0.3s">
            <!-- Score Card -->
            <div class="glass-card rounded-[2.5rem] p-8 shadow-2xl shadow-primary/10 text-center relative overflow-hidden group">
                <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-primary via-indigo-500 to-primary"></div>
                
                <p class="text-[11px] font-black text-slate-400 uppercase tracking-[0.2em] mb-8">Performance Score</p>
                
                <div class="relative size-52 mx-auto mb-8">
                    <svg class="size-full -rotate-90" viewbox="0 0 36 36">
                        <circle class="text-slate-100 dark:text-slate-800" cx="18" cy="18" r="16" fill="none" stroke="currentColor" stroke-width="3"></circle>
                        <circle class="text-primary score-circle" cx="18" cy="18" r="16" fill="none" stroke="currentColor" stroke-width="3"
                            stroke-dasharray="<?= $analysis['total_score'] ?? 0 ?>, 100" stroke-linecap="round"></circle>
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-6xl font-black text-slate-900 dark:text-white tracking-tighter"><?= $analysis['total_score'] ?? 0 ?></span>
                        <div class="flex items-center gap-1 text-[10px] font-bold text-slate-400 uppercase">
                            Percentile
                        </div>
                    </div>
                </div>

                <div class="inline-flex items-center gap-2 px-4 py-2 <?= ($analysis['total_score'] ?? 0) >= 70 ? 'bg-emerald-50 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400' : 'bg-rose-50 text-rose-700 dark:bg-rose-500/10 dark:text-rose-400' ?> rounded-full text-sm font-black mb-8 border border-current/10">
                    <span class="material-symbols-outlined text-[18px]"><?= ($analysis['total_score'] ?? 0) >= 70 ? 'verified' : 'pending' ?></span>
                    <?= ($analysis['total_score'] ?? 0) >= 70 ? 'PASSIBLE STATUS' : 'NEEDS PRACTICE' ?>
                </div>

                <!-- 7 Parameters -->
                <div class="space-y-5 text-left pt-6 border-t border-slate-100 dark:border-slate-800">
                    <div class="flex items-center justify-between">
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Core Metrics</p>
                        <span class="text-[10px] text-primary font-bold">In-Depth</span>
                    </div>

                    <?php
                    $params = [
                        'clarity' => ['label' => 'Articulation', 'icon' => 'record_voice_over', 'color' => 'bg-amber-500'],
                        'confidence' => ['label' => 'Confidence', 'icon' => 'bolt', 'color' => 'bg-indigo-500'],
                        'content' => ['label' => 'Accuracy', 'icon' => 'fact_check', 'color' => 'bg-emerald-500'],
                        'reasoning' => ['label' => 'Logic', 'icon' => 'neurology', 'color' => 'bg-blue-500'],
                        'language' => ['label' => 'Fluency', 'icon' => 'translate', 'color' => 'bg-rose-500'],
                        'passing_potential' => ['label' => 'Impact', 'icon' => 'target', 'color' => 'bg-primary']
                    ];
                    foreach ($params as $key => $meta):
                        $val = $analysis[$key] ?? 50;
                        ?>
                        <div class="group/bar">
                            <div class="flex justify-between items-center mb-1.5 grayscale group-hover/bar:grayscale-0 transition-all">
                                <span class="text-[11px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-tight flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-[16px] text-slate-300 group-hover/bar:text-slate-900 dark:group-hover/bar:text-white transition-colors"><?= $meta['icon'] ?></span>
                                    <?= $meta['label'] ?>
                                </span>
                                <span class="text-xs font-black text-slate-900 dark:text-white"><?= $val ?>%</span>
                            </div>
                            <div class="w-full bg-slate-100 dark:bg-slate-800 h-2 rounded-full overflow-hidden">
                                <div class="<?= $meta['color'] ?> h-full rounded-full shadow-sm transition-all duration-1000 ease-out" style="width: 0%" x-init="setTimeout(() => $el.style.width = '<?= $val ?>%', 500)"></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- AI Officer Feedback -->
            <div class="bg-gradient-to-br from-indigo-600 to-primary rounded-[2.5rem] p-8 text-white shadow-xl relative overflow-hidden group">
                <span class="material-symbols-outlined absolute -right-4 -bottom-4 text-9xl text-white opacity-10 rotate-12 group-hover:rotate-0 transition-transform duration-700">chat_bubble</span>
                <h3 class="text-xs font-black uppercase tracking-[0.2em] mb-4 flex items-center gap-2 text-indigo-100">
                    <span class="material-symbols-outlined text-[18px]">psychology</span>
                    Expert Insights
                </h3>
                <p class="text-base leading-relaxed font-medium italic opacity-95 relative z-10">
                    "<?= $analysis['feedback'] ?? 'The candidate shows high articulation. Strengthening financial clarity and tying study goals to local career growth will significantly improve your visa success probability.' ?>"
                </p>
                <div class="mt-6 flex items-center gap-3">
                    <div class="size-10 rounded-full border-2 border-white/20 bg-white/10 flex items-center justify-center">
                        <span class="material-symbols-outlined">person_pin</span>
                    </div>
                    <div>
                        <p class="text-xs font-bold">UniHunt Officer</p>
                        <p class="text-[10px] opacity-70">AI Analysis Model 2.1</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- LEFT COLUMN: Detailed Q&A Analysis (8 Cols) -->
        <div class="lg:col-span-8 lg:order-1 space-y-8 animate-slide-up" style="animation-delay: 0.4s">
            <div class="flex items-center justify-between mb-2 px-2">
                <h2 class="text-2xl font-black text-slate-900 dark:text-white flex items-center gap-3">
                    <span class="size-10 rounded-2xl bg-primary text-white flex items-center justify-center shadow-lg shadow-primary/20">
                        <span class="material-symbols-outlined">forum</span>
                    </span>
                    Chronological Review
                </h2>
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest"><?= count($analysis['q_analysis'] ?? []) ?> Interactions</span>
            </div>

            <div class="grid grid-cols-1 gap-6">
                <?php if (!empty($analysis['q_analysis'])): ?>
                    <?php foreach ($analysis['q_analysis'] as $index => $item): ?>
                        <div class="group bg-white dark:bg-slate-800 rounded-[2rem] border border-slate-100 dark:border-slate-700 overflow-hidden shadow-sm hover:shadow-xl hover:border-primary/20 transition-all duration-300">
                            <!-- Header Bar -->
                            <div class="px-8 py-4 border-b border-slate-50 dark:border-slate-700 flex justify-between items-center bg-slate-50/50 dark:bg-slate-800/50">
                                <span class="px-3 py-1 rounded-full bg-slate-200 dark:bg-slate-700 text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase">
                                    Question #<?= str_pad($index + 1, 2, '0', STR_PAD_LEFT) ?>
                                </span>
                                <div class="flex items-center gap-4">
                                    <div class="flex items-center gap-1.5">
                                        <div class="size-2 rounded-full <?= ($item['score'] ?? 0) >= 70 ? 'bg-emerald-500' : 'bg-rose-500' ?>"></div>
                                        <span class="text-xs font-black text-slate-900 dark:text-white"><?= $item['score'] ?? 0 ?>%</span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Question Body -->
                            <div class="p-8 space-y-6">
                                <div class="space-y-2">
                                    <p class="text-[10px] font-black text-primary uppercase tracking-[0.1em]">Officer's Prompt</p>
                                    <h3 class="text-lg font-bold text-slate-900 dark:text-white leading-snug">
                                        <?= esc($item['question'] ?? 'No question provided') ?>
                                    </h3>
                                </div>

                                <div class="relative pl-6 py-4 border-l-2 border-primary/20 bg-primary/[0.02] dark:bg-primary/[0.05] rounded-r-2xl">
                                    <span class="material-symbols-outlined absolute -left-3.5 top-5 size-7 bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-700 rounded-full flex items-center justify-center text-[16px] text-primary">auto_awesome</span>
                                    <div class="space-y-2">
                                        <p class="text-[10px] font-black text-primary uppercase tracking-[0.1em]">Smart Correction</p>
                                        <p class="text-slate-600 dark:text-slate-300 italic text-[15px] leading-relaxed">
                                            "<?= esc($item['correction'] ?? 'Your response was adequate, keep focusing on specific details.') ?>"
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="py-20 text-center glass-card rounded-[2rem] border-2 border-dashed border-slate-200 dark:border-slate-700">
                        <div class="size-16 bg-slate-100 dark:bg-slate-800 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <span class="material-symbols-outlined text-3xl text-slate-400">sentiment_dissatisfied</span>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-1">No Analysis Data</h3>
                        <p class="text-sm text-slate-500">The detailed breakdown for this session is unavailable.</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Ad Slot: Score Page -->
            <div class="py-4">
                <div class="uni-ad-slot" data-placement="score_page"></div>
            </div>
        </div>
    </div>

    <!-- Call to Action Footer -->
    <div class="mt-20 glass-card rounded-[3rem] p-10 text-center animate-slide-up relative overflow-hidden group" style="animation-delay: 0.5s">
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-primary to-transparent opacity-50"></div>
        <div class="relative z-10 space-y-6 max-w-2xl mx-auto">
            <h3 class="text-3xl font-black text-slate-900 dark:text-white tracking-tight">Ready to Master Your Interview?</h3>
            <p class="text-slate-500 font-medium">Consistent practice is the key to reducing anxiety and perfecting your narrative. Let's sharpen those skills.</p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="<?= base_url('ai-tools/mock-interview') ?>"
                    class="w-full sm:w-auto px-10 py-4 bg-primary text-white font-black rounded-2xl shadow-xl shadow-primary/30 hover:shadow-primary/40 transition-all hover:-translate-y-1 active:scale-95 flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined">restart_alt</span>
                    Start New Practice
                </a>
                <a href="<?= base_url('dashboard') ?>"
                    class="w-full sm:w-auto px-10 py-4 bg-white dark:bg-slate-800 text-slate-700 dark:text-white font-black rounded-2xl border border-slate-200 dark:border-slate-700 hover:bg-slate-50 transition-all">
                    Back to Dashboard
                </a>
            </div>
        </div>
    </div>
</main>

<?= view('web/include/footer') ?>