<?= view('admin/layout', ['title' => 'Role Requests', 'active_menu' => 'role-requests']) ?>

<main class="flex-1 p-6 overflow-y-auto bg-slate-50 relative z-10 font-display">
    <div class="max-w-7xl mx-auto space-y-6">

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900 border-l-4 border-indigo-500 pl-3">
                    Role Requests
                </h1>
                <p class="text-slate-500 text-sm mt-1 mb-0">Manage and approve user requests for role changes.</p>
            </div>
        </div>

        <?php if (session()->getFlashdata('message')): ?>
            <div
                class="p-4 rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-200 flex items-center gap-2 shadow-sm">
                <span class="material-symbols-outlined text-emerald-500">check_circle</span>
                <span class="font-medium">
                    <?= session()->getFlashdata('message') ?>
                </span>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="p-4 rounded-lg bg-red-50 text-red-700 border border-red-200 flex items-center gap-2 shadow-sm">
                <span class="material-symbols-outlined text-red-500">error</span>
                <span class="font-medium">
                    <?= session()->getFlashdata('error') ?>
                </span>
            </div>
        <?php endif; ?>

        <!-- Table -->
        <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead
                        class="bg-slate-50/80 border-b border-slate-200 text-slate-500 uppercase text-[11px] font-bold tracking-wider">
                        <tr>
                            <th class="px-6 py-4">User</th>
                            <th class="px-6 py-4">Requested Role</th>
                            <th class="px-6 py-4">Date</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-600">
                        <?php if (empty($requests)): ?>
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <span class="material-symbols-outlined text-4xl opacity-50">inbox</span>
                                        <p>No role requests found.</p>
                                    </div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($requests as $req): ?>
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold text-xs uppercase shrink-0">
                                                <?= substr(esc($req['user_name']), 0, 2) ?>
                                            </div>
                                            <div>
                                                <div class="font-medium text-slate-900">
                                                    <?= esc($req['user_name']) ?>
                                                </div>
                                                <div class="text-xs text-slate-500">
                                                    <?= esc($req['user_email']) ?>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 capitalize">
                                            <?= esc($req['requested_role_name'] ?? 'Unknown Role') ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-slate-500 text-xs">
                                        <?= date('M d, Y h:i A', strtotime($req['created_at'])) ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php if ($req['status'] === 'pending'): ?>
                                            <span
                                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                                Pending
                                            </span>
                                        <?php elseif ($req['status'] === 'approved'): ?>
                                            <span
                                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                <span class="material-symbols-outlined text-[14px]">check</span>
                                                Approved
                                            </span>
                                        <?php else: ?>
                                            <span
                                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-semibold bg-red-50 text-red-700 border border-red-200">
                                                <span class="material-symbols-outlined text-[14px]">close</span>
                                                Rejected
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <?php if ($req['status'] === 'pending'): ?>
                                            <div class="flex items-center justify-end gap-2">
                                                <form action="<?= base_url('admin/role-requests/approve/' . $req['id']) ?>"
                                                    method="post"
                                                    onsubmit="return confirm('Are you sure you want to approve this role change?');"
                                                    class="inline">
                                                    <?= csrf_field() ?>
                                                    <button type="submit"
                                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 hover:bg-emerald-500 text-emerald-600 hover:text-white border border-emerald-200 hover:border-emerald-500 rounded-md text-xs font-semibold transition-colors">
                                                        <span class="material-symbols-outlined text-[16px]">check_circle</span>
                                                        Approve
                                                    </button>
                                                </form>
                                                <form action="<?= base_url('admin/role-requests/reject/' . $req['id']) ?>"
                                                    method="post"
                                                    onsubmit="return confirm('Are you sure you want to reject this role change?');"
                                                    class="inline">
                                                    <?= csrf_field() ?>
                                                    <button type="submit"
                                                        class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 hover:bg-red-500 text-red-600 hover:text-white border border-red-200 hover:border-red-500 rounded-md text-xs font-semibold transition-colors">
                                                        <span class="material-symbols-outlined text-[16px]">cancel</span>
                                                        Reject
                                                    </button>
                                                </form>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-xs text-slate-400 italic">Processed</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if ($pager): ?>
                <div class="p-4 border-t border-slate-200 flex justify-center bg-slate-50/50">
                    <?= $pager->links() ?>
                </div>
            <?php endif; ?>
        </div>

    </div>
</main>
</div>
</body>

</html>