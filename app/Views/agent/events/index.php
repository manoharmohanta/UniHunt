<?= view('web/include/header', ['title' => $title]) ?>

<div class="flex min-h-screen bg-gray-50 dark:bg-background-dark">
    <?= view('agent/include/sidebar') ?>

    <main class="flex-1 p-6 md:p-10">
        <div class="max-w-6xl mx-auto">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 class="text-3xl font-bold dark:text-white mb-2">My Events</h1>
                    <p class="text-gray-500">Manage your educational fairs, webinars, and seminars.</p>
                </div>
                <a href="<?= base_url('agent/events/create') ?>" class="btn-primary flex items-center gap-2">
                    <span class="material-symbols-outlined">add</span> Post New Event
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($events as $event): ?>
                    <div
                        class="bg-white dark:bg-card-dark rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm overflow-hidden flex flex-col items-stretch">
                        <?php if ($event['image']): ?>
                            <img src="<?= base_url($event['image']) ?>" class="w-full h-40 object-cover"
                                alt="<?= esc($event['title']) ?>">
                        <?php else: ?>
                            <div
                                class="w-full h-40 bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-400">
                                <span class="material-symbols-outlined text-4xl">event</span>
                            </div>
                        <?php endif; ?>

                        <div class="p-6 flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <span
                                    class="px-2 py-0.5 bg-primary/10 text-primary text-[10px] font-bold rounded uppercase">
                                    <?= esc($event['event_type']) ?>
                                </span>
                                <span class="text-[10px] text-gray-500">
                                    <?= date('M d, Y', strtotime($event['start_date'])) ?>
                                </span>
                            </div>
                            <h3 class="font-bold dark:text-white mb-2 line-clamp-2">
                                <?= esc($event['title']) ?>
                            </h3>
                            <p class="text-xs text-gray-500 mb-4 line-clamp-3">
                                <?= esc($event['short_description']) ?>
                            </p>

                            <div
                                class="flex items-center justify-between pt-4 border-t border-gray-50 dark:border-gray-800">
                                <span
                                    class="text-xs font-bold <?= ($event['status'] === 'active') ? 'text-green-600' : 'text-orange-500' ?>">
                                    <?= ucfirst($event['status']) ?>
                                </span>
                                <div class="flex gap-2">
                                    <a href="<?= base_url('events/' . $event['slug']) ?>"
                                        class="text-xs text-primary hover:underline">View Publicly</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

                <?php if (empty($events)): ?>
                    <div
                        class="col-span-full py-12 text-center text-gray-500 border-2 border-dashed border-gray-200 dark:border-gray-800 rounded-3xl">
                        No events found. Start promoting your events today!
                    </div>
                <?php endif; ?>
            </div>

            <div class="mt-8">
                <?= $pager->links('default', 'tailwind_full') ?>
            </div>
        </div>
    </main>
</div>

<?= view('web/include/footer') ?>