<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="space-y-6">

    <!-- Alerts handled by layout.php -->

    <!-- Header Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-8 py-6 border-b border-slate-100 flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="text-xl font-bold text-slate-800">Location Management</h2>
                <p class="text-sm text-slate-500">Manage global countries, states, and cities</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <button onclick="openCountryModal()"
                    class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition-all shadow-lg shadow-indigo-100 flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">add</span> Add Country
                </button>
                <button onclick="openStateModal()"
                    class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white text-sm font-semibold rounded-xl transition-all shadow-lg shadow-slate-100 flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">add_location_alt</span> Add State
                </button>
                <button onclick="openCityModal()"
                    class="px-4 py-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 text-sm font-semibold rounded-xl transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">location_city</span> Add City
                </button>
            </div>
        </div>

        <div
            class="px-8 bg-slate-50/50 border-b border-slate-200 py-4 flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <?= view('admin/locations/_breadcrumbs', [
                    'active_country' => $active_country,
                    'active_state' => $active_state,
                    'tab' => $tab
                ]) ?>
            </div>

            <div class="flex items-center gap-4">
                <div class="relative">
                    <?= view('admin/locations/_search_form', [
                        'tab' => $tab,
                        'country_id' => $country_id,
                        'state_id' => $state_id,
                        'search' => $search,
                        'all_countries' => $all_countries
                    ]) ?>
                </div>
            </div>
        </div>

        <div class="p-0 min-h-[400px]" id="table-result">
            <!-- Initial content loaded based on $tab -->
            <?= view('admin/locations/_' . $tab, [
                'countries' => $countries,
                'countries_pager' => $countries_pager,
                'states' => $states,
                'states_pager' => $states_pager,
                'cities' => $cities,
                'cities_pager' => $cities_pager,
                'universities' => $universities,
                'universities_pager' => $universities_pager,
                'tab' => $tab,
                'active_country' => $active_country,
                'active_state' => $active_state,
                'search' => $search,
                'country_id' => $country_id,
                'state_id' => $state_id
            ]) ?>
        </div>
    </div>
</div>

<!-- Modal Country -->
<div id="countryModal" class="modal-overlay items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-lg modal-content-tw overflow-hidden shadow-2xl">
        <form id="countryForm" action="<?= base_url('admin/locations/store-country') ?>" method="POST">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" id="countryMethod" value="POST">
            <div class="px-8 py-6 bg-slate-50 border-b border-slate-100 flex justify-between items-center">
                <h3 class="text-xl font-bold text-slate-800" id="countryModalTitle">Add New Country</h3>
                <button type="button" onclick="closeModal('countryModal')"
                    class="size-8 rounded-full hover:bg-slate-200 flex items-center justify-center transition-colors">
                    <span class="material-symbols-outlined text-slate-500 text-sm">close</span>
                </button>
            </div>
            <div class="px-8 py-6 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Country
                            Name</label>
                        <input type="text" name="name" id="countryName"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 font-medium"
                            required placeholder="e.g. Canada">
                    </div>
                    <div>
                        <label
                            class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Code</label>
                        <input type="text" name="code" id="countryCode" maxlength="3"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 font-medium uppercase"
                            required placeholder="CAN">
                    </div>
                    <div>
                        <label
                            class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Currency</label>
                        <input type="text" name="currency" id="countryCurrency"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 font-medium uppercase"
                            placeholder="CAD">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Min Living
                            Cost</label>
                        <input type="number" name="living_cost_min" id="countryMinCost"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 font-medium"
                            placeholder="0">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Max Living
                            Cost</label>
                        <input type="number" name="living_cost_max" id="countryMaxCost"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 font-medium"
                            placeholder="0">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">GIC Amount
                            (if applicable)</label>
                        <input type="number" name="gic_amount" id="countryGic"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 font-medium"
                            placeholder="0">
                    </div>
                </div>
            </div>
            <div class="px-8 py-6 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
                <button type="button" onclick="closeModal('countryModal')"
                    class="px-6 py-2.5 text-slate-500 font-bold text-sm hover:text-slate-700 transition-colors">Cancel</button>
                <button type="submit" id="countrySubmitBtn"
                    class="px-6 py-2.5 bg-indigo-600 text-white font-bold text-sm rounded-xl hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-100">Save
                    Country</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal State -->
