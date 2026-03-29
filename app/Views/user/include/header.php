<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title><?= isset($title) ? $title : 'User Dashboard' ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('favicon_io/apple-touch-icon.webp') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('favicon_io/favicon-32x32.webp') ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('favicon_io/favicon-16x16.webp') ?>">
    <link rel="manifest" href="<?= base_url('favicon_io/site.webmanifest') ?>">
    <link rel="shortcut icon" href="<?= base_url('favicon_io/favicon.ico') ?>">
    <!-- CSS -->
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">

    <!-- Core Tools -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://unpkg.com/htmx.org@1.9.12"></script>
    <script src="https://unpkg.com/htmx.org/dist/ext/sse.js"></script>
    <script src="https://unpkg.com/htmx.org/dist/ext/ws.js"></script>
    <script>
        const hours = new Date().getHours();
        const isDayTime = hours >= 6 && hours < 18;

        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && !isDayTime)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }

        function toggleTheme() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.theme = 'light';
            } else {
                document.documentElement.classList.add('dark');
                localStorage.theme = 'dark';
            }
        }
    </script>
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 20px;
        }

        .dark .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #475569;
        }

        .kanban-column {
            min-width: 300px;
        }

        .material-symbols-outlined {
            font-family: 'Material Symbols Outlined';
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .icon-filled {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
</head>

<body
    class="<?= $bodyClass ?? 'bg-background-light dark:bg-background-dark text-slate-900 dark:text-white font-display antialiased overflow-hidden' ?>">
    <div class="flex h-screen w-full">
        <!-- Sidebar Navigation -->
        <aside
            class="w-72 h-full flex flex-col border-r border-border-light dark:border-border-dark bg-surface-light dark:bg-surface-dark flex-shrink-0 z-20 transition-all">
            <!-- Sidebar Logo -->
            <div class="px-6 py-6 border-b border-border-light dark:border-border-dark">
                <a href="<?= base_url() ?>" class="flex items-center gap-2">
                    <img src="<?= base_url('favicon_io/android-chrome-512x512.webp') ?>" class="w-8 h-8 object-contain"
                        alt="UniHunt">
                    <span class="text-xl font-bold tracking-tight uppercase">
                        <span class="text-primary dark:text-white">UNI</span><span class="text-secondary">HUNT</span>
                    </span>
                </a>
            </div>
            <!-- User Profile Header -->
            <div class="p-6 pb-2">
                <div class="flex items-center gap-3 mb-8">
                    <div class="relative group cursor-pointer">
                        <div class="w-12 h-12 rounded-full bg-cover bg-center border-2 border-primary/20"
                            style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBC54GiZxV3eJTH1MAlD6MR9vbAgfyePVohWiCI4m6_evGspWNszG4MM0pHF7ADXq4JTrubDgrvtraWIMN-lZy-iw8tNdGZBBjFqS8x0ziOOzlGayb39Zxx5E6ynvpRf1825281txyO6AnqtnasapRsLL6LKFerk0UHWNjX4hh66x8CII9VaqxwBYTJA2kPBmhSejgBdw6pvw384UuKaMW7c3yKdhbPYOJgcQWjdTrj3ol60jZX4UoEX6344r8MfkLn4jqd4uuRnfZV');">
                        </div>
                        <div
                            class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 rounded-full border-2 border-white dark:border-surface-dark">
                        </div>
                    </div>
                    <div class="flex flex-col">
                        <h2 class="text-base font-bold text-slate-900 dark:text-white leading-tight">
                            <?= session()->get('user_name') ?: 'User' ?>
                        </h2>
                        <p class="text-slate-500 dark:text-slate-400 text-xs font-medium">
                            <?= session()->get('user_role') ?: 'Student Account' ?>
                        </p>
                    </div>
                </div>
            </div>
            <!-- Navigation Links -->
            <nav class="flex-1 flex flex-col gap-1 px-3 overflow-y-auto custom-scrollbar">
                <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg <?= ($activePage == 'ai') ? 'bg-primary/10 text-primary dark:text-primary-400 font-semibold border-l-4 border-primary' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors group' ?>"
                    href="<?= base_url('ai-history') ?>">
                    <span
                        class="material-symbols-outlined text-[22px] <?= ($activePage == 'ai') ? 'icon-filled' : 'text-slate-400 group-hover:text-primary transition-colors' ?>">auto_awesome</span>
                    <span class="text-sm font-medium">AI Tools</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg <?= ($activePage == 'dashboard') ? 'bg-primary/10 text-primary dark:text-primary-400 font-semibold border-l-4 border-primary' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors group' ?>"
                    href="<?= base_url('dashboard') ?>">
                    <span
                        class="material-symbols-outlined text-[22px] <?= ($activePage == 'dashboard') ? 'icon-filled' : 'text-slate-400 group-hover:text-primary transition-colors' ?>">description</span>
                    <span class="text-sm font-medium">My Applications</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors group"
                    href="<?= base_url('dashboard') ?>#saved-courses">
                    <span
                        class="material-symbols-outlined text-[22px] text-slate-400 group-hover:text-primary transition-colors">bookmark</span>
                    <span class="text-sm font-medium">Saved Courses</span>
                </a>
                <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors group"
                    href="<?= base_url('universities') ?>">
                    <span
                        class="material-symbols-outlined text-[22px] text-slate-400 group-hover:text-primary transition-colors">account_balance</span>
                    <span class="text-sm font-medium">Browse Universities</span>
                </a>
            </nav>
            <!-- Bottom Actions -->
            <div class="p-4 border-t border-border-light dark:border-border-dark mt-auto">
                <button onclick="toggleTheme()"
                    class="flex items-center gap-3 px-3 py-2.5 mb-2 w-full rounded-lg text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                    <span class="material-symbols-outlined text-[22px] dark:hidden">dark_mode</span>
                    <span class="material-symbols-outlined text-[22px] hidden dark:block">light_mode</span>
                    <span class="text-sm font-medium">Toggle Appearance</span>
                </button>
                <a href="<?= base_url('logout') ?>"
                    class="flex items-center gap-3 px-3 py-2.5 w-full rounded-lg text-slate-500 dark:text-slate-400 hover:bg-red-50 hover:text-red-600 dark:hover:bg-red-900/20 dark:hover:text-red-400 transition-colors">
                    <span class="material-symbols-outlined text-[22px]">logout</span>
                    <span class="text-sm font-medium">Log Out</span>
                </a>
            </div>
        </aside>