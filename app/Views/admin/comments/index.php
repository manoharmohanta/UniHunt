<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div class="flex items-center gap-4">
        <a href="<?= base_url('admin/comments') ?>"
            class="px-4 py-2 rounded-lg text-sm font-bold transition-all <?= !$currentStatus ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' ?>">All
            Comments</a>
        <a href="<?= base_url('admin/comments?status=pending') ?>"
            class="px-4 py-2 rounded-lg text-sm font-bold transition-all <?= $currentStatus == 'pending' ? 'bg-amber-500 text-white shadow-lg shadow-amber-200' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' ?>">Pending</a>
        <a href="<?= base_url('admin/comments?status=approved') ?>"
            class="px-4 py-2 rounded-lg text-sm font-bold transition-all <?= $currentStatus == 'approved' ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-200' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' ?>">Approved</a>
        <a href="<?= base_url('admin/comments?status=spam') ?>"
            class="px-4 py-2 rounded-lg text-sm font-bold transition-all <?= $currentStatus == 'spam' ? 'bg-red-500 text-white shadow-lg shadow-red-200' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' ?>">Spam</a>
    </div>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="mb-4 bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded relative" role="alert">
        <strong class="font-bold">Success!</strong>
        <span class="block sm:inline">
            <?= session()->getFlashdata('success') ?>
        </span>
    </div>
<?php endif; ?>

<div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left">
            <thead>
                <tr class="bg-slate-50/50 border-b border-slate-200">
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Author</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Post</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Comment</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Actions
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php if (empty($comments)): ?>
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400">No comments found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($comments as $comment): ?>
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 shrink-0 mr-3">
                                        <img class="rounded-full"
                                            src="<?= $comment['avatar'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($comment['user_name']) ?>"
                                            width="32" height="32" alt="<?= esc($comment['user_name']) ?>" />
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-800">
                                            <?= esc($comment['user_name']) ?>
                                        </p>
                                        <p class="text-[10px] text-slate-400 mt-0.5">
                                            <?= date('M d, Y', strtotime($comment['created_at'])) ?>
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 max-w-xs">
                                <p class="text-sm text-indigo-600 font-medium truncate"
                                    title="<?= esc($comment['blog_title']) ?>">
                                    <?= esc($comment['blog_title']) ?>
                                </p>
                            </td>
                            <td class="px-6 py-4 max-w-md">
                                <p class="text-sm text-slate-600 line-clamp-2" title="<?= esc($comment['comment']) ?>">
                                    <?= esc($comment['comment']) ?>
                                </p>
                            </td>
                            <td class="px-6 py-4">
                                <?php
                                $statusClasses = [
                                    'pending' => 'bg-amber-100 text-amber-700',
                                    'approved' => 'bg-emerald-100 text-emerald-700',
                                    'spam' => 'bg-red-100 text-red-700' // Using red for spam to match 'rejected' vibe
                                ];
                                ?>
                                <span
                                    class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider <?= $statusClasses[$comment['status']] ?? 'bg-slate-100 text-slate-700' ?>">
                                    <?= $comment['status'] ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <?php if ($comment['status'] !== 'approved'): ?>
                                        <a href="<?= base_url('admin/comments/approve/' . $comment['id']) ?>"
                                            class="p-2 text-emerald-600 hover:bg-emerald-50 rounded-lg transition-colors"
                                            title="Approve">
                                            <span class="material-symbols-outlined text-[20px]">check_circle</span>
                                        </a>
                                    <?php endif; ?>

                                    <?php if ($comment['status'] !== 'spam'): ?>
                                        <a href="<?= base_url('admin/comments/spam/' . $comment['id']) ?>"
                                            class="p-2 text-amber-600 hover:bg-amber-50 rounded-lg transition-colors"
                                            title="Mark as Spam">
                                            <span class="material-symbols-outlined text-[20px]">block</span>
                                        </a>
                                    <?php endif; ?>

                                    <a href="<?= base_url('admin/comments/delete/' . $comment['id']) ?>"
                                        onclick="return confirm('Are you sure you want to delete this comment?');"
                                        class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors"
                                        title="Delete Permanent">
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
    <div class="px-6 py-4 border-t border-slate-100">
        <?= $pager->links('default', 'tailwind_full') ?>
    </div>
</div>

<?= $this->endSection() ?>