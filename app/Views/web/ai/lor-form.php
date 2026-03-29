<?= view('web/include/header', ['title' => 'AI LOR Generator - Create Letter of Recommendation', 'bodyClass' => 'bg-background-light dark:bg-background-dark font-display min-h-screen flex flex-col transition-colors duration-200']) ?>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "SoftwareApplication",
  "name": "AI LOR Generator",
  "operatingSystem": "Web",
  "applicationCategory": "EducationalApplication",
  "offers": {
    "@type": "Offer",
    "price": "499",
    "priceCurrency": "INR"
  },
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "4.7",
    "ratingCount": "980"
  },
  "description": "Create professional Letters of Recommendation (LOR) for academic and professional use with AI."
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
                    <p class="text-primary text-sm font-bold">LOR Details</p>
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
                <!-- Step 3: Generate -->
                <div id="stepper-3" class="flex items-center gap-3 px-4 py-3 opacity-40">
                    <div
                        class="flex items-center justify-center size-8 rounded-full border-2 border-border-light dark:border-gray-600 text-text-secondary dark:text-gray-500">
                        <span class="text-sm font-bold">3</span>
                    </div>
                    <p class="text-text-secondary dark:text-gray-500 text-sm font-bold">Generate LOR</p>
                </div>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8 items-start">
            <!-- Left Column: Form -->
            <div
                class="flex-1 w-full bg-surface-light dark:bg-surface-dark rounded-xl border border-border-light dark:border-border-dark shadow-soft p-6 md:p-8">
                <form id="lorForm" action="<?= base_url('ai-tools/generate-lor') ?>" method="POST"
                    class="flex flex-col gap-6">
                    <?= csrf_field() ?>
                    <?= honeypot_field() ?>

                    <!-- Step 1: LOR Inputs -->
                    <div class="form-step active" data-step="1">
                        <div class="mb-6">
                            <h2 class="text-2xl font-bold text-text-main dark:text-white">Recommendation Details</h2>
                            <p class="text-sm text-text-secondary dark:text-gray-400">Provide details about the
                                recommender and the applicant.</p>
                        </div>

                        <div class="flex flex-col gap-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <label class="flex flex-col gap-2">
                                    <span class="text-sm font-semibold text-text-main dark:text-gray-200">Recommendation
                                        Type</span>
                                    <select name="lor_type" required
                                        class="w-full rounded-lg border border-border-light dark:border-border-dark bg-white dark:bg-[#2a323c] h-12 px-4 focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all">
                                        <option value="Academic">Academic (Teacher/Professor)</option>
                                        <option value="Professional">Professional (Employer/Manager)</option>
                                    </select>
                                </label>
                                <label class="flex flex-col gap-2">
                                    <span class="text-sm font-semibold text-text-main dark:text-gray-200">Applicant's
                                        Name <span class="text-red-500">*</span></span>
                                    <input type="text" name="applicant_name" required
                                        class="w-full rounded-lg border border-border-light dark:border-border-dark bg-white dark:bg-[#2a323c] h-12 px-4 focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all"
                                        placeholder="Student or Employee Name">
                                </label>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <label class="flex flex-col gap-2">
                                    <span class="text-sm font-semibold text-text-main dark:text-gray-200">Recommender's
                                        Name <span class="text-red-500">*</span></span>
                                    <input type="text" name="recommender_name" required
                                        class="w-full rounded-lg border border-border-light dark:border-border-dark bg-white dark:bg-[#2a323c] h-12 px-4 focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all"
                                        placeholder="Professor or Manager Name">
                                </label>
                                <label class="flex flex-col gap-2">
                                    <span class="text-sm font-semibold text-text-main dark:text-gray-200">Recommender's
                                        Designation <span class="text-red-500">*</span></span>
                                    <input type="text" name="recommender_title" required
                                        class="w-full rounded-lg border border-border-light dark:border-border-dark bg-white dark:bg-[#2a323c] h-12 px-4 focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all"
                                        placeholder="e.g. Head of Dept / Senior Manager">
                                </label>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <label class="flex flex-col gap-2">
                                    <span class="text-sm font-semibold text-text-main dark:text-gray-200">Organization /
                                        University <span class="text-red-500">*</span></span>
                                    <input type="text" name="organization" required
                                        class="w-full rounded-lg border border-border-light dark:border-border-dark bg-white dark:bg-[#2a323c] h-12 px-4 focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all"
                                        placeholder="e.g. Stanford University / Tech Solutions Inc">
                                </label>
                                <label class="flex flex-col gap-2">
                                    <span class="text-sm font-semibold text-text-main dark:text-gray-200">Duration of
                                        Association</span>
                                    <input type="text" name="duration"
                                        class="w-full rounded-lg border border-border-light dark:border-border-dark bg-white dark:bg-[#2a323c] h-12 px-4 focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all"
                                        placeholder="e.g. 3 Years / 5 Semesters">
                                </label>
                            </div>

                            <label class="flex flex-col gap-2">
                                <span class="text-sm font-semibold text-text-main dark:text-gray-200">Key Projects /
                                    Achievements <span class="text-red-500">*</span></span>
                                <textarea name="projects" required
                                    class="w-full rounded-lg border border-border-light dark:border-border-dark bg-white dark:bg-[#2a323c] p-4 h-32 focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all"
                                    placeholder="Mention specific projects, tasks or awards the applicant worked on under your supervision."></textarea>
                            </label>

                            <label class="flex flex-col gap-2">
                                <span class="text-sm font-semibold text-text-main dark:text-gray-200">Specific Strengths
                                    / Traits <span class="text-red-500">*</span></span>
                                <textarea name="strengths" required
                                    class="w-full rounded-lg border border-border-light dark:border-border-dark bg-white dark:bg-[#2a323c] p-4 h-32 focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all"
                                    placeholder="e.g. Leadership, Analytical skills, Punctuality, Creativity."></textarea>
                            </label>
                        </div>
                    </div>

                    <!-- Step 2: Payment & Review -->
                    <div class="form-step hidden" data-step="2">
                        <div class="mb-6">
                            <h2 class="text-2xl font-bold text-text-main dark:text-white">Review & Pay</h2>
                            <p class="text-sm text-text-secondary dark:text-gray-400">Apply coupons and proceed to
                                generate your LOR.</p>
                        </div>

                        <div
                            class="p-6 bg-gray-50 dark:bg-gray-800/30 rounded-xl border border-border-light dark:border-border-dark">
                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                                <div class="flex-1 w-full">
                                    <h3 class="text-lg font-bold text-text-main dark:text-white mb-2">Premium AI LOR
                                    </h3>
                                    <p class="text-xs text-text-secondary dark:text-gray-400 mb-4">Apply a coupon to get
                                        a discount on your professional LOR.</p>

                                    <div class="flex gap-2 max-w-sm">
                                        <input type="text" id="coupon_code" name="coupon_code"
                                            class="flex-1 rounded-lg border border-border-light dark:border-border-dark bg-white dark:bg-[#2a323c] h-11 px-4 text-sm focus:ring-2 focus:ring-primary/50 transition-all uppercase"
                                            placeholder="COUPON CODE">
                                        <button type="button" onclick="applyCoupon()"
                                            class="bg-primary/10 text-primary hover:bg-primary/20 px-4 rounded-lg text-sm font-bold transition-all border border-primary/20">
                                            Apply
                                        </button>
                                    </div>
                                    <p id="coupon-msg" class="text-xs font-medium mt-2 hidden"></p>
                                </div>

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
                            <span id="btnText">Pay & Generate</span>
                            <span class="material-symbols-outlined text-sm">auto_awesome</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Right Column: Info -->
            <div class="w-full lg:w-[380px] flex flex-col gap-6">
                <div
                    class="bg-gradient-to-br from-[#e0f2f8] to-white dark:from-[#2a3a45] dark:to-surface-dark rounded-xl p-6 border border-primary/20 shadow-sm relative overflow-hidden group">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="material-symbols-outlined text-primary">description</span>
                        <h3 class="text-text-main dark:text-white font-bold text-base">LOR Guidelines</h3>
                    </div>
                    <ul class="space-y-4">
                        <li class="flex gap-3 items-start">
                            <span class="text-primary mt-1 material-symbols-outlined text-[18px]">check_circle</span>
                            <div>
                                <p class="text-text-main dark:text-gray-200 text-sm font-semibold">One Page Format</p>
                                <p class="text-text-secondary dark:text-gray-400 text-xs mt-1 leading-relaxed">
                                    Our AI generates a concise, impactful 1-page LOR suitable for University admissions
                                    or Job applications.
                                </p>
                            </div>
                        </li>
                        <li class="flex gap-3 items-start">
                            <span class="text-primary mt-1 material-symbols-outlined text-[18px]">check_circle</span>
                            <div>
                                <p class="text-text-main dark:text-gray-200 text-sm font-semibold">Relationship Clarity
                                </p>
                                <p class="text-text-secondary dark:text-gray-400 text-xs mt-1 leading-relaxed">
                                    Ensures exactly how and for how long the recommender has known the applicant.
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
<div id="loadingOverlay" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden items-center justify-center">
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
        <h3 class="text-xl font-bold text-text-main dark:text-white mb-2">AI is Crafting Your LOR</h3>
        <p class="text-text-secondary dark:text-gray-400 text-sm mb-4">Generating a professional recommendation...</p>
        <div class="flex flex-col gap-2 text-xs text-text-muted dark:text-gray-500">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-accent-green text-sm">check_circle</span>
                <span>Analyzing recommender background</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-sm animate-pulse">pending</span>
                <span>Structuring recommendation points</span>
            </div>
            <div class="flex items-center gap-2 opacity-50">
                <span class="material-symbols-outlined text-sm">radio_button_unchecked</span>
                <span>Finalizing letter format</span>
            </div>
        </div>
    </div>
