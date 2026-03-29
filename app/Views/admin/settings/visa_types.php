<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <div>
                <h2 class="text-xl font-bold text-slate-800">Visa Types</h2>
                <p class="text-sm text-slate-500 font-medium mt-1">Manage standard visa categories per country</p>
            </div>
            <button onclick="openModal('visaModal')"
                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition-all shadow-lg shadow-indigo-100 flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">assignment_ind</span> Add Visa Type
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-8 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Country
                        </th>
                        <th class="px-8 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Visa
                            Designation</th>
                        <th class="px-8 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest text-right">
                            Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php if (empty($visas)): ?>
                        <tr>
                            <td colspan="3" class="px-8 py-12 text-center text-slate-400">No visa types found.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($visas as $visa): ?>
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="px-8 py-4 text-sm font-bold text-slate-700"><?= $visa['country_name'] ?></td>
                                <td class="px-8 py-4 text-sm font-medium text-indigo-600"><?= $visa['name'] ?></td>
                                <td class="px-8 py-4 text-right">
                                    <a href="<?= base_url('admin/visa-types/delete/' . $visa['id']) ?>"
                                        class="p-2 text-rose-500 hover:bg-rose-50 rounded-lg transition-all inline-flex opacity-0 group-hover:opacity-100">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if ($pager->getPageCount() > 1): ?>
            <div class="px-8 py-6 bg-slate-50/50 border-t border-slate-100">
                <?= $pager->links('default', 'tailwind_full') ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modal Visa -->
<div id="visaModal" class="modal-overlay items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-md modal-content-tw overflow-hidden shadow-2xl">
        <form action="<?= base_url('admin/visa-types/store') ?>" method="POST">
            <?= csrf_field() ?>
            <?= honeypot_field() ?>
            <div class="px-8 py-6 bg-slate-50 border-b border-slate-100 flex justify-between items-center">
                <h3 class="text-xl font-bold text-slate-800">Add Visa Type</h3>
                <button type="button" onclick="closeModal('visaModal')"
                    class="size-8 rounded-full hover:bg-slate-200 flex items-center justify-center transition-colors">
                    <span class="material-symbols-outlined text-slate-500 text-sm">close</span>
                </button>
            </div>
            <div class="px-8 py-6 space-y-5">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Select
                        Country</label>
                    <select name="country_id"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-medium"
                        required>
                        <?php foreach ($countries as $country): ?>
                            <option value="<?= $country['id'] ?>"><?= $country['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Visa
                        Name</label>
                    <input type="text" name="name"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-medium"
                        required placeholder="e.g. Student Visa F-1">
                </div>
            </div>
            <div class="px-8 py-6 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
                <button type="button" onclick="closeModal('visaModal')"
                    class="px-6 py-2.5 text-slate-500 font-bold text-sm hover:text-slate-800 transition-colors">Cancel</button>
                <button type="submit"
                    class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-indigo-100 transition-all">Save
                    Visa Type</button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>