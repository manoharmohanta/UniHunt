<form action="<?= base_url('admin/locations') ?>" method="GET" class="flex flex-wrap items-center gap-3">
    <input type="hidden" name="tab" value="<?= esc($tab) ?>">

    <?php if ($tab !== 'countries'): ?>
        <div class="flex items-center gap-2">
            <select name="country_id" id="searchCountryId" onchange="this.form.submit()"
                class="px-3 py-1.5 border border-slate-200 rounded-lg text-xs focus:ring-2 focus:ring-indigo-50/20 focus:border-indigo-500 outline-none bg-white">
                <option value="">All Countries</option>
                <?php foreach ($all_countries as $country): ?>
                    <option value="<?= $country['id'] ?>" <?= ($country_id == $country['id']) ? 'selected' : '' ?>>
                        <?= esc($country['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    <?php endif; ?>

    <?php if (in_array($tab, ['cities', 'universities']) && $country_id): ?>
        <div class="flex items-center gap-2">
            <select name="state_id" id="searchStateId" onchange="this.form.submit()"
                class="px-3 py-1.5 border border-slate-200 rounded-lg text-xs focus:ring-2 focus:ring-indigo-50/20 focus:border-indigo-500 outline-none bg-white">
                <option value="">All States</option>
                <?php
                $db = \Config\Database::connect();
                $states = $db->table('states')->where('country_id', $country_id)->get()->getResultArray();
                foreach ($states as $state): ?>
                    <option value="<?= $state['id'] ?>" <?= ($state_id == $state['id']) ? 'selected' : '' ?>>
                        <?= esc($state['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    <?php elseif (isset($state_id) && $state_id && !in_array($tab, ['cities', 'universities'])): ?>
        <input type="hidden" name="state_id" value="<?= $state_id ?>">
    <?php endif; ?>

    <div class="relative">
        <input type="text" name="q" placeholder="Search..." x-ref="searchInput" value="<?= esc($search ?? '') ?>"
            class="pl-9 pr-4 py-1.5 border border-slate-200 rounded-lg text-xs focus:ring-2 focus:ring-indigo-50/20 focus:border-indigo-500 outline-none w-48 bg-white">
        <span
            class="material-symbols-outlined absolute left-2.5 top-1/2 -translate-y-1/2 text-slate-400 text-[16px]">search</span>
    </div>

    <div class="flex gap-2">
        <button type="submit"
            class="px-4 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-lg transition-colors">Filter</button>

        <?php if ($search || $country_id || $state_id): ?>
            <a href="<?= base_url('admin/locations?tab=' . $tab) ?>"
                class="px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-medium rounded-lg transition-colors flex items-center gap-1">
                <span class="material-symbols-outlined text-[14px]">close</span> Clear
            </a>
        <?php endif; ?>
    </div>
</form>