<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="max-w-5xl mx-auto">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <a href="<?= base_url('admin/campaigns') ?>"
                class="text-slate-500 hover:text-indigo-600 flex items-center gap-2 mb-2 transition-colors text-sm font-medium">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                Back to Campaigns
            </a>
            <h2 class="text-3xl font-bold text-slate-800 tracking-tight">New Campaign</h2>
            <p class="text-slate-500 mt-1">Configure your AI-driven email campaign parameters.</p>
        </div>
        <div
            class="hidden md:flex items-center gap-2 px-3 py-1.5 bg-indigo-50 border border-indigo-100 rounded-lg text-indigo-700 text-xs font-semibold">
            <span class="material-symbols-outlined text-[18px]">auto_awesome</span>
            <span>AI Powered Engine</span>
        </div>
    </div>

    <form action="<?= base_url('admin/campaigns/step1') ?>" method="post" class="grid grid-cols-1 lg:grid-cols-3 gap-8" x-data="{ submitting: false }" @submit="submitting = true">
        <?= csrf_field() ?>

        <!-- Left Column: Main Configuration -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Core Settings Card -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[20px]">tune</span>
                    </div>
                    <h3 class="font-semibold text-slate-800">Step 1: Core Configuration</h3>
                </div>
                
                <div class="p-6 space-y-6">
                    <!-- Email Type -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Campaign Type</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <label class="cursor-pointer relative">
                                <input type="radio" name="type" value="Newsletter" class="peer sr-only" <?= ($saved_data['type'] ?? '') == 'Newsletter' ? 'checked' : 'checked' ?>>
                                <div class="p-4 rounded-xl border border-slate-200 hover:border-indigo-300 peer-checked:border-indigo-600 peer-checked:bg-indigo-50 transition-all">
                                    <div class="flex items-center gap-3 mb-1">
                                        <span class="material-symbols-outlined text-slate-400 peer-checked:text-indigo-600">newspaper</span>
                                        <span class="font-medium text-slate-900 peer-checked:text-indigo-900">Newsletter</span>
                                    </div>
                                    <p class="text-xs text-slate-500">Regular updates and news</p>
                                </div>
                            </label>
                            
                            <label class="cursor-pointer relative">
                                <input type="radio" name="type" value="Promotional" class="peer sr-only" <?= ($saved_data['type'] ?? '') == 'Promotional' ? 'checked' : '' ?>>
                                <div class="p-4 rounded-xl border border-slate-200 hover:border-indigo-300 peer-checked:border-indigo-600 peer-checked:bg-indigo-50 transition-all">
                                    <div class="flex items-center gap-3 mb-1">
                                        <span class="material-symbols-outlined text-slate-400 peer-checked:text-indigo-600">local_offer</span>
                                        <span class="font-medium text-slate-900 peer-checked:text-indigo-900">Promotional</span>
                                    </div>
                                    <p class="text-xs text-slate-500">Sales, offers and discounts</p>
                                </div>
                            </label>

                            <label class="cursor-pointer relative">
                                <input type="radio" name="type" value="Product Update" class="peer sr-only" <?= ($saved_data['type'] ?? '') == 'Product Update' ? 'checked' : '' ?>>
                                <div class="p-4 rounded-xl border border-slate-200 hover:border-indigo-300 peer-checked:border-indigo-600 peer-checked:bg-indigo-50 transition-all">
                                    <div class="flex items-center gap-3 mb-1">
                                        <span class="material-symbols-outlined text-slate-400 peer-checked:text-indigo-600">rocket_launch</span>
                                        <span class="font-medium text-slate-900 peer-checked:text-indigo-900">Product Update</span>
                                    </div>
                                    <p class="text-xs text-slate-500">New features and improvements</p>
                                </div>
                            </label>

                            <label class="cursor-pointer relative">
                                <input type="radio" name="type" value="Onboarding" class="peer sr-only" <?= ($saved_data['type'] ?? '') == 'Onboarding' ? 'checked' : '' ?>>
                                <div class="p-4 rounded-xl border border-slate-200 hover:border-indigo-300 peer-checked:border-indigo-600 peer-checked:bg-indigo-50 transition-all">
                                    <div class="flex items-center gap-3 mb-1">
                                        <span class="material-symbols-outlined text-slate-400 peer-checked:text-indigo-600">waving_hand</span>
                                        <span class="font-medium text-slate-900 peer-checked:text-indigo-900">Onboarding</span>
                                    </div>
                                    <p class="text-xs text-slate-500">Welcome series for new users</p>
                                </div>
                            </label>

                            <label class="cursor-pointer relative">
                                <input type="radio" name="type" value="Event Invitation" class="peer sr-only" <?= ($saved_data['type'] ?? '') == 'Event Invitation' ? 'checked' : '' ?>>
                                <div class="p-4 rounded-xl border border-slate-200 hover:border-indigo-300 peer-checked:border-indigo-600 peer-checked:bg-indigo-50 transition-all">
                                    <div class="flex items-center gap-3 mb-1">
                                        <span class="material-symbols-outlined text-slate-400 peer-checked:text-indigo-600">event</span>
                                        <span class="font-medium text-slate-900 peer-checked:text-indigo-900">Event Invite</span>
                                    </div>
                                    <p class="text-xs text-slate-500">Webinars and live events</p>
                                </div>
                            </label>

                            <label class="cursor-pointer relative">
                                <input type="radio" name="type" value="Retention" class="peer sr-only" <?= ($saved_data['type'] ?? '') == 'Retention' ? 'checked' : '' ?>>
                                <div class="p-4 rounded-xl border border-slate-200 hover:border-indigo-300 peer-checked:border-indigo-600 peer-checked:bg-indigo-50 transition-all">
                                    <div class="flex items-center gap-3 mb-1">
                                        <span class="material-symbols-outlined text-slate-400 peer-checked:text-indigo-600">published_with_changes</span>
                                        <span class="font-medium text-slate-900 peer-checked:text-indigo-900">Retention</span>
                                    </div>
                                    <p class="text-xs text-slate-500">Re-engage inactive users</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Audience Segment (Optional hint) -->
                    <!-- We'll keep this as a 'Context' field, since actual selection is Step 2 -->
                    <!-- Changing label to "Context" -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Target Context (Optional)</label>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-slate-400 material-symbols-outlined text-[20px]">lightbulb</span>
                            <input type="text" name="segment" value="<?= esc($saved_data['segment'] ?? '') ?>" placeholder="e.g. 'This is for Computer Science students' (Selection happens next)"
                                class="w-full pl-10 pr-4 py-2.5 rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 transition-shadow">
                        </div>
                        <p class="mt-2 text-xs text-slate-500 flex items-center gap-1.5">
                            <span class="material-symbols-outlined text-[14px]">info</span>
                            <span>You will select specific recipients in the next step. Use this for AI context.</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Campaign Goal Card -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[20px]">flag</span>
                    </div>
                    <h3 class="font-semibold text-slate-800">Optimization Goal</h3>
                </div>
                <div class="p-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Primary Objective</label>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-slate-400 material-symbols-outlined text-[20px]">target</span>
                            <textarea name="goal" rows="3" placeholder="e.g. Drive registration for the upcoming 'Study inside the USA' webinar..."
                                class="w-full pl-10 pr-4 py-2.5 rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 transition-shadow resize-none" required><?= esc($saved_data['goal'] ?? '') ?></textarea>
                        </div>
                        <p class="mt-2 text-xs text-slate-500">
                            The AI will optimize subject lines and call-to-actions based on this goal.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Tone & Actions -->
        <div class="space-y-6">
            
            <!-- Tone Card -->
            <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[20px]">style</span>
                    </div>
                    <h3 class="font-semibold text-slate-800">Voice & Tone</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-3">
                        <label class="flex items-start gap-3 p-3 rounded-lg border border-slate-200 cursor-pointer hover:border-indigo-300 hover:bg-slate-50 transition-all">
                            <input type="radio" name="tone" value="Professional & Informative" class="mt-1" <?= ($saved_data['tone'] ?? '') == 'Professional & Informative' ? 'checked' : 'checked' ?>>
                            <div>
                                <span class="block text-sm font-medium text-slate-900">Professional & Informative</span>
                                <span class="block text-xs text-slate-500 mt-0.5">Clear, concise, and trustworthy. Good for updates.</span>
                            </div>
                        </label>

                        <label class="flex items-start gap-3 p-3 rounded-lg border border-slate-200 cursor-pointer hover:border-indigo-300 hover:bg-slate-50 transition-all">
                            <input type="radio" name="tone" value="Friendly & Casual" class="mt-1" <?= ($saved_data['tone'] ?? '') == 'Friendly & Casual' ? 'checked' : '' ?>>
                            <div>
                                <span class="block text-sm font-medium text-slate-900">Friendly & Casual</span>
                                <span class="block text-xs text-slate-500 mt-0.5">Warm and approachable. Great for engagement.</span>
                            </div>
                        </label>

                        <label class="flex items-start gap-3 p-3 rounded-lg border border-slate-200 cursor-pointer hover:border-indigo-300 hover:bg-slate-50 transition-all">
                            <input type="radio" name="tone" value="Urgent & Action-Oriented" class="mt-1" <?= ($saved_data['tone'] ?? '') == 'Urgent & Action-Oriented' ? 'checked' : '' ?>>
                            <div>
                                <span class="block text-sm font-medium text-slate-900">Urgent & Action-Oriented</span>
                                <span class="block text-xs text-slate-500 mt-0.5">High energy, FOMO-inducing. Best for deadlines.</span>
                            </div>
                        </label>

                        <label class="flex items-start gap-3 p-3 rounded-lg border border-slate-200 cursor-pointer hover:border-indigo-300 hover:bg-slate-50 transition-all">
                            <input type="radio" name="tone" value="Exclusive & Premium" class="mt-1" <?= ($saved_data['tone'] ?? '') == 'Exclusive & Premium' ? 'checked' : '' ?>>
                            <div>
                                <span class="block text-sm font-medium text-slate-900">Exclusive & Premium</span>
                                <span class="block text-xs text-slate-500 mt-0.5">Sophisticated and special. For VIP offers.</span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Action Card -->
            <div class="bg-indigo-900 rounded-xl shadow-lg overflow-hidden text-white p-6 relative">
                <div class="absolute top-0 right-0 p-4 opacity-10">
                    <span class="material-symbols-outlined text-[100px]">arrow_forward</span>
                </div>
                <h3 class="text-lg font-bold mb-2 relative z-10">Next Step</h3>
                <p class="text-indigo-200 text-sm mb-6 relative z-10">
                    Proceed to select target audience and recipients.
                </p>
                
                <button type="submit" 
                    :disabled="submitting"
                    class="w-full py-3 px-4 bg-white text-indigo-900 font-bold rounded-lg hover:bg-indigo-50 transition-colors shadow-md flex items-center justify-center gap-2 relative z-10 disabled:opacity-70 disabled:cursor-not-allowed">
                    <span x-show="!submitting">Next: Select Audience</span>
                    <span x-show="submitting" class="material-symbols-outlined animate-spin">refresh</span>
                </button>
            </div>

        </div>
    </form>
</div>

<?= $this->endSection() ?>