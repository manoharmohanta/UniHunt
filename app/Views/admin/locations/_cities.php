<div class="overflow-x-auto">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-slate-50/50">
                <th
                    class="px-8 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">
                    City Name</th>
                <th
                    class="px-8 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">
                    State</th>
                <th
                    class="px-8 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">
                    Country</th>
                <th
                    class="px-8 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100 text-right">
                    Action</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-50">
            <?php foreach ($cities as $city): ?>
                <tr class="hover:bg-slate-50/50 transition-colors group">
                    <td class="px-8 py-4 text-sm font-bold text-slate-700">
                        <?= esc($city['name']) ?>
                    </td>
                    <td class="px-8 py-4 text-sm text-slate-500 font-medium">
                        <?= esc($city['state_name'] ?? 'N/A') ?>
                    </td>
                    <td class="px-8 py-4 text-sm text-slate-500 font-medium">
                        <?= esc($city['country_name']) ?>
                    </td>
                    <td class="px-8 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <button
                                onclick='openCityModal(<?= json_encode($city, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>)'
                                class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-all inline-flex opacity-0 group-hover:opacity-100">
                                <span class="material-symbols-outlined text-[20px]">edit</span>
                            </button>
                            <a href="<?= base_url('admin/locations/delete-city/' . $city['id']) ?>"
                                onclick="return confirm('Delete this city?')"
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
<?php if ($cities_pager): ?>
    <div class="px-8 py-4 border-t border-slate-100">
        <?= $cities_pager->links('cities', 'tailwind_full') ?>
    </div>
<?php endif; ?>