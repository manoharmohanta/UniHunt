<div class="overflow-x-auto">
    <table class="w-full text-left text-sm text-slate-600">
        <thead class="bg-slate-50 border-b border-slate-200 uppercase font-semibold text-xs text-slate-500">
            <tr>
                <th class="px-6 py-3">Title</th>
                <th class="px-6 py-3">Status</th>
                <th class="px-6 py-3">Last Updated</th>
                <th class="px-6 py-3 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            <?php if (empty($blogs)): ?>
                <tr>
                    <td colspan="4" class="px-6 py-8 text-center text-slate-400">No blog posts found.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($blogs as $b): ?>
                    <tr class="hover:bg-slate-50/50">
                        <td class="px-6 py-4 font-medium text-slate-900">
                            <?= esc($b['title']) ?>
                            <div class="text-xs text-slate-400 font-normal">/
                                <?= esc($b['slug']) ?>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span
                                class="px-2 py-1 <?= $b['status'] == 'published' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' ?> rounded text-xs font-medium uppercase">
                                <?= $b['status'] ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-slate-500">
                            <?= date('M d, Y', strtotime($b['created_at'])) ?>
                        </td>
                        <td class="px-6 py-4 text-right flex items-center justify-end gap-2">
                            <a href="<?= base_url('admin/blogs/edit/' . $b['id']) ?>"
                                class="p-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-all inline-flex shadow-sm border border-slate-100"
                                title="Edit">
                                <span class="material-symbols-outlined text-[20px]">edit</span>
                            </a>
                            <a href="<?= base_url('blog/' . ($b['category'] ?? 'general') . '/' . $b['slug']) ?>"
                                target="_blank"
                                class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-slate-50 rounded-lg transition-all inline-flex"
                                title="View Live">
                                <span class="material-symbols-outlined text-[20px]">open_in_new</span>
                            </a>
                            <?php if (session()->get('role_id') == 1): ?>
                                <a href="<?= base_url('admin/blogs/delete/' . $b['id']) ?>"
                                    onclick="return confirm('Delete this blog post?');"
                                    class="p-2 text-rose-500 hover:text-rose-700 hover:bg-rose-50 rounded-lg transition-all inline-flex"
                                    title="Delete">
                                    <span class="material-symbols-outlined text-[20px]">delete</span>
                                </a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<!-- Pagination -->
<?php if ($pager): ?>
    <div class="px-6 py-4 border-t border-slate-200">
        <?= $pager->links('default', 'tailwind_full') ?>
    </div>
<?php endif; ?>