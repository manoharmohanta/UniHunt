<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden mb-8">
    <div class="px-6 py-4 border-b border-slate-200 flex justify-between items-center">
        <h2 class="text-lg font-bold text-slate-900">Registered Users</h2>
        <div class="flex items-center gap-3">
            <form action="<?= base_url('admin/users') ?>" method="GET" class="flex items-center gap-2">
                <div class="relative group">
                    <input type="text" name="search" value="<?= esc($search ?? '') ?>"
                        placeholder="Search users, emails..."
                        class="pl-10 pr-10 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all w-64 group-hover:bg-white">
                    <span
                        class="material-symbols-outlined absolute left-3 top-2.5 text-slate-400 text-sm group-hover:text-indigo-500 transition-colors">search</span>
                    <?php if (!empty($search)): ?>
                        <a href="<?= base_url('admin/users') ?>"
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

    <div id="users-container">
        <?= view('admin/users_table', ['users' => $users, 'pager' => $pager]) ?>
    </div>
</div>

<!-- Role Edit Modal -->
<div id="roleModal" class="hidden fixed inset-0 z-50 items-center justify-center bg-black/50 backdrop-blur-sm">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 transform transition-all scale-100">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-bold text-slate-900">Update User Role</h3>
            <button onclick="closeRoleModal()" class="text-slate-400 hover:text-slate-600 transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <form action="<?= base_url('admin/users/update-role') ?>" method="POST">
            <?= csrf_field() ?>
            <input type="hidden" name="user_id" id="roleUserId">

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Assign Role</label>
                    <div class="space-y-2">
                        <?php foreach ($roles as $r): ?>
                            <label
                                class="flex items-center gap-3 p-3 border border-slate-200 rounded-xl cursor-pointer hover:border-indigo-500 transition-colors has-[:checked]:bg-indigo-50 has-[:checked]:border-indigo-500">
                                <input type="radio" name="role_id" value="<?= $r['id'] ?>"
                                    class="text-indigo-600 focus:ring-indigo-500" onchange="toggleUniSelect(this.value)">
                                <div>
                                    <span
                                        class="block text-sm font-bold text-slate-900 uppercase"><?= esc($r['name']) ?></span>
                                    <span class="block text-[10px] text-slate-500"><?= esc($r['description']) ?></span>
                                </div>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div id="uniSelectContainer" class="hidden">
                    <label class="block text-sm font-bold text-slate-700 mb-2">Assign University</label>
                    <select name="university_id" id="uniSelect"
                        class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500">
                        <option value="">Select University</option>
                        <?php foreach ($universities as $uni): ?>
                            <option value="<?= $uni['id'] ?>"><?= esc($uni['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <p class="text-[10px] text-slate-500 mt-1 italic">Required for University Representatives</p>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3 pt-4 border-t border-slate-100">
                <button type="button" onclick="closeRoleModal()"
                    class="px-4 py-2 text-slate-600 font-bold text-sm hover:bg-slate-100 rounded-xl transition-colors">Cancel</button>
                <button type="submit"
                    class="px-6 py-2 bg-indigo-600 text-white font-bold text-sm rounded-xl hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-100">Save
                    Changes</button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#uniSelect').select2({
            placeholder: 'Select University',
            dropdownParent: $('#roleModal'),
            width: '100%'
        });
    });

    function openRoleModal(userId, roleId, uniId, uniName) {
        document.getElementById('roleUserId').value = userId;
        const modal = document.getElementById('roleModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        // Select Role
        const roleRadio = document.querySelector(`input[name="role_id"][value="${roleId}"]`);
        if (roleRadio) roleRadio.checked = true;

        // Select Uni
        $('#uniSelect').val(uniId).trigger('change');

        toggleUniSelect(roleId);
    }

    function closeRoleModal() {
        const modal = document.getElementById('roleModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    function toggleUniSelect(roleId) {
        const container = document.getElementById('uniSelectContainer');
        // Assuming ID 4 is University Rep
        if (roleId == 4) {
            container.classList.remove('hidden');
        } else {
            container.classList.add('hidden');
        }
    }
</script>

<?= $this->endSection() ?>