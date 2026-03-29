<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <!-- Header Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-8 py-6 border-b border-slate-100 flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="text-xl font-bold text-slate-800">Manage Universities</h2>
                <p class="text-sm text-slate-500">View and manage all registered universities</p>
            </div>
            <div class="flex flex-wrap gap-3 items-center">
                <form action="<?= base_url('admin/universities') ?>" method="GET" class="flex items-center gap-2">
                    <div class="relative group">
                        <input type="text" name="search" value="<?= esc($search) ?>"
                            placeholder="Search universities..."
                            class="pl-10 pr-10 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all w-64 group-hover:bg-white">
                        <span
                            class="material-symbols-outlined absolute left-3 top-2.5 text-slate-400 text-sm group-hover:text-indigo-500 transition-colors">search</span>
                        <?php if ($search): ?>
                            <a href="<?= base_url('admin/universities') ?>"
                                class="absolute right-3 top-2.5 text-slate-400 hover:text-rose-500 transition-colors">
                                <span class="material-symbols-outlined text-sm">close</span>
                            </a>
                        <?php endif; ?>
                    </div>
                    <button type="submit"
                        class="px-4 py-2 bg-slate-800 text-white text-sm font-semibold rounded-xl hover:bg-slate-900 transition-all shadow-sm">
                        Search
                    </button>
                </form>
                <div class="h-8 w-px bg-slate-200 mx-1 hidden md:block"></div>

                <?php if (session()->get('role_id') != 4): // Not Uni Rep ?>
                    <a href="<?= base_url('admin/universities/create') ?>"
                        class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition-all shadow-lg shadow-indigo-100 flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">add</span> Add New
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th
                            class="px-8 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">
                            Image</th>
                        <th
                            class="px-8 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">
                            University Name</th>
                        <th
                            class="px-8 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">
                            Country</th>
                        <th
                            class="px-8 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">
                            Ranking</th>
                        <th
                            class="px-8 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">
                            Tuition Range</th>
                        <th
                            class="px-8 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100 text-right">
                            Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php foreach ($universities as $uni): ?>
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-8 py-4">
                                <?php if ($uni['main_image']): ?>
                                    <img src="<?= base_url($uni['main_image']) ?>"
                                        class="size-12 rounded-xl object-cover ring-2 ring-slate-100">
                                <?php else: ?>
                                    <div
                                        class="size-12 rounded-xl bg-slate-100 flex items-center justify-center text-slate-400">
                                        <span class="material-symbols-outlined text-xl">image</span>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="px-8 py-4">
                                <div class="text-sm font-bold text-slate-700"><?= $uni['name'] ?></div>
                                <div class="text-[10px] text-slate-400 font-medium uppercase tracking-tight">
                                    <?= $uni['type'] ?? 'University' ?>
                                </div>
                            </td>
                            <td class="px-8 py-4 text-sm text-slate-500 font-medium"><?= $uni['country_name'] ?></td>
                            <td class="px-8 py-4 text-sm text-slate-500 font-medium">
                                <span
                                    class="px-2.5 py-1 bg-indigo-50 text-indigo-600 rounded-lg text-xs font-bold">#<?= $uni['ranking'] ?></span>
                            </td>
                            <td class="px-8 py-4 text-sm text-slate-500 font-medium"><?= $uni['tuition_fee_min'] ?> -
                                <?= $uni['tuition_fee_max'] ?>
                            </td>
                            <td class="px-8 py-4 text-right">
                                <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-all">
                                    <a href="<?= base_url('universities/' . ($uni['country_slug'] ?? url_title($uni['country_name'], '-', true)) . '/' . ($uni['slug'] ?? url_title($uni['name'], '-', true))) ?>"
                                        target="_blank"
                                        class="p-2 text-emerald-500 hover:bg-emerald-50 rounded-lg transition-all"
                                        title="View Public Listing">
                                        <span class="material-symbols-outlined text-[20px]">visibility</span>
                                    </a>
                                    <a href="<?= base_url('admin/universities/modify-listing/' . $uni['id']) ?>"
                                        class="p-2 text-indigo-500 hover:bg-indigo-50 rounded-lg transition-all">
                                        <span class="material-symbols-outlined text-[20px]">edit</span>
                                    </a>
                                    <?php if (session()->get('role_id') == 1): // Admin Only ?>
                                        <a href="<?= base_url('admin/universities/delete/' . $uni['id']) ?>"
                                            onclick="return confirm('Are you sure you want to delete this university? All associated courses and images will be removed.')"
                                            class="p-2 text-rose-500 hover:bg-rose-50 rounded-lg transition-all"
                                            title="Delete University">
                                            <span class="material-symbols-outlined text-[20px]">delete</span>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if ($pager->getPageCount() > 1): ?>
            <div class="px-8 py-6 bg-slate-50/50 border-t border-slate-100">
                <?= $pager->links('default', 'tailwind_full') ?>
            </div>
        <?php endif; ?>
    </div>
</div>


<?= $this->endSection() ?>