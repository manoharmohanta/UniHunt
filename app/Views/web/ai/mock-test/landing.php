<?= view('web/include/header', ['title' => $title]) ?>

<main class="flex-grow">
    <section class="bg-primary py-20 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-primary-dark/90 to-primary/90"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <span
                class="inline-block py-1 px-3 rounded-full bg-white/20 backdrop-blur-md border border-white/10 text-sm font-bold text-white mb-6">
                AI-Powered Assessment
            </span>
            <h1 class="text-4xl md:text-5xl font-black text-white mb-6">
                <?= esc($test_name) ?> Preparation
            </h1>
            <p class="text-xl text-blue-100 max-w-2xl mx-auto mb-10">
                Take a full-length, AI-generated mock test to assess your readiness. Get instant scoring and detailed
                feedback on your performance.
            </p>
        </div>
    </section>

    <section class="py-16 px-4 bg-background-light dark:bg-background-dark">
        <div class="max-w-4xl mx-auto">
            <div
                class="bg-white dark:bg-card-dark rounded-3xl shadow-xl overflow-hidden border border-gray-100 dark:border-gray-800">
                <div class="p-8 md:p-12">
                    <div class="flex flex-col md:flex-row gap-12">
                        <div class="flex-1 space-y-6">
                            <h2 class="text-2xl font-bold text-text-main dark:text-white">Test Overview</h2>
                            <ul class="space-y-4">
                                <li class="flex items-start gap-4">
                                    <div
                                        class="w-10 h-10 rounded-full bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined text-primary">timer</span>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-text-main dark:text-white">Duration</h4>
                                        <p class="text-sm text-text-muted">Approx. 15-20 Minutes (Mini Mock)</p>
                                    </div>
                                </li>
                                <li class="flex items-start gap-4">
                                    <div
                                        class="w-10 h-10 rounded-full bg-green-50 dark:bg-green-900/30 flex items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined text-green-600">psychology</span>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-text-main dark:text-white">AI-Generated</h4>
                                        <p class="text-sm text-text-muted">Unique questions every time you take the
                                            test.</p>
                                    </div>
                                </li>
                                <li class="flex items-start gap-4">
                                    <div
                                        class="w-10 h-10 rounded-full bg-purple-50 dark:bg-purple-900/30 flex items-center justify-center shrink-0">
                                        <span class="material-symbols-outlined text-purple-600">analytics</span>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-text-main dark:text-white">Instant Analysis</h4>
                                        <p class="text-sm text-text-muted">Get a predicted score and breakdown of weak
                                            areas immediately.</p>
                                    </div>
                                </li>
                            </ul>

                            <!-- Payment & Coupon Section -->
                            <?php if ($paymentEnabled && isset($tool) && $tool['price'] > 0): ?>
                                <div class="pt-6 border-t border-gray-100 dark:border-gray-800">
                                    <h3
                                        class="text-lg font-bold text-text-main dark:text-white mb-4 flex items-center gap-2">
                                        <span class="material-symbols-outlined text-primary">payments</span>
                                        Premium Assessment
                                    </h3>

                                    <div class="grid grid-cols-1 gap-6 mb-8">
                                        <!-- Coupon Input -->
                                        <div class="flex flex-col gap-3">
                                            <label class="text-sm font-semibold text-text-main dark:text-gray-200">Have a
                                                Coupon Code?</label>
                                            <div class="flex gap-2">
                                                <input type="text" id="coupon_code" name="coupon_code"
                                                    class="flex-1 rounded-lg border border-border-light dark:border-border-dark bg-white dark:bg-[#2a323c] h-11 px-4 text-sm focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all uppercase"
                                                    placeholder="ENTER CODE">
                                                <button type="button" onclick="applyCoupon()"
                                                    class="bg-surface-light dark:bg-gray-800 text-primary dark:text-white border border-primary/20 hover:bg-primary/5 px-4 rounded-lg text-sm font-bold transition-all">
                                                    Apply
                                                </button>
                                            </div>
                                            <p id="coupon-msg" class="text-xs font-medium hidden"></p>
                                        </div>

                                        <!-- Price Details -->
                                        <div
                                            class="bg-gray-50 dark:bg-gray-800/30 rounded-xl p-5 border border-border-light dark:border-border-dark">
                                            <div class="flex justify-between items-center mb-2">
                                                <span
                                                    class="text-xs text-text-secondary dark:text-gray-400 font-medium">Test
                                                    Price</span>
                                                <span
                                                    class="text-sm font-bold text-text-main dark:text-white line-through opacity-50"
                                                    id="original-price-display">₹<?= number_format($tool['price'], 2) ?></span>
                                            </div>
                                            <div
                                                class="flex justify-between items-center mb-4 pb-4 border-b border-dashed border-border-light dark:border-border-dark">
                                                <span
                                                    class="text-xs text-text-secondary dark:text-gray-400 font-medium">Discount
                                                    Applied</span>
                                                <span class="text-sm font-bold text-accent-green" id="discount-display">-
                                                    ₹0.00</span>
                                            </div>
                                            <div class="flex justify-between items-center">
                                                <span class="text-sm font-bold text-text-main dark:text-white">Amount to
                                                    Pay</span>
                                                <span class="text-xl font-black text-primary"
                                                    id="final-price-display">₹<?= number_format($tool['price'], 2) ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="pt-2">
                                <form id="startTestForm" action="<?= site_url('ai-tools/mock-take/' . $test_type) ?>"
                                    method="POST">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="coupon_code" id="coupon_code_applied">
                                    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
                                    <input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
                                    <input type="hidden" name="razorpay_signature" id="razorpay_signature">

                                    <button type="button" onclick="initiateStart()" class="inline-flex items-center justify-center w-full md:w-auto px-8 py-4 bg-primary
                                    hover:bg-primary-hover text-white font-bold rounded-xl transition-all hover:shadow-lg
                                    hover:-translate-y-1">
                                        <span id="startBtnText">Start Mock Test</span>
                                        <span class="material-symbols-outlined ml-2">play_circle</span>
                                    </button>
                                </form>
                                <p class="mt-4 text-xs text-center md:text-left text-text-muted">
                                    * Instant AI scoring and feedback included.
                                </p>
                            </div>
                        </div>

                        <div class="hidden md:block w-px bg-gray-100 dark:bg-gray-700"></div>

                        <div class="w-full md:w-72 shrink-0">
                            <h3 class="font-bold text-lg mb-4 text-text-main dark:text-white">Instructions</h3>
                            <div class="text-sm text-text-muted space-y-3">
                                <p>1. Ensure you have a stable internet connection.</p>
                                <p>2. Do not refresh the page during the test.</p>
                                <p>3. For speaking sections, you will be asked to type what you would say.</p>
                                <p>4. Results are generated via AI and are estimates.</p>
                            </div>

                            <div
                                class="mt-8 p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-xl border border-yellow-100 dark:border-yellow-800/50">
                                <div
                                    class="flex items-center gap-2 text-yellow-700 dark:text-yellow-400 font-bold mb-1">
                                    <span class="material-symbols-outlined text-lg">info</span> Beta Feature
                                </div>
                                <p class="text-xs text-yellow-600 dark:text-yellow-500/80">
                                    Our AI test engine is in beta. Questions are generated dynamically.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Loading Overlay -->
