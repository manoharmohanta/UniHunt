<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="mb-8">
    <div class="flex items-center gap-2 text-sm text-slate-500 mb-1">
        <a href="<?= base_url('admin/test-prep') ?>" class="hover:text-indigo-600 transition-colors">Exams</a>
        <span class="material-symbols-outlined text-[10px]">chevron_right</span>
        <a href="<?= base_url('admin/test-prep/modules/' . $exam['id']) ?>"
            class="hover:text-indigo-600 transition-colors"><?= esc($exam['name']) ?></a>
        <span class="material-symbols-outlined text-[10px]">chevron_right</span>
        <span><?= esc($module['name']) ?></span>
    </div>
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-slate-800">Topics / Questions</h2>
        <a href="<?= base_url('admin/test-prep/modules/' . $exam['id']) ?>"
            class="flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 rounded-xl text-slate-600 font-medium hover:bg-slate-50 transition-colors">
            <span class="material-symbols-outlined text-lg">arrow_back</span>
            Back to Modules
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    <!-- Create Question Form -->
    <div class="lg:col-span-5">
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm sticky top-24">
            <div class="p-6 border-b border-subtle">
                <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                    <span class="material-symbols-outlined text-indigo-500">add_task</span>
                    Add New Question / Topic
                </h3>
            </div>

            <form action="<?= base_url('admin/test-prep/store-question') ?>" method="post" enctype="multipart/form-data"
                class="p-6 space-y-5">
                <input type="hidden" name="module_id" value="<?= esc($module['id']) ?>">
                <?= csrf_field() ?>

                <div>
                    <label for="question_text" class="block text-sm font-semibold text-slate-700 mb-2">Question or
                        Topic</label>
                    <textarea name="question_text" id="question_text" rows="4"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none resize-none"
                        placeholder="Enter the question, topic, or prompt here..." required></textarea>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="type" class="block text-sm font-semibold text-slate-700 mb-2">Type</label>
                        <select name="type" id="type"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none appearance-none bg-white">
                            <option value="mcq">Multiple Choice</option>
                            <option value="essay">Essay / Long Answer</option>
                            <option value="speaking_prompt">Speaking Prompt</option>
                            <option value="fill_in_blank">Fill in the Blank</option>
                            <option value="true_false">True/False</option>
                        </select>
                    </div>
                </div>

                <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                    <label for="media_file" class="block text-sm font-semibold text-slate-700 mb-2">Attachment
                        (Optional)</label>
                    <input type="file" name="media_file" id="media_file" class="block w-full text-sm text-slate-500
                               file:mr-4 file:py-2 file:px-4
                               file:rounded-full file:border-0
                               file:text-sm file:font-semibold
                               file:bg-indigo-50 file:text-indigo-700
                               hover:file:bg-indigo-100 mb-1" accept="audio/*,image/*">
                    <p class="text-xs text-slate-400">Image for Writing Task 1, etc.</p>
                </div>

                <!-- Options Section (Visual toggle based on type could be added later, currently always visible) -->
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Options (For MCQ only)</label>
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <span
                                class="flex-shrink-0 size-8 rounded-lg bg-slate-100 flex items-center justify-center font-bold text-slate-500 text-sm">A</span>
                            <input type="text" name="options[A]"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 transition-all outline-none"
                                placeholder="Option A">
                        </div>
                        <div class="flex items-center gap-3">
                            <span
                                class="flex-shrink-0 size-8 rounded-lg bg-slate-100 flex items-center justify-center font-bold text-slate-500 text-sm">B</span>
                            <input type="text" name="options[B]"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 transition-all outline-none"
                                placeholder="Option B">
                        </div>
                        <div class="flex items-center gap-3">
                            <span
                                class="flex-shrink-0 size-8 rounded-lg bg-slate-100 flex items-center justify-center font-bold text-slate-500 text-sm">C</span>
                            <input type="text" name="options[C]"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 transition-all outline-none"
                                placeholder="Option C">
                        </div>
                        <div class="flex items-center gap-3">
                            <span
                                class="flex-shrink-0 size-8 rounded-lg bg-slate-100 flex items-center justify-center font-bold text-slate-500 text-sm">D</span>
                            <input type="text" name="options[D]"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 transition-all outline-none"
                                placeholder="Option D">
                        </div>
                    </div>
                </div>

                <div>
                    <label for="correct_answer" class="block text-sm font-semibold text-slate-700 mb-2">Answer /
                        Notes</label>
                    <input type="text" name="correct_answer" id="correct_answer"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-emerald-500 focus:ring-4 focus:ring-emerald-500/10 transition-all outline-none"
                        placeholder="Correct option or model answer notes" required>
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="w-full py-3 rounded-xl bg-indigo-600 text-white font-bold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200">
                        Save
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Existing Questions List -->
    <div class="lg:col-span-7">
        <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
            <span class="material-symbols-outlined text-slate-400">list</span>
            Existing Topics / Questions (<?= count($questions) ?>)
        </h3>

        <div class="space-y-4">
            <?php if (!empty($questions)): ?>
                <?php foreach ($questions as $q): ?>
                    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
                        <div class="p-5">
                            <div class="flex items-start justify-between gap-4 mb-3">
                                <div class="flex items-center gap-2">
                                    <span
                                        class="px-2.5 py-1 rounded-md bg-slate-100 text-slate-600 text-xs font-bold uppercase tracking-wide">
                                        <?= esc(str_replace('_', ' ', $q['type'])) ?>
                                    </span>
                                    <?php if (!empty($q['media_path'])): ?>
                                        <span
                                            class="px-2.5 py-1 rounded-md bg-amber-50 text-amber-600 text-xs font-bold uppercase tracking-wide flex items-center gap-1">
                                            <span class="material-symbols-outlined text-[14px]">attachment</span>
                                            Media
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <div class="flex items-center gap-2">
                                    <a href="<?= base_url('admin/test-prep/delete-question/' . $q['id']) ?>"
                                        onclick="return confirm('Are you sure you want to delete this question?')"
                                        class="size-8 rounded-lg bg-rose-50 text-rose-500 flex items-center justify-center hover:bg-rose-500 hover:text-white transition-all">
                                        <span class="material-symbols-outlined text-sm">delete</span>
                                    </a>
                                </div>
                            </div>

                            <p class="text-slate-800 font-medium mb-3">
                                <?= nl2br(esc($q['question_text'])) ?>
                            </p>

                            <div class="flex flex-wrap gap-2 text-sm">
                                <?php if (!empty($q['media_path'])): ?>
                                    <a href="<?= base_url($q['media_path']) ?>" target="_blank"
                                        class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg border border-slate-200 text-indigo-600 text-xs font-medium hover:bg-indigo-50 transition-colors">
                                        <span class="material-symbols-outlined text-sm">play_circle</span>
                                        View/Play Media
                                    </a>
                                <?php endif; ?>

                                <div
                                    class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg border border-emerald-100 bg-emerald-50 text-emerald-700 text-xs font-medium">
                                    <span class="material-symbols-outlined text-sm">check_circle</span>
                                    Answer/Notes: <?= esc($q['correct_answer']) ?>
                                </div>
                            </div>
                        </div>

                        <?php if ($q['type'] === 'mcq' && !empty($q['options'])): ?>
                            <?php
                            $opts = $q['options'];
                            if (is_object($opts)) {
                                $opts = (array) $opts;
                            }
                            if (is_array($opts)):
                                ?>
                                <div class="bg-slate-50 px-5 py-3 border-t border-slate-100">
                                    <div class="grid grid-cols-2 gap-2 text-sm">
                                        <?php foreach ($opts as $key => $val): ?>
                                            <?php if (!empty($val)): ?>
                                                <div class="flex items-center gap-2 text-slate-600">
                                                    <span class="font-bold text-slate-400"><?= esc($key) ?>.</span>
                                                    <span><?= esc($val) ?></span>
                                                </div>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="py-12 text-center bg-white rounded-2xl border border-dashed border-slate-300">
                    <div
                        class="inline-flex items-center justify-center size-12 rounded-full bg-slate-50 text-slate-400 mb-3">
                        <span class="material-symbols-outlined text-2xl">post_add</span>
                    </div>
                    <p class="text-slate-500 font-medium">No topics added yet.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>