<?= view('web/include/header', ['title' => 'UniHunt Partners | Global Student Recruitment', 'bodyClass' => 'bg-background-light dark:bg-background-dark text-text-main dark:text-white antialiased transition-colors duration-200']) ?>

        <main class="flex-grow">
            <!-- Hero Section -->
            <section class="relative pt-16 pb-20 lg:pt-24 lg:pb-32 overflow-hidden">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="grid lg:grid-cols-2 gap-12 items-center">
                        <!-- Hero Content -->
                        <div class="max-w-2xl">
                            <div
                                class="inline-flex items-center gap-2 rounded-full bg-primary/10 px-3 py-1 text-xs font-semibold text-primary ring-1 ring-inset ring-primary/20 mb-6">
                                <span class="relative flex h-2 w-2">
                                    <span
                                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
                                </span>
                                New AI Matching Engine v2.0
                            </div>
                            <h1
                                class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-text-main dark:text-white mb-6 leading-[1.1]">
                                Globalize Your <br class="hidden lg:block" /> Student Recruitment
                            </h1>
                            <p class="text-lg text-text-muted dark:text-gray-400 mb-8 leading-relaxed max-w-lg">
                                Connect with qualified students from 120+ countries using our AI-driven discovery
                                platform designed for modern higher education.
                            </p>
                            <div class="flex flex-wrap gap-4">
                                <button
                                    class="rounded-lg bg-primary px-8 py-3.5 text-base font-bold text-white shadow-soft hover:bg-primary-dark hover:shadow-hover transition-all duration-200 flex items-center gap-2">
                                    Become a Partner
                                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                                </button>
                                <button
                                    class="rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 px-8 py-3.5 text-base font-bold text-text-main dark:text-white shadow-soft hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-200">
                                    View Success Stories
                                </button>
                            </div>
                        </div>
                        <!-- Hero Visual -->
                        <div class="relative lg:ml-auto w-full">
                            <!-- Geometric Collage Container -->
                            <div class="grid grid-cols-12 grid-rows-6 gap-4 h-[400px] sm:h-[500px]">
                                <!-- Large Image -->
                                <div class="col-span-7 row-span-6 rounded-2xl overflow-hidden shadow-lg relative group">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent z-10">
                                    </div>
                                    <div class="absolute bottom-4 left-4 z-20 text-white">
                                        <p class="font-bold text-lg">Diverse Campus Life</p>
                                        <p class="text-xs opacity-80">University of Melbourne</p>
                                    </div>
                                    <div class="h-full w-full bg-cover bg-center transition-transform duration-700 group-hover:scale-105"
                                        data-alt="Group of diverse university students talking and laughing on campus grounds"
                                        style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAScyFmISSBZLmvOJeVcPcwT6o_jtzz4jdee87jryS3CKLJkw4bK-d_dkbF8thplzuZmShZRblfrynMEW6rkTkul1yVGvqPPnVnjxJ6qXqFpQKTN-TuZ8ZRUaw3Zx115RVAPAF3Ni7wXXO1CWLlo2AaiZpYPyrW4RDV9_NVKH2GddRIqjcxVDmQbK1NyFidiSNaRomQo1_AGrugiDq5XhPZvXd_zkt5Q78JLxsdo1SdUppKl8PIkIv2JZl_S98zGcSMZe-ZedDsnJ5A');">
                                    </div>
                                </div>
                                <!-- Top Right Image -->
                                <div class="col-span-5 row-span-3 rounded-2xl overflow-hidden shadow-lg relative">
                                    <div class="h-full w-full bg-cover bg-center"
                                        data-alt="University student presenting data in a modern classroom seminar"
                                        style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBZhoTZea7YYiB34-O5SBFLFYQH9RrKRHV6I8Fa71X_MGnfOHrl_rIp_qdmBgQ1sV79cEiKdyRmyRZC5OVEERdWZf8LZqLgTbsgL6i3mP83KPgPmR1pMUGM4Tm8Gj8do3P4gJp-uZnmkLeBAbd6YpmPXQHpXrEEmyww1_nnymncu6z2b7sZ9iimoIcXOhXApuJxL5lZXH6TD3F7UPqqT2dpD7IP9MGiAZMfs5-SYub2Yaf-FICvzIkaTqXcZgfiMVJ_iZ3Mx8gc-rZq');">
                                    </div>
                                </div>
                                <!-- Bottom Right Stats Card (Visual Element) -->
                                <div
                                    class="col-span-5 row-span-3 bg-primary/5 dark:bg-gray-800 rounded-2xl p-5 flex flex-col justify-between border border-primary/10 dark:border-gray-700">
                                    <div>
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="material-symbols-outlined text-accent-green">trending_up</span>
                                            <span
                                                class="text-xs font-bold uppercase tracking-wider text-text-muted dark:text-gray-400">Growth</span>
                                        </div>
                                        <div class="text-3xl font-heading font-bold text-text-main dark:text-white">
                                            +142%</div>
                                        <div class="text-sm text-text-muted dark:text-gray-400">Intl. Applications</div>
                                    </div>
                                    <!-- Simple CSS Chart -->
                                    <div class="flex items-end gap-1 h-16 mt-2">
                                        <div class="w-1/5 bg-primary/20 h-[40%] rounded-t-sm"></div>
                                        <div class="w-1/5 bg-primary/30 h-[60%] rounded-t-sm"></div>
                                        <div class="w-1/5 bg-primary/40 h-[45%] rounded-t-sm"></div>
                                        <div class="w-1/5 bg-primary/60 h-[80%] rounded-t-sm"></div>
                                        <div class="w-1/5 bg-primary h-[100%] rounded-t-sm"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Social Proof Section -->
            <section class="border-y border-gray-100 dark:border-gray-800 bg-surface-light dark:bg-surface-dark py-10">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <p
                        class="text-center text-sm font-semibold text-text-muted dark:text-gray-400 mb-8 uppercase tracking-widest">
                        Trusted by 500+ leading institutions worldwide</p>
                    <div
                        class="flex flex-wrap justify-center items-center gap-8 md:gap-16 opacity-60 grayscale hover:grayscale-0 transition-all duration-500">
                        <!-- Logo placeholders using text for simplicity/reliability -->
                        <div
                            class="flex items-center gap-2 text-xl font-bold font-heading text-slate-800 dark:text-white">
                            <span class="material-symbols-outlined">school</span> Stanford
                        </div>
                        <div
                            class="flex items-center gap-2 text-xl font-bold font-heading text-slate-800 dark:text-white">
                            <span class="material-symbols-outlined">account_balance</span> Oxford
                        </div>
                        <div
                            class="flex items-center gap-2 text-xl font-bold font-heading text-slate-800 dark:text-white">
                            <span class="material-symbols-outlined">history_edu</span> Cambridge
                        </div>
                        <div
                            class="flex items-center gap-2 text-xl font-bold font-heading text-slate-800 dark:text-white">
                            <span class="material-symbols-outlined">menu_book</span> MIT
                        </div>
                        <div
                            class="flex items-center gap-2 text-xl font-bold font-heading text-slate-800 dark:text-white">
                            <span class="material-symbols-outlined">local_library</span> Sorbonne
                        </div>
                    </div>
                </div>
            </section>
            <!-- Features Bento Grid -->
            <section class="py-24 bg-white dark:bg-background-dark relative">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="text-center max-w-2xl mx-auto mb-16">
                        <h2 class="text-3xl md:text-4xl font-bold text-text-main dark:text-white mb-4">Why Partner with
                            Us?</h2>
                        <p class="text-text-muted dark:text-gray-400 text-lg">We combine enterprise-grade data analytics
                            with a human-centric approach to recruitment.</p>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 auto-rows-[minmax(280px,auto)]">
                        <!-- Feature 1: AI Matching (Large) -->
                        <div
                            class="md:col-span-2 group relative overflow-hidden rounded-2xl bg-surface-light dark:bg-surface-dark border border-gray-100 dark:border-gray-800 p-8 hover:shadow-hover transition-all duration-300">
                            <div class="relative z-10 max-w-md">
                                <div
                                    class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-xl bg-white dark:bg-gray-800 text-primary shadow-sm border border-gray-100 dark:border-gray-700">
                                    <span class="material-symbols-outlined text-2xl">hub</span>
                                </div>
                                <h3 class="text-2xl font-bold text-text-main dark:text-white mb-2">AI-Powered Matching
                                </h3>
                                <p class="text-text-muted dark:text-gray-400 mb-6">Our proprietary algorithms analyze
                                    millions of data points to match students to your specific admission criteria,
                                    ensuring higher acceptance and retention rates.</p>
                                <a class="inline-flex items-center text-primary font-bold text-sm hover:underline"
                                    href="#">
                                    Learn about our Tech <span
                                        class="material-symbols-outlined text-sm ml-1">arrow_forward</span>
                                </a>
                            </div>
                            <!-- Visual Decoration -->
                            <div class="absolute top-8 right-8 w-32 h-32 md:w-64 md:h-64 opacity-50 md:opacity-100">
                                <svg class="w-full h-full text-primary/10 fill-current animate-[spin_60s_linear_infinite]"
                                    viewbox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M42.7,-73.2C55.9,-66.3,67.6,-57.1,76.5,-45.9C85.4,-34.7,91.5,-21.5,91.1,-8.5C90.7,4.5,83.8,17.3,75.3,28.6C66.8,39.9,56.7,49.7,45.4,57.1C34.1,64.5,21.6,69.5,8.8,70.9C-4,72.3,-17.1,70.1,-29.4,65.3C-41.7,60.5,-53.2,53.1,-62.4,43.3C-71.6,33.5,-78.5,21.3,-80.4,8.4C-82.3,-4.5,-79.2,-18.1,-71.7,-29.5C-64.2,-40.9,-52.3,-50.1,-39.8,-57.3C-27.3,-64.5,-14.2,-69.7,-0.4,-70.4C13.4,-71.1,29.5,-67.4,42.7,-73.2Z"
                                        transform="translate(100 100)"></path>
                                </svg>
                            </div>
                        </div>
                        <!-- Feature 2: Verified Leads (Tall/Standard) -->
                        <div
                            class="group relative overflow-hidden rounded-2xl bg-white dark:bg-surface-dark border border-gray-100 dark:border-gray-800 p-8 shadow-soft hover:shadow-hover transition-all duration-300 flex flex-col justify-between">
                            <div>
                                <div
                                    class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-xl bg-accent-green/10 text-accent-green shadow-sm">
                                    <span class="material-symbols-outlined text-2xl">verified_user</span>
                                </div>
                                <h3 class="text-xl font-bold text-text-main dark:text-white mb-2">Verified Leads</h3>
                                <p class="text-sm text-text-muted dark:text-gray-400">Receive high-intent applications
                                    that have been pre-vetted by our network of counselors.</p>
                            </div>
                            <div class="mt-8">
                                <div
                                    class="flex items-center gap-3 bg-gray-50 dark:bg-gray-800/50 p-3 rounded-lg border border-gray-100 dark:border-gray-700">
                                    <div
                                        class="h-8 w-8 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center overflow-hidden">
                                        <span class="material-symbols-outlined text-xs">person</span>
                                    </div>
                                    <div class="flex-1">
                                        <div class="h-2 w-24 bg-gray-200 dark:bg-gray-600 rounded mb-1"></div>
                                        <div class="h-1.5 w-16 bg-gray-200 dark:bg-gray-600 rounded"></div>
                                    </div>
                                    <span class="material-symbols-outlined text-accent-green">check_circle</span>
                                </div>
                            </div>
                        </div>
                        <!-- Feature 3: Real-time Analytics (Standard) -->
                        <div
                            class="group relative overflow-hidden rounded-2xl bg-white dark:bg-surface-dark border border-gray-100 dark:border-gray-800 p-8 shadow-soft hover:shadow-hover transition-all duration-300">
                            <div
                                class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-xl bg-primary/10 text-primary shadow-sm">
                                <span class="material-symbols-outlined text-2xl">monitoring</span>
                            </div>
                            <h3 class="text-xl font-bold text-text-main dark:text-white mb-2">Real-time Analytics</h3>
                            <p class="text-sm text-text-muted dark:text-gray-400">Track recruitment ROI instantly with
                                our comprehensive dashboard.</p>
                            <div
                                class="mt-6 h-32 w-full bg-gray-50 dark:bg-gray-800 rounded-lg p-4 relative overflow-hidden border border-gray-100 dark:border-gray-700">
                                <!-- Abstract chart -->
                                <svg class="w-full h-full text-primary" fill="none" stroke="currentColor"
                                    stroke-width="2" viewbox="0 0 100 40">
                                    <path d="M0 35 Q 20 30, 40 15 T 100 5" stroke-linecap="round"></path>
                                    <path class="opacity-20" d="M0 35 L 100 35" stroke="currentColor" stroke-width="1">
                                    </path>
                                </svg>
                                <div
                                    class="absolute top-2 right-2 bg-white dark:bg-gray-700 px-2 py-1 rounded text-[10px] font-bold shadow-sm text-accent-green">
                                    +24%</div>
                            </div>
                        </div>
                        <!-- Feature 4: Global Reach (Span 2) -->
                        <div
                            class="md:col-span-2 group relative overflow-hidden rounded-2xl bg-primary text-white p-8 hover:shadow-hover transition-all duration-300 flex items-center justify-between">
                            <div class="relative z-10 max-w-lg">
                                <h3 class="text-2xl font-bold mb-2">Ready to go Global?</h3>
                                <p class="text-primary/20 text-white/80 mb-6">Join a network that spans 120+ countries
                                    and access a diverse pool of talent waiting to discover your institution.</p>
                                <div class="flex gap-4">
                                    <div class="flex -space-x-2">
                                        <div class="w-8 h-8 rounded-full border-2 border-primary bg-gray-300"
                                            data-alt="Portrait of student 1"
                                            style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBMGCv_CRhd8EpTF23jQjE7WYzNVeruERt8d3lTZzMx43U9PKPyhWWwn4slDL7nZ0PYIyPOGilYhCVGahN7jAuxm5Jvbwouiv7vvnRoquZIdhSLf9WyjohwciNtmGnLlKGF4bTQi1vB79quxVnSUtObe0jcVjf3VLuaqZ4TfBeUSwKJa1659sgeU0dxrW8jiURmrgvK5jSQDpq1CSaI9N6dJx1uX_WwWsGEYaIYwARuysPQ7niC6pCO-Hs3rBOYOvH3v3TSw8WwSkng'); background-size: cover;">
                                        </div>
                                        <div class="w-8 h-8 rounded-full border-2 border-primary bg-gray-300"
                                            data-alt="Portrait of student 2"
                                            style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAaKEglaosvjpvV8xrw5G6Kim5n1RqwQK2AaInthJ7nJRafqQbo0ienWzCUrfZ60RWafLvAB5Motjto51yG5BfBZir_dCQ3CYi-3E5MfvdZBrmGClLLDEae_rf78GXonPBoTYGsPJLH1ARwRziEy6dguBXRKytdIqji4y29XG-mUO5zOtbHoOyBZ6h0ddEoaL6uUU_QyapwwUTAvFE22uuOHVxKAC1GBS9EZa9VFOUx7e7dwk_PR9S37NPLobZkaGOuLT0lk9ah3mhZ'); background-size: cover;">
                                        </div>
                                        <div class="w-8 h-8 rounded-full border-2 border-primary bg-gray-300"
                                            data-alt="Portrait of student 3"
                                            style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuB64t9dTnJH2XLiMovXjTA2qggqOi_yzK3a95uH1v6nVP6U1Wrxpju5s0UaTHffGBugoVJTf83_36Yp-kQFRYdE4PTK-ydfwVtQ3xjlcgYlrlYA1FhMxOSD-XYacaB6JZ-vhIikWUHzAVwdmxJS1jfauUWNvUBeWtZhP3Dc-VCbqvc-dm-RGINRVbV15KIyXyhT2DmubvIgI0q9zJDisv6fuJQV7Nm_fWzGjzBkdSoMH45VW_5BAw2mDPP1o9NHfbioHeYk8JSl7Wpp'); background-size: cover;">
                                        </div>
                                    </div>
                                    <span class="text-sm font-medium self-center">10k+ Students joined this week</span>
                                </div>
                            </div>
                            <div class="hidden md:block opacity-30">
                                <span class="material-symbols-outlined text-[120px]">public</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Inquiry Form Section -->
            <section class="py-24 bg-surface-light dark:bg-[#1a1d20] border-t border-gray-100 dark:border-gray-800">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="grid lg:grid-cols-2 gap-16 items-start">
                        <!-- Left Content -->
                        <div>
                            <span class="text-primary font-bold tracking-wider uppercase text-sm mb-2 block">Partnership
                                Inquiry</span>
                            <h2 class="text-4xl font-bold text-text-main dark:text-white mb-6">Expand your reach today.
                            </h2>
                            <p class="text-lg text-text-muted dark:text-gray-400 mb-8">
                                Whether you're a large university or a specialized college, UniHunt provides the tools
                                you need to meet your enrollment targets.
                            </p>
                            <ul class="space-y-4 mb-8">
                                <li class="flex items-center gap-3">
                                    <span
                                        class="flex h-6 w-6 items-center justify-center rounded-full bg-accent-green/20 text-accent-green">
                                        <span class="material-symbols-outlined text-sm font-bold">check</span>
                                    </span>
                                    <span class="text-text-main dark:text-gray-300">Direct access to verified student
                                        profiles</span>
                                </li>
                                <li class="flex items-center gap-3">
                                    <span
                                        class="flex h-6 w-6 items-center justify-center rounded-full bg-accent-green/20 text-accent-green">
                                        <span class="material-symbols-outlined text-sm font-bold">check</span>
                                    </span>
                                    <span class="text-text-main dark:text-gray-300">Dedicated account manager
                                        support</span>
                                </li>
                                <li class="flex items-center gap-3">
                                    <span
                                        class="flex h-6 w-6 items-center justify-center rounded-full bg-accent-green/20 text-accent-green">
                                        <span class="material-symbols-outlined text-sm font-bold">check</span>
                                    </span>
                                    <span class="text-text-main dark:text-gray-300">Seamless CRM integration</span>
                                </li>
                            </ul>
                            <div
                                class="p-6 bg-white dark:bg-surface-dark rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm">
                                <div class="flex gap-4 items-start">
                                    <div class="text-4xl text-primary">"</div>
                                    <div>
                                        <p class="text-text-main dark:text-gray-300 italic mb-4">
                                            Partnering with UniHunt transformed our international strategy. We saw a 40%
                                            increase in qualified leads within the first quarter.
                                        </p>
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-gray-200 rounded-full bg-cover"
                                                data-alt="Headshot of Director of Admissions"
                                                style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDWrMVs5htZXaqSTBI0-7vg8ISrSYGAC8eq3ES-Peilcpqbf51_DVtgJRyiBUOe7ecdYGxisPGPTE8l3mynhbtYzyq_8fSAihEBKxIZraElhViC1gJBNBxJm7Imx1_Dz5ECGwFx7BTNyqBuKVczJKjQUayfAf-XFl9VRwxh7iElAmvJ1xO2lf9bmEIW_WlntcDxuERR0tqYj1R_dMmF8wu3SG41qrYbK9m1FWaxEc5hNhN9GnceF92fn4JoGeXbHPRnN4hN9o3nz215')">
                                            </div>
                                            <div>
                                                <div class="text-sm font-bold text-text-main dark:text-white">James
                                                    Wilson</div>
                                                <div class="text-xs text-text-muted">Director of Admissions, Tech
                                                    University</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Right Form -->
                        <div
                            class="bg-white dark:bg-surface-dark rounded-2xl p-8 shadow-lg border border-gray-100 dark:border-gray-800">
                            <form action="#" method="POST" class="space-y-6">
                                <?= csrf_field() ?>
                                <?= honeypot_field() ?>
                                <div>
                                    <label class="block text-sm font-bold text-text-main dark:text-white mb-2"
                                        for="institution">Institution Name</label>
                                    <input
                                        class="block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 shadow-sm focus:border-primary focus:ring-primary sm:text-sm py-3 px-4"
                                        id="institution" placeholder="e.g. University of Example" type="text" />
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-bold text-text-main dark:text-white mb-2"
                                            for="name">Rep Name</label>
                                        <input
                                            class="block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 shadow-sm focus:border-primary focus:ring-primary sm:text-sm py-3 px-4"
                                            id="name" placeholder="Jane Doe" type="text" />
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-text-main dark:text-white mb-2"
                                            for="email">Work Email</label>
                                        <input
                                            class="block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 shadow-sm focus:border-primary focus:ring-primary sm:text-sm py-3 px-4"
                                            id="email" placeholder="jane@university.edu" type="email" />
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-text-main dark:text-white mb-2"
                                        for="goal">Recruitment Goal</label>
                                    <select
                                        class="block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 shadow-sm focus:border-primary focus:ring-primary sm:text-sm py-3 px-4"
                                        id="goal">
                                        <option>Select a primary goal</option>
                                        <option>Increase International Diversity</option>
                                        <option>Fill Specific Programs</option>
                                        <option>Improve Lead Quality</option>
                                        <option>Brand Awareness</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-text-main dark:text-white mb-2"
                                        for="message">Additional Notes</label>
                                    <textarea
                                        class="block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 shadow-sm focus:border-primary focus:ring-primary sm:text-sm py-3 px-4"
                                        id="message" placeholder="Tell us about your specific needs..."
                                        rows="3"></textarea>
                                </div>
                                <button
                                    class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors"
                                    type="submit">
                                    Request Partnership Info
                                </button>
                                <p class="text-xs text-center text-text-muted mt-4">By submitting this form, you agree
                                    to our Terms of Service and Privacy Policy.</p>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <!-- Footer -->
        
<?= view('web/include/footer') ?>