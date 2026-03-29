<?= view('web/include/header', ['title' => $course['name'] . ' - UniHunt', 'bodyClass' => 'bg-background-light dark:bg-background-dark font-display text-[#121417] dark:text-gray-100 flex flex-col min-h-screen transition-colors duration-200']) ?>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Course",
  "name": "<?= esc($course['name']) ?>",
  "description": "<?= esc(strip_tags($course['description'] ?? 'Study ' . $course['name'] . ' at ' . $course['university_name'])) ?>",
  "provider": {
    "@type": "CollegeOrUniversity",
    "name": "<?= esc($course['university_name']) ?>",
    "sameAs": "<?= esc($course['university_website'] ?? '') ?>",
    "logo": "<?= !empty($course['logo_path']) ? base_url('uploads/universities/' . $course['logo_path']) : base_url('favicon_io/favicon.ico') ?>"
  },
  "educationalCredentialAwarded": "<?= esc($course['level']) ?>",
  "offers": {
    "@type": "Offer",
    "category": "International Student Fees",
    "priceCurrency": "<?= esc($course['currency'] ?? 'USD') ?>",
    "price": "<?= esc($course['tuition_fee']) ?>",
    "priceSpecification": {
        "@type": "UnitPriceSpecification",
        "price": "<?= esc($course['tuition_fee']) ?>",
        "priceCurrency": "<?= esc($course['currency'] ?? 'USD') ?>",
        "unitCode": "ANN"
    }
  }
}
</script>

