<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="max-w-5xl mx-auto">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <a href="<?= base_url('admin/campaigns/step1') ?>"
                class="text-slate-500 hover:text-indigo-600 flex items-center gap-2 mb-2 transition-colors text-sm font-medium">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                Back to Configuration
            </a>
            <h2 class="text-3xl font-bold text-slate-800 tracking-tight">Select Recipients</h2>
            <p class="text-slate-500 mt-1">Choose who will receive this campaign.</p>
        </div>
        <div
            class="hidden md:flex items-center gap-2 px-3 py-1.5 bg-indigo-50 border border-indigo-100 rounded-lg text-indigo-700 text-xs font-semibold">
            <span class="material-symbols-outlined text-[18px]">group</span>
            <span>Targeting</span>
        </div>
    </div>

    <form action="<?= base_url('admin/campaigns/step2') ?>" method="post"
        x-data="{ submitting: false, activeTab: 'users' }" @submit="submitting = true">
        <?= csrf_field() ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Selection List -->
            <div class="lg:col-span-2 space-y-6">

                <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="border-b border-slate-200">
                        <nav class="-mb-px flex px-6" aria-label="Tabs">
                            <button type="button" @click="activeTab = 'users'"
                                :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'users', 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300': activeTab !== 'users' }"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm mr-8">
                                Registered Users (
                                <?= count($users) ?>)
                            </button>
                            <button type="button" @click="activeTab = 'subscribers'"
                                :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'subscribers', 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300': activeTab !== 'subscribers' }"
                                class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                                Newsletter Subscribers (
                                <?= count($subscribers) ?>)
                            </button>
                        </nav>
                    </div>

                    <div class="p-0">
                        <!-- Users List -->
                        <div x-show="activeTab === 'users'" class="overflow-x-auto max-h-[500px] overflow-y-auto">
                            <?php if (empty($users)): ?>
                                <div class="p-8 text-center text-slate-500">No registered users found.</div>
                            <?php else: ?>
                                <table class="min-w-full divide-y divide-slate-200">
                                    <thead class="bg-slate-50 sticky top-0">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider w-10">
                                                <input type="checkbox" @click="toggleAll('user_checkbox')"
                                                    class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                                Name</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                                Email</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                                Role</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-slate-200">
                                        <?php foreach ($users as $user): ?>
                                            <tr class="hover:bg-slate-50">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <input type="checkbox" name="recipients[]"
                                                        value="<?= esc($user['email']) ?>"
                                                        class="user_checkbox rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">
                                                    <?= esc($user['name']) ?>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                                    <?= esc($user['email']) ?>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                                    <?php
                                                    $roleMap = [1 => 'Admin', 2 => 'Student', 3 => 'University']; // Example mapping
                                                    echo $roleMap[$user['role_id']] ?? 'User';
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php endif; ?>
                        </div>

                        <!-- Subscribers List -->
                        <div x-show="activeTab === 'subscribers'" class="overflow-x-auto max-h-[500px] overflow-y-auto"
                            style="display: none;">
                            <?php if (empty($subscribers)): ?>
                                <div class="p-8 text-center text-slate-500">No subscribers found.</div>
                            <?php else: ?>
                                <table class="min-w-full divide-y divide-slate-200">
                                    <thead class="bg-slate-50 sticky top-0">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider w-10">
                                                <input type="checkbox" @click="toggleAll('subscriber_checkbox')"
                                                    class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                                            </th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                                Email</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">
                                                Subscribed At</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-slate-200">
                                        <?php foreach ($subscribers as $sub): ?>
                                            <tr class="hover:bg-slate-50">
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <input type="checkbox" name="recipients[]" value="<?= esc($sub['email']) ?>"
                                                        class="subscriber_checkbox rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">
                                                    <?= esc($sub['email']) ?>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                                    <?= esc($sub['subscribed_at']) ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Summary & Actions -->
            <div class="space-y-6">
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                    <h3 class="font-semibold text-slate-800 mb-4">Configuration Summary</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between py-2 border-b border-slate-50">
                            <span class="text-slate-500">Type</span>
                            <span class="font-medium">
                                <?= esc($saved_data['type'] ?? '-') ?>
                            </span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-slate-50">
                            <span class="text-slate-500">Target Context</span>
                            <span class="font-medium">
                                <?= esc($saved_data['segment'] ?? '-') ?>
                            </span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-slate-50">
                            <span class="text-slate-500">Goal</span>
                            <span class="font-medium truncate max-w-[150px]"
                                title="<?= esc($saved_data['goal'] ?? '') ?>">
                                <?= esc($saved_data['goal'] ?? '-') ?>
                            </span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-slate-50">
                            <span class="text-slate-500">Tone</span>
                            <span class="font-medium">
                                <?= esc($saved_data['tone'] ?? '-') ?>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="bg-indigo-900 rounded-xl shadow-lg overflow-hidden text-white p-6 relative">
                    <div class="absolute top-0 right-0 p-4 opacity-10">
                        <span class="material-symbols-outlined text-[100px]">auto_awesome</span>
                    </div>
                    <h3 class="text-lg font-bold mb-2 relative z-10">Generate Preview</h3>
                    <p class="text-indigo-200 text-sm mb-6 relative z-10">
                        Proceed to generate the email content with AI for the selected recipients.
                    </p>
                    <button type="submit" :disabled="submitting"
                        class="w-full py-3 px-4 bg-white text-indigo-900 font-bold rounded-lg hover:bg-indigo-50 transition-colors shadow-md flex items-center justify-center gap-2 relative z-10 disabled:opacity-70 disabled:cursor-not-allowed">
                        <span x-show="!submitting">Generate & Preview</span>
                        <span x-show="submitting" class="material-symbols-outlined animate-spin">refresh</span>
                    </button>
                    <p class="text-[10px] text-indigo-300 mt-2 text-center">Make sure to select recipients first</p>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function toggleAll(className) {
        const checkboxes = document.querySelectorAll('.' + className);
        const source = event.target;
        checkboxes.forEach(cb => cb.checked = source.checked);
    }
</script>

<?= $this->endSection() ?>