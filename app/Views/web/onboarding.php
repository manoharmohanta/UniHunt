<?= view('web/include/header', ['title' => 'Complete Your Profile | UniHunt', 'bodyClass' => 'bg-background-light dark:bg-background-dark min-h-screen flex flex-col font-display']) ?>

<!-- Main Content Area -->
<main class="flex-1 flex items-center justify-center p-6 relative overflow-hidden">
    <!-- Subtle Abstract Background Elements -->
    <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-primary/5 rounded-full blur-3xl -z-10"></div>
    <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-primary/10 rounded-full blur-3xl -z-10"></div>

    <!-- Onboarding Card -->
    <div
        class="w-full max-w-[480px] glass-card border border-white dark:border-gray-800 shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-xl overflow-hidden">
        <div class="p-8 md:p-12">
            <!-- Icon Header -->
            <div class="flex justify-center mb-6">
                <div
                    class="w-16 h-16 bg-primary/10 dark:bg-primary/20 rounded-full flex items-center justify-center p-3">
                    <img src="<?= base_url('favicon_io/android-chrome-512x512.webp') ?>"
                        class="w-full h-full object-contain" alt="UniHunt">
                </div>
            </div>

            <!-- Text Headings -->
            <div class="text-center mb-8">
                <h1 class="text-[#111816] dark:text-white text-3xl font-extrabold tracking-tight mb-3">Complete Profile
                </h1>
                <p class="text-gray-500 dark:text-gray-400 text-base leading-relaxed">
                    Just a few more details to get you started with your study abroad journey.
                </p>
            </div>

            <!-- Error Container for HTMX -->
            <div id="error-container"></div>

            <!-- Onboarding Form -->
            <form hx-post="<?= base_url('auth/submit-onboarding') ?>" hx-target="#error-container"
                hx-indicator="#loading-spinner" hx-disabled-elt="find button" class="space-y-6">
                <?= csrf_field() ?>
                <?= honeypot_field() ?>
                <!-- Name Field -->
                <div class="space-y-2">
                    <label class="block text-[#111816] dark:text-gray-200 text-sm font-semibold ml-1" for="name">
                        Full Name
                    </label>
                    <div class="relative group">
                        <span
                            class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-primary transition-colors">person</span>
                        <input
                            class="w-full pl-12 pr-4 py-4 rounded-lg border border-[#dbe6e3] dark:border-gray-700 bg-white dark:bg-gray-800 text-[#111816] dark:text-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all placeholder:text-gray-400 outline-none"
                            id="name" name="name" placeholder="John Doe" required type="text" minlength="3"
                            maxlength="25" />
                    </div>
                </div>

                <!-- Role Selection -->
                <div class="space-y-4">
                    <label class="block text-[#111816] dark:text-gray-200 text-sm font-semibold ml-1">
                        I am a...
                    </label>
                    <div class="grid grid-cols-2 gap-4">
                        <label
                            class="relative flex flex-col p-4 border-2 rounded-xl cursor-pointer transition-all hover:bg-primary/5 has-[:checked]:border-primary has-[:checked]:bg-primary/5 border-[#dbe6e3] dark:border-gray-700">
                            <input type="radio" name="role_id" value="2" checked class="sr-only">
                            <span class="material-symbols-outlined text-2xl mb-1 text-primary">school</span>
                            <span class="text-sm font-bold text-[#111816] dark:text-white">Student</span>
                            <span class="text-[10px] text-gray-500">I want to study abroad</span>
                        </label>

                        <label
                            class="relative flex flex-col p-4 border-2 rounded-xl cursor-pointer transition-all hover:bg-primary/5 has-[:checked]:border-primary has-[:checked]:bg-primary/5 border-[#dbe6e3] dark:border-gray-700">
                            <input type="radio" name="role_id" value="5" class="sr-only">
                            <span class="material-symbols-outlined text-2xl mb-1 text-secondary">business_center</span>
                            <span class="text-sm font-bold text-[#111816] dark:text-white">Agent</span>
                            <span class="text-[10px] text-gray-500">I post events & ads</span>
                        </label>
                    </div>
                </div>

                <!-- Phone Field -->
                <div class="space-y-2">
                    <label class="block text-[#111816] dark:text-gray-200 text-sm font-semibold ml-1" for="phone">
                        Phone Number
                    </label>
                    <div class="relative group">
                        <span
                            class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-primary transition-colors">phone</span>
                        <input
                            class="w-full pl-12 pr-4 py-4 rounded-lg border border-[#dbe6e3] dark:border-gray-700 bg-white dark:bg-gray-800 text-[#111816] dark:text-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all placeholder:text-gray-400 outline-none"
                            id="phone" name="phone" placeholder="9876543210" required type="tel" pattern="[0-9]{7,15}"
                            title="Please enter a valid phone number (7-15 digits)" />
                    </div>
                </div>

                <!-- Marketing Consent -->
                <div class="flex items-start gap-3 pt-2">
                    <div class="flex items-center h-5">
                        <input id="marketing_consent" name="marketing_consent" type="checkbox" value="1" required
                            class="w-5 h-5 text-primary bg-gray-100 border-gray-300 rounded focus:ring-primary dark:focus:ring-primary dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 transition-all cursor-pointer">
                    </div>
                    <label for="marketing_consent"
                        class="ml-1 text-sm font-medium text-gray-600 dark:text-gray-400 cursor-pointer select-none">
                        I agree to receive marketing & promotional emails from UniHunt.
                    </label>
                </div>

                <button
                    class="w-full bg-primary hover:bg-primary/90 text-white font-bold py-4 px-6 rounded-lg shadow-lg shadow-primary/20 transition-all flex items-center justify-center gap-2 group"
                    type="submit">
                    <span>Get Started</span>
                    <div id="loading-spinner"
                        class="htmx-indicator animate-spin h-5 w-5 border-2 border-white border-t-transparent rounded-full">
                    </div>
                    <span
                        class="material-symbols-outlined text-xl group-hover:translate-x-1 transition-transform htmx-indicator-hide">rocket_launch</span>
                </button>
            </form>
        </div>

        <!-- Helpful Tooltip/Info Bar -->
        <div class="bg-primary/5 dark:bg-primary/10 px-8 py-4 border-t border-primary/10">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-primary text-xl">security</span>
                <p class="text-xs text-primary/80 dark:text-primary/90 font-medium">
                    Your data is safe and will only be used for university applications.
                </p>
            </div>
        </div>
    </div>
</main>

<style>
    .htmx-indicator {
        display: none;
    }

    .htmx-request .htmx-indicator {
        display: block;
    }

    .htmx-request .htmx-indicator-hide {
        display: none;
    }
</style>

<?= view('web/include/footer') ?>