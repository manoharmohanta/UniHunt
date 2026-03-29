<?= view('web/include/header', [
    'title' => 'AI SOP Generator | Create a Winning Statement of Purpose',
    'meta_desc' => 'Generate a professional, visa-optimized Statement of Purpose (SOP) in minutes. Our AI covers academic background, career goals, and university-specific details for higher approval rates.',
    'bodyClass' => 'bg-background-light dark:bg-background-dark font-display min-h-screen flex flex-col transition-colors duration-200'
]) ?>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "SoftwareApplication",
  "name": "AI SOP Generator",
  "operatingSystem": "Web",
  "applicationCategory": "EducationalApplication",
  "offers": {
    "@type": "Offer",
    "price": "499",
    "priceCurrency": "INR"
  },
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "4.8",
    "ratingCount": "1540"
  },
  "description": "Generate a professional, visa-optimized Statement of Purpose (SOP) for university applications in minutes using AI."
}
</script>

<!-- Main Content -->
<main class="flex-1 flex flex-col items-center w-full py-8 px-4 md:px-8">
    <div class="w-full max-w-6xl flex flex-col gap-8">
        <!-- Breadcrumbs -->
        <div class="flex flex-wrap gap-2 px-0">
            <a class="text-[#5e888d] text-sm font-medium leading-normal hover:text-primary transition-colors"
                href="<?= base_url('ai-tools') ?>">AI Tools</a>
            <span class="text-[#5e888d] text-sm font-medium leading-normal">/</span>
            <span class="text-[#101818] dark:text-white text-sm font-medium leading-normal">SOP Generator</span>
        </div>

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
                    <p class="text-primary text-sm font-bold">Basic Info</p>
                    <div class="h-[2px] flex-1 bg-border-light dark:bg-gray-700 mx-2"></div>
                </div>
                <!-- Step 2 -->
                <div id="stepper-2" class="flex flex-1 items-center gap-3 px-4 py-3 opacity-40">
                    <div
                        class="flex items-center justify-center size-8 rounded-full border-2 border-border-light dark:border-gray-600 text-text-secondary dark:text-gray-500">
                        <span class="text-sm font-bold">2</span>
                    </div>
                    <p class="text-text-secondary dark:text-gray-500 text-sm font-bold">Academic Details</p>
                    <div class="h-[2px] flex-1 bg-border-light dark:bg-gray-700 mx-2"></div>
                </div>
                <!-- Step 3 -->
                <div id="stepper-3" class="flex items-center gap-3 px-4 py-3 opacity-40">
                    <div
                        class="flex items-center justify-center size-8 rounded-full border-2 border-border-light dark:border-gray-600 text-text-secondary dark:text-gray-500">
                        <span class="text-sm font-bold">3</span>
                    </div>
                    <p class="text-text-secondary dark:text-gray-500 text-sm font-bold">Review & Submit</p>
                </div>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8 items-start">
            <!-- Left Column: Form -->
            <div
                class="flex-1 w-full bg-surface-light dark:bg-surface-dark rounded-xl border border-border-light dark:border-border-dark shadow-soft p-6 md:p-8">
                <form id="sopForm" action="<?= base_url('ai-tools/generate-sop') ?>" method="POST"
                    class="flex flex-col gap-6">
                    <?= csrf_field() ?>
                    <?= honeypot_field() ?>

                    <!-- Step 1: Basic Info -->
                    <div id="step-1" class="step-content">
                        <div class="mb-4">
                            <h2 class="text-2xl font-bold text-text-main dark:text-white">Basic Information</h2>
                            <p class="text-sm text-text-secondary dark:text-gray-400">Let's start with your personal
                                details and target destination.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <label class="flex flex-col gap-2">
                                <span class="text-sm font-semibold text-text-main dark:text-gray-200">Full Name <span
                                        class="text-red-500">*</span></span>
                                <input type="text" name="name" id="name" required
                                    class="w-full rounded-lg border border-border-light dark:border-border-dark bg-white dark:bg-[#2a323c] h-12 px-4 focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all"
                                    placeholder="John Doe">
                            </label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="flex flex-col gap-2">
                                    <span class="text-sm font-semibold text-text-main dark:text-gray-200">Home Country
                                        <span class="text-red-500">*</span></span>
                                    <input type="text" name="home_country" id="home_country" required
                                        class="w-full rounded-lg border border-border-light dark:border-border-dark bg-white dark:bg-[#2a323c] h-12 px-4 focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all"
                                        placeholder="e.g. India">
                                </label>
                                <label class="flex flex-col gap-2">
                                    <span class="text-sm font-semibold text-text-main dark:text-gray-200">Target Country
                                        <span class="text-red-500">*</span></span>
                                    <select name="target_country" id="target_country" required
                                        class="w-full rounded-lg border border-border-light dark:border-border-dark bg-white dark:bg-[#2a323c] h-12 px-4 focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all">
                                        <option value="USA">USA</option>
                                        <option value="UK">UK</option>
                                        <option value="Ireland">Ireland</option>
                                        <option value="Europe">Europe</option>
                                        <option value="Canada">Canada</option>
                                        <option value="Australia">Australia</option>
                                        <option value="New Zealand">New Zealand</option>
                                    </select>
                                </label>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <label class="flex flex-col gap-2">
                                <span class="text-sm font-semibold text-text-main dark:text-gray-200">University Name
                                    <span class="text-red-500">*</span></span>
                                <input type="text" name="university" id="university" required
                                    class="w-full rounded-lg border border-border-light dark:border-border-dark bg-white dark:bg-[#2a323c] h-12 px-4 focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all"
                                    placeholder="University of Toronto">
                            </label>
                            <label class="flex flex-col gap-2">
                                <span class="text-sm font-semibold text-text-main dark:text-gray-200">Course Name <span
                                        class="text-red-500">*</span></span>
                                <input type="text" name="course" id="course" required
                                    class="w-full rounded-lg border border-border-light dark:border-border-dark bg-white dark:bg-[#2a323c] h-12 px-4 focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all"
                                    placeholder="MSc in Data Science">
                            </label>
                        </div>

                        <div class="flex items-center justify-end mt-8">
                            <button type="button" onclick="nextStep(1)"
                                class="bg-primary hover:bg-[#158bb3] text-white font-bold text-sm px-10 py-4 rounded-xl shadow-lg shadow-primary/30 flex items-center gap-3 transition-all transform hover:-translate-y-1">
                                Next: Academic Details
                                <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </button>
                        </div>
                    </div>

                    <!-- Step 2: Academic Details -->
                    <div id="step-2" class="step-content hidden">
                        <div class="mb-4">
                            <h2 class="text-2xl font-bold text-text-main dark:text-white">Academic Background</h2>
                            <p class="text-sm text-text-secondary dark:text-gray-400">Share your educational journey and
                                achievements.</p>
                        </div>

                        <label class="flex flex-col gap-2">
                            <span class="text-sm font-semibold text-text-main dark:text-gray-200">Academic Background &
                                Projects <span class="text-red-500">*</span></span>
                            <textarea name="academic_background" id="academic_background" required
                                class="w-full rounded-lg border border-border-light dark:border-border-dark bg-white dark:bg-[#2a323c] p-4 h-40 focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all"
                                placeholder="Mention your degree, college, key subjects, GPA, and any notable projects or research."></textarea>
                        </label>

                        <label class="flex flex-col gap-2">
                            <span class="text-sm font-semibold text-text-main dark:text-gray-200">Professional
                                Experience or Personal Motivations (Optional)</span>
                            <textarea name="about_profile" id="about_profile"
                                class="w-full rounded-lg border border-border-light dark:border-border-dark bg-white dark:bg-[#2a323c] p-4 h-32 focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all"
                                placeholder="Mention work experience, internships, or why you are passionate about this field."></textarea>
                        </label>

                        <div class="flex items-center justify-between mt-8">
                            <button type="button" onclick="prevStep(2)"
                                class="text-text-secondary hover:text-text-main dark:text-gray-400 dark:hover:text-white font-semibold text-sm px-6 py-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">arrow_back</span>
                                Back
                            </button>
                            <button type="button" onclick="nextStep(2)"
                                class="bg-primary hover:bg-[#158bb3] text-white font-bold text-sm px-10 py-4 rounded-xl shadow-lg shadow-primary/30 flex items-center gap-3 transition-all transform hover:-translate-y-1">
                                Review & Submit
                                <span class="material-symbols-outlined text-sm">arrow_forward</span>
                            </button>
                        </div>
                    </div>

                    <!-- Step 3: Review & Submit -->
                    <div id="step-3" class="step-content hidden">
                        <div class="mb-4">
                            <h2 class="text-2xl font-bold text-text-main dark:text-white">Review Your Information</h2>
                            <p class="text-sm text-text-secondary dark:text-gray-400">Please verify all details before
                                generating your SOP.</p>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-800/50 rounded-xl p-6 space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p
                                        class="text-xs text-text-secondary dark:text-gray-500 uppercase tracking-wider mb-1">
                                        Full Name</p>
                                    <p id="review-name" class="text-sm font-semibold text-text-main dark:text-white">-
                                    </p>
                                </div>
                                <div>
                                    <p
                                        class="text-xs text-text-secondary dark:text-gray-500 uppercase tracking-wider mb-1">
                                        Target Destination</p>
                                    <p id="review-destination"
                                        class="text-sm font-semibold text-text-main dark:text-white">-</p>
                                </div>
                                <div>
                                    <p
                                        class="text-xs text-text-secondary dark:text-gray-500 uppercase tracking-wider mb-1">
                                        University</p>
                                    <p id="review-university"
                                        class="text-sm font-semibold text-text-main dark:text-white">-</p>
                                </div>
                                <div>
                                    <p
                                        class="text-xs text-text-secondary dark:text-gray-500 uppercase tracking-wider mb-1">
                                        Course</p>
                                    <p id="review-course" class="text-sm font-semibold text-text-main dark:text-white">-
                                    </p>
                                </div>
                            </div>
                            <div>
                                <p class="text-xs text-text-secondary dark:text-gray-500 uppercase tracking-wider mb-1">
                                    Academic Background</p>
                                <p id="review-academic" class="text-sm text-text-main dark:text-gray-300 line-clamp-3">-
                                </p>
                            </div>
                        </div>

                        <!-- Payment & Coupon Section -->
                        <div class="mt-8 border-t border-border-light dark:border-border-dark pt-8">
                            <h3 class="text-lg font-bold text-text-main dark:text-white mb-4 flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary">payments</span>
                                Payment Summary
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
                                <!-- Coupon Input -->
                                <div class="flex flex-col gap-3">
                                    <label class="text-sm font-semibold text-text-main dark:text-gray-200">Have
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
                                        <span
                                            class="text-xs text-text-secondary dark:text-gray-400 font-medium">Original
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

                        <div
                            class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mt-6">
                            <div class="flex gap-3">
                                <span class="material-symbols-outlined text-blue-600 dark:text-blue-400">info</span>
                                <div>
                                    <p class="text-sm font-semibold text-blue-900 dark:text-blue-300 mb-1">AI Will
                                        Generate</p>
                                    <p class="text-xs text-blue-700 dark:text-blue-400">Our AI will automatically create
                                        compelling content for: Why this University, Why this Country, and Future Career
                                        Plans based on your profile.</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-8">
                            <button type="button" onclick="prevStep(3)"
                                class="text-text-secondary hover:text-text-main dark:text-gray-400 dark:hover:text-white font-semibold text-sm px-6 py-3 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">arrow_back</span>
                                Back
                            </button>
                            <button type="submit" id="submitBtn"
                                class="bg-gradient-to-r from-primary to-primary-dark hover:shadow-xl text-white font-bold text-sm px-10 py-4 rounded-xl shadow-lg shadow-primary/30 flex items-center gap-3 transition-all transform hover:-translate-y-1">
                                <span id="btnText">Generate SOP with AI</span>
                                <span class="material-symbols-outlined text-sm">auto_awesome</span>
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
                        <h3 class="text-text-main dark:text-white font-bold text-base">SOP Requirements</h3>
                    </div>
                    <ul class="space-y-4">
                        <li class="flex gap-3 items-start">
                            <span class="text-primary mt-1 material-symbols-outlined text-[18px]">verified</span>
                            <div>
                                <p class="text-text-main dark:text-gray-200 text-sm font-semibold">Word Count Policy</p>
                                <p class="text-text-secondary dark:text-gray-400 text-xs mt-1 leading-relaxed">
                                    <span class="font-bold text-primary">USA/UK/Ireland:</span> 750-1000 words.<br>
                                    <span class="font-bold text-primary">Canada/AUS/NZ:</span> 3000-7000 words.
                                </p>
                            </div>
                        </li>
                        <li class="flex gap-3 items-start">
                            <span class="text-primary mt-1 material-symbols-outlined text-[18px]">verified</span>
                            <div>
                                <p class="text-text-main dark:text-gray-200 text-sm font-semibold">Critical Topics</p>
                                <p class="text-text-secondary dark:text-gray-400 text-xs mt-1 leading-relaxed">
                                    Our AI ensures you cover Career Plans, Why not home country, and Academic depth for
                                    high visa approval.
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
        <h3 class="text-xl font-bold text-text-main dark:text-white mb-2">AI is Crafting Your SOP</h3>
        <p class="text-text-secondary dark:text-gray-400 text-sm mb-4">This may take 30-60 seconds...</p>
        <div class="flex flex-col gap-2 text-xs text-text-muted dark:text-gray-500">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-accent-green text-sm">check_circle</span>
                <span>Analyzing your profile</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-sm animate-pulse">pending</span>
                <span>Generating personalized content</span>
            </div>
            <div class="flex items-center gap-2 opacity-50">
                <span class="material-symbols-outlined text-sm">radio_button_unchecked</span>
                <span>Optimizing for visa approval</span>
            </div>
        </div>
    </div>
