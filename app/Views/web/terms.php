<?= view('web/include/header', ['title' => 'Terms and Conditions - UniHunt Global', 'bodyClass' => 'bg-background-light dark:bg-background-dark text-text-main font-display antialiased min-h-screen flex flex-col']) ?>

<!-- Breadcrumbs & Meta Bar -->
<div class="no-print bg-white dark:bg-[#1e2526] border-b border-gray-100 dark:border-gray-800">
    <div class="px-4 md:px-8 xl:px-40 flex justify-center">
        <div class="w-full max-w-[1280px] py-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <nav class="flex items-center gap-2 text-sm text-text-muted">
                    <a class="hover:text-primary transition-colors" href="<?= base_url() ?>">Home</a>
                    <span class="material-symbols-outlined text-[12px]">chevron_right</span>
                    <a class="hover:text-primary transition-colors" href="#">Legal</a>
                    <span class="material-symbols-outlined text-[12px]">chevron_right</span>
                    <span class="text-text-main dark:text-white font-medium">Terms and Conditions</span>
                </nav>
                <div class="flex items-center gap-4">
                    <span
                        class="text-xs font-medium text-text-muted bg-secondary dark:bg-gray-800 px-2 py-1 rounded">Version
                        1.0</span>
                    <a class="text-xs font-bold text-primary hover:underline" href="<?= base_url('privacy') ?>">View
                        Privacy Policy</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Main Content Layout -->
