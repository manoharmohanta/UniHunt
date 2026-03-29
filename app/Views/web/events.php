<?= view('web/include/header', ['title' => 'Upcoming Education Events Directory', 'bodyClass' => 'bg-background-light dark:bg-background-dark font-display text-text-main dark:text-gray-100 transition-colors duration-200']) ?>

<main class="flex-1 w-full max-w-[1440px] mx-auto px-4 md:px-8 lg:px-16 py-6 md:py-10">
    <!-- Breadcrumbs -->
    <div class="flex flex-wrap gap-2 mb-6">
        <a class="text-text-sub dark:text-gray-400 hover:text-primary text-sm font-medium leading-normal transition-colors"
            href="#">Home</a>
        <span class="text-text-sub dark:text-gray-500 text-sm font-medium leading-normal">/</span>
        <span class="text-text-main dark:text-white text-sm font-medium leading-normal">Events Directory</span>
    </div>
    <!-- Page Heading -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-4 mb-10">
        <div class="flex flex-col gap-2 max-w-2xl">
            <h1 class="text-[#101818] dark:text-white text-3xl md:text-4xl font-black leading-tight tracking-[-0.02em]">
                Upcoming Education Events</h1>
            <p class="text-text-sub dark:text-gray-400 text-base md:text-lg font-normal leading-relaxed">
                Discover webinars, fairs, and info sessions from top global universities. Connect with
                admissions officers and alumni.</p>
        </div>
        <div class="hidden md:flex gap-2">
            <button
                class="flex items-center gap-2 px-4 py-2 rounded-lg bg-surface-light dark:bg-surface-dark border border-gray-200 dark:border-gray-700 text-sm font-medium hover:border-primary transition-colors shadow-sm">
                <span class="material-symbols-outlined text-[20px]">calendar_month</span>
                Calendar View
            </button>
        </div>
    </div>
    <!-- Featured Carousel Section -->
    <?php if (!empty($events)): ?>
        <section class="mb-12" x-data="{ 
            active: 0,
            interval: null,
            init() {
                this.start();
            },
            start() {
                this.interval = setInterval(() => {
                    const container = this.$refs.carousel;
                    const items = container.querySelectorAll('.carousel-item');
                    if(items.length <= 1) return;
                    
                    this.active = (this.active + 1) % items.length;
                    const target = items[this.active];
                    
                    container.scrollTo({
                        left: target.offsetLeft - container.offsetLeft,
                        behavior: 'smooth'
                    });
                }, 5000);
            },
            stop() {
                clearInterval(this.interval);
            }
        }" @mouseenter="stop()" @mouseleave="start()">
            <div class="flex items-center gap-2 mb-4">
                <span class="material-symbols-outlined text-primary text-[20px]">star</span>
                <h3 class="text-lg font-bold text-[#101818] dark:text-white">Featured This Month</h3>
            </div>
            <!-- Scroll Container -->
            <div x-ref="carousel" class="flex overflow-x-auto gap-4 pb-4 no-scrollbar snap-x snap-mandatory scroll-smooth">
                <?php foreach ($events as $event): ?>
                    <?php if ($event['is_featured']): ?>
                        <a href="<?= base_url('events/' . $event['slug']) ?>"
                            class="carousel-item snap-center shrink-0 w-[85vw] md:w-[600px] h-[320px] relative rounded-xl overflow-hidden group cursor-pointer shadow-lg block">
                            <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-105"
                                style='background-image: url("<?= $event['image'] ? base_url($event['image']) : 'https://placehold.co/600x400?text=' . urlencode($event['title']) ?>");'>
                            </div>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                            <?php if ($event['is_premium']): ?>
                                <div
                                    class="absolute top-4 left-4 bg-primary text-white text-xs font-bold px-3 py-1 rounded-full uppercase tracking-wide">
                                    Premium Event</div>
                            <?php endif; ?>
                            <div class="absolute bottom-0 left-0 p-6 w-full md:w-3/4 text-left">
                                <p class="text-primary text-sm font-bold mb-1">
                                    <?= date('M d', strtotime($event['start_date'])) ?> •
                                    <?= esc($event['location_name'] ?: ucfirst($event['location_type'])) ?>
                                </p>
                                <h3 class="text-white text-2xl md:text-3xl font-bold mb-2"><?= esc($event['title']) ?></h3>
                                <p class="text-gray-200 text-sm md:text-base line-clamp-2 mb-4">
                                    <?= esc($event['short_description']) ?>
                                </p>
                                <span
                                    class="bg-white text-[#101818] hover:bg-gray-100 px-5 py-2 rounded-lg text-sm font-bold transition-colors inline-block">
                                    View Details
                                </span>
                            </div>
                        </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>

    <!-- Main Content Area: Sidebar + Grid -->
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Sidebar Filters -->
        <aside class="w-full lg:w-64 flex-shrink-0 space-y-6">
            <!-- Mobile Filter Toggle (Visible only on small screens) -->
            <div
                class="lg:hidden flex justify-between items-center p-4 bg-surface-light dark:bg-surface-dark rounded-lg border border-gray-200 dark:border-gray-700">
                <span class="font-bold text-[#101818] dark:text-white">Filters</span>
                <span class="material-symbols-outlined">filter_list</span>
            </div>
            <!-- Filter Groups (Desktop) -->
            <form action="<?= base_url('events') ?>" method="get" class="hidden lg:block space-y-8">
                <?php if (!empty($search)): ?>
                    <input type="hidden" name="q" value="<?= esc($search) ?>">
                <?php endif; ?>

                <div>
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-[#101818] dark:text-white text-sm uppercase tracking-wider">
                            Event Type</h3>
                    </div>
                    <div class="space-y-3">
                        <?php if (isset($filter_types)):
                            foreach ($filter_types as $t): ?>
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input name="type" value="<?= esc($t) ?>" <?= (service('request')->getVar('type') == $t) ? 'checked' : '' ?>
                                        class="form-checkbox size-4 rounded border-gray-300 text-primary focus:ring-primary bg-transparent"
                                        type="radio" onchange="this.form.submit()" />
                                    <span
                                        class="text-sm text-gray-600 dark:text-gray-400 group-hover:text-primary transition-colors">
                                        <?= esc(ucfirst(str_replace('_', ' ', $t))) ?>
                                    </span>
                                </label>
                            <?php endforeach; endif; ?>
                    </div>
                </div>
                <hr class="border-gray-200 dark:border-gray-700" />
                <div>
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="font-bold text-[#101818] dark:text-white text-sm uppercase tracking-wider">
                            Location Type</h3>
                    </div>
                    <div class="space-y-3">
                        <?php foreach (['online', 'venue', 'mixed'] as $lt): ?>
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input name="location_type" value="<?= $lt ?>"
                                    <?= (service('request')->getVar('location_type') == $lt) ? 'checked' : '' ?>
                                    class="form-checkbox size-4 rounded border-gray-300 text-primary focus:ring-primary bg-transparent"
                                    type="radio" onchange="this.form.submit()" />
                                <span
                                    class="text-sm text-gray-600 dark:text-gray-400 group-hover:text-primary transition-colors">
                                    <?= ucfirst($lt) ?>
                                </span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
            </form>
        </aside>
        <!-- Main Grid Column -->
        <div class="flex-1">
            <!-- Search Bar Area -->
            <div class="mb-8">
                <form action="<?= base_url('events') ?>" method="get" class="flex flex-col h-12 w-full">
                    <div
                        class="flex w-full items-stretch rounded-lg h-full shadow-sm bg-surface-light dark:bg-surface-dark border border-gray-200 dark:border-gray-700 focus-within:ring-2 focus-within:ring-primary focus-within:border-primary transition-shadow">
                        <div class="text-text-sub dark:text-gray-400 flex items-center justify-center pl-4 pr-2">
                            <span class="material-symbols-outlined">search</span>
                        </div>
                        <input name="q" value="<?= esc($search) ?>"
                            class="flex w-full flex-1 rounded-lg text-text-main dark:text-white bg-transparent border-none focus:ring-0 h-full placeholder:text-text-sub dark:placeholder:text-gray-500 px-2 text-base font-normal leading-normal"
                            placeholder="Search for events, universities, or topics..." />
                        <div class="hidden sm:flex items-center pr-2">
                            <button type="submit"
                                class="text-xs font-bold text-primary bg-primary/10 hover:bg-primary/20 px-3 py-1.5 rounded transition-colors">SEARCH</button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Events Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php if (empty($events)): ?>
                    <div class="col-span-full text-center py-10">
                        <p class="text-gray-500 text-lg">No events found matching your criteria.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($events as $event): ?>
                        <!-- Event Card -->
                        <a href="<?= base_url('events/' . $event['slug']) ?>"
                            class="group flex flex-col bg-surface-light dark:bg-surface-dark rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-gray-800 hover:-translate-y-1">
                            <div class="relative h-48 bg-cover bg-center"
                                style='background-image: url("<?= $event['image'] ? base_url('uploads/events/' . $event['image']) : 'https://placehold.co/600x400?text=' . urlencode($event['title']) ?>");'>
                                <div class="absolute inset-0 bg-black/10 group-hover:bg-black/0 transition-colors">
                                </div>
                                <div
                                    class="absolute top-3 left-3 bg-white dark:bg-[#242a30] rounded-lg px-2.5 py-1.5 flex flex-col items-center shadow-md border border-gray-100 dark:border-gray-700">
                                    <span
                                        class="text-[10px] font-bold text-primary uppercase tracking-wide"><?= strtoupper(date('M', strtotime($event['start_date']))) ?></span>
                                    <span
                                        class="text-xl font-black text-[#101818] dark:text-white leading-none"><?= date('d', strtotime($event['start_date'])) ?></span>
                                </div>
                                <div class="absolute bottom-3 left-3">
                                    <span
                                        class="bg-emerald-500/90 text-white text-[10px] font-bold px-2 py-1 rounded backdrop-blur-sm shadow-sm uppercase tracking-wide">
                                        <?= esc(ucfirst($event['location_type'])) ?>
                                    </span>
                                </div>
                            </div>
                            <div class="p-5 flex flex-col gap-3 flex-1">
                                <div class="flex flex-col gap-1">
                                    <p class="text-xs font-bold text-text-sub dark:text-gray-400 uppercase tracking-wide">
                                        <?= esc(ucfirst(str_replace('_', ' ', $event['event_type']))) ?>
                                    </p>
                                    <h3
                                        class="text-lg font-bold text-[#101818] dark:text-white leading-tight group-hover:text-primary transition-colors line-clamp-2">
                                        <?= esc($event['title']) ?>
                                    </h3>
                                </div>
                                <div class="flex items-center gap-2 text-text-sub dark:text-gray-400 text-sm mt-1">
                                    <span class="material-symbols-outlined text-[18px]">schedule</span>
                                    <span><?= date('g:i A', strtotime($event['start_time'])) ?></span>
                                </div>
                                <div
                                    class="flex items-center justify-between mt-auto pt-4 border-t border-gray-100 dark:border-gray-700">
                                    <div class="flex items-center gap-2">
                                        <span
                                            class="text-xs text-gray-500 dark:text-gray-400"><?= esc($event['organizer']) ?></span>
                                    </div>
                                    <span
                                        class="text-primary font-bold text-sm hover:underline decoration-2 underline-offset-4">Register</span>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <!-- Pagination -->
            <div class="mt-12 flex justify-center">
                <nav
                    class="flex items-center gap-1 bg-surface-light dark:bg-surface-dark p-1 rounded-lg border border-gray-200 dark:border-gray-700 shadow-sm">
                    <button
                        class="w-10 h-10 flex items-center justify-center rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-500 transition-colors">
                        <span class="material-symbols-outlined">chevron_left</span>
                    </button>
                    <button
                        class="w-10 h-10 flex items-center justify-center rounded-md bg-primary text-white font-bold text-sm shadow-sm">1</button>
                    <button
                        class="w-10 h-10 flex items-center justify-center rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 text-text-main dark:text-gray-300 font-medium text-sm transition-colors">2</button>
                    <button
                        class="w-10 h-10 flex items-center justify-center rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 text-text-main dark:text-gray-300 font-medium text-sm transition-colors">3</button>
                    <button
                        class="w-10 h-10 flex items-center justify-center rounded-md hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-500 transition-colors">
                        <span class="material-symbols-outlined">chevron_right</span>
                    </button>
                </nav>
            </div>
        </div>
    </div>
</main>
<!-- Footer -->

<?= view('web/include/footer') ?>

<style>
    .no-scrollbar::-webkit-scrollbar {
        display: none;
    }
    .no-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }
</style>