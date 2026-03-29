<?= view('web/include/header', ['title' => $title]) ?>

<div class="flex min-h-screen bg-gray-50 dark:bg-background-dark">
    <!-- Sidebar (Same as dashboard) -->
    <?= view('agent/include/sidebar') ?>

    <main class="flex-1 p-6 md:p-10">
        <div class="max-w-6xl mx-auto">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold dark:text-white mb-2">My Ads</h1>
                    <p class="text-gray-500">Manage and track your advertisements.</p>
                </div>
                <a href="<?= base_url('agent/ads/create') ?>" class="btn-primary flex items-center gap-2">
                    <span class="material-symbols-outlined">add</span> Create New Ad
                </a>
            </div>

            <div
                class="bg-white dark:bg-card-dark rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 dark:bg-gray-800/50 border-b border-gray-100 dark:border-gray-800">
                        <tr>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Ad Info</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Placement</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase text-center">Stats</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-500 uppercase text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        <?php foreach ($ads as $ad): ?>
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="font-bold dark:text-white">
                                        <?= esc($ad['title']) ?>
                                    </div>
                                    <div class="text-xs text-gray-500 uppercase">
                                        <?= esc($ad['format']) ?>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 bg-gray-100 dark:bg-gray-800 rounded text-xs">
                                        <?= esc($ad['placement']) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <?php if ($ad['status'] === 'active'): ?>
                                        <span
                                            class="px-2 py-1 bg-green-50 text-green-600 rounded-full text-[10px] font-bold uppercase">Active</span>
                                    <?php elseif ($ad['status'] === 'pending_payment'): ?>
                                        <a href="<?= base_url('agent/ads/pay/' . $ad['tracking_id']) ?>"
                                            class="px-2 py-1 bg-orange-50 text-orange-600 rounded-full text-[10px] font-bold uppercase hover:bg-orange-100 transition-colors">Pending
                                            Payment</a>
                                    <?php else: ?>
                                        <span
                                            class="px-2 py-1 bg-gray-100 text-gray-600 rounded-full text-[10px] font-bold uppercase">
                                            <?= $ad['status'] ?>
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex justify-center gap-4 text-xs">
                                        <div><span class="block font-bold dark:text-white">
                                                <?= number_format($ad['impressions']) ?>
                                            </span><span class="text-gray-400">Views</span></div>
                                        <div><span class="block font-bold dark:text-white">
                                                <?= number_format($ad['clicks']) ?>
                                            </span><span class="text-gray-400">Clicks</span></div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="<?= base_url('agent/reports?ad_id=' . $ad['tracking_id']) ?>"
                                        class="p-2 text-gray-400 hover:text-primary transition-colors inline-block"
                                        title="Report">
                                        <span class="material-symbols-outlined text-xl">analytics</span>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($ads)): ?>
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">No ads found. Start by creating
                                    your first ad.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                <?= $pager->links('default', 'tailwind_full') ?>
            </div>
        </div>
    </main>
</div>

<?= view('web/include/footer') ?>