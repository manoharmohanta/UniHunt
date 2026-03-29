<?= view('web/include/header', ['bodyClass' => 'bg-background-light dark:bg-background-dark font-display text-text-main antialiased min-h-screen flex flex-col']) ?>

<main class="flex-grow w-full max-w-7xl mx-auto px-4 md:px-10 lg:px-40 py-10">
    <div class="mb-10 text-center">
        <h1 class="text-4xl font-extrabold text-text-main dark:text-white mb-4">Frequently Asked Questions</h1>
        <p class="text-text-muted dark:text-gray-400 max-w-2xl mx-auto">
            Find answers to common questions about accounts, applications, and our AI tools.
        </p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Sidebar Navigation -->
        <div class="lg:col-span-1 space-y-2">
            <h3 class="font-bold text-text-main dark:text-white mb-4 px-3">Categories</h3>
            <?php foreach ($faqs as $key => $category) : ?>
                <a href="?category=<?= $key ?>" 
                   class="block px-4 py-3 rounded-lg text-sm font-medium transition-all <?= $activeCategory === $key ? 'bg-primary text-white shadow-md' : 'text-text-secondary dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800' ?>">
                    <?= esc($category['title']) ?>
                </a>
            <?php endforeach ?>
            
            <div class="mt-8 p-4 bg-primary/5 rounded-xl border border-primary/10">
                <p class="text-xs font-bold text-primary mb-1">Still stuck?</p>
                <p class="text-xs text-text-secondary dark:text-gray-400 mb-3">Our support team is just a click away.</p>
                <a href="<?= base_url('contact') ?>" class="block w-full text-center py-2 rounded-lg bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-xs font-bold text-text-main dark:text-white hover:border-primary transition-colors">
                    Contact Support
                </a>
            </div>
        </div>

        <!-- FAQ Content -->
        <div class="lg:col-span-3">
            <?php if (isset($faqs[$activeCategory])) : ?>
                <h2 class="text-2xl font-bold text-text-main dark:text-white mb-6">
                    <?= esc($faqs[$activeCategory]['title']) ?>
                </h2>

                <div class="space-y-4">
                    <?php foreach ($faqs[$activeCategory]['items'] as $index => $item) : ?>
                        <div class="border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden bg-white dark:bg-surface-dark shadow-sm">
                            <button class="w-full flex items-center justify-between p-5 text-left focus:outline-none" onclick="toggleFaq('faq-<?= $index ?>')">
                                <span class="font-bold text-text-main dark:text-gray-200"><?= esc($item['q']) ?></span>
                                <span id="icon-faq-<?= $index ?>" class="material-symbols-outlined text-gray-400 transition-transform duration-300">expand_more</span>
                            </button>
                            <div id="faq-<?= $index ?>" class="hidden px-5 pb-5 text-text-secondary dark:text-gray-400 text-sm leading-relaxed border-t border-gray-100 dark:border-gray-800 pt-4">
                                <?= esc($item['a']) ?>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>
            <?php else : ?>
                <p class="text-center text-gray-500 py-10">Category not found.</p>
            <?php endif ?>
        </div>
    </div>
</main>

<script>
    function toggleFaq(id) {
        const content = document.getElementById(id);
        const icon = document.getElementById('icon-' + id);
        
        if (content.classList.contains('hidden')) {
            content.classList.remove('hidden');
            icon.classList.add('rotate-180');
        } else {
            content.classList.add('hidden');
            icon.classList.remove('rotate-180');
        }
    }
</script>

<?= view('web/include/footer') ?>
