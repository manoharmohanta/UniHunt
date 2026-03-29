<?= view('web/include/header', ['title' => $title]) ?>

<div class="flex min-h-screen bg-gray-50 dark:bg-background-dark">
    <!-- Sidebar -->
    <aside class="w-64 bg-white dark:bg-card-dark border-r border-gray-200 dark:border-gray-800 hidden md:block">
        <div class="p-6">
            <h2 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4">Agent Menu</h2>
            <nav class="space-y-1">
                <a href="<?= base_url('agent/dashboard') ?>"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg bg-primary/10 text-primary">
                    <span class="material-symbols-outlined">dashboard</span>
                    Dashboard
                </a>
                <a href="<?= base_url('agent/events') ?>"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
                    <span class="material-symbols-outlined">event</span>
                    My Events
                </a>
                <a href="<?= base_url('agent/ads') ?>"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
                    <span class="material-symbols-outlined">ads_click</span>
                    My Ads
                </a>
                <a href="<?= base_url('agent/reports') ?>"
                    class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 transition-all">
                    <span class="material-symbols-outlined">analytics</span>
                    Ad Reports
                </a>
            </nav>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6 md:p-10">
        <div class="max-w-6xl mx-auto">
            <header class="mb-10">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Welcome, Agent</h1>
                <p class="text-gray-600 dark:text-gray-400">Manage your events and advertisements from one place.</p>
            </header>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
                <div
                    class="bg-white dark:bg-card-dark p-6 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <span
                            class="p-2 bg-blue-50 dark:bg-blue-900/20 text-blue-600 rounded-lg material-symbols-outlined">campaign</span>
                    </div>
                    <h3 class="text-gray-500 dark:text-gray-400 text-sm font-medium">Total Ads</h3>
                    <p class="text-2xl font-bold dark:text-white">
                        <?= $stats['total_ads'] ?>
                    </p>
                </div>
                <div
                    class="bg-white dark:bg-card-dark p-6 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <span
                            class="p-2 bg-green-50 dark:bg-green-900/20 text-green-600 rounded-lg material-symbols-outlined">event_available</span>
                    </div>
                    <h3 class="text-gray-500 dark:text-gray-400 text-sm font-medium">Active Events</h3>
                    <p class="text-2xl font-bold dark:text-white">
                        <?= $stats['total_events'] ?>
                    </p>
                </div>
                <div
                    class="bg-white dark:bg-card-dark p-6 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <span
                            class="p-2 bg-purple-50 dark:bg-purple-900/20 text-purple-600 rounded-lg material-symbols-outlined">visibility</span>
                    </div>
                    <h3 class="text-gray-500 dark:text-gray-400 text-sm font-medium">Ad Impressions</h3>
                    <p class="text-2xl font-bold dark:text-white">
                        <?= number_format($stats['ad_impressions']) ?>
                    </p>
                </div>
                <div
                    class="bg-white dark:bg-card-dark p-6 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm">
                    <div class="flex items-center justify-between mb-4">
                        <span
                            class="p-2 bg-orange-50 dark:bg-orange-900/20 text-orange-600 rounded-lg material-symbols-outlined">touch_app</span>
                    </div>
                    <h3 class="text-gray-500 dark:text-gray-400 text-sm font-medium">Ad Clicks</h3>
                    <p class="text-2xl font-bold dark:text-white">
                        <?= number_format($stats['ad_clicks']) ?>
                    </p>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-primary p-8 rounded-3xl text-white relative overflow-hidden group shadow-xl">
                    <div class="relative z-10">
                        <h2 class="text-2xl font-bold mb-4">Reach More Students</h2>
                        <p class="text-primary-foreground/80 mb-6 max-w-xs">Post targeted advertisements and get
                            detailed reports on their performance.</p>
                        <a href="<?= base_url('agent/ads/create') ?>"
                            class="inline-flex items-center gap-2 bg-white text-primary px-6 py-3 rounded-xl font-bold hover:scale-105 transition-transform">
                            <span class="material-symbols-outlined">add</span>
                            Create Ad
                        </a>
                    </div>
                    <span
                        class="material-symbols-outlined absolute -right-8 -bottom-8 text-white/10 text-9xl rotate-12 group-hover:rotate-0 transition-transform duration-500">ads_click</span>
                </div>

                <div class="bg-secondary p-8 rounded-3xl text-white relative overflow-hidden group shadow-xl">
                    <div class="relative z-10">
                        <h2 class="text-2xl font-bold mb-4">Promote Your Events</h2>
                        <p class="text-white/80 mb-6 max-w-xs">List your webinars, fairs, and seminars to the global
                            UniHunt community.</p>
                        <a href="<?= base_url('agent/events/create') ?>"
                            class="inline-flex items-center gap-2 bg-white text-secondary px-6 py-3 rounded-xl font-bold hover:scale-105 transition-transform">
                            <span class="material-symbols-outlined">add</span>
                            Add Event
                        </a>
                    </div>
                    <span
                        class="material-symbols-outlined absolute -right-8 -bottom-8 text-white/10 text-9xl -rotate-12 group-hover:rotate-0 transition-transform duration-500">event</span>
                </div>
            </div>
        </div>
    </main>
</div>

<?= view('web/include/footer') ?>