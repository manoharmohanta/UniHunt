<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="max-w-4xl mx-auto space-y-8" x-data="{ 
    logoPreview: '<?= base_url($settings['logo_url'] ?? '') ?>',
    faviconPreview: '<?= base_url($settings['favicon_url'] ?? '') ?>',
    tempVal: <?= esc($settings['ai_temperature'] ?? '0.7') ?>
}">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Site Settings</h1>
            <p class="text-sm text-slate-500">Manage your platform configuration and integrations.</p>
        </div>
        <button type="submit" form="settings-form"
            class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold shadow-sm transition-all active:scale-95 flex items-center gap-2">
            <span class="material-symbols-outlined text-[20px]">save</span>
            Save Settings
        </button>
    </div>

    <?php if (session()->has('message')): ?>
        <div class="p-4 rounded-2xl bg-green-50 text-green-700 border border-green-200 flex items-center gap-3">
            <span class="material-symbols-outlined shrink-0">check_circle</span>
            <span class="font-medium"><?= session('message') ?></span>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('admin/settings/save') ?>" method="post" enctype="multipart/form-data" id="settings-form"
        class="space-y-8">
        <?= csrf_field() ?>
        <?= honeypot_field() ?>

        <!-- General Identity -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8">
            <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-indigo-600">settings</span>
                General Identity
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-slate-700">Site Name</label>
                    <input type="text" name="site_name" value="<?= esc($settings['site_name'] ?? 'UniHunt') ?>"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none">
                </div>
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-slate-700">Contact Email</label>
                    <input type="email" name="contact_email"
                        value="<?= esc($settings['contact_email'] ?? 'support@unihunt.com') ?>"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none">
                </div>
                <div class="col-span-full space-y-2">
                    <div class="flex justify-between items-end mb-1">
                        <label class="text-sm font-bold text-slate-700">Meta Description</label>
                        <button type="button" onclick="generateMeta()" id="ai-gen-btn"
                            class="text-xs bg-indigo-50 text-indigo-600 px-3 py-1.5 rounded-lg hover:bg-indigo-100 transition-all font-bold flex items-center gap-1.5 border border-indigo-100">
                            <span class="material-symbols-outlined text-[16px]">auto_awesome</span>
                            AI Suggest
                        </button>
                    </div>
                    <textarea name="meta_description" rows="3"
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-2xl text-sm focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none leading-relaxed"><?= esc($settings['meta_description'] ?? '') ?></textarea>
                </div>
            </div>
        </div>

        <!-- Branding Assets -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8">
            <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-indigo-600">palette</span>
                Branding Assets
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-4">
                    <label class="block text-sm font-bold text-slate-700">Site Logo</label>
                    <div
                        class="relative group h-40 rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50 flex flex-col items-center justify-center p-4">
                        <template x-if="logoPreview">
                            <img :src="logoPreview" class="max-h-24 w-auto object-contain">
                        </template>
                        <template x-if="!logoPreview">
                            <div class="text-center">
                                <span class="material-symbols-outlined text-slate-400">image</span>
                                <p class="text-[10px] text-slate-400 font-bold uppercase mt-1">Logo</p>
                            </div>
                        </template>
                        <input type="file" name="logo"
                            @change="logoPreview = URL.createObjectURL($event.target.files[0])"
                            class="absolute inset-0 opacity-0 cursor-pointer">
                    </div>
                </div>

                <div class="space-y-4">
                    <label class="block text-sm font-bold text-slate-700">Favicon</label>
                    <div
                        class="relative group h-40 rounded-2xl border-2 border-dashed border-slate-200 bg-slate-50 flex flex-col items-center justify-center p-4">
                        <template x-if="faviconPreview">
                            <div
                                class="size-16 bg-white rounded-xl shadow-sm border border-slate-100 flex items-center justify-center p-2">
                                <img :src="faviconPreview" class="size-full object-contain">
                            </div>
                        </template>
                        <template x-if="!faviconPreview">
                            <div class="text-center">
                                <span class="material-symbols-outlined text-slate-400">add_to_home_screen</span>
                                <p class="text-[10px] text-slate-400 font-bold uppercase mt-1">Favicon</p>
                            </div>
                        </template>
                        <input type="file" name="favicon"
                            @change="faviconPreview = URL.createObjectURL($event.target.files[0])"
                            class="absolute inset-0 opacity-0 cursor-pointer">
                    </div>
                </div>
            </div>
        </div>

        <!-- AI Configuration -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8">
            <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-indigo-600">psychology</span>
                AI Configuration
            </h2>

            <div class="space-y-6">
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-slate-700">OpenRouter (Gemini) API Key</label>
                    <input type="password" name="openai_api_key" value="<?= esc($settings['openai_api_key'] ?? '') ?>"
                        placeholder="sk-..."
                        class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none font-mono">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-700">Model Identifier</label>
                        <input type="text" name="ai_model"
                            value="<?= esc($settings['ai_model'] ?? 'google/gemini-2.0-flash-001') ?>"
                            class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none">
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between items-center mb-1">
                            <label class="text-sm font-bold text-slate-700">AI Temperature</label>
                            <span class="text-xs font-bold font-mono text-indigo-600" x-text="tempVal"></span>
                        </div>
                        <input type="range" name="ai_temperature" min="0" max="2" step="0.1" x-model="tempVal"
                            class="w-full h-1.5 bg-slate-200 rounded-lg appearance-none cursor-pointer accent-indigo-600">
                    </div>
                </div>
            </div>
        </div>

        <!-- AI Tool Pricing -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8">
            <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-indigo-600">sell</span>
                AI Tool Pricing (Base Prices in INR)
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <?php foreach ($aiTools as $tool): ?>
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-slate-700"><?= esc($tool['name']) ?></label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-sm">₹</span>
                            <input type="number" step="0.01" name="ai_tool_prices[<?= $tool['id'] ?>]"
                                value="<?= esc($tool['price'] ?? '0.00') ?>"
                                class="w-full pl-8 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none font-mono">
                        </div>
                        <p class="text-[10px] text-slate-500 italic"><?= esc($tool['description'] ?? '') ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Ad Pricing Configuration -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8">
            <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-indigo-600">ads_click</span>
                Advertisement Pricing (Base Prices in INR)
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-slate-700">Per Day Cost</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-sm">₹</span>
                        <input type="number" step="0.01" name="ad_price_per_day"
                            value="<?= esc($settings['ad_price_per_day'] ?? '199.00') ?>"
                            class="w-full pl-8 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none font-mono">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-bold text-slate-700">Homepage Hero Area (Base)</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-sm">₹</span>
                        <input type="number" step="0.01" name="ad_price_home_top"
                            value="<?= esc($settings['ad_price_home_top'] ?? '120.00') ?>"
                            class="w-full pl-8 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none font-mono">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-bold text-slate-700">University Search Sidebar (Base)</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-sm">₹</span>
                        <input type="number" step="0.01" name="ad_price_university_sidebar"
                            value="<?= esc($settings['ad_price_university_sidebar'] ?? '150.00') ?>"
                            class="w-full pl-8 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none font-mono">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-bold text-slate-700">User Dashboard (Base)</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-sm">₹</span>
                        <input type="number" step="0.01" name="ad_price_dashboard_main"
                            value="<?= esc($settings['ad_price_dashboard_main'] ?? '99.00') ?>"
                            class="w-full pl-8 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none font-mono">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-bold text-slate-700">AI Result Pages (Base)</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold text-sm">₹</span>
                        <input type="number" step="0.01" name="ad_price_score_page"
                            value="<?= esc($settings['ad_price_score_page'] ?? '199.00') ?>"
                            class="w-full pl-8 pr-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none font-mono">
                    </div>
                </div>
            </div>
        </div>

        <!-- Payments & Checkout -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8">
            <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-indigo-600">payments</span>
                Payments & Checkout
            </h2>

            <div class="space-y-8">
                <div class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl border border-slate-100">
                    <div>
                        <span class="text-sm font-bold text-slate-800">Global Payment System</span>
                        <p class="text-[11px] text-slate-500">Enable or disable checkout platform-wide.</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer group">
                        <input type="checkbox" name="payments_enabled" value="1" <?= ($settings['payments_enabled'] ?? '0') == '1' ? 'checked' : '' ?> class="sr-only peer">
                        <div
                            class="w-11 h-6 bg-slate-200 rounded-full transition-all duration-300 peer peer-checked:bg-green-600 after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-full peer-checked:after:border-white">
                        </div>
                    </label>
                </div>

                <div class="pt-4 border-t border-slate-100">
                    <h3 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2">
                        <img src="https://razorpay.com/favicon.png" class="size-4">
                        Razorpay Configuration
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700">Test Key ID</label>
                            <input type="text" name="razorpay_key_id"
                                value="<?= esc($settings['razorpay_key_id'] ?? '') ?>" placeholder="rzp_test_..."
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none font-mono">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700">Test Key Secret</label>
                            <input type="password" name="razorpay_key_secret"
                                value="<?= esc($settings['razorpay_key_secret'] ?? '') ?>" placeholder="••••••••••••"
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none font-mono">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700">Live Key ID</label>
                            <input type="text" name="razorpay_live_key_id"
                                value="<?= esc($settings['razorpay_live_key_id'] ?? '') ?>" placeholder="rzp_live_..."
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none font-mono">
                        </div>
                        <div class="space-y-2">
                            <label class="block text-sm font-bold text-slate-700">Live Key Secret</label>
                            <input type="password" name="razorpay_live_key_secret"
                                value="<?= esc($settings['razorpay_live_key_secret'] ?? '') ?>"
                                placeholder="••••••••••••"
                                class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none font-mono">
                        </div>
                    </div>

                    <div class="mt-6">
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <div class="relative">
                                <input type="checkbox" name="razorpay_live_mode" value="1"
                                    <?= ($settings['razorpay_live_mode'] ?? '0') == '1' ? 'checked' : '' ?>
                                    class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-slate-200 rounded-full transition-all duration-300 peer peer-checked:bg-indigo-600 after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-full peer-checked:after:border-white">
                                </div>
                            </div>
                            <span class="text-sm font-bold text-slate-700">Enable Live Mode</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Integrations & Analytics -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8">
            <h2 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-indigo-600">analytics</span>
                Integrations & Analytics
            </h2>

            <div class="space-y-6">
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-slate-700">Google Tag Manager (GTM) ID</label>
                    <div class="flex items-center gap-3">
                        <input type="text" name="gtm_id" value="<?= esc($settings['gtm_id'] ?? '') ?>"
                            placeholder="GTM-XXXXXXX"
                            class="flex-1 px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 outline-none font-mono">
                    </div>
                    <p class="text-[10px] text-slate-500 italic">Enter your GTM Container ID to enable tracking across
                        all pages.</p>
                </div>
            </div>
        </div>

        <div class="flex justify-end pt-4">
            <button type="submit"
                class="px-10 py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-bold shadow-lg shadow-indigo-200 transition-all active:scale-95 flex items-center gap-2">
                <span class="material-symbols-outlined">save</span>
                Save All Changes
            </button>
        </div>
    </form>
</div>

<script>
    async function generateMeta() {
        const btn = document.getElementById('ai-gen-btn');
        const txt = document.querySelector('[name=meta_description]');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<span class="material-symbols-outlined animate-spin text-[16px]">sync</span> Generating...';
        btn.disabled = true;

        try {
            const formData = new FormData();
            const csrfTokenName = '<?= csrf_token() ?>';
            const csrfHash = document.querySelector('input[name="' + csrfTokenName + '"]').value;
            formData.append(csrfTokenName, csrfHash);

            const res = await fetch('<?= base_url('admin/settings/generate-ai') ?>', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            });
            const data = await res.json();

            if (data.description) {
                txt.value = data.description;
            } else {
                alert('Failed to generate description.');
            }
        } catch (e) {
            alert('An error occurred.');
        }

        btn.innerHTML = originalText;
        btn.disabled = false;
    }
</script>

<?= $this->endSection() ?>