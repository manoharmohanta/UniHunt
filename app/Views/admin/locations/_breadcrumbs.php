<nav class="flex items-center gap-1.5 text-sm font-semibold whitespace-nowrap overflow-x-auto pb-1 custom-scrollbar">
    <a href="<?= base_url('admin/locations?tab=countries') ?>" @click="switchTabAndClearSearch('countries')"
        class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg transition-all <?= (!isset($active_country) || !$active_country) ? 'bg-indigo-600 text-white shadow-md shadow-indigo-100' : 'text-slate-500 hover:bg-slate-100 hover:text-indigo-600' ?>">
        <span class="material-symbols-outlined text-[18px]">public</span>
        <span>Countries</span>
    </a>

    <?php if (isset($active_country) && $active_country): ?>
        <span class="text-slate-300 font-normal mx-0.5">
            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
        </span>
        <a href="<?= base_url('admin/locations?tab=states&country_id=' . $active_country['id']) ?>"
            @click="activeTab = 'states'"
            class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg transition-all <?= (!isset($active_state) || !$active_state) ? 'bg-indigo-600 text-white shadow-md shadow-indigo-100' : 'text-slate-500 hover:bg-slate-100 hover:text-indigo-600' ?>">
            <span class="material-symbols-outlined text-[18px]">map</span>
            <span><?= esc($active_country['name']) ?></span>
        </a>
    <?php endif; ?>

    <?php if (isset($active_state) && $active_state): ?>
        <span class="text-slate-300 font-normal mx-0.5">
            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
        </span>
        <a href="<?= base_url('admin/locations?tab=cities&state_id=' . $active_state['id'] . '&country_id=' . ($active_country['id'] ?? '')) ?>"
            @click="activeTab = 'cities'"
            class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg transition-all <?= ($tab == 'cities') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-100' : 'text-slate-500 hover:bg-slate-100 hover:text-indigo-600' ?>">
            <span class="material-symbols-outlined text-[18px]">location_city</span>
            <span><?= esc($active_state['name']) ?></span>
        </a>
    <?php endif; ?>

    <span class="text-slate-300 font-normal mx-0.5">
        <span class="material-symbols-outlined text-[16px]">chevron_right</span>
    </span>
    <a href="<?= base_url('admin/locations?tab=universities' . (isset($active_country['id']) ? '&country_id=' . $active_country['id'] : '') . (isset($active_state['id']) ? '&state_id=' . $active_state['id'] : '')) ?>"
        @click="activeTab = 'universities'"
        class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg transition-all <?= ($tab == 'universities') ? 'bg-emerald-600 text-white shadow-md shadow-emerald-100' : 'text-slate-500 hover:bg-slate-100 hover:text-emerald-600' ?>">
        <span class="material-symbols-outlined text-[18px]">school</span>
        <span>Universities</span>
    </a>
</nav>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        height: 4px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 10px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: #cbd5e1;
    }
</style>