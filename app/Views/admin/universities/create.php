<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="max-w-4xl mx-auto">
    <!-- Breadcrumb/Back -->
    <a href="<?= base_url('admin/universities') ?>"
        class="inline-flex items-center gap-2 text-slate-500 hover:text-indigo-600 font-bold text-sm mb-6 transition-colors">
        <span class="material-symbols-outlined text-sm">arrow_back</span> Back to list
    </a>

    <!-- Form Card -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-10 py-8 border-b border-slate-100 bg-slate-50/50">
            <h2 class="text-2xl font-bold text-slate-800">Add New University</h2>
            <p class="text-slate-500 font-medium mt-1">Configure institutional profile and settings</p>
        </div>

        <form action="<?= base_url('admin/universities/store') ?>" method="POST" enctype="multipart/form-data"
            x-data="universityForm()">
            <?= csrf_field() ?>
            <?= honeypot_field() ?>
            <div class="p-10 space-y-8">
                <!-- Basic Info Section -->
                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                        <div class="size-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                            <span class="material-symbols-outlined text-sm">info</span>
                        </div>
                        <h3 class="font-bold text-slate-800">Basic Information</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <div class="flex items-center justify-between mb-2">
                                <label
                                    class="block text-xs font-bold text-slate-500 uppercase tracking-widest">University
                                    Name</label>
                                <button type="button" @click="discoverUniversity()" id="discoverBtn"
                                    class="flex items-center gap-1.5 text-[11px] font-bold text-indigo-600 hover:text-indigo-700 transition-colors bg-indigo-50 px-2 py-1 rounded-lg">
                                    <span class="material-symbols-outlined text-sm">auto_awesome</span>
                                    Autofill with AI
                                </button>
                            </div>
                            <input type="text" name="name" id="uniName"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-medium"
                                placeholder="Enter institution name" required>
                        </div>

                        <div>
                            <label
                                class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Country</label>
                            <select name="country_id" x-model="countryId" @change="fetchRequirements()"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-medium"
                                required>
                                <option value="">Select Country</option>
                                <?php foreach ($countries as $c): ?>
                                    <option value="<?= $c['id'] ?>"><?= $c['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div>
                            <label
                                class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">State/Province</label>
                            <select name="state_id" id="stateSelect"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-medium">
                                <option value="">Select State</option>
                                <?php foreach ($states as $s): ?>
                                    <option value="<?= $s['id'] ?>"><?= $s['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div>
                            <label
                                class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Institution
                                Type</label>
                            <select name="type"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-medium"
                                required>
                                <option value="public">Public</option>
                                <option value="private">Private</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Website
                                URL</label>
                            <input type="url" name="website"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-medium"
                                placeholder="https://example.edu">
                        </div>
                    </div>
                </div>

                <hr class="border-slate-100">

                <!-- Stats & Ranking -->
                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                        <div class="size-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                            <span class="material-symbols-outlined text-sm">stars</span>
                        </div>
                        <h3 class="font-bold text-slate-800">Ranking & Tuition</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">QS
                                Global Ranking</label>
                            <input type="number" name="ranking"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-medium"
                                placeholder="Global Rank">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Tuition
                                Min (Yearly)</label>
                            <input type="number" step="0.01" name="tuition_fee_min"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-medium"
                                placeholder="0.00">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Tuition
                                Max (Yearly)</label>
                            <input type="number" step="0.01" name="tuition_fee_max"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-medium"
                                placeholder="0.00">
                        </div>
                    </div>
                </div>

                <hr class="border-slate-100">

                <!-- Media Section -->
                <div class="space-y-6" x-data="imageUploader()">
                    <div class="flex items-center gap-3">
                        <div class="size-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                            <span class="material-symbols-outlined text-sm">image</span>
                        </div>
                        <h3 class="font-bold text-slate-800">Media & Assets</h3>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between mb-2">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest">University
                                Images</label>
                            <button type="button" @click="scrapeImages()" id="scrapeBtn"
                                class="flex items-center gap-1.5 text-[11px] font-bold text-indigo-600 hover:text-indigo-700 transition-colors bg-indigo-50 px-2 py-1 rounded-lg">
                                <span class="material-symbols-outlined text-sm">public</span>
                                Scrape from Web
                            </button>
                        </div>

                        <!-- Dropzone -->
                        <div @dragover.prevent="isDragging = true" @dragleave.prevent="isDragging = false"
                            @drop.prevent="handleDrop($event)"
                            :class="{'border-indigo-400 bg-indigo-50/30': isDragging, 'border-slate-200 bg-slate-50/30': !isDragging}"
                            class="border-2 border-dashed rounded-2xl p-8 text-center hover:bg-white hover:border-indigo-400 transition-all group relative">

                            <input type="file" name="images[]" multiple accept="image/*" class="hidden" id="uniImages"
                                @change="handleFiles($event.target.files)">

                            <label for="uniImages" class="cursor-pointer block">
                                <span
                                    class="material-symbols-outlined text-4xl text-slate-300 group-hover:text-indigo-500 transition-all mb-2">add_photo_alternate</span>
                                <p class="text-sm font-bold text-slate-600">Drag & Drop or Click to Upload</p>
                                <p class="text-[11px] text-slate-400 mt-1 font-medium">Select multiple institutional
                                    photos</p>
                            </label>
                        </div>

                        <!-- Previews Container -->
                        <div x-show="previews.length > 0" class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
                            <template x-for="(preview, index) in previews" :key="index">
                                <div
                                    class="relative aspect-video rounded-xl overflow-hidden border border-slate-200 group bg-white shadow-sm">
                                    <img :src="preview.url" class="w-full h-full object-cover">

                                    <!-- Badge for Main Photo -->
                                    <div x-show="index === 0"
                                        class="absolute top-2 left-2 px-2 py-0.5 bg-indigo-600 text-[9px] font-bold text-white rounded-md shadow-sm">
                                        MAIN
                                    </div>

                                    <!-- Delete Button -->
                                    <button type="button" @click="removeImage(index)"
                                        class="absolute top-2 right-2 size-6 rounded-lg bg-white/90 text-rose-500 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all hover:bg-rose-500 hover:text-white shadow-sm border border-rose-100">
                                        <span class="material-symbols-outlined text-sm">delete</span>
                                    </button>

                                    <!-- Overlay for hover -->
                                    <div
                                        class="absolute inset-0 bg-slate-900/10 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none">
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <div class="col-span-2 space-y-4">
                    <div class="flex items-center gap-6 p-4 bg-slate-50 rounded-xl">
                        <div class="flex items-center gap-3">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="stem_available" id="stemToggle" value="1"
                                    class="sr-only peer" x-model="stemAvailable">
                                <div
                                    class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-100 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600">
                                </div>
                            </label>
                            <span class="text-sm font-bold text-slate-700">STEM Programs Available</span>
                        </div>

                        <div x-show="!stemAvailable" class="items-center gap-3 border-l border-slate-200 pl-6 flex">
                            <span
                                class="text-xs font-bold text-slate-500 uppercase tracking-widest">Classification</span>
                            <div class="flex gap-2">
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input type="radio" name="classification" value="International" class="hidden peer">
                                    <div
                                        class="px-3 py-1.5 rounded-lg border border-slate-200 text-xs font-bold text-slate-500 peer-checked:border-indigo-600 peer-checked:bg-indigo-50 peer-checked:text-indigo-600 transition-all hover:bg-slate-100">
                                        International</div>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input type="radio" name="classification" value="Domestic" class="hidden peer">
                                    <div
                                        class="px-3 py-1.5 rounded-lg border border-slate-200 text-xs font-bold text-slate-500 peer-checked:border-indigo-600 peer-checked:bg-indigo-50 peer-checked:text-indigo-600 transition-all hover:bg-slate-100">
                                        Domestic</div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dynamic Requirements -->
                <div class="col-span-2 pt-4" x-show="requirements.length > 0 || countryInfo">
                    <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-indigo-600">fact_check</span>
                            University Specific Requirements
                        </div>
                        <div x-show="loading"
                            class="animate-spin size-4 border-2 border-indigo-600 border-t-transparent rounded-full">
                        </div>
                    </h3>

                    <!-- Embassy Data Highlights -->
                    <div x-show="countryInfo" class="mb-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <template x-if="countryInfo && countryInfo.living_cost_min">
                            <div class="p-4 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center gap-4">
                                <div
                                    class="size-10 rounded-xl bg-white text-indigo-600 flex items-center justify-center shadow-sm">
                                    <span class="material-symbols-outlined">payments</span>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-indigo-400 uppercase tracking-widest">Embassy
                                        Living Costs</p>
                                    <p class="text-sm font-bold text-indigo-900">
                                        <span x-text="countryInfo.currency"></span>
                                        <span x-text="countryInfo.living_cost_min"></span> -
                                        <span x-text="countryInfo.living_cost_max"></span>
                                    </p>
                                </div>
                            </div>
                        </template>
                        <template x-if="countryInfo && countryInfo.gic_amount">
                            <div
                                class="p-4 rounded-2xl bg-emerald-50 border border-emerald-100 flex items-center gap-4">
                                <div
                                    class="size-10 rounded-xl bg-white text-emerald-600 flex items-center justify-center shadow-sm">
                                    <span class="material-symbols-outlined">account_balance_wallet</span>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-emerald-400 uppercase tracking-widest">Embassy
                                        GIC
                                        Amount</p>
                                    <p class="text-sm font-bold text-emerald-900">
                                        <span x-text="countryInfo.currency"></span>
                                        <span x-text="countryInfo.gic_amount"></span>
                                    </p>
                                </div>
                            </div>
                        </template>
                    </div>

                    <div
                        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 p-6 bg-slate-50/50 rounded-2xl border border-slate-100">
                        <template x-for="req in requirements" :key="req.code">
                            <div :class="req.type == 'string' ? 'md:col-span-2' : ''">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2"
                                    x-text="req.label"></label>

                                <template x-if="req.type == 'number'">
                                    <div class="space-y-1 group">
                                        <input type="text" :name="'metadata[' + req.code + ']'"
                                            x-model="savedMetadata[req.code]"
                                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-medium"
                                            placeholder="Score or 'Not Accepted'">
                                        <div
                                            class="flex flex-wrap gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <button type="button" @click="savedMetadata[req.code] = 'Waiver Available'"
                                                class="text-[9px] font-bold text-emerald-600 uppercase hover:underline">Mark
                                                Waiver</button>
                                            <button type="button" @click="savedMetadata[req.code] = 'Not Accepted'"
                                                class="text-[9px] font-bold text-rose-500 uppercase hover:underline">Mark
                                                Not
                                                Accepted</button>
                                            <button type="button" @click="savedMetadata[req.code] = 'N/A'"
                                                class="text-[9px] font-bold text-slate-400 uppercase hover:underline">N/A</button>
                                        </div>
                                    </div>
                                </template>

                                <template x-if="req.type == 'string'">
                                    <input type="text" :name="'metadata[' + req.code + ']'"
                                        x-model="savedMetadata[req.code]"
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-medium"
                                        placeholder="Enter details">
                                </template>

                                <template x-if="req.type == 'boolean'">
                                    <select :name="'metadata[' + req.code + ']'" x-model="savedMetadata[req.code]"
                                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-medium">
                                        <option value="">Select Option</option>
                                        <option value="Yes">Yes</option>
                                        <option value="No">No</option>
                                    </select>
                                </template>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Advanced Details (Metadata) -->
                <div class="col-span-2 pt-4">
                    <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-indigo-600">settings_applications</span>
                        Standard Info
                    </h3>
                    <div
                        class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6 bg-slate-50/50 rounded-2xl border border-slate-100">
                        <div>
                            <label
                                class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Student-Faculty
                                Ratio</label>
                            <input type="text" name="metadata[ratio]" x-model="savedMetadata.ratio"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-medium"
                                placeholder="e.g. 15:1">
                        </div>
                        <div>
                            <label
                                class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">University
                                Map URL</label>
                            <input type="url" name="metadata[map_url]" x-model="savedMetadata.map_url"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-medium"
                                placeholder="Google Maps Embed Link">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Living
                                Expenses (Est.)</label>
                            <input type="text" name="metadata[living_expenses]" x-model="savedMetadata.living_expenses"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-medium"
                                placeholder="e.g. $1,200/month">
                        </div>
                        <div class="md:col-span-2">
                            <div class="flex items-center justify-between mb-2">
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest">About
                                    (Short)</label>
                                <button type="button" @click="generateAiAbout()" id="aiBtn"
                                    class="flex items-center gap-1.5 text-[11px] font-bold text-indigo-600 hover:text-indigo-700 transition-colors bg-indigo-50 px-2 py-1 rounded-lg">
                                    <span class="material-symbols-outlined text-sm">auto_awesome</span>
                                    Generate with AI
                                </button>
                            </div>
                            <textarea name="metadata[about]" id="aboutField" rows="2" x-model="savedMetadata.about"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-medium"
                                placeholder="Brief tagline or description"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-10 py-8 bg-slate-50 border-t border-slate-100 flex justify-end">
                <button type="submit"
                    class="px-12 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-2xl shadow-xl shadow-indigo-100 transition-all transform hover:-translate-y-1 active:scale-95">
                    Save University Details
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Initialize Select2
    $(document).ready(function () {
        $('#stateSelect').select2({
            placeholder: 'Search State...',
            allowClear: true,
            width: '100%'
        });
    });

    function universityForm() {
        return {
            countryId: '',
            requirements: [],
            countryInfo: null,
            savedMetadata: {},
            loading: false,
            stemAvailable: true,
            init() {
                this.$nextTick(() => {
                    this.fetchRequirements();
                });
            },
            async fetchRequirements() {
                if (!this.countryId) {
                    this.requirements = [];
                    this.countryInfo = null;
                    return;
                }
                this.loading = true;
                try {
                    let formData = new FormData();
                    formData.append('country_id', this.countryId);
                    formData.append('target_type', 'University');
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                    formData.append('<?= csrf_token() ?>', csrfToken);

                    const response = await fetch('<?= base_url('admin/requirements/get-requirements') ?>', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    const data = await response.json();
                    this.requirements = data.results || [];
                    this.countryInfo = data.country || null;
                } catch (e) {
                    console.error('Failed to fetch requirements', e);
                }
                this.loading = false;
            },
            async discoverUniversity() {
                const name = document.getElementById('uniName').value;
                const btn = document.getElementById('discoverBtn');

                if (!name) {
                    alert('Please enter university name first');
                    return;
                }

                btn.disabled = true;
                btn.innerHTML = '<span class="material-symbols-outlined text-sm animate-spin">sync</span> Discovering...';

                const csrfName = '<?= csrf_token() ?>';
                const csrfHash = document.querySelector(`input[name="${csrfName}"]`).value;

                try {
                    const response = await fetch('<?= base_url('admin/universities/generate-details') ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfHash
                        },
                        body: JSON.stringify({ name: name, country_id: this.countryId })
                    });
                    const data = await response.json();

                    if (data.csrf_token) {
                        document.querySelector(`input[name="${csrfName}"]`).value = data.csrf_token;
                    }
                    if (data.error) {
                        alert(data.error);
                        return;
                    }

                    // Populate direct fields
                    if (data.website) document.querySelector('input[name="website"]').value = data.website;
                    if (data.ranking) document.querySelector('input[name="ranking"]').value = data.ranking;
                    if (data.tuition_min) document.querySelector('input[name="tuition_fee_min"]').value = data.tuition_min;
                    if (data.tuition_max) document.querySelector('input[name="tuition_fee_max"]').value = data.tuition_max;
                    if (data.type) document.querySelector('select[name="type"]').value = data.type.toLowerCase();

                    // Update savedMetadata for metadata fields
                    this.savedMetadata = {
                        ...this.savedMetadata,
                        ratio: data.ratio || this.savedMetadata.ratio,
                        map_url: data.map_url || this.savedMetadata.map_url,
                        about: data.about || this.savedMetadata.about,
                        living_expenses: data.living_expenses || this.savedMetadata.living_expenses,
                        ...(data.requirements || {})
                    };

                    // Select Country
                    if (data.country) {
                        const countrySelect = document.querySelector('select[name="country_id"]');
                        Array.from(countrySelect.options).forEach(opt => {
                            if (opt.text.toLowerCase().includes(data.country.toLowerCase())) {
                                this.countryId = opt.value;
                                this.$nextTick(() => {
                                    this.fetchRequirements();
                                });
                            }
                        });
                    }

                    // Select State
                    if (data.state) {
                        const stateSelect = $('#stateSelect');
                        stateSelect.find('option').each(function () {
                            if ($(this).text().toLowerCase().includes(data.state.toLowerCase())) {
                                stateSelect.val($(this).val()).trigger('change');
                                return false;
                            }
                        });
                    }
                } catch (err) {
                    console.error(err);
                    alert('Discovery failed');
                } finally {
                    btn.disabled = false;
                    btn.innerHTML = '<span class="material-symbols-outlined text-sm">auto_awesome</span> Autofill with AI';
                }
            },
            async generateAiAbout() {
                const name = document.getElementById('uniName').value;
                const btn = document.getElementById('aiBtn');

                if (!name) {
                    alert('Please enter university name first');
                    return;
                }

                btn.disabled = true;
                btn.innerHTML = '<span class="material-symbols-outlined text-sm animate-spin">sync</span> Generating...';

                const csrfName = '<?= csrf_token() ?>';
                const csrfHash = document.querySelector(`input[name="${csrfName}"]`).value;

                try {
                    const response = await fetch('<?= base_url('admin/universities/generate-details') ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfHash
                        },
                        body: JSON.stringify({ name: name })
                    });
                    const data = await response.json();
                    if (data.csrf_token) {
                        document.querySelector(`input[name="${csrfName}"]`).value = data.csrf_token;
                    }
                    if (data.about) {
                        this.savedMetadata.about = data.about;
                    } else if (data.error) {
                        alert(data.error);
                    }
                } catch (err) {
                    alert('AI Generation failed');
                } finally {
                    btn.disabled = false;
                    btn.innerHTML = '<span class="material-symbols-outlined text-sm">auto_awesome</span> Generate with AI';
                }
            }
        }
    }

    // Image Uploader Logic
    function imageUploader() {
        return {
            isDragging: false,
            previews: [],
            handleDrop(e) {
                this.isDragging = false;
                const files = e.dataTransfer.files;
                this.handleFiles(files);
            },
            handleFiles(files) {
                const arr = Array.from(files);
                arr.forEach(file => {
                    if (!file.type.startsWith('image/')) return;
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.previews.push({
                            url: e.target.result,
                            file: file
                        });
                        this.syncFileInput();
                    };
                    reader.readAsDataURL(file);
                });
            },
            removeImage(index) {
                this.previews.splice(index, 1);
                this.syncFileInput();
            },
            syncFileInput() {
                const dataTransfer = new DataTransfer();
                this.previews.forEach(p => {
                    if (p.file instanceof File) {
                        dataTransfer.items.add(p.file);
                    }
                });
                document.getElementById('uniImages').files = dataTransfer.files;
            },
            async scrapeImages() {
                const name = document.getElementById('uniName').value;
                const btn = document.getElementById('scrapeBtn');

                if (!name) {
                    alert('Please enter university name first');
                    return;
                }

                btn.disabled = true;
                btn.innerHTML = '<span class="material-symbols-outlined text-sm animate-spin">sync</span> Scraping...';

                const csrfName = '<?= csrf_token() ?>';
                const csrfHash = document.querySelector(`input[name="${csrfName}"]`).value;

                try {
                    const response = await fetch('<?= base_url('admin/universities/scrape-images') ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: new URLSearchParams({
                            'name': name,
                            [csrfName]: csrfHash
                        })
                    });
                    const data = await response.json();

                    if (data.csrf_token) {
                        document.querySelector(`input[name="${csrfName}"]`).value = data.csrf_token;
                    }

                    if (data.images && data.images.length > 0) {
                        for (const img of data.images) {
                            try {
                                const res = await fetch(img.url);
                                if (!res.ok) continue;
                                const blob = await res.blob();
                                const file = new File([blob], img.fileName, { type: blob.type });
                                this.previews.push({
                                    url: img.url,
                                    file: file
                                });
                            } catch (err) {
                                console.error('Failed to fetch individual image', err);
                            }
                        }
                        this.syncFileInput();
                    } else if (data.error) {
                        alert(data.error);
                    } else {
                        alert('No images found');
                    }
                } catch (e) {
                    console.error(e);
                    alert('Scraping failed');
                } finally {
                    btn.disabled = false;
                    btn.innerHTML = '<span class="material-symbols-outlined text-sm">public</span> Scrape from Web';
                }
            }
        }
    }


</script>

<style>
    [x-cloak] {
        display: none !important;
    }

    .select2-container--default .select2-selection--single {
        border-radius: 0.75rem;
        height: 52px;
        padding: 10px 16px;
        border-color: #e2e8f0;
        font-weight: 500;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 50px;
    }
</style>
<?= $this->endSection() ?>