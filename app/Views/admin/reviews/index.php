<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div class="flex items-center gap-4">
        <a href="<?= base_url('admin/reviews') ?>"
            class="px-4 py-2 rounded-lg text-sm font-bold transition-all <?= !$currentStatus ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' ?>">All
            Reviews</a>
        <a href="<?= base_url('admin/reviews?status=pending') ?>"
            class="px-4 py-2 rounded-lg text-sm font-bold transition-all <?= $currentStatus == 'pending' ? 'bg-amber-500 text-white shadow-lg shadow-amber-200' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' ?>">Pending</a>
        <a href="<?= base_url('admin/reviews?status=approved') ?>"
            class="px-4 py-2 rounded-lg text-sm font-bold transition-all <?= $currentStatus == 'approved' ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-200' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' ?>">Approved</a>
        <a href="<?= base_url('admin/reviews?status=rejected') ?>"
            class="px-4 py-2 rounded-lg text-sm font-bold transition-all <?= $currentStatus == 'rejected' ? 'bg-red-500 text-white shadow-lg shadow-red-200' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' ?>">Rejected</a>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/50 border-b border-slate-200">
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Reviewer</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">University</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Rating</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Comment</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Actions
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php if (empty($reviews)): ?>
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-400">No reviews found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($reviews as $review): ?>
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <p class="text-sm font-bold text-slate-800">
                                    <?= esc($review['reviewer_name']) ?>
                                </p>
                                <p class="text-xs text-slate-400">
                                    <?= esc($review['reviewer_designation']) ?>
                                </p>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-slate-600 font-medium">
                                    <?= esc($review['university_name']) ?>
                                </p>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-1">
                                    <span class="text-sm font-bold text-amber-500">
                                        <?= $review['rating'] ?>
                                    </span>
                                    <span
                                        class="material-symbols-outlined text-amber-500 text-sm ring-1 ring-amber-100 rounded-full p-0.5">star</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 max-w-xs">
                                <p class="text-sm text-slate-600 line-clamp-2">
                                    <?= esc($review['comment']) ?>
                                </p>
                                <p class="text-[10px] text-slate-400 mt-1">
                                    <?= date('M d, Y', strtotime($review['created_at'])) ?>
                                </p>
                            </td>
                            <td class="px-6 py-4">
                                <?php
                                $statusClasses = [
                                    'pending' => 'bg-amber-100 text-amber-700',
                                    'approved' => 'bg-emerald-100 text-emerald-700',
                                    'rejected' => 'bg-red-100 text-red-700'
                                ];
                                ?>
                                <span
                                    class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider <?= $statusClasses[$review['status']] ?>">
                                    <?= $review['status'] ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <form action="<?= base_url('admin/reviews/update-status') ?>" method="POST" class="inline">
                                        <?= csrf_field() ?>
                                        <input type="hidden" name="id" value="<?= $review['id'] ?>">
                                        <?php if ($review['status'] != 'approved'): ?>
                                            <button name="status" value="approved"
                                                class="p-2 text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors"
                                                title="Approve">
                                                <span class="material-symbols-outlined text-[20px]">check_circle</span>
                                            </button>
                                        <?php endif; ?>
                                        <?php if ($review['status'] != 'rejected'): ?>
                                            <button name="status" value="rejected"
                                                class="p-2 text-amber-600 hover:bg-amber-50 rounded-lg transition-colors"
                                                title="Reject/Disable">
                                                <span class="material-symbols-outlined text-[20px]">block</span>
                                            </button>
                                        <?php endif; ?>
                                    </form>
                                    <button
                                        onclick="if(confirm('Are you sure you want to delete this review?')) window.location.href='<?= base_url('admin/reviews/delete/' . $review['id']) ?>'"
                                        class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                        title="Delete Permanent">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>