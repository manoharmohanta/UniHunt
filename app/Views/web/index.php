<?= view('web/include/header', ['title' => 'UniHunt - Global Education Platform', 'bodyClass' => 'bg-background-light dark:bg-background-dark font-display text-text-main dark:text-white antialiased transition-colors duration-200']) ?>

<!-- Main Content -->
<main class="flex flex-col w-full overflow-hidden">
    <!-- Hero Section -->
    <section class="relative w-full pt-8 pb-16 px-4 sm:px-6 lg:px-8 flex justify-center">
        <div
            class="w-full max-w-[1920px] rounded-3xl overflow-hidden relative min-h-[560px] flex items-center justify-center">
            <!-- Background Image with Overlay -->
            <div class="absolute inset-0 z-0">
                <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/40 to-black/70 z-10"></div>
                <img alt="Students walking on a university campus with historic architecture"
                    class="w-full h-full object-cover"
                    data-alt="Students walking on a university campus with historic architecture"
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuA-904flvnQCnG0RVJspNJGbtHXNZO365KRpjB7Su-PQHJ38RdCYVd7Z09EgRiXDg0Q5NfZS9UnyjRgbCIOYyJByeDelmgDOpFe-Hrg9sTwSFWnSH647YP2uSkEuW2pPBz4gCdzZ7uJjUskvfoasUOowQJzOQ7dcWz5wfCfNBV0spQA37XsppxPRzh0VE_La6b2uDk5gbbM7MveU04fkbGp_1Gfe6mWvKaLTDzHlhkq88rnVXwDI2NyYiTRi9ZrPGwWzv6vO7uf-APo" />
            </div>
            <!-- Content -->
            <div class="relative z-20 w-full max-w-3xl flex flex-col items-center text-center px-4 space-y-8">
                <div class="space-y-4">
                    <span
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/20 backdrop-blur-md border border-white/10 text-xs font-medium text-white tracking-wide uppercase">
                        <span class="w-1.5 h-1.5 rounded-full bg-green-400"></span>
                        Admissions Open for
                        <?= date('Y') ?>
                    </span>
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-white leading-[1.1] tracking-tight">
                        Your Gateway to <br />Global Education
                    </h1>
                    <p class="text-lg md:text-xl text-gray-200 max-w-xl mx-auto font-medium">
                        Discover universities, generate application docs, and prepare for your future with
                        AI-powered guidance.
                    </p>
                </div>
                <!-- Search Bar Component -->
                <form action="<?= base_url('search') ?>" method="get"
                    class="w-full bg-white p-2 rounded-2xl shadow-xl flex flex-col sm:flex-row gap-2 items-center">
                    <div class="flex-1 flex items-center px-4 h-12 w-full">
                        <span class="material-symbols-outlined text-gray-400 mr-3">search</span>
                        <input name="q"
                            class="w-full h-full border-none focus:ring-0 text-text-main placeholder-gray-400 text-base font-medium bg-transparent"
                            placeholder="Search by university, course, or country..." type="text" />
                    </div>
                    <div class="hidden sm:block w-px h-8 bg-gray-200"></div>
                    <button type="submit"
                        class="w-full sm:w-auto h-12 px-8 bg-primary hover:bg-primary-hover text-white font-bold rounded-xl transition-all hover:shadow-lg flex items-center justify-center gap-2 group">
                        Search
                        <span
                            class="material-symbols-outlined text-lg transition-transform group-hover:translate-x-1">arrow_forward</span>
                    </button>
                </form>
                <!-- Quick Tags -->
                <div class="flex flex-wrap justify-center gap-3 text-sm text-white/80">
                    <span>Trending:</span>
                    <?php if (!empty($trendingTags)): ?>
                        <?php foreach ($trendingTags as $index => $tag): ?>
                            <a class="hover:text-white underline decoration-white/30 hover:decoration-white"
                                href="<?= base_url('search?q=' . urlencode($tag)) ?>">
                                <?= esc($tag) ?>
                            </a>
                            <?php if ($index < count($trendingTags) - 1): ?>
                                <span class="w-1 h-1 rounded-full bg-white/40 self-center"></span>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Ad Slot: Home Top -->
    <div class="max-w-7xl mx-auto px-6 mt-4 mb-4">
        <div class="uni-ad-slot" data-placement="home_top"></div>
    </div>

    <!-- Statistics Section -->
    <section class="bg-background-light dark:background-dark py-20">
        <div class="max-w-7xl mx-auto px-6">

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">

                <!-- Card 1 -->
                <div class="bg-white dark:bg-[#121a2f] border border-[#dbe2ef] dark:border-[#1e2a44]
                            rounded-2xl p-8 text-center transition hover:-translate-y-2 hover:border-[#012169]">
                    <h2 class="text-4xl font-extrabold text-primary dark:text-white">
                        <?= number_format($stats['students']) ?>+
                    </h2>
                    <p class="mt-2 text-sm text-[#5b6b8a] dark:text-white">Students Guided</p>
                </div>

                <!-- Card 2 -->
                <div class="bg-white dark:bg-[#121a2f] border border-[#dbe2ef] dark:border-[#1e2a44]
                            rounded-2xl p-8 text-center transition hover:-translate-y-2 hover:border-[#012169]">
                    <h2 class="text-4xl font-extrabold text-primary dark:text-white">
                        <?= number_format($stats['universities']) ?>+
                    </h2>
                    <p class="mt-2 text-sm text-[#5b6b8a] dark:text-white">Partner Universities</p>
                </div>

                <!-- Card 3 -->
                <div class="bg-white dark:bg-[#121a2f] border border-[#dbe2ef] dark:border-[#1e2a44]
                            rounded-2xl p-8 text-center transition hover:-translate-y-2 hover:border-[#012169]">
                    <h2 class="text-4xl font-extrabold text-primary dark:text-white">
                        <?= number_format($stats['courses']) ?>+
                    </h2>
                    <p class="mt-2 text-sm text-[#5b6b8a] dark:text-white">Courses Listed</p>
                </div>

                <!-- Card 4 -->
                <div class="bg-white dark:bg-[#121a2f] border border-[#dbe2ef] dark:border-[#1e2a44]
                            rounded-2xl p-8 text-center transition hover:-translate-y-2 hover:border-[#012169]">
                    <h2 class="text-4xl font-extrabold text-primary dark:text-white">
                        <?= number_format($stats['countries']) ?>+
                    </h2>
                    <p class="mt-2 text-sm text-[#5b6b8a] dark:text-white">Countries Covered</p>
                </div>

            </div>

        </div>
    </section>
    <!-- Study by Country Section -->
    <section class="py-16 px-4 sm:px-6 lg:px-8 bg-white dark:bg-card-dark">
        <div class="max-w-[1280px] mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-text-main dark:text-white tracking-tight">Explore by Country</h2>
                <p class="mt-3 text-text-muted dark:text-gray-400 text-lg">Pick your dream destination and find the
                    perfect university.</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
                <?php foreach ($countries as $country): ?>
                    <a href="<?= base_url('universities/' . $country['slug']) ?>"
                        class="group relative flex flex-col items-center p-6 bg-background-light dark:bg-background-dark border border-gray-100 dark:border-gray-800 rounded-3xl transition-all duration-300 hover:shadow-xl hover:border-primary/30 hover:-translate-y-2">
                        <div
                            class="w-16 h-16 rounded-2xl bg-white dark:bg-gray-800 shadow-sm border border-gray-100 dark:border-gray-700 flex items-center justify-center mb-4 transition-transform group-hover:scale-110 overflow-hidden relative">
                            <?php if (!empty($country['code'])):
                                $code = strtolower($country['code']);
                                // Map common 3-letter or non-standard codes to 2-letter ISO codes
                                $flagMap = [
                                    'usa' => 'us',
                                    'uk' => 'gb',
                                    'gbr' => 'gb',
                                    'can' => 'ca',
                                    'aus' => 'au',
                                    'ind' => 'in',
                                    'deu' => 'de',
                                    'fra' => 'fr',
                                    'irl' => 'ie',
                                    'nzl' => 'nz',
                                    'sgp' => 'sg',
                                    'are' => 'ae', // UAE
                                ];
                                $flagCode = $flagMap[$code] ?? $code;
                                ?>
                                <img src="https://flagcdn.com/w80/<?= $flagCode ?>.png" alt="<?= esc($country['name']) ?> flag"
                                    class="w-full h-full object-cover opacity-90 group-hover:opacity-100 transition-opacity"
                                    loading="lazy">
                            <?php else: ?>
                                <span
                                    class="material-symbols-outlined text-4xl text-primary transition-colors group-hover:text-primary-hover">public</span>
                            <?php endif; ?>
                        </div>
                        <h3
                            class="text-base font-bold text-text-main dark:text-white mb-1 group-hover:text-primary transition-colors">
                            <?= esc($country['name']) ?>
                        </h3>
                        <p class="text-xs font-semibold text-text-muted dark:text-gray-500">
                            <?= $country['university_count'] ?> Universities
                        </p>

                        <div class="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity">
                            <span class="material-symbols-outlined text-primary text-sm">arrow_forward</span>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- AI Tools Section -->
    <section id="ai-tools"
        class="py-16 px-4 sm:px-6 lg:px-8 bg-white dark:bg-card-dark border-y border-gray-100 dark:border-gray-800">
        <div class="max-w-[960px] mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-text-main dark:text-white tracking-tight">AI-Powered Application
                    Tools</h2>
                <p class="mt-3 text-text-muted dark:text-gray-400 text-lg">Streamline your application process with
                    our intelligent assistants.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- SOP Generator -->
                <div
                    class="group relative p-6 bg-background-light dark:bg-background-dark border border-gray-200 dark:border-gray-700 rounded-2xl transition-all duration-300 hover:shadow-soft hover:border-primary/50 hover:-translate-y-1">
                    <div
                        class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center mb-4 transition-colors group-hover:bg-primary group-hover:text-white">
                        <span class="material-symbols-outlined text-2xl">note_add</span>
                    </div>
                    <h3 class="text-lg font-bold text-text-main dark:text-white mb-2">SOP Generator</h3>
                    <p class="text-sm text-text-muted dark:text-gray-400 leading-relaxed">Create compelling
                        Statements of Purpose tailored to your profile with AI assistance.</p>
                    <div
                        class="mt-4 flex items-center text-primary text-sm font-bold opacity-0 group-hover:opacity-100 transition-opacity transform translate-x-[-10px] group-hover:translate-x-0">
                        <a href="<?= base_url('ai-tools/sop-generator-form') ?>">Try Now <span
                                class="material-symbols-outlined text-base ml-1">arrow_forward</span></a>
                    </div>
                </div>
                <!-- Resume Builder -->
                <div
                    class="group relative p-6 bg-background-light dark:bg-background-dark border border-gray-200 dark:border-gray-700 rounded-2xl transition-all duration-300 hover:shadow-soft hover:border-primary/50 hover:-translate-y-1">
                    <div
                        class="w-12 h-12 rounded-xl bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 flex items-center justify-center mb-4 transition-colors group-hover:bg-primary group-hover:text-white">
                        <span class="material-symbols-outlined text-2xl">badge</span>
                    </div>
                    <h3 class="text-lg font-bold text-text-main dark:text-white mb-2">Resume Builder</h3>
                    <p class="text-sm text-text-muted dark:text-gray-400 leading-relaxed">Build a professional,
                        ATS-friendly resume formatted specifically for admission boards.</p>
                    <div
                        class="mt-4 flex items-center text-primary text-sm font-bold opacity-0 group-hover:opacity-100 transition-opacity transform translate-x-[-10px] group-hover:translate-x-0">
                        <a href="<?= base_url('ai-tools/resume-builder-form') ?>">Build Now <span
                                class="material-symbols-outlined text-base ml-1">arrow_forward</span></a>
                    </div>
                </div>
                <!-- Visa Mock Interview -->
                <div
                    class="group relative p-6 bg-background-light dark:bg-background-dark border border-gray-200 dark:border-gray-700 rounded-2xl transition-all duration-300 hover:shadow-soft hover:border-primary/50 hover:-translate-y-1">
                    <div
                        class="w-12 h-12 rounded-xl bg-orange-100 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400 flex items-center justify-center mb-4 transition-colors group-hover:bg-primary group-hover:text-white">
                        <span class="material-symbols-outlined text-2xl">video_camera_front</span>
                    </div>
                    <h3 class="text-lg font-bold text-text-main dark:text-white mb-2">Visa Mock Interview</h3>
                    <p class="text-sm text-text-muted dark:text-gray-400 leading-relaxed">Practice confidently for
                        your visa interview with our interactive AI interviewer.</p>
                    <div
                        class="mt-4 flex items-center text-primary text-sm font-bold opacity-0 group-hover:opacity-100 transition-opacity transform translate-x-[-10px] group-hover:translate-x-0">
                        <a href="<?= base_url('ai-tools/mock-interview') ?>">Start Practice <span
                                class="material-symbols-outlined text-base ml-1">arrow_forward</span></a>
                    </div>
                </div>
                <!-- AI University Finder -->
                <div
                    class="group relative p-6 bg-background-light dark:bg-background-dark border border-gray-200 dark:border-gray-700 rounded-2xl transition-all duration-300 hover:shadow-soft hover:border-primary/50 hover:-translate-y-1">
                    <div
                        class="w-12 h-12 rounded-xl bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 flex items-center justify-center mb-4 group-hover:bg-primary group-hover:text-white">
                        <span class="material-symbols-outlined text-2xl">school</span>
                    </div>
                    <h3 class="text-lg font-bold text-text-main dark:text-white mb-2">
                        AI University Finder
                    </h3>
                    <p class="text-sm text-text-muted dark:text-gray-400 leading-relaxed">
                        Discover the best universities and courses based on your academic profile, budget, and
                        goals.
                    </p>
                    <div
                        class="mt-4 flex items-center text-primary text-sm font-bold opacity-0 group-hover:opacity-100 transition-all translate-x-[-10px] group-hover:translate-x-0">
                        <a href="<?= base_url('ai-tools/university-counsellor') ?>">Find Universities <span
                                class="material-symbols-outlined text-base ml-1">arrow_forward</span></a>
                    </div>
                </div>





                <!-- LOR Generator -->
                <div
                    class="group relative p-6 bg-background-light dark:bg-background-dark border border-gray-200 dark:border-gray-700 rounded-2xl transition-all duration-300 hover:shadow-soft hover:border-primary/50 hover:-translate-y-1">
                    <div
                        class="w-12 h-12 rounded-xl bg-pink-100 dark:bg-pink-900/30 text-pink-600 dark:text-pink-400 flex items-center justify-center mb-4 group-hover:bg-primary group-hover:text-white">
                        <span class="material-symbols-outlined text-2xl">description</span>
                    </div>
                    <h3 class="text-lg font-bold text-text-main dark:text-white mb-2">
                        LOR Generator
                    </h3>
                    <p class="text-sm text-text-muted dark:text-gray-400 leading-relaxed">
                        Generate strong academic or professional Letters of Recommendation with AI assistance.
                    </p>
                    <div
                        class="mt-4 flex items-center text-primary text-sm font-bold opacity-0 group-hover:opacity-100 transition-all translate-x-[-10px] group-hover:translate-x-0">
                        <a href="<?= base_url('ai-tools/lor-generator-form') ?>">Generate LOR <span
                                class="material-symbols-outlined text-base ml-1">arrow_forward</span></a>
                    </div>
                </div>

                <!-- Visa Document Checker -->
                <div
                    class="group relative p-6 bg-background-light dark:bg-background-dark border border-gray-200 dark:border-gray-700 rounded-2xl transition-all duration-300 hover:shadow-soft hover:border-primary/50 hover:-translate-y-1">
                    <div
                        class="w-12 h-12 rounded-xl bg-teal-100 dark:bg-teal-900/30 text-teal-600 dark:text-teal-400 flex items-center justify-center mb-4 group-hover:bg-primary group-hover:text-white">
                        <span class="material-symbols-outlined text-2xl">verified</span>
                    </div>
                    <h3 class="text-lg font-bold text-text-main dark:text-white mb-2">
                        Visa Document Checker
                    </h3>
                    <p class="text-sm text-text-muted dark:text-gray-400 leading-relaxed">
                        AI scans your visa documents to detect missing files and risk factors.
                    </p>
                    <div
                        class="mt-4 flex items-center text-primary text-sm font-bold opacity-0 group-hover:opacity-100 transition-all translate-x-[-10px] group-hover:translate-x-0">
                        <a href="<?= base_url('ai-tools/visa-checker-form') ?>">Check Documents <span
                                class="material-symbols-outlined text-base ml-1">arrow_forward</span></a>
                    </div>
                </div>

                <!-- Career Outcome Predictor -->
                <div
                    class="group relative p-6 bg-background-light dark:bg-background-dark border border-gray-200 dark:border-gray-700 rounded-2xl transition-all duration-300 hover:shadow-soft hover:border-primary/50 hover:-translate-y-1">
                    <div
                        class="w-12 h-12 rounded-xl bg-cyan-100 dark:bg-cyan-900/30 text-cyan-600 dark:text-cyan-400 flex items-center justify-center mb-4 group-hover:bg-primary group-hover:text-white">
                        <span class="material-symbols-outlined text-2xl">work</span>
                    </div>
                    <h3 class="text-lg font-bold text-text-main dark:text-white mb-2">
                        Career Outcome AI
                    </h3>
                    <p class="text-sm text-text-muted dark:text-gray-400 leading-relaxed">
                        Predict job roles, salaries, and PR opportunities after completing your course.
                    </p>
                    <div
                        class="mt-4 flex items-center text-primary text-sm font-bold opacity-0 group-hover:opacity-100 transition-all translate-x-[-10px] group-hover:translate-x-0">
                        <a href="<?= base_url('ai-tools/career-predictor-form') ?>">View Outcomes <span
                                class="material-symbols-outlined text-base ml-1">arrow_forward</span></a>
                    </div>
                </div>

                <!-- IELTS Mock Test -->
                <div
                    class="group relative p-6 bg-background-light dark:bg-background-dark border border-gray-200 dark:border-gray-700 rounded-2xl transition-all duration-300 hover:shadow-soft hover:border-primary/50 hover:-translate-y-1">
                    <div
                        class="w-12 h-12 rounded-xl bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 flex items-center justify-center mb-4 group-hover:bg-primary group-hover:text-white">
                        <span class="material-symbols-outlined text-2xl">language</span>
                    </div>
                    <h3 class="text-lg font-bold text-text-main dark:text-white mb-2">IELTS Mock Test</h3>
                    <p class="text-sm text-text-muted dark:text-gray-400 leading-relaxed">Full-length AI-generated IELTS
                        practice tests with instant grading for Reading, Writing, and Speaking.</p>
                    <div
                        class="mt-4 flex items-center text-primary text-sm font-bold opacity-0 group-hover:opacity-100 transition-all translate-x-[-10px] group-hover:translate-x-0">
                        <a href="<?= base_url('ai-tools/ielts') ?>">Start Test <span
                                class="material-symbols-outlined text-base ml-1">arrow_forward</span></a>
                    </div>
                </div>

                <!-- PTE Mock Test -->
                <div
                    class="group relative p-6 bg-background-light dark:bg-background-dark border border-gray-200 dark:border-gray-700 rounded-2xl transition-all duration-300 hover:shadow-soft hover:border-primary/50 hover:-translate-y-1">
                    <div
                        class="w-12 h-12 rounded-xl bg-orange-100 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400 flex items-center justify-center mb-4 group-hover:bg-primary group-hover:text-white">
                        <span class="material-symbols-outlined text-2xl">record_voice_over</span>
                    </div>
                    <h3 class="text-lg font-bold text-text-main dark:text-white mb-2">PTE Mock Test</h3>
                    <p class="text-sm text-text-muted dark:text-gray-400 leading-relaxed">AI-powered PTE Academic
                        practice with automated scoring for speaking and writing tasks.</p>
                    <div
                        class="mt-4 flex items-center text-primary text-sm font-bold opacity-0 group-hover:opacity-100 transition-all translate-x-[-10px] group-hover:translate-x-0">
                        <a href="<?= base_url('ai-tools/pte') ?>">Start Test <span
                                class="material-symbols-outlined text-base ml-1">arrow_forward</span></a>
                    </div>
                </div>



                <!-- GRE Mock Test -->
                <div
                    class="group relative p-6 bg-background-light dark:bg-background-dark border border-gray-200 dark:border-gray-700 rounded-2xl transition-all duration-300 hover:shadow-soft hover:border-primary/50 hover:-translate-y-1">
                    <div
                        class="w-12 h-12 rounded-xl bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 flex items-center justify-center mb-4 group-hover:bg-primary group-hover:text-white">
                        <span class="material-symbols-outlined text-2xl">calculate</span>
                    </div>
                    <h3 class="text-lg font-bold text-text-main dark:text-white mb-2">GRE Mock Test</h3>
                    <p class="text-sm text-text-muted dark:text-gray-400 leading-relaxed">Master GRE Verbal and Quant
                        sections with AI-generated problems and detailed explanations.</p>
                    <div
                        class="mt-4 flex items-center text-primary text-sm font-bold opacity-0 group-hover:opacity-100 transition-all translate-x-[-10px] group-hover:translate-x-0">
                        <a href="<?= base_url('ai-tools/gre') ?>">Start Test <span
                                class="material-symbols-outlined text-base ml-1">arrow_forward</span></a>
                    </div>
                </div>

                <!-- GMAT Mock Test -->
                <div
                    class="group relative p-6 bg-background-light dark:bg-background-dark border border-gray-200 dark:border-gray-700 rounded-2xl transition-all duration-300 hover:shadow-soft hover:border-primary/50 hover:-translate-y-1">
                    <div
                        class="w-12 h-12 rounded-xl bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center mb-4 group-hover:bg-primary group-hover:text-white">
                        <span class="material-symbols-outlined text-2xl">analytics</span>
                    </div>
                    <h3 class="text-lg font-bold text-text-main dark:text-white mb-2">GMAT Mock Test</h3>
                    <p class="text-sm text-text-muted dark:text-gray-400 leading-relaxed">Prepare for GMAT Focus Edition
                        with AI-adaptive questions for Data Insights and Verbal Reasoning.</p>
                    <div
                        class="mt-4 flex items-center text-primary text-sm font-bold opacity-0 group-hover:opacity-100 transition-all translate-x-[-10px] group-hover:translate-x-0">
                        <a href="<?= base_url('ai-tools/gmat') ?>">Start Test <span
                                class="material-symbols-outlined text-base ml-1">arrow_forward</span></a>
                    </div>
                </div>

                <!-- SAT Mock Test -->
                <div
                    class="group relative p-6 bg-background-light dark:bg-background-dark border border-gray-200 dark:border-gray-700 rounded-2xl transition-all duration-300 hover:shadow-soft hover:border-primary/50 hover:-translate-y-1">
                    <div
                        class="w-12 h-12 rounded-xl bg-pink-100 dark:bg-pink-900/30 text-pink-600 dark:text-pink-400 flex items-center justify-center mb-4 group-hover:bg-primary group-hover:text-white">
                        <span class="material-symbols-outlined text-2xl">edit_note</span>
                    </div>
                    <h3 class="text-lg font-bold text-text-main dark:text-white mb-2">SAT Mock Test</h3>
                    <p class="text-sm text-text-muted dark:text-gray-400 leading-relaxed">Ace the Digital SAT with
                        AI-curated Reading, Writing, and Math practice modules.</p>
                    <div
                        class="mt-4 flex items-center text-primary text-sm font-bold opacity-0 group-hover:opacity-100 transition-all translate-x-[-10px] group-hover:translate-x-0">
                        <a href="<?= base_url('ai-tools/sat') ?>">Start Test <span
                                class="material-symbols-outlined text-base ml-1">arrow_forward</span></a>
                    </div>
                </div>
            </div>

            <div class="mt-12 text-center">
                <a href="<?= base_url('ai-tools') ?>"
                    class="inline-flex items-center justify-center gap-2 px-8 py-3 bg-primary hover:bg-primary-hover text-white font-bold rounded-xl shadow-lg hover:shadow-xl transition-all">
                    View All AI Tools <span class="material-symbols-outlined">arrow_forward</span>
                </a>
            </div>
        </div>
    </section>
    <!-- Featured Universities Section -->
    <section class="py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-[1280px] mx-auto">
            <div class="flex flex-col sm:flex-row justify-between items-end mb-10 gap-4">
                <div>
                    <h2 class="text-3xl font-bold text-text-main dark:text-white tracking-tight">Top Rated
                        Institutions</h2>
                    <p class="mt-2 text-text-muted dark:text-gray-400">Explore universities with high acceptance
                        rates for international students.</p>
                </div>
                <a class="hidden sm:flex items-center text-primary font-bold hover:text-primary-hover"
                    href="<?= base_url('universities') ?>">
                    View all universities <span class="material-symbols-outlined ml-1">arrow_right_alt</span>
                </a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php if (!empty($topUniversities)): ?>
                    <?php foreach ($topUniversities as $uni): ?>
                        <div
                            class="group bg-card-light dark:bg-card-dark rounded-2xl overflow-hidden shadow-card hover:shadow-xl transition-all duration-300 border border-transparent hover:border-gray-200 dark:hover:border-gray-700 flex flex-col h-full">
                            <div class="relative h-40 overflow-hidden">
                                <?php
                                $imgUrl = 'https://placehold.co/600x400?text=' . urlencode($uni['name']);
                                if (!empty($uni['gallery_image'])) {
                                    $imgUrl = (stripos($uni['gallery_image'], 'http') === 0) ? $uni['gallery_image'] : base_url($uni['gallery_image']);
                                } elseif (!empty($uni['image'])) {
                                    $imgUrl = (stripos($uni['image'], 'http') === 0) ? $uni['image'] : base_url($uni['image']);
                                }
                                ?>
                                <img alt="<?= esc($uni['name']) ?>"
                                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                    src="<?= $imgUrl ?>" />
                                <?php if ($uni['ranking']): ?>
                                    <div
                                        class="absolute top-3 right-3 bg-white/95 backdrop-blur-sm px-2 py-1 rounded-md text-xs font-bold shadow-sm text-text-main flex items-center gap-1">
                                        <span class="material-symbols-outlined text-yellow-500 text-sm">trophy</span>
                                        #<?= $uni['ranking'] ?> QS Rank
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="p-5 flex flex-col flex-1">
                                <div class="flex items-start justify-between gap-3 mb-3">
                                    <div
                                        class="w-12 h-12 rounded-lg bg-gray-50 border border-gray-100 flex items-center justify-center p-1 shrink-0 -mt-10 shadow-md z-10 bg-white">
                                        <span class="material-symbols-outlined text-3xl text-primary">school</span>
                                    </div>
                                    <?php if (!empty($uni['type'])): ?>
                                        <span
                                            class="text-xs font-medium text-text-muted bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded"><?= ucfirst($uni['type']) ?></span>
                                    <?php endif; ?>
                                </div>
                                <?php 
                                    $nameLen = strlen($uni['name']);
                                    $fontSize = 'text-lg';
                                    if ($nameLen > 45) $fontSize = 'text-sm';
                                    elseif ($nameLen > 30) $fontSize = 'text-base';
                                ?>
                                <h3
                                    class="<?= $fontSize ?> font-bold text-text-main dark:text-white mb-1 leading-tight group-hover:text-primary transition-colors line-clamp-2">
                                    <?= esc($uni['name']) ?>
                                </h3>
                                <div class="flex items-center text-text-muted text-sm mb-4">
                                    <span class="material-symbols-outlined text-base mr-1">location_on</span>
                                    <?= esc($uni['state_name'] ?? '') ?>
                                    <?= (isset($uni['state_name']) && isset($uni['country_name'])) ? ', ' : '' ?>
                                    <?= esc($uni['country_name']) ?>
                                </div>
                                <div
                                    class="mt-auto pt-4 border-t border-gray-100 dark:border-gray-700 flex justify-between items-center">
                                    <span class="text-xs font-semibold text-text-muted">Courses:
                                        <?= number_format($uni['course_count']) ?>+</span>
                                    <a href="<?= base_url('universities/' . $uni['country_slug'] . '/' . $uni['slug']) ?>"
                                        class="text-primary hover:text-primary-hover font-bold text-sm">View
                                        Profile</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <div class="mt-8 flex justify-center sm:hidden">
                <a href="<?= base_url('universities') ?>"
                    class="w-full px-6 py-3 border border-gray-200 dark:border-gray-700 rounded-xl text-sm font-bold text-text-main dark:text-white hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                    View all universities
                </a>
            </div>
        </div>
    </section>
    <!-- Popular Courses Section -->
    <section class="py-16 px-4 sm:px-6 lg:px-8 bg-background-light dark:bg-background-dark">
        <div class="max-w-[1280px] mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-text-main dark:text-white">
                    Browse Popular Courses Worldwide
                </h2>
                <p class="mt-2 text-text-muted dark:text-gray-400">
                    Explore high-demand courses chosen by international students
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <?php if (!empty($popularCourses)): ?>
                    <?php foreach ($popularCourses as $course): ?>
                        <div
                            class="p-6 bg-card-light dark:bg-card-dark rounded-2xl shadow-card hover:shadow-xl transition flex flex-col h-full border border-gray-100 dark:border-gray-800">
                            <h3 class="text-lg font-bold mb-2 text-text-main dark:text-white line-clamp-2"
                                title="<?= esc($course['name']) ?>">
                                <?= esc($course['name']) ?>
                            </h3>
                            <p class="text-xs font-semibold text-primary mb-1 uppercase tracking-wider">
                                <?= esc($course['level']) ?>
                            </p>
                            <p class="text-sm text-text-muted mb-4 flex-grow">
                                at <?= esc($course['uni_name']) ?>, <?= esc($course['country_name']) ?>
                            </p>
                            <div
                                class="flex justify-between items-center text-xs font-semibold text-text-muted mt-auto pt-4 border-t border-gray-100 dark:border-gray-700">
                                <span class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[16px]">schedule</span>
                                    <?= $course['duration_months'] ?> Months
                                </span>
                                <a href="<?= base_url('universities/' . $course['country_slug'] . '/' . $course['uni_slug']) ?>"
                                    class="text-green-600 hover:text-green-700 flex items-center gap-1">
                                    View <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <!-- Blog Section -->
    <section
        class="py-16 px-4 sm:px-6 lg:px-8 bg-white dark:bg-card-dark border-t border-gray-100 dark:border-gray-800">
        <div class="max-w-[1280px] mx-auto">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-text-main dark:text-white">
                    Latest Study Abroad Insights
                </h2>
                <p class="mt-2 text-text-muted dark:text-gray-400">
                    Expert tips, guides, and admission updates
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Blog Cards -->
                <?php if (!empty($recentBlogs)): ?>
                    <?php foreach ($recentBlogs as $blog): ?>
                        <div
                            class="bg-background-light dark:bg-background-dark rounded-2xl overflow-hidden shadow-card hover:shadow-xl transition flex flex-col h-full">
                            <?php
                            $blogImg = 'https://placehold.co/600x400?text=UniHunt+Blog';
                            if (!empty($blog['uni_gallery_image'])) {
                                $blogImg = (stripos($blog['uni_gallery_image'], 'http') === 0) ? $blog['uni_gallery_image'] : base_url($blog['uni_gallery_image']);
                            } elseif (!empty($blog['featured_image'])) {
                                $blogImg = (stripos($blog['featured_image'], 'http') === 0) ? $blog['featured_image'] : base_url($blog['featured_image']);
                            }
                            ?>
                            <img src="<?= $blogImg ?>" class="h-40 w-full object-cover" alt="<?= esc($blog['title']) ?>">
                            <div class="p-5 flex flex-col flex-1">
                                <span class="text-xs font-bold text-primary uppercase mb-2">
                                    <?= !empty($blog['category']) ? esc(ucfirst($blog['category'])) : 'Guide' ?>
                                </span>
                                <h3 class="font-bold text-lg leading-tight mb-2 line-clamp-2">
                                    <?= esc($blog['title']) ?>
                                </h3>
                                <p class="text-sm text-text-muted mb-4 line-clamp-2 flex-grow">
                                    <?= esc(strip_tags($blog['meta_description'] ?? 'Read our latest guide')) ?>
                                </p>
                                <a href="<?= base_url('blog/' . strtolower(($blog['category'] ?? 'general')) . '/' . $blog['slug']) ?>"
                                    class="mt-auto text-sm font-bold text-primary hover:text-primary-hover flex items-center gap-1">
                                    Read More <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="text-text-muted col-span-3 text-center">No blog posts found.</p>
                <?php endif; ?>
            </div>

            <div class="mt-10 text-center">
                <a href="<?= base_url('blog') ?>"
                    class="inline-flex items-center justify-center gap-2 px-6 py-3 font-bold text-primary bg-primary/10 hover:bg-primary/20 rounded-xl transition-all">
                    View all Blogs <span class="material-symbols-outlined">arrow_forward</span>
                </a>
            </div>
        </div>
    </section>
    <!-- Newsletter / CTA -->
    <section class="py-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-[1280px] mx-auto bg-primary rounded-3xl p-8 md:p-12 overflow-hidden relative">
            <!-- Abstract decorative circles -->
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white/10 rounded-full blur-3xl">
            </div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-64 h-64 bg-white/10 rounded-full blur-3xl">
            </div>
            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
                <div class="flex-1 text-center md:text-left">
                    <h2 class="text-3xl font-black text-white mb-3">Ready to start your journey?
                    </h2>
                    <p class="text-blue-50 text-lg max-w-xl">Join over 50,000 students finding their
                        dream
                        universities and scholarships on UniHunt today.</p>
                </div>
                <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
                    <?php if (session()->get('isLoggedIn')): ?>
                        <a href="<?= base_url('ai-tools/mock-interview') ?>"
                            class="px-8 py-3.5 bg-white text-primary font-bold rounded-xl shadow-lg hover:shadow-xl hover:bg-gray-50 transition-all transform hover:-translate-y-0.5 text-center">
                            AI Mock Interview
                        </a>
                        <a href="<?= base_url('ai-tools') ?>"
                            class="px-8 py-3.5 bg-primary-hover border border-white/20 text-white font-bold rounded-xl hover:bg-black/20 transition-all text-center">
                            Explore AI Tools
                        </a>
                    <?php else: ?>
                        <a href="<?= base_url('login') ?>"
                            class="px-8 py-3.5 bg-white text-primary font-bold rounded-xl shadow-lg hover:shadow-xl hover:bg-gray-50 transition-all transform hover:-translate-y-0.5 text-center">
                            Create Free Account
                        </a>
                        <a href="<?= base_url('ai-tools') ?>"
                            class="px-8 py-3.5 bg-primary-hover border border-white/20 text-white font-bold rounded-xl hover:bg-black/20 transition-all text-center">
                            Explore AI Tools
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</main>
<!-- Footer -->

<?= view('web/include/footer') ?>