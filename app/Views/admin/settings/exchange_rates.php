<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Header Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <div>
                <h2 class="text-xl font-bold text-slate-800">Exchange Rates</h2>
                <p class="text-sm text-slate-500 font-medium mt-1">Relative to 1 USD base currency</p>
            </div>
            <button onclick="openModal('rateModal')"
                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition-all shadow-lg shadow-indigo-100 flex items-center gap-2">
                <span class="material-symbols-outlined text-sm">currency_exchange</span> Add/Update
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="px-8 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Currency
                        </th>
                        <th class="px-8 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest">Rate (1 USD
                            =)</th>
                        <th class="px-8 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest text-right">
                            Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php foreach ($rates as $rate): ?>
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-8 py-4 text-sm font-bold text-slate-700 uppercase tracking-widest">
                                <?= $rate['currency'] ?>
                            </td>
                            <td class="px-8 py-4 text-sm font-mono font-bold text-indigo-600"><?= $rate['rate_to_usd'] ?>
                            </td>
                            <td class="px-8 py-4 text-right">
                                <a href="<?= base_url('admin/exchange-rates/delete/' . $rate['currency']) ?>"
                                    class="p-2 text-rose-500 hover:bg-rose-50 rounded-lg transition-all inline-flex opacity-0 group-hover:opacity-100">
                                    <span class="material-symbols-outlined text-[20px]">delete</span>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Rate -->
<div id="rateModal" class="modal-overlay items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-sm modal-content-tw overflow-hidden shadow-2xl">
        <form action="<?= base_url('admin/exchange-rates/store') ?>" method="POST">
            <?= csrf_field() ?>
            <?= honeypot_field() ?>
            <div class="px-8 py-6 bg-slate-50 border-b border-slate-100 flex justify-between items-center">
                <h3 class="text-xl font-bold text-slate-800">Update Rate</h3>
                <button type="button" onclick="closeModal('rateModal')"
                    class="size-8 rounded-full hover:bg-slate-200 flex items-center justify-center transition-colors">
                    <span class="material-symbols-outlined text-slate-500 text-sm">close</span>
                </button>
            </div>
            <div class="px-8 py-6 space-y-5">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Currency
                        Code</label>
                    <input type="text" name="currency"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-bold uppercase"
                        required placeholder="e.g. INR">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Rate to 1
                        USD</label>
                    <input type="number" step="0.0001" name="rate_to_usd"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-mono font-bold"
                        required placeholder="0.0000">
                    <p class="text-[10px] text-slate-400 mt-2 italic">* Example: 1 USD = 83.50 INR</p>
                </div>
            </div>
            <div class="px-8 py-6 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
                <button type="button" onclick="closeModal('rateModal')"
                    class="px-6 py-2.5 text-slate-500 font-bold text-sm hover:text-slate-800 transition-colors">Cancel</button>
                <button type="submit"
                    class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-indigo-100 transition-all">Save
                    Rate</button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>