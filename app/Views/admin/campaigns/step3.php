<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="max-w-6xl mx-auto">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <a href="<?= base_url('admin/campaigns/step2') ?>"
                class="text-slate-500 hover:text-indigo-600 flex items-center gap-2 mb-2 transition-colors text-sm font-medium">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                Back to Audience Selection
            </a>
            <h2 class="text-3xl font-bold text-slate-800 tracking-tight">Preview Campaign</h2>
            <p class="text-slate-500 mt-1">Review the AI-generated content before queuing.</p>
        </div>
        <div
            class="hidden md:flex items-center gap-2 px-3 py-1.5 bg-green-50 border border-green-100 rounded-lg text-green-700 text-xs font-semibold">
            <span class="material-symbols-outlined text-[18px]">check_circle</span>
            <span>Ready for Review</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Left Column: Email Preview -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center justify-between">
                    <h3 class="font-semibold text-slate-800">Email Preview</h3>
                    <a href="<?= base_url('admin/campaigns/step3?regenerate=1') ?>"
                        class="text-xs font-medium text-indigo-600 hover:text-indigo-800 flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">refresh</span>
                        Regenerate Content
                    </a>
                </div>

                <div class="p-6">
                    <div class="mb-4">
                        <label
                            class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1">Subject</label>
                        <div class="text-lg font-medium text-slate-900 border-b pb-2">
                            <?= esc($preview_data['email_subject'] ?? 'No Subject') ?>
                        </div>
                    </div>

                    <div class="border rounded-lg p-4 bg-slate-50 min-h-[400px]">
                        <!-- Render raw HTML for preview. In a real app, use an iframe to isolate styles. -->
                        <div class="prose max-w-none bg-white p-4 rounded shadow-sm">
                            <?= $preview_data['full_html_preview'] ?? '' ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden p-6">
                <h3 class="font-semibold text-slate-800 mb-2">Plain Text Version</h3>
                <pre
                    class="bg-slate-50 p-4 rounded text-xs text-slate-600 overflow-x-auto whitespace-pre-wrap font-mono"><?= esc($preview_data['email_body_text'] ?? '') ?></pre>
            </div>
        </div>

        <!-- Right Column: Final Actions -->
        <div class="space-y-6">
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                <h3 class="font-semibold text-slate-800 mb-4">Campaign Summary</h3>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between py-2 border-b border-slate-50">
                        <span class="text-slate-500">Recipients</span>
                        <span class="font-medium">
                            <?= count($wizard_data['recipients'] ?? []) ?> Selected
                        </span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-slate-50">
                        <span class="text-slate-500">Priority</span>
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            <?= esc($preview_data['priority'] ?? 'medium') ?>
                        </span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-slate-50">
                        <span class="text-slate-500">Scheduled For</span>
                        <span class="font-medium">
                            <?= esc($preview_data['scheduled_at'] ?? 'Now') ?>
                        </span>
                    </div>

                    <div class="pt-2">
                        <h4 class="text-xs font-semibold text-slate-500 mb-2">Selected Recipients:</h4>
                        <div class="max-h-32 overflow-y-auto text-xs text-slate-600 bg-slate-50 p-2 rounded">
                            <?php foreach (($wizard_data['recipients'] ?? []) as $email): ?>
                                <div class="truncate">
                                    <?= esc($email) ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

            <form action="<?= base_url('admin/campaigns/confirm') ?>" method="post" x-data="{ submitting: false }"
                @submit="submitting = true">
                <?= csrf_field() ?>
                <div class="bg-indigo-900 rounded-xl shadow-lg overflow-hidden text-white p-6 relative">
                    <div class="absolute top-0 right-0 p-4 opacity-10">
                        <span class="material-symbols-outlined text-[100px]">send</span>
                    </div>
                    <h3 class="text-lg font-bold mb-2 relative z-10">Launch Campaign</h3>
                    <p class="text-indigo-200 text-sm mb-6 relative z-10">
                        Ready to queue emails? This will schedule them for delivery.
                    </p>
                    <button type="submit" :disabled="submitting"
                        class="w-full py-3 px-4 bg-white text-indigo-900 font-bold rounded-lg hover:bg-indigo-50 transition-colors shadow-md flex items-center justify-center gap-2 relative z-10 disabled:opacity-70 disabled:cursor-not-allowed">
                        <span x-show="!submitting">Confirm & Queue</span>
                        <span x-show="submitting" class="material-symbols-outlined animate-spin">refresh</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>