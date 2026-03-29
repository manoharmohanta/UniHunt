<?= view('web/include/header', ['title' => $title]) ?>

<div class="flex min-h-screen bg-gray-50 dark:bg-background-dark">
    <?= view('agent/include/sidebar') ?>

    <main class="flex-1 p-6 md:p-10">
        <div class="max-w-3xl mx-auto">
            <header class="mb-8">
                <a href="<?= base_url('agent/ads') ?>"
                    class="text-sm text-primary hover:underline flex items-center gap-1 mb-4">
                    <span class="material-symbols-outlined text-sm">arrow_back</span> Back to Ads
                </a>
                <h1 class="text-3xl font-bold dark:text-white">Create New Advertisement</h1>
                <p class="text-gray-500">Reach thousands of students searching for their ideal university.</p>
            </header>

            <form action="<?= base_url('agent/ads/store') ?>" method="POST" enctype="multipart/form-data"
                class="space-y-6 flex flex-col items-stretch">
                <?= csrf_field() ?>

                <div
                    class="bg-white dark:bg-card-dark p-8 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm space-y-6 flex flex-col items-stretch">
                    <div>
                        <label class="block text-sm font-bold mb-2 dark:text-gray-200">Ad Campaign Title</label>
                        <input type="text" name="title" required placeholder="e.g. Autumn Webinar Promo"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-transparent outline-none focus:ring-2 focus:ring-primary/20 transition-all">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-bold mb-2 dark:text-gray-200">Ad Format</label>
                            <select name="format"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 outline-none">
                                <option value="banner">Standard Banner</option>
                                <option value="native">Native Card</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2 dark:text-gray-200">Target Placement</label>
                            <select name="placement" id="ad_placement"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 outline-none">
                                <option value="home_top">Homepage Hero Area</option>
                                <option value="university_sidebar">University Search Sidebar</option>
                                <option value="dashboard_main">User Dashboard</option>
                                <option value="score_page">AI Result Pages</option>
                                <option value="course_requirements_bottom">Course List Entry Requirements</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2 dark:text-gray-200">Duration (Days)</label>
                            <input type="number" name="total_days" id="total_days" value="30" min="1" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-transparent outline-none focus:ring-2 focus:ring-primary/20 transition-all">
                        </div>
                    </div>

                    <div class="border-t border-gray-100 dark:border-gray-800 pt-6">
                        <h3 class="font-bold mb-4 dark:text-white">Ad Creative</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">Banner Image (Recommended 1200x400 for
                                    Page Top, 400x400 for Sidebar)</label>
                                <input type="file" name="ad_image" required
                                    class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">Landing Page URL</label>
                                <input type="url" name="link_url" required placeholder="https://yourwebsite.com/landing"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-transparent outline-none focus:ring-2 focus:ring-primary/20 transition-all">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">Call to Action Text</label>
                                <input type="text" name="cta_text" required placeholder="e.g. Register Now"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-transparent outline-none focus:ring-2 focus:ring-primary/20 transition-all">
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    class="flex items-center justify-between p-6 bg-primary/5 dark:bg-primary/10 rounded-2xl border border-primary/20 shrink-0">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-primary">payments</span>
                        <div>
                            <p class="font-bold dark:text-white" id="price_display">Ad Cost: ₹0.00</p>
                            <p class="text-xs text-gray-500" id="duration_display">Includes 30 days of standard
                                rotation.</p>
                        </div>
                    </div>
                    <button type="submit"
                        class="bg-primary text-white font-bold py-3 px-8 rounded-xl hover:scale-105 transition-transform">
                        Confirm & Proceed to Pay
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const placementSelect = document.getElementById('ad_placement');
        const durationInput = document.getElementById('total_days');
        const priceDisplay = document.getElementById('price_display');
        const durationDisplay = document.getElementById('duration_display');

        const pricing = {
            per_day: parseFloat(<?= esc($settings['ad_price_per_day'] ?? '199.00') ?>),
            placements: {
                'home_top': parseFloat(<?= esc($settings['ad_price_home_top'] ?? '120.00') ?>),
                'university_sidebar': parseFloat(<?= esc($settings['ad_price_university_sidebar'] ?? '150.00') ?>),
                'dashboard_main': parseFloat(<?= esc($settings['ad_price_dashboard_main'] ?? '99.00') ?>),
                'score_page': parseFloat(<?= esc($settings['ad_price_score_page'] ?? '199.00') ?>),
                'course_requirements_bottom': parseFloat(<?= esc($settings['ad_price_course_requirements_bottom'] ?? '150.00') ?>)
            }
        };

        function calculatePrice() {
            const days = parseInt(durationInput.value) || 0;
            const placement = placementSelect.value;
            const baseCost = pricing.placements[placement] || 0;
            const totalCost = (pricing.per_day * days) + baseCost;

            priceDisplay.innerHTML = `Ad Cost: ₹${totalCost.toFixed(2)}`;
            durationDisplay.innerHTML = `Includes ${days} days of standard rotation.`;
        }

        placementSelect.addEventListener('change', calculatePrice);
        durationInput.addEventListener('input', calculatePrice);

        // Initial calculation
        calculatePrice();
    });
</script>

<?= view('web/include/footer') ?>