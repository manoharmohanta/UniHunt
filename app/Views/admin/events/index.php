<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-slate-800">Events Manager</h2>
    <a href="<?= base_url('admin/events/new') ?>"
        class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors shadow-sm">
        <span class="material-symbols-outlined text-[20px]">add</span>
        Create Event
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
    <div class="px-6 py-4 border-b border-slate-200 flex justify-between items-center gap-4">
        <h2 class="text-lg font-bold text-slate-900 whitespace-nowrap">Event List</h2>
        <div class="flex items-center gap-3">
            <form action="<?= base_url('admin/events') ?>" method="GET" class="flex items-center gap-2">
                <div class="relative group">
                    <input type="text" name="search" value="<?= esc($search ?? '') ?>" placeholder="Search events..." 
                        class="pl-10 pr-10 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all w-64 group-hover:bg-white">
                    <span class="material-symbols-outlined absolute left-3 top-2.5 text-slate-400 text-sm group-hover:text-indigo-500 transition-colors">search</span>
                    <?php if (!empty($search)): ?>
                        <a href="<?= base_url('admin/events') ?>" class="absolute right-3 top-2.5 text-slate-400 hover:text-rose-500 transition-colors">
                            <span class="material-symbols-outlined text-sm">close</span>
                        </a>
                    <?php endif; ?>
                </div>
                <button type="submit" class="px-4 py-2 bg-slate-800 text-white text-sm font-semibold rounded-xl hover:bg-slate-900 transition-all shadow-sm">
                    Search
                </button>
            </form>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-600">
            <thead
                class="bg-slate-50 border-b border-slate-200 font-semibold text-slate-700 uppercase tracking-wider text-xs">
                <tr>
                    <th class="px-6 py-4">Event</th>
                    <th class="px-6 py-4">Date & Time</th>
                    <th class="px-6 py-4">Type</th>
                    <th class="px-6 py-4">Location</th>
                    <th class="px-6 py-4 text-center">Status</th>
                    <th class="px-6 py-4 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                <?php if (!empty($events) && is_array($events)): ?>
                    <?php foreach ($events as $event): ?>
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <?php if ($event['image']): ?>
                                        <img src="<?= base_url($event['image']) ?>" alt="Thumbnail"
                                            class="w-12 h-12 rounded-lg object-cover border border-slate-200">
                                    <?php else: ?>
                                        <div
                                            class="w-12 h-12 rounded-lg bg-slate-100 flex items-center justify-center border border-slate-200">
                                            <span class="material-symbols-outlined text-slate-400">image</span>
                                        </div>
                                    <?php endif; ?>
                                    <div>
                                        <div class="font-bold text-slate-900 line-clamp-1">
                                            <?= esc($event['title']) ?>
                                        </div>
                                        <div class="text-xs text-slate-500 line-clamp-1">
                                            <?= esc($event['short_description']) ?>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-medium text-slate-900">
                                    <?= date('M d, Y', strtotime($event['start_date'])) ?>
                                </div>
                                <div class="text-xs text-slate-500">
                                    <?= $event['start_time'] ? date('h:i A', strtotime($event['start_time'])) : 'All Day' ?>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-100">
                                    <?= esc($event['event_type']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-1.5 text-slate-600">
                                    <span class="material-symbols-outlined text-[16px] text-slate-400">
                                        <?= $event['location_type'] === 'online' ? 'videocam' : 'location_on' ?>
                                    </span>
                                    <span>
                                        <?= esc($event['location_name'] ?? ucfirst($event['location_type'])) ?>
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <?php
                                $statusColors = [
                                    'draft' => 'bg-gray-100 text-gray-700 border-gray-200',
                                    'published' => 'bg-emerald-50 text-emerald-700 border-emerald-100',
                                    'cancelled' => 'bg-red-50 text-red-700 border-red-100',
                                    'archived' => 'bg-amber-50 text-amber-700 border-amber-100'
                                ];
                                $colorClass = $statusColors[$event['status']] ?? $statusColors['draft'];
                                ?>
                                <span
                                    class="inline-flex px-2.5 py-1 rounded-full text-xs font-medium border <?= $colorClass ?>">
                                    <?= ucfirst($event['status']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="<?= base_url('events/' . $event['slug']) ?>" target="_blank"
                                        class="p-2 rounded-lg text-slate-500 hover:bg-slate-100 hover:text-emerald-600 transition-colors"
                                        title="View Public Page">
                                        <span class="material-symbols-outlined text-[20px]">visibility</span>
                                    </a>
                                    <a href="<?= base_url('admin/events/edit/' . $event['id']) ?>"
                                        class="p-2 rounded-lg text-slate-500 hover:bg-slate-100 hover:text-indigo-600 transition-colors"
                                        title="Edit">
                                        <span class="material-symbols-outlined text-[20px]">edit</span>
                                    </a>
                                    <a href="<?= base_url('admin/events/delete/' . $event['id']) ?>"
                                        onclick="return confirm('Are you sure you want to delete this event?');"
                                        class="p-2 rounded-lg text-slate-500 hover:bg-red-50 hover:text-red-600 transition-colors"
                                        title="Delete">
                                        <span class="material-symbols-outlined text-[20px]">delete</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                            <div class="flex flex-col items-center justify-center gap-3">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center">
                                    <span class="material-symbols-outlined text-3xl text-slate-300">event_busy</span>
                                </div>
                                <p class="text-base font-medium">No events found</p>
                                <a href="<?= base_url('admin/events/new') ?>"
                                    class="text-sm text-indigo-600 hover:underline">Create your first event</a>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <!-- Pagination -->
    <?php if ($pager->getPageCount() > 1): ?>
        <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-200">
            <?= $pager->links('default', 'tailwind_full') ?>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>