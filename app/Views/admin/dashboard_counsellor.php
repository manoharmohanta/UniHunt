<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
    <!-- Stat Card 1 -->
    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-start justify-between">
        <div>
            <p class="text-sm font-medium text-slate-500 mb-1">Total Students</p>
            <h3 class="text-3xl font-bold text-slate-900">
                <?= number_format($stats['users']) ?>
            </h3>
        </div>
        <div class="size-12 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
            <span class="material-symbols-outlined text-2xl">group</span>
        </div>
    </div>

    <!-- Stat Card 2 -->
    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-start justify-between">
        <div>
            <p class="text-sm font-medium text-slate-500 mb-1">Generated Documents</p>
            <h3 class="text-3xl font-bold text-slate-900">
                <?= number_format($stats['documents']) ?>
            </h3>
        </div>
        <div class="size-12 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center">
            <span class="material-symbols-outlined text-2xl">description</span>
        </div>
    </div>

    <!-- Stat Card 3 -->
    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-start justify-between">
        <div>
            <p class="text-sm font-medium text-slate-500 mb-1">Mock Interviews</p>
            <h3 class="text-3xl font-bold text-slate-900">
                <?= number_format($stats['interviews']) ?>
            </h3>
        </div>
        <div class="size-12 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center">
            <span class="material-symbols-outlined text-2xl">video_camera_front</span>
        </div>
    </div>

    <!-- Stat Card 4 -->
    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-start justify-between">
        <div>
            <p class="text-sm font-medium text-slate-500 mb-1">Universities</p>
            <h3 class="text-3xl font-bold text-slate-900">
                <?= number_format($stats['universities']) ?>
            </h3>
        </div>
        <div class="size-12 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
            <span class="material-symbols-outlined text-2xl">account_balance</span>
        </div>
    </div>

    <!-- Stat Card 5 -->
    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-start justify-between">
        <div>
            <p class="text-sm font-medium text-slate-500 mb-1">Total Courses</p>
            <h3 class="text-3xl font-bold text-slate-900">
                <?= number_format($stats['courses']) ?>
            </h3>
        </div>
        <div class="size-12 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center">
            <span class="material-symbols-outlined text-2xl">list_alt</span>
        </div>
    </div>

    <!-- Stat Card 6 -->
    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-start justify-between">
        <div>
            <p class="text-sm font-medium text-slate-500 mb-1">Total AI Requests</p>
            <h3 class="text-3xl font-bold text-slate-900">
                <?= number_format($stats['ai_usage']) ?>
            </h3>
        </div>
        <div class="size-12 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
            <span class="material-symbols-outlined text-2xl">psychology</span>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
    <div class="lg:col-span-3 bg-white rounded-xl border border-slate-200 shadow-sm p-6 flex flex-col gap-6">
        <h2 class="font-bold text-slate-800">Counsellor Actions</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <a href="<?= base_url('admin/universities/create') ?>"
                class="group p-4 rounded-xl border border-slate-100 hover:border-indigo-100 hover:bg-indigo-50/30 transition-all flex items-center gap-4">
                <div
                    class="size-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center group-hover:bg-indigo-600 group-hover:text-white transition-all">
                    <span class="material-symbols-outlined">add_business</span>
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-800">Add University</p>
                    <p class="text-[11px] text-slate-500">Register educational hub</p>
                </div>
            </a>
            <a href="<?= base_url('admin/courses/create') ?>"
                class="group p-4 rounded-xl border border-slate-100 hover:border-teal-100 hover:bg-teal-50/30 transition-all flex items-center gap-4">
                <div
                    class="size-10 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center group-hover:bg-teal-600 group-hover:text-white transition-all">
                    <span class="material-symbols-outlined">playlist_add</span>
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-800">Add Course</p>
                    <p class="text-[11px] text-slate-500">List new study program</p>
                </div>
            </a>
            <a href="<?= base_url('admin/blogs/create') ?>"
                class="group p-4 rounded-xl border border-slate-100 hover:border-amber-100 hover:bg-amber-50/30 transition-all flex items-center gap-4">
                <div
                    class="size-10 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center group-hover:bg-amber-600 group-hover:text-white transition-all">
                    <span class="material-symbols-outlined">edit</span>
                </div>
                <div>
                    <p class="text-sm font-bold text-slate-800">Post Insight</p>
                    <p class="text-[11px] text-slate-500">Publish news or guides</p>
                </div>
            </a>
        </div>
    </div>
</div>

<?= $this->endSection() ?>