<?= view('web/include/header', ['title' => $event['title'] . ' | UniHunt Events', 'bodyClass' => 'bg-background-light dark:bg-background-dark text-text-main dark:text-gray-100 font-display transition-colors duration-200']) ?>

<!-- Hero Section -->
<header class="relative w-full bg-background-dark overflow-hidden">
    <!-- Background Image with Overlay -->
    <div class="absolute inset-0 z-0 bg-gray-900">
        <img alt="<?= esc($event['title']) ?>" class="w-full h-full object-cover opacity-50"
            src="<?= $event['image'] ? base_url('uploads/events/' . $event['image']) : 'https://placehold.co/1920x600?text=' . urlencode($event['title']) ?>" />
        <!-- Gray Overlay Layer -->
        <div class="absolute inset-0 bg-gray-900/60"></div>
        <!-- Bottom Fade -->
        <div class="absolute inset-0 bg-gradient-to-t from-background-dark to-transparent"></div>
    </div>
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 pb-20 lg:pt-24 lg:pb-32">
        <div class="max-w-3xl">
            <div
                class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/20 border border-primary/30 backdrop-blur-sm mb-6">
                <span class="relative flex h-2 w-2">
                    <span
                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                </span>
                <span
                    class="text-xs font-bold uppercase tracking-wider text-green-300"><?= esc(ucfirst($event['event_type'])) ?></span>
            </div>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-white leading-[1.1] tracking-tight mb-6">
                <?= esc($event['title']) ?>
            </h1>
            <p class="text-lg md:text-xl text-dark-200 mb-10 max-w-2xl font-light">
                <?= esc($event['short_description']) ?>
            </p>

            <?php if ($event['registration_link']): ?>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="<?= $event['registration_link'] ?>" target="_blank"
                        class="h-12 px-8 rounded-lg bg-primary text-white font-bold text-lg hover:bg-primary/90 transition-transform active:scale-95 shadow-lg shadow-primary/25 flex items-center justify-center gap-2">
                        Secure Your Spot
                        <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</header>
