<?= view('web/include/header', ['title' => 'AI Resume Builder', 'bodyClass' => 'bg-background-light dark:bg-background-dark font-display min-h-screen flex flex-col transition-colors duration-200']) ?>

<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "SoftwareApplication",
  "name": "AI Resume Builder",
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
    "ratingCount": "1950"
  },
  "description": "Create an ATS-friendly, professional resume tailored for international university applications and jobs using AI."
}
</script>

<!-- Main Content -->
<main class="flex-1 flex flex-col items-center w-full py-8 px-4 md:px-8">
    <div class="w-full max-w-7xl flex flex-col gap-6">
        <!-- Header -->
        <div class="text-center mb-4">
            <h1 class="text-3xl md:text-4xl font-black text-text-main mb-2">AI Resume Builder</h1>
            <p class="text-text-muted">Create a professional resume in minutes with AI assistance</p>
        </div>

        <!-- Progress Stepper -->
        <!-- Stepper -->
        <div class="w-full bg-surface-light rounded-xl border border-border-light shadow-sm p-1 overflow-x-auto">
            <div class="flex justify-between items-center min-w-[600px]">
                <!-- Step 1 -->
                <div id="stepper-1" class="flex flex-1 items-center gap-3 px-4 py-3 bg-primary/5 rounded-lg border border-primary/10">
                    <div class="flex items-center justify-center size-8 rounded-full bg-primary text-white shadow-glow">
                        <span class="text-sm font-bold">1</span>
                    </div>
                    <p class="text-primary text-sm font-bold">Template</p>
                    <div class="h-[2px] flex-1 bg-border-light mx-2"></div>
                </div>
                <!-- Step 2 -->
                <div id="stepper-2" class="flex flex-1 items-center gap-3 px-4 py-3 opacity-40">
                    <div class="flex items-center justify-center size-8 rounded-full border-2 border-border-light text-text-muted">
                        <span class="text-sm font-bold">2</span>
                    </div>
                    <p class="text-text-muted text-sm font-bold">Details</p>
                    <div class="h-[2px] flex-1 bg-border-light mx-2"></div>
                </div>
                <!-- Step 3 -->
                <div id="stepper-3" class="flex items-center gap-3 px-4 py-3 opacity-40">
                    <div class="flex items-center justify-center size-8 rounded-full border-2 border-border-light text-text-muted">
                        <span class="text-sm font-bold">3</span>
                    </div>
                    <p class="text-text-muted text-sm font-bold">Preview</p>
                </div>
            </div>
        </div>

        <!-- Main Content Area: Form + Preview -->
        <div class="flex flex-col lg:grid lg:grid-cols-12 gap-6 items-start">
            <!-- Left Column: Form Steps -->
            <div class="lg:col-span-7 w-full">
                <div class="bg-surface-light rounded-xl border border-border-light shadow-soft p-6 md:p-8">
                    <form id="resumeForm" class="flex flex-col gap-6" onsubmit="return false;">
                        <?= csrf_field() ?>
                        <?= honeypot_field() ?>

                        <!-- Step 1: Template Selection -->
                        <div class="form-step active" data-step="1">
                            <div class="flex items-center gap-3 mb-6">
                                <span class="material-symbols-outlined text-3xl text-primary">palette</span>
                                <h2 class="text-2xl font-bold text-text-main">Choose Template</h2>
                            </div>

                            <p class="text-sm text-text-muted mb-6">Select a professional template for your resume</p>

                            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4">
                                <?php for ($i = 1; $i <= 10; $i++): ?>
                                    <button type="button" onclick="selectTemplate(<?= $i ?>)" id="btn_template_<?= $i ?>"
                                        class="template-btn group relative aspect-[1/1.4] rounded-xl border-3 border-border-light overflow-hidden transition-all hover:shadow-lg hover:scale-105 <?= $i == 1 ? 'border-primary ring-4 ring-primary/30 shadow-lg' : '' ?>">
                                        <!-- Placeholder (visible if image missing) -->
                                        <div class="absolute inset-0 bg-gradient-to-br from-background-light to-border-light flex flex-col items-center justify-center gap-2">
                                            <span class="material-symbols-outlined text-4xl text-primary">description</span>
                                            <span class="text-xs font-bold text-text-main">Template <?= $i ?></span>
                                        </div>

                                        <!-- Template Preview Image -->
                                        <img src="<?= base_url('assets/images/resume-templates/template-' . $i . '.png') ?>"
                                            alt="Template <?= $i ?>"
                                            class="absolute inset-0 w-full h-full object-cover transition-opacity duration-300 bg-white"
                                            onerror="this.style.display='none'">

                                        <div
                                            class="absolute inset-0 bg-primary/0 group-hover:bg-primary/10 transition-colors pointer-events-none">
                                        </div>
                                    </button>
                                <?php endfor; ?>
                            </div>
                        </div>

                        <!-- Step 2: Personal Details & AI Generation -->
                        <div class="form-step hidden" data-step="2">
                            <div class="flex flex-col gap-8">
                                <!-- 2.1 Basic Info -->
                                <section>
                                    <div class="flex items-center gap-3 mb-6">
                                        <span class="material-symbols-outlined text-3xl text-primary">person</span>
                                        <h2 class="text-2xl font-bold text-text-main">Personal Information</h2>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                        <label class="flex flex-col gap-2">
                                            <span class="text-sm font-semibold text-text-main">Full Name <span class="text-red-500">*</span></span>
                                            <input type="text" id="name" name="name" required maxlength="100"
                                                class="w-full rounded-lg border border-border-light bg-card-light h-12 px-4 focus:ring-2 focus:ring-primary/50 text-text-main"
                                                placeholder="John Doe">
                                        </label>
                                        <label class="flex flex-col gap-2">
                                            <span class="text-sm font-semibold text-text-main">Job Title <span class="text-red-500">*</span></span>
                                            <input type="text" id="title" name="title" required maxlength="100"
                                                class="w-full rounded-lg border border-border-light bg-card-light h-12 px-4 focus:ring-2 focus:ring-primary/50 text-text-main"
                                                placeholder="Software Engineer">
                                        </label>
                                        <label class="flex flex-col gap-2">
                                            <span class="text-sm font-semibold text-text-main">Email <span class="text-red-500">*</span></span>
                                            <input type="email" id="email" name="email" required maxlength="255"
                                                class="w-full rounded-lg border border-border-light bg-card-light h-12 px-4 focus:ring-2 focus:ring-primary/50 text-text-main"
                                                placeholder="john@example.com">
                                        </label>
                                        <label class="flex flex-col gap-2">
                                            <span class="text-sm font-semibold text-text-main">Phone <span class="text-red-500">*</span></span>
                                            <input type="text" id="phone" name="phone" required maxlength="15"
                                                class="w-full rounded-lg border border-border-light bg-card-light h-12 px-4 focus:ring-2 focus:ring-primary/50 text-text-main"
                                                placeholder="9876543210 (Numbers only)">
                                        </label>
                                        <label class="flex flex-col gap-2">
                                            <span class="text-sm font-semibold text-text-main">Location</span>
                                            <input type="text" id="location" name="location" maxlength="100"
                                                class="w-full rounded-lg border border-border-light bg-card-light h-12 px-4 focus:ring-2 focus:ring-primary/50 text-text-main"
                                                placeholder="New York, NY">
                                        </label>
                                        <label class="flex flex-col gap-2">
                                            <span class="text-sm font-semibold text-text-main">LinkedIn</span>
                                            <input type="text" id="linkedin" name="linkedin" maxlength="255"
                                                class="w-full rounded-lg border border-border-light bg-card-light h-12 px-4 focus:ring-2 focus:ring-primary/50 text-text-main"
                                                placeholder="linkedin.com/in/johndoe">
                                        </label>
                                    </div>
                                </section>

                                <!-- 2.2 Summary / AI Objective -->
                                <section>
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center gap-3">
                                            <span
                                                class="material-symbols-outlined text-3xl text-primary">description</span>
                                            <h2 class="text-2xl font-bold text-text-main dark:text-white">Professional
                                                Summary</h2>
                                        </div>
                                        <button type="button" onclick="generateAiSummary()"
                                            class="flex items-center gap-2 px-4 py-2 bg-primary/10 hover:bg-primary/20 text-primary rounded-lg font-bold text-sm transition-all border border-primary/20">
                                            <span class="material-symbols-outlined text-lg">auto_awesome</span>
                                            AI Generate
                                        </button>
                                    </div>
                                    <textarea id="summary" name="summary" rows="4" maxlength="1000"
                                        class="w-full rounded-lg border border-border-light bg-card-light p-4 focus:ring-2 focus:ring-primary/50 text-text-main resize-none"
                                        placeholder="Brief overview of your professional background..."
                                        oninput="document.getElementById('summaryCount').textContent = this.value.length + '/1000'"></textarea>
                                    <p id="summaryCount" class="text-right text-xs text-text-muted mt-1">0/1000</p>
                                </section>

                                <!-- 2.3 Work Experience -->
                                <section>
                                    <div class="flex items-center gap-3 mb-6">
                                        <span class="material-symbols-outlined text-3xl text-primary">work</span>
                                        <h2 class="text-2xl font-bold text-text-main">Work Experience</h2>
                                    </div>
                                    <div id="experienceContainer" class="flex flex-col gap-4">
                                        <div class="experience-item p-5 border-2 border-border-light rounded-xl bg-background-light relative">
                                            <button type="button" onclick="removeExperience(this)"
                                                class="absolute top-3 right-3 text-red-500 hover:text-red-700">
                                                <span class="material-symbols-outlined text-xl">close</span>
                                            </button>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                                <input type="text" placeholder="Company Name" maxlength="100"
                                                    class="exp-company w-full rounded-lg border border-border-light h-11 px-4 bg-card-light text-text-main">
                                                <input type="text" placeholder="Job Title" maxlength="100"
                                                    class="exp-title w-full rounded-lg border border-border-light h-11 px-4 bg-card-light text-text-main">
                                                <input type="text" placeholder="Dates (e.g. Jan 2021 - Present)"
                                                    maxlength="50"
                                                    class="exp-dates w-full rounded-lg border border-border-light h-11 px-4 bg-card-light text-text-main">
                                                <input type="text" placeholder="Location" maxlength="100"
                                                    class="exp-location w-full rounded-lg border border-border-light h-11 px-4 bg-card-light text-text-main">
                                            </div>
                                            <div class="flex items-center justify-between mb-2">
                                                <span class="text-sm font-semibold text-text-main">Responsibilities & Achievements</span>
                                                <button type="button" onclick="generateAiHighlights(this)"
                                                    class="flex items-center gap-1 text-xs font-bold text-primary hover:text-primary-hover">
                                                    <span class="material-symbols-outlined text-sm">auto_awesome</span>
                                                    AI Improve
                                                </button>
                                            </div>
                                            <textarea placeholder="Key achievements (one per line)" maxlength="2000"
                                                class="exp-highlights w-full rounded-lg border border-border-light p-4 h-28 bg-card-light text-text-main resize-none"></textarea>
                                        </div>
                                    </div>
                                    <button type="button" onclick="addExperience()"
                                        class="mt-4 text-primary hover:text-primary-hover font-bold text-sm flex items-center gap-2">
                                        <span class="material-symbols-outlined text-xl">add_circle</span> Add Another
                                        Experience
                                    </button>
                                </section>

                                <!-- 2.4 Education -->
                                <section>
                                    <div class="flex items-center gap-3 mb-6">
                                        <span class="material-symbols-outlined text-3xl text-primary">school</span>
                                        <h2 class="text-2xl font-bold text-text-main">Education</h2>
                                    </div>
                                    <div id="educationContainer" class="flex flex-col gap-4">
                                        <div class="education-item p-5 border-2 border-border-light rounded-xl bg-background-light relative">
                                            <button type="button" onclick="removeEducation(this)"
                                                class="absolute top-3 right-3 text-red-500 hover:text-red-700">
                                                <span class="material-symbols-outlined text-xl">close</span>
                                            </button>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <input type="text" placeholder="School/University" maxlength="100"
                                                    class="edu-school w-full rounded-lg border border-border-light h-11 px-4 bg-card-light text-text-main">
                                                <input type="text" placeholder="Degree & Major" maxlength="100"
                                                    class="edu-degree w-full rounded-lg border border-border-light h-11 px-4 bg-card-light text-text-main">
                                                <input type="text" placeholder="Graduation Date" maxlength="50"
                                                    class="edu-dates w-full rounded-lg border border-border-light h-11 px-4 bg-card-light text-text-main">
                                                <input type="text" placeholder="GPA (Optional)" maxlength="10"
                                                    class="edu-gpa w-full rounded-lg border border-border-light h-11 px-4 bg-card-light text-text-main">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" onclick="addEducation()"
                                        class="mt-4 text-primary hover:text-primary-hover font-bold text-sm flex items-center gap-2">
                                        <span class="material-symbols-outlined text-xl">add_circle</span> Add Another
                                        Education
                                    </button>
                                </section>

                                <!-- 2.5 Skills -->
                                <section>
                                    <div class="flex items-center gap-3 mb-6">
                                        <span class="material-symbols-outlined text-3xl text-primary">architecture</span>
                                        <h2 class="text-2xl font-bold text-text-main">Skills</h2>
                                    </div>
                                    <input type="text" id="skills" name="skills" maxlength="500"
                                        class="w-full rounded-lg border border-border-light bg-card-light h-12 px-4 focus:ring-2 focus:ring-primary/50 text-text-main"
                                        placeholder="JavaScript, Python, React, Node.js, SQL">
                                </section>
                            </div>
                        </div>

                        <!-- Step 3: Preview & Download -->
                        <div class="form-step hidden" data-step="3">
                            <div class="flex items-center gap-3 mb-6">
                                <span class="material-symbols-outlined text-3xl text-primary">visibility</span>
                                <h2 class="text-2xl font-bold text-text-main dark:text-white">Preview & Download</h2>
                            </div>

                            <div
                                class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-6 mb-6">
                                <div class="flex items-start gap-4">
                                    <span
                                        class="material-symbols-outlined text-3xl text-green-600 dark:text-green-400">check_circle</span>
                                    <div>
                                        <h3 class="text-lg font-bold text-green-800 dark:text-green-300 mb-2">Your
                                            Resume is Ready!</h3>
                                        <p class="text-sm text-green-700 dark:text-green-400">Review your resume in the
                                            preview panel. If everything looks good, download it in your preferred
                                            format.</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment & Coupon Section -->
                            <div class="mb-8 p-6 bg-background-light rounded-xl border border-border-light">
                                <h3 class="text-lg font-bold text-text-main mb-4 flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary">payments</span>
                                    Premium Resume Builder
                                </h3>

                                <div class="flex flex-col gap-6">
                                    <!-- Coupon Input -->
                                    <div class="flex flex-col gap-3">
                                        <label class="text-xs font-bold text-text-muted uppercase tracking-widest">Coupon Code</label>
                                        <div class="flex gap-2">
                                            <input type="text" id="coupon_code"
                                                class="flex-1 rounded-lg border border-border-light bg-card-light h-11 px-4 text-sm focus:ring-2 focus:ring-primary/50 transition-all uppercase"
                                                placeholder="ENTER CODE">
                                            <button type="button" onclick="applyCoupon()"
                                                class="bg-primary/10 text-primary hover:bg-primary/20 px-6 rounded-lg text-sm font-bold transition-all border border-primary/20">
                                                Apply
                                            </button>
                                        </div>
                                        <p id="coupon-msg" class="text-xs font-medium hidden"></p>
                                    </div>

                                    <!-- Price Details -->
                                    <div
                                        class="space-y-3 pt-4 border-t border-dashed border-border-light dark:border-border-dark">
                                        <div class="flex justify-between items-center text-sm">
                                            <span class="text-text-muted">Standard Price</span>
                                            <span class="font-bold text-text-main line-through opacity-50" id="original-price-display">₹0.00</span>
                                        </div>
                                        <div class="flex justify-between items-center text-sm">
                                            <span class="text-text-muted">Discount</span>
                                            <span class="font-bold text-accent-green" id="discount-display">- ₹0.00</span>
                                        </div>
                                        <div class="flex justify-between items-center pt-2">
                                            <span class="font-bold text-text-main">Amount due</span>
                                            <span class="text-2xl font-black text-primary" id="final-price-display">₹0.00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Hidden Payment Fields -->
                            <input type="hidden" id="razorpay_payment_id">
                            <input type="hidden" id="razorpay_order_id">
                            <input type="hidden" id="razorpay_signature">

                            <div class="flex flex-col gap-4">
                                <button type="button" onclick="downloadResume('pdf')"
                                    class="w-full bg-primary hover:bg-primary-hover text-white font-bold text-base px-8 py-4 rounded-xl shadow-lg shadow-primary/30 flex items-center justify-center gap-3 transition-all transform hover:-translate-y-1">
                                    <span class="material-symbols-outlined text-xl">download</span>
                                    Download & Print PDF
                                </button>
                                <button type="button" onclick="downloadResume('docx')"
                                    class="w-full bg-card-light border-2 border-primary text-primary hover:bg-primary/5 font-bold text-base px-8 py-4 rounded-xl flex items-center justify-center gap-3 transition-all">
                                    <span class="material-symbols-outlined text-xl">description</span>
                                    Download as Web View
                                </button>
                            </div>
                        </div>

                        <!-- Hidden Inputs -->
                        <input type="hidden" name="template_id" id="templateIdInput" value="1">

                        <!-- Navigation Buttons -->
                        <div class="flex items-center justify-between mt-8 pt-6 border-t border-border-light">
                            <button type="button" id="prevBtn" onclick="changeStep(-1)"
                                class="hidden bg-border-light hover:bg-border-light/80 text-text-main font-bold text-sm px-6 py-3 rounded-lg items-center gap-2 transition-all">
                                <span class="material-symbols-outlined text-lg">arrow_back</span>
                                Previous
                            </button>
                            <button type="button" id="nextBtn" onclick="changeStep(1)"
                                class="ml-auto bg-primary hover:bg-primary-hover text-white font-bold text-sm px-8 py-3 rounded-lg flex items-center gap-2 transition-all shadow-md">
                                Next
                                <span class="material-symbols-outlined text-lg">arrow_forward</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right Column: Live Preview -->
            <div class="lg:col-span-5 w-full lg:sticky lg:top-6">
                <div class="bg-surface-light rounded-xl border border-border-light shadow-soft p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-text-main">Live Preview</h3>
                        <button type="button" onclick="refreshPreview()"
                            class="text-primary hover:text-primary-hover transition-colors">
                            <span class="material-symbols-outlined">refresh</span>
                        </button>
                    </div>

                    <!-- Resume Preview Container -->
                    <div class="bg-card-light rounded-lg border-2 border-border-light p-8 min-h-[600px] shadow-inner overflow-auto max-h-[800px]">
                        <div id="resumePreview" class="text-sm">
                            <!-- Header -->
                            <div class="text-center mb-6 pb-4 border-b-2 border-primary">
                                <h1 id="preview-name" class="text-2xl font-black text-text-main mb-1">
                                    Your Name</h1>
                                <h2 id="preview-title" class="text-lg font-semibold text-primary mb-3">Job Title</h2>
                                <div class="flex flex-wrap justify-center gap-3 text-xs text-text-muted">
                                    <span id="preview-email" class="flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm">email</span>
                                        email@example.com
                                    </span>
                                    <span id="preview-phone" class="flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm">phone</span>
                                        +1 234 567 890
                                    </span>
                                    <span id="preview-location" class="flex items-center gap-1">
                                        <span class="material-symbols-outlined text-sm">location_on</span>
                                        Location
                                    </span>
                                </div>
                            </div>

                            <!-- Summary -->
                            <div id="preview-summary-section" class="mb-6 hidden">
                                <h3 class="text-sm font-bold text-text-main uppercase tracking-wide mb-2 pb-1 border-b border-border-light"> Professional Summary</h3>
                                <p id="preview-summary" class="text-xs text-text-muted leading-relaxed"></p>
                            </div>

                            <!-- Skills -->
                            <div id="preview-skills-section" class="mb-6 hidden">
                                <h3 class="text-sm font-bold text-text-main uppercase tracking-wide mb-2 pb-1 border-b border-border-light"> Skills</h3>
                                <div id="preview-skills" class="flex flex-wrap gap-2"></div>
                            </div>

                            <!-- Experience -->
                            <div id="preview-experience-section" class="mb-6 hidden">
                                <h3 class="text-sm font-bold text-text-main uppercase tracking-wide mb-3 pb-1 border-b border-border-light"> Work Experience</h3>
                                <div id="preview-experience" class="space-y-4"></div>
                            </div>

                            <!-- Education -->
                            <div id="preview-education-section" class="mb-6 hidden">
                                <h3 class="text-sm font-bold text-text-main uppercase tracking-wide mb-3 pb-1 border-b border-border-light"> Education</h3>
                                <div id="preview-education" class="space-y-3"></div>
                            </div>
                        </div>
                    </div>
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
        <h3 class="text-xl font-bold text-text-main dark:text-white mb-2">AI is Building Your Resume</h3>
        <p class="text-text-secondary dark:text-gray-400 text-sm mb-4">Applying professional formatting & templates...
        </p>
        <div class="flex flex-col gap-2 text-xs text-text-muted dark:text-gray-500">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-accent-green text-sm">check_circle</span>
                <span>Compiling experience & skills</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined text-primary text-sm animate-pulse">pending</span>
                <span>Injecting AI-optimized content</span>
            </div>
            <div class="flex items-center gap-2 opacity-50">
                <span class="material-symbols-outlined text-sm">radio_button_unchecked</span>
                <span>Formatting PDF output</span>
            </div>
        </div>
    </div>
