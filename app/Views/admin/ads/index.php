<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Ads Management</h1>
    <a href="<?= base_url('admin/ads/create') ?>"
        class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
        Create New Ad
    </a>
</div>

<?php if (session()->getFlashdata('message')): ?>
    <div class="bg-green-100 text-green-700 p-4 rounded-lg mb-6">
        <?= session()->getFlashdata('message') ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-6">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-200 flex justify-between items-center">
        <h2 class="text-lg font-bold text-slate-900">Active Campaigns</h2>
        <div class="flex items-center gap-3">
            <form action="<?= base_url('admin/ads') ?>" method="GET" class="flex items-center gap-2">
                <div class="relative group">
                    <input type="text" name="search" value="<?= esc($search ?? '') ?>" placeholder="Search ads..."
                        class="pl-10 pr-10 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all w-64 group-hover:bg-white">
                    <span
                        class="material-symbols-outlined absolute left-3 top-2.5 text-slate-400 text-sm group-hover:text-indigo-500 transition-colors">search</span>
                    <?php if (!empty($search)): ?>
                        <a href="<?= base_url('admin/ads') ?>"
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
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-600">
            <thead class="bg-slate-50 border-b border-slate-200 uppercase font-semibold text-xs text-slate-500">
                <tr>
                    <th class="px-6 py-3">Title</th>
                    <th class="px-6 py-3">Source</th>
                    <th class="px-6 py-3">Advertiser</th>
                    <th class="px-6 py-3">Format</th>
                    <th class="px-6 py-3">Placement</th>
                    <th class="px-6 py-3">Performance</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php foreach ($ads as $ad): ?>
                    <tr class="hover:bg-slate-50/50">
                        <td class="px-6 py-4 font-medium text-slate-900">
                            <?= esc($ad['title']) ?>
                        </td>
                        <td class="px-6 py-4">
                            <?php if ($ad['source_type'] === 'network'): ?>
                                <span
                                    class="inline-flex items-center gap-1 text-xs font-semibold px-2 py-1 bg-blue-50 text-blue-600 rounded">
                                    <span class="material-symbols-outlined text-[14px]">public</span> Network
                                </span>
                            <?php else: ?>
                                <span
                                    class="inline-flex items-center gap-1 text-xs font-semibold px-2 py-1 bg-purple-50 text-purple-600 rounded">
                                    <span class="material-symbols-outlined text-[14px]">campaign</span> Direct
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-xs font-semibold text-slate-800 uppercase mb-1">
                                <span class="material-symbols-outlined text-[12px] align-middle mr-1">person</span>
                                <?= esc($ad['posted_by'] ?? 'Admin') ?>
                            </div>
                            <?php if (($ad['price_paid'] ?? 0) > 0): ?>
                                <span
                                    class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-0.5 bg-emerald-50 text-emerald-600 rounded border border-emerald-100">
                                    <span class="material-symbols-outlined text-[12px]">payments</span> Paid
                                    ($<?= number_format($ad['price_paid'], 2) ?>)
                                </span>
                            <?php else: ?>
                                <span
                                    class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-0.5 bg-slate-100 text-slate-600 rounded border border-slate-200">
                                    <span class="material-symbols-outlined text-[12px]">money_off</span> Free/Organic
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 bg-slate-50">
                            <span class="uppercase text-xs tracking-wide">
                                <?= esc($ad['format']) ?>
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <?= esc($ad['placement']) ?>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col text-xs">
                                <span><strong class="text-slate-800">
                                        <?= number_format($ad['impressions']) ?>
                                    </strong> Impr.</span>
                                <span><strong class="text-slate-800">
                                        <?= number_format($ad['clicks']) ?>
                                    </strong> Clicks</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span
                                class="px-2 py-1 <?= $ad['status'] == 'active' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' ?> rounded text-xs font-medium uppercase">
                                <?= $ad['status'] ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="<?= base_url('admin/ads/toggle-pause/' . $ad['id']) ?>"
                                    title="<?= $ad['status'] === 'active' ? 'Pause Ad' : 'Resume Ad' ?>"
                                    class="p-2 text-slate-400 hover:text-<?= $ad['status'] === 'active' ? 'amber' : 'green' ?>-600 transition-colors">
                                    <span
                                        class="material-symbols-outlined text-[20px]"><?= $ad['status'] === 'active' ? 'pause_circle' : 'play_circle' ?></span>
                                </a>
                                <a href="<?= base_url('admin/ads/edit/' . $ad['id']) ?>"
                                    class="p-2 text-slate-400 hover:text-indigo-600 transition-colors">
                                    <span class="material-symbols-outlined text-[20px]">edit</span>
                                </a>
                                <a href="<?= base_url('admin/ads/delete/' . $ad['id']) ?>"
                                    onclick="return confirm('Are you sure? This cannot be undone.');"
                                    class="p-2 text-slate-400 hover:text-red-600 transition-colors">
                                    <span class="material-symbols-outlined text-[20px]">delete</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($ads)): ?>
                    <tr>
                        <td colspan="8" class="px-6 py-8 text-center text-slate-400">
                            No ads created yet.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <!-- Pagination -->
    <?php if ($pager->getPageCount() > 1): ?>
        <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-200">
            <?= $pager->links('default', 'tailwind_full') ?>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>