<!-- Main Content Layout -->
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 mb-20 relative z-20">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
        <!-- Left Column: Content -->
        <div
            class="lg:col-span-8 space-y-12 bg-surface-light dark:bg-surface-dark p-6 sm:p-8 rounded-2xl shadow-xl shadow-black/5 dark:shadow-none border border-transparent dark:border-white/5">
            <!-- About Section -->
            <section>
                <h2 class="text-2xl font-bold mb-4 flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary">info</span>
                    About this Event
                </h2>
                <div
                    class="text-text-muted dark:text-gray-300 leading-relaxed text-lg prose dark:prose-invert max-w-none">
                    <?= $event['description'] ?>
                </div>
            </section>

            <?php if (!empty($event['learning_points'])): ?>
                <!-- What You Will Learn -->
                <section
                    class="bg-background-light dark:bg-background-dark/50 rounded-xl p-6 sm:p-8 border border-gray-100 dark:border-white/5">
                    <h3 class="text-xl font-bold mb-6">What You Will Learn</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <?php foreach ($event['learning_points'] as $point): ?>
                            <div class="flex items-start gap-3">
                                <div
                                    class="mt-1 min-w-5 size-5 rounded-full bg-primary/20 text-primary flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[14px] font-bold">check</span>
                                </div>
                                <span class="text-text-main dark:text-gray-200"><?= esc($point) ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>

            <?php if (!empty($event['agenda'])): ?>
                <!-- Agenda Timeline -->
                <section>
                    <h2 class="text-2xl font-bold mb-8 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">calendar_clock</span>
                        Agenda
                    </h2>
                    <div class="relative border-l-2 border-primary/20 ml-3 space-y-10 pl-8 py-2">
                        <?php foreach ($event['agenda'] as $item): ?>
                            <div class="relative group">
                                <span
                                    class="absolute -left-[41px] top-1 flex h-6 w-6 items-center justify-center rounded-full bg-background-light dark:bg-background-dark border-2 border-primary group-hover:bg-primary transition-colors">
                                    <div class="h-2 w-2 rounded-full bg-primary group-hover:bg-white"></div>
                                </span>
                                <div class="flex flex-col sm:flex-row sm:items-baseline sm:gap-4 mb-1">
                                    <span
                                        class="text-sm font-bold text-primary font-mono bg-primary/10 px-2 py-0.5 rounded"><?= esc($item['time'] ?? '') ?></span>
                                    <h3 class="font-bold text-lg text-text-main dark:text-white">
                                        <?= esc($item['title'] ?? '') ?>
                                    </h3>
                                </div>
                                <p class="text-text-muted dark:text-gray-400 text-sm"><?= esc($item['description'] ?? '') ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>

            <?php if (!empty($event['speakers'])): ?>
                <!-- Speakers Section -->
                <section>
                    <h2 class="text-2xl font-bold mb-8 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">groups</span>
                        Speakers
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <?php foreach ($event['speakers'] as $speaker): ?>
                            <div
                                class="group flex items-center gap-4 p-4 rounded-xl bg-white dark:bg-white/5 border border-gray-100 dark:border-white/5 hover:border-primary/30 hover:shadow-lg transition-all">
                                <img alt="<?= esc($speaker['name'] ?? 'Speaker') ?>"
                                    class="size-16 rounded-full object-cover ring-2 ring-primary/20"
                                    src="<?= !empty($speaker['image']) ? $speaker['image'] : 'https://placehold.co/100x100?text=' . urlencode('Speaker') ?>" />
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-bold text-lg truncate"><?= esc($speaker['name'] ?? '') ?></h3>
                                    <p class="text-sm text-text-muted dark:text-gray-400 truncate">
                                        <?= esc($speaker['role'] ?? '') ?>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endif; ?>
        </div>
        <!-- Right Column: Sidebar (Sticky) -->
        <aside class="lg:col-span-4 space-y-6">
            <!-- Event Logistics Card -->
            <div class="sticky top-24 space-y-6">
                <div
                    class="bg-surface-light dark:bg-surface-dark p-6 rounded-xl shadow-xl shadow-black/5 dark:shadow-none border border-transparent dark:border-white/5">
                    <h3 class="text-lg font-bold mb-6 pb-2 border-b border-gray-100 dark:border-white/10">Event
                        Details</h3>
                    <div class="space-y-5">
                        <div class="flex items-start gap-4">
                            <div class="size-10 rounded-lg bg-primary/10 flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-primary">calendar_month</span>
                            </div>
                            <div>
                                <p
                                    class="text-xs text-text-muted dark:text-gray-400 uppercase tracking-wide font-semibold">
                                    Date</p>
                                <p class="font-bold text-text-main dark:text-white">
                                    <?= $event['start_date_formatted'] ?>
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="size-10 rounded-lg bg-primary/10 flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-primary">schedule</span>
                            </div>
                            <div>
                                <p
                                    class="text-xs text-text-muted dark:text-gray-400 uppercase tracking-wide font-semibold">
                                    Time</p>
                                <p class="font-bold text-text-main dark:text-white">
                                    <?= $event['start_time_formatted'] ?>
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="size-10 rounded-lg bg-primary/10 flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-primary">location_on</span>
                            </div>
                            <div>
                                <p
                                    class="text-xs text-text-muted dark:text-gray-400 uppercase tracking-wide font-semibold">
                                    Location</p>
                                <p class="font-bold text-text-main dark:text-white">
                                    <?= esc($event['location_name'] ?: ucfirst($event['location_type'])) ?>
                                </p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4">
                            <div class="size-10 rounded-lg bg-primary/10 flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-primary">payments</span>
                            </div>
                            <div>
                                <p
                                    class="text-xs text-text-muted dark:text-gray-400 uppercase tracking-wide font-semibold">
                                    Cost</p>
                                <p class="font-bold text-text-main dark:text-white">
                                    <?= (float) $event['cost'] > 0 ? '$' . number_format((float) $event['cost'], 2) : 'Free' ?>
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php if ($event['registration_link']): ?>
                        <div class="mt-8">
                            <a href="<?= $event['registration_link'] ?>" target="_blank"
                                class="block text-center w-full h-12 pt-3 rounded-lg bg-primary text-white font-bold hover:bg-primary/90 transition-colors shadow-lg shadow-primary/20 mb-3">
                                Register Now
                            </a>
                            <p class="text-center text-xs text-text-muted dark:text-gray-500">Limited spots available.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </aside>
    </div>
</main>
<!-- Footer -->

<?= view('web/include/footer') ?>