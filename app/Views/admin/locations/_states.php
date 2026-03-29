<div class="overflow-x-auto">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-slate-50/50">
                <th
                    class="px-8 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">
                    State Name</th>
                <th
                    class="px-8 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">
                    Country</th>
                <th
                    class="px-8 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">
                    Universities</th>
                <th
                    class="px-8 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100 text-right">
                    Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
            <?php foreach ($states as $state): ?>
                <tr class="hover:bg-slate-50/50 transition-colors group">
                    <td class="px-8 py-4 text-sm font-bold text-slate-700">
                        <a href="<?= base_url('admin/locations?tab=cities&state_id=' . $state['id'] . '&country_id=' . $state['country_id']) ?>"
                            class="hover:text-indigo-600 hover:underline">
                            <?= esc($state['name']) ?>
                        </a>
                    </td>
                    <td class="px-8 py-4 text-sm text-slate-500 font-medium">
                        <?= esc($state['country_name']) ?>
                    </td>
                    <td class="px-8 py-4 text-sm font-bold">
                        <a href="<?= base_url('admin/locations?tab=universities&state_id=' . $state['id'] . '&country_id=' . $state['country_id']) ?>"
                            class="inline-flex items-center gap-1.5 px-3 py-1 bg-emerald-50 text-emerald-700 rounded-full hover:bg-emerald-100 transition-colors">
                            <span class="material-symbols-outlined text-[16px]">school</span>
                            <?= $state['university_count'] ?> Universities
                        </a>
                    </td>
                    <td class="px-8 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="<?= base_url('admin/locations?tab=cities&state_id=' . $state['id'] . '&country_id=' . $state['country_id']) ?>"
                                class="text-xs font-bold text-indigo-600 px-3 py-1 bg-indigo-50 rounded-lg hover:bg-indigo-100 transition-colors">
                                View Cities
                            </a>
                            <button
                                onclick='openStateModal(<?= json_encode($state, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>)'
                                class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-all inline-flex opacity-0 group-hover:opacity-100">
                                <span class="material-symbols-outlined text-[20px]">edit</span>
                            </button>
                            <a href="<?= base_url('admin/locations/delete-state/' . $state['id']) ?>"
                                onclick="return confirm('Delete this state and all its cities?')"
                                class="p-2 text-rose-500 hover:bg-rose-50 rounded-lg transition-all inline-flex opacity-0 group-hover:opacity-100">
                                <span class="material-symbols-outlined text-[20px]">delete</span>
                            </a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php if ($states_pager): ?>
    <div class="px-8 py-4 border-t border-slate-100">
        <?= $states_pager->links('states', 'tailwind_full') ?>
    </div>
<?php endif; ?>