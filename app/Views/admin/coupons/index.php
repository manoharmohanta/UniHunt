<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="max-w-7xl mx-auto">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-3xl font-bold text-slate-800 tracking-tight">Coupons</h2>
            <p class="text-slate-500 mt-1">Manage discount codes and promotions.</p>
        </div>
        <a href="<?= base_url('admin/coupons/new') ?>"
            class="flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors font-medium">
            <span class="material-symbols-outlined text-[20px]">add</span>
            Create Coupon
        </a>
    </div>

    <?php if (session()->has('message')): ?>
        <div
            class="mb-6 bg-emerald-50 text-emerald-700 px-4 py-3 rounded-lg border border-emerald-200 flex items-center gap-2">
            <span class="material-symbols-outlined">check_circle</span>
            <?= session('message') ?>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-slate-200 flex justify-between items-center gap-4">
            <h2 class="text-lg font-bold text-slate-900 whitespace-nowrap">Active Coupons</h2>
            <div class="flex items-center gap-3">
                <form action="<?= base_url('admin/coupons') ?>" method="GET" class="flex items-center gap-2">
                    <div class="relative group">
                        <input type="text" name="search" value="<?= esc($search ?? '') ?>"
                            placeholder="Search coupons..."
                            class="pl-10 pr-10 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all w-64 group-hover:bg-white">
                        <span
                            class="material-symbols-outlined absolute left-3 top-2.5 text-slate-400 text-sm group-hover:text-indigo-500 transition-colors">search</span>
                        <?php if (!empty($search)): ?>
                            <a href="<?= base_url('admin/coupons') ?>"
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
            <?php if (empty($coupons)): ?>
                <div class="p-12 text-center">
                    <div
                        class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-400">
                        <span class="material-symbols-outlined text-[32px]">local_activity</span>
                    </div>
                    <h3 class="text-lg font-medium text-slate-900 mb-1">No coupons found</h3>
                    <p class="text-slate-500">Create your first coupon code to get started.</p>
                </div>
            <?php else: ?>
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Code
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                Discount</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Status
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Usage
                            </th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">
                                Validity</th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        <?php foreach ($coupons as $coupon): ?>
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span
                                            class="font-mono font-bold text-indigo-600 bg-indigo-50 px-2 py-1 rounded border border-indigo-100">
                                            <?= esc($coupon['code']) ?>
                                        </span>
                                    </div>
                                    <div class="text-xs text-slate-500 mt-1">
                                        <?= esc($coupon['description'] ?: 'No description') ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-medium text-slate-900">
                                        <?= $coupon['discount_type'] === 'percentage' ? esc($coupon['discount_value']) . '%' : '$' . esc($coupon['discount_value']) ?>
                                    </span>
                                    <?php if ($coupon['discount_type'] === 'percentage' && $coupon['max_discount_amount']): ?>
                                        <div class="text-xs text-slate-500">Max $
                                            <?= esc($coupon['max_discount_amount']) ?>
                                        </div>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php
                                    $isActive = $coupon['status'] === 'active';
                                    $isExpired = $coupon['expires_at'] && strtotime($coupon['expires_at']) < time();
                                    $statusClass = $isExpired ? 'bg-red-100 text-red-700' : ($isActive ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-700');
                                    $statusText = $isExpired ? 'Expired' : ucfirst($coupon['status']);
                                    ?>
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $statusClass ?>">
                                        <?= $statusText ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                                    <?= esc($coupon['usage_count']) ?> /
                                    <?= $coupon['usage_limit'] ? esc($coupon['usage_limit']) : '∞' ?>
                                    <div class="text-xs text-slate-400">Limit per user:
                                        <?= $coupon['usage_limit_per_user'] ? esc($coupon['usage_limit_per_user']) : '∞' ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                    <?php if ($coupon['expires_at']): ?>
                                        <?= date('M j, Y', strtotime($coupon['expires_at'])) ?>
                                    <?php else: ?>
                                        <span class="text-slate-400">No expiry</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="<?= base_url('admin/coupons/delete/' . $coupon['id']) ?>"
                                        class="text-red-600 hover:text-red-900 ml-3"
                                        onclick="return confirm('Are you sure you want to delete this coupon? This cannot be undone.')">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
        <!-- Pagination -->
        <?php if ($pager->getPageCount() > 1): ?>
            <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-200">
                <?= $pager->links('default', 'tailwind_full') ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>