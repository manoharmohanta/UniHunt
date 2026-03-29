<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="max-w-4xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="<?= base_url('admin/ads') ?>"
            class="p-2 bg-white border border-slate-200 rounded-lg hover:bg-slate-50 transition">
            <span class="material-symbols-outlined text-slate-600">arrow_back</span>
        </a>
        <h1 class="text-xl font-bold text-slate-800">
            <?= isset($ad) ? 'Edit Ad' : 'Create New Ad' ?>
        </h1>
    </div>

    <form action="<?= isset($ad) ? base_url('admin/ads/update/' . $ad['id']) : base_url('admin/ads/store') ?>"
        method="post" enctype="multipart/form-data"
        class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden p-6 md:p-8">
        <?= csrf_field() ?>

        <!-- General Info -->
        <h2 class="text-sm uppercase tracking-wide text-slate-500 font-bold mb-4 border-b pb-2">Campaign Details</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Internal Campaign Title</label>
                <input type="text" name="title" value="<?= esc($ad['title'] ?? '') ?>" required
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500/20 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                <select name="status"
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500/20 outline-none">
                    <option value="active" <?= ($ad['status'] ?? '') == 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="paused" <?= ($ad['status'] ?? '') == 'paused' ? 'selected' : '' ?>>Paused</option>
                    <option value="archived" <?= ($ad['status'] ?? '') == 'archived' ? 'selected' : '' ?>>Archived
                    </option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Source Type</label>
                <select id="source_type" name="source_type"
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500/20 outline-none"
                    onchange="toggleSourceFields()">
                    <option value="network" <?= ($ad['source_type'] ?? '') == 'network' ? 'selected' : '' ?>>Ad Network
                        (Google/MS)</option>
                    <option value="direct" <?= ($ad['source_type'] ?? '') == 'direct' ? 'selected' : '' ?>>Direct /
                        Internal Brand</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Ad Format</label>
                <select name="format"
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500/20 outline-none">
                    <option value="banner" <?= ($ad['format'] ?? '') == 'banner' ? 'selected' : '' ?>>Banner Display
                    </option>
                    <option value="native" <?= ($ad['format'] ?? '') == 'native' ? 'selected' : '' ?>>Native Card</option>
                    <option value="rewarded" <?= ($ad['format'] ?? '') == 'rewarded' ? 'selected' : '' ?>>Rewarded
                        Video/Action</option>
                    <option value="interstitial" <?= ($ad['format'] ?? '') == 'interstitial' ? 'selected' : '' ?>>
                        Interstitial (Popup)</option>
                </select>
            </div>
        </div>

        <!-- Dynamic Fields: Network -->
        <div id="network_fields" class="mb-6 <?= ($ad['source_type'] ?? 'network') == 'network' ? '' : 'hidden' ?>">
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-1">Network Name</label>
                <input type="text" name="network_name" value="<?= esc($ad['network_name'] ?? '') ?>"
                    placeholder="e.g. Google Ad Manager"
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500/20 outline-none">
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Ad Script / Tag Code</label>
                <textarea name="ad_content" rows="4"
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500/20 outline-none font-mono text-xs"><?= ($ad['source_type'] ?? '') == 'network' ? esc($ad['ad_content'] ?? '') : '' ?></textarea>
                <p class="text-xs text-slate-500 mt-1">Paste the Javascript or IFRAME code provided by the ad network.
                </p>
            </div>
        </div>

        <!-- Dynamic Fields: Direct -->
        <div id="direct_fields" class="mb-6 <?= ($ad['source_type'] ?? '') == 'direct' ? '' : 'hidden' ?>">
            <?php
            $content = json_decode($ad['ad_content'] ?? '{}', true);
            ?>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Ad Image</label>
                    <input type="file" name="ad_image" accept="image/*"
                        class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    <?php if (!empty($content['image_url'])): ?>
                        <div class="mt-2">
                            <img src="<?= base_url($content['image_url']) ?>" alt="Ad Preview"
                                class="h-24 w-auto rounded border border-slate-200">
                        </div>
                    <?php endif; ?>
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Destination URL</label>
                    <input type="url" name="link_url" value="<?= esc($content['link_url'] ?? '') ?>"
                        placeholder="https://"
                        class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500/20 outline-none">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Call To Action (Button Text)</label>
                <input type="text" name="cta_text" value="<?= esc($content['cta_text'] ?? 'Learn More') ?>"
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500/20 outline-none">
            </div>
        </div>

        <!-- Placement & Targeting -->
        <h2 class="text-sm uppercase tracking-wide text-slate-500 font-bold mb-4 border-b pb-2 pt-4">Placement &
            Targeting</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Primary Placement</label>
                <select name="placement"
                    class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-indigo-500/20 outline-none">
                    <option value="home_top" <?= ($ad['placement'] ?? '') == 'home_top' ? 'selected' : '' ?>>Home Page Top
                    </option>
                    <option value="dashboard_sidebar" <?= ($ad['placement'] ?? '') == 'dashboard_sidebar' ? 'selected' : '' ?>>Student Dashboard Sidebar</option>
                    <option value="course_list" <?= ($ad['placement'] ?? '') == 'course_list' ? 'selected' : '' ?>>Course
                        Listing Page</option>
                    <option value="score_page" <?= ($ad['placement'] ?? '') == 'score_page' ? 'selected' : '' ?>>
                        Score/Result Page</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Target Audience</label>
                <?php $targeting = json_decode($ad['targeting'] ?? '{}', true); ?>
                <div class="flex flex-col gap-2 p-3 border border-slate-300 rounded-lg">
                    <label class="inline-flex items-center gap-2">
                        <input type="checkbox" name="target_role[]" value="student" <?= in_array('student', $targeting['role'] ?? []) ? 'checked' : '' ?> class="rounded text-indigo-600
                        focus:ring-indigo-500">
                        <span class="text-sm text-slate-700">Students</span>
                    </label>
                    <label class="inline-flex items-center gap-2">
                        <input type="checkbox" name="target_role[]" value="guest" <?= in_array('guest', $targeting['role'] ?? []) ? 'checked' : '' ?> class="rounded text-indigo-600
                        focus:ring-indigo-500">
                        <span class="text-sm text-slate-700">Guests (Unauthenticated)</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-6 border-t border-slate-200">
            <button type="submit"
                class="px-6 py-2 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/30">
                <?= isset($ad) ? 'Update Campaign' : 'Publish Campaign' ?>
            </button>
        </div>

    </form>
</div>

<script>
    function toggleSourceFields() {
        const type = document.getElementById('source_type').value;
        if (type === 'network') {
            document.getElementById('network_fields').classList.remove('hidden');
            document.getElementById('direct_fields').classList.add('hidden');
        } else {
            document.getElementById('network_fields').classList.add('hidden');
            document.getElementById('direct_fields').classList.remove('hidden');
        }
    }
</script>

<?= $this->endSection() ?>