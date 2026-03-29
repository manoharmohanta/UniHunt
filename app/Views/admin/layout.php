<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin Dashboard | UniHunt' ?></title>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('favicon_io/apple-touch-icon.webp') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('favicon_io/favicon-32x32.webp') ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('favicon_io/favicon-16x16.webp') ?>">
    <link rel="manifest" href="<?= base_url('favicon_io/site.webmanifest') ?>">
    <link rel="shortcut icon" href="<?= base_url('favicon_io/favicon.ico') ?>">

    <!-- CSRF Meta -->
    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <meta name="csrf-header" content="X-CSRF-TOKEN">

    <!-- Frameworks -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
    <script src="https://unpkg.com/htmx.org@1.9.10"></script>

    <style>
        :root {
            --brand-primary: #6366f1;
            --brand-secondary: #4f46e5;
            --sidebar-bg: #0f172a;
            --main-bg: #f8fafc;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--main-bg);
            color: #1e293b;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .glass-sidebar {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            box-shadow: 4px 0 24px rgba(0, 0, 0, 0.1);
        }

        .nav-item-active {
            background: rgba(99, 102, 241, 0.15);
            color: white !important;
            border-right: 3px solid var(--brand-primary);
        }

        .nav-link-modern {
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .nav-link-modern:hover {
            background: rgba(255, 255, 255, 0.05);
            color: white;
            transform: translateX(4px);
        }

        /* Fix for scroll/layout */
        .layout-wrapper {
            display: grid;
            grid-template-columns: 280px 1fr;
            height: 100vh;
            overflow: hidden;
        }

        .content-area {
            overflow-y: auto;
            scroll-behavior: smooth;
            min-width: 0;
        }

        /* Tailwind Modal Logic */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            z-index: 50;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .modal-overlay.active {
            display: flex !important;
            align-items: center;
            justify-content: center;
            opacity: 1;
        }

        .modal-content-tw {
            transform: scale(0.95);
            transition: transform 0.3s ease;
        }

        .modal-overlay.active .modal-content-tw {
            transform: scale(1);
        }

        /* Select2 Custom Styling */
        .select2-container--default .select2-selection--single {
            height: 48px;
            border: 1px solid #e2e8f0;
            border-radius: 0.75rem;
            display: flex;
            align-items: center;
            padding: 0 1rem;
            transition: all 0.2s;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #1e293b;
            font-weight: 500;
            padding: 0;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 48px;
            right: 12px;
        }

        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }

        .select2-dropdown {
            border-color: #e2e8f0;
            border-radius: 0.75rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            z-index: 1000;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #6366f1;
        }

        .select2-search--dropdown .select2-search__field {
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            padding: 8px 12px;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
    <script>
        function updateCSRF(newToken) {
            // Update Meta tag
            document.querySelector('meta[name="csrf-token"]').setAttribute('content', newToken);

            // Update all CSRF hidden inputs
            const tokenName = '<?= csrf_token() ?>';
            document.querySelectorAll(`input[name="${tokenName}"]`).forEach(input => {
                input.value = newToken;
            });

            // If Alpine components exist, they should also be informed via events or local update
            window.dispatchEvent(new CustomEvent('csrf-updated', { detail: newToken }));
        }

        function openModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.classList.add('active');
                modal.style.display = 'flex'; // Force display flex
                setTimeout(() => {
                    modal.style.opacity = '1';
                }, 10);
                document.body.style.overflow = 'hidden';
            }
        }
        function closeModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.style.opacity = '0';
                setTimeout(() => {
                    modal.classList.remove('active');
                    modal.style.display = 'none';
                }, 300);
                document.body.style.overflow = '';
            }
        }
        // Close modal on overlay click (Disabled as per user request to prevent accidental closure)
        /*
        window.onclick = function (event) {
            if (event.target.classList.contains('modal-overlay')) {
                const id = event.target.id;
                closeModal(id);
            }
        }
        */
    </script>
</head>

