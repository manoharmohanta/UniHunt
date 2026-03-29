<?= view('web/include/header', ['title' => 'About UniHunt - Mission &amp; Team', 'bodyClass' => 'bg-background-light dark:bg-background-dark text-[#111816] dark:text-[#f0f4f3] font-display overflow-x-hidden antialiased selection:bg-primary/20 selection:text-primary']) ?>

        <main class="flex-1 flex flex-col w-full max-w-[1280px] mx-auto">
            <!-- Hero Section: Mission -->
            <section
                class="flex flex-col items-center justify-center py-20 px-4 md:px-20 text-center max-w-4xl mx-auto">
                <div
                    class="mb-6 inline-flex items-center gap-2 rounded-full border border-primary/20 bg-primary/5 px-3 py-1 text-xs font-bold uppercase tracking-wider text-primary">
                    <span class="size-2 rounded-full bg-primary animate-pulse"></span>
                    Our Mission
                </div>
                <h1
                    class="text-4xl md:text-6xl font-extrabold leading-[1.1] tracking-tight mb-8 text-[#111816] dark:text-white">
                    Empowering the next generation of <span class="text-primary relative inline-block">
                        global scholars.
                        <svg class="absolute w-full h-3 -bottom-1 left-0 text-primary/20" preserveaspectratio="none"
                            viewbox="0 0 100 10">
                            <path d="M0 5 Q 50 10 100 5" fill="none" stroke="currentColor" stroke-width="8"></path>
                        </svg>
                    </span>
                </h1>
                <p class="text-lg md:text-xl text-gray-600 dark:text-gray-300 font-medium leading-relaxed max-w-2xl">
                    At UniHunt, we believe talent is universal but opportunity is not. We're on a mission to democratize
                    access to global education through technology, transparency, and trust.
                </p>
            </section>
            <!-- Decorative Visual Divider -->
            <div class="w-full h-px bg-gradient-to-r from-transparent via-primary/20 to-transparent my-8"></div>
            <!-- Impact Statistics -->
            <section class="py-12 px-4 md:px-20">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div
                        class="flex flex-col p-8 rounded-2xl bg-white dark:bg-surface-dark border border-[#f0f4f3] dark:border-[#2C3E36] shadow-soft hover:shadow-md transition-shadow group">
                        <div
                            class="size-12 rounded-full bg-primary/10 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-primary">groups</span>
                        </div>
                        <p class="text-4xl font-extrabold text-[#111816] dark:text-white mb-1">100k+</p>
                        <p class="text-sm font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Students
                            Placed</p>
                    </div>
                    <div
                        class="flex flex-col p-8 rounded-2xl bg-white dark:bg-surface-dark border border-[#f0f4f3] dark:border-[#2C3E36] shadow-soft hover:shadow-md transition-shadow group">
                        <div
                            class="size-12 rounded-full bg-primary/10 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-primary">account_balance</span>
                        </div>
                        <p class="text-4xl font-extrabold text-[#111816] dark:text-white mb-1">500+</p>
                        <p class="text-sm font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            University Partners</p>
                    </div>
                    <div
                        class="flex flex-col p-8 rounded-2xl bg-white dark:bg-surface-dark border border-[#f0f4f3] dark:border-[#2C3E36] shadow-soft hover:shadow-md transition-shadow group">
                        <div
                            class="size-12 rounded-full bg-primary/10 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <span class="material-symbols-outlined text-primary">payments</span>
                        </div>
                        <p class="text-4xl font-extrabold text-[#111816] dark:text-white mb-1">$50M+</p>
                        <p class="text-sm font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">
                            Scholarships Unlocked</p>
                    </div>
                </div>
            </section>
            <!-- Our Story (Timeline) -->
            <section class="py-16 px-4 md:px-20">
                <div class="max-w-[800px] mx-auto">
                    <h2 class="text-2xl font-bold mb-12 text-center">Our Story</h2>
                    <div class="grid grid-cols-[60px_1fr] gap-x-6 md:gap-x-10">
                        <!-- Item 1 -->
                        <div class="flex flex-col items-center">
                            <div
                                class="size-10 rounded-full border-2 border-primary bg-white dark:bg-background-dark flex items-center justify-center z-10">
                                <span class="material-symbols-outlined text-primary text-[20px]">flag</span>
                            </div>
                            <div class="w-0.5 bg-primary/20 h-full grow min-h-[80px]"></div>
                        </div>
                        <div class="pb-12 pt-1">
                            <div class="flex flex-col md:flex-row md:items-baseline md:justify-between gap-1 mb-2">
                                <h3 class="text-xl font-bold text-[#111816] dark:text-white">Founded in London</h3>
                                <span class="text-primary font-bold text-lg">2018</span>
                            </div>
                            <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                                UniHunt began as a small project in a university dorm room, aiming to simplify the
                                complex application process for international students.
                            </p>
                        </div>
                        <!-- Item 2 -->
                        <div class="flex flex-col items-center">
                            <div class="w-0.5 bg-primary/20 h-4"></div>
                            <div
                                class="size-10 rounded-full border-2 border-primary bg-white dark:bg-background-dark flex items-center justify-center z-10">
                                <span class="material-symbols-outlined text-primary text-[20px]">handshake</span>
                            </div>
                            <div class="w-0.5 bg-primary/20 h-full grow min-h-[80px]"></div>
                        </div>
                        <div class="pb-12 pt-1">
                            <div class="flex flex-col md:flex-row md:items-baseline md:justify-between gap-1 mb-2">
                                <h3 class="text-xl font-bold text-[#111816] dark:text-white">100 Partner Universities
                                </h3>
                                <span class="text-primary font-bold text-lg">2020</span>
                            </div>
                            <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                                Despite global challenges, we established trusted partnerships with top institutions
                                across the UK, US, and Canada.
                            </p>
                        </div>
                        <!-- Item 3 -->
                        <div class="flex flex-col items-center">
                            <div class="w-0.5 bg-primary/20 h-4"></div>
                            <div
                                class="size-10 rounded-full border-2 border-primary bg-white dark:bg-background-dark flex items-center justify-center z-10">
                                <span class="material-symbols-outlined text-primary text-[20px]">psychology</span>
                            </div>
                            <div class="w-0.5 bg-primary/20 h-full grow min-h-[80px]"></div>
                        </div>
                        <div class="pb-12 pt-1">
                            <div class="flex flex-col md:flex-row md:items-baseline md:justify-between gap-1 mb-2">
                                <h3 class="text-xl font-bold text-[#111816] dark:text-white">AI Scholarship Matching
                                </h3>
                                <span class="text-primary font-bold text-lg">2022</span>
                            </div>
                            <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                                Launched our proprietary AI engine that helps students discover financial aid
                                opportunities they otherwise would have missed.
                            </p>
                        </div>
                        <!-- Item 4 -->
                        <div class="flex flex-col items-center">
                            <div class="w-0.5 bg-primary/20 h-4"></div>
                            <div
                                class="size-10 rounded-full border-2 border-primary bg-white dark:bg-background-dark flex items-center justify-center z-10">
                                <span class="material-symbols-outlined text-primary text-[20px]">public</span>
                            </div>
                        </div>
                        <div class="pb-4 pt-1">
                            <div class="flex flex-col md:flex-row md:items-baseline md:justify-between gap-1 mb-2">
                                <h3 class="text-xl font-bold text-[#111816] dark:text-white">Global Expansion</h3>
                                <span class="text-primary font-bold text-lg">2024</span>
                            </div>
                            <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                                Now operating in 50+ countries, serving students from diverse backgrounds and connecting
                                them to world-class education.
                            </p>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Leadership Team -->
            <section class="py-20 px-4 md:px-20 bg-surface-light/50 dark:bg-surface-dark/30 rounded-3xl mx-4 my-10">
                <div class="mb-12 text-center">
                    <h2 class="text-3xl font-bold mb-4 text-[#111816] dark:text-white">Meet the Leadership</h2>
                    <p class="text-gray-600 dark:text-gray-300 max-w-2xl mx-auto">
                        A team of educators, technologists, and dreamers dedicated to building the future of higher
                        education.
                    </p>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    <!-- Leader 1 -->
                    <div class="group flex flex-col gap-4">
                        <div class="aspect-[4/5] w-full overflow-hidden rounded-xl bg-gray-200 relative">
                            <img alt="James Sterling CEO"
                                class="h-full w-full object-cover transition-all duration-500 group-hover:scale-105 grayscale group-hover:grayscale-0"
                                data-alt="Portrait of James Sterling, CEO, wearing a suit in a modern office environment"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuBTiQJakjF7iQDaMJIpToDcCxzX43YspxD6iV-cyvRvvlYVix-81sAVE1wTi8AEUgSgCqzs_g__DUwld53yCFM1Xgl523PQruRIh4FV_DKoZzQDQVQcw4m-2jbzbfoco2y6PIgSTBVjJcjAZADduoPrYt1EoBk6TMebz5pajK9RuGXRUGDiI_4TvVzD3r7OjWEaXlMKmF702otv0u7m2aRAa1FWt2tqRQDorqd0ayGun84x3dtA_JNqVQtd8nZ1KbulzEc_V_fNRA-T" />
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                                <a class="text-white hover:text-primary transition-colors" href="#">
                                    <svg class="size-6" fill="currentColor" viewbox="0 0 24 24">
                                        <path
                                            d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z">
                                        </path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-[#111816] dark:text-white">James Sterling</h3>
                            <p class="text-sm font-medium text-primary mb-2">CEO &amp; Co-Founder</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-3">Former Admissions Director
                                at Oxford. Passionate about removing borders from education.</p>
                        </div>
                    </div>
                    <!-- Leader 2 -->
                    <div class="group flex flex-col gap-4">
                        <div class="aspect-[4/5] w-full overflow-hidden rounded-xl bg-gray-200 relative">
                            <img alt="Sarah Chen CTO"
                                class="h-full w-full object-cover transition-all duration-500 group-hover:scale-105 grayscale group-hover:grayscale-0"
                                data-alt="Portrait of Sarah Chen, CTO, smiling confidently in a tech office setting"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuBzQCOEId-_6IFy_gab2OYwBLXjeLab8SxqwrEv1mWaoyjAld9c9i8iEipQHVhSalulOaKJlB7frTw5YAiUcQwm1YeM3Fha5DzJ1oMBonAvFxTT-VsJUI3s0xnht0dUZeoLGE8916aY5rIUOB-K5pTX7J-Efrzkta1Swq5QODA61QjsOQEmT25ygnrehCgcVloIweZfDmc23kek1J0lSnJ0B55xeC7hQZtodfkWOlI9149n-9B3mGA1MQLtHmaxRMP6hKO9ertHqRyn" />
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                                <a class="text-white hover:text-primary transition-colors" href="#">
                                    <svg class="size-6" fill="currentColor" viewbox="0 0 24 24">
                                        <path
                                            d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z">
                                        </path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-[#111816] dark:text-white">Sarah Chen</h3>
                            <p class="text-sm font-medium text-primary mb-2">CTO</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-3">Ex-Google Engineer.
                                Building the AI architecture that powers our matching engine.</p>
                        </div>
                    </div>
                    <!-- Leader 3 -->
                    <div class="group flex flex-col gap-4">
                        <div class="aspect-[4/5] w-full overflow-hidden rounded-xl bg-gray-200 relative">
                            <img alt="Marcus Johnson Head of Admissions"
                                class="h-full w-full object-cover transition-all duration-500 group-hover:scale-105 grayscale group-hover:grayscale-0"
                                data-alt="Portrait of Marcus Johnson, Head of Admissions, looking professional in a suit"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuCBWJld4OyEu8Cw4voVxr2GXZyjheBZxbU3sKWUXQwh25yjXQ0l1wisKrXWehzYnsAGisp8P1D0AfWUfm_uav2iD9S1_7iNrirbZ_RB9ujait2JrUZBumAVSgbiRXeo3g_8f3o1JOVvHJWkhpeiNhmeDCExcFINwdyNI_6QDkBzWXWMMTBUvfmnRtgcygMwwRCKSPzrSGIyDFz75sSub_Q0Iq-awUy0tgxWWn1jBXSsoBhgYeZPfkvm1JJkRsUUIl5o4gRxjq4soIH9" />
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                                <a class="text-white hover:text-primary transition-colors" href="#">
                                    <svg class="size-6" fill="currentColor" viewbox="0 0 24 24">
                                        <path
                                            d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z">
                                        </path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-[#111816] dark:text-white">Marcus Johnson</h3>
                            <p class="text-sm font-medium text-primary mb-2">Head of Admissions</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-3">Guidance counselor turned
                                scalable education strategist.</p>
                        </div>
                    </div>
                    <!-- Leader 4 -->
                    <div class="group flex flex-col gap-4">
                        <div class="aspect-[4/5] w-full overflow-hidden rounded-xl bg-gray-200 relative">
                            <img alt="Elena Rodriguez VP Partnerships"
                                class="h-full w-full object-cover transition-all duration-500 group-hover:scale-105 grayscale group-hover:grayscale-0"
                                data-alt="Portrait of Elena Rodriguez, VP of Partnerships, smiling in a casual business setting"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuCfaHkkP16L6qhGzzVp55aOaQfgSvHDEXD4HiLmfb4L8tzjn2Yzzm-38u1nP9ASor4zpVmGFZ_64UsrCGqOQvzMdoae7obCWqn7o1qvoc-ThjgupkcX_iGdjhHsdyZFmD8XEjRdCF6rpVOc1yMuezREzgzv8eUt-lSNQ5LGNUybQdXZuY3yY3MMRdqkW9EhPC03LKBc2KCEvL4KGEWWd2slRTmvjmCAlIEQqlHYO5zUW_2Nk_82yP_mI1ja5LYxSIN9yZSpX40q1dHR" />
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-4">
                                <a class="text-white hover:text-primary transition-colors" href="#">
                                    <svg class="size-6" fill="currentColor" viewbox="0 0 24 24">
                                        <path
                                            d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z">
                                        </path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-[#111816] dark:text-white">Elena Rodriguez</h3>
                            <p class="text-sm font-medium text-primary mb-2">VP of Partnerships</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-3">Connecting 500+
                                universities with our platform worldwide.</p>
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <!-- Footer -->
        
<?= view('web/include/footer') ?>