<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="space-y-6">
    <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-xl flex items-center gap-3">
            <span class="material-symbols-outlined text-emerald-500">check_circle</span>
            <span class="font-medium"><?= session()->getFlashdata('success') ?></span>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-rose-50 border border-rose-200 text-rose-700 px-6 py-4 rounded-xl flex items-center gap-3">
            <span class="material-symbols-outlined text-rose-500">error</span>
            <span class="font-medium"><?= session()->getFlashdata('error') ?></span>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div
            class="px-6 py-4 border-b border-slate-200 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <h2 class="text-lg font-bold text-slate-900 whitespace-nowrap">Requirement Parameters</h2>

            <div class="flex items-center gap-3 w-full md:w-auto flex-1 justify-end">
                <!-- Search -->
                <div class="relative w-full max-w-sm">
                    <form action="<?= base_url('admin/requirements') ?>" method="GET" class="flex items-center gap-2">
                        <div class="relative flex-1 group">
                            <input type="text" name="q" placeholder="Search parameters..."
                                value="<?= esc($search ?? '') ?>"
                                class="w-full pl-10 pr-10 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all group-hover:bg-white">
                            <span
                                class="material-symbols-outlined absolute left-3 top-2.5 text-slate-400 text-sm group-hover:text-indigo-500 transition-colors">search</span>
                            <?php if ($search): ?>
                                <a href="<?= base_url('admin/requirements') ?>"
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
                </div>

                <button onclick="resetModal(); openModal('paramModal')"
                    class="flex-shrink-0 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium transition-colors inline-flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">add</span> Add Parameter
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50 border-b border-slate-200 uppercase font-semibold text-xs text-slate-500">
                    <tr>
                        <th class="px-6 py-3">Code</th>
                        <th class="px-6 py-3">Label</th>
                        <th class="px-6 py-3">Context</th>
                        <th class="px-6 py-3">Type</th>
                        <th class="px-6 py-3">Tags</th>
                        <th class="px-6 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (empty($parameters)): ?>
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <span
                                    class="material-symbols-outlined text-slate-200 text-5xl block mb-2">rule_folder</span>
                                <p class="text-slate-400">No parameters found.</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($parameters as $param): ?>
                            <?php
                            $contextBadge = 'bg-amber-50 text-amber-600';
                            if ($param['applies_to'] == 'University')
                                $contextBadge = 'bg-indigo-50 text-indigo-600';
                            if ($param['applies_to'] == 'Course')
                                $contextBadge = 'bg-emerald-50 text-emerald-600';
                            ?>
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <span class="font-mono text-indigo-600 font-bold"><?= $param['code'] ?></span>
                                </td>
                                <td class="px-6 py-4 font-semibold text-slate-900"><?= $param['label'] ?></td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-1">
                                        <span class="text-xs font-medium text-slate-500">
                                            <?= $param['country_name'] ?? 'Global' ?>
                                        </span>
                                        <span
                                            class="text-[10px] px-1.5 py-0.5 rounded-md w-fit font-bold uppercase <?= $contextBadge ?>">
                                            <?= $param['applies_to'] ?>
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 uppercase text-[11px] font-bold text-slate-400">
                                    <?= $param['type'] ?>
                                </td>
                                <td class="px-6 py-4 text-xs">
                                    <div class="flex flex-wrap gap-1">
                                        <?php if ($param['category_tags']): ?>
                                            <?php foreach (explode(',', $param['category_tags']) as $tag): ?>
                                                <span
                                                    class="px-1.5 py-0.5 bg-slate-100 text-slate-500 rounded text-[9px] font-bold uppercase"><?= trim($tag) ?></span>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <span class="text-slate-300 italic">None</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button
                                            onclick='openEditModal(<?= json_encode($param, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>)'
                                            class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all inline-flex"
                                            title="Edit">
                                            <span class="material-symbols-outlined text-[20px]">edit</span>
                                        </button>
                                        <a href="<?= base_url('admin/requirements/delete-param/' . $param['id']) ?>"
                                            onclick="return confirm('Delete this parameter?')"
                                            class="p-2 text-rose-500 hover:bg-rose-50 rounded-lg transition-all inline-flex"
                                            title="Delete">
                                            <span class="material-symbols-outlined text-[20px]">delete</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if ($pager->getPageCount() > 1): ?>
            <div class="px-6 py-4 bg-slate-50 border-t border-slate-200">
                <?= $pager->links('default', 'tailwind_full') ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal Parameter -->