</div>

<script>
    let currentStep = 1;
    const totalSteps = 3;

    function nextStep(step) {
        // Validate current step before proceeding
        if (!validateStep(step)) {
            return;
        }

        // Hide current step
        document.getElementById(`step-${step}`).classList.add('hidden');

        // Show next step
        const nextStepNum = step + 1;
        document.getElementById(`step-${nextStepNum}`).classList.remove('hidden');

        // Update stepper UI
        updateStepper(nextStepNum);

        // If moving to step 3 (review), populate review data
        if (nextStepNum === 3) {
            populateReview();
        }

        currentStep = nextStepNum;

        // Scroll to top
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function prevStep(step) {
        // Hide current step
        document.getElementById(`step-${step}`).classList.add('hidden');

        // Show previous step
        const prevStepNum = step - 1;
        document.getElementById(`step-${prevStepNum}`).classList.remove('hidden');

        // Update stepper UI
        updateStepper(prevStepNum);

        currentStep = prevStepNum;

        // Scroll to top
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function validateStep(step) {
        if (step === 1) {
            const name = document.getElementById('name').value.trim();
            const homeCountry = document.getElementById('home_country').value.trim();
            const targetCountry = document.getElementById('target_country').value;
            const university = document.getElementById('university').value.trim();
            const course = document.getElementById('course').value.trim();

            if (!name || !homeCountry || !targetCountry || !university || !course) {
                showNotification('Please fill in all required fields', 'error');
                return false;
            }
        } else if (step === 2) {
            const academicBackground = document.getElementById('academic_background').value.trim();

            if (!academicBackground) {
                showNotification('Please provide your academic background', 'error');
                return false;
            }
        }
        return true;
    }

    function updateStepper(activeStep) {
        // Reset all steppers
        for (let i = 1; i <= totalSteps; i++) {
            const stepper = document.getElementById(`stepper-${i}`);
            const stepCircle = stepper.querySelector('div');
            const stepText = stepper.querySelector('p');

            if (i < activeStep) {
                // Completed step
                stepper.classList.remove('bg-primary/5', 'border-primary/10', 'opacity-40');
                stepper.classList.add('opacity-60');
                stepCircle.className = 'flex items-center justify-center size-8 rounded-full bg-primary/20 text-primary';
                stepCircle.innerHTML = '<span class="material-symbols-outlined text-lg">check</span>';
                stepText.classList.remove('text-primary', 'text-text-secondary', 'dark:text-gray-500');
                stepText.classList.add('text-text-main', 'dark:text-gray-300');
            } else if (i === activeStep) {
                // Active step
                stepper.classList.remove('opacity-40', 'opacity-60');
                stepper.classList.add('bg-primary/5', 'border-primary/10');
                stepCircle.className = 'flex items-center justify-center size-8 rounded-full bg-primary text-white shadow-glow';
                stepCircle.innerHTML = `<span class="text-sm font-bold">${i}</span>`;
                stepText.classList.remove('text-text-secondary', 'dark:text-gray-500', 'text-text-main', 'dark:text-gray-300');
                stepText.classList.add('text-primary');
            } else {
                // Future step
                stepper.classList.remove('bg-primary/5', 'border-primary/10', 'opacity-60');
                stepper.classList.add('opacity-40');
                stepCircle.className = 'flex items-center justify-center size-8 rounded-full border-2 border-border-light dark:border-gray-600 text-text-secondary dark:text-gray-500';
                stepCircle.innerHTML = `<span class="text-sm font-bold">${i}</span>`;
                stepText.classList.remove('text-primary', 'text-text-main', 'dark:text-gray-300');
                stepText.classList.add('text-text-secondary', 'dark:text-gray-500');
            }
        }
    }

    function populateReview() {
        document.getElementById('review-name').textContent = document.getElementById('name').value || '-';
        document.getElementById('review-destination').textContent =
            `${document.getElementById('home_country').value} → ${document.getElementById('target_country').value}`;
        document.getElementById('review-university').textContent = document.getElementById('university').value || '-';
        document.getElementById('review-course').textContent = document.getElementById('course').value || '-';
        document.getElementById('review-academic').textContent = document.getElementById('academic_background').value || '-';
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

    // Show loading overlay on form submit
    document.getElementById('sopForm').addEventListener('submit', async function (e) {
        e.preventDefault();

        const submitBtn = document.getElementById('submitBtn');
        const originalBtnHtml = submitBtn.innerHTML;

        // 1. Initial Access Check
        try {
            const response = await fetch('<?= base_url('ai-tools/check-price') ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    tool_id: 5, // SOP Generator
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

            // If payment is required
            if (data.final_price > 0 && data.order_id) {
                const options = {
                    "key": data.razorpay_key || "<?= esc($settings['razorpay_key_id'] ?? '') ?>",
                    "amount": data.final_price * 100,
                    "currency": "INR",
                    "name": "<?= esc($settings['site_name'] ?? 'UniHunt') ?>",
                    "description": "Premium SOP Generation",
                    "order_id": data.order_id,
                    "handler": function (response) {
                        document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                        document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
                        document.getElementById('razorpay_signature').value = response.razorpay_signature;

                        // Now submit the form for real
                        submitForm();
                    },
                    "prefill": {
                        "name": document.getElementById('name').value,
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
                // Free or Waived or Payments Disabled - proceed immediately
                submitForm();
            }
        } catch (error) {
            console.error(error);
            showNotification('Failed to initiate payment. Please try again.', 'error');
            document.getElementById('loadingOverlay').classList.remove('flex');
            document.getElementById('loadingOverlay').classList.add('hidden');
        }
    });

    function submitForm() {
        document.getElementById('loadingOverlay').classList.remove('hidden');
        document.getElementById('loadingOverlay').classList.add('flex');
        document.getElementById('sopForm').submit();
    }

    const toolPriceCheck = {
        toolId: 5,
        calc: null
    };

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
                btnText.textContent = `Pay ₹${finalPrice.toFixed(2)} & Generate SOP`;
            } else {
                btnText.textContent = 'Generate SOP with AI (Free)';
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
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ tool_id: toolPriceCheck.toolId })
            });
            const data = await response.json();

            if (data.csrf_token) {
                const csrfInput = document.querySelector('input[name="<?= csrf_token() ?>"]');
                if (csrfInput) csrfInput.value = data.csrf_token;
            }

            if (!data.error) {
                updatePriceUI(data);
            }
        } catch (e) { }
    }
</script>

<?= view('web/include/footer') ?>