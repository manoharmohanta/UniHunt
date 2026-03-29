<?= view('web/include/header', ['title' => 'No Refund Policy | UniHunt', 'bodyClass' => 'bg-background-light dark:bg-background-dark text-text-main font-display antialiased min-h-screen flex flex-col']) ?>

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
                    <span class="text-text-main dark:text-white font-medium">No Refund Policy</span>
                </nav>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Layout -->
<main class="flex-grow bg-white dark:bg-[#1e2526]">
    <div class="px-4 md:px-8 xl:px-40 flex justify-center pb-20 pt-8">
        <div class="w-full max-w-[1280px]">
            <article class="max-w-[800px] mx-auto">
                <div class="mb-10 pb-8 border-b border-gray-200 dark:border-gray-700">
                    <h1
                        class="font-serif text-4xl md:text-5xl font-bold text-text-main dark:text-white mb-4 tracking-tight">
                        No Refund Policy
                    </h1>
                    <div class="flex items-center gap-2 text-text-muted">
                        <span class="material-symbols-outlined text-[18px]">calendar_today</span>
                        <span class="text-sm font-medium">Last Updated: <?= date('F d, Y') ?></span>
                    </div>
                </div>

                <div
                    class="prose prose-lg dark:prose-invert max-w-none text-text-main/80 dark:text-gray-300 font-light">
                    <section class="mb-12">
                        <h2
                            class="font-serif text-2xl font-bold text-text-main dark:text-white mb-4 flex items-center gap-3">
                            <span class="text-primary/40 dark:text-primary/60 font-sans text-lg font-bold">01</span>
                            General Policy
                        </h2>
                        <p class="leading-relaxed mb-4">
                            At <strong>UniHunt</strong>, we are committed to providing high-quality digital services,
                            including
                            AI-powered tools, university applications, and counselling sessions. Due to the nature of
                            our
                            digital products and services, <strong>all sales are final and non-refundable</strong>.
                        </p>
                    </section>

                    <section class="mb-12">
                        <h2
                            class="font-serif text-2xl font-bold text-text-main dark:text-white mb-4 flex items-center gap-3">
                            <span class="text-primary/40 dark:text-primary/60 font-sans text-lg font-bold">02</span>
                            Digital Products & AI Tools
                        </h2>
                        <p class="leading-relaxed mb-4">
                            Our AI tools (including but not limited to SOP Generator, Resume Builder, Visa Chance
                            Predictor, and
                            Mock Interview simulations) provide immediate access to digital content and generated
                            results. Once
                            a service has been used or a document generated, it consumes computing resources and
                            intellectual
                            property that cannot be returned. Therefore, we do not offer refunds for any AI tool usage
                            or
                            credits purchased.
                        </p>
                    </section>

                    <section class="mb-12">
                        <h2
                            class="font-serif text-2xl font-bold text-text-main dark:text-white mb-4 flex items-center gap-3">
                            <span class="text-primary/40 dark:text-primary/60 font-sans text-lg font-bold">03</span>
                            Subscriptions & Sessions
                        </h2>
                        <p class="leading-relaxed mb-4">
                            Subscription fees for premium plans are non-refundable. If you choose to cancel your
                            subscription,
                            you will continue to have access to premium features until the end of your current billing
                            cycle.
                        </p>
                        <p class="leading-relaxed mb-4">
                            Bookings for live counselling sessions or mock interviews are non-refundable once the
                            session has
                            been confirmed. Rescheduling may be permitted if requested at least 24 hours in advance.
                        </p>
                    </section>

                    <section class="mb-12">
                        <h2
                            class="font-serif text-2xl font-bold text-text-main dark:text-white mb-4 flex items-center gap-3">
                            <span class="text-primary/40 dark:text-primary/60 font-sans text-lg font-bold">04</span>
                            Exceptional Circumstances
                        </h2>
                        <p class="leading-relaxed mb-4">
                            We may consider refund requests only in exceptional circumstances:
                        </p>
                        <ul class="list-disc list-outside ml-5 space-y-2 marker:text-primary">
                            <li>Duplicate payments for the same transaction due to technical error.</li>
                            <li>Service failure where the tool explicitly failed to function as described.</li>
                        </ul>
                        <p class="mt-6 leading-relaxed">
                            All such requests must be submitted within <strong>7 days</strong> of the transaction date
                            to
                            <a href="mailto:unihunt.overseas@gmail.com"
                                class="text-primary font-bold hover:underline">unihunt.overseas@gmail.com</a>.
                        </p>
                    </section>
                </div>
            </article>
        </div>
    </div>
</main>

<?= view('web/include/footer') ?>