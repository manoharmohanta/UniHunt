<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="max-w-7xl mx-auto">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <a href="<?= base_url('admin/coupons') ?>"
                class="text-slate-500 hover:text-indigo-600 flex items-center gap-2 mb-2 transition-colors text-sm font-medium">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                Back to Coupons
            </a>
            <h2 class="text-3xl font-bold text-slate-800 tracking-tight">Create New Coupon</h2>
            <p class="text-slate-500 mt-1">Configure discount rules and usage limits.</p>
        </div>
    </div>

    <form action="<?= base_url('admin/coupons/create') ?>" method="post" x-data="{ discountType: 'percentage' }">
        <?= csrf_field() ?>

        <?php if (session()->has('errors')): ?>
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-start gap-2">
                <span class="material-symbols-outlined text-[20px] mt-0.5">error</span>
                <div>
                    <h4 class="font-semibold text-sm">Please correct the following errors:</h4>
                    <ul class="list-disc list-inside text-sm mt-1">
                        <?php foreach (session('errors') as $error): ?>
                            <li><?= esc($error) ?></li>
                        <?php endforeach ?>
                    </ul>
                </div>
            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Core Configuration -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Basic Info Card -->
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center">
                            <span class="material-symbols-outlined text-[20px]">badge</span>
                        </div>
                        <h3 class="font-semibold text-slate-800">Basic Information</h3>
                    </div>

                    <div class="p-6 grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Coupon Code</label>
                            <div class="relative">
                                <span
                                    class="absolute left-3 top-3 text-slate-400 material-symbols-outlined text-[20px]">confirmation_number</span>
                                <input type="text" name="code" value="<?= old('code') ?>"
                                    class="w-full pl-10 pr-4 py-2.5 rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 uppercase font-mono tracking-wider transition-shadow placeholder:normal-case"
                                    placeholder="e.g. SUMMER50" required>
                            </div>
                            <p class="mt-2 text-xs text-slate-500">The code users will enter at checkout.</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Description</label>
                            <textarea name="description" rows="2"
                                class="w-full px-4 py-2.5 rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 transition-shadow resize-none"
                                placeholder="Internal note or user-facing description (e.g. 'Summer Sale 2026')"><?= old('description') ?></textarea>
                        </div>
                    </div>
                </div>

                <!-- Discount Rules Card -->
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center gap-3">
                        <div
                            class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center">
                            <span class="material-symbols-outlined text-[20px]">percent</span>
                        </div>
                        <h3 class="font-semibold text-slate-800">Discount Rules</h3>
                    </div>

                    <div class="p-6 space-y-6">
                        <!-- Discount Type Selection -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-3">Discount Type</label>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <label class="cursor-pointer relative">
                                    <input type="radio" name="discount_type" value="percentage" class="peer sr-only"
                                        x-model="discountType" <?= old('discount_type', 'percentage') == 'percentage' ? 'checked' : '' ?>>
                                    <div
                                        class="p-4 rounded-xl border border-slate-200 hover:border-indigo-300 peer-checked:border-indigo-600 peer-checked:bg-indigo-50 transition-all flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-slate-100 peer-checked:bg-indigo-200 text-slate-500 peer-checked:text-indigo-700 flex items-center justify-center">
                                            <span class="material-symbols-outlined">percent</span>
                                        </div>
                                        <div>
                                            <span
                                                class="block font-semibold text-slate-900 peer-checked:text-indigo-900">Percentage
                                                Off</span>
                                            <span class="block text-xs text-slate-500 mt-0.5">e.g. 20% off total</span>
                                        </div>
                                    </div>
                                </label>

                                <label class="cursor-pointer relative">
                                    <input type="radio" name="discount_type" value="fixed" class="peer sr-only"
                                        x-model="discountType" <?= old('discount_type') == 'fixed' ? 'checked' : '' ?>>
                                    <div
                                        class="p-4 rounded-xl border border-slate-200 hover:border-indigo-300 peer-checked:border-indigo-600 peer-checked:bg-indigo-50 transition-all flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-slate-100 peer-checked:bg-indigo-200 text-slate-500 peer-checked:text-indigo-700 flex items-center justify-center">
                                            <span class="material-symbols-outlined">attach_money</span>
                                        </div>
                                        <div>
                                            <span
                                                class="block font-semibold text-slate-900 peer-checked:text-indigo-900">Fixed
                                                Amount</span>
                                            <span class="block text-xs text-slate-500 mt-0.5">e.g. $10 off total</span>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Values -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Discount Value</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-3 text-slate-400 font-bold"
                                        x-text="discountType === 'fixed' ? '$' : '%'"></span>
                                    <input type="number" step="0.01" name="discount_value"
                                        value="<?= old('discount_value') ?>"
                                        class="w-full pl-8 pr-4 py-2.5 rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 transition-shadow"
                                        placeholder="0.00" required>
                                </div>
                            </div>

                            <div x-show="discountType === 'percentage'" x-transition>
                                <label class="block text-sm font-medium text-slate-700 mb-2">Maximum Discount
                                    Amount</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-3 text-slate-400 font-bold">$</span>
                                    <input type="number" step="0.01" name="max_discount_amount"
                                        value="<?= old('max_discount_amount') ?>"
                                        class="w-full pl-8 pr-4 py-2.5 rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 transition-shadow"
                                        placeholder="Empty for no limit">
                                </div>
                                <p class="mt-1 text-xs text-slate-500">Cap the discount at this amount.</p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Minimum Purchase
                                Requirement</label>
                            <div class="relative max-w-md">
                                <span
                                    class="absolute left-3 top-3 text-slate-400 material-symbols-outlined text-[20px]">shopping_cart</span>
                                <input type="number" step="0.01" name="min_purchase_amount"
                                    value="<?= old('min_purchase_amount') ?>"
                                    class="w-full pl-10 pr-4 py-2.5 rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 transition-shadow"
                                    placeholder="0.00">
                            </div>
                            <p class="mt-2 text-xs text-slate-500">Minimum cart total required to apply this coupon.</p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Right Column: Sidebar Settings -->
            <div class="space-y-6">

                <!-- Usage Limits -->
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">
                            <span class="material-symbols-outlined text-[20px]">equalizer</span>
                        </div>
                        <h3 class="font-semibold text-slate-800">Usage Limits</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Total Global Uses</label>
                            <input type="number" name="usage_limit" value="<?= old('usage_limit') ?>"
                                class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 py-2.5"
                                placeholder="Unlimited">
                            <p class="mt-1 text-xs text-slate-500">Total redemptions allowed across all users.</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Uses Per User</label>
                            <input type="number" name="usage_limit_per_user" value="<?= old('usage_limit_per_user') ?>"
                                class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 py-2.5"
                                placeholder="Unlimited">
                            <p class="mt-1 text-xs text-slate-500">How many times a single user can use this code.</p>
                        </div>
                    </div>
                </div>

                <!-- Validity Dates -->
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 bg-slate-50/50 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-orange-100 text-orange-600 flex items-center justify-center">
                            <span class="material-symbols-outlined text-[20px]">calendar_month</span>
                        </div>
                        <h3 class="font-semibold text-slate-800">Validity Period</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Starts At</label>
                            <input type="datetime-local" name="starts_at" value="<?= old('starts_at') ?>"
                                class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 py-2.5 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-2">Expires At</label>
                            <input type="datetime-local" name="expires_at" value="<?= old('expires_at') ?>"
                                class="w-full rounded-lg border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 py-2.5 text-sm">
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex flex-col gap-3">
                    <button type="submit"
                        class="w-full py-3 px-4 bg-indigo-600 text-white font-bold rounded-lg hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-200 flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined">save</span>
                        Save Coupon
                    </button>
                    <a href="<?= base_url('admin/coupons') ?>"
                        class="w-full py-3 px-4 bg-white text-slate-700 font-semibold rounded-lg border border-slate-300 hover:bg-slate-50 transition-colors flex items-center justify-center">
                        Cancel
                    </a>
                </div>

            </div>
        </div>
    </form>
</div>

<?= $this->endSection() ?>