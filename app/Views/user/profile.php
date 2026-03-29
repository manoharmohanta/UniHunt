<?= view('user/include/header', ['title' => 'Profile Settings', 'activePage' => 'profile']) ?>

<main class="flex-1 h-full overflow-y-auto bg-slate-50 dark:bg-[#0B0F1A] font-display custom-scrollbar">
    <div class="max-w-6xl mx-auto px-6 lg:px-10 py-12">

        <!-- Dynamic Page Header -->
        <div
            class="relative mb-12 rounded-3xl overflow-hidden bg-white dark:bg-gray-800 shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-200 dark:border-gray-700">
            <div
                class="absolute top-0 right-0 w-64 h-64 bg-primary/5 dark:bg-primary/10 rounded-full blur-3xl -mr-20 -mt-20">
            </div>
            <div
                class="absolute bottom-0 left-0 w-48 h-48 bg-secondary/5 dark:bg-secondary/10 rounded-full blur-2xl -ml-20 -mb-20">
            </div>

            <div class="relative p-8 md:p-10 flex flex-col md:flex-row items-center gap-8">
                <div class="relative group">
                    <div
                        class="w-24 h-24 rounded-2xl bg-gradient-to-tr from-primary to-purple-600 p-[3px] shadow-lg transform group-hover:scale-105 transition-all duration-300">
                        <div
                            class="w-full h-full rounded-[13px] bg-white dark:bg-gray-800 flex items-center justify-center text-3xl font-black text-primary overflow-hidden uppercase">
                            <?= substr(esc($user['name']), 0, 1) ?>
                        </div>
                    </div>
                </div>

                <div class="flex-1 text-center md:text-left">
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-3 mb-2">
                        <h1 class="text-3xl font-black text-slate-900 dark:text-white leading-tight">
                            <?= esc($user['name']) ?>
                        </h1>
                        <span
                            class="px-3 py-1 rounded-full bg-primary/10 text-primary text-[10px] font-black uppercase tracking-widest border border-primary/20">
                            <?= session()->get('user_role') ?: 'Student' ?>
                        </span>
                    </div>
                    <p
                        class="text-slate-500 dark:text-gray-400 font-medium flex items-center justify-center md:justify-start gap-2 text-sm italic">
                        <span class="material-symbols-outlined text-base">alternate_email</span>
                        <?= esc($user['email']) ?>
                    </p>
                </div>

                <div class="flex items-center gap-4">
                    <a href="<?= base_url('dashboard') ?>"
                        class="flex items-center gap-2 px-6 py-3 rounded-xl bg-slate-100 dark:bg-gray-700 text-slate-700 dark:text-gray-200 font-bold text-xs hover:bg-slate-200 dark:hover:bg-gray-600 transition-all active:scale-95 uppercase tracking-wider">
                        <span class="material-symbols-outlined text-lg">dashboard</span>
                        Dashboard
                    </a>
                </div>
            </div>
        </div>

        <?php if (session()->getFlashdata('message')): ?>
            <div
                class="mb-8 p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-900/20 text-emerald-700 dark:text-emerald-400 border border-emerald-200/50 dark:border-emerald-800/50 flex items-center gap-4 shadow-sm animate-in fade-in slide-in-from-top-4 duration-300">
                <div
                    class="w-10 h-10 rounded-full bg-emerald-100 dark:bg-emerald-900/40 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-emerald-600">check_circle</span>
                </div>
                <span class="font-bold text-sm"><?= session()->getFlashdata('message') ?></span>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div
                class="mb-8 p-4 rounded-2xl bg-rose-50 dark:bg-rose-900/20 text-rose-700 dark:text-rose-400 border border-rose-200/50 dark:border-rose-800/50 flex items-center gap-4 shadow-sm animate-in fade-in slide-in-from-top-4 duration-300">
                <div
                    class="w-10 h-10 rounded-full bg-rose-100 dark:bg-rose-900/40 flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-rose-600">error</span>
                </div>
                <span class="font-bold text-sm"><?= session()->getFlashdata('error') ?></span>
            </div>
        <?php endif; ?>

        <!-- Primary Form -->
        <form action="<?= base_url('profile/update') ?>" method="post">
            <?= csrf_field() ?>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Main Settings Column -->
                <div class="lg:col-span-2 space-y-8">
                    <div
                        class="bg-white dark:bg-gray-800 rounded-3xl shadow-xl shadow-slate-200/50 dark:shadow-none border border-slate-200 dark:border-gray-700 overflow-hidden">
                        <div class="p-8 md:p-10">
                            <div class="flex items-center gap-3 mb-8">
                                <div
                                    class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary">
                                    <span class="material-symbols-outlined">person_edit</span>
                                </div>
                                <h2 class="text-xl font-black text-slate-900 dark:text-white uppercase tracking-tight">
                                    Personal Details</h2>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div class="space-y-3">
                                    <label
                                        class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Legal
                                        Full Name</label>
                                    <div class="relative group">
                                        <div
                                            class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400 group-focus-within:text-primary transition-colors">
                                            <span class="material-symbols-outlined">person</span>
                                        </div>
                                        <input type="text" name="name" id="name" value="<?= esc($user['name']) ?>"
                                            required
                                            class="w-full pl-12 pr-4 py-4 rounded-2xl border border-slate-200 dark:border-gray-700 bg-slate-50 dark:bg-gray-900 text-slate-900 dark:text-white focus:ring-4 focus:ring-primary/10 focus:border-primary focus:outline-none transition-all font-bold">
                                    </div>
                                </div>

                                <div class="space-y-3">
                                    <label
                                        class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Primary
                                        Contact</label>
                                    <div class="relative group">
                                        <div
                                            class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400 group-focus-within:text-primary transition-colors">
                                            <span class="material-symbols-outlined">call</span>
                                        </div>
                                        <input type="tel" name="phone" id="phone" value="<?= esc($user['phone']) ?>"
                                            required
                                            class="w-full pl-12 pr-4 py-4 rounded-2xl border border-slate-200 dark:border-gray-700 bg-slate-50 dark:bg-gray-900 text-slate-900 dark:text-white focus:ring-4 focus:ring-primary/10 focus:border-primary focus:outline-none transition-all font-bold">
                                    </div>
                                </div>

                                <div class="space-y-3 md:col-span-2 opacity-60">
                                    <label
                                        class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Authentication
                                        Email</label>
                                    <div class="relative group">
                                        <div
                                            class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400">
                                            <span class="material-symbols-outlined">lock</span>
                                        </div>
                                        <input type="email" value="<?= esc($user['email']) ?>" readonly disabled
                                            class="w-full pl-12 pr-4 py-4 rounded-2xl border border-slate-200 dark:border-gray-700 bg-slate-100 dark:bg-[#151A26] text-slate-500 dark:text-gray-500 cursor-not-allowed font-bold italic">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Upgrade Component -->
                    <?php if ($user['role_id'] == 2): ?>
                        <div class="relative group">
                            <div
                                class="absolute -inset-1 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 rounded-3xl blur opacity-20 group-hover:opacity-40 transition duration-1000">
                            </div>
                            <div
                                class="relative bg-white dark:bg-gray-800 rounded-3xl border border-slate-200 dark:border-gray-700 overflow-hidden shadow-xl">
                                <div class="p-8 md:p-10">
                                    <div class="flex items-start gap-6 mb-8">
                                        <div
                                            class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center shrink-0 shadow-lg rotate-3 group-hover:rotate-0 transition-all">
                                            <span
                                                class="material-symbols-outlined text-primary text-3xl">military_tech</span>
                                        </div>
                                        <div>
                                            <h3
                                                class="text-2xl font-black text-slate-900 dark:text-white tracking-tight mb-2 uppercase">
                                                Pro Upgrade</h3>
                                            <p class="text-slate-500 dark:text-gray-400 text-sm leading-relaxed max-w-md">
                                                Looking to become a <span
                                                    class="text-primary font-bold italic">Partner</span>? Apply for a
                                                professional role to access exclusive enterprise modules.
                                            </p>
                                        </div>
                                    </div>

                                    <?php
                                    $db = \Config\Database::connect();
                                    $existingRequest = $db->table('role_requests')
                                        ->where('user_id', $user['id'])
                                        ->where('status', 'pending')
                                        ->get()->getRow();
                                    ?>

                                    <?php if ($existingRequest): ?>
                                        <div
                                            class="flex items-center gap-5 p-6 rounded-2xl bg-amber-50 dark:bg-amber-900/10 border border-amber-200/50 dark:border-amber-800/30">
                                            <div
                                                class="w-12 h-12 rounded-full bg-amber-100 dark:bg-amber-900/50 flex items-center justify-center shrink-0 shadow-inner">
                                                <span
                                                    class="material-symbols-outlined text-amber-600 dark:text-amber-400 rotate-animation">pending</span>
                                            </div>
                                            <div>
                                                <h4
                                                    class="text-amber-900 dark:text-amber-300 font-black text-xs uppercase tracking-widest">
                                                    Verification Pending</h4>
                                                <p class="text-amber-700 dark:text-amber-400/80 text-[11px] mt-1 italic">
                                                    Applied for:
                                                    <strong><?= esc($db->table('roles')->where('id', $existingRequest->requested_role_id)->get()->getRow()->name ?? '') ?></strong>
                                                </p>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                                            <div class="md:col-span-3">
                                                <div class="relative">
                                                    <select name="requested_role_id_select" id="requested_role_id_select"
                                                        class="w-full pl-6 pr-12 py-4 rounded-2xl border border-slate-200 dark:border-gray-700 bg-slate-50 dark:bg-gray-900 text-slate-900 dark:text-white focus:ring-4 focus:ring-primary/10 focus:border-primary focus:outline-none transition-all font-black appearance-none cursor-pointer text-sm">
                                                        <option value="" disabled selected>-- SELECT TARGET ROLE --</option>
                                                        <option value="3">Counsellor (Advisory License)</option>
                                                        <option value="4">University Official / Rep</option>
                                                        <option value="5">Recruitment Agency / Agent</option>
                                                    </select>
                                                    <div
                                                        class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400">
                                                        <span class="material-symbols-outlined">expand_more</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <button type="button" onclick="submitRoleUpgrade()"
                                                class="px-6 py-4 bg-primary text-white font-black rounded-2xl hover:bg-black transition-all shadow-lg shadow-primary/20 text-xs tracking-widest active:scale-95 uppercase">
                                                APPLY
                                            </button>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Sidebar / Actions Column -->
                <div class="space-y-8">
                    <!-- Preference Card -->
                    <div
                        class="bg-white dark:bg-gray-800 rounded-3xl p-8 border border-slate-200 dark:border-gray-700 shadow-xl shadow-slate-200/50 dark:shadow-none">
                        <div class="flex items-center gap-3 mb-8">
                            <div
                                class="w-10 h-10 rounded-xl bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center text-purple-600 dark:text-purple-400">
                                <span class="material-symbols-outlined">tune</span>
                            </div>
                            <h2 class="text-lg font-black text-slate-900 dark:text-white uppercase tracking-tight">
                                Preferences</h2>
                        </div>

                        <div class="space-y-6">
                            <label
                                class="group relative flex items-start gap-4 p-5 rounded-2xl border border-slate-100 dark:border-gray-700/50 bg-slate-50 dark:bg-gray-900/50 cursor-pointer hover:border-primary/30 hover:bg-white dark:hover:bg-gray-800 transition-all duration-300">
                                <div class="flex items-center h-5 mt-1">
                                    <input id="marketing_consent" name="marketing_consent" type="checkbox" value="1"
                                        <?= $user['marketing_consent'] ? 'checked' : '' ?>
                                        class="w-6 h-6 text-primary border-slate-300 rounded-lg focus:ring-primary dark:focus:ring-primary transition-all cursor-pointer bg-white dark:bg-gray-700">
                                </div>
                                <div class="flex-1">
                                    <span
                                        class="block text-sm font-black text-slate-900 dark:text-white uppercase tracking-wider">Marketing</span>
                                    <p class="text-[10px] text-slate-400 mt-2 leading-relaxed italic">I agree to receive
                                        tactical updates and premium offer notifications.</p>
                                </div>
                            </label>

                            <button type="submit"
                                class="w-full py-6 bg-slate-900 dark:bg-white text-white dark:text-slate-900 font-black rounded-2xl hover:scale-[1.03] active:scale-[0.98] transition-all shadow-2xl shadow-slate-900/20 dark:shadow-white/5 uppercase tracking-widest text-sm">
                                SYNC SETTINGS
                            </button>
                        </div>
                    </div>

                    <!-- Danger Card -->
                    <div
                        class="bg-rose-50/40 dark:bg-rose-900/5 rounded-3xl p-8 border border-rose-100 dark:border-rose-900/20">
                        <div class="flex items-center gap-3 mb-6 text-rose-600">
                            <div
                                class="w-8 h-8 rounded-lg bg-rose-100 dark:bg-rose-900/30 flex items-center justify-center">
                                <span class="material-symbols-outlined text-sm font-black">gpp_maybe</span>
                            </div>
                            <h2 class="text-[10px] font-black uppercase tracking-[0.2em]">Security Zone</h2>
                        </div>
                        <p class="text-[10px] text-rose-700/60 dark:text-rose-400/60 leading-relaxed mb-8 italic">
                            Authentication termination is irreversible and wipes all historical AI data and application
                            records.
                        </p>

                        <button type="button" onclick="handleAccountDeletion()"
                            class="w-full py-4 bg-transparent hover:bg-rose-600 text-rose-600 hover:text-primary font-extrabold text-xs uppercase tracking-[0.2em] border-2 border-dashed border-rose-200 dark:border-rose-900/50 rounded-2xl transition-all duration-300">
                            DELETE ACCOUNT
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <!-- Functional Helpers -->
        <form id="role_upgrade_form" action="<?= base_url('profile/request-role') ?>" method="post" class="hidden">
            <?= csrf_field() ?>
            <input type="hidden" name="requested_role_id" id="target_role_id">
        </form>

        <form id="delete_account_form" action="<?= base_url('profile/delete') ?>" method="post" class="hidden">
            <?= csrf_field() ?>
        </form>

        <script>
            function submitRoleUpgrade() {
                const select = document.getElementById('requested_role_id_select');
                if (!select.value) {
                    alert('Please select a target professional role.');
                    return;
                }
                document.getElementById('target_role_id').value = select.value;
                document.getElementById('role_upgrade_form').submit();
            }

            function handleAccountDeletion() {
                if (confirm('CRITICAL ACTION: This will permanently delete your account and all associated data. Proceed?')) {
                    document.getElementById('delete_account_form').submit();
                }
            }
        </script>
    </div>
</main>

<style>
    @keyframes rotate {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    .rotate-animation {
        animation: rotate 8s linear infinite;
        display: inline-block;
    }

    .custom-scrollbar::-webkit-scrollbar {
        width: 8px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 10px;
    }

    .dark .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #1e293b;
    }
</style>

<?= view('user/include/footer') ?>