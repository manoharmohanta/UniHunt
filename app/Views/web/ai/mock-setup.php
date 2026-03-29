<?= view('web/include/header', [
    'title' => 'Setup Your AI Mock Interview',
    'bodyClass' => 'bg-background-light dark:bg-background-dark font-display min-h-screen flex flex-col transition-colors duration-200'
]) ?>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "SoftwareApplication",
  "name": "AI Mock Interview",
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
    "ratingCount": "1120"
  },
  "description": "Practice for your university admission or visa interview with our AI interviewer and get instant feedback."
}
</script>

<!-- Main Content -->
<main class="flex-1 flex flex-col items-center w-full py-8 px-4 md:px-8">
    <div class="w-full max-w-6xl flex flex-col gap-8">
        <!-- Stepper -->
        <div
            class="w-full bg-surface-light dark:bg-surface-dark rounded-xl border border-border-light dark:border-border-dark shadow-sm p-1 overflow-x-auto">
            <div class="flex justify-between items-center min-w-[600px]">
                <!-- Step 1 -->
                <div id="stepper-1"
                    class="flex flex-1 items-center gap-3 px-4 py-3 bg-primary/5 rounded-lg border border-primary/10">
                    <div class="flex items-center justify-center size-8 rounded-full bg-primary text-white shadow-glow">
                        <span class="text-sm font-bold">1</span>
                    </div>
                    <p class="text-primary text-sm font-bold">Visa & Destination</p>
                    <div class="h-[2px] flex-1 bg-border-light dark:bg-gray-700 mx-2"></div>
                </div>
                <!-- Step 2 -->
                <div id="stepper-2" class="flex flex-1 items-center gap-3 px-4 py-3 opacity-40">
                    <div
                        class="flex items-center justify-center size-8 rounded-full border-2 border-border-light dark:border-gray-600 text-text-secondary dark:text-gray-500">
                        <span class="text-sm font-bold">2</span>
                    </div>
                    <p class="text-text-secondary dark:text-gray-500 text-sm font-bold">Financial Details</p>
                    <div class="h-[2px] flex-1 bg-border-light dark:bg-gray-700 mx-2"></div>
                </div>
                <!-- Step 3 -->
                <div id="stepper-3" class="flex items-center gap-3 px-4 py-3 opacity-40">
                    <div
                        class="flex items-center justify-center size-8 rounded-full border-2 border-border-light dark:border-gray-600 text-text-secondary dark:text-gray-500">
                        <span class="text-sm font-bold">3</span>
                    </div>
                    <p class="text-text-secondary dark:text-gray-500 text-sm font-bold">Interview Intensity</p>
                </div>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8 items-start">
            <!-- Left Column: Form -->
            <div
                class="flex-1 w-full bg-surface-light dark:bg-surface-dark rounded-xl border border-border-light dark:border-border-dark shadow-soft p-6 md:p-8">
                <form id="mockSetupForm" action="<?= base_url('ai-tools/mock-session') ?>" method="POST"
                    class="flex flex-col gap-6">
                    <?= csrf_field() ?>

                    <!-- Step 1: Destination -->
                    <div id="step-1" class="step-content">
                        <div class="mb-6">
                            <h2 class="text-2xl font-bold text-text-main dark:text-white">Visa & Destination</h2>
                            <p class="text-sm text-text-secondary dark:text-gray-400">Tell us where you're heading and
                                your visa category.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <label class="flex flex-col gap-2">
                                <span class="text-sm font-semibold text-text-main dark:text-gray-200">Target Country
                                    <span class="text-red-500">*</span></span>
                                <select name="country" id="country" required
                                    class="w-full rounded-lg border border-border-light dark:border-border-dark bg-white dark:bg-[#2a323c] h-12 px-4 focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all text-text-main dark:text-white">
                                    <option value="USA">USA</option>
                                    <option value="UK">UK</option>
                                    <option value="Australia">Australia</option>
                                    <option value="Canada">Canada</option>
                                    <option value="Ireland">Ireland</option>
                                    <option value="Germany">Germany</option>
                                    <option value="New Zealand">New Zealand</option>
                                    <option value="Switzerland">Switzerland</option>
                                    <option value="Sweden">Sweden</option>
                                    <option value="Finland">Finland</option>
                                    <option value="Dubai">Dubai (UAE)</option>
                                    <option value="Singapore">Singapore</option>
                                </select>
                            </label>

                            <label class="flex flex-col gap-2">
                                <span class="text-sm font-semibold text-text-main dark:text-gray-200">Interview/Visa
                                    Category <span class="text-red-500">*</span></span>
                                <select name="visa_type" id="visa_type" required
                                    class="w-full rounded-lg border border-border-light dark:border-border-dark bg-white dark:bg-[#2a323c] h-12 px-4 focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all text-text-main dark:text-white">
                                    <!-- Populated via JS -->
                                </select>
                            </label>
                        </div>

                        <div id="study_details" class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                            <label class="flex flex-col gap-2">
                                <span class="text-sm font-semibold text-text-main dark:text-gray-200">University
                                    Name</span>
                                <input type="text" name="university" id="university"
                                    placeholder="e.g. Stanford University"
                                    class="w-full rounded-lg border border-border-light dark:border-border-dark bg-white dark:bg-[#2a323c] h-12 px-4 focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all text-text-main dark:text-white">
                            </label>
                            <label class="flex flex-col gap-2">
                                <span class="text-sm font-semibold text-text-main dark:text-gray-200">Course Name</span>
                                <input type="text" name="course" id="course"
                                    placeholder="e.g. Masters in Computer Science"
                                    class="w-full rounded-lg border border-border-light dark:border-border-dark bg-white dark:bg-[#2a323c] h-12 px-4 focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all text-text-main dark:text-white">
                            </label>
                        </div>

                        <div class="flex items-center justify-end mt-8">
                            <button type="button" onclick="nextStep(1)"
                                class="bg-primary hover:bg-[#158bb3] text-white font-bold text-sm px-10 py-4 rounded-xl shadow-lg shadow-primary/30 flex items-center gap-3 transition-all transform hover:-translate-y-1">
                                Next: Financial Details
                                <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </button>
                        </div>
                    </div>

                    <!-- Step 2: Financials -->
                    <div id="step-2" class="step-content hidden">
                        <div class="mb-6">
                            <h2 class="text-2xl font-bold text-text-main dark:text-white">Financial Details</h2>
                            <p class="text-sm text-text-secondary dark:text-gray-400">Share your funding sources and
                                financial capability.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <label class="flex flex-col gap-2">
                                <span class="text-sm font-semibold text-text-main dark:text-gray-200">Primary Sponsor
                                    <span class="text-red-500">*</span></span>
                                <input type="text" name="sponsor" id="sponsor" required
                                    placeholder="e.g. Father, Education Loan, Self"
                                    class="w-full rounded-lg border border-border-light dark:border-border-dark bg-white dark:bg-[#2a323c] h-12 px-4 focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all text-text-main dark:text-white">
                            </label>
                            <label class="flex flex-col gap-2">
                                <span class="text-sm font-semibold text-text-main dark:text-gray-200">Annual
                                    Income/Savings ($) <span class="text-red-500">*</span></span>
                                <input type="text" name="finances" id="finances" required placeholder="e.g. $50,000"
                                    class="w-full rounded-lg border border-border-light dark:border-border-dark bg-white dark:bg-[#2a323c] h-12 px-4 focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all text-text-main dark:text-white">
                            </label>
                        </div>

                        <div class="flex items-center justify-between mt-8">
                            <button type="button" onclick="prevStep(2)"
                                class="text-text-secondary hover:text-text-main dark:text-gray-400 dark:hover:text-white font-semibold text-sm px-6 py-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">arrow_back</span>
                                Back
                            </button>
                            <button type="button" onclick="nextStep(2)"
                                class="bg-primary hover:bg-[#158bb3] text-white font-bold text-sm px-10 py-4 rounded-xl shadow-lg shadow-primary/30 flex items-center gap-3 transition-all transform hover:-translate-y-1">
                                Next: Interview Intensity
                                <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </button>
                        </div>
                    </div>

                    <!-- Step 3: Intensity -->
                    <div id="step-3" class="step-content hidden">
                        <div class="mb-6">
                            <h2 class="text-2xl font-bold text-text-main dark:text-white">Interview Intensity</h2>
                            <p class="text-sm text-text-secondary dark:text-gray-400">Choose the difficulty level for
                                your mock session.</p>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                            <label class="relative cursor-pointer group">
                                <input type="radio" name="difficulty" value="Easy" class="peer sr-only" checked>
                                <div
                                    class="p-6 rounded-2xl border-2 border-border-light dark:border-border-dark bg-white dark:bg-[#2a323c] peer-checked:border-primary peer-checked:bg-primary/5 text-center transition-all group-hover:shadow-md">
                                    <span
                                        class="block text-xl font-bold text-text-main dark:text-white group-hover:text-primary mb-1">Easy</span>
                                    <span
                                        class="text-[10px] text-text-secondary uppercase tracking-tighter leading-none">Supportive
                                        Officer</span>
                                </div>
                            </label>
                            <label class="relative cursor-pointer group">
                                <input type="radio" name="difficulty" value="Medium" class="peer sr-only">
                                <div
                                    class="p-6 rounded-2xl border-2 border-border-light dark:border-border-dark bg-white dark:bg-[#2a323c] peer-checked:border-primary peer-checked:bg-primary/5 text-center transition-all group-hover:shadow-md">
                                    <span
                                        class="block text-xl font-bold text-text-main dark:text-white group-hover:text-primary mb-1">Medium</span>
                                    <span
                                        class="text-[10px] text-text-secondary uppercase tracking-tighter leading-none">Professional
                                        Neutral</span>
                                </div>
                            </label>
                            <label class="relative cursor-pointer group">
                                <input type="radio" name="difficulty" value="Hard" class="peer sr-only">
                                <div
                                    class="p-6 rounded-2xl border-2 border-border-light dark:border-border-dark bg-white dark:bg-[#2a323c] peer-checked:border-primary peer-checked:bg-primary/5 text-center transition-all group-hover:shadow-md">
                                    <span
                                        class="block text-xl font-bold text-text-main dark:text-white group-hover:text-primary mb-1">Hard</span>
                                    <span
                                        class="text-[10px] text-text-secondary uppercase tracking-tighter leading-none">Stressful
                                        Grilling</span>
                                </div>
                            </label>
                        </div>

                        <div
                            class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mt-6">
                            <div class="flex gap-3">
                                <span class="material-symbols-outlined text-blue-600 dark:text-blue-400">info</span>
                                <div>
                                    <p class="text-sm font-semibold text-blue-900 dark:text-blue-300 mb-1">Microphone
                                        Access Ready</p>
                                    <p class="text-xs text-blue-700 dark:text-blue-400">Your browser will request
                                        microphone access to start the AI conversation and real-time transcription.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Payment & Coupon Section -->
                        <div class="mt-8 border-t border-border-light dark:border-border-dark pt-8">
                            <h3 class="text-lg font-bold text-text-main dark:text-white mb-4 flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary">payments</span>
                                Premium Interview Session
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
                                <!-- Coupon Input -->
                                <div class="flex flex-col gap-3">
                                    <label class="text-sm font-semibold text-text-main dark:text-gray-200 text-sm">Have
                                        a Coupon Code?</label>
                                    <div class="flex gap-2">
                                        <input type="text" id="coupon_code" name="coupon_code"
                                            class="flex-1 rounded-lg border border-border-light dark:border-border-dark bg-white dark:bg-[#2a323c] h-11 px-4 text-sm focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all uppercase"
                                            placeholder="ENTER CODE">
                                        <button type="button" onclick="applyCoupon()"
                                            class="bg-surface-light dark:bg-[#343d4a] text-primary dark:text-white border border-primary/20 hover:bg-primary/5 px-4 rounded-lg text-sm font-bold transition-all">
                                            Apply
                                        </button>
                                    </div>
                                    <p id="coupon-msg" class="text-xs font-medium hidden"></p>
                                </div>

                                <!-- Price Details -->
                                <div
                                    class="bg-gray-50 dark:bg-gray-800/30 rounded-xl p-5 border border-border-light dark:border-border-dark">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-xs text-text-secondary dark:text-gray-400 font-medium">Session
                                            Price</span>
                                        <span
                                            class="text-sm font-bold text-text-main dark:text-white line-through opacity-50"
                                            id="original-price-display">₹0.00</span>
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
                                            id="final-price-display">₹0.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden Payment Fields -->
                        <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
                        <input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
                        <input type="hidden" name="razorpay_signature" id="razorpay_signature">

                        <div class="flex items-center justify-between mt-8">
                            <button type="button" onclick="prevStep(3)"
                                class="text-text-secondary hover:text-text-main dark:text-gray-400 dark:hover:text-white font-semibold text-sm px-6 py-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">arrow_back</span>
                                Back
                            </button>
                            <button type="submit" id="submitBtn"
                                class="bg-gradient-to-r from-primary to-primary-dark hover:shadow-xl text-white font-bold text-sm px-10 py-4 rounded-xl shadow-lg shadow-primary/30 flex items-center gap-3 transition-all transform hover:-translate-y-1">
                                <span id="btnText">Start AI Mock Interview</span>
                                <span class="material-symbols-outlined text-sm">rocket_launch</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Right Column: Info -->
            <div class="w-full lg:w-[380px] flex flex-col gap-6">
                <div
                    class="bg-gradient-to-br from-[#e0f2f8] to-white dark:from-[#2a3a45] dark:to-surface-dark rounded-xl p-6 border border-primary/20 shadow-sm relative overflow-hidden group">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="material-symbols-outlined text-primary">info</span>
                        <h3 class="text-text-main dark:text-white font-bold text-base">Preparation Tips</h3>
                    </div>
                    <ul class="space-y-4">
                        <li class="flex gap-3 items-start">
                            <span class="text-primary mt-1 material-symbols-outlined text-[18px]">verified</span>
                            <div>
                                <p class="text-text-main dark:text-gray-200 text-sm font-semibold">Speak Naturally</p>
                                <p class="text-text-secondary dark:text-gray-400 text-xs mt-1 leading-relaxed">
                                    The AI detects pace and clarity. Try to be as authentic as possible.
                                </p>
                            </div>
                        </li>
                        <li class="flex gap-3 items-start">
                            <span class="text-primary mt-1 material-symbols-outlined text-[18px]">verified</span>
                            <div>
                                <p class="text-text-main dark:text-gray-200 text-sm font-semibold">Financial Accuracy
                                </p>
                                <p class="text-text-secondary dark:text-gray-400 text-xs mt-1 leading-relaxed">
                                    Officers check if you understand your sponsorship. Be specific about amounts.
                                </p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    let currentStep = 1;
    const totalSteps = 3;

    const visaOptions = {
        'USA': ['F1 Student Visa', 'J1 Exchange Visitor', 'B1/B2 Visitor', 'H1B Work Visa'],
        'UK': ['Credibility Interview (CAS)', 'Student Visa (Tier 4)', 'Standard Visitor', 'Skilled Worker'],
        'Australia': ['GS (Genuine Student) Interview', 'Student Visa (Subclass 500)', 'Visitor Visa (600)', 'Work Visa'],
        'Canada': ['Study Permit Interview', 'Visitor Visa', 'Work Permit'],
        'Ireland': ['Study Visa Interview', 'Visit Visa'],
        'Germany': ['Student Visa Interview', 'Job Seeker Visa', 'Schengen Visitor'],
        'New Zealand': ['Student Visa', 'Visitor Visa'],
        'Switzerland': ['Admission Interview', 'National Visa D (Student)'],
        'Sweden': ['University Interview', 'Residence Permit (Studies)'],
        'Finland': ['University Interview', 'Residence Permit (Studies)'],
        'Dubai': ['University Interview', 'Student Visa'],
        'Singapore': ['Student Pass Interview', 'Social Visit Pass'],
        'default': ['Student Visa Interview', 'Visitor Visa', 'Work Visa']
    };

    function populateVisaOptions() {
        const country = document.getElementById('country').value;
        const visaSelect = document.getElementById('visa_type');
        const options = visaOptions[country] || visaOptions['default'];

        visaSelect.innerHTML = '';
        options.forEach(opt => {
            const el = document.createElement('option');
            el.value = opt;
            el.textContent = opt;
            visaSelect.appendChild(el);
        });

        // Trigger change to update UI state
        visaSelect.dispatchEvent(new Event('change'));
    }

    // Initialize and Listen
    document.getElementById('country').addEventListener('change', populateVisaOptions);
    document.getElementById('visa_type').addEventListener('change', function () {
        const studyDetails = document.getElementById('study_details');
        const val = this.value.toLowerCase();
        // Show study details for student/university related interviews
        if (val.includes('student') || val.includes('study') || val.includes('university') || val.includes('admission') || val.includes('cas') || val.includes('gs')) {
            studyDetails.classList.remove('opacity-20', 'pointer-events-none');
        } else {
            studyDetails.classList.add('opacity-20', 'pointer-events-none');
        }
    });

    // Run once on load
    populateVisaOptions();

    function nextStep(step) {
        if (!validateStep(step)) return;

        document.getElementById(`step-${step}`).classList.add('hidden');
        const nextStepNum = step + 1;
        document.getElementById(`step-${nextStepNum}`).classList.remove('hidden');
        updateStepper(nextStepNum);
        currentStep = nextStepNum;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function prevStep(step) {
        document.getElementById(`step-${step}`).classList.add('hidden');
        const prevStepNum = step - 1;
        document.getElementById(`step-${prevStepNum}`).classList.remove('hidden');
        updateStepper(prevStepNum);
        currentStep = prevStepNum;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function validateStep(step) {
        if (step === 1) {
            const country = document.getElementById('country').value;
            const visa = document.getElementById('visa_type').value;
            if (!country || !visa) {
                showNotification('Please select country and visa type', 'error');
                return false;
            }
        } else if (step === 2) {
            const sponsor = document.getElementById('sponsor').value.trim();
            const finances = document.getElementById('finances').value.trim();
            if (!sponsor || !finances) {
                showNotification('Please provide financial details', 'error');
                return false;
            }
        }
        return true;
    }

    function updateStepper(activeStep) {
        for (let i = 1; i <= totalSteps; i++) {
            const stepper = document.getElementById(`stepper-${i}`);
            const stepCircle = stepper.querySelector('div');
            const stepText = stepper.querySelector('p');

            if (i < activeStep) {
                stepper.classList.remove('bg-primary/5', 'border-primary/10', 'opacity-40');
                stepper.classList.add('opacity-60');
                stepCircle.className = 'flex items-center justify-center size-8 rounded-full bg-primary/20 text-primary';
                stepCircle.innerHTML = '<span class="material-symbols-outlined text-lg">check</span>';
                stepText.classList.remove('text-primary', 'text-text-secondary', 'dark:text-gray-500');
                stepText.classList.add('text-text-main', 'dark:text-gray-300');
            } else if (i === activeStep) {
                stepper.classList.remove('opacity-40', 'opacity-60');
                stepper.classList.add('bg-primary/5', 'border-primary/10');
                stepCircle.className = 'flex items-center justify-center size-8 rounded-full bg-primary text-white shadow-glow';
                stepCircle.innerHTML = `<span class="text-sm font-bold">${i}</span>`;
                stepText.classList.remove('text-text-secondary', 'dark:text-gray-500', 'text-text-main', 'dark:text-gray-300');
                stepText.classList.add('text-primary');
            } else {
                stepper.classList.remove('bg-primary/5', 'border-primary/10', 'opacity-60');
                stepper.classList.add('opacity-40');
                stepCircle.className = 'flex items-center justify-center size-8 rounded-full border-2 border-border-light dark:border-gray-600 text-text-secondary dark:text-gray-500';
                stepCircle.innerHTML = `<span class="text-sm font-bold">${i}</span>`;
                stepText.classList.remove('text-primary', 'text-text-main', 'dark:text-gray-300');
                stepText.classList.add('text-text-secondary', 'dark:text-gray-500');
            }
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

    // Show loading overlay on form submit
    document.getElementById('mockSetupForm').addEventListener('submit', async function (e) {
        e.preventDefault();

        // 1. Initial Access Check
        try {
            const response = await fetch('<?= base_url('ai-tools/check-price') ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    tool_id: 6, // Mock Interview
                    coupon_code: document.getElementById('coupon_code').value
                })
            });

            const data = await response.json();

            if (data.error) {
                showNotification(data.error, 'error');
                return;
            }

            // If payment is required
            if ((data.status === 'pending' || data.final_price > 0) && data.final_price > 0 && data.order_id) {
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
                    "description": "Premium Mock Interview",
                    "order_id": data.order_id,
                    "handler": function (response) {
                        document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                        document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
                        document.getElementById('razorpay_signature').value = response.razorpay_signature;

                        // Now submit the form for real
                        document.getElementById('mockSetupForm').submit();
                    },
                    "prefill": {
                        "name": "Applicant",
                    },
                    "theme": { "color": "#1da1f2" }
                };
                const rzp = new Razorpay(options);
                rzp.on('payment.failed', function (response) {
                    showNotification(response.error.description, 'error');
                });
                rzp.open();
            } else {
                // Free or Waived - proceed immediately
                document.getElementById('mockSetupForm').submit();
            }
        } catch (error) {
            console.error(error);
            // Fallback: If the UI shows free/0.00, assume it's free and allow submission
            const priceDisplay = document.getElementById('final-price-display');
            if (priceDisplay && (priceDisplay.textContent.includes('0.00') || priceDisplay.textContent.trim() === '₹0')) {
                document.getElementById('mockSetupForm').submit();
                return;
            }

            showNotification('Failed to initiate payment. Please try again.', 'error');
        }
    });

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
                body: JSON.stringify({ tool_id: 6, coupon_code: code })
            });
            const data = await response.json();
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
                btnText.textContent = `Pay ₹${finalPrice.toFixed(2)} & Start Interview`;
            } else {
                btnText.textContent = 'Start AI Mock Interview (Free)';
            }
        }
    }

    // Load initial price on step 3
    const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                if (!document.getElementById('step-3').classList.contains('hidden')) {
                    loadInitialPrice();
                }
            }
        });
    });
    observer.observe(document.getElementById('step-3'), { attributes: true });

    async function loadInitialPrice() {
        try {
            const response = await fetch('<?= base_url('ai-tools/check-price') ?>', {
                method: 'POST', headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ tool_id: 6 })
            });
            const data = await response.json();
            if (!data.error) updatePriceUI(data);
        } catch (e) { }
    }
</script>

<!-- Razorpay Checkout -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<?= view('web/include/footer') ?>