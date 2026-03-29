<?= view('web/include/header', ['title' => 'AI University Counsellor - UniHunt', 'bodyClass' => 'bg-background-light dark:bg-background-dark font-display min-h-screen flex flex-col transition-colors duration-200']) ?>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "SoftwareApplication",
  "name": "AI University Counsellor",
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
    "ratingCount": "2500"
  },
  "description": "Get personalized university and course recommendations based on your profile and preferences using AI."
}
</script>

<!-- Main Content -->
<main class="flex-1 flex flex-col items-center w-full py-8 px-4 md:px-8">
    <div class="w-full max-w-6xl flex flex-col gap-8">
        <!-- Stepper -->
        <div
            class="w-full bg-surface-light dark:bg-surface-dark rounded-xl border border-border-light dark:border-border-dark shadow-sm p-1 overflow-x-auto">
            <div class="flex justify-between items-center min-w-[600px]">
                <div id="step-1-indicator"
                    class="flex flex-1 items-center gap-3 px-4 py-3 bg-primary/5 rounded-lg border border-primary/10 transition-all">
                    <div class="flex items-center justify-center size-8 rounded-full bg-primary text-white shadow-glow">
                        <span class="text-sm font-bold">1</span>
                    </div>
                    <p class="text-primary text-sm font-bold">Student Profile</p>
                    <div class="h-[2px] flex-1 bg-border-light dark:bg-gray-700 mx-2"></div>
                </div>
                <div id="step-2-indicator" class="flex flex-1 items-center gap-3 px-4 py-3 opacity-40 transition-all">
                    <div
                        class="flex items-center justify-center size-8 rounded-full border-2 border-border-light dark:border-gray-600 text-text-secondary dark:text-gray-500">
                        <span class="text-sm font-bold">2</span>
                    </div>
                    <p class="text-text-secondary dark:text-gray-500 text-sm font-bold">Payment</p>
                    <div class="h-[2px] flex-1 bg-border-light dark:bg-gray-700 mx-2"></div>
                </div>
                <div class="flex items-center gap-3 px-4 py-3 opacity-40">
                    <div
                        class="flex items-center justify-center size-8 rounded-full border-2 border-border-light dark:border-gray-600 text-text-secondary dark:text-gray-500">
                        <span class="text-sm font-bold">3</span>
                    </div>
                    <p class="text-text-secondary dark:text-gray-500 text-sm font-bold">Personalized Guidance</p>
                </div>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8 items-start">
            <!-- Left Column: Form -->
            <div
                class="w-full lg:w-4/5 min-w-0 bg-surface-light dark:bg-surface-dark rounded-xl border border-border-light dark:border-border-dark shadow-soft p-6 md:p-8">
                <form id="counsellorForm" action="<?= base_url('ai-tools/start-counsellor-session') ?>" method="POST"
                    class="flex flex-col gap-6">
                    <?= csrf_field() ?>
                    <?= honeypot_field() ?>

                    <div class="mb-4">
                        <h2 class="text-2xl font-bold text-text-main dark:text-white">AI University Counsellor</h2>
                        <p class="text-sm text-text-secondary dark:text-gray-400">Get personalized university
                            recommendations and real-time guidance from our advanced AI.</p>
                    </div>

                    <!-- Step 1 Container -->
                    <div id="step1-container">
                        <!-- Personal Details -->
                        <div class="space-y-4">
                            <h3
                                class="text-lg font-bold text-text-main dark:text-white border-b border-border-light dark:border-border-dark pb-2 flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary">school</span>
                                Academic Profile
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <label class="flex flex-col gap-2">
                                    <span class="text-sm font-semibold text-text-main dark:text-gray-200">Current
                                        Education Minimum
                                        Level</span>
                                    <div class="relative">
                                        <span
                                            class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-gray-400">menu_book</span>
                                        <select name="education_level" required onchange="updateTestFields()"
                                            class="w-full rounded-lg border border-border-light dark:border-border-dark bg-white dark:bg-[#2a323c] h-12 pl-12 pr-4 focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all appearance-none">
                                            <option value="">Select Level</option>
                                            <option value="High School">High School (12th Grade)</option>
                                            <option value="Undergraduate">Undergraduate (Bachelor's)</option>
                                            <option value="Postgraduate">Postgraduate (Master's)</option>
                                        </select>
                                    </div>
                                </label>
                                <label class="flex flex-col gap-2">
                                    <span class="text-sm font-semibold text-text-main dark:text-gray-200">GPA /
                                        Percentage</span>
                                    <div class="relative">
                                        <span
                                            class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-gray-400">percent</span>
                                        <input type="text" name="gpa" required
                                            class="w-full rounded-lg border border-border-light dark:border-border-dark bg-white dark:bg-[#2a323c] h-12 pl-12 pr-4 focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all"
                                            placeholder="e.g. 3.5 GPA or 85%">
                                    </div>
                                </label>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <label class="flex flex-col gap-2">
                                    <span class="text-sm font-semibold text-text-main dark:text-gray-200">IELTS/TOEFL
                                        Score</span>
                                    <div class="relative">
                                        <span
                                            class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-gray-400">language</span>
                                        <input type="text" name="test_scores"
                                            class="w-full rounded-lg border border-border-light dark:border-border-dark bg-white dark:bg-[#2a323c] h-12 pl-12 pr-4 focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all"
                                            placeholder="e.g. IELTS 7.0">
                                    </div>
                                </label>
                                <label class="flex flex-col gap-2">
                                    <span id="standardized-test-label"
                                        class="text-sm font-semibold text-text-main dark:text-gray-200">GRE/GMAT
                                        (Optional)</span>
                                    <div class="relative">
                                        <span
                                            class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-gray-400">calculate</span>
                                        <input type="text" id="standardized-test-input" name="gre_gmat"
                                            class="w-full rounded-lg border border-border-light dark:border-border-dark bg-white dark:bg-[#2a323c] h-12 pl-12 pr-4 focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all"
                                            placeholder="e.g. GRE 310">
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Preferences -->
                        <div class="space-y-4 mt-6">
                            <h3
                                class="text-lg font-bold text-text-main dark:text-white border-b border-border-light dark:border-border-dark pb-2 flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary">travel_explore</span>
                                Study Preferences
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <label class="flex flex-col gap-2">
                                    <span class="text-sm font-semibold text-text-main dark:text-gray-200">Preferred
                                        Country</span>
                                    <div class="relative">
                                        <span
                                            class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-gray-400">public</span>
                                        <input type="text" name="preferred_country" required
                                            class="w-full rounded-lg border border-border-light dark:border-border-dark bg-white dark:bg-[#2a323c] h-12 pl-12 pr-4 focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all"
                                            placeholder="e.g. USA, UK, Canada">
                                    </div>
                                </label>
                                <label class="flex flex-col gap-2">
                                    <span class="text-sm font-semibold text-text-main dark:text-gray-200">Field of
                                        Study</span>
                                    <div class="relative">
                                        <span
                                            class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-gray-400">science</span>
                                        <input type="text" name="field_of_study" required
                                            class="w-full rounded-lg border border-border-light dark:border-border-dark bg-white dark:bg-[#2a323c] h-12 pl-12 pr-4 focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all"
                                            placeholder="e.g. Computer Science">
                                    </div>
                                </label>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <label class="flex flex-col gap-2">
                                    <span class="text-sm font-semibold text-text-main dark:text-gray-200">Max Budget
                                        (Annual
                                        Tuition)</span>
                                    <div class="relative">
                                        <span
                                            class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-gray-400">payments</span>
                                        <select name="budget"
                                            class="w-full rounded-lg border border-border-light dark:border-border-dark bg-white dark:bg-[#2a323c] h-12 pl-12 pr-4 focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all appearance-none">
                                            <option value="Any">Any Budget</option>
                                            <option value="Under $15k">Under $15k</option>
                                            <option value="$15k - $30k">$15k - $30k</option>
                                            <option value="$30k - $50k">$30k - $50k</option>
                                            <option value="$50k+">$50k+</option>
                                        </select>
                                    </div>
                                </label>
                                <label class="flex flex-col gap-2">
                                    <span class="text-sm font-semibold text-text-main dark:text-gray-200">Preferred
                                        Intake</span>
                                    <div class="relative">
                                        <span
                                            class="absolute left-4 top-1/2 -translate-y-1/2 material-symbols-outlined text-gray-400">calendar_month</span>
                                        <select name="intake"
                                            class="w-full rounded-lg border border-border-light dark:border-border-dark bg-white dark:bg-[#2a323c] h-12 pl-12 pr-4 focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all appearance-none">
                                            <option value="Any">Any</option>
                                            <option value="Fall <?= date('Y') ?>">Fall <?= date('Y') ?></option>
                                            <option value="Spring <?= date('Y') + 1 ?>">Spring <?= date('Y') + 1 ?>
                                            </option>
                                            <option value="Fall <?= date('Y') + 1 ?>">Fall
                                                <?= date('Y') + 1 ?>
                                            </option>
                                        </select>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Specific Goals -->
                        <div class="space-y-4 mt-6">
                            <label class="flex flex-col gap-2">
                                <span class="text-sm font-semibold text-text-main dark:text-gray-200">Career Goals /
                                    Specific Requirements</span>
                                <textarea name="goals" rows="3"
                                    class="w-full rounded-lg border border-border-light dark:border-border-dark bg-white dark:bg-[#2a323c] p-4 focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all"
                                    placeholder="Tell us about what you are looking for..."></textarea>
                            </label>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <button type="button" onclick="showStep2()"
                                class="bg-primary hover:bg-[#158bb3] text-white font-bold text-base px-8 py-3 rounded-xl shadow-lg shadow-primary/30 flex items-center gap-3 transition-all transform hover:-translate-y-1">
                                <span>Next: Payment Details</span>
                                <span class="material-symbols-outlined">arrow_forward</span>
                            </button>
                        </div>
                    </div>

                    <!-- Step 2 Container (Initially Hidden) -->
                    <div id="step2-container" class="hidden">
                        <!-- Payment & Coupon Section -->
                        <div class="pt-2" id="payment-section">
                            <h3 class="text-lg font-bold text-text-main dark:text-white mb-4 flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary">payments</span>
                                Session Fee & Payment
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-start">
                                <!-- Coupon Input -->
                                <div class="flex flex-col gap-3">
                                    <label class="text-sm font-semibold text-text-main dark:text-gray-200">Coupon
                                        Code</label>
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
                                            id="original-price-display">₹99.00</span>
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
                                        <span class="text-sm font-bold text-text-main dark:text-white">Total</span>
                                        <span class="text-xl font-black text-primary"
                                            id="final-price-display">₹99.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden Payment Fields -->
                        <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
                        <input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
                        <input type="hidden" name="razorpay_signature" id="razorpay_signature">

                        <div
                            class="flex items-center justify-between mt-8 border-t border-border-light dark:border-border-dark pt-6">
                            <button type="button" onclick="showStep1()"
                                class="text-text-secondary dark:text-gray-400 font-bold text-sm px-6 py-3 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 flex items-center gap-2 transition-all">
                                <span class="material-symbols-outlined">arrow_back</span>
                                <span>Back</span>
                            </button>
                            <button type="submit" id="submitBtn"
                                class="bg-primary hover:bg-[#158bb3] text-white font-bold text-base px-8 py-4 rounded-xl shadow-lg shadow-primary/30 flex items-center gap-3 transition-all transform hover:-translate-y-1">
                                <span id="btnText">Pay ₹99.00 & Start Session</span>
                                <span class="material-symbols-outlined">smart_toy</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Right Column: Info -->
            <div class="w-full lg:w-1/5 flex flex-col gap-6">
                <div
                    class="bg-gradient-to-br from-[#e0f2f8] to-white dark:from-[#2a3a45] dark:to-surface-dark rounded-xl p-6 border border-primary/20 shadow-sm relative overflow-hidden group">
                    <div class="flex items-center gap-2 mb-4">
                        <span class="material-symbols-outlined text-primary">psychology</span>
                        <h3 class="text-text-main dark:text-white font-bold text-lg">Why use AI?</h3>
                    </div>
                    <ul class="space-y-4">
                        <li class="flex gap-3 items-start">
                            <span class="material-symbols-outlined text-primary mt-1 text-[18px]">check_circle</span>
                            <div>
                                <p class="text-sm text-text-main dark:text-gray-200 font-bold">Matching</p>
                                <p class="text-xs text-text-secondary dark:text-gray-400 mt-1">
                                    Instant university matches.
                                </p>
                            </div>
                        </li>
                        <li class="flex gap-3 items-start">
                            <span class="material-symbols-outlined text-primary mt-1 text-[18px]">check_circle</span>
                            <div>
                                <p class="text-sm text-text-main dark:text-gray-200 font-bold">Insights</p>
                                <p class="text-xs text-text-secondary dark:text-gray-400 mt-1">
                                    Real cost & acceptance analysis.
                                </p>
                            </div>
                        </li>
                        <li class="flex gap-3 items-start">
                            <span class="material-symbols-outlined text-primary mt-1 text-[18px]">check_circle</span>
                            <div>
                                <p class="text-sm text-text-main dark:text-gray-200 font-bold">24/7 Chat</p>
                                <p class="text-xs text-text-secondary dark:text-gray-400 mt-1">
                                    Always available for questions.
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
            <!-- Simple animated Spinner -->
            <div class="relative w-20 h-20 mx-auto">
                <div class="absolute inset-0 border-4 border-primary/20 rounded-full"></div>
                <div class="absolute inset-0 border-4 border-primary border-t-transparent rounded-full animate-spin">
                </div>
                <span
                    class="material-symbols-outlined absolute inset-0 flex items-center justify-center text-primary text-3xl animate-pulse">smart_toy</span>
            </div>
        </div>
        <h3 class="text-xl font-bold text-text-main dark:text-white mb-2">Initializing AI Counsellor...</h3>
        <p class="text-text-secondary dark:text-gray-400 text-sm mb-4">Please wait while we review your profile.</p>
        <div class="flex flex-col gap-2 text-xs text-text-muted dark:text-gray-500">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-accent-green text-sm">check_circle</span>
                <span>Analyzing academic background</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-sm animate-pulse">pending</span>
                <span>Matching universities</span>
            </div>
            <div class="flex items-center gap-2 opacity-50">
                <span class="material-symbols-outlined text-sm">radio_button_unchecked</span>
                <span>Generating report</span>
            </div>
        </div>
    </div>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    const toolPriceCheck = {
        toolId: 11, // AI Counsellor
        calc: null
    };

    document.addEventListener('DOMContentLoaded', loadInitialPrice);

    async function loadInitialPrice() {
        try {
            const response = await fetch('<?= base_url('ai-tools/check-price') ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ tool_id: toolPriceCheck.toolId })
            });
            const data = await response.json();
            if (!data.error) {
                updatePriceUI(data);
            }
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
        const originalPrice = parseFloat(data.original_price || 0);
        const discountAmount = parseFloat(data.discount_amount || 0);
        const finalPrice = parseFloat(data.final_price || 0);

        document.getElementById('original-price-display').textContent = `₹${originalPrice.toFixed(2)}`;
        document.getElementById('discount-display').textContent = `- ₹${discountAmount.toFixed(2)}`;
        document.getElementById('final-price-display').textContent = `₹${finalPrice.toFixed(2)}`;

        const btnText = document.getElementById('btnText');
        if (btnText) {
            btnText.textContent = finalPrice > 0 ? `Pay ₹${finalPrice.toFixed(2)} & Start Session` : 'Start Session (Free)';
        }

        const paymentSection = document.getElementById('payment-section');
        if (finalPrice <= 0) {
            if (paymentSection) paymentSection.classList.add('hidden');
        } else {
            if (paymentSection) paymentSection.classList.remove('hidden');
        }
    }

    function showStep2() {
        const form = document.getElementById('counsellorForm');
        if (!form.reportValidity()) return;

        document.getElementById('step1-container').classList.add('hidden');
        document.getElementById('step2-container').classList.remove('hidden');

        // Update Indicators
        document.getElementById('step-1-indicator').classList.add('opacity-40');
        document.getElementById('step-1-indicator').classList.remove('bg-primary/5', 'border-primary/10');

        document.getElementById('step-2-indicator').classList.remove('opacity-40');
        document.getElementById('step-2-indicator').classList.add('bg-primary/5', 'rounded-lg', 'border', 'border-primary/10');

        const step2Badge = document.getElementById('step-2-indicator').querySelector('.rounded-full');
        step2Badge.classList.remove('border-2', 'border-border-light', 'dark:border-gray-600', 'text-text-secondary', 'dark:text-gray-500');
        step2Badge.classList.add('bg-primary', 'text-white', 'shadow-glow');

        const step2Title = document.getElementById('step-2-indicator').querySelector('p');
        step2Title.classList.remove('text-text-secondary', 'dark:text-gray-500');
        step2Title.classList.add('text-primary');

        // Scroll to top of form
        document.getElementById('counsellorForm').scrollIntoView({ behavior: 'smooth' });
    }

    function showStep1() {
        document.getElementById('step2-container').classList.add('hidden');
        document.getElementById('step1-container').classList.remove('hidden');

        // Reset Indicators
        document.getElementById('step-1-indicator').classList.remove('opacity-40');
        document.getElementById('step-1-indicator').classList.add('bg-primary/5', 'border-primary/10');

        document.getElementById('step-2-indicator').classList.add('opacity-40');
        document.getElementById('step-2-indicator').classList.remove('bg-primary/5', 'rounded-lg', 'border', 'border-primary/10');

        const step2Badge = document.getElementById('step-2-indicator').querySelector('.rounded-full');
        step2Badge.classList.add('border-2', 'border-border-light', 'dark:border-gray-600', 'text-text-secondary', 'dark:text-gray-500');
        step2Badge.classList.remove('bg-primary', 'text-white', 'shadow-glow');

        const step2Title = document.getElementById('step-2-indicator').querySelector('p');
        step2Title.classList.add('text-text-secondary', 'dark:text-gray-500');
        step2Title.classList.remove('text-primary');

        document.getElementById('counsellorForm').scrollIntoView({ behavior: 'smooth' });
    }

    function showNotification(message, type = 'info') {
        const colors = { success: 'bg-green-500', error: 'bg-red-500', info: 'bg-blue-500' };
        const n = document.createElement('div');
        n.className = `fixed top-4 right-4 z-[9999] px-6 py-3 rounded-lg shadow-lg text-white font-medium transition-all duration-300 ${colors[type]}`;
        n.textContent = message;
        document.body.appendChild(n);
        setTimeout(() => { n.style.opacity = '0'; setTimeout(() => n.remove(), 300); }, 3000);
    }

    document.getElementById('counsellorForm').addEventListener('submit', async function (e) {
        e.preventDefault();

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

            if (data.error) {
                showNotification(data.error, 'error');
                return;
            }

            if (data.final_price > 0 && data.order_id) {
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
                    "description": "AI Counselling Session",
                    "order_id": data.order_id,
                    "handler": function (response) {
                        document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                        document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
                        document.getElementById('razorpay_signature').value = response.razorpay_signature;

                        submitForm();
                    },
                    "theme": { "color": "#1da1f2" }
                };
                const rzp = new Razorpay(options);
                rzp.on('payment.failed', function (response) {
                    showNotification(response.error.description, 'error');
                });
                rzp.open();
            } else {
                submitForm();
            }
        } catch (error) {
            console.error(error);
            // Fallback: If the UI shows free/0.00, assume it's free and allow submission
            const priceDisplay = document.getElementById('final-price-display');
            if (priceDisplay && (priceDisplay.textContent.includes('0.00') || priceDisplay.textContent.trim() === '₹0')) {
                submitForm();
                return;
            }
            showNotification('Payment initialization failed.', 'error');
        }
    });

    function updateTestFields() {
        const educationLevel = document.querySelector('select[name="education_level"]').value;
        const testLabel = document.getElementById('standardized-test-label');
        const testInput = document.getElementById('standardized-test-input');

        if (educationLevel === 'High School') {
            testLabel.textContent = 'SAT/ACT (Optional)';
            testInput.placeholder = 'e.g. SAT 1400';
            testInput.name = 'sat_act'; // Update name attribute if your backend expects different keys
        } else {
            testLabel.textContent = 'GRE/GMAT (Optional)';
            testInput.placeholder = 'e.g. GRE 310';
            testInput.name = 'gre_gmat';
        }
    }

    function submitForm() {
        document.getElementById('loadingOverlay').classList.remove('hidden');
        document.getElementById('loadingOverlay').classList.add('flex');
        document.getElementById('counsellorForm').submit();
    }
</script>

<?= view('web/include/footer') ?>