<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <p class="text-xs font-bold text-gray-400 uppercase mb-1">Total Revenue</p>
        <h3 class="text-3xl font-black text-emerald-600">₹<?= number_format($stats['revenue'], 2) ?></h3>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <p class="text-xs font-bold text-gray-400 uppercase mb-1">Paid Transactions</p>
        <h3 class="text-3xl font-black text-gray-800"><?= $stats['paid'] ?></h3>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
        <p class="text-xs font-bold text-gray-400 uppercase mb-1">Waived Sessions</p>
        <h3 class="text-3xl font-black text-blue-600"><?= $stats['waived'] ?></h3>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
    <div class="px-6 py-4 border-b border-gray-100 flex flex-wrap items-center justify-between gap-4">
        <h2 class="text-lg font-bold text-gray-800">Transaction Logs</h2>
        <form action="<?= base_url('admin/payments') ?>" method="GET" class="flex flex-wrap items-center gap-3">
            <!-- Search -->
            <div class="flex items-center gap-2">
                <div class="relative group">
                    <input type="text" name="search" value="<?= esc($search ?? '') ?>" placeholder="Search user, ID..."
                        class="pl-10 pr-10 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all w-64 group-hover:bg-white">
                    <span
                        class="material-symbols-outlined absolute left-3 top-2.5 text-gray-400 text-sm group-hover:text-indigo-500 transition-colors">search</span>
                    <?php if ($search): ?>
                        <a href="<?= base_url('admin/payments') ?>"
                            class="absolute right-3 top-2.5 text-gray-400 hover:text-rose-500 transition-colors">
                            <span class="material-symbols-outlined text-sm">close</span>
                        </a>
                    <?php endif; ?>
                </div>
                <button type="submit"
                    class="px-4 py-2 bg-slate-800 text-white text-sm font-semibold rounded-xl hover:bg-slate-900 transition-all shadow-sm">
                    Search
                </button>
            </div>

            <!-- Service Filter -->
            <select name="tool_id" onchange="this.form.submit()"
                class="px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                <option value="">All Services</option>
                <?php foreach ($tools as $tool): ?>
                    <option value="<?= $tool['id'] ?>" <?= ($currentToolId == $tool['id']) ? 'selected' : '' ?>>
                        <?= esc($tool['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <!-- Status Filter -->
            <select name="status" onchange="this.form.submit()"
                class="px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                <option value="">All Statuses</option>
                <option value="paid" <?= ($currentStatus == 'paid') ? 'selected' : '' ?>>Paid</option>
                <option value="waived" <?= ($currentStatus == 'waived') ? 'selected' : '' ?>>Waived</option>
                <option value="free" <?= ($currentStatus == 'free') ? 'selected' : '' ?>>Free</option>
            </select>

            <?php if ($search || $currentStatus || $currentToolId): ?>
                <a href="<?= base_url('admin/payments') ?>"
                    class="px-4 py-2 bg-rose-50 text-rose-600 rounded-xl text-sm font-bold hover:bg-rose-100 transition-all flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">close</span> Clear
                </a>
            <?php endif; ?>
        </form>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-4 font-bold text-gray-600">User</th>
                    <th class="px-6 py-4 font-bold text-gray-600">Service</th>
                    <th class="px-6 py-4 font-bold text-gray-600">Amount</th>
                    <th class="px-6 py-4 font-bold text-gray-600">Status</th>
                    <th class="px-6 py-4 font-bold text-gray-600">Transaction ID</th>
                    <th class="px-6 py-4 font-bold text-gray-600 text-right">Date</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <?php if (empty($payments)): ?>
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-gray-400">No payment records found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($payments as $payment): ?>
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-bold text-gray-800"><?= esc($payment['user_name'] ?: 'Guest') ?></div>
                                <div class="text-xs text-gray-500"><?= esc($payment['user_email'] ?: 'N/A') ?></div>
                            </td>
                            <td class="px-6 py-4 text-gray-700">
                                <div class="font-medium"><?= esc($payment['tool_name']) ?></div>
                                <?php if ($payment['coupon_code']): ?>
                                    <div class="text-[10px] text-primary font-bold">COUPON: <?= esc($payment['coupon_code']) ?>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 font-black text-gray-900">
                                ₹<?= number_format($payment['final_amount'], 2) ?>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 rounded text-[10px] font-bold uppercase
                                    <?php
                                    switch ($payment['payment_status']) {
                                        case 'paid':
                                            echo 'bg-green-100 text-green-600';
                                            break;
                                        case 'waived':
                                            echo 'bg-blue-100 text-blue-600';
                                            break;
                                        case 'free':
                                            echo 'bg-gray-100 text-gray-600';
                                            break;
                                        default:
                                            echo 'bg-amber-100 text-amber-600';
                                    }
                                    ?>">
                                    <?= $payment['payment_status'] ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 font-mono text-xs text-gray-400">
                                <?= $payment['razorpay_payment_id'] ?: $payment['razorpay_order_id'] ?: 'N/A' ?>
                            </td>
                            <td class="px-6 py-4 text-right text-gray-500">
                                <?= date('M d, Y H:i', strtotime($payment['created_at'])) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if ($pager->getPageCount() > 1): ?>
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
            <?= $pager->links('default', 'tailwind_full') ?>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>