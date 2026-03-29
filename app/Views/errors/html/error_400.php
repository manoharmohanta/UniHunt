<?= view('web/include/header', ['title' => 'Bad Request | UniHunt', 'bodyClass' => 'bg-background-light dark:bg-background-dark text-[#111816] dark:text-[#f0f4f3] font-display overflow-x-hidden antialiased selection:bg-primary/20 selection:text-primary']) ?>

<main class="flex-1 flex flex-col items-center justify-center min-h-[60vh] px-4 text-center">
    <div class="max-w-md w-full animate-fade-in-up">
        <div class="mb-8 relative inline-block">
            <h1 class="text-[120px] font-black text-gray-100 dark:text-gray-800 leading-none select-none">400</h1>
            <div class="absolute inset-0 flex items-center justify-center">
                <span class="material-symbols-outlined text-6xl text-amber-500 animate-pulse">warning</span>
            </div>
        </div>
        
        <h2 class="text-3xl md:text-4xl font-bold text-[#111816] dark:text-white mb-4">Bad Request</h2>
        <p class="text-lg text-gray-600 dark:text-gray-300 mb-8 max-w-sm mx-auto">
            <?php if (ENVIRONMENT !== 'production') : ?>
                <?= nl2br(esc($message)) ?>
            <?php else : ?>
                The request could not be understood by the server due to malformed syntax.
            <?php endif; ?>
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="<?= base_url() ?>" 
               class="inline-flex items-center justify-center gap-2 px-6 py-3 text-base font-bold text-white bg-primary hover:bg-primary-hover rounded-xl shadow-lg shadow-primary/20 transition-all hover:shadow-xl hover:-translate-y-0.5">
                <span class="material-symbols-outlined">home</span>
                Back to Home
            </a>
            <a href="javascript:history.back()" 
               class="inline-flex items-center justify-center gap-2 px-6 py-3 text-base font-bold text-[#111816] dark:text-white bg-white dark:bg-card-dark border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-xl transition-all hover:-translate-y-0.5">
                <span class="material-symbols-outlined">arrow_back</span>
                Go Back
            </a>
        </div>
    </div>
</main>

<?= view('web/include/footer') ?>
