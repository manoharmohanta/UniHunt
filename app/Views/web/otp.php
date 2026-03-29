<?= view('web/include/header', ['title' => 'Verify OTP | UniHunt', 'bodyClass' => 'bg-background-light dark:bg-background-dark min-h-screen flex flex-col font-display']) ?>

<script>
    /**
     * Define OTP Form component globally BEFORE Alpine initializes.
     * Using Alpine.data is the robust way to handle this with HTMX.
     */
    document.addEventListener('alpine:init', () => {
        Alpine.data('otpForm', () => ({
            otp: ['', '', '', '', '', ''],

            get otpValue() {
                return this.otp.join('');
            },

            prepareSubmit(event) {
                if (this.otpValue.length !== 6) {
                    event.preventDefault();
                }
            },

            focusInput(index) {
                const el = document.getElementById('otp-' + index);
                if (el) {
                    el.focus();
                    el.select();
                }
            },

            handleInput(index, event) {
                const val = event.target.value;
                if (!val) return;
                if (!/^\d*$/.test(val)) {
                    this.otp[index] = '';
                    return;
                }
                if (index < this.otp.length - 1) {
                    this.focusInput(index + 1);
                }
            },

            moveBack(index, event) {
                if (!this.otp[index] && index > 0) {
                    this.otp[index - 1] = '';
                    this.focusInput(index - 1);
                }
            },

            handlePaste(event) {
                event.preventDefault();
                const text = event.clipboardData.getData('text').slice(0, 6);
                if (!/^\d+$/.test(text)) return;

                const digits = text.split('');
                digits.forEach((d, i) => {
                    if (i < 6) this.otp[i] = d;
                });
                const nextIndex = Math.min(digits.length, 5);
                this.focusInput(nextIndex);
            }
        }));
    });
</script>

<!-- Main Content Area -->
<main class="flex-1 flex items-center justify-center p-6 relative overflow-hidden">
    <!-- Background Decor -->
    <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-primary/5 rounded-full blur-3xl -z-10"></div>
    <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-primary/10 rounded-full blur-3xl -z-10"></div>

    <!-- OTP Card -->
    <div
        class="w-full max-w-[420px] glass-card border border-white dark:border-gray-800 shadow-[0_8px_30px_rgb(0,0,0,0.04)] rounded-xl overflow-hidden">
        <div class="p-8 md:p-12">

            <!-- Icon -->
            <div class="flex justify-center mb-6">
                <div
                    class="w-16 h-16 bg-primary/10 dark:bg-primary/20 rounded-full flex items-center justify-center p-3">
                    <img src="<?= base_url('favicon_io/android-chrome-512x512.webp') ?>"
                        class="w-full h-full object-contain" alt="UniHunt">
                </div>
            </div>

            <!-- Heading -->
            <div class="text-center mb-8">
                <h1 class="text-[#111816] dark:text-white text-3xl font-extrabold mb-3">Verify OTP</h1>
                <p class="text-gray-500 dark:text-gray-400 text-base">Enter the 6-digit OTP sent to your email</p>
            </div>

            <!-- Error Container for HTMX -->
            <div id="error-container"></div>

            <!-- OTP FORM -->
            <form x-data="otpForm" hx-post="<?= base_url('auth/verify-otp') ?>" hx-target="#error-container"
                hx-indicator="#loading-spinner" hx-disabled-elt="find button" @submit="prepareSubmit($event)"
                class="space-y-6">

                <?= csrf_field() ?>
                <?= honeypot_field() ?>

                <input type="hidden" name="otp" :value="otpValue">

                <!-- OTP Inputs -->
                <div class="flex justify-center gap-3">
                    <template x-for="(digit, index) in otp" :key="index">
                        <input type="text" maxlength="1" inputmode="numeric" x-model="otp[index]" :id="'otp-' + index"
                            @input="handleInput(index, $event)" @keydown.backspace="moveBack(index, $event)"
                            @paste="handlePaste($event)" @focus="$event.target.select()"
                            @keyup.left="focusInput(index - 1)" @keyup.right="focusInput(index + 1)"
                            class="w-12 h-14 text-center text-xl font-bold rounded-xl border border-[#dbe6e3] dark:border-gray-800 bg-white dark:bg-gray-800 text-[#111816] dark:text-white focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition"
                            :aria-label="'Digit ' + (index + 1)" />
                    </template>
                </div>

                <!-- Verify Button -->
                <button type="submit" :disabled="otpValue.length !== 6"
                    class="w-full bg-primary disabled:opacity-50 disabled:cursor-not-allowed hover:bg-primary/90 text-white font-bold py-4 rounded-lg shadow-lg shadow-primary/20 transition flex items-center justify-center gap-2 group">
                    <span>Verify OTP</span>
                    <div id="loading-spinner"
                        class="htmx-indicator animate-spin h-5 w-5 border-2 border-white border-t-transparent rounded-full">
                    </div>
                    <span class="material-symbols-outlined htmx-indicator-hide">check_circle</span>
                </button>

                <!-- Resend -->
                <div class="text-center text-sm text-gray-500 dark:text-gray-400">
                    Didn't receive OTP?
                    <button type="button" hx-post="<?= base_url('auth/send-otp') ?>" hx-target="#error-container"
                        hx-vals='{"resend": "true"}' hx-indicator="#loading-spinner"
                        class="text-primary font-bold hover:underline ml-1">
                        Resend OTP
                    </button>
                </div>
            </form>
        </div>

        <!-- Info -->
        <div class="bg-primary/5 dark:bg-primary/10 px-8 py-4 border-t border-primary/10">
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-primary">info</span>
                <p class="text-xs text-primary/80 font-medium">OTP is valid for 5 minutes</p>
            </div>
        </div>
    </div>
</main>

<script>
    // Handle error clearing on new request
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