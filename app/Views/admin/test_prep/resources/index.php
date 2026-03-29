<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<?php
$slug = isset($module['slug']) ? strtolower($module['slug']) : '';
$isWriting = strpos($slug, 'writing') !== false;
$isSpeaking = strpos($slug, 'speaking') !== false;
$isQuant = strpos($slug, 'quant') !== false || strpos($slug, 'math') !== false || strpos($slug, 'reasoning') !== false;
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
        <span>
            <?= esc($module['name']) ?>
        </span>
    </div>

    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Resources</h2>
            <p class="text-slate-500 text-sm mt-1">
                <?php if ($isTopicBased): ?>
                    Manage Topics for <?= $isWriting ? 'Writing' : 'Speaking' ?>
                <?php else: ?>
                    Manage Audio Tracks or Reading Passages
                <?php endif; ?>
            </p>
        </div>
        <div class="flex gap-2">
            <a href="<?= base_url('admin/test-prep/modules/' . $exam['id']) ?>"
                class="flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 rounded-xl text-slate-600 font-medium hover:bg-slate-50 transition-colors">
                <span class="material-symbols-outlined text-lg">arrow_back</span>
                Back
            </a>
            <button onclick="openModal('addResourceModal')"
                class="flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-200">
                <span class="material-symbols-outlined">add</span>
                Add Resource
            </button>
        </div>
    </div>
</div>

<!-- Resource List -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php if (!empty($resources)): ?>
        <?php foreach ($resources as $res): ?>
            <div class="group bg-white rounded-2xl p-5 border border-slate-200 shadow-sm hover:shadow-md transition-all">
                <div class="flex items-start justify-between mb-3">
                    <div class="size-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <span class="material-symbols-outlined">
                            <?= !empty($res['media_path']) ? 'headphones' : 'description' ?>
                        </span>
                    </div>
                </div>

                <h3 class="text-lg font-bold text-slate-800 mb-1 line-clamp-1" title="<?= esc($res['title']) ?>">
                    <?= esc($res['title']) ?>
                </h3>
                <p class="text-slate-400 text-xs mb-4">
                    <?php if ($isTopicBased): ?>
                        Topic
                    <?php else: ?>
                        <?= !empty($res['media_path']) ? 'Audio Track' : 'Reading Passage' ?>
                    <?php endif; ?>
                </p>

                <div class="flex gap-2">
                    <?php if (!$isTopicBased): ?>
                        <a href="<?= base_url('admin/test-prep/manage-resource/' . $res['id']) ?>"
                            class="flex-1 flex items-center justify-center gap-2 py-2 rounded-lg bg-slate-900 text-white text-sm font-medium hover:bg-indigo-600 transition-colors">
                            Manage Questions
                        </a>
                    <?php endif; ?>
                    <a href="<?= base_url('admin/test-prep/delete-resource/' . $res['id']) ?>"
                        onclick="return confirm('Delete this resource? All linked questions will be lost.')"
                        class="<?= $isTopicBased ? 'w-full' : '' ?> flex items-center justify-center px-3 py-2 rounded-lg bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-lg">delete</span>
                        <?php if ($isTopicBased): ?>
                            <span class="ml-2 font-medium">Delete</span>
                        <?php endif; ?>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-span-full py-12 text-center bg-white rounded-2xl border border-dashed border-slate-300">
            <div class="inline-flex items-center justify-center size-16 rounded-full bg-slate-50 text-slate-400 mb-4">
                <span class="material-symbols-outlined text-3xl">playlist_remove</span>
            </div>
            <h3 class="text-lg font-medium text-slate-900 mb-1">No Resources Found</h3>
            <p class="text-slate-500">Add an audio track or reading text to start adding questions.</p>
        </div>
    <?php endif; ?>
</div>

