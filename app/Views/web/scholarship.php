<?= view('web/include/header', ['title' => 'Scholarship Finder Search', 'bodyClass' => 'bg-background-light dark:bg-background-dark font-display text-[#111816] dark:text-gray-100 min-h-screen flex flex-col overflow-x-hidden']) ?>

    <!-- Main Content Wrapper -->
    <main class="flex-1 w-full max-w-7xl mx-auto px-4 md:px-6 py-8">
        <!-- Hero & Filters Section -->
        <section class="mb-10">
            <div class="flex flex-col md:flex-row justify-between items-end gap-6 mb-8">
                <div class="max-w-2xl">
                    <h1 class="text-4xl md:text-5xl font-black tracking-tight text-[#111816] dark:text-white mb-3">
                        Find Your <span class="text-primary">Funding</span>
                    </h1>
                    <p class="text-gray-500 dark:text-gray-400 text-lg">
                        Browse 10,000+ verified scholarships for international students.
                    </p>
                </div>
                <!-- AI Match Button (Prominent) -->
                <a href="<?= base_url('ai-tools/form') ?>"
                    class="hidden md:flex group relative overflow-hidden rounded-xl bg-gradient-to-br from-primary to-[#0d9472] px-6 py-3.5 text-white shadow-lg shadow-primary/20 transition-all hover:scale-[1.02] hover:shadow-xl">
                    <div class="absolute inset-0 bg-white/10 opacity-0 group-hover:opacity-100 transition-opacity">
                    </div>
                    <div class="flex items-center gap-3 relative z-10">
                        <span class="material-symbols-outlined text-[22px] animate-pulse">auto_awesome</span>
                        <div class="text-left">
                            <p class="text-xs font-medium text-white/80 uppercase tracking-wider">AI Powered</p>
                            <p class="text-base font-bold leading-none">Match Me with AI</p>
                        </div>
                    </div>
                </a>
            </div>
            <!-- Filter Bar -->
            <div
                class="bg-surface-light dark:bg-surface-dark p-4 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 flex flex-col lg:flex-row gap-4 items-center">
                <!-- Search Input -->
                <div class="relative flex-1 w-full">
                    <span
                        class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">search</span>
                    <input
                        class="w-full h-12 pl-12 pr-4 rounded-xl border-gray-200 dark:border-gray-600 bg-white dark:bg-[#33363d] focus:border-primary focus:ring-primary text-sm font-medium"
                        placeholder="Search by keyword, sponsor, or field..." type="text" />
                </div>
                <!-- Dropdowns -->
                <div class="grid grid-cols-2 md:grid-cols-3 gap-3 w-full lg:w-auto">
                    <div class="relative">
                        <select
                            class="appearance-none w-full h-12 px-4 pr-10 rounded-xl border-gray-200 dark:border-gray-600 bg-white dark:bg-[#33363d] text-sm font-medium focus:border-primary focus:ring-0 text-gray-700 dark:text-gray-200 cursor-pointer">
                            <option disabled="" selected="" value="">Scholarship Type</option>
                            <option value="full">Full Ride</option>
                            <option value="partial">Partial Funding</option>
                            <option value="grant">Research Grant</option>
                        </select>
                        <span
                            class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-lg">expand_more</span>
                    </div>
                    <div class="relative">
                        <select
                            class="appearance-none w-full h-12 px-4 pr-10 rounded-xl border-gray-200 dark:border-gray-600 bg-white dark:bg-[#33363d] text-sm font-medium focus:border-primary focus:ring-0 text-gray-700 dark:text-gray-200 cursor-pointer">
                            <option disabled="" selected="" value="">Degree Level</option>
                            <option value="bachelors">Bachelors</option>
                            <option value="masters">Masters</option>
                            <option value="phd">PhD</option>
                        </select>
                        <span
                            class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-lg">expand_more</span>
                    </div>
                    <div class="relative col-span-2 md:col-span-1">
                        <select
                            class="appearance-none w-full h-12 px-4 pr-10 rounded-xl border-gray-200 dark:border-gray-600 bg-white dark:bg-[#33363d] text-sm font-medium focus:border-primary focus:ring-0 text-gray-700 dark:text-gray-200 cursor-pointer">
                            <option disabled="" selected="" value="">Origin Country</option>
                            <option value="india">India</option>
                            <option value="nigeria">Nigeria</option>
                            <option value="brazil">Brazil</option>
                            <option value="vietnam">Vietnam</option>
                        </select>
                        <span
                            class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none text-lg">expand_more</span>
                    </div>
                </div>
                <!-- Mobile AI Button -->
                <a href="<?= base_url('ai-tools/form') ?>"
                    class="flex md:hidden w-full items-center justify-center gap-2 h-12 rounded-xl bg-primary text-white font-bold">
                    <span class="material-symbols-outlined">auto_awesome</span>
                    Match Me
                </a>
            </div>
        </section>
        <!-- Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            <!-- Left Column: Scholarship List (Span 8) -->
            <div class="lg:col-span-8 flex flex-col gap-5">
                <!-- Results Header -->
                <div class="flex justify-between items-center px-1">
                    <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">Showing 42 Results</p>
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-500">Sort by:</span>
                        <button class="text-sm font-bold text-[#111816] dark:text-white flex items-center gap-1">
                            Relevance <span class="material-symbols-outlined text-base">sort</span>
                        </button>
                    </div>
                </div>
                <!-- Card 1: Featured/High Value -->
                <article
                    class="bg-surface-light dark:bg-surface-dark rounded-xl p-6 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow relative overflow-hidden group">
                    <div
                        class="absolute top-0 right-0 bg-accent-green/10 text-accent-green px-3 py-1 rounded-bl-xl text-xs font-bold uppercase tracking-wider">
                        High Match
                    </div>
                    <div class="flex flex-col md:flex-row gap-6">
                        <!-- Logo -->
                        <div class="flex-shrink-0">
                            <div
                                class="size-16 rounded-lg bg-gray-100 dark:bg-gray-800 flex items-center justify-center border border-gray-200 dark:border-gray-600">
                                <img alt="Fulbright Logo" class="w-10 h-10 object-contain"
                                    data-alt="Fulbright Scholarship program logo blue abstract"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuA_zqkJndbHb8RWd6Wt36Ej5ujpwSJzt9BssVrC9DKPzRNNa9MsKsXEs1OrszbLWUH6mnPlrgWAcWifadeEXHL332_JXB2ITp6hEXkt6HIX0_FORFCTa4UPAmkgaNyq4x7M8w0M1DHYIoIT_YnWnHwozzMJadDlslSloT84ONeto_eJwocbt-4B2xlf97sdHaX85l2kSbPoYm-IifZ2HWxkn7fQ2cGIKjEEsJEakQH63TCNpNVJaniLLrnnD5gKI4lXwzlGjwPQd5OV" />
                            </div>
                        </div>
                        <!-- Content -->
                        <div class="flex-1">
                            <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-2 mb-2">
                                <div>
                                    <h3
                                        class="text-xl font-bold text-[#111816] dark:text-white group-hover:text-primary transition-colors cursor-pointer">
                                        Fulbright Foreign Student Program</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">US Dept. of State â€¢ USA</p>
                                </div>
                                <div class="text-right md:text-right">
                                    <p class="text-2xl font-black text-accent-green tracking-tight">Fully Funded</p>
                                    <p class="text-xs text-gray-400">Tuition + Stipend + Travel</p>
                                </div>
                            </div>
                            <div class="flex flex-wrap gap-2 my-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300">
                                    Masters &amp; PhD
                                </span>
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300">
                                    All Disciplines
                                </span>
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300">
                                    <span class="material-symbols-outlined text-[14px] mr-1">public</span> International
                                </span>
                            </div>
                            <div
                                class="flex flex-col sm:flex-row items-start sm:items-center justify-between pt-4 border-t border-gray-100 dark:border-gray-700 gap-4">
                                <div class="flex items-center gap-2 text-red-500 text-sm font-medium">
                                    <span class="material-symbols-outlined text-[18px]">alarm</span>
                                    <span>Deadline: Oct 15, 2023</span>
                                </div>
                                <div class="flex gap-3 w-full sm:w-auto">
                                    <button
                                        class="flex-1 sm:flex-none px-4 py-2 rounded-lg border border-gray-200 dark:border-gray-600 text-[#111816] dark:text-white font-semibold hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors text-sm">Save</button>
                                    <button
                                        class="flex-1 sm:flex-none px-6 py-2 rounded-lg bg-primary hover:bg-primary-dark text-white font-bold shadow-sm transition-colors text-sm">Apply
                                        Now</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
                <!-- Card 2 -->
                <article
                    class="bg-surface-light dark:bg-surface-dark rounded-xl p-6 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow group">
                    <div class="flex flex-col md:flex-row gap-6">
                        <!-- Logo -->
                        <div class="flex-shrink-0">
                            <div
                                class="size-16 rounded-lg bg-white dark:bg-gray-800 flex items-center justify-center border border-gray-200 dark:border-gray-600 overflow-hidden p-2">
                                <img alt="Chevening Logo" class="w-full h-full object-contain"
                                    data-alt="Chevening logo with red C and globe"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuBpI4TJneQLnEC0Ur3PX1Chp5oapLwkPuenhYiLduZTnh8gKwjMOsWzFiZND0XZDwRkYkXEFkPIywg0hLeVTTzHyCR2v6y8Z-2QTGM5Q5u60kjlWjo400DGW1CqfNYk5B8SlQDM1wUmEsT-2xfRjJK7lbmv6Nw8xRZnBBaZnPBYUxSI3gu1q9gG163O7wBOdoOFBbwZ3JErG7cBn820JhrJKrDyrIEy6T6YMLgoVEuYD28cm6OM9icN5fuB5o1TWUiWUFsId9EPtF0T" />
                            </div>
                        </div>
                        <!-- Content -->
                        <div class="flex-1">
                            <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-2 mb-2">
                                <div>
                                    <h3
                                        class="text-xl font-bold text-[#111816] dark:text-white group-hover:text-primary transition-colors cursor-pointer">
                                        Chevening Scholarships</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">UK Government â€¢ United Kingdom
                                    </p>
                                </div>
                                <div class="text-right md:text-right">
                                    <p class="text-2xl font-black text-accent-green tracking-tight">Â£18,000<span
                                            class="text-sm font-normal text-gray-500 dark:text-gray-400">/yr</span></p>
                                    <p class="text-xs text-gray-400">Plus Airfare</p>
                                </div>
                            </div>
                            <p class="text-sm text-gray-600 dark:text-gray-300 mb-4 line-clamp-2">
                                Chevening is the UK governmentâ€™s international awards programme aimed at developing
                                global leaders. Funded by the Foreign, Commonwealth and Development Office.
                            </p>
                            <div class="flex flex-wrap gap-2 mb-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300">
                                    Masters
                                </span>
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300">
                                    Leadership
                                </span>
                            </div>
                            <div
                                class="flex flex-col sm:flex-row items-start sm:items-center justify-between pt-4 border-t border-gray-100 dark:border-gray-700 gap-4">
                                <div
                                    class="flex items-center gap-2 text-gray-500 dark:text-gray-400 text-sm font-medium">
                                    <span class="material-symbols-outlined text-[18px]">calendar_today</span>
                                    <span>Deadline: Nov 07, 2023</span>
                                </div>
                                <div class="flex gap-3 w-full sm:w-auto">
                                    <button
                                        class="flex-1 sm:flex-none px-4 py-2 rounded-lg border border-gray-200 dark:border-gray-600 text-[#111816] dark:text-white font-semibold hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors text-sm">Save</button>
                                    <button
                                        class="flex-1 sm:flex-none px-6 py-2 rounded-lg bg-primary hover:bg-primary-dark text-white font-bold shadow-sm transition-colors text-sm">Apply
                                        Now</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
                <!-- Card 3 -->
                <article
                    class="bg-surface-light dark:bg-surface-dark rounded-xl p-6 border border-gray-200 dark:border-gray-700 shadow-sm hover:shadow-md transition-shadow group">
                    <div class="flex flex-col md:flex-row gap-6">
                        <!-- Logo -->
                        <div class="flex-shrink-0">
                            <div
                                class="size-16 rounded-lg bg-[#cc0000] flex items-center justify-center border border-gray-200 dark:border-gray-600 text-white font-bold text-xl">
                                ETH
                            </div>
                        </div>
                        <!-- Content -->
                        <div class="flex-1">
                            <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-2 mb-2">
                                <div>
                                    <h3
                                        class="text-xl font-bold text-[#111816] dark:text-white group-hover:text-primary transition-colors cursor-pointer">
                                        Excellence Scholarship &amp; Opportunity</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">ETH Zurich â€¢ Switzerland</p>
                                </div>
                                <div class="text-right md:text-right">
                                    <p class="text-2xl font-black text-accent-green tracking-tight">CHF 12k<span
                                            class="text-sm font-normal text-gray-500 dark:text-gray-400">/sem</span></p>
                                </div>
                            </div>
                            <div class="flex flex-wrap gap-2 my-4">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300">
                                    Masters
                                </span>
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300">
                                    STEM
                                </span>
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-300">
                                    Merit-based
                                </span>
                            </div>
                            <div
                                class="flex flex-col sm:flex-row items-start sm:items-center justify-between pt-4 border-t border-gray-100 dark:border-gray-700 gap-4">
                                <div
                                    class="flex items-center gap-2 text-gray-500 dark:text-gray-400 text-sm font-medium">
                                    <span class="material-symbols-outlined text-[18px]">calendar_today</span>
                                    <span>Deadline: Dec 15, 2023</span>
                                </div>
                                <div class="flex gap-3 w-full sm:w-auto">
                                    <button
                                        class="flex-1 sm:flex-none px-4 py-2 rounded-lg border border-gray-200 dark:border-gray-600 text-[#111816] dark:text-white font-semibold hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors text-sm">Save</button>
                                    <button
                                        class="flex-1 sm:flex-none px-6 py-2 rounded-lg bg-primary hover:bg-primary-dark text-white font-bold shadow-sm transition-colors text-sm">Apply
                                        Now</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
                <div class="flex justify-center mt-6">
                    <button class="text-primary font-bold text-sm flex items-center gap-2 hover:underline">
                        Load More Scholarships <span class="material-symbols-outlined">expand_more</span>
                    </button>
                </div>
            </div>
            <!-- Right Column: Sidebar (Span 4) -->
            <aside class="lg:col-span-4 space-y-6">
                <!-- Upcoming Deadlines Widget -->
                <div
                    class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div
                        class="px-5 py-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center bg-gray-50 dark:bg-[#25282e]">
                        <h3 class="font-bold text-[#111816] dark:text-white flex items-center gap-2">
                            <span class="material-symbols-outlined text-gray-400">hourglass_top</span>
                            Upcoming Deadlines
                        </h3>
                    </div>
                    <div class="p-2">
                        <!-- List Item -->
                        <div
                            class="flex gap-4 p-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 rounded-lg transition-colors cursor-pointer group">
                            <div
                                class="bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 rounded-lg flex flex-col items-center justify-center w-12 h-12 flex-shrink-0 border border-red-100 dark:border-red-900/30">
                                <span class="text-[10px] uppercase font-bold leading-none">Oct</span>
                                <span class="text-lg font-black leading-none mt-0.5">05</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p
                                    class="text-sm font-bold text-gray-900 dark:text-white truncate group-hover:text-primary transition-colors">
                                    DAAD Germany Grant</p>
                                <p class="text-xs text-gray-500 truncate">Ends in 2 days</p>
                            </div>
                        </div>
                        <div
                            class="flex gap-4 p-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 rounded-lg transition-colors cursor-pointer group">
                            <div
                                class="bg-orange-50 dark:bg-orange-900/20 text-orange-600 dark:text-orange-400 rounded-lg flex flex-col items-center justify-center w-12 h-12 flex-shrink-0 border border-orange-100 dark:border-orange-900/30">
                                <span class="text-[10px] uppercase font-bold leading-none">Oct</span>
                                <span class="text-lg font-black leading-none mt-0.5">12</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p
                                    class="text-sm font-bold text-gray-900 dark:text-white truncate group-hover:text-primary transition-colors">
                                    Commonwealth Masters</p>
                                <p class="text-xs text-gray-500 truncate">Ends in 1 week</p>
                            </div>
                        </div>
                        <div
                            class="flex gap-4 p-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 rounded-lg transition-colors cursor-pointer group">
                            <div
                                class="bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-400 rounded-lg flex flex-col items-center justify-center w-12 h-12 flex-shrink-0 border border-gray-200 dark:border-gray-700">
                                <span class="text-[10px] uppercase font-bold leading-none">Oct</span>
                                <span class="text-lg font-black leading-none mt-0.5">28</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p
                                    class="text-sm font-bold text-gray-900 dark:text-white truncate group-hover:text-primary transition-colors">
                                    Gates Cambridge</p>
                                <p class="text-xs text-gray-500 truncate">Ends in 3 weeks</p>
                            </div>
                        </div>
                    </div>
                    <div class="px-5 py-3 border-t border-gray-100 dark:border-gray-700 text-center">
                        <a class="text-xs font-bold text-primary uppercase tracking-wide hover:underline" href="#">View
                            Calendar</a>
                    </div>
                </div>
                <!-- Tips Widget -->
                <div
                    class="bg-primary/5 dark:bg-primary/10 rounded-xl p-5 border border-primary/10 dark:border-primary/20 relative overflow-hidden">
                    <span
                        class="material-symbols-outlined absolute -right-4 -bottom-4 text-9xl text-primary/5 dark:text-primary/10 pointer-events-none">lightbulb</span>
                    <div class="relative z-10">
                        <h4 class="font-bold text-primary dark:text-primary-light text-lg mb-2 flex items-center gap-2">
                            <span class="material-symbols-outlined text-xl">lightbulb</span> Pro Tip
                        </h4>
                        <p class="text-sm text-[#111816] dark:text-gray-300 leading-relaxed mb-4">
                            <strong>Personalize your essay!</strong> Sponsors look for candidates who align with their
                            mission. Mention specific projects or values from their website in your application letter.
                        </p>
                        <a class="text-sm font-bold text-primary dark:text-primary-light flex items-center gap-1 hover:gap-2 transition-all"
                            href="#">
                            Read Application Guide <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </a>
                    </div>
                </div>
                <!-- Featured University Widget -->
                <div
                    class="bg-surface-light dark:bg-surface-dark rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Featured University</p>
                    <div class="h-32 rounded-lg bg-gray-200 mb-4 bg-cover bg-center"
                        data-alt="University of Oxford campus building stone architecture"
                        style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAqrL1Yy7mxnywNNvRbnaGwL1PoTjoLj8lwYFlnYqkXijyI9RFSrvf1AUuqy1cpgTWcDOXdbUrZNW4gkxufUJeoRVVUTpVohPN5PyQEBM9KrbiPlVfHjKErqEVOkjPF86x12Qq94b21eYNBJHWtLa77sshSktIAz51Rw2inW6S4BcPKhCwjcbeMdti3_tp1nYs6CCeRqyD_dlRpBHYYHxuySy2uYTg03RzlIl9U24QgBDlz03O7_jsWBFyBBc_srI3Qy9LUo5TgiTPw');">
                    </div>
                    <h4 class="font-bold text-lg text-[#111816] dark:text-white">University of Oxford</h4>
                    <p class="text-sm text-gray-500 mb-3">Offering 15+ new scholarships for 2024 intake.</p>
                    <button
                        class="w-full py-2 rounded-lg border border-gray-200 dark:border-gray-600 text-sm font-bold hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">View
                        Profile</button>
                </div>
            </aside>
        </div>
    </main>
    <!-- Footer -->
    
<?= view('web/include/footer') ?>