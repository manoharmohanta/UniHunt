<?= view('web/include/header', ['title' => 'Career Forecast - ' . ($course_name ?? 'Future'), 'bodyClass' => 'bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 font-display min-h-screen flex flex-col transition-colors duration-200']) ?>

<!-- Main Content -->
<main class="flex-1 w-full max-w-[1280px] mx-auto px-4 md:px-8 py-8">
    <div class="flex flex-col gap-8">
        <!-- Header -->
        <div
            class="bg-white dark:bg-surface-dark rounded-2xl border border-border-light dark:border-border-dark p-6 md:p-10 shadow-soft relative overflow-hidden">
            <div class="absolute top-0 right-0 p-8 opacity-5">
                <span class="material-symbols-outlined text-[200px]">trending_up</span>
            </div>
            <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <span
                            class="px-3 py-1 bg-primary/10 text-primary text-xs font-bold rounded-full uppercase tracking-wider">Career
                            Outcome Predictor</span>
                        <span class="text-text-secondary dark:text-gray-500 text-sm">Based on current global data</span>
                    </div>
                    <h1 class="text-3xl md:text-5xl font-black text-text-main dark:text-white tracking-tight">
                        <?= $course_name ?></h1>
                    <p class="text-text-secondary dark:text-gray-400 mt-2">Market potential from primary perspective:
                        <span class="font-bold text-primary"><?= $home_country ?></span></p>
                </div>
                <div>
                    <button onclick="window.print()"
                        class="flex items-center justify-center rounded-xl h-12 px-6 bg-primary hover:bg-[#158bb3] text-white text-sm font-bold shadow-lg shadow-primary/30 transition-all">
                        <span class="material-symbols-outlined mr-2">download</span>
                        Download Career Report
                    </button>
                </div>
            </div>
        </div>

        <!-- Dashboard Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Potential Job Titles -->
            <div
                class="bg-white dark:bg-surface-dark rounded-2xl border border-border-light dark:border-border-dark shadow-soft overflow-hidden">
                <div
                    class="p-6 border-b border-border-light dark:border-border-dark bg-gray-50 dark:bg-gray-800/50 flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">person_search</span>
                    <h2 class="text-xl font-bold text-text-main dark:text-white">Probable Job Titles</h2>
                </div>
                <div class="p-6">
                    <div class="prose prose-slate dark:prose-invert max-w-none markdown-content hidden">
                        <?= htmlspecialchars($job_titles ?? 'No job title data available.') ?>
                    </div>
                </div>
            </div>

            <!-- Strategic Roadmap -->
            <div
                class="lg:col-span-2 bg-white dark:bg-surface-dark rounded-2xl border border-border-light dark:border-border-dark shadow-soft overflow-hidden">
                <div
                    class="p-6 border-b border-border-light dark:border-border-dark bg-gray-50 dark:bg-gray-800/50 flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">alt_route</span>
                    <h2 class="text-xl font-bold text-text-main dark:text-white">Career Evolution Roadmap</h2>
                </div>
                <div class="p-6">
                    <div class="prose prose-slate dark:prose-invert max-w-none markdown-content hidden">
                        <?= htmlspecialchars($career_roadmap ?? 'No roadmap available.') ?>
                    </div>
                </div>
            </div>

            <!-- Payscale Snapshot -->
            <div
                class="lg:col-span-2 bg-white dark:bg-surface-dark rounded-2xl border border-border-light dark:border-border-dark shadow-soft overflow-hidden">
                <div
                    class="p-6 border-b border-border-light dark:border-border-dark bg-gray-50 dark:bg-gray-800/50 flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">payments</span>
                    <h2 class="text-xl font-bold text-text-main dark:text-white">Global Average Payscales</h2>
                </div>
                <div class="p-6">
                    <div class="prose prose-slate dark:prose-invert max-w-none">
                        <p class="text-sm text-text-secondary dark:text-gray-400 mb-4 italic">*Average annual salaries
                            for entry to mid-level positions</p>
                        <div class="markdown-content hidden">
                            <?= htmlspecialchars($payscales ?? 'No salary data available.') ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Top MNCs -->
            <div
                class="bg-white dark:bg-surface-dark rounded-2xl border border-border-light dark:border-border-dark shadow-soft overflow-hidden">
                <div
                    class="p-6 border-b border-border-light dark:border-border-dark bg-gray-50 dark:bg-gray-800/50 flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">apartment</span>
                    <h2 class="text-xl font-bold text-text-main dark:text-white">Target Top 10 MNCs</h2>
                </div>
                <div class="p-6">
                    <div class="prose prose-slate dark:prose-invert max-w-none markdown-content hidden">
                        <?= htmlspecialchars($top_mncs ?? 'No company data available.') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
    @media print {
        button {
            display: none !important;
        }

        body {
            background: white !important;
            color: black !important;
        }

        main {
            max-width: 100% !important;
            padding: 0 !important;
        }

        .shadow-soft {
            box-shadow: none !important;
        }

        .rounded-2xl {
            border-radius: 0 !important;
            border-color: #eee !important;
        }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        marked.setOptions({ breaks: true, gfm: true });

        // Render all elements with .markdown-content class
        document.querySelectorAll('.markdown-content').forEach(el => {
            const raw = el.textContent.trim();
            if (raw) {
                el.innerHTML = marked.parse(raw);
                el.classList.remove('hidden');
            }
        });
    });
</script>

<?= view('web/include/footer') ?>