<div class="flex-1 w-full max-w-7xl mx-auto px-4 md:px-6 lg:px-8 py-6">
    <!-- Breadcrumbs -->
    <nav class="flex flex-wrap gap-2 items-center mb-6 text-sm text-[#677583] dark:text-gray-400">
        <a class="hover:text-primary transition-colors" href="<?= base_url() ?>">Home</a>
        <span class="material-symbols-outlined text-[16px]">chevron_right</span>
        <a class="hover:text-primary transition-colors" href="<?= base_url('universities') ?>">Universities</a>
        <span class="material-symbols-outlined text-[16px]">chevron_right</span>
        <a class="hover:text-primary transition-colors"
            href="<?= base_url('universities/' . $course['country_slug'] . '/' . $course['university_slug']) ?>"><?= esc($course['university_name']) ?></a>
        <span class="material-symbols-outlined text-[16px]">chevron_right</span>
        <span class="text-[#121417] dark:text-white font-medium"><?= esc($course['name']) ?></span>
    </nav>
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <!-- Left Sidebar (Navigation & CTA) -->
        <aside class="lg:col-span-3 lg:sticky lg:top-24 order-2 lg:order-1 space-y-6">
            <!-- CTA Card -->
            <div
                class="bg-card-light dark:bg-card-dark rounded-xl border border-border-light dark:border-border-dark p-5 shadow-sm">
                <div class="mb-4">
                    <p class="text-sm text-[#677583] dark:text-gray-400 mb-1">Tuition Fee</p>
                    <div class="flex flex-col gap-1">
                        <p class="text-3xl font-bold text-primary leading-none">
                            <?php
                            $uniCurrency = $course['country_currency'] ?: 'USD';
                            $userCurrency = get_user_currency();
                            
                            if ($course['tuition_fee']) {
                                echo format_currency_price($course['tuition_fee'], $uniCurrency);
                            } else {
                                echo 'N/A';
                            }
                            ?>
                        </p>
                        <?php
                        if ($course['tuition_fee'] && $uniCurrency !== $userCurrency) {
                            $converted = convert_currency($course['tuition_fee'], $uniCurrency, $userCurrency);
                            if ($converted) {
                                echo '<div class="text-sm font-medium text-slate-500">≈ ' . format_currency_price($converted, $userCurrency) . '<span class="text-xs font-normal ml-1">/ year</span></div>';
                            }
                        } else {
                            echo '<span class="text-xs font-normal text-slate-500">/ year</span>';
                        }
                        ?>
                    </div>
                </div>
                <?php if (!empty($metadata['application_fee'])): ?>
                    <div class="mb-4 pt-4 border-t border-border-light dark:border-border-dark">
                        <p class="text-sm text-[#677583] dark:text-gray-400 mb-1">Application Fee</p>
                        <div class="flex flex-col gap-0.5">
                            <p class="text-xl font-bold text-[#121417] dark:text-white leading-none">
                                <?php
                                $appFee = $metadata['application_fee'];
                                // Assuming app fee is stored as number, format it
                                // If it already has symbols, we might just print it, but let's try to format if numeric
                                if (is_numeric(str_replace([',', '$', '£', '€'], '', $appFee))) {
                                    $cleanFee = (float)str_replace([',', '$', '£', '€'], '', $appFee);
                                    echo format_currency_price($cleanFee, $uniCurrency);
                                } else {
                                    echo esc($appFee); // Fallback for strings like "Free" or "50 USD"
                                }
                                ?>
                            </p>
                            <?php
                            if (is_numeric(str_replace([',', '$', '£', '€'], '', $appFee)) && $uniCurrency !== $userCurrency) {
                                $cleanFee = (float)str_replace([',', '$', '£', '€'], '', $appFee);
                                $convertedAppFee = convert_currency($cleanFee, $uniCurrency, $userCurrency);
                                if ($convertedAppFee) {
                                    echo '<div class="text-xs font-medium text-slate-500">≈ ' . format_currency_price($convertedAppFee, $userCurrency) . '</div>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php
                $applyUrl = $course['university_website'];
                if (!empty($requirementParams) && !empty($metadata)) {
                    foreach ($requirementParams as $p) {
                        if ($p['label'] === 'Application URL' && !empty($metadata[$p['code']])) {
                            $applyUrl = $metadata[$p['code']];
                            break;
                        }
                    }
                }
                ?>
                <?php if (!empty($applyUrl)): ?>
                    <button
                        class="w-full flex items-center justify-center gap-2 rounded-lg h-12 bg-primary text-white text-base font-bold shadow-lg shadow-primary/25 hover:bg-[#153556] transition-all transform hover:-translate-y-0.5"
                        onclick="window.open('<?= esc($applyUrl) ?>', '_blank')">
                        <span>Apply for this Course</span>
                        <span class="material-symbols-outlined text-[20px]">arrow_forward</span>
                    </button>
                <?php endif; ?>
                <div class="mt-4 flex flex-col items-center gap-2 text-sm text-[#677583]">
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px] text-green-600">check_circle</span>
                        <span>Applications open for:</span>
                    </div>
                    <?php
                    $intakeStr = $course['intake_months'];
                    $intakes = [];
                    // Try JSON
                    $json = json_decode($intakeStr, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($json)) {
                        $intakes = $json;
                    } else {
                        // Fallback comma
                        $intakes = explode(',', $intakeStr);
                    }
                    $intakes = array_filter(array_map('trim', $intakes));
                    ?>
                    <div class="flex flex-wrap gap-2 justify-center">
                        <?php if (!empty($intakes)):
                            foreach ($intakes as $m): ?>
                                <span
                                    class="px-2 py-0.5 rounded bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 text-xs font-bold uppercase tracking-wide border border-green-200 dark:border-green-800">
                                    <?= esc($m) ?>
                                </span>
                            <?php endforeach; else: ?>
                            <span class="text-xs font-bold">Fall 2024</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <!-- Navigation Links -->
            <nav
                class="hidden lg:flex flex-col gap-1 bg-card-light dark:bg-card-dark rounded-xl border border-border-light dark:border-border-dark p-3 shadow-sm">
                <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg bg-primary/10 text-primary font-semibold"
                    href="#overview">
                    <span class="material-symbols-outlined text-[20px]">info</span>
                    Overview
                </a>
                <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#677583] hover:bg-background-light dark:hover:bg-background-dark hover:text-[#121417] dark:hover:text-white transition-colors"
                    href="#syllabus">
                    <span class="material-symbols-outlined text-[20px]">menu_book</span>
                    Syllabus
                </a>
                <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#677583] hover:bg-background-light dark:hover:bg-background-dark hover:text-[#121417] dark:hover:text-white transition-colors"
                    href="#career">
                    <span class="material-symbols-outlined text-[20px]">trending_up</span>
                    Career Outcomes
                </a>
                <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-[#677583] hover:bg-background-light dark:hover:bg-background-dark hover:text-[#121417] dark:hover:text-white transition-colors"
                    href="#requirements">
                    <span class="material-symbols-outlined text-[20px]">verified</span>
                    Entry Requirements
                </a>
            </nav>
            <!-- Similar Courses -->
            <?php if (!empty($similarCourses)): ?>
                <div
                    class="bg-card-light dark:bg-card-dark rounded-xl border border-border-light dark:border-border-dark p-5 shadow-sm">
                    <h3 class="font-bold text-[#121417] dark:text-white mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">hub</span>
                        Similar Courses
                    </h3>
                    <div class="flex flex-col gap-4">
                        <?php foreach ($similarCourses as $sim): ?>
                            <a class="group block"
                                href="<?= base_url('courses/' . ($course['country_slug'] ?? 'world') . '/' . ($course['university_slug'] ?? 'any') . '/' . url_title($sim['name'], '-', true)) ?>">
                                <p class="font-semibold text-sm group-hover:text-primary transition-colors">
                                    <?= esc($sim['name']) ?>
                                </p>
                                <p class="text-xs text-[#677583] mt-0.5"><?= esc($course['university_name']) ?></p>
                            </a>
                            <div class="h-px bg-border-light dark:bg-border-dark w-full last:hidden"></div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Sidebar Ad Slot -->
            <div class="uni-ad-slot mt-6" data-placement="university_sidebar"></div>
        </aside>
        <!-- Main Content Area -->
        <main class="lg:col-span-9 flex flex-col gap-8 order-1 lg:order-2">
            <!-- Course Header Card -->
            <div class="bg-card-light dark:bg-card-dark rounded-2xl border border-border-light dark:border-border-dark p-6 md:p-8 shadow-sm relative overflow-hidden group/header"
                id="overview">
                <!-- Decorative Gradients -->
                <div
                    class="absolute top-0 right-0 w-96 h-96 bg-primary/5 rounded-full blur-3xl -mr-32 -mt-32 pointer-events-none group-hover/header:bg-primary/10 transition-colors duration-500">
                </div>
                <div
                    class="absolute bottom-0 left-0 w-64 h-64 bg-secondary/5 rounded-full blur-3xl -ml-20 -mb-20 pointer-events-none">
                </div>
                <div class="relative z-10">
                    <div class="flex flex-col md:flex-row md:items-start justify-between gap-4 mb-6">
                        <div>
                            <div class="flex items-center gap-2 mb-3">
                                <div class="size-10 rounded-full bg-white border border-border-light flex items-center justify-center p-1 shadow-sm overflow-hidden"
                                    title="<?= esc($course['university_name']) ?>">
                                    <img alt="<?= esc($course['university_name']) ?>"
                                        class="w-full h-full object-contain"
                                        src="<?= $course['logo_path'] ? base_url($course['logo_path']) : base_url('favicon_io/android-chrome-512x512.webp') ?>" />
                                </div>
                                <span
                                    class="text-[#677583] dark:text-gray-400 font-medium"><?= esc($course['university_name']) ?></span>
                            </div>
                            <h1
                                class="text-3xl md:text-4xl font-black text-[#121417] dark:text-white leading-tight mb-2">
                                <?= esc($course['name']) ?>
                            </h1>
                            <p class="text-base text-[#677583] dark:text-gray-400 max-w-2xl mb-4">
                                <?= isset($metadata['notes']) ? esc($metadata['notes']) : 'Study ' . esc($course['name']) . ' at ' . esc($course['university_name']) . ' and advance your career with global exposure.' ?>
                            </p>
                            <div class="flex flex-wrap gap-2">
                                <?php if ($course['stem']): ?>
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-300 text-xs font-bold uppercase tracking-wider border border-blue-100 dark:border-blue-800">
                                        <span class="material-symbols-outlined text-[16px]">science</span>
                                        STEM Designated
                                    </span>
                                <?php elseif (($metadata['classification'] ?? 'International') === 'International'): ?>
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-purple-50 dark:bg-purple-900/20 text-purple-600 dark:text-purple-300 text-xs font-bold uppercase tracking-wider border border-purple-100 dark:border-purple-800">
                                        <span class="material-symbols-outlined text-[16px]">public</span>
                                        International Students
                                    </span>
                                <?php elseif (($metadata['classification'] ?? '') === 'Domestic'): ?>
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-50 dark:bg-slate-900/20 text-slate-600 dark:text-slate-300 text-xs font-bold uppercase tracking-wider border border-slate-100 dark:border-slate-800">
                                        <span class="material-symbols-outlined text-[16px]">home</span>
                                        Domestic Students
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                        <button onclick="toggleBookmark(this, 'course', <?= $course['id'] ?>)"
                            class="flex items-center justify-center size-10 rounded-full bg-background-light dark:bg-background-dark <?= isset($isBookmarked) && $isBookmarked ? 'text-secondary' : 'text-[#677583]' ?> hover:text-secondary hover:bg-secondary/10 transition-colors border border-border-light dark:border-border-dark group">
                            <span class="material-symbols-outlined group-hover:scale-110 transition-transform"
                                style="<?= isset($isBookmarked) && $isBookmarked ? "font-variation-settings: 'FILL' 1" : "" ?>"><?= isset($isBookmarked) && $isBookmarked ? 'bookmark' : 'bookmark_border' ?></span>
                        </button>
                    </div>
                    <!-- Key Stats Grid -->
                    <div
                        class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-8 pt-8 border-t border-border-light dark:border-border-dark relative z-10">
                        <div
                            class="flex flex-col gap-1 p-4 bg-background-light dark:bg-background-dark rounded-xl border border-transparent hover:border-primary/20 transition-colors">
                            <div
                                class="flex items-center gap-2 text-[#677583] text-xs font-bold uppercase tracking-wider mb-1">
                                <span class="material-symbols-outlined text-[18px] text-primary">schedule</span>
                                Duration
                            </div>
                            <p class="text-lg font-black text-[#121417] dark:text-white leading-tight">
                                <?= $course['duration_months'] ?> Months
                            </p>
                        </div>
                        <div
                            class="flex flex-col gap-1 p-4 bg-background-light dark:bg-background-dark rounded-xl border border-transparent hover:border-primary/20 transition-colors">
                            <div
                                class="flex items-center gap-2 text-[#677583] text-xs font-bold uppercase tracking-wider mb-1">
                                <span class="material-symbols-outlined text-[18px] text-primary">school</span>
                                Level
                            </div>
                            <p class="text-lg font-black text-[#121417] dark:text-white leading-tight">
                                <?= ucfirst($course['level']) ?>
                            </p>
                        </div>
                        <div
                            class="flex flex-col gap-1 p-4 bg-background-light dark:bg-background-dark rounded-xl border border-transparent hover:border-primary/20 transition-colors">
                            <div
                                class="flex items-center gap-2 text-[#677583] text-xs font-bold uppercase tracking-wider mb-1">
                                <span class="material-symbols-outlined text-[18px] text-primary">location_on</span>
                                Location
                            </div>
                            <p class="text-lg font-black text-[#121417] dark:text-white leading-tight truncate"
                                title="<?= esc($course['country_name']) ?>">
                                <?= esc($course['country_name']) ?>
                            </p>
                        </div>
                        <div
                            class="flex flex-col gap-1 p-4 bg-background-light dark:bg-background-dark rounded-xl border border-transparent hover:border-primary/20 transition-colors">
                            <div
                                class="flex items-center gap-2 text-[#677583] text-xs font-bold uppercase tracking-wider mb-1">
                                <span class="material-symbols-outlined text-[18px] text-primary">stars</span>
                                Credits
                            </div>
                            <p class="text-lg font-black text-[#121417] dark:text-white leading-tight">
                                <?= !empty($course['credits']) ? $course['credits'] : '<span class="text-gray-400 font-normal">N/A</span>' ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Syllabus Section -->
            <!-- Syllabus Section -->
            <?php
            $syllabusRaw = $course['syllabus'] ?? $metadata['syllabus'] ?? '';
            $modules = [];
            // Try JSON first
            $jsonModules = json_decode($syllabusRaw, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($jsonModules)) {
                $modules = $jsonModules;
            } else {
                // Fallback to comma separated
                $modules = !empty($syllabusRaw) ? explode(',', $syllabusRaw) : [];
            }
            $modules = array_filter(array_map('trim', $modules));
            ?>
            <section class="flex flex-col gap-4 scroll-mt-28" id="syllabus">
                <div class="flex items-center justify-between">
                    <h2 class="text-2xl font-bold text-[#121417] dark:text-white flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">menu_book</span>
                        Syllabus & Modules
                    </h2>
                </div>

                <?php if (!empty($modules)): ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <?php foreach ($modules as $index => $module): ?>
                            <div
                                class="flex items-start gap-4 p-4 rounded-xl bg-card-light dark:bg-card-dark border border-border-light dark:border-border-dark hover:border-primary/50 hover:shadow-md hover:-translate-y-1 transition-all duration-300 group shadow-sm">
                                <div
                                    class="flex-shrink-0 size-10 rounded-lg bg-primary/10 flex items-center justify-center text-primary font-bold text-sm group-hover:bg-primary group-hover:text-white transition-colors">
                                    <?= str_pad($index + 1, 2, '0', STR_PAD_LEFT) ?>
                                </div>
                                <div>
                                    <h4 class="font-bold text-[#121417] dark:text-white text-base leading-snug">
                                        <?= esc($module) ?>
                                    </h4>
                                    <p class="text-xs text-[#677583] dark:text-gray-400 mt-1">Core Module</p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div
                        class="p-8 bg-slate-50 dark:bg-slate-800/50 rounded-xl border border-dashed border-slate-200 dark:border-slate-700 text-center">
                        <span class="material-symbols-outlined text-slate-300 text-[48px] mb-2">lock</span>
                        <p class="font-bold text-slate-600 dark:text-slate-400">Content details locked</p>
                        <p class="text-sm text-slate-400 mb-4">Please sign in to view full syllabus.</p>
                        <button
                            class="px-5 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg text-sm font-bold shadow-sm hover:border-primary hover:text-primary transition-colors">
                            Unlock Content
                        </button>
                    </div>
                <?php endif; ?>
            </section>

            <!-- Career Outcomes Section -->
            <section class="flex flex-col gap-4 scroll-mt-28" id="career">
                <h2 class="text-2xl font-bold text-[#121417] dark:text-white">Career Outcomes</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Stats Card -->
                    <div
                        class="bg-card-light dark:bg-card-dark rounded-xl border border-border-light dark:border-border-dark p-6 shadow-sm flex flex-col justify-between">
                        <div>
                            <h3 class="text-lg font-bold mb-1">Employment Rate</h3>
                            <p class="text-sm text-[#677583]">Graduates employed within 6 months</p>
                        </div>
                        <div class="flex items-center gap-6 mt-6">
                            <?php $empRate = intval($metadata['employment_rate'] ?? 85); ?>
                            <div class="relative size-24">
                                <svg class="size-full -rotate-90" viewbox="0 0 36 36">
                                    <path class="text-gray-200 dark:text-gray-700"
                                        d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                        fill="none" stroke="currentColor" stroke-width="4"></path>
                                    <path class="text-[#33CC80]"
                                        d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                        fill="none" stroke="currentColor" stroke-dasharray="<?= $empRate ?>, 100"
                                        stroke-linecap="round" stroke-width="4"></path>
                                </svg>
                                <div class="absolute inset-0 flex items-center justify-center flex-col">
                                    <span
                                        class="text-2xl font-bold text-[#121417] dark:text-white"><?= $empRate ?>%</span>
                                </div>
                            </div>
                            <div class="flex flex-col gap-2">
                                <div class="flex items-center gap-2">
                                    <span class="size-3 rounded-full bg-[#33CC80]"></span>
                                    <span class="text-sm font-medium">Employed</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="size-3 rounded-full bg-gray-200 dark:bg-gray-700"></span>
                                    <span class="text-sm font-medium text-[#677583]">Other</span>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 pt-4 border-t border-border-light dark:border-border-dark">
                            <p class="text-sm font-medium">Average Starting Salary</p>
                            <p class="text-2xl font-bold text-primary">
                                <?= ($metadata['avg_salary'] ?? '') ? esc($metadata['avg_salary']) : 'Competitive' ?>
                            </p>
                        </div>
                    </div>
                    <!-- Top Hiring Roles -->
                    <div
                        class="bg-card-light dark:bg-card-dark rounded-xl border border-border-light dark:border-border-dark p-6 shadow-sm">
                        <h3 class="text-lg font-bold mb-4">Core Focus & Roles</h3>
                        <div class="flex flex-wrap gap-2">
                            <?php
                            $roles = !empty($metadata['top_roles']) ? explode(',', $metadata['top_roles']) : ['Professional Graduate', 'Researcher', 'Consultant'];
                            foreach ($roles as $role): ?>
                                <span
                                    class="px-3 py-1.5 bg-background-light dark:bg-background-dark border border-border-light dark:border-border-dark rounded-lg text-sm font-medium">
                                    <?= trim($role) ?>
                                </span>
                            <?php endforeach; ?>
                        </div>
                        <div class="mt-6 prose dark:prose-invert text-sm text-[#677583] dark:text-gray-400">
                            <?= isset($metadata['career_outcomes']) ? nl2br(esc($metadata['career_outcomes'])) : 'Graduates from this program are highly sought after by top-tier global organizations.' ?>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Entry Requirements Section -->
            <section class="flex flex-col gap-4 scroll-mt-28 mb-10" id="requirements">
                <h2 class="text-2xl font-bold text-[#121417] dark:text-white">Entry Requirements</h2>
                <div
                    class="bg-card-light dark:bg-card-dark rounded-xl border border-border-light dark:border-border-dark p-6 md:p-8 shadow-sm">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Left Side: ALL Requirements -->
                        <div class="flex flex-col gap-8">
                            
                            
                            <!-- Language/Other -->
                            <div class="flex flex-col gap-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="size-10 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                                        <span class="material-symbols-outlined">language</span>
                                    </div>
                                    <h3 class="text-lg font-bold">English & Others</h3>
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <?php
                                    foreach ($requirementParams as $p):
                                        // Exclude Academic & GPA from here
                                        $isAcademic = strpos($p['category_tags'], 'Academic') !== false || stripos($p['label'], 'GPA') !== false;

                                        if (!$isAcademic && isset($metadata[$p['code']]) && !empty($metadata[$p['code']])):
                                            $val = $metadata[$p['code']];
                                            $isLink = filter_var($val, FILTER_VALIDATE_URL);
                                            $isScore = stripos($p['label'], 'Score') !== false; // GPA moved to left
                                            $isDeadline = stripos($p['label'], 'Deadline') !== false;
                                            ?>
                                            <?php if ($isDeadline): ?>
                                                <div
                                                    class="col-span-2 flex items-start gap-4 p-4 rounded-xl bg-amber-50 dark:bg-amber-900/10 border border-amber-100 dark:border-amber-900/30">
                                                    <div
                                                        class="size-10 rounded-full bg-amber-100 dark:bg-amber-800/30 flex items-center justify-center text-amber-600 dark:text-amber-400 flex-shrink-0">
                                                        <span class="material-symbols-outlined">event</span>
                                                    </div>
                                                    <div>
                                                        <p
                                                            class="text-xs font-bold text-amber-700 dark:text-amber-500 uppercase tracking-wide mb-1">
                                                            <?= $p['label'] ?>
                                                        </p>
                                                        <p class="text-sm font-bold text-[#121417] dark:text-gray-200"><?= esc($val) ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            <?php elseif ($isLink): ?>
                                                <a href="<?= esc($val) ?>" target="_blank"
                                                    class="col-span-1 flex items-center justify-between p-3 rounded-lg border border-slate-200 dark:border-slate-700 hover:border-primary hover:bg-slate-50 dark:hover:bg-slate-800 transition-all group h-full">
                                                    <span class="text-[10px] font-bold text-slate-500 uppercase leading-tight mr-2">
                                                        <?= ($p['label'] === 'Application URL') ? 'Apply for this Course' : str_replace(' URL', '', $p['label']) ?>
                                                    </span>
                                                    <span
                                                        class="material-symbols-outlined text-primary text-[18px] group-hover:translate-x-1 transition-transform">open_in_new</span>
                                                </a>
                                            <?php elseif ($isScore): ?>
                                                <div
                                                    class="col-span-1 flex flex-col justify-center p-3 rounded-lg bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800">
                                                    <span
                                                        class="text-[10px] font-bold text-slate-500 uppercase mb-1"><?= str_replace(['MIN.', 'Min.', ' Score'], '', $p['label']) ?></span>
                                                    <span class="text-xl font-black text-primary"><?= esc($val) ?></span>
                                                </div>
                                            <?php else: ?>
                                                <div class="col-span-2 flex items-start gap-4 p-4 rounded-xl bg-gray-50 dark:bg-slate-800/50 border border-transparent hover:border-gray-200 dark:hover:border-slate-700 transition-colors">
                                                    <div class="flex-shrink-0 size-8 rounded-full bg-white dark:bg-slate-700 flex items-center justify-center text-primary shadow-sm border border-gray-100 dark:border-slate-600">
                                                        <span class="material-symbols-outlined text-[18px]">check</span>
                                                    </div>
                                                    <div>
                                                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-0.5"><?= $p['label'] ?></p>
                                                        <p class="text-sm text-[#121417] dark:text-gray-300 font-bold leading-tight"><?= esc($val) ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        <?php endif; endforeach; ?>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Right Side: Ads slot for Course Listing Placement -->
                        <div class="flex flex-col gap-6">
                            <!-- Academic -->
                            <div class="flex flex-col gap-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="size-10 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                                        <span class="material-symbols-outlined">school</span>
                                    </div>
                                    <h3 class="text-lg font-bold">Academic</h3>
                                </div>
                                <ul class="space-y-4">
                                    <?php
                                    foreach ($requirementParams as $p):
                                        // Include GPA here even if not tagged 'Academic' in DB, just in case
                                        $isAcademic = strpos($p['category_tags'], 'Academic') !== false || stripos($p['label'], 'GPA') !== false;
                                        if ($isAcademic && isset($metadata[$p['code']]) && !empty($metadata[$p['code']])):
                                            // Special score style for GPA if desired, or standard list
                                            if (stripos($p['label'], 'GPA') !== false):
                                                ?>
                                                <li
                                                    class="flex items-center justify-between p-3 rounded-lg bg-indigo-50 dark:bg-indigo-900/10 border border-indigo-100 dark:border-indigo-900/30">
                                                    <span class="text-xs font-bold text-indigo-800 dark:text-indigo-300 uppercase">Min
                                                        GPA</span>
                                                    <span
                                                        class="text-xl font-black text-indigo-600 dark:text-indigo-400"><?= $metadata[$p['code']] ?></span>
                                                </li>
                                            <?php else: ?>
                                                <li class="flex items-start gap-4 p-4 rounded-xl bg-gray-50 dark:bg-slate-800/50 border border-transparent hover:border-gray-200 dark:hover:border-slate-700 transition-colors">
                                                    <div class="flex-shrink-0 size-8 rounded-full bg-white dark:bg-slate-700 flex items-center justify-center text-primary shadow-sm border border-gray-100 dark:border-slate-600">
                                                        <span class="material-symbols-outlined text-[18px]">check</span>
                                                    </div>
                                                    <div>
                                                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wide mb-0.5"><?= $p['label'] ?></p>
                                                        <p class="text-sm text-[#121417] dark:text-gray-300 font-bold leading-tight">
                                                            <?= $metadata[$p['code']] ?>
                                                        </p>
                                                    </div>
                                                </li>
                                            <?php endif; ?>
                                        <?php endif; endforeach; ?>
                                </ul>
                            </div>
                            <!-- Ad Slot -->
                            <div class="uni-ad-slot w-full mt-auto" data-placement="course_list"></div>
                        </div>
                    </div>

                </div>
            </section>
        </main>
    </div>

    <!-- Static AI Interview Promo Section -->
    <div
        class="mt-12 bg-gradient-to-br from-slate-900 to-slate-800 rounded-2xl p-8 md:p-12 relative overflow-hidden shadow-xl border border-slate-700/50">
        <!-- Abstract Background Shapes -->
        <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-primary/20 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-purple-500/20 rounded-full blur-2xl"></div>

        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="flex-1 text-center md:text-left">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/10 border border-white/20 backdrop-blur-sm text-yellow-400 text-xs font-bold uppercase tracking-wider mb-4">
                    <span class="material-symbols-outlined text-[16px]">smart_toy</span>
                    <span>AI Powered</span>
                </div>
                <h2 class="text-3xl font-black text-white mb-4">Ace Your University Interview</h2>
                <div class="text-slate-300 text-lg mb-6 max-w-xl">
                    Practice with our advanced AI interviewer. Get real-time feedback on your answers, tone, and
                    confidence to secure your spot.
                </div>
                <div class="flex flex-col sm:flex-row gap-4 justify-center md:justify-start">
                    <a href="<?= base_url('services/mock-interview') ?>"
                        class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-primary text-white font-bold rounded-xl hover:bg-[#153556] transition-all transform hover:-translate-y-1 shadow-lg shadow-white/10">
                        <span>Start Mock Interview</span>
                        <span class="material-symbols-outlined">arrow_forward</span>
                    </a>
                </div>
            </div>
            <div class="shrink-0 relative">
                <div
                    class="w-24 h-24 md:w-32 md:h-32 bg-gradient-to-tr from-primary to-purple-500 rounded-2xl rotate-6 absolute inset-0 opacity-50 blur-lg">
                </div>
                <div
                    class="w-24 h-24 md:w-32 md:h-32 bg-slate-800 border border-slate-700 rounded-2xl flex items-center justify-center relative shadow-2xl">
                    <span class="material-symbols-outlined text-[48px] md:text-[64px] text-white">mic</span>
                </div>
            </div>
        </div>
    </div>
</div>

<?= view('web/include/footer') ?>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const observerOptions = {
            root: null,
            rootMargin: '-20% 0px -60% 0px', // Activate when section is near top
            threshold: 0
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const id = entry.target.getAttribute('id');
                    updateActiveNav(id);
                }
            });
        }, observerOptions);

        // Observe all sections
        document.querySelectorAll('section[id], div[id="overview"]').forEach((section) => {
            observer.observe(section);
        });

        function updateActiveNav(id) {
            document.querySelectorAll('nav a[href^="#"]').forEach(link => {
                const href = link.getAttribute('href').substring(1);
                if (href === id) {
                    // Active State
                    link.classList.add('bg-primary/10', 'text-primary', 'font-semibold');
                    link.classList.remove('text-[#677583]', 'hover:bg-background-light', 'dark:hover:bg-background-dark', 'hover:text-[#121417]', 'dark:hover:text-white');
                } else {
                    // Inactive State
                    link.classList.remove('bg-primary/10', 'text-primary', 'font-semibold');
                    link.classList.add('text-[#677583]', 'hover:bg-background-light', 'dark:hover:bg-background-dark', 'hover:text-[#121417]', 'dark:hover:text-white');
                }
            });
        }

        // Smooth scroll reset for click
        document.querySelectorAll('nav a[href^="#"]').forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                const id = link.getAttribute('href').substring(1);
                document.getElementById(id).scrollIntoView({ behavior: 'smooth' });
                // Manual update just in case
                updateActiveNav(id);
            });
        });
    });


    async function toggleBookmark(btn, type, id) {
        const iconSpan = btn.querySelector('span');
        const originalIcon = iconSpan.innerText;

        // Optimistic UI update
        const isAdded = originalIcon === 'bookmark_border';
        iconSpan.innerText = isAdded ? 'bookmark' : 'bookmark_border';

        if (isAdded) {
            btn.classList.add('text-secondary');
            btn.classList.remove('text-[#677583]');
            iconSpan.style.fontVariationSettings = "'FILL' 1";
        } else {
            btn.classList.remove('text-secondary');
            btn.classList.add('text-[#677583]');
            iconSpan.style.fontVariationSettings = "'FILL' 0";
        }

        try {
            const response = await fetch('<?= base_url('bookmark/toggle') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
                },
                body: `entity_type=${type}&entity_id=${id}`
            });

            const data = await response.json();

            if (!response.ok) {
                if (response.status === 401) {
                    window.location.href = '<?= base_url('login') ?>';
                    return;
                }
                throw new Error(data.message || 'Error toggling bookmark');
            }

            // Sync with server response just in case
            if (data.icon) {
                iconSpan.innerText = data.icon;
            }

        } catch (error) {
            console.error(error);
            // Revert on error
            iconSpan.innerText = originalIcon;
            alert('Failed to update bookmark. Please try again.');
        }
    }
</script>