<main class="flex-grow bg-white dark:bg-[#1e2526]">
    <div class="px-4 md:px-8 xl:px-40 flex justify-center pb-20 pt-8">
        <div class="w-full max-w-[1280px] flex flex-col lg:flex-row gap-12 relative">
            <!-- Sticky Sidebar Navigation (Left) -->
            <aside class="no-print hidden lg:block w-64 shrink-0 relative">
                <div class="sticky top-8 max-h-[calc(100vh-4rem)] overflow-y-auto custom-scrollbar pr-4">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-text-muted mb-4">Contents</h3>
                    <nav class="flex flex-col gap-1 border-l border-gray-200 dark:border-gray-700">
                        <a class="pl-4 py-2 text-sm font-medium text-primary border-l-2 border-primary -ml-[1px] bg-primary/5 transition-all"
                            href="#intro">
                            1. Introduction
                        </a>
                        <a class="pl-4 py-2 text-sm font-medium text-text-muted hover:text-text-main hover:border-l-2 hover:border-gray-300 dark:hover:border-gray-600 -ml-[1px] transition-all"
                            href="#accounts">
                            2. User Accounts
                        </a>
                        <a class="pl-4 py-2 text-sm font-medium text-text-muted hover:text-text-main hover:border-l-2 hover:border-gray-300 dark:hover:border-gray-600 -ml-[1px] transition-all"
                            href="#use">
                            3. Acceptable Use
                        </a>
                        <a class="pl-4 py-2 text-sm font-medium text-text-muted hover:text-text-main hover:border-l-2 hover:border-gray-300 dark:hover:border-gray-600 -ml-[1px] transition-all"
                            href="#intellectual">
                            4. Intellectual Property
                        </a>
                        <a class="pl-4 py-2 text-sm font-medium text-text-muted hover:text-text-main hover:border-l-2 hover:border-gray-300 dark:hover:border-gray-600 -ml-[1px] transition-all"
                            href="#termination">
                            5. Termination
                        </a>
                        <a class="pl-4 py-2 text-sm font-medium text-text-muted hover:text-text-main hover:border-l-2 hover:border-gray-300 dark:hover:border-gray-600 -ml-[1px] transition-all"
                            href="#limitation">
                            6. Limitation of Liability
                        </a>
                        <a class="pl-4 py-2 text-sm font-medium text-text-muted hover:text-text-main hover:border-l-2 hover:border-gray-300 dark:hover:border-gray-600 -ml-[1px] transition-all"
                            href="#contact">
                            7. Contact Us
                        </a>
                    </nav>
                </div>
            </aside>
            <!-- Document Content (Right/Center) -->
            <article class="print-full-width flex-1 max-w-[800px]">
                <!-- Document Header -->
                <div
                    class="mb-10 pb-8 border-b border-gray-200 dark:border-gray-700 flex flex-col md:flex-row md:items-end justify-between gap-6">
                    <div>
                        <h1
                            class="font-serif text-4xl md:text-5xl font-bold text-text-main dark:text-white mb-4 tracking-tight">
                            Terms and Conditions</h1>
                        <div class="flex items-center gap-2 text-text-muted">
                            <span class="material-symbols-outlined text-[18px]">calendar_today</span>
                            <span class="text-sm font-medium">Last Updated:
                                <?= date('F d, Y') ?>
                            </span>
                        </div>
                    </div>
                    <button onclick="window.print()"
                        class="no-print group flex items-center gap-2 bg-secondary dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-text-main dark:text-white px-4 py-2.5 rounded-lg transition-all font-medium text-sm">
                        <span
                            class="material-symbols-outlined text-[20px] group-hover:-translate-y-0.5 transition-transform">print</span>
                        Print
                    </button>
                </div>
                <!-- Sections -->
                <div
                    class="prose prose-lg dark:prose-invert max-w-none text-text-main/80 dark:text-gray-300 font-light">
                    <section class="mb-12 scroll-mt-24" id="intro">
                        <h2
                            class="font-serif text-2xl font-bold text-text-main dark:text-white mb-4 flex items-center gap-3">
                            <span class="text-primary/40 dark:text-primary/60 font-sans text-lg font-bold">01</span>
                            Introduction
                        </h2>
                        <p class="leading-relaxed mb-4">
                            Welcome to UniHunt Global. These Terms and Conditions govern your use of our website and
                            services. By accessing or using our platform, you agree to be bound by these terms. If you
                            do not agree with any part of these terms, you may not use our services.
                        </p>
                        <p class="leading-relaxed">
                            UniHunt Global provides a platform for university discovery, application management, and
                            career guidance. Our services are intended for students, parents, and educators seeking
                            information about higher education opportunities worldwide.
                        </p>
                    </section>

                    <section class="mb-12 scroll-mt-24" id="accounts">
                        <h2
                            class="font-serif text-2xl font-bold text-text-main dark:text-white mb-4 flex items-center gap-3">
                            <span class="text-primary/40 dark:text-primary/60 font-sans text-lg font-bold">02</span>
                            User Accounts
                        </h2>
                        <p class="leading-relaxed mb-4">
                            To access certain features of our platform, you may be required to create an account. You
                            are responsible for:
                        </p>
                        <ul class="list-disc list-outside ml-5 space-y-2 marker:text-primary">
                            <li>Maintaining the confidentiality of your account credentials.</li>
                            <li>Ensuring that all information provided is accurate and up-to-date.</li>
                            <li>All activities that occur under your account.</li>
                        </ul>
                        <p class="leading-relaxed mt-4">
                            We reserve the right to suspend or terminate accounts that violate these terms or provide
                            false information.
                        </p>
                    </section>

                    <section class="mb-12 scroll-mt-24" id="use">
                        <h2
                            class="font-serif text-2xl font-bold text-text-main dark:text-white mb-4 flex items-center gap-3">
                            <span class="text-primary/40 dark:text-primary/60 font-sans text-lg font-bold">03</span>
                            Acceptable Use
                        </h2>
                        <p class="leading-relaxed mb-4">
                            You agree not to use the platform for any unlawful purpose or any purpose prohibited under
                            this clause. You agree not to:
                        </p>
                        <div class="grid md:grid-cols-2 gap-4 mb-6">
                            <div
                                class="p-4 rounded-lg border border-gray-100 dark:border-gray-800 bg-background-light dark:bg-gray-900/50">
                                <div class="flex items-center gap-2 mb-2 text-primary font-bold text-sm">
                                    <span class="material-symbols-outlined text-[18px]">block</span>
                                    No Scraping
                                </div>
                                <p class="text-sm text-text-muted">You may not use automated systems or software to
                                    extract data from our website for commercial purposes.</p>
                            </div>
                            <div
                                class="p-4 rounded-lg border border-gray-100 dark:border-gray-800 bg-background-light dark:bg-gray-900/50">
                                <div class="flex items-center gap-2 mb-2 text-primary font-bold text-sm">
                                    <span class="material-symbols-outlined text-[18px]">security</span>
                                    Security
                                </div>
                                <p class="text-sm text-text-muted">You may not attempt to bypass any security features
                                    or interfere with the proper working of the platform.</p>
                            </div>
                        </div>
                    </section>

                    <section class="mb-12 scroll-mt-24" id="intellectual">
                        <h2
                            class="font-serif text-2xl font-bold text-text-main dark:text-white mb-4 flex items-center gap-3">
                            <span class="text-primary/40 dark:text-primary/60 font-sans text-lg font-bold">04</span>
                            Intellectual Property
                        </h2>
                        <p class="leading-relaxed mb-4">
                            All content on this platform, including text, graphics, logos, and software, is the property
                            of UniHunt Global or its content suppliers and is protected by international copyright laws.
                        </p>
                        <p class="leading-relaxed">
                            You are granted a limited, non-exclusive license to access and use the platform for
                            personal, non-commercial purposes.
                        </p>
                    </section>

                    <section class="mb-12 scroll-mt-24" id="termination">
                        <h2
                            class="font-serif text-2xl font-bold text-text-main dark:text-white mb-4 flex items-center gap-3">
                            <span class="text-primary/40 dark:text-primary/60 font-sans text-lg font-bold">05</span>
                            Termination
                        </h2>
                        <p class="leading-relaxed mb-4">
                            We may terminate or suspend your access to our services immediately, without prior notice or
                            liability, for any reason whatsoever, including without limitation if you breach the Terms.
                        </p>
                    </section>

                    <section class="mb-12 scroll-mt-24" id="limitation">
                        <h2
                            class="font-serif text-2xl font-bold text-text-main dark:text-white mb-4 flex items-center gap-3">
                            <span class="text-primary/40 dark:text-primary/60 font-sans text-lg font-bold">06</span>
                            Limitation of Liability
                        </h2>
                        <p class="leading-relaxed mb-4">
                            In no event shall UniHunt Global, nor its directors, employees, partners, agents, suppliers,
                            or affiliates, be liable for any indirect, incidental, special, consequential or punitive
                            damages, including without limitation, loss of profits, data, use, goodwill, or other
                            intangible losses.
                        </p>
                    </section>

                    <section class="mb-12 scroll-mt-24" id="contact">
                        <h2
                            class="font-serif text-2xl font-bold text-text-main dark:text-white mb-4 flex items-center gap-3">
                            <span class="text-primary/40 dark:text-primary/60 font-sans text-lg font-bold">07</span>
                            Contact Us
                        </h2>
                        <p class="leading-relaxed mb-6">
                            If you have any questions about these Terms and Conditions, please contact us:
                        </p>
                        <div class="bg-primary text-white p-6 rounded-xl relative overflow-hidden">
                            <div class="absolute top-0 right-0 opacity-10 -mr-10 -mt-10">
                                <span class="material-symbols-outlined text-[150px]">gavel</span>
                            </div>
                            <div class="relative z-10 grid md:grid-cols-2 gap-8">
                                <div>
                                    <p class="text-xs uppercase tracking-widest opacity-70 mb-1">Email Support</p>
                                    <a class="text-xl font-bold hover:underline text-white"
                                        href="mailto:unihunt.overseas@gmail.com">unihunt.overseas@gmail.com</a>
                                    <p class="text-sm opacity-80 mt-2">Typical response time: 24-48 hours</p>
                                </div>
                                <div>
                                    <p class="text-xs uppercase tracking-widest opacity-70 mb-1">Mailing Address</p>
                                    <address class="not-italic font-medium">
                                        UniHunt<br />
                                        123 Education Lane, Suite 400<br />
                                        San Francisco, CA 94105<br />
                                        United States
                                    </address>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </article>
        </div>
    </div>
</main>

<?= view('web/include/footer') ?>