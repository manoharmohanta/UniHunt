<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="space-y-6">
    <!-- Header Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-8 py-6 border-b border-slate-100 flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="text-xl font-bold text-slate-800">Manage Courses</h2>
                <p class="text-sm text-slate-500">View and manage academic programs globally</p>
            </div>
            <div class="flex flex-wrap gap-3 items-center">
                <form action="<?= base_url('admin/courses') ?>" method="GET" class="flex items-center gap-2">
                    <div class="relative group">
                        <input type="text" name="search" value="<?= esc($search) ?>"
                            placeholder="Search courses, universities..."
                            class="pl-10 pr-10 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all w-64 group-hover:bg-white">
                        <span
                            class="material-symbols-outlined absolute left-3 top-2.5 text-slate-400 text-sm group-hover:text-indigo-500 transition-colors">search</span>
                        <?php if ($search): ?>
                            <a href="<?= base_url('admin/courses') ?>"
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
                <div class="h-8 w-px bg-slate-200 mx-1 hidden md:block"></div>
                <?php if (session()->get('role_id') != 4): ?>
                    <button onclick="openModal('bulkModal')"
                        class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl transition-all shadow-lg shadow-emerald-100 flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">upload_file</span> Bulk Upload
                    </button>
                <?php endif; ?>
                <a href="<?= base_url('admin/courses/create') ?>"
                    class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition-all shadow-lg shadow-indigo-100 flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">add</span> Add New
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th
                            class="px-8 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">
                            Course Name</th>
                        <th
                            class="px-8 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">
                            University</th>
                        <th
                            class="px-8 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">
                            Level</th>
                        <th
                            class="px-8 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100">
                            Tuition Fee</th>
                        <th
                            class="px-8 py-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-100 text-right">
                            Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php foreach ($courses as $course): ?>
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-8 py-4">
                                <div class="text-sm font-bold text-slate-700"><?= $course['name'] ?></div>
                                <div class="text-[10px] text-slate-400 font-medium uppercase tracking-tight">
                                    <?= $course['field'] ?? 'General field' ?>
                                </div>
                            </td>
                            <td class="px-8 py-4 text-sm text-slate-500 font-medium"><?= $course['university_name'] ?></td>
                            <td class="px-8 py-4">
                                <span
                                    class="px-2.5 py-1 bg-slate-100 text-slate-600 rounded-lg text-xs font-bold uppercase tracking-wider"><?= $course['level'] ?></span>
                            </td>
                            <td class="px-8 py-4 text-sm font-bold text-indigo-600"><?= $course['tuition_fee'] ?></td>
                            <td class="px-8 py-4 text-right">
                                <div class="flex justify-end gap-2 opacity-0 group-hover:opacity-100 transition-all">
                                    <a href="<?= base_url('admin/courses/edit/' . $course['id']) ?>"
                                        class="p-2 text-indigo-500 hover:bg-indigo-50 rounded-lg transition-all">
                                        <span class="material-symbols-outlined text-[20px]">edit</span>
                                    </a>
                                    <?php
                                    $courseUrl = base_url('courses/' .
                                        ($course['country_slug'] ?? 'global') . '/' .
                                        ($course['university_slug'] ?? 'university') . '/' .
                                        url_title($course['name'], '-', true));
                                    ?>
                                    <a href="<?= $courseUrl ?>" target="_blank"
                                        class="p-2 text-emerald-500 hover:bg-emerald-50 rounded-lg transition-all">
                                        <span class="material-symbols-outlined text-[20px]">visibility</span>
                                    </a>
                                    <?php if (session()->get('role_id') == 1): ?>
                                        <a href="<?= base_url('admin/courses/delete/' . $course['id']) ?>"
                                            onclick="return confirm('Are you sure you want to delete this course?');"
                                            class="p-2 text-rose-500 hover:bg-rose-50 rounded-lg transition-all">
                                            <span class="material-symbols-outlined text-[20px]">delete</span>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?php if ($pager->getPageCount() > 1): ?>
            <div class="px-8 py-6 bg-slate-50/50 border-t border-slate-100">
                <?= $pager->links('default', 'tailwind_full') ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Bulk Modal -->
<div id="bulkModal" class="modal-overlay items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-lg modal-content-tw overflow-hidden shadow-2xl">
        <form action="<?= base_url('admin/courses/upload-bulk') ?>" method="POST" enctype="multipart/form-data">
            <?= csrf_field() ?>
            <?= honeypot_field() ?>
            <div class="px-8 py-6 bg-slate-50 border-b border-slate-100 flex justify-between items-center">
                <h3 class="text-xl font-bold text-slate-800">Bulk Upload Courses</h3>
                <button type="button" onclick="closeModal('bulkModal')"
                    class="size-8 rounded-full hover:bg-slate-200 flex items-center justify-center transition-colors">
                    <span class="material-symbols-outlined text-slate-500 text-sm">close</span>
                </button>
            </div>
            <div class="px-8 py-6 space-y-6">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Select CSV
                        File</label>
                    <div
                        class="border-2 border-dashed border-slate-200 rounded-2xl p-8 text-center hover:border-indigo-400 transition-all group">
                        <input type="file" name="bulk_csv" accept=".csv" required class="hidden" id="csvFileCourses">
                        <label for="csvFileCourses" class="cursor-pointer">
                            <span
                                class="material-symbols-outlined text-4xl text-slate-300 group-hover:text-indigo-500 transition-all mb-2">upload</span>
                            <p class="text-sm font-bold text-slate-600">Click to select CSV file</p>
                        </label>
                    </div>
                </div>
                <div class="bg-emerald-50 p-4 rounded-xl border border-emerald-100">
                    <div class="flex justify-between items-center mb-2">
                        <p class="text-xs font-bold text-emerald-700 uppercase tracking-widest flex items-center gap-2">
                            <span class="material-symbols-outlined text-sm">assignment</span> CSV Format Requirement
                        </p>
                        <a href="<?= base_url('admin/courses/download-template') ?>"
                            class="text-[10px] font-bold text-emerald-700 hover:underline">Download Sample CSV</a>
                    </div>
                    <p class="text-[11px] text-emerald-600 font-medium leading-relaxed">
                        university_id, name, level, field, stem (YES/NO), duration_months, tuition_fee, credits,
                        intake_months (comma separated), notes, syllabus, career_outcomes
                    </p>
                </div>
            </div>
            <div class="px-8 py-6 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
                <button type="button" onclick="closeModal('bulkModal')"
                    class="px-6 py-2.5 text-slate-500 font-bold text-sm hover:text-slate-800 transition-colors">Cancel</button>
                <button type="submit"
                    class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-indigo-100 transition-all">Process
                    Upload</button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>