<!-- Add Resource Modal -->
<div id="addResourceModal" class="modal-overlay">
    <div class="modal-content-tw bg-white rounded-2xl shadow-2xl w-full max-w-lg mx-4">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-lg font-bold text-slate-800">Add New Resource</h3>
            <button onclick="closeModal('addResourceModal')" class="text-slate-400 hover:text-slate-600">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form action="<?= base_url('admin/test-prep/store-resource') ?>" method="post" enctype="multipart/form-data">
            <div class="p-6 space-y-4">
                <input type="hidden" name="module_id" value="<?= esc($module['id']) ?>">
                <?= csrf_field() ?>

                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Title</label>
                    <div class="flex gap-2">
                        <input type="text" name="title" id="resourceTitle"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 outline-none"
                            placeholder="e.g. <?= $isWriting ? 'Writing Task 1' : ($isSpeaking ? 'Speaking Part 1' : ($isQuant ? 'Algebra Practice Set 1' : 'Listening Practice 1')) ?>"
                            required>

                        <button type="button" onclick="generateAiTopic('<?= $slug ?>')"
                            class="px-4 py-2.5 bg-indigo-50 text-indigo-600 rounded-xl font-bold hover:bg-indigo-100 transition-colors flex items-center gap-2 whitespace-nowrap">
                            <span class="material-symbols-outlined text-lg">auto_awesome</span>
                            Generate
                        </button>
                    </div>
                </div>

                <div x-data="{ type: '<?= $isQuant ? 'image' : ($isTopicBased ? 'text' : 'audio') ?>' }">
                    <?php if (!$isTopicBased): ?>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Resource Type</label>
                        <div class="flex gap-4 mb-4">
                            <?php if (!$isQuant): ?>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="res_type" value="audio" x-model="type"
                                        class="text-indigo-600 focus:ring-indigo-500">
                                    <span class="text-sm text-slate-700">Audio File</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="res_type" value="text" x-model="type"
                                        class="text-indigo-600 focus:ring-indigo-500">
                                    <span class="text-sm text-slate-700">Reading Passage</span>
                                </label>
                            <?php endif; ?>

                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="radio" name="res_type" value="image" x-model="type"
                                    class="text-indigo-600 focus:ring-indigo-500">
                                <span class="text-sm text-slate-700">Image / Chart</span>
                            </label>
                        </div>
                    <?php else: ?>
                        <input type="hidden" name="res_type" value="text">
                    <?php endif; ?>

                    <div x-show="type === 'audio'">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Upload Audio (MP3)</label>
                        <input type="file" name="media_file"
                            class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                            accept="audio/*">
                    </div>

                    <div x-show="type === 'image'">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Upload Image (JPG, PNG)</label>
                        <input type="file" name="media_file"
                            class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100"
                            accept="image/*">
                    </div>

                    <?php if (!$isTopicBased && !$isQuant): ?>
                        <div x-show="type === 'text'">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">
                                Passage Content
                            </label>
                            <textarea name="content" rows="6"
                                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/10 outline-none resize-none"
                                placeholder="Paste reading text here..."></textarea>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="p-6 border-t border-slate-100 flex justify-end gap-3 bg-slate-50/50 rounded-b-2xl">
                <button type="button" onclick="closeModal('addResourceModal')"
                    class="px-5 py-2.5 rounded-xl text-slate-600 font-medium hover:bg-slate-100 transition-colors">Cancel</button>
                <button type="submit"
                    class="px-5 py-2.5 rounded-xl bg-indigo-600 text-white font-bold hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-200">Save
                    Resource</button>
            </div>
        </form>
    </div>
</div>
<script>
    function generateAiTopic(type) {
        const btn = event.currentTarget;
        const originalContent = btn.innerHTML;
        const input = document.getElementById('resourceTitle');

        // Get CSRF
        const csrfName = '<?= csrf_token() ?>';
        const csrfHash = document.querySelector(`input[name="${csrfName}"]`).value;

        btn.disabled = true;
        btn.innerHTML = '<span class="material-symbols-outlined animate-spin text-lg">refresh</span> Generating...';

        const params = new URLSearchParams();
        params.append('type', type);
        params.append(csrfName, csrfHash);

        fetch('<?= base_url('admin/test-prep/ai-suggest-topic') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: params.toString()
        })
            .then(response => response.json())
            .then(data => {
                if (data.topic) {
                    input.value = data.topic;
                } else {
                    alert(data.error || 'Failed to generate topic');
                }
            })
            .catch(err => {
                console.error(err);
                alert('Error connecting to AI service');
            })
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = originalContent;
            });
    }
</script>
<?= $this->endSection() ?>