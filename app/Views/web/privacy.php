<?= view('web/include/header', ['title' => 'Privacy Policy - UniHunt Global', 'bodyClass' => 'bg-background-light dark:bg-background-dark text-text-main font-display antialiased min-h-screen flex flex-col']) ?>

<!-- Breadcrumbs & Meta Bar -->
<div class="no-print bg-white dark:bg-[#1e2526] border-b border-gray-100 dark:border-gray-800">
    <div class="px-4 md:px-8 xl:px-40 flex justify-center">
        <div class="w-full max-w-[1280px] py-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <nav class="flex items-center gap-2 text-sm text-text-muted">
                    <a class="hover:text-primary transition-colors" href="#">Home</a>
                    <span class="material-symbols-outlined text-[12px]">chevron_right</span>
                    <a class="hover:text-primary transition-colors" href="#">Legal</a>
                    <span class="material-symbols-outlined text-[12px]">chevron_right</span>
                    <span class="text-text-main dark:text-white font-medium">Privacy Policy</span>
                </nav>
                <div class="flex items-center gap-4">
                    <span
                        class="text-xs font-medium text-text-muted bg-secondary dark:bg-gray-800 px-2 py-1 rounded">Version
                        2.4</span>
                    <a class="text-xs font-bold text-primary hover:underline" href="#">View Terms of Service</a>
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
                            href="#collection">
                            2. Information Collection
                        </a>
                        <a class="pl-4 py-2 text-sm font-medium text-text-muted hover:text-text-main hover:border-l-2 hover:border-gray-300 dark:hover:border-gray-600 -ml-[1px] transition-all"
                            href="#usage">
                            3. How We Use Data
                        </a>
                        <a class="pl-4 py-2 text-sm font-medium text-text-muted hover:text-text-main hover:border-l-2 hover:border-gray-300 dark:hover:border-gray-600 -ml-[1px] transition-all"
                            href="#cookies">
                            4. Cookies &amp; Tracking
                        </a>
                        <a class="pl-4 py-2 text-sm font-medium text-text-muted hover:text-text-main hover:border-l-2 hover:border-gray-300 dark:hover:border-gray-600 -ml-[1px] transition-all"
                            href="#sharing">
                            5. Third-Party Disclosure
                        </a>
                        <a class="pl-4 py-2 text-sm font-medium text-text-muted hover:text-text-main hover:border-l-2 hover:border-gray-300 dark:hover:border-gray-600 -ml-[1px] transition-all"
                            href="#rights">
                            6. User Rights &amp; GDPR
                        </a>
                        <a class="pl-4 py-2 text-sm font-medium text-text-muted hover:text-text-main hover:border-l-2 hover:border-gray-300 dark:hover:border-gray-600 -ml-[1px] transition-all"
                            href="#contact">
                            7. Contact Us
                        </a>
                    </nav>
                    <div class="mt-8 p-4 bg-secondary dark:bg-gray-800 rounded-lg">
                        <p class="text-xs text-text-muted mb-3 font-medium">Need help with your data?</p>
                        <a class="flex items-center gap-2 text-sm font-bold text-primary hover:text-primary-dark"
                            href="mailto:unihunt.overseas@gmail.com">
                            <span class="material-symbols-outlined text-[18px]">mail</span>
                            Contact DPO
                        </a>
                    </div>
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
                            Privacy Policy</h1>
                        <div class="flex items-center gap-2 text-text-muted">
                            <span class="material-symbols-outlined text-[18px]">calendar_today</span>
                            <span class="text-sm font-medium">Last Updated: October 24, 2023</span>
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
                            At UniHunt Global ("we," "our," or "us"), we are committed to protecting your privacy
                            and ensuring the security of your personal information. This Privacy Policy outlines how
                            we collect, use, disclose, and safeguard your data when you visit our website or use our
                            university discovery platform.
                        </p>
                        <p class="leading-relaxed">
                            By accessing or using our services, you signify that you have read, understood, and
                            agree to our collection, storage, use, and disclosure of your personal information as
                            described in this Privacy Policy and our Terms of Service.
                        </p>
                    </section>
                    <section class="mb-12 scroll-mt-24" id="collection">
                        <h2
                            class="font-serif text-2xl font-bold text-text-main dark:text-white mb-4 flex items-center gap-3">
                            <span class="text-primary/40 dark:text-primary/60 font-sans text-lg font-bold">02</span>
                            Information Collection
                        </h2>
                        <p class="leading-relaxed mb-6">
                            We collect information that you provide directly to us when you create an account,
                            update your profile, or communicate with us. This includes:
                        </p>
                        <div class="grid md:grid-cols-2 gap-4 mb-6">
                            <div
                                class="p-4 rounded-lg border border-gray-100 dark:border-gray-800 bg-background-light dark:bg-gray-900/50">
                                <div class="flex items-center gap-2 mb-2 text-primary font-bold text-sm">
                                    <span class="material-symbols-outlined text-[18px]">badge</span>
                                    Personal Identity
                                </div>
                                <p class="text-sm text-text-muted">Name, email address, phone number, and date of
                                    birth required for account creation.</p>
                            </div>
                            <div
                                class="p-4 rounded-lg border border-gray-100 dark:border-gray-800 bg-background-light dark:bg-gray-900/50">
                                <div class="flex items-center gap-2 mb-2 text-primary font-bold text-sm">
                                    <span class="material-symbols-outlined text-[18px]">school</span>
                                    Academic Profile
                                </div>
                                <p class="text-sm text-text-muted">Educational history, GPA, test scores (SAT,
                                    IELTS, TOEFL), and intended major.</p>
                            </div>
                        </div>
                        <p class="leading-relaxed mb-4">
                            Additionally, we automatically collect certain data when you interact with our platform:
                        </p>
                        <ul class="list-disc list-outside ml-5 space-y-2 marker:text-primary">
                            <li><strong>Device Information:</strong> IP address, browser type, operating system, and
                                device identifiers.</li>
                            <li><strong>Usage Data:</strong> Pages viewed, time spent on pages, links clicked, and
                                search queries.</li>
                            <li><strong>Location Data:</strong> Approximate location based on IP address to suggest
                                relevant regional universities.</li>
                        </ul>
                    </section>
                    <section class="mb-12 scroll-mt-24" id="usage">
                        <h2
                            class="font-serif text-2xl font-bold text-text-main dark:text-white mb-4 flex items-center gap-3">
                            <span class="text-primary/40 dark:text-primary/60 font-sans text-lg font-bold">03</span>
                            How We Use Data
                        </h2>
                        <p class="leading-relaxed mb-4">
                            The primary purpose of collecting data is to provide you with a personalized university
                            discovery experience. Specifically, we use your information to:
                        </p>
                        <div class="space-y-4">
                            <div class="flex gap-4">
                                <div class="w-1 h-auto bg-primary/20 rounded-full"></div>
                                <div>
                                    <h4 class="font-bold text-text-main dark:text-white text-base">Matchmaking
                                        Algorithms</h4>
                                    <p class="text-sm mt-1">Calculate your admission chances and match you with
                                        universities that fit your academic profile and preferences.</p>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div class="w-1 h-auto bg-primary/20 rounded-full"></div>
                                <div>
                                    <h4 class="font-bold text-text-main dark:text-white text-base">Application
                                        Management</h4>
                                    <p class="text-sm mt-1">Facilitate the submission of applications directly to
                                        partner institutions through our portal.</p>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <div class="w-1 h-auto bg-primary/20 rounded-full"></div>
                                <div>
                                    <h4 class="font-bold text-text-main dark:text-white text-base">Platform
                                        Improvement</h4>
                                    <p class="text-sm mt-1">Analyze user behavior to improve our search
                                        functionality, user interface, and service offerings.</p>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section class="mb-12 scroll-mt-24" id="cookies">
                        <h2
                            class="font-serif text-2xl font-bold text-text-main dark:text-white mb-4 flex items-center gap-3">
                            <span class="text-primary/40 dark:text-primary/60 font-sans text-lg font-bold">04</span>
                            Cookies &amp; Tracking
                        </h2>
                        <p class="leading-relaxed mb-4">
                            We use cookies and similar tracking technologies to track the activity on our Service
                            and hold certain information. You can instruct your browser to refuse all cookies or to
                            indicate when a cookie is being sent.
                        </p>
                        <div
                            class="bg-blue-50 dark:bg-blue-900/20 p-5 rounded-lg border border-blue-100 dark:border-blue-900/30 flex gap-3 items-start">
                            <span class="material-symbols-outlined text-primary mt-0.5">info</span>
                            <div class="text-sm">
                                <p class="font-bold text-text-main dark:text-white mb-1">Cookie Preferences</p>
                                <p>You can change your cookie preferences at any time by clicking the "Cookie
                                    Settings" link in the footer of our website. Essential cookies cannot be
                                    disabled as they are required for the site to function.</p>
                            </div>
                        </div>
                    </section>
                    <section class="mb-12 scroll-mt-24" id="sharing">
                        <h2
                            class="font-serif text-2xl font-bold text-text-main dark:text-white mb-4 flex items-center gap-3">
                            <span class="text-primary/40 dark:text-primary/60 font-sans text-lg font-bold">05</span>
                            Third-Party Disclosure
                        </h2>
                        <p class="leading-relaxed mb-4">
                            We do not sell, trade, or otherwise transfer to outside parties your Personally
                            Identifiable Information unless we provide users with advance notice. This does not
                            include website hosting partners and other parties who assist us in operating our
                            website, conducting our business, or serving our users.
                        </p>
                        <p class="leading-relaxed">
                            However, non-personally identifiable visitor information may be provided to other
                            parties for marketing, advertising, or other uses. When you apply to a university
                            through UniHunt, your relevant academic data is shared securely with that specific
                            institution.
                        </p>
                    </section>
                    <section class="mb-12 scroll-mt-24" id="rights">
                        <h2
                            class="font-serif text-2xl font-bold text-text-main dark:text-white mb-4 flex items-center gap-3">
                            <span class="text-primary/40 dark:text-primary/60 font-sans text-lg font-bold">06</span>
                            User Rights &amp; GDPR
                        </h2>
                        <p class="leading-relaxed mb-4">
                            If you are a resident of the European Economic Area (EEA), you have certain data
                            protection rights. UniHunt aims to take reasonable steps to allow you to correct, amend,
                            delete, or limit the use of your Personal Data.
                        </p>
                        <div class="grid sm:grid-cols-2 gap-3">
                            <div class="flex items-center gap-3 p-3 bg-secondary dark:bg-gray-800 rounded">
                                <span class="material-symbols-outlined text-primary">check_circle</span>
                                <span class="text-sm font-medium">Right to Access</span>
                            </div>
                            <div class="flex items-center gap-3 p-3 bg-secondary dark:bg-gray-800 rounded">
                                <span class="material-symbols-outlined text-primary">check_circle</span>
                                <span class="text-sm font-medium">Right to Rectification</span>
                            </div>
                            <div class="flex items-center gap-3 p-3 bg-secondary dark:bg-gray-800 rounded">
                                <span class="material-symbols-outlined text-primary">check_circle</span>
                                <span class="text-sm font-medium">Right to Erasure</span>
                            </div>
                            <div class="flex items-center gap-3 p-3 bg-secondary dark:bg-gray-800 rounded">
                                <span class="material-symbols-outlined text-primary">check_circle</span>
                                <span class="text-sm font-medium">Right to Restriction</span>
                            </div>
                        </div>
                    </section>
                    <section class="mb-12 scroll-mt-24" id="contact">
                        <h2
                            class="font-serif text-2xl font-bold text-text-main dark:text-white mb-4 flex items-center gap-3">
                            <span class="text-primary/40 dark:text-primary/60 font-sans text-lg font-bold">07</span>
                            Contact Us
                        </h2>
                        <p class="leading-relaxed mb-6">
                            If you have any questions about this Privacy Policy, please contact us:
                        </p>
                        <div class="bg-primary text-white p-6 rounded-xl relative overflow-hidden">
                            <div class="absolute top-0 right-0 opacity-10 -mr-10 -mt-10">
                                <span class="material-symbols-outlined text-[150px]">gavel</span>
                            </div>
                            <div class="relative z-10 grid md:grid-cols-2 gap-8">
                                <div>
                                    <p class="text-xs uppercase tracking-widest opacity-70 mb-1">Email Support</p>
                                    <a class="text-xl font-bold hover:underline"
                                        href="mailto:unihunt.overseas@gmail.com">unihunt.overseas@gmail.com</a>
                                    <p class="text-sm opacity-80 mt-2">Typical response time: 24-48 hours</p>
                                </div>
                                <div>
                                    <p class="text-xs uppercase tracking-widest opacity-70 mb-1">Mailing Address</p>
                                    <address class="not-italic font-medium">
                                        UniHunt Global HQ<br />
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
<!-- Footer -->

<?= view('web/include/footer') ?>