<?= view('web/include/header', ['title' => $university['name'] . ' - UniHunt', 'bodyClass' => 'bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 antialiased flex flex-col min-h-screen']) ?>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "EducationalOrganization",
  "name": "<?= esc($university['name']) ?>",
  "url": "<?= current_url() ?>",
  "logo": "<?= !empty($logo) ? base_url('uploads/universities/' . $logo) : base_url('favicon_io/favicon.ico') ?>",
  "image": "<?= !empty($banner) ? base_url('uploads/universities/' . $banner) : '' ?>",
  "description": "<?= esc(strip_tags($university['about'] ?? $university['name'] . ' is a top university in ' . $university['country_name'])) ?>",
  "address": {
    "@type": "PostalAddress",
    "addressLocality": "<?= esc($university['state_name'] ?? '') ?>",
    "addressCountry": "<?= esc($university['country_name']) ?>"
  },
  "sameAs": [
    "<?= esc($university['website'] ?? '') ?>"
  ]
}
</script>

<script>
    function universityDetails() {
        return {
            isReviewModalOpen: false,
            isGalleryModalOpen: false,
            galleryIndex: 0,
            applying: false,
            isLoggedIn: <?= json_encode(session()->get('isLoggedIn') ? true : false) ?>,
            isBookmarked: <?= json_encode($isBookmarked ?? false) ?>,
            galleryImages: [
                <?php foreach ($gallery as $img): ?>
                                            '<?= base_url($img['file_name']) ?>',
                <?php endforeach; ?>
            ],
            init() {
                this.$watch('isReviewModalOpen', value => {
                    if (value) { document.body.classList.add('overflow-hidden'); }
                    else { document.body.classList.remove('overflow-hidden'); }
                });
                this.$watch('isGalleryModalOpen', value => {
                    if (value) { document.body.classList.add('overflow-hidden'); }
                    else { document.body.classList.remove('overflow-hidden'); }
                });
            },
            async handleApplyNow(url, id) {
                if (!this.isLoggedIn) {
                    const currentUrl = window.location.href;
                    window.location.href = `<?= base_url('login') ?>?redirect=${encodeURIComponent(currentUrl)}&bookmark_entity=university&bookmark_id=${id}`;
                    return;
                }

                if (this.isBookmarked) {
                    window.open(url, '_blank');
                    return;
                }

                this.applying = true;
                try {
                    const formData = new FormData();
                    formData.append('entity_type', 'university');
                    formData.append('entity_id', id);
                    formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

                    const response = await fetch('<?= base_url('bookmarks/toggle') ?>', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    const result = await response.json();

                    if (result.status === 'added' || (result.message && result.message.includes('added'))) {
                        this.isBookmarked = true;
                    }
                    window.open(url, '_blank');
                } catch (e) {
                    console.error('Bookmark failed', e);
                    window.open(url, '_blank');
                } finally {
                    this.applying = false;
                }
            }
        }
    }
</script>
<div x-data="universityDetails()" @handle-apply-now.window="handleApplyNow($event.detail.url, $event.detail.id)">

    <!-- Gallery Modal (Moved to top for Z-Index) -->
    <div x-show="isGalleryModalOpen" class="fixed inset-0 flex items-center justify-center bg-black/95 backdrop-blur-md"
        style="z-index: 9999999 !important;" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" x-cloak @keydown.escape.window="isGalleryModalOpen = false"
        @keydown.left.window="galleryIndex = (galleryIndex > 0) ? galleryIndex - 1 : galleryImages.length - 1"
        @keydown.right.window="galleryIndex = (galleryIndex < galleryImages.length - 1) ? galleryIndex + 1 : 0">

        <!-- Top Bar (Close & Counter) -->
        <div class="absolute top-0 inset-x-0 h-20 md:h-24 flex items-center justify-between px-6 md:px-10 z-[10000005]">
            <div
                class="flex items-center gap-4 bg-black/40 backdrop-blur-md border border-white/10 px-4 py-2 rounded-full shadow-xl">
                <div class="text-white font-bold text-sm tracking-widest">
                    <span x-text="galleryIndex + 1"></span> / <span x-text="galleryImages.length"></span>
                </div>
                <div class="hidden sm:block w-px h-4 bg-white/20"></div>
                <div class="hidden sm:block text-white/70 text-[10px] font-bold uppercase tracking-wider">
                    <?= esc($university['name']) ?>
                </div>
            </div>

            <button @click.stop="isGalleryModalOpen = false"
                class="size-12 md:size-14 bg-black/40 hover:bg-black/60 border border-white/10 backdrop-blur-md text-white transition-all active:scale-95 flex items-center justify-center rounded-full shadow-xl">
                <i class="fa-solid fa-xmark text-2xl"></i>
            </button>
        </div>

        <!-- Navigation Controls -->
        <template x-if="galleryImages.length > 1">
            <button @click.stop="galleryIndex = (galleryIndex > 0) ? galleryIndex - 1 : galleryImages.length - 1"
                class="absolute left-4 md:left-10 top-1/2 -translate-y-1/2 z-[10000005] size-14 md:size-18 rounded-full bg-black/20 hover:bg-black/40 border border-white/5 hover:border-white/20 backdrop-blur-md text-white flex items-center justify-center transition-all active:scale-90 cursor-pointer">
                <i class="fa-solid fa-chevron-left text-2xl"></i>
            </button>
        </template>
        <template x-if="galleryImages.length > 1">
            <button @click.stop="galleryIndex = (galleryIndex < galleryImages.length - 1) ? galleryIndex + 1 : 0"
                class="absolute right-4 md:right-10 top-1/2 -translate-y-1/2 z-[10000005] size-14 md:size-18 rounded-full bg-black/20 hover:bg-black/40 border border-white/5 hover:border-white/20 backdrop-blur-md text-white flex items-center justify-center transition-all active:scale-90 cursor-pointer">
                <i class="fa-solid fa-chevron-right text-2xl"></i>
            </button>
        </template>

        <!-- Main Image -->
        <div class="relative w-full h-full flex items-center justify-center p-4 md:p-12 overflow-hidden"
            @click="isGalleryModalOpen = false">
            <template x-if="galleryImages.length > 0">
                <img :src="galleryImages[galleryIndex]" @click.stop
                    class="max-w-full max-h-[75vh] md:max-h-[85vh] object-contain rounded-lg shadow-[0_0_50px_rgba(0,0,0,0.5)] animate-in zoom-in-95 duration-300">
            </template>
            <template x-if="galleryImages.length === 0">
                <div class="text-center text-white">
                    <i class="fa-solid fa-image text-4xl mb-4 opacity-20"></i>
                    <p class="text-lg font-medium opacity-50">No gallery images.</p>
                </div>
            </template>
        </div>
    </div>

    <main class="flex-grow w-full max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Hero Section -->
        <?php if (session()->getFlashdata('success')): ?>
            <div
                class="mb-6 p-4 bg-green-500/10 border border-green-500/20 text-green-600 dark:text-green-400 rounded-xl flex items-center gap-3 animate-in fade-in slide-in-from-top-4">
                <span class="material-symbols-outlined text-[24px]">check_circle</span>
                <span class="font-bold text-sm">
                    <?= session()->getFlashdata('success') ?>
                </span>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div
                class="mb-6 p-4 bg-red-500/10 border border-red-500/20 text-red-600 dark:text-red-400 rounded-xl flex items-center gap-3 animate-in fade-in slide-in-from-top-4">
                <span class="material-symbols-outlined text-[24px]">error</span>
                <span class="font-bold text-sm">
                    <?= session()->getFlashdata('error') ?>
                </span>
            </div>
        <?php endif; ?>

        <section
            class="relative w-full rounded-lg overflow-hidden bg-surface-light dark:bg-surface-dark shadow-soft mb-6 group">
            <!-- Cover Image -->
            <div class="h-[280px] md:h-[340px] w-full bg-slate-200 relative">
                <?php
                $placeholderBase = urlencode($university['name'] . ' - ' . ($university['state_name'] ?? '') . ' ' . $university['country_name']);
                $galleryBanner = null;
                if (!empty($images)) {
                    foreach ($images as $img) {
                        if ($img['image_type'] === 'gallery' && $img['is_main'] == 0) {
                            $galleryBanner = $img['file_name'];
                            break;
                        }
                    }
                }
                $actualBanner = $galleryBanner ?: ($banner ?: "https://placehold.co/1200x600?text={$placeholderBase}+Banner");
                $bannerUrl = (stripos($actualBanner, 'http') === 0) ? $actualBanner : base_url($actualBanner);
                ?>
                <div class="absolute inset-0 bg-cover bg-center" data-alt="<?= esc($university['name']) ?> Banner"
                    style="background-image: url('<?= $bannerUrl ?>');">
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent"></div>
            </div>
            <!-- Profile Content Overlay/Layout -->
            <div class="relative px-6 pb-6 -mt-16 md:-mt-20 flex flex-col md:flex-row gap-6 items-start md:items-end">
                <!-- Logo -->
                <div
                    class="w-32 h-32 md:w-40 md:h-40 bg-white p-2 rounded shadow-lg flex-shrink-0 z-10 flex items-center justify-center">
                    <?php
                    $mainImage = null;
                    if (!empty($images)) {
                        foreach ($images as $img) {
                            if ($img['is_main'] == 1) {
                                $mainImage = $img['file_name'];
                                break;
                            }
                        }
                    }
                    $finalLogo = $mainImage ?: $logo;
                    ?>
                    <div class="w-full h-full bg-contain bg-center bg-no-repeat"
                        data-alt="<?= esc($university['name']) ?> Logo"
                        style="background-image: url('<?= $finalLogo ? base_url($finalLogo) : base_url('favicon_io/android-chrome-512x512.webp') ?>');">
                    </div>
                </div>
                <!-- Text Info -->
                <div class="flex-1 text-primary md:mb-2 z-10 w-full">
                    <div class="flex flex-col md:flex-row md:justify-between md:items-end gap-4">
                        <div>
                            <h1 class="text-3xl md:text-5xl font-bold font-display tracking-tight text-primary mb-2"
                                style="text-shadow: 0 2px 10px rgba(255,255,255,0.6);">
                                <?= esc($university['name']) ?>
                            </h1>
                            <div
                                class="flex flex-wrap items-center gap-4 text-slate-400 text-sm md:text-base font-medium">
                                <span class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[18px]">location_on</span>
                                    <?= esc($university['state_name'] ?? '') ?><?= (isset($university['state_name']) && isset($university['country_name'])) ? ', ' : '' ?><?= esc($university['country_name']) ?>
                                </span>
                                <span class="hidden md:inline w-1 h-1 bg-slate-400 rounded-full"></span>
                                <span class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[18px]">school</span>
                                    <?= ucfirst(esc($university['type'])) ?> University
                                </span>
                            </div>
                        </div>
                        <!-- Badges -->
                        <div class="flex gap-2 flex-wrap">
                            <?php if ($university['ranking']): ?>
                                <div
                                    class="flex h-8 items-center gap-2 rounded bg-white/10 backdrop-blur-md border border-white/20 px-3 text-white">
                                    <span class="material-symbols-outlined text-accent text-[18px]">trophy</span>
                                    <span class="text-xs font-bold uppercase tracking-wider">#<?= $university['ranking'] ?>
                                        World Rank</span>
                                </div>
                            <?php endif; ?>
                            <div
                                class="flex h-8 items-center gap-2 rounded bg-white/10 backdrop-blur-md border border-white/20 px-3 text-white">
                                <span class="material-symbols-outlined text-accent text-[18px]">public</span>
                                <span class="text-xs font-bold uppercase tracking-wider">Verified Listing</span>
                            </div>
                            <button onclick="toggleCompare(event, 'university', <?= $university['id'] ?>)"
                                class="flex h-8 items-center gap-2 rounded bg-primary border border-white/20 px-3 text-white transition-all">
                                <span class="material-symbols-outlined text-accent text-[18px]">compare_arrows</span>
                                <span class="text-xs font-bold uppercase tracking-wider">Add to Compare</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Navigation Tabs -->
        <nav
            class="sticky top-[65px] z-40 bg-background-light dark:bg-background-dark pt-2 pb-4 mb-6 border-b border-slate-200 dark:border-slate-800">
            <div class="flex gap-8 overflow-x-auto hide-scrollbar">
                <a class="nav-tab active pb-3 border-b-[3px] border-primary text-primary dark:text-white font-bold text-sm tracking-wide uppercase whitespace-nowrap"
                    href="#overview">Overview</a>
                <a class="nav-tab pb-3 border-b-[3px] border-transparent text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-200 font-bold text-sm tracking-wide uppercase whitespace-nowrap transition-colors"
                    href="#courses">Courses</a>
                <a class="nav-tab pb-3 border-b-[3px] border-transparent text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-200 font-bold text-sm tracking-wide uppercase whitespace-nowrap transition-colors"
                    href="#admissions">Admissions</a>
                <a class="nav-tab pb-3 border-b-[3px] border-transparent text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-200 font-bold text-sm tracking-wide uppercase whitespace-nowrap transition-colors"
                    href="#costs">Costs</a>
                <a class="nav-tab pb-3 border-b-[3px] border-transparent text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-200 font-bold text-sm tracking-wide uppercase whitespace-nowrap transition-colors"
                    href="#scholarships">Scholarships</a>
                <a class="nav-tab pb-3 border-b-[3px] border-transparent text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-200 font-bold text-sm tracking-wide uppercase whitespace-nowrap transition-colors"
                    href="#reviews">Reviews</a>
                <?php if (!empty($latestUpdates)): ?>
                    <a class="nav-tab pb-3 border-b-[3px] border-transparent text-slate-500 hover:text-slate-800 dark:text-slate-400 dark:hover:text-slate-200 font-bold text-sm tracking-wide uppercase whitespace-nowrap transition-colors"
                        href="#updates">Updates</a>
                <?php endif; ?>
            </div>
        </nav>
        <!-- Main Layout Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <!-- Left Column (Content) -->
            <div class="lg:col-span-8 flex flex-col gap-8">
                <!-- About Section -->
                <section id="overview"
                    class="scroll-mt-32 bg-surface-light dark:bg-surface-dark p-6 md:p-8 rounded shadow-soft border border-slate-100 dark:border-slate-800">
                    <h2 class="text-2xl font-bold text-primary dark:text-white mb-4 font-display">About
                        <?= esc($university['name']) ?>
                    </h2>
                    <p class="text-slate-600 dark:text-slate-300 leading-relaxed mb-6">
                        <?= isset($metadata['about']) ? esc($metadata['about']) : 'Welcome to ' . esc($university['name']) . '. This institution is dedicated to excellence in teaching, learning, and research, and to developing leaders in many disciplines who make a difference globally.' ?>
                    </p>
                    <div
                        class="grid grid-cols-2 md:grid-cols-4 gap-4 pt-4 border-t border-slate-100 dark:border-slate-800">
                        <div class="flex flex-col">
                            <span
                                class="text-3xl font-bold text-primary dark:text-white font-display"><?= $metadata['students'] ?? '10k+' ?></span>
                            <span class="text-sm text-slate-500 font-medium">Students</span>
                        </div>
                        <div class="flex flex-col">
                            <span
                                class="text-3xl font-bold text-primary dark:text-white font-display"><?= $metadata['ratio'] ?? '15:1' ?></span>
                            <span class="text-sm text-slate-500 font-medium">Student-Faculty Ratio</span>
                        </div>
                        <div class="flex flex-col">
                            <span
                                class="text-3xl font-bold text-primary dark:text-white font-display"><?= $university['stem_available'] ? 'Yes' : 'No' ?></span>
                            <span class="text-sm text-slate-500 font-medium">STEM Available</span>
                        </div>
                        <div class="flex flex-col">
                            <span
                                class="text-3xl font-bold text-primary dark:text-white font-display"><?= ucfirst(esc($university['classification'] ?? 'Mixed')) ?></span>
                            <span class="text-sm text-slate-500 font-medium">Classification</span>
                        </div>
                    </div>
                </section>
                <!-- Courses Filter & List -->
                <section id="courses" class="flex flex-col gap-4 scroll-mt-32">
                    <div class="flex items-center justify-between">
                        <h2 class="text-2xl font-bold text-primary dark:text-white font-display">Popular Programs</h2>
                        <a class="text-primary text-sm font-bold hover:underline"
                            href="<?= base_url('universities/' . $university['country_slug'] . '/' . $university['slug'] . '/courses') ?>">View
                            All Courses</a>
                    </div>

                    <!-- Course Items -->
                    <div class="flex flex-col gap-3">
                        <?php if (!empty($courses)): ?>
                            <?php foreach ($courses as $course): ?>
                                <a href="<?= base_url('courses/' . $university['country_slug'] . '/' . $university['slug'] . '/' . url_title($course['name'], '-', true)) ?>"
                                    class="bg-surface-light dark:bg-surface-dark p-5 rounded shadow-soft border border-slate-100 dark:border-slate-800 hover:border-primary/30 transition-colors group block">
                                    <div class="flex flex-col md:flex-row justify-between gap-4">
                                        <div>
                                            <div class="flex items-center gap-2 mb-1">
                                                <span
                                                    class="bg-primary/10 text-primary dark:text-primary-light text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wide">
                                                    <?= esc($course['level']) ?>
                                                </span>
                                                <?php if ($course['stem']): ?>
                                                    <span
                                                        class="bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wide">STEM</span>
                                                <?php endif; ?>
                                            </div>
                                            <h3
                                                class="text-lg font-bold text-slate-900 dark:text-white group-hover:text-primary transition-colors">
                                                <?= esc($course['name']) ?>
                                            </h3>
                                            <p class="text-sm text-slate-500 mt-1 line-clamp-1">
                                                In <?= esc($course['field']) ?> at <?= esc($university['name']) ?>
                                            </p>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <button onclick="toggleCompare(event, 'course', <?= $course['id'] ?>)"
                                                class="p-2 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-500 hover:text-primary transition-colors hover:bg-primary/10"
                                                title="Add to Compare">
                                                <span class="material-symbols-outlined text-[20px]">compare_arrows</span>
                                            </button>
                                        </div>
                                        <div
                                            class="flex flex-row md:flex-col items-center md:items-end gap-x-6 gap-y-1 text-right min-w-max border-t md:border-t-0 md:border-l border-slate-100 dark:border-slate-800 pt-3 md:pt-0 md:pl-6 mt-2 md:mt-0">
                                            <div class="flex flex-col items-start md:items-end">
                                                <span
                                                    class="text-xs text-slate-400 font-medium uppercase tracking-wider">Duration</span>
                                                <span class="text-sm font-bold text-slate-800 dark:text-slate-200">
                                                    <?= esc($course['duration_months']) ?> Months
                                                </span>
                                            </div>
                                            <div class="flex flex-col items-start md:items-end">
                                                <span
                                                    class="text-xs text-slate-400 font-medium uppercase tracking-wider">Estimated
                                                    Tuition</span>
                                                <span class="text-sm font-bold text-slate-800 dark:text-slate-200">
                                                    <?= $course['tuition_fee'] ? format_currency_price($course['tuition_fee'], $university['country_currency']) : 'N/A' ?>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div
                                class="p-8 text-center bg-slate-50 dark:bg-slate-800/50 rounded-xl border border-dashed border-slate-200 dark:border-slate-700">
                                <p class="text-slate-500">No programs listed yet. Check back soon!</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>

                <!-- Admissions Section -->
                <section id="admissions"
                    class="scroll-mt-32 bg-surface-light dark:bg-surface-dark p-6 md:p-8 rounded shadow-soft border border-slate-100 dark:border-slate-800">
                    <h2 class="text-2xl font-bold text-primary dark:text-white mb-6 font-display">Admissions Info</h2>
                    <div class="space-y-6">
                        <div class="flex items-start gap-4">
                            <span class="material-symbols-outlined text-primary text-[32px]">event_available</span>
                            <div>
                                <h4 class="font-bold text-slate-800 dark:text-white mb-1">Application Period</h4>
                                <p class="text-sm text-slate-600 dark:text-slate-400">Main intake starts in September.
                                    Applications are typically accepted from October to January for the following
                                    academic
                                    year.</p>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Costs Section -->
                <section id="costs"
                    class="scroll-mt-32 bg-surface-light dark:bg-surface-dark p-6 md:p-8 rounded shadow-soft border border-slate-100 dark:border-slate-800">
                    <h2 class="text-2xl font-bold text-primary dark:text-white mb-6 font-display">Fees & Living Costs
                    </h2>

                    <?php
                    $uniCurrency = $university['country_currency'] ?: 'USD';
                    $userCurrency = get_user_currency();

                    $renderCost = function ($label, $min, $max, $period = 'Year') use ($uniCurrency, $userCurrency) {
                        if (!$min && !$max)
                            return;
                        ?>
                        <div
                            class="p-5 rounded-xl bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700">
                            <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2"><?= $label ?> <span
                                    class="font-normal normal-case text-slate-400">/ <?= $period ?></span></h4>
                            <div class="space-y-1">
                                <p class="text-xl font-black text-slate-900 dark:text-white">
                                    <?php
                                    echo format_currency_price($min, $uniCurrency);
                                    if ($max && $max > $min) {
                                        echo ' - ' . format_currency_price($max, $uniCurrency);
                                    }
                                    ?>
                                </p>
                                <?php if ($uniCurrency !== $userCurrency): ?>
                                    <p class="text-sm font-bold text-slate-500">
                                        ≈
                                        <?php
                                        $convMin = convert_currency($min, $uniCurrency, $userCurrency);
                                        echo format_currency_price($convMin, $userCurrency);

                                        if ($max && $max > $min) {
                                            $convMax = convert_currency($max, $uniCurrency, $userCurrency);
                                            echo ' - ' . format_currency_price($convMax, $userCurrency);
                                        }
                                        ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php
                    };
                    ?>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <?php
                        // Check if values exist before rendering
                        if ($university['tuition_fee_min'] || $university['tuition_fee_max'])
                            $renderCost('Tuition Fees', $university['tuition_fee_min'], $university['tuition_fee_max'], 'Year');

                        if ($university['living_cost_min'] || $university['living_cost_max'])
                            $renderCost('Living Expenses', $university['living_cost_min'], $university['living_cost_max'], 'Year');
                        ?>
                    </div>
                    <p class="text-xs text-slate-400 mt-4 italic">* Costs are estimated. Actual fees may vary by course
                        and lifestyle.</p>
                </section>

                <!-- Scholarships Section -->
                <section id="scholarships"
                    class="scroll-mt-32 bg-surface-light dark:bg-surface-dark p-6 md:p-8 rounded shadow-soft border border-slate-100 dark:border-slate-800">
                    <h2 class="text-2xl font-bold text-primary dark:text-white mb-6 font-display">Scholarships &
                        Financial
                        Aid</h2>
                    <div class="space-y-4">
                        <div class="p-4 rounded-xl border-l-4 border-accent bg-accent/5">
                            <h4 class="font-bold text-slate-900 dark:text-white mb-1">Need-Blind Admission</h4>
                            <p class="text-sm text-slate-600 dark:text-slate-400">Financial need is not considered
                                during
                                the admission process for both domestic and international students.</p>
                        </div>
                        <?php if (!empty($scholarshipBlogs)): ?>
                            <div class="mt-6 border-t border-slate-100 dark:border-slate-800 pt-6">
                                <h4 class="font-bold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary">school</span>
                                    Related Scholarship Opportunities
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <?php foreach ($scholarshipBlogs as $blog): ?>
                                        <a href="<?= base_url('blog/' . $blog['slug']) ?>"
                                            class="group block bg-white dark:bg-slate-800 rounded-lg overflow-hidden border border-slate-200 dark:border-slate-700 hover:border-primary/50 transition-all shadow-sm hover:shadow-md">
                                            <div class="p-4">
                                                <span
                                                    class="text-[10px] font-bold text-primary bg-primary/10 px-2 py-0.5 rounded uppercase tracking-wide mb-2 inline-block">Scholarship</span>
                                                <h5
                                                    class="font-bold text-slate-900 dark:text-white group-hover:text-primary transition-colors line-clamp-2 text-sm">
                                                    <?= esc($blog['title']) ?>
                                                </h5>
                                                <div class="mt-3 flex items-center justify-between text-[10px] text-slate-500">
                                                    <span class="flex items-center gap-1">
                                                        <span
                                                            class="material-symbols-outlined text-[14px]">calendar_today</span>
                                                        <?= date('M d, Y', strtotime($blog['created_at'])) ?>
                                                    </span>
                                                    <span
                                                        class="group-hover:translate-x-1 transition-transform text-primary font-bold flex items-center">
                                                        View <span
                                                            class="material-symbols-outlined text-[10px]">arrow_forward</span>
                                                    </span>
                                                </div>
                                            </div>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>

                <!-- Campus Gallery (Mini) -->
                <section class="mt-4">
                    <h2 class="text-2xl font-bold text-primary dark:text-white font-display mb-4">Campus Life</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 h-48 md:h-64">
                        <div @click="if(galleryImages.length > 0) { galleryIndex = 0; isGalleryModalOpen = true; }"
                            class="col-span-2 row-span-2 rounded-lg bg-cover bg-center cursor-pointer hover:opacity-90 transition-opacity"
                            data-alt="Campus Overview"
                            style="background-image: url('<?= isset($gallery[0]) ? base_url($gallery[0]['file_name']) : "https://placehold.co/800x600?text={$placeholderBase}+-+Campus+Overview" ?>');">
                        </div>
                        <div @click="if(galleryImages.length > 1) { galleryIndex = 1; isGalleryModalOpen = true; }"
                            class="rounded-lg bg-cover bg-center cursor-pointer hover:opacity-90 transition-opacity"
                            data-alt="Campus View"
                            style="background-image: url('<?= isset($gallery[1]) ? base_url($gallery[1]['file_name']) : "https://placehold.co/600x600?text={$placeholderBase}+-+Campus+View" ?>');">
                        </div>
                        <div @click="if(galleryImages.length > 2) { galleryIndex = 2; isGalleryModalOpen = true; }"
                            class="rounded-lg bg-cover bg-center cursor-pointer hover:opacity-90 transition-opacity"
                            data-alt="Study Area"
                            style="background-image: url('<?= isset($gallery[2]) ? base_url($gallery[2]['file_name']) : "https://placehold.co/600x600?text={$placeholderBase}+-+Study+Area" ?>');">
                        </div>
                        <div class="col-span-2 rounded-lg bg-cover bg-center relative group cursor-pointer"
                            @click="if(galleryImages.length > 0) { galleryIndex = 0; isGalleryModalOpen = true; }"
                            data-alt="Gallery View"
                            style="background-image: url('<?= isset($gallery[3]) ? base_url($gallery[3]['file_name']) : "https://placehold.co/800x400?text={$placeholderBase}+-+Campus+Life" ?>');">
                            <div
                                class="absolute inset-0 bg-black/40 group-hover:bg-black/30 transition-colors flex items-center justify-center rounded-lg">
                                <span
                                    class="text-white font-bold border-2 border-white rounded px-4 py-2 text-sm uppercase tracking-wider">View
                                    Gallery</span>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Reviews Section -->
                <section id="reviews" class="mt-4 scroll-mt-36">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-bold text-primary dark:text-white font-display">Student Reviews</h2>
                        <?php if (session()->get('isLoggedIn')): ?>
                            <button @click="isReviewModalOpen = true"
                                class="bg-primary hover:bg-[#152a48] text-white px-5 py-2 rounded-lg text-sm font-bold transition-all flex items-center gap-2">
                                <span class="material-symbols-outlined text-[20px]">edit_square</span>
                                Write a Review
                            </button>
                        <?php else: ?>
                            <a href="<?= base_url('login') ?>"
                                class="bg-primary hover:bg-[#152a48] text-white px-5 py-2 rounded-lg text-sm font-bold transition-all flex items-center gap-2">
                                <span class="material-symbols-outlined text-[20px]">login</span>
                                Login to Review
                            </a>
                        <?php endif; ?>
                    </div>

                    <?php
                    $totalReviews = count($reviews);
                    $avgRating = 0;
                    $ratingCounts = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];

                    if ($totalReviews > 0) {
                        $sumRating = 0;
                        foreach ($reviews as $r) {
                            $sumRating += $r['rating'];
                            $ratingCounts[$r['rating']]++;
                        }
                        $avgRating = round($sumRating / $totalReviews, 1);
                    }
                    ?>

                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                        <!-- Rating Summary -->
                        <div
                            class="md:col-span-4 bg-surface-light dark:bg-surface-dark p-6 rounded shadow-soft border border-slate-100 dark:border-slate-800 flex flex-col items-center justify-center text-center">
                            <div class="text-5xl font-black text-primary dark:text-white mb-2 font-display">
                                <?= $avgRating ?: '0.0' ?>
                            </div>
                            <div class="flex gap-1 mb-2">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <span
                                        class="material-symbols-outlined <?= $i <= round($avgRating) ? 'text-accent fill-accent' : 'text-slate-200' ?> text-[24px]">star</span>
                                <?php endfor; ?>
                            </div>
                            <p class="text-slate-500 text-sm font-medium">Based on <?= $totalReviews ?> Reviews</p>

                            <div class="w-full mt-6 space-y-2">
                                <?php foreach ($ratingCounts as $star => $count):
                                    $percentage = $totalReviews > 0 ? round(($count / $totalReviews) * 100) : 0;
                                    ?>
                                    <div class="flex items-center gap-3">
                                        <span class="text-xs font-bold text-slate-500 shrink-0"><?= $star ?> Star</span>
                                        <div class="flex-1 h-2 bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden">
                                            <div class="h-full bg-accent rounded-full" style="width: <?= $percentage ?>%">
                                            </div>
                                        </div>
                                        <span
                                            class="text-xs font-bold text-slate-400 shrink-0 w-8"><?= $percentage ?>%</span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>

                        <!-- Review List -->
                        <div class="md:col-span-8 space-y-4">
                            <?php if ($totalReviews > 0): ?>
                                <?php foreach ($reviews as $rev): ?>
                                    <div
                                        class="bg-surface-light dark:bg-surface-dark p-6 rounded shadow-soft border border-slate-100 dark:border-slate-800">
                                        <div class="flex justify-between items-start mb-4">
                                            <div class="flex items-center gap-3">
                                                <div
                                                    class="size-10 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold">
                                                    <?= strtoupper(substr($rev['reviewer_name'], 0, 2)) ?>
                                                </div>
                                                <div>
                                                    <h4 class="text-sm font-bold text-slate-900 dark:text-white">
                                                        <?= esc($rev['reviewer_name']) ?>
                                                    </h4>
                                                    <p class="text-[10px] text-slate-400 font-medium uppercase tracking-wide">
                                                        <?= esc($rev['reviewer_designation'] ?? 'Student') ?>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="flex gap-0.5">
                                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                                    <span
                                                        class="material-symbols-outlined <?= $i <= $rev['rating'] ? 'text-accent fill-accent' : 'text-slate-200' ?> text-[16px]">star</span>
                                                <?php endfor; ?>
                                            </div>
                                        </div>
                                        <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed italic">
                                            "<?= esc($rev['comment']) ?>"
                                        </p>
                                        <div
                                            class="mt-4 pt-4 border-t border-slate-50 dark:border-slate-800 flex items-center gap-4">
                                            <button
                                                class="flex items-center gap-1.5 text-xs text-slate-400 hover:text-primary transition-colors">
                                                <span class="material-symbols-outlined text-[16px]">thumb_up</span> Helpful
                                            </button>
                                            <span class="text-xs text-slate-300">|</span>
                                            <span class="text-xs text-slate-400">Published
                                                <?= date('M d, Y', strtotime($rev['created_at'])) ?></span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div
                                    class="bg-surface-light dark:bg-surface-dark p-12 rounded shadow-soft border border-slate-100 dark:border-slate-800 text-center">
                                    <span
                                        class="material-symbols-outlined text-slate-300 text-[64px] mb-4">rate_review</span>
                                    <p class="text-slate-500 font-medium">No reviews yet. Be the first to share your
                                        experience!</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </section>


                <!-- Latest Updates Section -->
                <?php if (!empty($latestUpdates)): ?>
                    <section id="updates" class="mt-4 scroll-mt-36">
                        <h2 class="text-2xl font-bold text-primary dark:text-white font-display mb-6">Latest Updates</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <?php foreach ($latestUpdates as $blog): ?>
                                <a href="<?= base_url('blog/' . $blog['slug']) ?>"
                                    class="group flex flex-col bg-surface-light dark:bg-surface-dark rounded-xl shadow-soft border border-slate-100 dark:border-slate-800 overflow-hidden hover:border-primary/30 transition-all">
                                    <?php if (!empty($blog['featured_image'])): ?>
                                        <div class="h-48 w-full bg-cover bg-center"
                                            style="background-image: url('<?= base_url('uploads/blogs/' . $blog['featured_image']) ?>');">
                                        </div>
                                    <?php endif; ?>
                                    <div class="p-5 flex flex-col flex-1">
                                        <div class="mb-2">
                                            <span
                                                class="text-[10px] font-bold text-slate-500 bg-slate-100 dark:bg-slate-800 px-2 py-1 rounded-full uppercase tracking-wide">
                                                <?= esc($blog['blog_category'] ?? 'Update') ?>
                                            </span>
                                        </div>
                                        <h3
                                            class="text-lg font-bold text-slate-900 dark:text-white mb-2 group-hover:text-primary transition-colors leading-tight">
                                            <?= esc($blog['title']) ?>
                                        </h3>
                                        <div
                                            class="mt-auto pt-4 flex items-center justify-between text-xs text-slate-400 border-t border-slate-100 dark:border-slate-800">
                                            <span><?= date('M d, Y', strtotime($blog['created_at'])) ?></span>
                                            <span
                                                class="flex items-center gap-1 group-hover:translate-x-1 transition-transform text-primary font-bold">
                                                Read More <span
                                                    class="material-symbols-outlined text-[14px]">arrow_forward</span>
                                            </span>
                                        </div>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endif; ?>
            </div>

            <!-- Right Sidebar (Sticky) -->
            <div class="lg:col-span-4 lg:sticky lg:top-24 space-y-6">
                <!-- Requirements Card -->
                <div class="bg-surface-light dark:bg-surface-dark rounded shadow-soft border-t-4 border-primary p-6">
                    <h3
                        class="text-lg font-bold text-primary dark:text-white font-display mb-5 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">fact_check</span>
                        Entry Requirements
                    </h3>

                    <div class="space-y-6">
                        <?php
                        $englishReqs = array_filter($requirementParams ?? [], fn($p) => stripos($p['category_tags'], 'English') !== false);
                        $entranceReqs = array_filter($requirementParams ?? [], fn($p) => (stripos($p['category_tags'], 'Entrance') !== false || stripos($p['category_tags'], 'Analytical') !== false));

                        $englishCodes = array_column($englishReqs, 'code');
                        $entranceCodes = array_column($entranceReqs, 'code');

                        $otherReqs = array_filter($requirementParams ?? [], fn($p) => !in_array($p['code'], $englishCodes) && !in_array($p['code'], $entranceCodes));
                        ?>

                        <?php if (!empty($englishReqs)): ?>
                            <!-- English Proficiency -->
                            <div>
                                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">English
                                    Proficiency</h4>
                                <div class="grid grid-cols-2 gap-3">
                                    <?php foreach ($englishReqs as $p): ?>
                                        <div
                                            class="bg-indigo-50 dark:bg-indigo-900/10 p-3 rounded-lg border border-indigo-100 dark:border-indigo-900/20 text-center">
                                            <span class="block text-xl font-black text-indigo-600 dark:text-indigo-400">
                                                <?= esc($metadata[$p['code']] ?? 'N/A') ?>
                                            </span>
                                            <span
                                                class="text-[10px] font-bold text-indigo-400 dark:text-indigo-300 uppercase"><?= esc($p['label']) ?></span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($entranceReqs)): ?>
                            <!-- Analytical & Entrance Tests -->
                            <div>
                                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Analytical &
                                    Entrance Tests</h4>
                                <div class="grid grid-cols-1 gap-3">
                                    <?php foreach ($entranceReqs as $p): ?>
                                        <div
                                            class="bg-emerald-50 dark:bg-emerald-900/10 p-3 rounded-lg border border-emerald-100 dark:border-emerald-900/20 flex items-center justify-between px-4">
                                            <span
                                                class="text-[10px] font-bold text-emerald-500 dark:text-emerald-300 uppercase"><?= esc($p['label']) ?></span>
                                            <span class="text-lg font-black text-emerald-600 dark:text-emerald-400">
                                                <?= esc($metadata[$p['code']] ?? 'N/A') ?>
                                            </span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($otherReqs)): ?>
                            <!-- Other Requirements -->
                            <div>
                                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Other Details
                                </h4>
                                <div class="space-y-2">
                                    <?php foreach ($otherReqs as $p): ?>
                                        <div class="flex justify-between items-center text-sm">
                                            <span class="text-slate-500 font-medium"><?= esc($p['label']) ?></span>
                                            <span
                                                class="font-bold text-slate-700 dark:text-slate-300"><?= esc($metadata[$p['code']] ?? 'N/A') ?></span>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (empty($requirementParams)): ?>
                            <p class="text-sm text-slate-400 italic text-center py-4">Standard entry requirements apply.
                                Contact university for details.</p>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- Advertisement Slot -->
                <div class="uni-ad-slot" data-placement="university_sidebar"></div>
                <!-- Map / Location Mini -->
                <div
                    class="bg-surface-light dark:bg-surface-dark rounded shadow-soft border border-slate-100 dark:border-slate-800 overflow-hidden">
                    <div class="h-48 w-full bg-slate-100 dark:bg-slate-900">
                        <?php
                        $query = urlencode($university['name'] . ' ' . ($university['state_name'] ?? '') . ' ' . $university['country_name']);
                        $mapSrc = "https://maps.google.com/maps?q={$query}&t=&z=14&ie=UTF8&iwloc=&output=embed";
                        ?>
                        <iframe width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade" src="<?= $mapSrc ?>">
                        </iframe>
                    </div>
                    <div
                        class="p-4 flex items-center justify-between bg-white dark:bg-surface-dark border-t border-slate-100 dark:border-slate-800">
                        <div class="text-sm font-medium text-slate-700 dark:text-slate-300">
                            <?= esc($university['state_name'] ?? '') ?><?= (isset($university['state_name']) && isset($university['country_name'])) ? ', ' : '' ?><?= esc($university['country_name']) ?>
                        </div>
                        <a href="https://www.google.com/maps/search/?api=1&query=<?= $query ?>" target="_blank"
                            class="text-primary text-sm font-bold hover:underline">Get Directions</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Static Mock Test Promo Section -->
        <div
            class="mt-12 bg-gradient-to-br from-slate-900 to-slate-800 rounded-2xl p-8 md:p-12 relative overflow-hidden shadow-xl border border-slate-700/50">
            <!-- Abstract Background Shapes -->
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-emerald-500/20 rounded-full blur-3xl">
            </div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-blue-500/20 rounded-full blur-2xl">
            </div>

            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
                <div class="flex-1 text-center md:text-left">
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 backdrop-blur-sm text-emerald-400 text-xs font-bold uppercase tracking-wider mb-4">
                        <span class="material-symbols-outlined text-[16px]">quiz</span>
                        <span>Exam Prep</span>
                    </div>
                    <h2 class="text-3xl font-black text-secondary mb-4">Ace Your Entrance Exams</h2>
                    <div class="text-white text-lg mb-6 max-w-xl">
                        Maximize your score with full-length mock tests for IELTS, TOEFL, GRE, and GMAT. Get
                        detailed
                        analytics and personalized performance reports.
                    </div>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                        <a href="<?= base_url('ai-tools') ?>"
                            class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-emerald-500 text-primary font-bold rounded-xl hover:bg-emerald-600 transition-all transform hover:-translate-y-1 shadow-lg shadow-white/10">
                            <span>Start Free Mock Test</span>
                            <span class="material-symbols-outlined">arrow_forward</span>
                        </a>
                    </div>
                </div>
                <div class="shrink-0 relative">
                    <div
                        class="w-24 h-24 md:w-32 md:h-32 bg-gradient-to-tr from-emerald-500 to-blue-500 rounded-2xl rotate-6 absolute inset-0 opacity-50 blur-lg">
                    </div>
                    <div
                        class="w-24 h-24 md:w-32 md:h-32 bg-slate-800 border border-slate-700 rounded-2xl flex items-center justify-center relative shadow-2xl">
                        <span
                            class="material-symbols-outlined text-[48px] md:text-[64px] text-white">assignment_turned_in</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Spacer -->
        <div class="h-24"></div>
    </main>

    <!-- Sticky Apply Bar -->
    <div
        class="fixed bottom-0 left-0 w-full bg-white dark:bg-[#0f172a] border-t border-slate-200 dark:border-slate-800 p-4 shadow-[0_-4px_20px_rgba(0,0,0,0.1)] z-[100]">
        <div class="max-w-[1280px] mx-auto flex items-center justify-between gap-4">
            <div class="hidden md:flex flex-col">
                <span class="text-xs text-slate-500 uppercase tracking-wide font-bold">Interested in
                    <?= esc($university['name']) ?>?</span>
                <span class="text-sm text-slate-900 dark:text-white font-medium">Free counseling & application support
                    available.</span>
            </div>
            <div class="flex flex-1 md:flex-none gap-4">
                <a href="<?= esc($university['website']) ?>" target="_blank"
                    class="flex-1 md:flex-none text-center min-w-[160px] border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-200 font-bold py-2.5 px-6 rounded hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                    University Site
                </a>
                <?php if (!empty($university['website'])): ?>
                    <button type="button"
                        @click="handleApplyNow('<?= esc($university['website']) ?>', <?= $university['id'] ?>)"
                        class="flex-1 md:flex-none min-w-[160px] bg-primary text-white font-bold py-2.5 px-6 rounded hover:bg-[#152a48] transition-colors shadow-lg shadow-primary/20 flex items-center justify-center gap-2">
                        <span x-show="applying"
                            class="animate-spin size-4 border-2 border-white border-t-transparent rounded-full"></span>
                        <span x-text="isBookmarked ? 'Already Bookmarked' : 'Apply Now'"></span>
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
        // Tab highlighting logic
        const sections = document.querySelectorAll('section[id]');
        const navLinks = document.querySelectorAll('.nav-tab');

        window.addEventListener('scroll', () => {
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.clientHeight;
                if (window.pageYOffset >= (sectionTop - 150)) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('active', 'border-primary', 'text-primary', 'dark:text-white');
                link.classList.add('border-transparent', 'text-slate-500', 'dark:text-slate-400');
                if (link.getAttribute('href') === `#${current}`) {
                    link.classList.add('active', 'border-primary', 'text-primary', 'dark:text-white');
                    link.classList.remove('border-transparent', 'text-slate-500', 'dark:text-slate-400');
                }
            });
        });
    </script>

    <!-- Review Modal -->
    <div x-show="isReviewModalOpen"
        class="fixed inset-0 z-[9999] flex items-center justify-center p-4 bg-black/40 backdrop-blur-md" x-cloak
        @keydown.escape.window="isReviewModalOpen = false">

        <div class="bg-white dark:bg-slate-900 w-full max-w-lg rounded-2xl shadow-2xl overflow-hidden"
            @click.away="isReviewModalOpen = false">
            <div
                class="p-6 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center bg-slate-50/50 dark:bg-slate-800/50">
                <h3 class="text-xl font-bold text-primary dark:text-white font-display">Write a Review</h3>
                <button @click="isReviewModalOpen = false"
                    class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <form action="<?= base_url('universities/submit-review') ?>" method="POST" class="p-6 space-y-6">
                <?= csrf_field() ?>
                <input type="hidden" name="university_id" value="<?= $university['id'] ?>">

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Full Name</label>
                        <input type="text" name="name" required value="<?= esc(session()->get('user_name')) ?>"
                            <?= session()->get('user_name') ? 'readonly' : '' ?> placeholder="Ex: John Doe"
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all <?= session()->get('user_name') ? 'opacity-70 cursor-not-allowed' : '' ?>">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Designation</label>
                        <input type="text" name="designation" placeholder="Ex: CS Student"
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
                    </div>
                </div>

                <div class="space-y-3">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Overall Rating</label>
                    <div class="flex gap-2" x-data="{ rating: 0 }">
                        <template x-for="i in 5">
                            <button type="button" @click="rating = i"
                                class="focus:outline-none transition-transform active:scale-90">
                                <span class="material-symbols-outlined text-[32px]"
                                    :class="i <= rating ? 'text-accent fill-accent' : 'text-slate-200'"
                                    x-text="'star'"></span>
                            </button>
                        </template>
                        <input type="hidden" name="rating" :value="rating" required>
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider">Your Experience</label>
                    <textarea name="comment" required rows="4"
                        placeholder="Tell us about the campus, faculty, and overall atmosphere..."
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all resize-none"></textarea>
                </div>

                <button type="submit"
                    class="w-full py-3.5 bg-primary text-white font-bold rounded-xl hover:bg-[#152a48] transition-all shadow-lg shadow-primary/20 flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-[20px]">send</span>
                    Submit Review
                </button>
            </form>
        </div>
    </div>
</div>

<?= view('web/include/footer') ?>