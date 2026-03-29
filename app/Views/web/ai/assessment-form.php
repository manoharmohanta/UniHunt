<?= view('web/include/header', ['title' => 'AI SOP Generator - Step 2', 'bodyClass' => 'bg-background-light dark:bg-background-dark font-display min-h-screen flex flex-col transition-colors duration-200']) ?>

<!-- Main Content -->
<main class="flex-1 flex flex-col items-center w-full py-8 px-4 md:px-8">
    <div class="w-full max-w-6xl flex flex-col gap-8">
        <!-- Stepper -->
        <div class="w-full bg-surface-light rounded-xl border border-border-light shadow-sm p-1 overflow-x-auto">
            <div class="flex justify-between items-center min-w-[600px]">
                <!-- Step 1: Completed -->
                <div class="flex flex-1 items-center gap-3 px-4 py-3 opacity-60">
                    <div class="flex items-center justify-center size-8 rounded-full bg-primary/20 text-primary">
                        <span class="material-symbols-outlined text-lg">check</span>
                    </div>
                    <p class="text-text-main text-sm font-bold">Personal Info</p>
                    <div class="h-[2px] flex-1 bg-primary/30 mx-2"></div>
                </div>
                <!-- Step 2: Active -->
                <div class="flex flex-1 items-center gap-3 px-4 py-3 bg-primary/5 rounded-lg border border-primary/10">
                    <div class="flex items-center justify-center size-8 rounded-full bg-primary text-white shadow-glow">
                        <span class="text-sm font-bold">2</span>
                    </div>
                    <p class="text-primary text-sm font-bold">Academic Background</p>
                    <div class="h-[2px] flex-1 bg-border-light mx-2"></div>
                </div>
                <!-- Step 3: Pending -->
                <div class="flex flex-1 items-center gap-3 px-4 py-3 opacity-40">
                    <div
                        class="flex items-center justify-center size-8 rounded-full border-2 border-border-light text-text-muted">
                        <span class="text-sm font-bold">3</span>
                    </div>
                    <p class="text-text-muted text-sm font-bold">Goals</p>
                    <div class="h-[2px] flex-1 bg-border-light mx-2"></div>
                </div>
                <!-- Step 4: Pending -->
                <div class="flex items-center gap-3 px-4 py-3 opacity-40">
                    <div
                        class="flex items-center justify-center size-8 rounded-full border-2 border-border-light text-text-muted">
                        <span class="text-sm font-bold">4</span>
                    </div>
                    <p class="text-text-muted text-sm font-bold">Generate</p>
                </div>
            </div>
        </div>
        <div class="flex flex-col lg:flex-row gap-8 items-start">
            <!-- Left Column: Form -->
            <div class="flex-1 w-full bg-surface-light rounded-xl border border-border-light shadow-soft p-6 md:p-8">
                <div class="mb-8">
                    <h1 class="text-text-main text-2xl md:text-3xl font-bold mb-2">Academic Background</h1>
                    <p class="text-text-muted">Tell us about your educational journey so far to tailor your SOP.</p>
                </div>
                <form action="<?= base_url('ai-tools/form-submit') ?>" method="POST" class="flex flex-col gap-6">
                    <?= csrf_field() ?>
                    <?= honeypot_field() ?>
                    <!-- Row 1 -->
                    <div class="flex flex-col md:flex-row gap-6">
                        <label class="flex flex-col flex-1">
                            <p class="text-text-main text-sm font-semibold mb-2">
                                University/Institution Name</p>
                            <div class="relative group">
                                <span
                                    class="absolute left-4 top-1/2 -translate-y-1/2 text-text-muted material-symbols-outlined">account_balance</span>
                                <input
                                    class="w-full rounded-lg border border-border-light bg-card-light h-12 pl-12 pr-4 text-text-main placeholder-text-muted/50 focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all"
                                    placeholder="e.g. Stanford University" type="text" />
                            </div>
                        </label>
                        <label class="flex flex-col flex-1">
                            <p class="text-text-main dark:text-gray-200 text-sm font-semibold mb-2">Major/Field of
                                Study</p>
                            <div class="relative group">
                                <span
                                    class="absolute left-4 top-1/2 -translate-y-1/2 text-text-muted material-symbols-outlined">school</span>
                                <input
                                    class="w-full rounded-lg border border-border-light bg-card-light h-12 pl-12 pr-4 text-text-main placeholder-text-muted/50 focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all"
                                    placeholder="e.g. Computer Science" type="text" />
                            </div>
                        </label>
                    </div>
                    <!-- Row 2 -->
                    <div class="flex flex-col md:flex-row gap-6">
                        <label class="flex flex-col md:w-1/3">
                            <div class="flex justify-between items-baseline mb-2">
                                <p class="text-text-main text-sm font-semibold">GPA / Percentage</p>
                                <span class="text-xs text-text-muted">ex: 3.8/4.0</span>
                            </div>
                            <div class="relative group">
                                <span
                                    class="absolute left-4 top-1/2 -translate-y-1/2 text-text-muted material-symbols-outlined">percent</span>
                                <input
                                    class="w-full rounded-lg border border-border-light bg-card-light h-12 pl-12 pr-4 text-text-main placeholder-text-muted/50 focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all"
                                    placeholder="3.8" type="text" />
                            </div>
                        </label>
                        <div class="flex-1"></div>
                    </div>
                    <!-- Row 3: Text Area -->
                    <label class="flex flex-col w-full relative">
                        <div class="flex justify-between items-center mb-2">
                            <p class="text-text-main text-sm font-semibold">Key Projects &amp; Research</p>
                            <span class="text-xs font-medium text-primary bg-primary/10 px-2 py-0.5 rounded">AI
                                Recommended</span>
                        </div>
                        <textarea
                            class="w-full rounded-lg border border-border-light bg-card-light min-h-[160px] p-4 text-text-main placeholder-text-muted/50 focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all resize-none leading-relaxed"
                            placeholder="Describe 1-2 key projects. Mention your role, the tools used (e.g., Python, MATLAB), and the outcome."></textarea>
                        <div class="absolute bottom-4 right-4 flex gap-2">
                            <button
                                class="flex items-center gap-1 text-xs font-medium text-text-muted hover:text-primary transition-colors bg-background-light px-2 py-1 rounded border border-border-light"
                                type="button">
                                <span class="material-symbols-outlined text-[14px]">auto_fix_high</span>
                                Rewrite with AI
                            </button>
                        </div>
                    </label>
                    <!-- Actions -->
                    <div class="flex items-center justify-between mt-6 pt-6 border-t border-border-light">
                        <button
                            class="text-text-muted hover:text-text-main font-semibold text-sm px-6 py-3 rounded-lg hover:bg-gray-100 transition-colors"
                            type="button">
                            Back
                        </button>
                        <button
                            class="bg-primary hover:bg-primary-hover text-white font-bold text-sm px-8 py-3 rounded-lg shadow-lg shadow-primary/30 flex items-center gap-2 transition-all transform hover:-translate-y-0.5"
                            type="button">
                            Next Step: Goals
                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </button>
                    </div>
                </form>
            </div>
            <!-- Right Column: Assistant -->
            <div class="w-full lg:w-[380px] flex flex-col gap-6">
                <!-- Pro Tips Card -->
                <div
                    class="bg-gradient-to-br from-primary/10 to-surface-light rounded-xl p-6 border border-primary/20 shadow-sm relative overflow-hidden group">
                    <div
                        class="absolute -right-6 -top-6 w-24 h-24 bg-primary/10 rounded-full blur-2xl group-hover:bg-primary/20 transition-all">
                    </div>
                    <div class="flex items-center gap-2 mb-4 relative z-10">
                        <span class="material-symbols-outlined text-primary">lightbulb</span>
                        <h3 class="text-text-main font-bold text-base">Pro Tips</h3>
                    </div>
                    <ul class="space-y-4 relative z-10">
                        <li class="flex gap-3 items-start">
                            <span class="text-primary mt-1 material-symbols-outlined text-[18px]">check_circle</span>
                            <div>
                                <p class="text-text-main text-sm font-semibold">Show, Don't Just Tell</p>
                                <p class="text-text-muted text-xs mt-1 leading-relaxed">
                                    Instead of listing course names, explain the <span
                                        class="text-primary font-medium">methodologies</span> you applied.</p>
                            </div>
                        </li>
                        <li class="flex gap-3 items-start">
                            <span class="text-primary mt-1 material-symbols-outlined text-[18px]">check_circle</span>
                            <div>
                                <p class="text-text-main text-sm font-semibold">Highlight Outcomes</p>
                                <p class="text-text-muted text-xs mt-1 leading-relaxed">Did your project lead to a
                                    publication or optimize a process? Quantify it.</p>
                            </div>
                        </li>
                    </ul>
                </div>
                <!-- Blurred Live Preview -->
                <div
                    class="bg-surface-light rounded-xl border border-border-light shadow-soft p-1 relative min-h-[400px]">
                    <div class="absolute inset-0 bg-surface-light rounded-xl z-0"></div>
                    <!-- Header of the document -->
                    <div
                        class="relative z-10 p-5 border-b border-border-light flex justify-between items-center bg-card-light rounded-t-lg">
                        <div class="flex gap-2">
                            <div class="size-3 rounded-full bg-red-400"></div>
                            <div class="size-3 rounded-full bg-yellow-400"></div>
                            <div class="size-3 rounded-full bg-green-400"></div>
                        </div>
                        <span class="text-[10px] uppercase font-bold text-text-muted tracking-widest">Live Draft</span>
                    </div>
                    <!-- Document Body (Blurred) -->
                    <div
                        class="relative z-0 p-6 space-y-4 filter blur-[3px] select-none opacity-50 bg-card-light h-[340px] rounded-b-lg overflow-hidden">
                        <div class="h-4 bg-border-light rounded w-3/4 mb-6"></div>
                        <div class="space-y-2">
                            <div class="h-2.5 bg-border-light rounded w-full"></div>
                            <div class="h-2.5 bg-border-light rounded w-[90%]"></div>
                            <div class="h-2.5 bg-border-light rounded w-[95%]"></div>
                            <div class="h-2.5 bg-border-light rounded w-[85%]"></div>
                        </div>
                        <div class="space-y-2 pt-4">
                            <div class="h-2.5 bg-border-light rounded w-full"></div>
                            <div class="h-2.5 bg-border-light rounded w-[92%]"></div>
                            <div class="h-2.5 bg-border-light rounded w-[98%]"></div>
                        </div>
                        <div class="space-y-2 pt-4">
                            <div class="h-2.5 bg-border-light rounded w-[88%]"></div>
                            <div class="h-2.5 bg-border-light rounded w-full"></div>
                        </div>
                    </div>
                    <!-- Overlay Indicator -->
                    <div
                        class="absolute inset-0 z-20 flex flex-col items-center justify-center bg-background-light/30 rounded-xl blur-backdrop">
                        <div
                            class="bg-surface-light p-4 rounded-2xl shadow-xl border border-primary/20 flex flex-col items-center gap-3">
                            <div class="size-10 relative">
                                <div class="absolute inset-0 rounded-full border-4 border-border-light"></div>
                                <div
                                    class="absolute inset-0 rounded-full border-4 border-primary border-t-transparent animate-spin">
                                </div>
                            </div>
                            <div class="text-center">
                                <p class="text-text-main font-bold text-sm">Processing Background</p>
                                <p class="text-text-muted text-xs mt-1">AI is analyzing your inputs...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<!-- footer -->

<?= view('web/include/footer') ?>