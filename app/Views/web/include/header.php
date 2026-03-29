<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title><?= isset($title) ? $title : "UniHunt | Discover Global Universities & Events" ?></title>
    <meta name="description"
        content="<?= isset($meta_desc) ? $meta_desc : "UniHunt helps students find the best universities worldwide with AI-powered tools and expert guidance." ?>" />
    <link rel="canonical" href="<?= current_url() ?>" />

    <!-- Open Graph / SEO -->
    <meta property="og:type" content="website" />
    <meta property="og:title" content="<?= isset($title) ? esc($title) : "UniHunt" ?>" />
    <meta property="og:description"
        content="<?= isset($meta_desc) ? esc($meta_desc) : "Find your ideal university abroad." ?>" />
    <meta property="og:url" content="<?= current_url() ?>" />
    <meta property="og:site_name" content="UniHunt" />

    <?php if (isset($og_image) && !empty($og_image)): ?>
        <meta property="og:image" content="<?= $og_image ?>" />
        <meta name="twitter:image" content="<?= $og_image ?>" />
        <meta name="twitter:card" content="summary_large_image" />
    <?php else: ?>
        <meta property="og:image" content="<?= base_url('favicon_io/favicon.ico') ?>" />
        <meta name="twitter:card" content="summary" />
    <?php endif; ?>

    <?php if (isset($keywords) && !empty($keywords)): ?>
        <meta name="keywords" content="<?= esc($keywords) ?>" />
    <?php endif; ?>

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('favicon_io/apple-touch-icon.webp') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('favicon_io/favicon-32x32.webp') ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('favicon_io/favicon-16x16.webp') ?>">
    <link rel="manifest" href="<?= base_url('favicon_io/site.webmanifest') ?>">
    <link rel="shortcut icon" href="<?= base_url('favicon_io/favicon.ico') ?>">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect" />
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect" />
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&amp;display=swap" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <!-- FontAwesome for Brand Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <!-- CSS -->
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">

    <!-- Core Tools -->
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://unpkg.com/htmx.org@1.9.12"></script>
    <script src="https://unpkg.com/htmx.org/dist/ext/sse.js"></script>
    <script src="https://unpkg.com/htmx.org/dist/ext/ws.js"></script>
    <script>
        // Global Config
        window.UniHunt = {
            baseUrl: '<?= base_url() ?>',
            apiUrl: '<?= base_url('api') ?>'
        };

        // Check local time (Day: 6 AM - 6 PM)
        const hours = new Date().getHours();
        const isDayTime = hours >= 6 && hours < 18;

        // Check storage or default to time-based
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

        // Global HTMX Loading Logic
        document.addEventListener('DOMContentLoaded', () => {
            const loadingBar = document.getElementById('global-loader');

            document.body.addEventListener('htmx:beforeRequest', () => {
                loadingBar.style.width = '0%';
                loadingBar.style.opacity = '1';
                loadingBar.style.display = 'block';
                setTimeout(() => loadingBar.style.width = '30%', 50);
            });

            document.body.addEventListener('htmx:afterRequest', (event) => {
                if (event.detail.failed) {
                    loadingBar.style.backgroundColor = '#d64545'; // Danger color on fail
                }
                loadingBar.style.width = '100%';
                setTimeout(() => {
                    loadingBar.style.opacity = '0';
                    setTimeout(() => {
                        loadingBar.style.display = 'none';
                        loadingBar.style.width = '0%';
                        loadingBar.style.backgroundColor = '#c91331'; // Reset to secondary red
                    }, 300);
                }, 200);
            });
        });
    </script>
    <style>
        #global-loader {
            position: fixed;
            top: 0;
            left: 0;
            height: 3px;
            background-color: #c91331;
            /* Theme Secondary Red */
            z-index: 9999;
            transition: width 0.4s ease, opacity 0.3s ease;
            box-shadow: 0 0 10px rgba(201, 19, 49, 0.5);
            display: none;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
    <?php
    helper('settings');
    $gtm_id = get_setting('gtm_id');
    ?>
    <?php if ($gtm_id): ?>
        <!-- Google Tag Manager -->
        <script>(function (w, d, s, l, i) {
                w[l] = w[l] || []; w[l].push({
                    'gtm.start':
                        new Date().getTime(), event: 'gtm.js'
                }); var f = d.getElementsByTagName(s)[0],
                    j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src =
                        'https://www.googletagmanager.com/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f);
            })(window, document, 'script', 'dataLayer', '<?= $gtm_id ?>');</script>
        <!-- End Google Tag Manager -->
    <?php endif; ?>
