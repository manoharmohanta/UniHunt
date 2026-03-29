<?= view('web/include/header', ['title' => $title]) ?>

<div class="flex min-h-screen bg-gray-50 dark:bg-background-dark">
    <?= view('agent/include/sidebar') ?>

    <main class="flex-1 p-6 md:p-10">
        <div class="max-w-4xl mx-auto">
            <header class="mb-8">
                <a href="<?= base_url('agent/events') ?>"
                    class="text-sm text-primary hover:underline flex items-center gap-1 mb-4">
                    <span class="material-symbols-outlined text-sm">arrow_back</span> Back to Events
                </a>
                <h1 class="text-3xl font-bold dark:text-white">Post New Event</h1>
                <p class="text-gray-500">Reach prospective students globally.</p>
            </header>

            <form action="<?= base_url('agent/events/store') ?>" method="POST" enctype="multipart/form-data"
                class="space-y-8 flex flex-col items-stretch">
                <?= csrf_field() ?>

                <div
                    class="bg-white dark:bg-card-dark p-8 rounded-2xl border border-gray-100 dark:border-gray-800 shadow-sm space-y-6 flex flex-col items-stretch">
                    <div>
                        <label class="block text-sm font-bold mb-2 dark:text-gray-200">Event Title</label>
                        <input type="text" name="title" required placeholder="e.g. Virtual UK Education Fair 2026"
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-transparent outline-none focus:ring-2 focus:ring-primary/20 transition-all">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold mb-2 dark:text-gray-200">Event Type</label>
                            <select name="event_type"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 outline-none">
                                <option value="webinar">Webinar (Online)</option>
                                <option value="fair">Educational Fair (In-person)</option>
                                <option value="seminar">Seminar</option>
                                <option value="on-campus">On-campus Event</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2 dark:text-gray-200">Organizer Name</label>
                            <input type="text" name="organizer" required placeholder="e.g. Bright Future Agents"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-transparent outline-none focus:ring-2 focus:ring-primary/20 transition-all">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-bold mb-2 dark:text-gray-200">Start Date</label>
                            <input type="date" name="start_date" required
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2 dark:text-gray-200">Start Time</label>
                            <input type="time" name="start_time"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2 dark:text-gray-200">End Time</label>
                            <input type="time" name="end_time"
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold mb-2 dark:text-gray-200">Short Description</label>
                        <textarea name="short_description" rows="2" maxlength="200" required
                            placeholder="A brief summary for the event listing..."
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-transparent outline-none focus:ring-2 focus:ring-primary/20 transition-all"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-bold mb-2 dark:text-gray-200">Full Description</label>
                        <textarea name="description" rows="5" required
                            placeholder="Describe the agenda, target audience, etc."
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-transparent outline-none focus:ring-2 focus:ring-primary/20 transition-all"></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold mb-2 dark:text-gray-200">Event Image</label>
                            <input type="file" name="image"
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20">
                        </div>
                        <div>
                            <label class="block text-sm font-bold mb-2 dark:text-gray-200">Registration Link
                                (External)</label>
                            <input type="url" name="registration_link" placeholder="https://zoom.us/j/..."
                                class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-gray-700 bg-transparent outline-none focus:ring-2 focus:ring-primary/20 transition-all">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end shrink-0">
                    <button type="submit"
                        class="bg-primary text-white font-bold py-4 px-12 rounded-2xl shadow-lg shadow-primary/20 hover:scale-105 transition-transform">
                        Post Event
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>

<?= view('web/include/footer') ?>