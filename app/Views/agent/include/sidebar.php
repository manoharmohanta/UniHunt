<aside class="w-64 bg-white dark:bg-card-dark border-r border-gray-200 dark:border-gray-800 hidden md:block">
    <div class="p-6">
        <h2 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4">Agent Menu</h2>
        <nav class="space-y-1">
            <a href="<?= base_url('agent/dashboard') ?>"
                class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg <?= (current_url() == base_url('agent/dashboard')) ? 'bg-primary/10 text-primary' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800' ?> transition-all">
                <span class="material-symbols-outlined">dashboard</span>
                Dashboard
            </a>
            <a href="<?= base_url('agent/events') ?>"
                class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg <?= (strpos(current_url(), 'agent/events') !== false) ? 'bg-primary/10 text-primary' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800' ?> transition-all">
                <span class="material-symbols-outlined">event</span>
                My Events
            </a>
            <a href="<?= base_url('agent/ads') ?>"
                class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg <?= (strpos(current_url(), 'agent/ads') !== false) ? 'bg-primary/10 text-primary' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800' ?> transition-all">
                <span class="material-symbols-outlined">ads_click</span>
                My Ads
            </a>
            <a href="<?= base_url('agent/reports') ?>"
                class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-lg <?= (strpos(current_url(), 'agent/reports') !== false) ? 'bg-primary/10 text-primary' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800' ?> transition-all">
                <span class="material-symbols-outlined">analytics</span>
                Ad Reports
            </a>
        </nav>
    </div>
</aside>