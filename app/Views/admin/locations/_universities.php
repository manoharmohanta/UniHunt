<div class="overflow-x-auto">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-slate-50/50">
                <th
                    class="px-8 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">
                    University</th>
                <th
                    class="px-8 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">
                    Location</th>
                <th
                    class="px-8 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">
                    Type</th>
                <th
                    class="px-8 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">
                    Ranking</th>
                <th
                    class="px-8 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100 text-right">
                    Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
            <?php foreach ($universities as $uni): ?>
                <tr class="hover:bg-slate-50/50 transition-colors group">
                    <td class="px-8 py-4">
                        <div class="flex flex-col">
                            <span class="text-sm font-bold text-slate-700">
                                <?= esc($uni['name']) ?>
                            </span>
                            <span class="text-[11px] text-slate-400">
                                <?= esc($uni['website']) ?>
                            </span>
                        </div>
                    </td>
                    <td class="px-8 py-4">
                        <div class="flex items-center gap-1.5 text-xs font-medium text-slate-600">
                            <span class="material-symbols-outlined text-[16px] text-slate-400">location_on</span>
                            <?= esc($uni['country_name']) ?>
                            <?= esc($uni['state_name'] ? ', ' . $uni['state_name'] : '') ?>
                        </div>
                    </td>
                    <td class="px-8 py-4">
                        <span
                            class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider <?= $uni['type'] == 'public' ? 'bg-blue-50 text-blue-600' : 'bg-purple-50 text-purple-600' ?>">
                            <?= esc($uni['type']) ?>
                        </span>
                    </td>
                    <td class="px-8 py-4">
                        <div class="flex items-center gap-1 text-sm font-bold text-slate-700">
                            <span class="material-symbols-outlined text-[16px] text-amber-400">military_tech</span>
                            #
                            <?= $uni['ranking'] ?>
                        </div>
                    </td>
                    <td class="px-8 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="<?= base_url('admin/universities/modify-listing/' . $uni['id']) ?>"
                                class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all inline-flex">
                                <span class="material-symbols-outlined text-[20px]">edit</span>
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($universities)): ?>
                <tr>
                    <td colspan="5" class="px-8 py-12 text-center text-slate-500">
                        <div class="flex flex-col items-center gap-2">
                            <span class="material-symbols-outlined text-4xl text-slate-300">school</span>
                            <p>No universities found for this location.</p>
                        </div>
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php if ($universities_pager): ?>
    <div class="px-8 py-4 border-t border-slate-100">
        <?= $universities_pager->links('universities', 'tailwind_full') ?>
    </div>
<?php endif; ?>