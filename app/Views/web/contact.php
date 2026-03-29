<?= view('web/include/header', ['title' => 'Contact &amp; Help Center - UniHunt', 'bodyClass' => 'bg-background-light dark:bg-background-dark font-display text-text-main antialiased min-h-screen flex flex-col']) ?>

<main class="flex-grow w-full max-w-7xl mx-auto px-4 md:px-10 lg:px-40 py-10">
    <!-- Hero & Search Section -->
    <section class="flex flex-col items-center justify-center py-10 md:py-16 gap-6 text-center">
        <div class="space-y-3 max-w-2xl">
            <h1 class="text-4xl md:text-5xl font-extrabold text-text-main dark:text-white tracking-tight leading-[1.1]">
                How can we <span class="text-primary">help you?</span>
            </h1>
            <p class="text-text-muted dark:text-gray-400 text-lg">
                Find answers to your questions about applications, scholarships, and more.
            </p>
        </div>
        <!-- Search Bar -->
        <form action="<?= base_url('blog') ?>" method="GET" class="w-full max-w-xl relative mt-4 group">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <span
                    class="material-symbols-outlined text-text-muted group-focus-within:text-primary transition-colors">search</span>
            </div>
            <input
                class="block w-full pl-12 pr-4 py-4 rounded-xl border-0 bg-white dark:bg-surface-dark text-text-main dark:text-white shadow-soft ring-1 ring-gray-100 dark:ring-gray-700 placeholder:text-gray-400 focus:ring-2 focus:ring-primary focus:bg-white dark:focus:bg-surface-dark transition-all text-base"
                placeholder="Search for articles, guides, or FAQs..." type="text" name="q" id="detail_search" />
            <div class="absolute inset-y-0 right-2 flex items-center">
                <button type="submit"
                    class="bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-xs font-semibold px-2 py-1 rounded text-gray-500 dark:text-gray-300 transition-colors">
                    Search
                </button>
            </div>
        </form>
    </section>
    <!-- Bento Grid Categories -->
    <section class="py-8">
        <h2 class="sr-only">Help Categories</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Card 1 -->
            <a class="group flex flex-col p-6 rounded-xl bg-white dark:bg-surface-dark border border-gray-100 dark:border-gray-800 shadow-sm hover:shadow-md hover:border-primary/30 transition-all duration-300"
                href="<?= base_url('faq?category=account-support') ?>">
                <div
                    class="size-12 rounded-lg bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-blue-600 dark:text-blue-400 mb-4 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-2xl">account_circle</span>
                </div>
                <h3 class="text-lg font-bold text-text-main dark:text-white mb-1">Account Support</h3>
                <p class="text-sm text-text-muted dark:text-gray-400">Login issues, profile settings, and
                    verification.</p>
            </a>
            <!-- Card 2 -->
            <a class="group flex flex-col p-6 rounded-xl bg-white dark:bg-surface-dark border border-gray-100 dark:border-gray-800 shadow-sm hover:shadow-md hover:border-primary/30 transition-all duration-300"
                href="<?= base_url('faq?category=application-tracking') ?>">
                <div
                    class="size-12 rounded-lg bg-purple-50 dark:bg-purple-900/20 flex items-center justify-center text-purple-600 dark:text-purple-400 mb-4 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-2xl">assignment</span>
                </div>
                <h3 class="text-lg font-bold text-text-main dark:text-white mb-1">Application Tracking</h3>
                <p class="text-sm text-text-muted dark:text-gray-400">Status updates, submission errors, and
                    deadlines.</p>
            </a>
            <!-- Card 3 -->
            <a class="group flex flex-col p-6 rounded-xl bg-white dark:bg-surface-dark border border-gray-100 dark:border-gray-800 shadow-sm hover:shadow-md hover:border-primary/30 transition-all duration-300"
                href="<?= base_url('faq?category=ai-tools-help') ?>">
                <div
                    class="size-12 rounded-lg bg-orange-50 dark:bg-orange-900/20 flex items-center justify-center text-orange-600 dark:text-orange-400 mb-4 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-2xl">smart_toy</span>
                </div>
                <h3 class="text-lg font-bold text-text-main dark:text-white mb-1">AI Tools Help</h3>
                <p class="text-sm text-text-muted dark:text-gray-400">Resume builder, essay assistant, and AI
                    coaching.</p>
            </a>
            <!-- Card 4 -->
            <a class="group flex flex-col p-6 rounded-xl bg-white dark:bg-surface-dark border border-gray-100 dark:border-gray-800 shadow-sm hover:shadow-md hover:border-primary/30 transition-all duration-300"
                href="<?= base_url('faq?category=scholarships') ?>">
                <div
                    class="size-12 rounded-lg bg-primary/10 flex items-center justify-center text-primary mb-4 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-2xl">school</span>
                </div>
                <h3 class="text-lg font-bold text-text-main dark:text-white mb-1">Scholarships</h3>
                <p class="text-sm text-text-muted dark:text-gray-400">Finding funding, application guides, and
                    eligibility.</p>
            </a>
        </div>
    </section>
    <!-- Contact Split Section -->
    <section class="mt-12 grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Contact Form (Left - 2 Cols) -->
        <div
            class="lg:col-span-2 bg-white dark:bg-surface-dark rounded-xl p-6 md:p-8 shadow-soft border border-gray-100 dark:border-gray-800">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-text-main dark:text-white">Still need help? Send us a message.
                </h2>
                <p class="text-text-muted dark:text-gray-400 mt-1">Our team typically responds within 24 hours.</p>
            </div>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400"
                    role="alert">
                    <span class="font-medium">Success!</span> <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                    role="alert">
                    <span class="font-medium">Error!</span> <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('errors')): ?>
                <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                    role="alert">
                    <ul class="list-disc pl-5">
                        <?php foreach (session()->getFlashdata('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form class="space-y-5" method="POST" action="<?= base_url('contact') ?>">
                <?= csrf_field() ?>
                <?= honeypot_field() ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="space-y-1.5">
                        <label class="block text-sm font-medium text-text-main dark:text-gray-200" for="name">Full
                            Name</label>
                        <input
                            class="block w-full rounded-lg border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-text-main dark:text-white shadow-sm focus:border-primary focus:ring-primary sm:text-sm py-3 px-4"
                            id="name" name="name" placeholder="Jane Doe" type="text" required
                            value="<?= old('name') ?>" />
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-sm font-medium text-text-main dark:text-gray-200" for="email">Email
                            Address</label>
                        <input
                            class="block w-full rounded-lg border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-text-main dark:text-white shadow-sm focus:border-primary focus:ring-primary sm:text-sm py-3 px-4"
                            id="email" name="email" placeholder="jane@example.com" type="email" required
                            value="<?= old('email') ?>" />
                    </div>
                </div>
                <div class="space-y-1.5">
                    <label class="block text-sm font-medium text-text-main dark:text-gray-200"
                        for="subject">Subject</label>
                    <select
                        class="block w-full rounded-lg border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-text-main dark:text-white shadow-sm focus:border-primary focus:ring-primary sm:text-sm py-3 px-4"
                        id="subject" name="subject">
                        <option value="General Inquiry" <?= old('subject') == 'General Inquiry' ? 'selected' : '' ?>>
                            General Inquiry</option>
                        <option value="Technical Support" <?= old('subject') == 'Technical Support' ? 'selected' : '' ?>>
                            Technical Support</option>
                        <option value="Billing Question" <?= old('subject') == 'Billing Question' ? 'selected' : '' ?>>
                            Billing Question</option>
                        <option value="Partnership" <?= old('subject') == 'Partnership' ? 'selected' : '' ?>>Partnership
                        </option>
                    </select>
                </div>
                <div class="space-y-1.5">
                    <label class="block text-sm font-medium text-text-main dark:text-gray-200"
                        for="message">Message</label>
                    <textarea
                        class="block w-full rounded-lg border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 text-text-main dark:text-white shadow-sm focus:border-primary focus:ring-primary sm:text-sm py-3 px-4"
                        id="message" name="message" placeholder="Describe your issue in detail..." rows="4"
                        required><?= old('message') ?></textarea>
                </div>
                <div class="pt-2">
                    <button
                        class="inline-flex items-center justify-center rounded-lg bg-primary px-6 py-3 text-sm font-bold text-white shadow-sm hover:bg-primary/90 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition-all w-full sm:w-auto"
                        type="submit">
                        Submit Request
                    </button>
                </div>
            </form>
        </div>
        <!-- Direct Support Sidebar (Right - 1 Col) -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Live Chat Card -->
            <div class="bg-primary text-white rounded-xl p-6 shadow-md relative overflow-hidden group">
                <!-- Abstract Pattern Background -->
                <div
                    class="absolute -right-4 -top-4 bg-white/10 w-24 h-24 rounded-full blur-xl group-hover:scale-150 transition-transform duration-700">
                </div>
                <div
                    class="absolute -left-4 -bottom-4 bg-white/10 w-20 h-20 rounded-full blur-xl group-hover:scale-150 transition-transform duration-700">
                </div>
                <div class="relative z-10 flex flex-col items-start gap-4 h-full justify-between">
                    <div>
                        <div class="bg-white/20 w-fit p-2 rounded-lg mb-3">
                            <span class="material-symbols-outlined text-2xl">chat</span>
                        </div>
                        <h3 class="text-xl font-bold mb-1">Direct Support</h3>
                        <p class="text-white/80 text-sm">Need a quick answer? Chat with our support team in
                            real-time.</p>
                    </div>
                    <button
                        class="w-full bg-white text-primary font-bold py-3 px-4 rounded-lg hover:bg-gray-50 transition-colors flex items-center justify-center gap-2">
                        Start Live Chat
                    </button>
                </div>
            </div>
            <!-- Info Card -->
            <div
                class="bg-white dark:bg-surface-dark rounded-xl p-6 border border-gray-100 dark:border-gray-800 shadow-soft">
                <h4 class="font-bold text-text-main dark:text-white mb-4">Other ways to connect</h4>
                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-primary mt-0.5">mail</span>
                        <div>
                            <p class="text-xs font-semibold text-text-muted dark:text-gray-400 uppercase tracking-wide">
                                General Support</p>
                            <a class="text-text-main dark:text-white hover:text-primary dark:hover:text-primary font-medium transition-colors"
                                href="mailto:unihunt.overseas@gmail.com">unihunt.overseas@gmail.com</a>
                        </div>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-primary mt-0.5">business_center</span>
                        <div>
                            <p class="text-xs font-semibold text-text-muted dark:text-gray-400 uppercase tracking-wide">
                                Partnerships</p>
                            <a class="text-text-main dark:text-white hover:text-primary dark:hover:text-primary font-medium transition-colors"
                                href="mailto:unihunt.overseas@gmail.com">unihunt.overseas@gmail.com</a>
                        </div>
                    </div>
                    <hr class="border-gray-100 dark:border-gray-800 my-2" />
                    <div>
                        <p
                            class="text-xs font-semibold text-text-muted dark:text-gray-400 uppercase tracking-wide mb-3">
                            Follow us</p>
                        <div class="flex gap-3">
                            <a class="size-10 rounded-full bg-gray-50 dark:bg-gray-800 flex items-center justify-center text-text-muted dark:text-gray-400 hover:bg-primary/10 hover:text-primary transition-colors"
                                href="#">
                                <svg aria-hidden="true" class="w-5 h-5 fill-current" viewbox="0 0 24 24">
                                    <path
                                        d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84">
                                    </path>
                                </svg>
                            </a>
                            <a class="size-10 rounded-full bg-gray-50 dark:bg-gray-800 flex items-center justify-center text-text-muted dark:text-gray-400 hover:bg-primary/10 hover:text-primary transition-colors"
                                href="#">
                                <svg aria-hidden="true" class="w-5 h-5 fill-current" viewbox="0 0 24 24">
                                    <path clip-rule="evenodd"
                                        d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.468 2.373c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                                        fill-rule="evenodd"></path>
                                </svg>
                            </a>
                            <a class="size-10 rounded-full bg-gray-50 dark:bg-gray-800 flex items-center justify-center text-text-muted dark:text-gray-400 hover:bg-primary/10 hover:text-primary transition-colors"
                                href="#">
                                <svg aria-hidden="true" class="w-5 h-5 fill-current" viewbox="0 0 24 24">
                                    <path clip-rule="evenodd"
                                        d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"
                                        fill-rule="evenodd"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<!-- Footer -->

<?= view('web/include/footer') ?>