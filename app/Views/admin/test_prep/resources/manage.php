<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<?php
$slug = isset($module['slug']) ? strtolower($module['slug']) : '';
$isWriting = strpos($slug, 'writing') !== false;
$isSpeaking = strpos($slug, 'speaking') !== false;
$isTopicBased = $isWriting || $isSpeaking;
?>
<div class="mb-8">
    <div class="flex items-center gap-2 text-sm text-slate-500 mb-1">
        <a href="<?= base_url('admin/test-prep') ?>" class="hover:text-indigo-600 transition-colors">Exams</a>
        <span class="material-symbols-outlined text-[10px]">chevron_right</span>
        <a href="<?= base_url('admin/test-prep/modules/' . $exam['id']) ?>"
            class="hover:text-indigo-600 transition-colors">
            <?= esc($exam['name']) ?>
        </a>
        <span class="material-symbols-outlined text-[10px]">chevron_right</span>
        <a href="<?= base_url('admin/test-prep/resources/' . $module['id']) ?>"
            class="hover:text-indigo-600 transition-colors">
            <?= esc($module['name']) ?>
        </a>
    </div>

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">
                <?= $isTopicBased ? 'Topic Details' : esc($resource['title']) ?>
            </h2>
            <p class="text-slate-500 text-sm mt-1">
                <?= $isTopicBased ? 'View topic content' : 'Manage content and questions' ?>
            </p>
        </div>
        <a href="<?= base_url('admin/test-prep/resources/' . $module['id']) ?>"
            class="flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 rounded-xl text-slate-600 font-medium hover:bg-slate-50 transition-colors">
            <span class="material-symbols-outlined text-lg">arrow_back</span>
            Back to Resources
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    <!-- Content Preview & Question Form -->
    <div class="<?= $isTopicBased ? 'lg:col-span-12' : 'lg:col-span-5' ?>">
        <!-- Resource Content -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm mb-6 p-6">
            <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-indigo-500">source</span>
                <?= $isTopicBased ? 'Topic Details' : 'Resource Content' ?>
            </h3>

            <?php if (!empty($resource['media_path'])): ?>
                <?php
                $ext = pathinfo($resource['media_path'], PATHINFO_EXTENSION);
                $isImage = in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                ?>
                <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                    <?php if ($isImage): ?>
                        <img src="<?= base_url($resource['media_path']) ?>" alt="Resource Image"
                            class="w-full h-auto rounded-lg max-h-96 object-contain">
                    <?php else: ?>
                        <audio controls class="w-full">
                            <source src="<?= base_url($resource['media_path']) ?>" type="audio/mpeg">
                            Your browser does not support the audio element.
                        </audio>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($resource['content'])): ?>
                <div
                    class="bg-slate-50 p-4 rounded-xl border border-slate-100 max-h-60 overflow-y-auto text-sm text-slate-700 leading-relaxed">
                    <?= nl2br(esc($resource['content'])) ?>
                </div>
            <?php endif; ?>
        </div>

        <?php if (!$isTopicBased): ?>
            <!-- Add Question Form -->
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm sticky top-24">
                <div class="p-6 border-b border-subtle">
                    <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <span class="material-symbols-outlined text-indigo-500">add_task</span>
                        Add Question to Resource
                    </h3>
                </div>

                <form action="<?= base_url('admin/test-prep/store-question') ?>" method="post" class="p-6 space-y-5">
                    <input type="hidden" name="module_id" value="<?= esc($module['id']) ?>">
                    <input type="hidden" name="resource_id" value="<?= esc($resource['id']) ?>">
                    <?= csrf_field() ?>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Question Text</label>
                        <textarea name="question_text" rows="3"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-500/10 transition-all outline-none resize-none"
                            placeholder="Enter question..." required></textarea>
                    </div>

                    <div x-data="{ qType: 'mcq' }">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Type</label>
                                <select name="type" x-model="qType"
                                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 outline-none bg-white">
                                    <option value="mcq">Multiple Choice</option>
                                    <option value="fill_in_blank">Fill in the Blank</option>
                                    <option value="true_false">True/False</option>
                                </select>
                            </div>
                        </div>

                        <div x-show="qType === 'mcq'" class="mt-5">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Options</label>
                            <div class="space-y-2">
                                <div class="flex items-center gap-2">
                                    <span
                                        class="size-8 rounded bg-slate-100 flex items-center justify-center font-bold text-slate-500 text-xs">A</span>
                                    <input type="text" name="options[A]"
                                        class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm focus:border-indigo-500 outline-none"
                                        placeholder="Option A">
                                </div>
                                <div class="flex items-center gap-2">
                                    <span
                                        class="size-8 rounded bg-slate-100 flex items-center justify-center font-bold text-slate-500 text-xs">B</span>
                                    <input type="text" name="options[B]"
                                        class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm focus:border-indigo-500 outline-none"
                                        placeholder="Option B">
                                </div>
                                <div class="flex items-center gap-2">
                                    <span
                                        class="size-8 rounded bg-slate-100 flex items-center justify-center font-bold text-slate-500 text-xs">C</span>
                                    <input type="text" name="options[C]"
                                        class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm focus:border-indigo-500 outline-none"
                                        placeholder="Option C">
                                </div>
                                <div class="flex items-center gap-2">
                                    <span
                                        class="size-8 rounded bg-slate-100 flex items-center justify-center font-bold text-slate-500 text-xs">D</span>
                                    <input type="text" name="options[D]"
                                        class="w-full px-3 py-2 rounded-lg border border-slate-200 text-sm focus:border-indigo-500 outline-none"
                                        placeholder="Option D">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Correct Answer</label>
                        <input type="text" name="correct_answer"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/10 outline-none"
                            placeholder="e.g. A" required>
                    </div>

                    <button type="submit"
                        class="w-full py-3 rounded-xl bg-indigo-600 text-white font-bold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200">
                        Add Question
                    </button>
                </form>
            </div>
        <?php endif; ?>
    </div>

    <?php if (!$isTopicBased): ?>
        <!-- Questions List -->
        <div class="lg:col-span-7">
            <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined text-slate-400">list</span>
                Questions in this Resource (
                <?= count($questions) ?>)
            </h3>

            <div class="space-y-4">
                <?php if (!empty($questions)): ?>
                    <?php foreach ($questions as $q): ?>
                        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
                            <div class="p-5">
                                <div class="flex items-start justify-between gap-4 mb-2">
                                    <span
                                        class="px-2.5 py-1 rounded-md bg-slate-100 text-slate-600 text-xs font-bold uppercase tracking-wide">
                                        <?= esc(str_replace('_', ' ', $q['type'])) ?>
                                    </span>
                                    <a href="<?= base_url('admin/test-prep/delete-question/' . $q['id']) ?>"
                                        onclick="return confirm('Delete question?')" class="text-rose-400 hover:text-rose-600">
                                        <span class="material-symbols-outlined">delete</span>
                                    </a>
                                </div>

                                <p class="text-slate-800 font-medium mb-3">
                                    <?= nl2br(esc($q['question_text'])) ?>
                                </p>

                                <div
                                    class="inline-flex items-center gap-2 px-3 py-1.5 rounded-lg border border-emerald-100 bg-emerald-50 text-emerald-700 text-xs font-medium">
                                    <span class="material-symbols-outlined text-sm">check_circle</span>
                                    Correct:
                                    <?= esc($q['correct_answer']) ?>
                                </div>
                            </div>

                            <?php if ($q['type'] === 'mcq' && !empty($q['options'])): ?>
                                <?php
                                $opts = $q['options'];
                                // Ensure it's an array (CodeIgniter's JsonCast might return stdClass)
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
                                                        <span class="font-bold text-slate-400">
                                                            <?= esc($key) ?>.
                                                        </span>
                                                        <span>
                                                            <?= esc($val) ?>
                                                        </span>
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
                        <p class="text-slate-500">No questions added to this resource yet.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>