<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-slate-800">Email Campaign Engine</h2>
    <a href="<?= base_url('admin/campaigns/new') ?>"
        class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors shadow-sm">
        <span class="material-symbols-outlined text-[20px]">add</span>
        New Campaign
    </a>
</div>

<?php if (session()->getFlashdata('message')): ?>
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
        <?= session()->getFlashdata('message') ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-600">
            <thead
                class="bg-slate-50 border-b border-slate-200 font-semibold text-slate-700 uppercase tracking-wider text-xs">
                <tr>
                    <th class="px-6 py-4">Campaign</th>
                    <th class="px-6 py-4">Subject</th>
                    <th class="px-6 py-4">Priority</th>
                    <th class="px-6 py-4">Scheduled</th>
                    <th class="px-6 py-4 text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                <?php if (!empty($campaigns) && is_array($campaigns)): ?>
                    <?php foreach ($campaigns as $campaign): ?>
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="font-bold text-slate-900">
                                    <?= esc($campaign['campaign_tag'] ?? 'Untitled') ?>
                                </div>
                                <div class="text-xs text-slate-500">
                                    ID:
                                    <?= esc($campaign['id']) ?>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="block max-w-xs truncate" title="<?= esc($campaign['email_subject']) ?>">
                                    <?= esc($campaign['email_subject']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <?php
                                $priorityColors = [
                                    'low' => 'bg-blue-50 text-blue-700',
                                    'medium' => 'bg-yellow-50 text-yellow-700',
                                    'high' => 'bg-red-50 text-red-700',
                                ];
                                $pColor = $priorityColors[$campaign['priority']] ?? 'bg-gray-50 text-gray-700';
                                ?>
                                <span class="inline-flex px-2 py-1 rounded-full text-xs font-medium <?= $pColor ?>">
                                    <?= ucfirst($campaign['priority']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <?= date('M d, Y h:i A', strtotime($campaign['scheduled_at'])) ?>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span
                                    class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700">
                                    <?= ucfirst($campaign['status']) ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                            <p class="text-base font-medium">No campaigns found</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>