</head>

<body
    class="<?= isset($bodyClass) ? $bodyClass : 'bg-background-light font-display text-text-main antialiased transition-colors duration-200' ?>">
    <?php if ($gtm_id): ?>
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?= $gtm_id ?>" height="0" width="0"
                style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
    <?php endif; ?>
    <!-- Global Progress Bar -->
    <div id="global-loader"></div>
    <!-- Top Navigation -->
    <nav x-data="{ mobileMenuOpen: false }"
        class="sticky top-0 z-50 w-full bg-surface-light border-b border-border-light shadow-sm">
        <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <a href="<?= base_url() ?>" class="flex items-center gap-3">
                    <img src="<?= base_url('favicon_io/android-chrome-512x512.webp') ?>"
                        class="w-10 h-10 object-contain" alt="UniHunt Logo">
                    <span class="text-2xl font-black tracking-tighter uppercase">
                        <span class="text-primary dark:text-white">UNI</span><span class="text-secondary">HUNT</span>
                    </span>
                </a>
                <!-- Desktop Links -->
                <div class="hidden md:flex items-center gap-8">
                    <a class="text-sm font-semibold text-text-main hover:text-primary transition-colors"
                        href="<?= base_url('universities') ?>">Universities</a>
                    <a class="text-sm font-semibold text-text-main hover:text-primary transition-colors"
                        href="<?= base_url('events') ?>">Events</a>
                    <a class="text-sm font-semibold text-text-main hover:text-primary transition-colors"
                        href="<?= base_url('ai-tools') ?>">AI Tools</a>
                    <a class="text-sm font-semibold text-text-main hover:text-primary transition-colors"
                        href="<?= base_url('blog') ?>">Blog</a>
                    <a class="text-sm font-semibold text-text-main hover:text-primary transition-colors"
                        href="<?= base_url('contact') ?>">Contact Us</a>

                    <div class="relative group" x-data="{ open: false }">
                        <button @click="open = !open"
                            class="flex items-center gap-1 text-sm font-semibold text-text-main hover:text-primary transition-colors">
                            Compare
                            <span class="material-symbols-outlined text-[18px]">expand_more</span>
                        </button>
                        <div x-show="open" @click.away="open = false"
                            class="absolute left-0 mt-2 w-48 bg-surface-light rounded-xl shadow-xl border border-border-light p-2 z-[60]">
                            <a href="<?= base_url('compare-universities') ?>"
                                class="flex items-center justify-between px-3 py-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                <span class="text-sm text-text-main">Universities</span>
                                <span
                                    class="size-5 bg-primary/10 text-primary text-[10px] font-bold rounded-full flex items-center justify-center">
                                    <?= count(session()->get('compare_universities') ?? []) ?>
                                </span>
                            </a>
                            <a href="<?= base_url('compare-courses') ?>"
                                class="flex items-center justify-between px-3 py-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                <span class="text-sm text-text-main">Courses</span>
                                <span
                                    class="size-5 bg-primary/10 text-primary text-[10px] font-bold rounded-full flex items-center justify-center">
                                    <?= count(session()->get('compare_courses') ?? []) ?>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>

                <script>
                    async function toggleCompare(e, type, id) {
                        if (e) {
                            e.preventDefault();
                            e.stopPropagation();
                        }
                        try {
                            const response = await fetch('<?= base_url('comparison/toggle') ?>', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded',
                                    'X-Requested-With': 'XMLHttpRequest',
                                    'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
                                },
                                body: `type=${type}&id=${id}`
                            });
                            const data = await response.json();
                            if (response.ok) {
                                if (confirm(data.message + ' View comparison?')) {
                                    window.location.href = type === 'university' ? '<?= base_url('compare-universities') ?>' : '<?= base_url('compare-courses') ?>';
                                } else {
                                    location.reload();
                                }
                            } else {
                                alert(data.message || 'Error updating comparison');
                            }
                        } catch (error) {
                            console.error(error);
                        }
                    }
                </script>
                <!-- CTA Buttons -->
                <div class="hidden md:flex items-center gap-3">
                    <!-- Theme Toggle -->
                    <button onclick="toggleTheme()"
                        class="p-2 mr-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors text-text-main"
                        aria-label="Toggle Dark Mode">
                        <span class="material-symbols-outlined dark:hidden">dark_mode</span>
                        <span class="material-symbols-outlined hidden dark:block">light_mode</span>
                    </button>
                    <?php if (session()->get('isLoggedIn')): ?>
                        <?php
                        $dashUrl = base_url('dashboard');
                        $role = session()->get('role_id');
                        if (in_array($role, [1, 3, 4]))
                            $dashUrl = base_url('admin');
                        if ($role == 5)
                            $dashUrl = base_url('agent');
                        ?>
                        <a href="<?= $dashUrl ?>"
                            class="px-4 py-2 text-sm font-bold text-text-main bg-background-light hover:bg-border-light rounded-lg transition-colors">
                            Dashboard
                        </a>
                        <a href="<?= base_url('logout') ?>"
                            class="px-4 py-2 text-sm font-bold text-white bg-secondary hover:bg-secondary-hover rounded-lg shadow-sm transition-all hover:shadow-md hover:-translate-y-0.5">
                            Logout
                        </a>
                    <?php else: ?>
                        <a href="<?= base_url('login') ?>"
                            class="px-6 py-2.5 text-sm font-bold text-white bg-primary hover:bg-primary-hover rounded-lg shadow-lg shadow-primary/20 transition-all hover:shadow-xl hover:-translate-y-0.5">
                            Sign In / Sign Up
                        </a>
                    <?php endif; ?>
                </div>
                <!-- Mobile Menu Button -->
                <div class="md:hidden flex items-center gap-3">
                    <button onclick="toggleTheme()"
                        class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors text-text-main"
                        aria-label="Toggle Dark Mode">
                        <span class="material-symbols-outlined dark:hidden">dark_mode</span>
                        <span class="material-symbols-outlined hidden dark:block">light_mode</span>
                    </button>
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-text-main p-2">
                        <span class="material-symbols-outlined" x-text="mobileMenuOpen ? 'close' : 'menu'">menu</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu Overlay -->
        <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-4"
            class="md:hidden absolute top-16 left-0 w-full bg-surface-light border-b border-border-light shadow-xl overflow-hidden"
            style="display: none;">
            <div class="px-4 pt-2 pb-6 space-y-2">
                <a class="block px-3 py-3 text-base font-semibold text-text-main hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-colors"
                    href="<?= base_url('universities') ?>">Universities</a>
                <a class="block px-3 py-3 text-base font-semibold text-text-main hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-colors"
                    href="<?= base_url('events') ?>">Events</a>
                <a class="block px-3 py-3 text-base font-semibold text-text-main hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-colors"
                    href="<?= base_url('ai-tools') ?>">AI Tools</a>
                <a class="block px-3 py-3 text-base font-semibold text-text-main hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-colors"
                    href="<?= base_url('blog') ?>">Blog</a>
                <a class="block px-3 py-3 text-base font-semibold text-text-main hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-colors"
                    href="<?= base_url('contact') ?>">Contact Us</a>

                <div class="pt-4 border-t border-border-light grid grid-cols-2 gap-3">
                    <?php if (session()->get('isLoggedIn')): ?>
                        <?php
                        $dashUrl = base_url('dashboard');
                        $role = session()->get('role_id');
                        if (in_array($role, [1, 3, 4]))
                            $dashUrl = base_url('admin');
                        if ($role == 5)
                            $dashUrl = base_url('agent');
                        ?>
                        <a href="<?= $dashUrl ?>"
                            class="px-4 py-3 text-center text-sm font-bold text-text-main bg-background-light rounded-lg transition-colors">
                            Dashboard
                        </a>
                        <a href="<?= base_url('logout') ?>"
                            class="px-4 py-3 text-center text-sm font-bold text-white bg-secondary rounded-lg">
                            Logout
                        </a>
                    <?php else: ?>
                        <a href="<?= base_url('login') ?>"
                            class="col-span-2 px-4 py-3 text-center text-sm font-bold text-white bg-primary rounded-lg shadow-sm">
                            Sign In / Sign Up
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>