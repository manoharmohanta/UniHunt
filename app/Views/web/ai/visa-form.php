<?= view('web/include/header', ['title' => 'AI Visa Document Checker - UniHunt', 'bodyClass' => 'bg-background-light dark:bg-background-dark font-display min-h-screen flex flex-col transition-colors duration-200']) ?>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "SoftwareApplication",
  "name": "AI Visa Document Checker",
  "operatingSystem": "Web",
  "applicationCategory": "EducationalApplication",
  "offers": {
    "@type": "Offer",
    "price": "499",
    "priceCurrency": "INR"
  },
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "4.9",
    "ratingCount": "2100"
  },
  "description": "Get instant visa document checklists and travel plans for any country using AI."
}
</script>

<!-- Main Content -->
<main class="flex-1 flex flex-col items-center w-full py-8 px-4 md:px-8">
    <div class="w-full max-w-6xl flex flex-col gap-8">
        <!-- Stepper -->
        <div
            class="w-full bg-surface-light dark:bg-surface-dark rounded-xl border border-border-light dark:border-border-dark shadow-sm p-1 overflow-x-auto">
            <div class="flex justify-between items-center min-w-[600px]">
                <!-- Step 1: Details -->
                <div id="stepper-1"
                    class="flex flex-1 items-center gap-3 px-4 py-3 bg-primary/5 rounded-lg border border-primary/10">
                    <div class="flex items-center justify-center size-8 rounded-full bg-primary text-white shadow-glow">
                        <span class="text-sm font-bold">1</span>
                    </div>
                    <p class="text-primary text-sm font-bold">Visa Details</p>
                    <div class="h-[2px] flex-1 bg-border-light dark:bg-gray-700 mx-2"></div>
                </div>
                <!-- Step 2: Payment -->
                <div id="stepper-2" class="flex flex-1 items-center gap-3 px-4 py-3 opacity-40">
                    <div
                        class="flex items-center justify-center size-8 rounded-full border-2 border-border-light dark:border-gray-600 text-text-secondary dark:text-gray-500">
                        <span class="text-sm font-bold">2</span>
                    </div>
                    <p class="text-text-secondary dark:text-gray-500 text-sm font-bold">Payment</p>
                    <div class="h-[2px] flex-1 bg-border-light dark:bg-gray-700 mx-2"></div>
                </div>
                <!-- Step 3: Result -->
                <div id="stepper-3" class="flex items-center gap-3 px-4 py-3 opacity-40">
                    <div
                        class="flex items-center justify-center size-8 rounded-full border-2 border-border-light dark:border-gray-600 text-text-secondary dark:text-gray-500">
                        <span class="text-sm font-bold">3</span>
                    </div>
                    <p class="text-text-secondary dark:text-gray-500 text-sm font-bold">Checklist & Plan</p>
                </div>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8 items-start">
            <!-- Left Column: Form -->
            <div
                class="flex-1 w-full bg-surface-light dark:bg-surface-dark rounded-xl border border-border-light dark:border-border-dark shadow-soft p-6 md:p-8">
                <form id="visaForm" action="<?= base_url('ai-tools/visa-checker-result') ?>" method="POST"
                    class="flex flex-col gap-6">
                    <?= csrf_field() ?>
                    <?= honeypot_field() ?>

                    <!-- Step 1: Visa Inputs -->
                    <div class="form-step active" data-step="1">
                        <div class="mb-4">
                            <h2 class="text-2xl font-bold text-text-main dark:text-white">AI Visa Document Checker</h2>
                            <p class="text-sm text-text-secondary dark:text-gray-400">Get instant document checklists,
                                travel plans, and essential travel tips for any country.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <label class="flex flex-col gap-2">
                                <span class="text-sm font-semibold text-text-main dark:text-gray-200">Destination
                                    Country <span class="text-red-500">*</span></span>
                                <div class="relative">
                                    <span
                                        class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-gray-400">public</span>
                                    <input type="text" name="country" required
                                        class="w-full rounded-lg border border-border-light dark:border-border-dark bg-white dark:bg-[#2a323c] h-12 pl-12 pr-4 focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all"
                                        placeholder="e.g. Canada, Germany, Japan">
                                </div>
                            </label>
                            <label class="flex flex-col gap-2">
                                <span class="text-sm font-semibold text-text-main dark:text-gray-200">Visa
                                    Category</span>
                                <select name="visa_type" required
                                    class="w-full rounded-lg border border-border-light dark:border-border-dark bg-white dark:bg-[#2a323c] h-12 px-4 focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all">
                                    <option value="Student">Student Visa</option>
                                    <option value="Work">Work Visa / Permit</option>
                                    <option value="Tourist">Tourist / Visitor Visa</option>
                                    <option value="Business">Business Visa</option>
                                </select>
                            </label>
                        </div>

                        <div class="bg-primary/5 border border-primary/10 rounded-xl p-6 flex items-start gap-4 mt-6">
                            <span class="material-symbols-outlined text-primary mt-1">smart_toy</span>
                            <div>
                                <h4 class="text-primary font-bold text-sm">AI Recommendation Engine</h4>
                                <p class="text-xs text-text-secondary dark:text-gray-400 mt-1 leading-relaxed">Our AI
                                    will compile a specialized checklist of documents, a 7-day travel itinerary, best
                                    sight-seeing spots, and a packing list tailored for your destination and visa type.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Payment -->
                    <div class="form-step hidden" data-step="2">
                        <div class="mb-4">
                            <h2 class="text-2xl font-bold text-text-main dark:text-white">Review & Pay</h2>
                            <p class="text-sm text-text-secondary dark:text-gray-400">Apply coupons and proceed to
                                analyze requirements.</p>
                        </div>

                        <div
                            class="p-6 bg-gray-50 dark:bg-gray-800/30 rounded-xl border border-border-light dark:border-border-dark">
                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                                <!-- Coupon Input -->
                                <div class="flex-1 w-full">
                                    <h3 class="text-lg font-bold text-text-main dark:text-white mb-2">Premium Review
                                    </h3>
                                    <p class="text-xs text-text-secondary dark:text-gray-400 mb-4">Secure your visa
                                        chances with AI analysis.</p>

                                    <div class="flex gap-2 max-w-sm">
                                        <input type="text" id="coupon_code" name="coupon_code"
                                            class="flex-1 rounded-lg border border-border-light dark:border-border-dark bg-white dark:bg-[#2a323c] h-11 px-4 text-sm focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all uppercase"
                                            placeholder="ENTER CODE">
                                        <button type="button" onclick="applyCoupon()"
                                            class="bg-primary/10 text-primary hover:bg-primary/20 px-4 rounded-lg text-sm font-bold transition-all border border-primary/20">
                                            Apply
                                        </button>
                                    </div>
                                    <p id="coupon-msg" class="text-xs font-medium mt-2 hidden"></p>
                                </div>

                                <!-- Price Details -->
                                <div
                                    class="w-full md:w-64 space-y-3 pt-4 md:pt-0 md:pl-6 md:border-l border-dashed border-border-light dark:border-border-dark">
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-text-secondary dark:text-gray-400">Price</span>
                                        <span class="font-bold text-text-main dark:text-white line-through opacity-50"
                                            id="original-price-display">₹0.00</span>
                                    </div>
                                    <div class="flex justify-between items-center text-sm">
                                        <span class="text-text-secondary dark:text-gray-400">Discount</span>
                                        <span class="font-bold text-accent-green" id="discount-display">- ₹0.00</span>
                                    </div>
                                    <div class="flex justify-between items-center pt-2">
                                        <span class="font-bold text-text-main dark:text-white">Total</span>
                                        <span class="text-xl font-black text-primary"
                                            id="final-price-display">₹0.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Hidden Payment Fields -->
                    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
                    <input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
                    <input type="hidden" name="razorpay_signature" id="razorpay_signature">

                    <!-- Navigation Buttons -->
                    <div
                        class="flex items-center justify-between mt-8 pt-4 border-t border-border-light dark:border-border-dark">
                        <button type="button" id="prevBtn" onclick="changeStep(-1)"
                            class="hidden px-6 py-3 rounded-lg border border-border-light dark:border-border-dark text-text-main dark:text-white font-semibold hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                            Back
                        </button>

                        <button type="button" id="nextBtn" onclick="changeStep(1)"
                            class="ml-auto bg-primary hover:bg-[#158bb3] text-white font-bold text-sm px-8 py-3 rounded-xl shadow-lg shadow-primary/30 flex items-center gap-2 transition-all">
                            Next Step
                            <span class="material-symbols-outlined text-sm">arrow_forward</span>
                        </button>

                        <button type="submit" id="submitBtn"
                            class="hidden ml-auto bg-primary hover:bg-[#158bb3] text-white font-bold text-sm px-10 py-4 rounded-xl shadow-lg shadow-primary/30 items-center gap-3 transition-all transform hover:-translate-y-1">
                            <span id="btnText">Pay & Analyze</span>
                            <span class="material-symbols-outlined text-sm">search</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Right Column: Info -->
            <div class="w-full lg:w-[380px] flex flex-col gap-6">
                <div
                    class="bg-gradient-to-br from-[#e0f2f8] to-white dark:from-[#2a3a45] dark:to-surface-dark rounded-xl p-6 border border-primary/20 shadow-sm relative overflow-hidden group">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="material-symbols-outlined text-primary">verified_user</span>
                        <h3 class="text-text-main dark:text-white font-bold text-base">Key Insights</h3>
                    </div>
                    <ul class="space-y-4">
                        <li class="flex gap-3 items-start">
                            <span class="text-primary mt-1 material-symbols-outlined text-[18px]">check_circle</span>
                            <div>
                                <p class="text-text-main dark:text-gray-200 text-sm font-semibold">Document Checklist
                                </p>
                                <p class="text-text-secondary dark:text-gray-400 text-xs mt-1 leading-relaxed">
                                    Know exactly what forms and proofs you need before you apply.
                                </p>
                            </div>
                        </li>
                        <li class="flex gap-3 items-start">
                            <span class="text-primary mt-1 material-symbols-outlined text-[18px]">check_circle</span>
                            <div>
                                <p class="text-text-main dark:text-gray-200 text-sm font-semibold">Travel Planning</p>
                                <p class="text-text-secondary dark:text-gray-400 text-xs mt-1 leading-relaxed">
                                    Get a curated list of top attractions and a practical travel schedule.
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Loading Overlay -->
<div id="loadingOverlay" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 items-center justify-center hidden">
    <div class="bg-white dark:bg-surface-dark rounded-2xl p-8 max-w-md mx-4 text-center shadow-2xl">
        <div class="mb-6">
            <div class="relative w-20 h-20 mx-auto">
                <div class="absolute inset-0 border-4 border-primary/20 rounded-full"></div>
                <div class="absolute inset-0 border-4 border-primary border-t-transparent rounded-full animate-spin">
                </div>
                <span
                    class="material-symbols-outlined absolute inset-0 flex items-center justify-center text-primary text-3xl animate-pulse">auto_awesome</span>
            </div>
        </div>
        <h3 class="text-xl font-bold text-text-main dark:text-white mb-2">AI is Analyzing Requirements</h3>
        <p class="text-text-secondary dark:text-gray-400 text-sm mb-4">Pulling document checklists and travel
            insights...</p>
        <div class="flex flex-col gap-2 text-xs text-text-muted dark:text-gray-500">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-accent-green text-sm">check_circle</span>
                <span>Checking destination protocols</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-sm animate-pulse">pending</span>
                <span>Fetching visa checklists</span>
            </div>
            <div class="flex items-center gap-2 opacity-50">
                <span class="material-symbols-outlined text-sm">radio_button_unchecked</span>
                <span>Generating travel itinerary</span>
            </div>
        </div>
    </div>