<div id="paramModal" class="modal-overlay items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-md modal-content-tw overflow-hidden shadow-2xl">
        <form id="paramForm" action="<?= base_url('admin/requirements/store-param') ?>" method="POST">
            <?= csrf_field() ?>
            <?= honeypot_field() ?>
            <input type="hidden" name="id" id="paramId">
            <div class="px-8 py-6 bg-slate-50 border-b border-slate-100 flex justify-between items-center">
                <h3 class="text-xl font-bold text-slate-800" id="modalTitle">Add Parameter</h3>
                <button type="button" onclick="closeModal('paramModal')"
                    class="size-8 rounded-full hover:bg-slate-200 flex items-center justify-center transition-colors">
                    <span class="material-symbols-outlined text-slate-500 text-sm">close</span>
                </button>
            </div>
            <div class="px-8 py-6 space-y-5">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Code (No
                        spaces)</label>
                    <input type="text" name="code" id="paramCode"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-mono font-medium"
                        required placeholder="e.g. gmat_score">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Display
                        Label</label>
                    <input type="text" name="label" id="paramLabel"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-medium"
                        required placeholder="e.g. Minimum GMAT Score">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Country
                            Context</label>
                        <select name="country_id" id="paramCountryId"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-medium">
                            <option value="">Apply Globally</option>
                            <?php foreach ($countries as $country): ?>
                                <option value="<?= $country['id'] ?>"><?= $country['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Visible
                            On</label>
                        <select name="applies_to" id="paramAppliesTo"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-medium"
                            required>
                            <option value="Both">Both</option>
                            <option value="University">University Only</option>
                            <option value="Course">Course Only</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Input
                        Type</label>
                    <select name="type" id="paramType"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-medium"
                        required>
                        <option value="number">Number</option>
                        <option value="boolean">Boolean (Yes/No)</option>
                        <option value="string">String (Text)</option>
                        <option value="range">Range (Min-Max)</option>
                        <option value="list">List (Comma separated)</option>
                    </select>
                </div>
                <div>
                    <label
                        class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2 flex justify-between">
                        <span>Category Tags</span>
                        <span class="text-[10px] normal-case text-slate-400">Comma separated</span>
                    </label>
                    <input type="text" name="category_tags" id="paramTags"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-medium mb-2"
                        placeholder="e.g. Masters, STEM, General">
                    <div class="flex flex-wrap gap-2">
                        <?php foreach (['General', 'International', 'USA', 'UK', 'Canada', 'Australia', 'Ireland', 'Masters', 'Bachelors', 'STEM'] as $t): ?>
                            <button type="button" onclick="addTag('<?= $t ?>')"
                                class="px-2 py-1 bg-slate-100 hover:bg-slate-200 text-slate-500 text-[10px] font-bold rounded-lg transition-colors uppercase"><?= $t ?></button>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <div class="px-8 py-6 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
                <button type="button" onclick="closeModal('paramModal')"
                    class="px-6 py-2.5 text-slate-500 font-bold text-sm hover:text-slate-800 transition-colors">Cancel</button>
                <button type="submit" id="submitBtn"
                    class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-indigo-100 transition-all">Create
                    Parameter</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(data) {
        document.getElementById('modalTitle').innerText = 'Edit Parameter';
        document.getElementById('paramForm').action = '<?= base_url('admin/requirements/update-param') ?>';
        document.getElementById('submitBtn').innerText = 'Update Parameter';

        document.getElementById('paramId').value = data.id;
        document.getElementById('paramCode').value = data.code;
        document.getElementById('paramLabel').value = data.label;
        document.getElementById('paramCountryId').value = data.country_id || '';
        document.getElementById('paramAppliesTo').value = data.applies_to;
        document.getElementById('paramType').value = data.type;
        document.getElementById('paramTags').value = data.category_tags;

        openModal('paramModal');
    }

    function resetModal() {
        document.getElementById('modalTitle').innerText = 'Add Parameter';
        document.getElementById('paramForm').action = '<?= base_url('admin/requirements/store-param') ?>';
        document.getElementById('submitBtn').innerText = 'Create Parameter';

        document.getElementById('paramId').value = '';
        document.getElementById('paramCode').value = '';
        document.getElementById('paramLabel').value = '';
        document.getElementById('paramCountryId').value = '';
        document.getElementById('paramAppliesTo').value = 'Both';
        document.getElementById('paramType').value = 'number';
        document.getElementById('paramTags').value = '';
    }

    function addTag(tag) {
        const input = document.getElementById('paramTags');
        let currentTags = input.value.split(',').map(t => t.trim()).filter(t => t !== '');
        if (!currentTags.includes(tag)) {
            currentTags.push(tag);
            input.value = currentTags.join(', ');
        }
    }
</script>

<?= $this->endSection() ?>