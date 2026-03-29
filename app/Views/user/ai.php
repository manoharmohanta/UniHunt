<?= view('user/include/header', ['title' => 'AI Study Assistants | UniHunt', 'activePage' => 'ai']) ?>

    <!-- MAIN CONTENT -->
    <main class="flex-1 flex flex-col h-full relative overflow-hidden">
        <!-- TOP HEADER -->
        <header
            class="h-16 border-b border-[#f0f4f4] dark:border-gray-800 bg-surface-light dark:bg-surface-dark px-8 flex items-center justify-between z-10">
            <div class="flex lg:hidden items-center gap-4 text-[#111718] dark:text-white">
                <span class="material-symbols-outlined">menu</span>
            </div>
            <!-- Search -->
            <div class="hidden md:flex flex-1 max-w-md items-center">
                <form action="<?= base_url('search') ?>" method="get" class="relative w-full group">
                    <span
                        class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-text-muted group-focus-within:text-primary transition-colors">search</span>
                    <input
                        name="q"
                        class="w-full bg-[#f0f4f4] dark:bg-gray-800 text-sm border-none rounded-lg pl-10 pr-4 py-2.5 focus:ring-2 focus:ring-primary/50 text-text-main dark:text-white placeholder-text-muted transition-all"
                        placeholder="Search tools, universities, or resources..." type="text" />
                </form>
            </div>
            <!-- Right Actions -->
            <div class="flex items-center gap-6">
                <!-- Notifications (Future Implementation) -->
                <button
                    class="relative p-2 text-text-muted hover:text-primary transition-colors rounded-full hover:bg-gray-50 dark:hover:bg-gray-800">
                    <span class="material-symbols-outlined">notifications</span>
                </button>
            </div>
        </header>
        <!-- CONTENT SCROLL AREA -->
        <div class="flex-1 overflow-y-auto p-4 md:p-8 lg:p-10 bg-background-light dark:bg-background-dark">
            <div class="max-w-[1200px] mx-auto flex flex-col gap-10">
                <!-- Page Heading & Credits Widget -->
                <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
                    <div class="max-w-2xl">
                        <div class="flex items-center gap-2 mb-2">
                            <span
                                class="px-2 py-1 rounded bg-accent/20 text-yellow-700 dark:text-yellow-400 text-xs font-bold uppercase tracking-wider">AI
                                Hub</span>
                        </div>
                        <h2
                            class="text-3xl md:text-4xl font-black text-text-main dark:text-white leading-tight tracking-tight mb-3">
                            AI Study Assistants</h2>
                        <p class="text-text-muted text-lg">Supercharge your application with cutting-edge AI tools
                            designed for study abroad success.</p>
                    </div>
                    <!-- Usage Stats Widget (Desktop only variant of sidebar) -->

                </div>
                <!-- BENTO GRID -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 auto-rows-[minmax(280px,auto)]">
                    <!-- Card 1: SOP Generator (Featured - Spans 2 cols) -->
                    <div
                        class="group relative col-span-1 lg:col-span-2 bg-white dark:bg-surface-dark rounded-2xl p-6 border border-gray-100 dark:border-gray-800 shadow-[0_2px_10px_rgba(0,0,0,0.03)] hover:shadow-[0_8px_30px_rgba(0,0,0,0.06)] transition-all duration-300 overflow-hidden flex flex-col md:flex-row gap-6">
                        <!-- Decorative bg -->
                        <div
                            class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-primary/5 to-transparent rounded-bl-full -mr-16 -mt-16 pointer-events-none">
                        </div>
                        <div class="flex-1 flex flex-col justify-between z-10">
                            <div>
                                <div
                                    class="size-12 rounded-xl bg-[#e0f2f1] dark:bg-primary/20 flex items-center justify-center text-primary mb-6">
                                    <span class="material-symbols-outlined icon-filled text-2xl">edit_document</span>
                                </div>
                                <h3 class="text-2xl font-bold text-text-main dark:text-white mb-2">SOP Generator</h3>
                                <p class="text-text-muted mb-6 leading-relaxed">
                                    Craft a compelling Statement of Purpose tailored to your dream university. Our AI
                                    analyzes thousands of successful essays to help structure your unique story.
                                </p>
                            </div>
                            <div class="flex items-center gap-4">
                                <a href="<?= base_url('ai-tools/sop-generator-form') ?>"
                                    class="bg-primary hover:bg-primary-dark text-white px-5 py-2.5 rounded-lg text-sm font-semibold transition-colors flex items-center gap-2">
                                    <span>Draft New SOP</span>
                                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                                </a>
                                <span
                                    class="text-xs font-mono text-text-muted bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded">v2.4
                                    Stable</span>
                            </div>
                        </div>
                        <!-- Image Area -->
                        <div
                            class="w-full md:w-2/5 rounded-xl bg-gray-50 dark:bg-gray-900 overflow-hidden relative group-hover:scale-[1.02] transition-transform duration-500 ease-out">
                            <div class="absolute inset-0 bg-cover bg-center"
                                style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuAT3bFZfOSrYUMCCXEgI9vApT2-vuHO1J9BpcZ13dWtwysyjFxr9drfb0oFHG7YXULR4vDzmeLOPSJg37so-l8x21z_AC7pRcAaaK0hq-hPX_C2hMIcmxlTtjVYIc7yLJ6E3JCF1hM0sj64vZ3pop7Kv-kv32BshhBipls_irYjAd0cJjUuHIOU1c5MkqgJtQasKoZjT3uDbsuXuV_R8UgXJXGIqOpUzGk8GOrWScqSQaTE-kLQkBAEVtnrXJZzCqfV34URyw40Qfm1");'>
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                            <div
                                class="absolute bottom-4 left-4 text-white text-xs font-medium backdrop-blur-md bg-white/10 px-3 py-1 rounded-full border border-white/20">
                                Used 1.2k times this week
                            </div>
                        </div>
                    </div>
                    <!-- Card 2: Resume Builder -->
                    <div
                        class="group col-span-1 bg-white dark:bg-surface-dark rounded-2xl p-6 border border-gray-100 dark:border-gray-800 shadow-[0_2px_10px_rgba(0,0,0,0.03)] hover:shadow-[0_8px_30px_rgba(0,0,0,0.06)] hover:border-primary/30 transition-all duration-300 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-4">
                                <div
                                    class="size-12 rounded-xl bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-blue-600 dark:text-blue-400">
                                    <span class="material-symbols-outlined icon-filled text-2xl">badge</span>
                                </div>
                                <span
                                    class="bg-accent text-[#111718] text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wide">Popular</span>
                            </div>
                            <h3 class="text-xl font-bold text-text-main dark:text-white mb-2">Resume Builder</h3>
                            <p class="text-sm text-text-muted leading-relaxed mb-4">
                                Convert your experiences into an ATS-friendly academic resume. Highlights research and
                                extracurriculars automatically.
                            </p>
                        </div>
                        <a href="<?= base_url('ai-tools/resume-builder-form') ?>"
                            class="w-full py-2.5 rounded-lg border border-gray-200 dark:border-gray-700 text-text-main dark:text-white font-medium text-sm hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors flex justify-center items-center gap-2 group-hover:border-primary group-hover:text-primary">
                            <span>Build Resume</span>
                        </a>
                    </div>
                    <!-- Card 3: Mock Visa Interview -->
                    <div
                        class="group col-span-1 bg-white dark:bg-surface-dark rounded-2xl p-6 border border-gray-100 dark:border-gray-800 shadow-[0_2px_10px_rgba(0,0,0,0.03)] hover:shadow-[0_8px_30px_rgba(0,0,0,0.06)] hover:border-primary/30 transition-all duration-300 flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start mb-4">
                                <div
                                    class="size-12 rounded-xl bg-purple-50 dark:bg-purple-900/20 flex items-center justify-center text-purple-600 dark:text-purple-400">
                                    <span
                                        class="material-symbols-outlined icon-filled text-2xl">video_camera_front</span>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold text-text-main dark:text-white mb-2">Visa Interview AI</h3>
                            <p class="text-sm text-text-muted leading-relaxed mb-4">
                                Practice answering tough F1 visa questions with our AI interviewer. Get real-time
                                feedback on confidence and clarity.
                            </p>
                        </div>
                        <a href="<?= base_url('ai-tools/mock-interview') ?>"
                            class="w-full py-2.5 rounded-lg border border-gray-200 dark:border-gray-700 text-text-main dark:text-white font-medium text-sm hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors flex justify-center items-center gap-2 group-hover:border-primary group-hover:text-primary">
                            <span>Start Mock Interview</span>
                        </a>
                    </div>
                    <!-- Card 4: Scholarship Matcher (Coming Soon) -->
                    <div
                        class="group col-span-1 bg-[#f8fafc] dark:bg-[#1a1e24] rounded-2xl p-6 border border-dashed border-gray-300 dark:border-gray-700 flex flex-col justify-center items-center text-center opacity-80 hover:opacity-100 transition-opacity">
                        <div
                            class="size-12 rounded-full bg-gray-200 dark:bg-gray-800 flex items-center justify-center text-gray-400 mb-4 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-2xl">school</span>
                        </div>
                        <h3 class="text-lg font-bold text-text-main dark:text-white mb-1">Scholarship Matcher</h3>
                        <p class="text-xs text-text-muted mb-4 max-w-[200px]">Find hidden funding opportunities based on
                            your unique profile.</p>
                        <span
                            class="text-[10px] font-bold uppercase tracking-widest text-text-muted bg-gray-200 dark:bg-gray-800 px-3 py-1 rounded-full">Coming
                            Soon</span>
                    </div>
                <!-- Recent Activity Section (Span 1 or more depending on content) -->
                    <div
                        class="col-span-1 lg:col-span-1 bg-white dark:bg-surface-dark rounded-2xl border border-gray-100 dark:border-gray-800 overflow-hidden flex flex-col">
                        <div
                            class="p-5 border-b border-gray-100 dark:border-gray-800 flex justify-between items-center">
                            <h3 class="text-base font-bold text-text-main dark:text-white">Recent Activity</h3>
                            <a href="<?= base_url('dashboard') ?>" class="text-xs text-primary font-medium hover:underline">View All</a>
                        </div>
                        <div class="flex-1 overflow-y-auto">
                            <?php 
                                $activities = [];
                                // Combine documents
                                if (!empty($documents)) {
                                    foreach ($documents as $doc) {
                                        $activities[] = [
                                            'type' => 'document',
                                            'data' => $doc,
                                            'timestamp' => strtotime($doc['created_at'])
                                        ];
                                    }
                                }
                                // Combine interviews
                                if (!empty($interviews)) {
                                    foreach ($interviews as $interview) {
                                        $activities[] = [
                                            'type' => 'interview',
                                            'data' => $interview,
                                            'timestamp' => strtotime($interview['created_at'])
                                        ];
                                    }
                                }
                                
                                // Sort by timestamp descending
                                usort($activities, function($a, $b) {
                                    return $b['timestamp'] - $a['timestamp'];
                                });
                                
                                // Slice top 5
                                $recentActivities = array_slice($activities, 0, 5);
                            ?>

                            <?php if (empty($recentActivities)): ?>
                                <div class="p-8 text-center text-text-muted text-sm">
                                    No recent activity.
                                </div>
                            <?php else: ?>
                                <?php foreach ($recentActivities as $item): ?>
                                    <?php if ($item['type'] === 'document'): ?>
                                        <!-- Document Item -->
                                        <a href="<?= base_url('ai-tools/document/' . $item['data']['id']) ?>" target="_blank"
                                            class="flex items-center gap-3 p-4 hover:bg-gray-50 dark:hover:bg-gray-800/50 cursor-pointer transition-colors border-b border-gray-50 dark:border-gray-800/50 last:border-0">
                                            <div
                                                class="size-8 rounded bg-teal-50 dark:bg-teal-900/20 flex items-center justify-center text-primary shrink-0">
                                                <span class="material-symbols-outlined text-sm">description</span>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h4 class="text-sm font-semibold text-text-main dark:text-white truncate"><?= esc($item['data']['title']) ?: 'Untitled Document' ?></h4>
                                                <p class="text-xs text-text-muted">Generated <?= date('M d, g:i A', $item['timestamp']) ?></p>
                                            </div>
                                        </a>
                                    <?php else: ?>
                                        <!-- Interview Item -->
                                        <a href="<?= base_url('ai-tools/mock-interview-view/' . $item['data']['id']) ?>"
                                            class="flex items-center gap-3 p-4 hover:bg-gray-50 dark:hover:bg-gray-800/50 cursor-pointer transition-colors border-b border-gray-50 dark:border-gray-800/50 last:border-0">
                                            <div
                                                class="size-8 rounded bg-purple-50 dark:bg-purple-900/20 flex items-center justify-center text-purple-600 shrink-0">
                                                <span class="material-symbols-outlined text-sm">mic</span>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h4 class="text-sm font-semibold text-text-main dark:text-white truncate"><?= $item['data']['country'] ?> Visa Interview</h4>
                                                <p class="text-xs text-text-muted">Score: <?= $item['data']['score'] ?>/100</p>
                                            </div>
                                        </a>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <style>
        .radial-progress {
            position: relative;
            display: inline-grid;
            height: var(--size);
            width: var(--size);
            place-content: center;
            border-radius: 9999px;
            background-color: transparent;
            vertical-align: middle;
            box-sizing: content-box;
            --thickness: 4px;
        }

        .radial-progress:before,
        .radial-progress:after {
            position: absolute;
            border-radius: 9999px;
            content: "";
        }

        .radial-progress:before {
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background: radial-gradient(farthest-side, currentColor 98%, #0000) top/var(--thickness) var(--thickness) no-repeat,
                conic-gradient(currentColor calc(var(--value) * 1%), #0000 0);
            -webkit-mask: radial-gradient(farthest-side, #0000 calc(99% - var(--thickness)), #000 calc(100% - var(--thickness)));
            mask: radial-gradient(farthest-side, #0000 calc(99% - var(--thickness)), #000 calc(100% - var(--thickness)));
        }

        .radial-progress:after {
            inset: calc(50% - var(--thickness) / 2);
            transform: rotate(calc(var(--value) * 3.6deg - 90deg)) translate(calc(var(--size) / 2 - 50%));
            background-color: currentColor;
        }
    </style>

<?= view('user/include/footer') ?>