</div>

<script>
    let currentStep = 1;
    const totalSteps = 3;

    // Update preview on input change
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('resumeForm').addEventListener('input', function (e) {
            if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') {
                updatePreview();
            }
        });
        updatePreview();
    });

    function updatePreview() {
        const name = document.getElementById('name').value || 'Your Name';
        const title = document.getElementById('title').value || 'Job Title';
        const email = document.getElementById('email').value || 'email@example.com';
        const phone = document.getElementById('phone').value || '+1 234 567 890';
        const location = document.getElementById('location').value || 'Location';
        const summary = document.getElementById('summary').value;
        const skills = document.getElementById('skills').value;

        document.getElementById('preview-name').textContent = name;
        document.getElementById('preview-title').textContent = title;
        document.getElementById('preview-email').innerHTML = `<span class="material-symbols-outlined text-sm">email</span>${email}`;
        document.getElementById('preview-phone').innerHTML = `<span class="material-symbols-outlined text-sm">phone</span>${phone}`;
        document.getElementById('preview-location').innerHTML = `<span class="material-symbols-outlined text-sm">location_on</span>${location}`;

        const summarySection = document.getElementById('preview-summary-section');
        if (summary.trim()) {
            summarySection.classList.remove('hidden');
            document.getElementById('preview-summary').textContent = summary;
        } else {
            summarySection.classList.add('hidden');
        }

        const skillsSection = document.getElementById('preview-skills-section');
        const skillsContainer = document.getElementById('preview-skills');
        if (skills.trim()) {
            skillsSection.classList.remove('hidden');
            const skillArray = skills.split(',').map(s => s.trim()).filter(s => s);
            skillsContainer.innerHTML = skillArray.map(skill =>
                `<span class="px-3 py-1 bg-primary/10 text-primary dark:bg-primary/20 rounded-full text-xs font-medium">${skill}</span>`
            ).join('');
        } else {
            skillsSection.classList.add('hidden');
        }

        updateExperiencePreview();
        updateEducationPreview();
    }

    function updateExperiencePreview() {
        const experienceSection = document.getElementById('preview-experience-section');
        const experienceContainer = document.getElementById('preview-experience');
        const experiences = [];

        document.querySelectorAll('#experienceContainer .experience-item').forEach(item => {
            const company = item.querySelector('.exp-company').value;
            const title = item.querySelector('.exp-title').value;
            const dates = item.querySelector('.exp-dates').value;
            const loc = item.querySelector('.exp-location').value;
            const highlights = item.querySelector('.exp-highlights').value;

            if (company || title) experiences.push({ company, title, dates, location: loc, highlights });
        });

        if (experiences.length > 0) {
            experienceSection.classList.remove('hidden');
            experienceContainer.innerHTML = experiences.map(exp => `
                    <div class="mb-3">
                        <div class="flex justify-between items-start mb-1">
                            <div>
                                <h4 class="font-bold text-gray-900 dark:text-white text-sm">${exp.title || 'Job Title'}</h4>
                                <p class="text-xs text-primary font-semibold">${exp.company || 'Company Name'}</p>
                            </div>
                            <span class="text-xs text-gray-500 dark:text-gray-400">${exp.dates || 'Dates'}</span>
                        </div>
                        ${exp.location ? `<p class="text-xs text-gray-500 dark:text-gray-400 mb-2">${exp.location}</p>` : ''}
                        ${exp.highlights ? `<ul class="list-disc list-inside text-xs text-gray-700 dark:text-gray-300 space-y-1">
                            ${exp.highlights.split('\n').filter(h => h.trim()).map(h => `<li>${h.trim()}</li>`).join('')}
                        </ul>` : ''}
                    </div>
                `).join('');
        } else {
            experienceSection.classList.add('hidden');
        }
    }

    function updateEducationPreview() {
        const educationSection = document.getElementById('preview-education-section');
        const educationContainer = document.getElementById('preview-education');
        const educations = [];

        document.querySelectorAll('#educationContainer .education-item').forEach(item => {
            const school = item.querySelector('.edu-school').value;
            const degree = item.querySelector('.edu-degree').value;
            const dates = item.querySelector('.edu-dates').value;
            const gpa = item.querySelector('.edu-gpa').value;

            if (school || degree) educations.push({ school, degree, dates, gpa });
        });

        if (educations.length > 0) {
            educationSection.classList.remove('hidden');
            educationContainer.innerHTML = educations.map(edu => `
                    <div class="mb-2">
                        <div class="flex justify-between items-start">
                            <div>
                                <h4 class="font-bold text-gray-900 dark:text-white text-sm">${edu.degree || 'Degree'}</h4>
                                <p class="text-xs text-primary font-semibold">${edu.school || 'School/University'}</p>
                            </div>
                            <span class="text-xs text-gray-500 dark:text-gray-400">${edu.dates || 'Dates'}</span>
                        </div>
                        ${edu.gpa ? `<p class="text-xs text-gray-600 dark:text-gray-400 mt-1">GPA: ${edu.gpa}</p>` : ''}
                    </div>
                `).join('');
        } else {
            educationSection.classList.add('hidden');
        }
    }

    function refreshPreview() {
        updatePreview();
        showNotification('Preview refreshed!', 'success');
    }

    function changeStep(direction) {
        const newStep = currentStep + direction;
        if (newStep < 1 || newStep > totalSteps) return;
        if (direction > 0 && !validateStep(currentStep)) return;

        // Hide current
        document.querySelector(`.form-step[data-step="${currentStep}"]`).classList.add('hidden');
        document.querySelector(`.form-step[data-step="${currentStep}"]`).classList.remove('active');

        // Show new
        currentStep = newStep;
        document.querySelector(`.form-step[data-step="${currentStep}"]`).classList.remove('hidden');
        document.querySelector(`.form-step[data-step="${currentStep}"]`).classList.add('active');

        // Update UI
        updateStepper(currentStep);

        // Update Buttons (Simple logic inline or we can keep the helper if needed, but SOP does it differently. 
        // SOP has custom buttons per step. Resume form has global Prev/Next buttons. 
        // I will keep the global buttons logic but integrated here or keep the helper adapted.
        // Let's keep `updateNavigationButtons` but simplify it or just do it inline.)
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        if (prevBtn) {
            if (currentStep === 1) {
                prevBtn.classList.add('hidden');
                prevBtn.classList.remove('flex');
            } else {
                prevBtn.classList.remove('hidden');
                prevBtn.classList.add('flex');
            }
        }
        if (nextBtn) nextBtn.classList.toggle('hidden', currentStep === totalSteps);

        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function validateStep(step) {
        if (step === 1) {
            const templateId = document.getElementById('templateIdInput').value;
            if (!templateId) {
                showNotification('Please select a template', 'error');
                return false;
            }
        }
        if (step === 2) {
            const name = document.getElementById('name').value.trim();
            const title = document.getElementById('title').value.trim();
            const email = document.getElementById('email').value.trim();
            const phone = document.getElementById('phone').value.trim();

            if (!name || !title || !email || !phone) {
                showNotification('Please fill in Name, Title, Email and Phone', 'error');
                return false;
            }

            // Phone numeric validation
            const phoneRegex = /^[0-9]+$/;
            if (!phoneRegex.test(phone)) {
                showNotification('Phone number must contain only numbers', 'error');
                return false;
            }

            // Email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                showNotification('Please enter a valid email address', 'error');
                return false;
            }

            // Experience and Education are now optional
        }
        return true;
    }

    function updateStepper(activeStep) {
        // Reset all steppers
        for (let i = 1; i <= totalSteps; i++) {
            const stepper = document.getElementById(`stepper-${i}`);
            if (!stepper) continue;
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
                stepper.classList.remove('opacity-60');
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

    // AI Generation Functions
    async function generateAiSummary() {
        const title = document.getElementById('title').value;
        const skills = document.getElementById('skills').value;
        if (!title) { showNotification('Please enter a job title first', 'error'); return; }

        const csrfName = '<?= csrf_token() ?>';
        const csrfHash = document.querySelector('input[name="' + csrfName + '"]').value;

        showNotification('Generating AI summary...', 'info');
        try {
            const response = await fetch('<?= base_url('ai-tools/suggest-summary') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    [csrfName]: csrfHash
                },
                body: JSON.stringify({ title, skills })
            });
            const data = await response.json();

            if (data.csrf_token) {
                document.querySelector('input[name="' + csrfName + '"]').value = data.csrf_token;
            }

            if (data.summary) {
                document.getElementById('summary').value = data.summary;
                updatePreview();
                showNotification('Summary generated!', 'success');
            } else {
                showNotification(data.error || 'Failed to generate', 'error');
            }
        } catch (e) { showNotification('Failed to generate summary', 'error'); }
    }

    async function generateAiHighlights(btn) {
        const item = btn.closest('.experience-item');
        const title = item.querySelector('.exp-title').value;
        const company = item.querySelector('.exp-company').value;
        if (!title) { showNotification('Please enter a job title first', 'error'); return; }

        const csrfName = '<?= csrf_token() ?>';
        const csrfHash = document.querySelector('input[name="' + csrfName + '"]').value;

        showNotification('Generating highlights...', 'info');
        try {
            const response = await fetch('<?= base_url('ai-tools/suggest-highlights') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    [csrfName]: csrfHash
                },
                body: JSON.stringify({ title, company })
            });
            const data = await response.json();

            if (data.csrf_token) {
                document.querySelector('input[name="' + csrfName + '"]').value = data.csrf_token;
            }

            if (data.highlights) {
                item.querySelector('.exp-highlights').value = data.highlights;
                updatePreview();
                showNotification('Highlights improved!', 'success');
            } else {
                showNotification(data.error || 'Failed to generate', 'error');
            }
        } catch (e) { showNotification('Failed to improve highlights', 'error'); }
    }

    function addExperience() {
        const container = document.getElementById('experienceContainer');
        const div = document.createElement('div');
        div.className = 'experience-item p-5 border-2 border-border-light dark:border-border-dark rounded-xl bg-gray-50 dark:bg-gray-800/30 relative mt-4';
        div.innerHTML = `
                <button type="button" onclick="removeExperience(this)" class="absolute top-3 right-3 text-red-500 hover:text-red-700">
                    <span class="material-symbols-outlined text-xl">close</span>
                </button>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <input type="text" placeholder="Company Name" maxlength="100" class="exp-company w-full rounded-lg border border-border-light dark:border-border-dark h-11 px-4 bg-white dark:bg-[#2a323c] text-text-main dark:text-white">
                    <input type="text" placeholder="Job Title" maxlength="100" class="exp-title w-full rounded-lg border border-border-light dark:border-border-dark h-11 px-4 bg-white dark:bg-[#2a323c] text-text-main dark:text-white">
                    <input type="text" placeholder="Dates (e.g. Jan 2021 - Present)" maxlength="50" class="exp-dates w-full rounded-lg border border-border-light dark:border-border-dark h-11 px-4 bg-white dark:bg-[#2a323c] text-text-main dark:text-white">
                    <input type="text" placeholder="Location" maxlength="100" class="exp-location w-full rounded-lg border border-border-light dark:border-border-dark h-11 px-4 bg-white dark:bg-[#2a323c] text-text-main dark:text-white">
                </div>
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm font-semibold text-text-main dark:text-gray-200">Responsibilities & Achievements</span>
                    <button type="button" onclick="generateAiHighlights(this)" class="flex items-center gap-1 text-xs font-bold text-primary hover:text-primary-hover">
                        <span class="material-symbols-outlined text-sm">auto_awesome</span>
                        AI Improve
                    </button>
                </div>
                <textarea placeholder="Key achievements (one per line)" maxlength="2000" class="exp-highlights w-full rounded-lg border border-border-light dark:border-border-dark p-4 h-28 bg-white dark:bg-[#2a323c] text-text-main dark:text-white resize-none"></textarea>
            `;
        container.appendChild(div);
    }

    function removeExperience(btn) {
        btn.closest('.experience-item').remove();
        updatePreview();
    }

    function addEducation() {
        const container = document.getElementById('educationContainer');
        const div = document.createElement('div');
        div.className = 'education-item p-5 border-2 border-border-light dark:border-border-dark rounded-xl bg-gray-50 dark:bg-gray-800/30 relative mt-4';
        div.innerHTML = `
                <button type="button" onclick="removeEducation(this)" class="absolute top-3 right-3 text-red-500 hover:text-red-700">
                    <span class="material-symbols-outlined text-xl">close</span>
                </button>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="text" placeholder="School/University" maxlength="100" class="edu-school w-full rounded-lg border border-border-light dark:border-border-dark h-11 px-4 bg-white dark:bg-[#2a323c] text-text-main dark:text-white">
                    <input type="text" placeholder="Degree & Major" maxlength="100" class="edu-degree w-full rounded-lg border border-border-light dark:border-border-dark h-11 px-4 bg-white dark:bg-[#2a323c] text-text-main dark:text-white">
                    <input type="text" placeholder="Graduation Date" maxlength="50" class="edu-dates w-full rounded-lg border border-border-light dark:border-border-dark h-11 px-4 bg-white dark:bg-[#2a323c] text-text-main dark:text-white">
                    <input type="text" placeholder="GPA (Optional)" maxlength="10" class="edu-gpa w-full rounded-lg border border-border-light dark:border-border-dark h-11 px-4 bg-white dark:bg-[#2a323c] text-text-main dark:text-white">
                </div>
            `;
        container.appendChild(div);
    }

    function removeEducation(btn) {
        btn.closest('.education-item').remove();
        updatePreview();
    }

    function selectTemplate(id) {
        document.querySelectorAll('.template-btn').forEach(btn => btn.classList.remove('border-primary', 'ring-4', 'ring-primary/30', 'shadow-lg'));
        document.getElementById('btn_template_' + id).classList.add('border-primary', 'ring-4', 'ring-primary/30', 'shadow-lg');
        document.getElementById('templateIdInput').value = id;
        showNotification('Template ' + id + ' selected', 'success');
    }

    async function downloadResume(format) {
        // 1. Initial Access Check before allowing download
        const coupon = document.getElementById('coupon_code').value;
        const paymentId = document.getElementById('razorpay_payment_id').value;

        try {
            const resp = await fetch('<?= base_url('ai-tools/check-price') ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    tool_id: 2, // Resume Builder
                    coupon_code: coupon
                })
            });
            const data = await resp.json();

            if (data.error) {
                showNotification(data.error, 'error');
                return;
            }

            if (data.final_price > 0 && !paymentId) {
                // Payment required but not done
                const options = {
                    "key": data.razorpay_key || "<?= esc($settings['razorpay_key_id'] ?? '') ?>",
                    "amount": data.final_price * 100,
                    "currency": "INR",
                    "name": "<?= esc($settings['site_name'] ?? 'UniHunt') ?>",
                    "description": "Premium Resume Download",
                    "order_id": data.order_id,
                    "handler": function (response) {
                        document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id;
                        document.getElementById('razorpay_order_id').value = response.razorpay_order_id;
                        document.getElementById('razorpay_signature').value = response.razorpay_signature;

                        // Proceed to download
                        processDownload(format);
                    },
                    "prefill": {
                        "name": document.getElementById('name').value,
                        "email": document.getElementById('email').value,
                        "contact": document.getElementById('phone').value,
                    },
                    "theme": { "color": "#4f46e5" }
                };
                const rzp = new Razorpay(options);
                rzp.open();
                return;
            }

            // If free, waived, or already paid
            processDownload(format);

        } catch (e) {
            // Fallback: If the UI shows free/0.00, assume it's free and allow submission
            const priceDisplay = document.getElementById('final-price-display');
            if (priceDisplay && (priceDisplay.textContent.includes('0.00') || priceDisplay.textContent.trim() === '₹0')) {
                processDownload(format);
                return;
            }
            showNotification('Internal error. Please try again.', 'error');
        }
    }

    function processDownload(format) {
        // Create a temporary form to submit properly in a new tab
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?= base_url('ai-tools/generate-resume') ?>';
        form.target = '_blank'; // Open in new tab
        form.style.display = 'none';

        // Add CSRF Token
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        const csrfName = '<?= csrf_token() ?>';
        const csrfHash = document.querySelector('input[name="' + csrfName + '"]').value;
        csrfInput.name = csrfName;
        csrfInput.value = csrfHash;
        form.appendChild(csrfInput);

        // Add formatted input data
        const inputs = {
            'name': document.getElementById('name').value,
            'title': document.getElementById('title').value,
            'email': document.getElementById('email').value,
            'phone': document.getElementById('phone').value,
            'location': document.getElementById('location').value,
            'linkedin': document.getElementById('linkedin').value,
            'summary': document.getElementById('summary').value,
            'skills': document.getElementById('skills').value,
            'template_id': document.getElementById('templateIdInput').value,
            'format': format
        };

        // Collect Experience
        const experiences = [];
        document.querySelectorAll('#experienceContainer .experience-item').forEach(item => {
            const company = item.querySelector('.exp-company').value;
            if (company) {
                experiences.push({
                    company, title: item.querySelector('.exp-title').value,
                    dates: item.querySelector('.exp-dates').value,
                    location: item.querySelector('.exp-location').value,
                    highlights: item.querySelector('.exp-highlights').value.split('\n').filter(h => h.trim())
                });
            }
        });
        inputs['experience'] = JSON.stringify(experiences);

        // Collect Education
        const educations = [];
        document.querySelectorAll('#educationContainer .education-item').forEach(item => {
            const school = item.querySelector('.edu-school').value;
            if (school) {
                educations.push({
                    school, degree: item.querySelector('.edu-degree').value,
                    dates: item.querySelector('.edu-dates').value, gpa: item.querySelector('.edu-gpa').value
                });
            }
        });
        inputs['education'] = JSON.stringify(educations);

        // Append inputs to form
        for (const key in inputs) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = inputs[key];
            form.appendChild(input);
        }

        // Add Razorpay details if present
        const rzpPayId = document.getElementById('razorpay_payment_id').value;
        if (rzpPayId) {
            const pid = document.createElement('input');
            pid.type = 'hidden'; pid.name = 'razorpay_payment_id'; pid.value = rzpPayId;
            form.appendChild(pid);
            const oid = document.createElement('input');
            oid.type = 'hidden'; oid.name = 'razorpay_order_id'; oid.value = document.getElementById('razorpay_order_id').value;
            form.appendChild(oid);
            const sig = document.createElement('input');
            sig.type = 'hidden'; sig.name = 'razorpay_signature'; sig.value = document.getElementById('razorpay_signature').value;
            form.appendChild(sig);
        }

        // Add Coupon if present
        const coupon = document.getElementById('coupon_code').value;
        if (coupon) {
            const cp = document.createElement('input');
            cp.type = 'hidden'; cp.name = 'coupon_code'; cp.value = coupon;
            form.appendChild(cp);
        }

        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);

        showNotification('Opening resume preview...', 'success');
    }

    // Payment Utility Functions
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
                body: JSON.stringify({ tool_id: 2, coupon_code: code })
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
                // Clear previous payment session if coupon changed
                document.getElementById('razorpay_payment_id').value = '';
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
    }

    // Load price when entering step 3
    const stepObserver = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                const step3 = document.querySelector('.form-step[data-step="3"]');
                if (step3 && !step3.classList.contains('hidden')) {
                    loadInitialPrice();
                }
            }
        });
    });
    const step3El = document.querySelector('.form-step[data-step="3"]');
    if (step3El) stepObserver.observe(step3El, { attributes: true });

    async function loadInitialPrice() {
        try {
            const response = await fetch('<?= base_url('ai-tools/check-price') ?>', {
                method: 'POST', headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ tool_id: 2 })
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
        n.className = `fixed top-4 right-4 z-[9999] px-6 py-3 rounded-lg shadow-lg text-white font-medium transition-all ${colors[type]}`;
        n.textContent = message;
        document.body.appendChild(n);
        setTimeout(() => { n.style.opacity = '0'; setTimeout(() => n.remove(), 300); }, 3000);
    }

    // Show loading overlay on form submit (if form had standard submission)
    if (document.getElementById('resumeForm')) {
        document.getElementById('resumeForm').addEventListener('submit', function (e) {
            if (currentStep === totalSteps) {
                document.getElementById('loadingOverlay').classList.remove('hidden');
                document.getElementById('loadingOverlay').classList.add('flex');
            }
        });
    }
</script>
<?= view('web/include/footer') ?>