<body class="h-full">
    <div class="layout-wrapper">
        <!-- Sidebar -->
        <aside class="glass-sidebar text-slate-300 flex flex-col h-full overflow-hidden">
            <div class="h-20 flex items-center px-8 flex-shrink-0">
                <a href="<?= base_url('admin') ?>" class="flex items-center gap-3">
                    <img src="<?= base_url('favicon_io/android-chrome-512x512.webp') ?>" class="w-8 h-8 object-contain"
                        alt="UniHunt">
                    <span class="text-xl font-bold tracking-tight">
                        <span class="text-secondary">UNI</span>
                        <span class="text-white">HUNT</span>
                    </span>
                </a>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
                <div class="px-4 mb-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Main Menu</div>

                <a href="<?= base_url('admin') ?>"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg nav-link-modern <?= uri_string() == 'admin' ? 'nav-item-active' : 'text-slate-400' ?>">
                    <span class="material-symbols-outlined">grid_view</span>
                    <span class="font-medium text-sm">Dashboard</span>
                </a>

                <?php if (session()->get('role_id') == 1): // Admin Only ?>
                    <a href="<?= base_url('admin/users') ?>"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg nav-link-modern <?= strpos(uri_string(), 'admin/users') !== false ? 'nav-item-active' : 'text-slate-400' ?>">
                        <span class="material-symbols-outlined">group</span>
                        <span class="font-medium text-sm">Manage Users</span>
                    </a>

                    <a href="<?= base_url('admin/role-requests') ?>"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg nav-link-modern <?= strpos(uri_string(), 'admin/role-requests') !== false ? 'nav-item-active' : 'text-slate-400' ?>">
                        <span class="material-symbols-outlined">badge</span>
                        <span class="font-medium text-sm flex-1">Role Requests</span>
                        <?php
                        $db = \Config\Database::connect();
                        if ($db->tableExists('role_requests')) {
                            $pendingReqs = $db->table('role_requests')->where('status', 'pending')->countAllResults();
                            if ($pendingReqs > 0) {
                                echo '<span class="bg-indigo-500 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">' . $pendingReqs . '</span>';
                            }
                        }
                        ?>
                    </a>
                <?php endif; ?>

                <?php if (session()->get('role_id') != 4): // Not Uni Rep ?>
                    <a href="<?= base_url('admin/blogs') ?>"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg nav-link-modern <?= strpos(uri_string(), 'admin/blogs') !== false ? 'nav-item-active' : 'text-slate-400' ?>">
                        <span class="material-symbols-outlined">edit_note</span>
                        <span class="font-medium text-sm">Blog & Content</span>
                    </a>

                    <?php if (session()->get('role_id') == 1): // Admin Only ?>
                        <a href="<?= base_url('admin/comments') ?>"
                            class="flex items-center gap-3 px-4 py-3 rounded-lg nav-link-modern <?= strpos(uri_string(), 'admin/comments') !== false ? 'nav-item-active' : 'text-slate-400' ?>">
                            <span class="material-symbols-outlined">forum</span>
                            <span class="font-medium text-sm">Comments</span>
                        </a>

                        <a href="<?= base_url('admin/reviews') ?>"
                            class="flex items-center gap-3 px-4 py-3 rounded-lg nav-link-modern <?= strpos(uri_string(), 'admin/reviews') !== false ? 'nav-item-active' : 'text-slate-400' ?>">
                            <span class="material-symbols-outlined">reviews</span>
                            <span class="font-medium text-sm">Student Reviews</span>
                        </a>
                    <?php endif; ?>

                    <a href="<?= base_url('admin/events') ?>"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg nav-link-modern <?= strpos(uri_string(), 'admin/events') !== false ? 'nav-item-active' : 'text-slate-400' ?>">
                        <span class="material-symbols-outlined">event</span>
                        <span class="font-medium text-sm">Events Manager</span>
                    </a>

                    <a href="<?= base_url('admin/campaigns') ?>"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg nav-link-modern <?= strpos(uri_string(), 'admin/campaigns') !== false ? 'nav-item-active' : 'text-slate-400' ?>">
                        <span class="material-symbols-outlined">mail</span>
                        <span class="font-medium text-sm">Email Campaigns</span>
                    </a>
                <?php endif; ?>

                <div class="px-4 mt-8 mb-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Global Data
                </div>

                <?php if (session()->get('role_id') == 1): // Admin Only ?>
                    <a href="<?= base_url('admin/locations') ?>"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg nav-link-modern <?= strpos(uri_string(), 'admin/locations') !== false ? 'nav-item-active' : 'text-slate-400' ?>">
                        <span class="material-symbols-outlined">public</span>
                        <span class="font-medium text-sm">Locations</span>
                    </a>
                <?php endif; ?>

                <a href="<?= base_url('admin/universities') ?>"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg nav-link-modern <?= strpos(uri_string(), 'admin/universities') !== false ? 'nav-item-active' : 'text-slate-400' ?>">
                    <span class="material-symbols-outlined">account_balance</span>
                    <span class="font-medium text-sm">Universities</span>
                </a>

                <a href="<?= base_url('admin/courses') ?>"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg nav-link-modern <?= strpos(uri_string(), 'admin/courses') !== false ? 'nav-item-active' : 'text-slate-400' ?>">
                    <span class="material-symbols-outlined">list_alt</span>
                    <span class="font-medium text-sm">Courses</span>
                </a>

                <?php if (session()->get('role_id') == 1): // Admin Only ?>
                    <div class="px-4 mt-8 mb-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Monetization
                    </div>

                    <a href="<?= base_url('admin/ads') ?>"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg nav-link-modern <?= strpos(uri_string(), 'admin/ads') !== false ? 'nav-item-active' : 'text-slate-400' ?>">
                        <span class="material-symbols-outlined">campaign</span>
                        <span class="font-medium text-sm">Ads Management</span>
                    </a>

                    <a href="<?= base_url('admin/coupons') ?>"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg nav-link-modern <?= strpos(uri_string(), 'admin/coupons') !== false ? 'nav-item-active' : 'text-slate-400' ?>">
                        <span class="material-symbols-outlined">local_activity</span>
                        <span class="font-medium text-sm">Coupons</span>
                    </a>

                    <a href="<?= base_url('admin/payments') ?>"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg nav-link-modern <?= strpos(uri_string(), 'admin/payments') !== false ? 'nav-item-active' : 'text-slate-400' ?>">
                        <span class="material-symbols-outlined">payments</span>
                        <span class="font-medium text-sm">AI Tool Payments</span>
                    </a>
                <?php endif; ?>

                <?php if (session()->get('role_id') == 1): // Admin Only ?>
                    <div class="px-4 mt-8 mb-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest">Configuration
                    </div>

                    <a href="<?= base_url('admin/requirements') ?>"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg nav-link-modern <?= strpos(uri_string(), 'admin/requirements') !== false ? 'nav-item-active' : 'text-slate-400' ?>">
                        <span class="material-symbols-outlined">rule_folder</span>
                        <span class="font-medium text-sm">Requirements</span>
                    </a>

                    <a href="<?= base_url('admin/visa-types') ?>"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg nav-link-modern <?= strpos(uri_string(), 'admin/visa-types') !== false ? 'nav-item-active' : 'text-slate-400' ?>">
                        <span class="material-symbols-outlined">receipt_long</span>
                        <span class="font-medium text-sm">Visa Types</span>
                    </a>

                    <a href="<?= base_url('admin/exchange-rates') ?>"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg nav-link-modern <?= strpos(uri_string(), 'admin/exchange-rates') !== false ? 'nav-item-active' : 'text-slate-400' ?>">
                        <span class="material-symbols-outlined">payments</span>
                        <span class="font-medium text-sm">Exchange Rates</span>
                    </a>

                    <a href="<?= base_url('admin/settings') ?>"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg nav-link-modern <?= strpos(uri_string(), 'admin/settings') !== false ? 'nav-item-active' : 'text-slate-400' ?>">
                        <span class="material-symbols-outlined">settings</span>
                        <span class="font-medium text-sm">Site Settings</span>
                    </a>

                    <a href="<?= base_url('admin/database') ?>"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg nav-link-modern <?= strpos(uri_string(), 'admin/database') !== false ? 'nav-item-active' : 'text-slate-400' ?>">
                        <span class="material-symbols-outlined">database</span>
                        <span class="font-medium text-sm">Database Mgmt</span>
                    </a>
                <?php endif; ?>
            </nav>

            <div class="p-6 border-t border-slate-800 flex-shrink-0">
                <a href="<?= base_url() ?>"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl border border-slate-700 text-slate-400 hover:text-white hover:bg-slate-800 transition-all group">
                    <span
                        class="material-symbols-outlined transition-transform group-hover:-translate-x-1">arrow_back</span>
                    <span class="font-semibold text-sm">Exit Admin</span>
                </a>
            </div>
        </aside>

        <!-- Content Area -->
        <div class="content-area bg-[#f8fafc] flex flex-col h-full">
            <!-- Topbar -->
            <header
                class="h-20 bg-white border-b border-slate-200 sticky top-0 z-10 flex items-center justify-between px-4 md:px-10">
                <div>
                    <h1 class="text-xl font-bold text-slate-800 tracking-tight"><?= $title ?? 'Dashboard' ?></h1>
                    <p class="text-[11px] text-slate-400 font-medium tracking-wide">UniHunt Administration Portal</p>
                </div>

                <div class="flex items-center gap-6">
                    <div class="flex items-center gap-3 pl-6 border-l border-slate-200">
                        <div class="text-right">
                            <p class="text-xs font-bold text-slate-800">Administrator</p>
                            <p class="text-[10px] text-indigo-500 font-bold uppercase tracking-widest">Master Access</p>
                        </div>
                        <div
                            class="size-10 rounded-xl bg-indigo-500 flex items-center justify-center text-white ring-4 ring-indigo-50">
                            <span class="material-symbols-outlined">person</span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="p-4 md:p-10 max-w-[1600px] w-full mx-auto overflow-x-hidden">
                <main>
                    <?php if (session()->getFlashdata('error')): ?>
                        <div
                            class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-100 text-rose-600 font-medium flex items-center gap-3">
                            <span class="material-symbols-outlined">error</span>
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('success')): ?>
                        <div
                            class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-600 font-medium flex items-center gap-3">
                            <span class="material-symbols-outlined">check_circle</span>
                            <?= session()->getFlashdata('success') ?>
                        </div>
                    <?php endif; ?>

                    <?= $this->renderSection('content') ?>
                </main>
            </div>
        </div>
    </div>
    <?= $this->renderSection('scripts') ?>
</body>

</html>