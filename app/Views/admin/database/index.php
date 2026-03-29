<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="max-w-4xl mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Database Switcher -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-8 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-bold text-slate-800">Switch Database</h2>
                    <p class="text-xs text-slate-400 font-medium mt-1">Change the active database connection group</p>
                </div>
                <div class="size-12 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                    <span class="material-symbols-outlined">database</span>
                </div>
            </div>

            <div class="p-8">
                <form action="<?= base_url('admin/database/switch') ?>" method="POST" class="space-y-6"
                    x-data="{ selectedGroup: '<?= $currentGroup ?>', currentGroup: '<?= $currentGroup ?>' }">
                    <?= csrf_field() ?>

                    <div class="space-y-4">
                        <!-- MySQL Option -->
                        <label class="group block relative">
                            <input type="radio" name="db_group" value="default" class="sr-only peer"
                                x-model="selectedGroup" <?= $currentGroup == 'default' ? 'checked' : '' ?>>
                            <div class="flex items-center gap-4 p-5 rounded-2xl border-2 border-slate-100 cursor-pointer transition-all 
                                peer-checked:border-indigo-500 peer-checked:bg-indigo-50/40 peer-checked:shadow-md 
                                hover:border-slate-200">
                                <div
                                    class="size-12 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 
                                    peer-checked:group-[]:text-indigo-600 peer-checked:group-[]:border-indigo-200 peer-checked:group-[]:shadow-inner transition-colors">
                                    <span class="material-symbols-outlined text-2xl">storage</span>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between mb-0.5">
                                        <p
                                            class="font-bold text-slate-800 transition-colors peer-checked:group-[]:text-indigo-900">
                                            MySQL / MariaDB</p>
                                        <div class="flex items-center gap-2">
                                            <template x-if="currentGroup == 'default'">
                                                <span
                                                    class="px-2.5 py-1 bg-emerald-500 text-[10px] font-bold text-white uppercase tracking-wider rounded-lg shadow-sm">Current</span>
                                            </template>
                                            <span
                                                class="material-symbols-outlined text-indigo-500 opacity-0 scale-50 transition-all peer-checked:group-[]:opacity-100 peer-checked:group-[]:scale-100 font-bold">check_circle</span>
                                        </div>
                                    </div>
                                    <p class="text-xs text-slate-500 peer-checked:group-[]:text-indigo-700/70">Standard
                                        production performance for web apps</p>
                                </div>
                            </div>
                        </label>

                        <!-- SQLite Option -->
                        <label class="group block relative">
                            <input type="radio" name="db_group" value="sqlite" class="sr-only peer"
                                x-model="selectedGroup" <?= $currentGroup == 'sqlite' ? 'checked' : '' ?>>
                            <div class="flex items-center gap-4 p-5 rounded-2xl border-2 border-slate-100 cursor-pointer transition-all 
                                peer-checked:border-indigo-500 peer-checked:bg-indigo-50/40 peer-checked:shadow-md 
                                hover:border-slate-200">
                                <div
                                    class="size-12 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 
                                    peer-checked:group-[]:text-indigo-600 peer-checked:group-[]:border-indigo-200 peer-checked:group-[]:shadow-inner transition-colors">
                                    <span class="material-symbols-outlined text-2xl">hard_drive</span>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between mb-0.5">
                                        <p
                                            class="font-bold text-slate-800 transition-colors peer-checked:group-[]:text-indigo-900">
                                            SQLite</p>
                                        <div class="flex items-center gap-2">
                                            <template x-if="currentGroup == 'sqlite'">
                                                <span
                                                    class="px-2.5 py-1 bg-emerald-500 text-[10px] font-bold text-white uppercase tracking-wider rounded-lg shadow-sm">Current</span>
                                            </template>
                                            <span
                                                class="material-symbols-outlined text-indigo-500 opacity-0 scale-50 transition-all peer-checked:group-[]:opacity-100 peer-checked:group-[]:scale-100 font-bold">check_circle</span>
                                        </div>
                                    </div>
                                    <p class="text-xs text-slate-500 peer-checked:group-[]:text-indigo-700/70">
                                        Lightweight file-based database for simple setups</p>
                                </div>
                            </div>
                        </label>
                    </div>

                    <!-- Sync Preview Info -->
                    <div x-show="selectedGroup !== currentGroup" x-transition
                            class="p-6 rounded-2xl bg-indigo-600 text-white shadow-lg shadow-indigo-200">
                            <div class="flex items-start gap-4">
                                <div
                                    class="size-10 rounded-xl bg-white/20 flex items-center justify-center flex-shrink-0 text-white">
                                    <span class="material-symbols-outlined">sync</span>
                                </div>
                                <div>
                                    <h4 class="font-bold text-sm mb-1">Data Synchronization Enabled</h4>
                                    <p class="text-[11px] text-indigo-50/80 leading-relaxed">
                                        Switching will move all data from
                                        <strong class="text-white"
                                            x-text="currentGroup === 'default' ? 'MySQL' : 'SQLite'"></strong>
                                        into
                                        <strong class="text-white"
                                            x-text="selectedGroup === 'default' ? 'MySQL' : 'SQLite'"></strong>.
                                        Existing data in the target will be overwritten.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full h-12 bg-slate-800 text-white rounded-xl font-bold text-sm tracking-wide hover:bg-indigo-600 transition-all flex items-center justify-center gap-2 group">
                            <span
                                class="material-symbols-outlined text-lg group-hover:rotate-180 transition-transform duration-500">sync_alt</span>
                            <span
                                x-text="selectedGroup === currentGroup ? 'Connection Stable' : 'Synchronize & Switch Account'"></span>
                        </button>

                        <div class="p-4 bg-amber-50 rounded-xl border border-amber-100 flex gap-3">
                            <span class="material-symbols-outlined text-amber-500 text-lg">warning</span>
                            <p class="text-[11px] text-amber-600 leading-relaxed">
                                <strong class="block mb-0.5">Note:</strong>
                                Switching databases will affect which data is displayed.
                                If the selected database is empty, you must run migrations to create tables.
                            </p>
                        </div>
                </form>
            </div>
        </div>

        <!-- Migration Tools -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-8 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-bold text-slate-800">Database Tools</h2>
                    <p class="text-xs text-slate-400 font-medium mt-1">Run migrations and maintenance tasks</p>
                </div>
                <div class="size-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                    <span class="material-symbols-outlined">settings_suggest</span>
                </div>
            </div>

            <div class="p-8 space-y-6">
                <div>
                    <h3 class="text-sm font-bold text-slate-800 mb-2">Run Migrations</h3>
                    <p class="text-xs text-slate-400 leading-relaxed mb-4">
                        If you've just switched to a new database or added new migration files,
                        running this will ensure your current database has all the required tables.
                    </p>
                    <form action="<?= base_url('admin/database/migrate') ?>" method="POST">
                        <?= csrf_field() ?>
                        <button type="submit"
                            class="w-full h-12 bg-emerald-600 text-white rounded-xl font-bold text-sm tracking-wide hover:bg-emerald-700 transition-all flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-lg">play_arrow</span>
                            Run Migrations (Latest)
                        </button>
                    </form>
                </div>

                <div class="pt-6 border-t border-slate-100">
                    <h3 class="text-sm font-bold text-slate-800 mb-2">Database Stats</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Active DB</p>
                            <p class="text-sm font-bold text-slate-800">
                                <?= strtoupper($currentGroup) ?>
                            </p>
                        </div>
                        <div class="p-4 rounded-xl bg-slate-50 border border-slate-100">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Environment
                            </p>
                            <p class="text-sm font-bold text-indigo-600">
                                <?= strtoupper(ENVIRONMENT) ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>