</div>

<script>
    let currentStep = 1;
    const toolPriceCheck = {
        toolId: 1, // LOR Generator
        calc: null
    };
    const totalSteps = 3; // 1: Details, 2: Payment, 3: Result (Redirect)

    function changeStep(direction) {
        const newStep = currentStep + direction;

        // Validate before moving forward
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
            const required = ['applicant_name', 'recommender_name', 'recommender_title', 'organization', 'projects', 'strengths'];
            let isValid = true;
            required.forEach(name => {
                const el = document.getElementsByName(name)[0];
                if (!el.value.trim()) {
                    el.classList.add('border-red-500');
                    isValid = false;
                } else {
                    el.classList.remove('border-red-500');
                }
            });

            if (!isValid) {
                showNotification('Please fill in all required fields marked with *', 'error');
            }
            return isValid;
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
                // Completed
                stepper.className = 'flex flex-1 items-center gap-3 px-4 py-3 opacity-60';
                stepCircle.className = 'flex items-center justify-center size-8 rounded-full bg-primary/20 text-primary';
                stepCircle.innerHTML = '<span class="material-symbols-outlined text-lg">check</span>';
                stepText.className = 'text-text-main dark:text-gray-300 text-sm font-bold';
            } else if (i === activeStep) {
                // Active
                stepper.className = 'flex flex-1 items-center gap-3 px-4 py-3 bg-primary/5 rounded-lg border border-primary/10';
                stepCircle.className = 'flex items-center justify-center size-8 rounded-full bg-primary text-white shadow-glow';
                stepCircle.innerHTML = `<span class="text-sm font-bold">${i}</span>`;
                stepText.className = 'text-primary text-sm font-bold';
            } else {
                // Future
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

            // Refresh price on entering payment step
            loadInitialPrice();
        }
    }

    // Form Submission with Payment
    document.getElementById('lorForm').addEventListener('submit', async function (e) {
        if (document.getElementById('razorpay_payment_id').value) return; // Already paid

        e.preventDefault();

        // 1. Initial Access Check
        try {
            const response = await fetch('<?= base_url('ai-tools/check-price') ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    tool_id: toolPriceCheck.toolId,
                })
            });

            const data = await response.json();

            if (data.csrf_token) {
                const csrfInput = document.querySelector('input[name="<?= csrf_token() ?>"]');
                if (csrfInput) csrfInput.value = data.csrf_token;
            }

            if (data.error) {
                showNotification(data.error, 'error');
                return;
            }

            // If payment is required
            if ((data.status === 'pending' || data.final_price > 0) && data.final_price > 0 && data.order_id) {
                const options = {
                    "key": data.razorpay_key || "<?= esc($settings['razorpay_key_id'] ?? '') ?>",
                    "amount": data.final_price * 100,
                    "currency": "INR",
                    "name": "<?= esc($settings['site_name'] ?? 'UniHunt') ?>",
                    "description": "Premium AI LOR",
                    "order_id": data.order_id,
                    "handler": function (response) {
                        document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                        document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
                        document.getElementById('razorpay_signature').value = response.razorpay_signature;

                        // Show loading and submit
                        finishSubmission();
                    },
                    "prefill": {
                        "name": document.getElementsByName('applicant_name')[0].value,
                    },
                    "theme": { "color": "#4f46e5" }
                };
                const rzp = new Razorpay(options);
                rzp.on('payment.failed', function (response) {
                    showNotification(response.error.description, 'error');
                });
                rzp.open();
            } else {
                // Free or Waived - proceed immediately
                finishSubmission();
            }
        } catch (error) {
            console.error(error);
            showNotification('Failed to initiate payment. Please try again.', 'error');
        }
    });

    function finishSubmission() {
        // Update UI to Step 3 (Generation/Loading)
        changeStep(3); // Move stepper visually to step 3
        showLoading();
        document.getElementById('lorForm').submit();
    }

    function showLoading() {
        document.getElementById('loadingOverlay').classList.remove('hidden');
        document.getElementById('loadingOverlay').classList.add('flex');
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
                body: JSON.stringify({ tool_id: toolPriceCheck.toolId, coupon_code: code })
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
                btnText.textContent = `Pay ₹${finalPrice.toFixed(2)} & Generate LOR`;
            } else {
                btnText.textContent = 'Generate LOR (Free)';
            }
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

    function showNotification(message, type = 'info') {
        const colors = { success: 'bg-green-500', error: 'bg-red-500', info: 'bg-blue-500' };
        const n = document.createElement('div');
        n.className = `fixed top-4 right-4 z-[9999] px-6 py-3 rounded-lg shadow-lg text-white font-medium transition-all duration-300 ${colors[type]}`;
        n.textContent = message;
        document.body.appendChild(n);
        setTimeout(() => { n.style.opacity = '0'; setTimeout(() => n.remove(), 300); }, 3000);
    }

    // Initialize
    updateStepper(1);
</script>

<?= view('web/include/footer') ?>