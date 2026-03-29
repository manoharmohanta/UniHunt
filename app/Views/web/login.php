<?= view('web/include/header', ['title' => 'Login | UniHunt', 'bodyClass' => 'bg-background-light dark:bg-background-dark min-h-screen flex flex-col font-display']) ?>

<!-- Main Content Area -->
<main class="flex-1 flex items-center justify-center p-6 relative overflow-hidden">
    <!-- Subtle Abstract Background Elements -->
    <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-primary/5 rounded-full blur-3xl -z-10"></div>
    <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-primary/10 rounded-full blur-3xl -z-10"></div>

    <!-- Focused Login Card -->
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
                <h1 class="text-[#111816] dark:text-white text-3xl font-extrabold tracking-tight mb-3">Login / Signup
                </h1>
                <p class="text-gray-500 dark:text-gray-400 text-base leading-relaxed">
                    Enter your email. We'll send a One-Time Password (OTP) to verify your identity.
                </p>
            </div>

            <!-- Error Container for HTMX -->
            <div id="error-container"></div>

            <!-- OTP Login Form -->
            <form hx-post="<?= base_url('auth/send-otp') ?>" hx-target="#error-container" hx-swap="innerHTML"
                hx-indicator="#loading-spinner" hx-disabled-elt="find button" class="space-y-6">
                <?= csrf_field() ?>
                <?= honeypot_field() ?>

                <input type="hidden" name="redirect" value="<?= esc(service('request')->getGet('redirect')) ?>">
                <input type="hidden" name="bookmark_entity"
                    value="<?= esc(service('request')->getGet('bookmark_entity')) ?>">
                <input type="hidden" name="bookmark_id" value="<?= esc(service('request')->getGet('bookmark_id')) ?>">

                <div class="space-y-2">
                    <label class="block text-[#111816] dark:text-gray-200 text-sm font-semibold ml-1" for="login">
                        Email Address
                    </label>
                    <div class="relative group">
                        <span
                            class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-primary transition-colors">mail</span>
                        <input
                            class="w-full pl-12 pr-4 py-4 rounded-lg border border-[#dbe6e3] dark:border-gray-700 bg-white dark:bg-gray-800 text-[#111816] dark:text-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all placeholder:text-gray-400 outline-none"
                            id="login" name="login" placeholder="e.g., user@domain.com" required="" type="email" />
                    </div>
                </div>

                <button
                    class="w-full bg-primary hover:bg-primary/90 text-white font-bold py-4 px-6 rounded-lg shadow-lg shadow-primary/20 transition-all flex items-center justify-center gap-2 group"
                    type="submit">
                    <span id="btn-text">Send OTP</span>
                    <div id="loading-spinner"
                        class="htmx-indicator animate-spin h-5 w-5 border-2 border-white border-t-transparent rounded-full">
                    </div>
                    <span
                        class="material-symbols-outlined text-xl group-hover:translate-x-1 transition-transform htmx-indicator-hide">arrow_forward</span>
                </button>
            </form>
        </div>

        <!-- Helpful Tooltip/Info Bar -->
        <div class="bg-primary/5 dark:bg-primary/10 px-8 py-4 border-t border-primary/10">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-primary text-xl">help</span>
                <p class="text-xs text-primary/80 dark:text-primary/90 font-medium">
                    Need help? Contact our global support team at <span
                        class="font-bold">unihunt.overseas@gmail.com</span>
                </p>
            </div>
        </div>
    </div>
</main>

<script>
    document.body.addEventListener('htmx:beforeRequest', function (evt) {
        const errBox = document.getElementById('error-container');
        if (errBox) errBox.innerHTML = '';
    });
</script>

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