<div id="loading-overlay"
    class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 backdrop-blur-sm transition-opacity duration-300 opacity-0">
    <div
        class="bg-white dark:bg-card-dark p-8 rounded-2xl shadow-2xl max-w-sm w-full text-center relative overflow-hidden transform scale-95 transition-transform duration-300">
        <!-- Background Glow -->
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-32 h-32 bg-primary/20 rounded-full blur-3xl -z-10"></div>

        <div class="relative z-10">
            <div class="w-16 h-16 mx-auto border-4 border-primary border-t-transparent rounded-full animate-spin mb-6">
            </div>

            <h3 class="text-xl font-bold text-text-main dark:text-white mb-2">
                Ai is getting ready...
            </h3>
            <p class="text-text-muted text-sm mb-6" id="loading-text">
                Analyzing test parameters
            </p>

            <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-1.5 overflow-hidden">
                <div id="loading-bar" class="bg-primary h-full rounded-full w-0 transition-all duration-300"></div>
            </div>
        </div>
    </div>
</div>

<script>
    const toolId = 10;
    let finalPrice = <?= $tool['price'] ?? 0 ?>;

    async function applyCoupon() {
        const code = document.getElementById('coupon_code').value.trim();
        const msgEl = document.getElementById('coupon-msg');
        if (!code) return;

        msgEl.className = 'text-xs font-medium text-text-secondary';
        msgEl.textContent = 'Validating...';
        msgEl.classList.remove('hidden');

        try {
            const response = await fetch('<?= base_url('ai-tools/check-price') ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ tool_id: toolId, coupon_code: code })
            });
            const data = await response.json();
            if (data.error) {
                msgEl.className = 'text-xs font-medium text-red-500';
                msgEl.textContent = data.error;
            } else {
                msgEl.className = 'text-xs font-medium text-accent-green';
                msgEl.textContent = 'Coupon applied successfully!';
                document.getElementById('coupon_code_applied').value = code;
                updatePriceUI(data);
            }
        } catch (error) {
            msgEl.textContent = 'Failed to validate coupon';
        }
    }

    function updatePriceUI(data) {
        finalPrice = parseFloat(data.final_price || 0);
        document.getElementById('original-price-display').textContent = `₹${parseFloat(data.original_price).toFixed(2)}`;
        document.getElementById('discount-display').textContent = `- ₹${parseFloat(data.discount_amount).toFixed(2)}`;
        document.getElementById('final-price-display').textContent = `₹${finalPrice.toFixed(2)}`;

        const btnText = document.getElementById('startBtnText');
        if (finalPrice > 0) {
            btnText.textContent = `Pay ₹${finalPrice.toFixed(2)} & Start Test`;
        } else {
            btnText.textContent = 'Start Mock Test (Free)';
        }
    }

    function showNotification(message, type = 'info') {
        const colors = { success: 'bg-green-500', error: 'bg-red-500', info: 'bg-blue-500' };
        const n = document.createElement('div');
        n.className = `fixed top-4 right-4 z-[9999] px-6 py-3 rounded-lg shadow-lg text-white font-medium transition-all duration-300 ${colors[type]}`;
        n.textContent = message;
        document.body.appendChild(n);
        setTimeout(() => { n.style.opacity = '0'; setTimeout(() => n.remove(), 300); }, 3000);
    }

    async function initiateStart() {
        if (finalPrice > 0) {
            // Check for order ID
            const coupon = document.getElementById('coupon_code').value.trim();
            try {
                const response = await fetch('<?= base_url('ai-tools/check-price') ?>', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ tool_id: toolId, coupon_code: coupon })
                });
                const data = await response.json();

                if (data.error) {
                    showNotification(data.error, 'error');
                    return;
                }

                if (data.order_id && data.final_price > 0) {
                    // Double check if the price matches what the user sees
                    if (document.getElementById('final-price-display').textContent.includes('0.00') && data.final_price > 0) {
                        showNotification("Price has changed (possibly due to removed coupon). Updating...", 'info');
                        updatePriceUI(data);
                        // Abort this attempt so user sees the new price
                        return;
                    }

                    const options = {
                        "key": data.razorpay_key || "<?= esc($settings['razorpay_key_id'] ?? '') ?>",
                        "amount": data.final_price * 100,
                        "currency": "INR",
                        "name": "UniHunt AI",
                        "description": "<?= esc($test_name) ?> Mock Test",
                        "order_id": data.order_id,
                        "handler": function (response) {
                            document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                            document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
                            document.getElementById('razorpay_signature').value = response.razorpay_signature;
                            startTest();
                        },
                        "theme": { "color": "#1da1f2" }
                    };
                    const rzp = new Razorpay(options);
                    rzp.on('payment.failed', function (response) {
                        showNotification(response.error.description, 'error');
                    });
                    rzp.open();
                } else {
                    startTest();
                }
            } catch (e) {
                // Fallback: If the UI shows free/0.00, assume it's free and allow submission
                const priceDisplay = document.getElementById('final-price-display');
                if (priceDisplay && (priceDisplay.textContent.includes('0.00') || priceDisplay.textContent.trim() === '₹0')) {
                    startTest();
                    return;
                }
                showNotification("Failed to initiate payment. Please try again.", "error");
            }
        } else {
            startTest();
        }
    }

    function startTest() {
        const type = '<?= $test_type ?>';
        const overlay = document.getElementById('loading-overlay');
        const loadingBar = document.getElementById('loading-bar');
        const loadingText = document.getElementById('loading-text');

        // Show Overlay
        overlay.classList.remove('hidden');
        overlay.classList.add('flex');

        // Small delay to allow display:block to apply before opacity transition
        setTimeout(() => {
            overlay.classList.remove('opacity-0');
            overlay.querySelector('div').classList.remove('scale-95');
            overlay.querySelector('div').classList.add('scale-100');
        }, 10);

        const steps = [
            { pct: 20, text: "Initializing secure environment..." },
            { pct: 45, text: "Fetching AI-generated questions..." },
            { pct: 70, text: "Calibrating difficulty levels..." },
            { pct: 90, text: "Finalizing test structure..." },
            { pct: 100, text: "Ready! Launching test..." }
        ];

        let stepIndex = 0;

        const interval = setInterval(() => {
            if (stepIndex >= steps.length) {
                clearInterval(interval);
                document.getElementById('startTestForm').submit();
                return;
            }

            const step = steps[stepIndex];
            loadingBar.style.width = step.pct + '%';
            loadingText.textContent = step.text;

            stepIndex++;
        }, 800);
    }
</script>

<!-- Razorpay Checkout -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<?= view('web/include/footer') ?>