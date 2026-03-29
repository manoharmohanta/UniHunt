<?= view('web/include/header', ['title' => 'UniHunt - Resources &amp; Study Abroad Guides', 'bodyClass' => 'bg-background-light dark:bg-background-dark font-display text-text-main dark:text-white overflow-x-hidden min-h-screen flex flex-col']) ?>

<!-- Main Content Wrapper -->
<main class="flex-grow w-full max-w-[1280px] mx-auto px-4 md:px-10 py-8 md:py-12">
    <!-- Hero Section -->
    <?php if (isset($heroPost) && $heroPost): ?>
        <section class="relative w-full rounded-2xl overflow-hidden shadow-hero group mb-12">
            <!-- Background Image -->
            <?php
            $heroImg = !empty($heroPost['featured_image']) ? base_url($heroPost['featured_image']) : 'https://placehold.co/1200x600?text=' . urlencode($heroPost['title']);
            if (!empty($heroPost['uni_gallery_image'])) {
                $heroImg = (stripos($heroPost['uni_gallery_image'], 'http') === 0) ? $heroPost['uni_gallery_image'] : base_url($heroPost['uni_gallery_image']);
            }
            ?>
            <div class="w-full h-[500px] md:h-[600px] bg-cover bg-center transition-transform duration-700 group-hover:scale-105"
                style="background-image: url('<?= $heroImg ?>');">
                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/20 to-transparent"></div>
            </div>
            <!-- Floating Content Card -->
            <div
                class="absolute bottom-6 left-6 right-6 md:bottom-12 md:left-12 md:right-auto md:max-w-xl bg-white dark:bg-surface-dark p-6 md:p-8 rounded-xl shadow-card backdrop-blur-sm bg-opacity-95 dark:bg-opacity-95 border border-white/20">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-secondary/10 text-secondary-dark text-xs font-bold uppercase tracking-wider mb-4 border border-secondary/20">
                    <span class="material-symbols-outlined text-[16px] text-secondary">star</span>
                    <span class="text-secondary-dark dark:text-secondary">Featured Article</span>
                </div>
                <h1 class="text-3xl md:text-4xl font-extrabold text-[#111816] dark:text-white leading-tight mb-4">
                    <?= esc($heroPost['title']) ?>
                </h1>
                <p class="text-text-muted dark:text-gray-300 text-base md:text-lg mb-6 leading-relaxed line-clamp-2">
                    <?= strip_tags($heroPost['content']) ?>
                </p>
                <div class="flex items-center gap-4">
                    <a href="<?= base_url('blog/' . url_title($heroPost['category'] ?? 'general', '-', true) . '/' . $heroPost['slug']) ?>"
                        class="flex items-center justify-center rounded-lg h-12 px-6 bg-primary hover:bg-primary-dark text-white text-base font-bold shadow-lg shadow-primary/30 transition-all transform hover:-translate-y-0.5">
                        Read Guide
                    </a>
                    <span class="text-sm font-medium text-text-muted dark:text-gray-400">
                        <?= max(1, round(str_word_count(strip_tags($heroPost['content'])) / 200)) ?> min read
                    </span>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Categories / Filters + Search -->
    <section class="mb-12">
        <div class="flex flex-col md:flex-row gap-6 justify-between items-center">
            <!-- Categories -->
            <div class="overflow-x-auto overflow-y-hidden pb-4 -mx-4 px-4 md:mx-0 md:px-0 md:pb-0 scrollbar-hide w-full md:w-auto"
                style="scrollbar-width: none; -ms-overflow-style: none;">
                <div class="flex gap-4 min-w-max">
                    <a href="<?= base_url('blog') ?>"
                        class="flex h-12 items-center justify-center gap-x-2 rounded-full <?= ($category == 'All' && empty($search)) ? 'bg-primary text-white' : 'bg-white dark:bg-surface-dark border border-gray-200 dark:border-gray-700 text-slate-700 dark:text-slate-200' ?> pl-4 pr-6 shadow-md transition-transform hover:scale-105 active:scale-95">
                        <span class="material-symbols-outlined text-[20px]">grid_view</span>
                        <span class="text-sm font-bold">All Resources</span>
                    </a>
                    <?php
                    $iconMap = [
                        'Visa' => 'flight_takeoff',
                        'Scholarships' => 'school',
                        'Lifestyle' => 'local_cafe',
                        'Admissions' => 'history_edu',
                        'University' => 'account_balance',
                        'General' => 'article'
                    ];
                    foreach ($categories as $catName):
                        $icon = $iconMap[$catName] ?? 'article';
                        $catSlug = url_title($catName, '-', true);
                        $isActive = ($category === $catName);
                        ?>
                        <a href="<?= base_url('blog/category/' . $catSlug) ?>"
                            class="group flex h-12 items-center justify-center gap-x-2 rounded-full <?= $isActive ? 'bg-primary text-white' : 'bg-white dark:bg-surface-dark border border-gray-200 dark:border-gray-700 text-slate-700 dark:text-slate-200' ?> pl-4 pr-6 hover:border-primary/50 hover:shadow-md transition-all">
                            <span
                                class="material-symbols-outlined text-[20px] <?= $isActive ? 'text-white' : 'text-gray-500 group-hover:text-primary' ?> transition-colors"><?= $icon ?></span>
                            <span class="text-sm font-medium"><?= esc($catName) ?></span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Search Bar -->
            <form action="" method="GET" class="w-full md:w-72 relative" id="searchForm" onsubmit="return false;">
                <span
                    class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">search</span>
                <input type="text" name="q" id="searchInput" value="<?= esc($search ?? '') ?>"
                    placeholder="Search articles..."
                    class="w-full pl-10 pr-4 py-3 rounded-full border border-gray-200 dark:border-gray-700 bg-white dark:bg-surface-dark focus:ring-2 focus:ring-primary focus:border-transparent outline-none transition-all shadow-sm">
            </form>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('searchInput');
            let timeout = null;

            searchInput.addEventListener('input', (e) => {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    const query = e.target.value;
                    const url = new URL(window.location.href);
                    if (query.trim() !== '') {
                        url.searchParams.set('q', query);
                    } else {
                        url.searchParams.delete('q');
                    }
                    // Reset pagination when searching
                    url.searchParams.delete('page');
                    window.location.href = url.toString();
                }, 600); // 600ms debounce
            });
        });
    </script>
    </div>
    </section>

    <!-- Main Layout: Grid + Sidebar -->
    <div class="flex flex-col lg:flex-row gap-8 lg:gap-12">
        <!-- Left Column: Article Grid -->
        <div class="w-full lg:w-2/3 flex flex-col gap-8">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-extrabold text-[#111816] dark:text-white"><?= $category ?> Articles</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php if (empty($blogs)): ?>
                    <div
                        class="col-span-full py-12 text-center bg-white dark:bg-surface-dark rounded-xl border border-dashed border-gray-200 dark:border-gray-700">
                        <span class="material-symbols-outlined text-4xl text-gray-300 mb-2">search_off</span>
                        <?php if (!empty($search)): ?>
                            <h3 class="text-lg font-bold text-gray-700 dark:text-white">No results found for
                                "<?= esc($search) ?>"</h3>
                            <p class="text-gray-500">Try checking for typos or using different keywords.</p>
                        <?php else: ?>
                            <p class="text-gray-500">No articles found here yet.</p>
                        <?php endif; ?>
                    </div>
                <?php else: ?>
                    <?php foreach ($blogs as $blog): ?>
                        <article
                            onclick="window.location.href='<?= base_url('blog/' . url_title($blog['category'] ?? 'general', '-', true) . '/' . $blog['slug']) ?>'"
                            class="flex flex-col bg-white dark:bg-surface-dark rounded-xl overflow-hidden shadow-card hover:shadow-card-hover transition-all duration-300 group cursor-pointer h-full border border-gray-100 dark:border-gray-800">
                            <div class="relative h-48 w-full overflow-hidden">
                                <div
                                    class="absolute top-3 left-3 z-10 bg-white/90 dark:bg-black/80 backdrop-blur px-2.5 py-1 rounded-md text-xs font-bold text-[#111816] dark:text-white uppercase tracking-wider shadow-sm">
                                    <?= esc(ucfirst($blog['category'] ?? 'General')) ?>
                                </div>
                                <?php
                                $blogImg = !empty($blog['featured_image']) ? base_url($blog['featured_image']) : 'https://placehold.co/600x400?text=' . urlencode($blog['title']);
                                if (!empty($blog['uni_gallery_image'])) {
                                    $blogImg = (stripos($blog['uni_gallery_image'], 'http') === 0) ? $blog['uni_gallery_image'] : base_url($blog['uni_gallery_image']);
                                }
                                ?>
                                <div class="w-full h-full bg-cover bg-center transition-transform duration-500 group-hover:scale-110"
                                    style="background-image: url('<?= $blogImg ?>');">
                                </div>
                            </div>
                            <div class="p-5 flex flex-col flex-1">
                                <h3
                                    class="text-lg font-bold text-[#111816] dark:text-white mb-2 leading-snug group-hover:text-primary transition-colors">
                                    <?= esc($blog['title']) ?>
                                </h3>
                                <p class="text-text-muted dark:text-gray-400 text-sm mb-4 line-clamp-2 leading-relaxed">
                                    <?= strip_tags($blog['content']) ?>
                                </p>
                                <div
                                    class="mt-auto pt-4 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <img src="https://ui-avatars.com/api/?name=<?= urlencode($blog['author_name'] ?? 'UniHunt') ?>&background=random"
                                            class="size-6 rounded-full" alt="Author">
                                        <span class="text-xs font-medium text-gray-600 dark:text-gray-300">
                                            <?= esc($blog['author_name'] ?? 'UniHunt Team') ?>
                                        </span>
                                    </div>
                                    <span class="text-xs font-medium text-gray-400 flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[14px]">calendar_today</span>
                                        <?= date('M d, Y', strtotime($blog['created_at'])) ?>
                                    </span>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <!-- Pagination -->
            <?php if ($pager): ?>
                <div class="mt-8">
                    <?= $pager->links('default', 'tailwind_full') ?>
                </div>
            <?php endif; ?>
        </div>
        <!-- Right Column: Sidebar -->
        <aside class="w-full lg:w-1/3 flex flex-col gap-8">
            <!-- Newsletter Widget -->
            <div class="bg-primary dark:bg-surface-dark rounded-xl p-8 text-white shadow-lg relative overflow-hidden">
                <div class="absolute -top-10 -right-10 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                <div class="absolute bottom-0 right-0 w-24 h-24 bg-secondary/20 rounded-full blur-xl"></div>
                <span class="material-symbols-outlined text-[32px] mb-4">mail_outline</span>
                <h3 class="text-xl font-extrabold mb-2 relative z-10">Study abroad tips in your inbox</h3>
                <p class="text-white/80 text-sm mb-6 leading-relaxed relative z-10">Join 50,000+ students getting
                    weekly guides and scholarship alerts.</p>
                <form hx-post="<?= base_url('subscribe') ?>" hx-swap="outerHTML"
                    class="flex flex-col gap-3 relative z-10">
                    <?= csrf_field() ?>
                    <input
                        class="w-full rounded-lg bg-white/10 border border-white/20 text-white placeholder:text-white/60 focus:ring-2 focus:ring-secondary focus:border-transparent"
                        placeholder="Enter your email" type="email" name="email" required />
                    <button
                        class="w-full rounded-lg bg-white text-primary font-bold py-2.5 hover:bg-gray-100 transition-colors flex items-center justify-center gap-2"
                        type="submit">
                        <span>Subscribe Now</span>
                        <span
                            class="htmx-indicator animate-spin material-symbols-outlined text-sm">progress_activity</span>
                    </button>
                </form>
                <div id="subscribe-message" class="mt-4 text-sm font-medium"></div>
                <p class="text-xs text-white/50 mt-4 text-center">No spam, unsubscribe anytime.</p>
            </div>
            <!-- Trending List -->
            <div
                class="bg-white dark:bg-surface-dark rounded-xl p-6 shadow-card border border-gray-100 dark:border-gray-800">
                <div class="flex items-center gap-2 mb-6 pb-4 border-b border-gray-100 dark:border-gray-700">
                    <span class="material-symbols-outlined text-primary">trending_up</span>
                    <h3 class="text-lg font-bold text-[#111816] dark:text-white">Trending Now</h3>
                </div>
                <div class="flex flex-col gap-6">
                    <?php if (empty($trendingPosts)): ?>
                        <p class="text-sm text-gray-400">Viewing data coming soon...</p>
                    <?php else: ?>
                        <?php foreach ($trendingPosts as $index => $t): ?>
                            <a class="group flex gap-4 items-start"
                                href="<?= base_url('blog/' . url_title($t['category'] ?? 'general', '-', true) . '/' . $t['slug']) ?>">
                                <span
                                    class="text-4xl font-black text-gray-100 dark:text-gray-800 leading-none group-hover:text-secondary/50 transition-colors"><?= $index + 1 ?></span>
                                <div>
                                    <h4
                                        class="text-sm font-bold text-[#111816] dark:text-white leading-tight group-hover:text-primary transition-colors mb-1 line-clamp-2">
                                        <?= esc($t['title']) ?>
                                    </h4>
                                    <span class="text-xs text-text-muted"><?= ucfirst($t['category'] ?? 'General') ?> &bull;
                                        <?= number_format($t['views']) ?> views</span>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <!-- Ad / Promo Placeholder -->
            <div
                class="bg-gray-100 dark:bg-surface-dark rounded-xl p-6 border border-dashed border-gray-300 dark:border-gray-600 flex flex-col items-center justify-center text-center min-h-[200px]">
                <span class="material-symbols-outlined text-gray-400 text-4xl mb-2">rocket_launch</span>
                <p class="text-sm font-bold text-gray-500 mb-2">University Partner Spot</p>
                <p class="text-xs text-gray-400">Reach 1M+ students globally.</p>
            </div>
        </aside>
    </div>
</main>
<!-- Call to Action Band -->
<section class="bg-[#111816] dark:bg-black py-16 md:py-20 relative overflow-hidden mt-auto">
    <!-- Abstract Decoration -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden opacity-20 pointer-events-none">
        <div class="absolute -top-[50%] -left-[10%] w-[500px] h-[500px] rounded-full bg-primary blur-[120px]"></div>
        <div class="absolute top-[20%] -right-[10%] w-[400px] h-[400px] rounded-full bg-secondary blur-[100px]">
        </div>
    </div>
    <div class="max-w-[1280px] mx-auto px-4 md:px-10 flex flex-col items-center text-center relative z-10">
        <h2 class="text-3xl md:text-5xl font-extrabold text-white mb-6 tracking-tight">Ready to find your dream
            university?</h2>
        <p class="text-gray-400 text-lg md:text-xl max-w-2xl mb-10">Explore over 500+ institutions and apply with
            confidence using our comprehensive guides.</p>
        <div class="flex flex-col sm:flex-row gap-4">
            <a href="<?= session()->get('isLoggedIn') ? base_url('dashboard') : base_url('login') ?>"
                class="bg-primary hover:bg-primary-dark text-white text-lg font-bold py-4 px-10 rounded-xl shadow-lg hover:shadow-primary/20 transition-all transform hover:-translate-y-1 flex items-center justify-center">
                Start Your Journey
            </a>
            <a href="<?= base_url('universities') ?>"
                class="bg-transparent border-2 border-white/20 hover:border-white text-white text-lg font-bold py-4 px-10 rounded-xl transition-all flex items-center justify-center">
                Browse All Universities
            </a>
        </div>
    </div>
</section>
<!-- Simple Footer -->
<!-- Footer -->

<?= view('web/include/footer') ?>