<div id="stateModal" class="modal-overlay items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-md modal-content-tw overflow-hidden shadow-2xl">
        <form id="stateForm" action="<?= base_url('admin/locations/store-state') ?>" method="POST">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" id="stateMethod" value="POST">
            <div class="px-8 py-6 bg-slate-50 border-b border-slate-100 flex justify-between items-center">
                <h3 class="text-xl font-bold text-slate-800" id="stateModalTitle">Add State</h3>
                <button type="button" onclick="closeModal('stateModal')"
                    class="size-8 rounded-full hover:bg-slate-200 flex items-center justify-center transition-colors">
                    <span class="material-symbols-outlined text-slate-500 text-sm">close</span>
                </button>
            </div>
            <div class="px-8 py-6 space-y-5">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Target
                        Country</label>
                    <select name="country_id" id="stateCountryId"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 font-medium"
                        required>
                        <option value="">-- Select Country --</option>
                        <?php foreach ($all_countries as $country): ?>
                            <option value="<?= $country['id'] ?>" <?= (isset($active_country['id']) && $active_country['id'] == $country['id']) ? 'selected' : '' ?>>
                                <?= esc($country['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class=" block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">State
                        Name</label>
                    <input type="text" name="name" id="stateName"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 font-medium"
                        required placeholder="e.g. Ontario">
                </div>
            </div>
            <div class="px-8 py-6 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
                <button type="button" onclick="closeModal('stateModal')"
                    class="px-6 py-2.5 text-slate-500 font-bold text-sm hover:text-slate-700 transition-colors">Cancel</button>
                <button type="submit" id="stateSubmitBtn"
                    class="px-6 py-2.5 bg-slate-800 text-white font-bold text-sm rounded-xl hover:bg-slate-900 transition-all shadow-lg shadow-slate-100">Save
                    State</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal City -->
<div id="cityModal" class="modal-overlay items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-md modal-content-tw overflow-hidden shadow-2xl">
        <form id="cityForm" action="<?= base_url('admin/locations/store-city') ?>" method="POST">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" id="cityMethod" value="POST">
            <div class="px-8 py-6 bg-slate-50 border-b border-slate-100 flex justify-between items-center">
                <h3 class="text-xl font-bold text-slate-800" id="cityModalTitle">Add City</h3>
                <button type="button" onclick="closeModal('cityModal')"
                    class="size-8 rounded-full hover:bg-slate-200 flex items-center justify-center transition-colors">
                    <span class="material-symbols-outlined text-slate-500 text-sm">close</span>
                </button>
            </div>
            <div class="px-8 py-6 space-y-5">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Country</label>
                    <select name="country_id" id="cityCountryId" onchange="loadStates(this.value)"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 font-medium"
                        required>
                        <option value="">-- Select Country --</option>
                        <?php foreach ($all_countries as $country): ?>
                            <option value="<?= $country['id'] ?>" <?= (isset($active_country['id']) && $active_country['id'] == $country['id']) ? 'selected' : '' ?>>
                                <?= esc($country['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div id="stateSelectContainer" style="<?= (isset($active_country['id'])) ? '' : 'display: none;' ?>">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">State
                        (Optional)</label>
                    <select name="state_id" id="cityStateId"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 font-medium">
                        <option value="">-- Select State --</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">City
                        Name</label>
                    <input type="text" name="name" id="cityName"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 font-medium"
                        required placeholder="e.g. Toronto">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Living
                        Cost</label>
                    <input type="number" step="0.01" name="living_cost" id="cityLivingCost"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 font-medium"
                        placeholder="Monthly amount">
                </div>
            </div>
            <div class="px-8 py-6 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
                <button type="button" onclick="closeModal('cityModal')"
                    class="px-6 py-2.5 text-slate-500 font-bold text-sm hover:text-slate-700 transition-colors">Cancel</button>
                <button type="submit" id="citySubmitBtn"
                    class="px-6 py-2.5 bg-slate-900 text-white font-bold text-sm rounded-xl hover:bg-black transition-all shadow-lg shadow-slate-200">Save
                    City</button>
            </div>
        </form>
    </div>
</div>

<script>
    const BASE_URL = '<?= base_url() ?>';

    document.addEventListener('DOMContentLoaded', () => {
        const activeCountryId = '<?= $active_country['id'] ?? '' ?>';
        if (activeCountryId) {
            loadStates(activeCountryId, '<?= $active_state['id'] ?? '' ?>');
        }
    });

    async function loadStates(countryId, selectedStateId = null) {
        const stateSelect = document.getElementById('cityStateId');
        const container = document.getElementById('stateSelectContainer');

        if (!countryId) {
            container.style.display = 'none';
            stateSelect.innerHTML = '<option value="">-- Select State --</option>';
            return;
        }

        try {
            const res = await fetch(`${BASE_URL}/admin/locations/get-states/${countryId}`);
            const states = await res.json();

            container.style.display = 'block';
            let html = '<option value="">-- Select State --</option>';
            states.forEach(state => {
                const selected = (selectedStateId && selectedStateId == state.id) ? 'selected' : '';
                html += `<option value="${state.id}" ${selected}>${state.name}</option>`;
            });
            stateSelect.innerHTML = html;
        } catch (e) {
            console.error('Error loading states:', e);
        }
    }

    function openCountryModal(data = null) {
        const form = document.getElementById('countryForm');
        const title = document.getElementById('countryModalTitle');
        const method = document.getElementById('countryMethod');
        const submitBtn = document.getElementById('countrySubmitBtn');

        if (data) {
            title.innerText = 'Edit Country';
            form.action = `${BASE_URL}/admin/locations/update-country/${data.id}`;
            method.value = 'POST'; // CI4 handles PUT via hidden field if enabled, but we use POST for simplicitly or actual POST route
            submitBtn.innerText = 'Update Country';

            document.getElementById('countryName').value = data.name || '';
            document.getElementById('countryCode').value = data.code || '';
            document.getElementById('countryCurrency').value = data.currency || '';
            document.getElementById('countryMinCost').value = data.living_cost_min || '';
            document.getElementById('countryMaxCost').value = data.living_cost_max || '';
            document.getElementById('countryGic').value = data.gic_amount || '';
        } else {
            title.innerText = 'Add New Country';
            form.action = `${BASE_URL}/admin/locations/store-country`;
            method.value = 'POST';
            submitBtn.innerText = 'Save Country';
            form.reset();
        }
        openModal('countryModal');
    }

    function openStateModal(data = null) {
        const form = document.getElementById('stateForm');
        const title = document.getElementById('stateModalTitle');
        const method = document.getElementById('stateMethod');
        const submitBtn = document.getElementById('stateSubmitBtn');

        if (data) {
            title.innerText = 'Edit State';
            form.action = `${BASE_URL}/admin/locations/update-state/${data.id}`;
            method.value = 'POST';
            submitBtn.innerText = 'Update State';

            document.getElementById('stateCountryId').value = data.country_id || '';
            document.getElementById('stateName').value = data.name || '';
        } else {
            title.innerText = 'Add State';
            form.action = `${BASE_URL}/admin/locations/store-state`;
            method.value = 'POST';
            submitBtn.innerText = 'Save State';
            form.reset();
            // Preserve context if available
            const activeCountry = '<?= $active_country['id'] ?? '' ?>';
            if (activeCountry) document.getElementById('stateCountryId').value = activeCountry;
        }
        openModal('stateModal');
    }

    async function openCityModal(data = null) {
        const form = document.getElementById('cityForm');
        const title = document.getElementById('cityModalTitle');
        const method = document.getElementById('cityMethod');
        const submitBtn = document.getElementById('citySubmitBtn');

        if (data) {
            title.innerText = 'Edit City';
            form.action = `${BASE_URL}/admin/locations/update-city/${data.id}`;
            method.value = 'POST';
            submitBtn.innerText = 'Update City';

            document.getElementById('cityCountryId').value = data.country_id || '';
            await loadStates(data.country_id, data.state_id);
            document.getElementById('cityName').value = data.name || '';
            document.getElementById('cityLivingCost').value = data.living_cost || '';
        } else {
            title.innerText = 'Add City';
            form.action = `${BASE_URL}/admin/locations/store-city`;
            method.value = 'POST';
            submitBtn.innerText = 'Save City';
            form.reset();

            const activeCountry = '<?= $active_country['id'] ?? '' ?>';
            const activeState = '<?= $active_state['id'] ?? '' ?>';

            if (activeCountry) {
                document.getElementById('cityCountryId').value = activeCountry;
                await loadStates(activeCountry, activeState);
            }
        }
        openModal('cityModal');
    }

    // Modal Helper functions
    function openModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.style.display = 'flex';
            setTimeout(() => { modal.classList.add('active'); }, 10);
            document.body.style.overflow = 'hidden';
        }
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.classList.remove('active');
            setTimeout(() => { modal.style.display = 'none'; }, 300);
            document.body.style.overflow = '';
        }
    }
</script>

<style>
    .modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        z-index: 100;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .modal-overlay.active {
        opacity: 1;
    }

    .modal-content-tw {
        transform: scale(0.95);
        transition: transform 0.3s ease;
    }

    .modal-overlay.active .modal-content-tw {
        transform: scale(1);
    }
</style>

<?= $this->endSection() ?>