</div>

<script>
    const toolPriceCheck = {
        toolId: 4, // Visa Checker
        calc: null
    };

    let currentStep = 1;
    const totalSteps = 3;

    // Load initial price logic
    // document.addEventListener('DOMContentLoaded', () => updateStepper(1));

    function changeStep(direction) {
        const newStep = currentStep + direction;
        if (direction > 0 && !validateStep(currentStep)) return;

        const currentStepEl = document.querySelector(`.form-step[data-step="${currentStep}"]`);
        const nextStepEl = document.querySelector(`.form-step[data-step="${newStep}"]`);

        if (currentStepEl) {
            currentStepEl.classList.add('hidden');
            currentStepEl.classList.remove('active');
        }

        if (nextStepEl) {
            nextStepEl.classList.remove('hidden');
            nextStepEl.classList.add('active');
        }

        currentStep = newStep;
        updateStepper(currentStep);
        updateButtons(currentStep);

        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function validateStep(step) {
        if (step === 1) {
            const country = document.getElementsByName('country')[0];
            if (!country.value.trim()) {
                showNotification('Please enter a destination country', 'error');
                country.focus();
                country.classList.add('border-red-500');
                return false;
            }
            country.classList.remove('border-red-500');
            return true;
        }
        return true;
    }

    function updateStepper(activeStep) {
        for (let i = 1; i <= totalSteps; i++) {
            const stepper = document.getElementById(`stepper-${i}`);
            if (!stepper) continue;

            const stepCircle = stepper.querySelector('div');
            const stepText = stepper.querySelector('p');

            if (i < activeStep) {
                stepper.className = 'flex flex-1 items-center gap-3 px-4 py-3 opacity-60';
                stepCircle.className = 'flex items-center justify-center size-8 rounded-full bg-primary/20 text-primary';
                stepCircle.innerHTML = '<span class="material-symbols-outlined text-lg">check</span>';
                stepText.className = 'text-text-main dark:text-gray-300 text-sm font-bold';
            } else if (i === activeStep) {
                stepper.className = 'flex flex-1 items-center gap-3 px-4 py-3 bg-primary/5 rounded-lg border border-primary/10';
                stepCircle.className = 'flex items-center justify-center size-8 rounded-full bg-primary text-white shadow-glow';
                stepCircle.innerHTML = `<span class="text-sm font-bold">${i}</span>`;
                stepText.className = 'text-primary text-sm font-bold';
            } else {
                stepper.className = 'flex flex-1 items-center gap-3 px-4 py-3 opacity-40';
                stepCircle.className = 'flex items-center justify-center size-8 rounded-full border-2 border-border-light dark:border-gray-600 text-text-secondary dark:text-gray-500';
                stepCircle.innerHTML = `<span class="text-sm font-bold">${i}</span>`;
                stepText.className = 'text-text-secondary dark:text-gray-500 text-sm font-bold';
            }
        }
    }

    function updateButtons(step) {
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        const submitBtn = document.getElementById('submitBtn');

        if (step === 1) {
            prevBtn.classList.add('hidden');
            prevBtn.classList.remove('flex');
            nextBtn.classList.remove('hidden');
            nextBtn.classList.add('flex');
            submitBtn.classList.add('hidden');
            submitBtn.classList.remove('flex');
        } else if (step === 2) {
            prevBtn.classList.remove('hidden');
            prevBtn.classList.add('flex');
            nextBtn.classList.add('hidden');
            nextBtn.classList.remove('flex');
            submitBtn.classList.remove('hidden');
            submitBtn.classList.add('flex');
            // load price when entering payment step
            loadInitialPrice();
        }
    }

    async function loadInitialPrice() {
        try {
            const response = await fetch('<?= base_url('ai-tools/check-price') ?>', {
                method: 'POST', headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ tool_id: toolPriceCheck.toolId })
            });
            const data = await response.json();

            if (data.csrf_token) {
                const csrfInput = document.querySelector('input[name="<?= csrf_token() ?>"]');
                if (csrfInput) csrfInput.value = data.csrf_token;
            }

            if (!data.error) updatePriceUI(data);
        } catch (e) { }
    }

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
                body: JSON.stringify({
                    tool_id: toolPriceCheck.toolId,
                    coupon_code: code
                })
            });

            const data = await response.json();

            if (data.csrf_token) {
                const csrfInput = document.querySelector('input[name="<?= csrf_token() ?>"]');
                if (csrfInput) csrfInput.value = data.csrf_token;
            }

            if (data.error) {
                msgEl.className = 'text-xs font-medium text-red-500';
                msgEl.textContent = data.error;
            } else {
                msgEl.className = 'text-xs font-medium text-accent-green';
                msgEl.textContent = 'Coupon applied successfully!';
                updatePriceUI(data);
            }
        } catch (error) {
            msgEl.className = 'text-xs font-medium text-red-500';
            msgEl.textContent = 'Failed to validate coupon';
        }
    }

    function updatePriceUI(data) {
        console.log("Updating Price UI:", data);
        const originalPrice = parseFloat(data.original_price || 0);
        const discountAmount = parseFloat(data.discount_amount || 0);
        const finalPrice = parseFloat(data.final_price || 0);

        document.getElementById('original-price-display').textContent = `₹${originalPrice.toFixed(2)}`;
        document.getElementById('discount-display').textContent = `- ₹${discountAmount.toFixed(2)}`;
        document.getElementById('final-price-display').textContent = `₹${finalPrice.toFixed(2)}`;

        const btnText = document.getElementById('btnText');
        if (btnText) {
            if (finalPrice > 0) {
                btnText.textContent = `Pay ₹${finalPrice.toFixed(2)} & Analyze`;
            } else {
                btnText.textContent = 'Analyze Requirements (Free)';
            }
        }
    }

    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        const bgColor = type === 'success' ? 'bg-green-500' :
            type === 'error' ? 'bg-red-500' : 'bg-blue-500';
        notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg text-white font-medium transform transition-all duration-300 ${bgColor}`;
        notification.textContent = message;
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.style.opacity = '0';
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }

    // Handle Form Submission with Payment
    document.getElementById('visaForm').addEventListener('submit', async function (e) {
        e.preventDefault();
        if (document.getElementById('razorpay_payment_id').value) return;

        const submitBtn = document.getElementById('submitBtn');

        try {
            const response = await fetch('<?= base_url('ai-tools/check-price') ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    tool_id: toolPriceCheck.toolId,
                    coupon_code: document.getElementById('coupon_code').value
                })
            });

            const data = await response.json();

            if (data.csrf_token) {
                const csrfInput = document.querySelector('input[name="<?= csrf_token() ?>"]');
                if (csrfInput) csrfInput.value = data.csrf_token;
            }

            if (data.error) {
                showNotification(data.error, 'error');
                submitBtn.classList.remove('hidden'); // Ensure button is visible if it was hidden
                document.getElementById('loadingOverlay').classList.remove('flex');
                document.getElementById('loadingOverlay').classList.add('hidden');
                return;
            }

            if (data.final_price > 0 && data.order_id) {
                const options = {
                    "key": data.razorpay_key || "<?= esc($settings['razorpay_key_id'] ?? '') ?>",
                    "amount": data.final_price * 100,
                    "currency": "INR",
                    "name": "<?= esc($settings['site_name'] ?? 'UniHunt') ?>",
                    "description": "Visa Document Check",
                    "order_id": data.order_id,
                    "handler": function (response) {
                        document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                        document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
                        document.getElementById('razorpay_signature').value = response.razorpay_signature;

                        submitForm();
                    },
                    "theme": { "color": "#4f46e5" }
                };
                const rzp = new Razorpay(options);
                rzp.on('payment.failed', function (response) {
                    showNotification(response.error.description, 'error');
                    document.getElementById('loadingOverlay').classList.remove('flex');
                    document.getElementById('loadingOverlay').classList.add('hidden');
                });
                rzp.open();
            } else {
                // Free/Waived/Disabled
                submitForm();
            }
        } catch (error) {
            console.error('Payment initiation failed:', error);
            showNotification('Failed to initiate payment. Please try again.', 'error');
            document.getElementById('loadingOverlay').classList.remove('flex');
            document.getElementById('loadingOverlay').classList.add('hidden');
        }
    });

    function submitForm() {
        changeStep(3); // Result Step
        document.getElementById('loadingOverlay').classList.remove('hidden');
        document.getElementById('loadingOverlay').classList.add('flex');
        document.getElementById('visaForm').submit();
    }

    // Init
    updateStepper(1);
</script>
<?= view('web/include/footer') ?>