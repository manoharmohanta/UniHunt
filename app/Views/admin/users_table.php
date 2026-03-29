<table class="w-full text-left text-sm text-slate-600">
    <thead class="bg-slate-50 border-b border-slate-200 uppercase font-semibold text-xs text-slate-500">
        <tr>
            <th class="px-6 py-3">User</th>
            <th class="px-6 py-3">Role</th>
            <th class="px-6 py-3">Status</th>
            <th class="px-6 py-3">Marketing</th>
            <th class="px-6 py-3">Joined</th>
            <th class="px-6 py-3 text-right">Actions</th>
        </tr>
    </thead>
    <tbody class="divide-y divide-slate-100">
        <?php foreach ($users as $u): ?>
            <tr class="hover:bg-slate-50/50">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div
                            class="size-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold uppercase text-xs">
                            <?= substr($u['name'] ?? 'U', 0, 1) ?>
                        </div>
                        <div>
                            <div class="font-medium text-slate-900">
                                <?= esc($u['name']) ?>
                            </div>
                            <div class="text-xs text-slate-400">
                                <?= esc($u['email']) ?>
                            </div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        <span class="px-2 py-1 bg-slate-100 text-slate-600 rounded text-xs font-medium uppercase">
                            <?= esc($u['role_name'] ?? 'Student') ?>
                        </span>
                        <?php if ($u['role_id'] == 4 && !empty($u['university_name'])): ?>
                            <span class="text-[10px] text-slate-400" title="<?= esc($u['university_name']) ?>">
                                (<?= substr($u['university_name'], 0, 10) ?>...)
                            </span>
                        <?php endif; ?>
                        <button
                            onclick="openRoleModal(<?= $u['id'] ?>, <?= $u['role_id'] ?? 2 ?>, <?= $u['university_id'] ?? 'null' ?>, '<?= esc($u['university_name'] ?? '') ?>')"
                            class="p-1 text-slate-400 hover:text-indigo-600 transition-colors" title="Edit Role">
                            <span class="material-symbols-outlined text-[16px]">edit</span>
                        </button>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <span
                        class="px-2 py-1 <?= $u['status'] == 'active' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?> rounded text-xs font-medium uppercase">
                        <?= $u['status'] ?>
                    </span>
                </td>
                <td class="px-6 py-4">
                    <?php if (!empty($u['marketing_consent'])): ?>
                        <span class="flex items-center gap-1 text-green-600 text-xs font-medium">
                            <span class="material-symbols-outlined text-[16px]">check_circle</span> Consented
                        </span>
                    <?php else: ?>
                        <span class="flex items-center gap-1 text-slate-400 text-xs font-medium">
                            <span class="material-symbols-outlined text-[16px]">cancel</span> Declined
                        </span>
                    <?php endif; ?>
                </td>
                <td class="px-6 py-4 text-slate-500">
                    <?= date('M d, Y', strtotime($u['created_at'])) ?>
                </td>
                <td class="px-6 py-4 text-right">
                    <form hx-post="<?= base_url('admin/users/update-status') ?>" hx-target="#users-container"
                        hx-swap="innerHTML" class="inline-block">
                        <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                        <?php if ($u['status'] == 'active'): ?>
                            <input type="hidden" name="status" value="blocked">
                            <button type="submit"
                                class="text-red-500 hover:text-red-700 transition-colors flex items-center gap-1 ml-auto text-xs font-bold bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded"
                                title="Stop User">
                                <span class="material-symbols-outlined text-[16px]">block</span> Stop
                            </button>
                        <?php else: ?>
                            <input type="hidden" name="status" value="active">
                            <button type="submit"
                                class="text-green-600 hover:text-green-800 transition-colors flex items-center gap-1 ml-auto text-xs font-bold bg-green-50 hover:bg-green-100 px-3 py-1.5 rounded"
                                title="Activate User">
                                <span class="material-symbols-outlined text-[16px]">check</span> Activate
                            </button>
                        <?php endif; ?>
                    </form>
                    <?php if (session()->get('role_id') == 1 && $u['id'] != session()->get('user_id')): ?>
                        <a href="<?= base_url('admin/users/delete/' . $u['id']) ?>"
                            onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.')"
                            class="text-rose-500 hover:text-rose-700 transition-colors inline-flex items-center gap-1 text-xs font-bold bg-rose-50 hover:bg-rose-100 px-3 py-1.5 rounded"
                            title="Delete User">
                            <span class="material-symbols-outlined text-[16px]">delete</span>
                        </a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<!-- Pagination -->
<?php if ($pager): ?>
    <div class="px-6 py-4 border-t border-slate-200">
        <?= $pager->links('default', 'tailwind_full') ?>
    </div>
<?php endif; ?>