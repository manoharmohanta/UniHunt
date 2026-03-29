<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>
<div class="max-w-4xl mx-auto">
    <!-- Breadcrumb/Back -->
    <a href="<?= base_url('admin/courses') ?>"
        class="inline-flex items-center gap-2 text-slate-500 hover:text-indigo-600 font-bold text-sm mb-6 transition-colors">
        <span class="material-symbols-outlined text-sm">arrow_back</span> Back to list
    </a>

    <!-- Form Card -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-10 py-8 border-b border-slate-100 bg-slate-50/50">
            <h2 class="text-2xl font-bold text-slate-800">Edit Course</h2>
            <p class="text-slate-500 font-medium mt-1">Update educational program details and requirements</p>
        </div>

        <form id="courseForm" action="<?= base_url('admin/courses/update/' . $course['id']) ?>" method="POST">
            <?= csrf_field() ?>
            <?= honeypot_field() ?>

            <div class="p-10 space-y-8">
                <!-- Affiliation Section -->
                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                        <div class="size-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                            <span class="material-symbols-outlined text-sm">school</span>
                        </div>
                        <h3 class="font-bold text-slate-800">Affiliation</h3>
                    </div>

                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Target University</label>
                            <select name="university_id" id="university_id"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-medium"
                                required>
                                <option value=""></option>
                                <?php foreach ($universities as $uni): ?>
                                    <option value="<?= $uni['id'] ?>" <?= $uni['id'] == $course['university_id'] ? 'selected' : '' ?>><?= $uni['name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <hr class="border-slate-100">

                <!-- Program Details -->
                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                        <div class="size-8 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center">
                            <span class="material-symbols-outlined text-sm">menu_book</span>
                        </div>
                        <h3 class="font-bold text-slate-800">Program Details</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Course Name</label>
                            <input type="text" name="name" id="course_name" value="<?= esc($course['name']) ?>"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-medium"
                                required placeholder="e.g. Master of Computer Science">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Program Level</label>
                            <select name="level" id="level"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-medium"
                                required>
                                <option value="Diploma" <?= $course['level'] == 'Diploma' ? 'selected' : '' ?>>Diploma</option>
                                <option value="Bachelors" <?= $course['level'] == 'Bachelors' ? 'selected' : '' ?>>Bachelors</option>
                                <option value="Masters" <?= $course['level'] == 'Masters' ? 'selected' : '' ?>>Masters</option>
                                <option value="PhD" <?= $course['level'] == 'PhD' ? 'selected' : '' ?>>PhD</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Duration (Months)</label>
                            <input type="number" name="duration_months" value="<?= esc($course['duration_months']) ?>"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-medium"
                                placeholder="e.g. 24">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Annual Tuition Fee</label>
                            <input type="number" step="0.01" name="tuition_fee" value="<?= esc($course['tuition_fee']) ?>"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-medium"
                                placeholder="0.00">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Total Credits</label>
                            <input type="number" name="credits" id="credits" value="<?= esc($course['credits'] ?? 0) ?>"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-medium"
                                placeholder="e.g. 120">
                        </div>
                    </div>

                    <div class="flex items-center gap-6 p-4 bg-slate-50 rounded-xl">
                        <div class="flex items-center gap-3">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="stem" id="stem" value="1" <?= $course['stem'] ? 'checked' : '' ?> class="sr-only peer">
                                <div
                                    class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-100 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600">
                                </div>
                            </label>
                            <span class="text-sm font-bold text-slate-700">STEM Program</span>
                        </div>

                        <div id="classificationContainer"
                            class="hidden items-center gap-3 border-l border-slate-200 pl-6">
                            <span class="text-xs font-bold text-slate-500 uppercase tracking-widest">Classification</span>
                            <div class="flex gap-2">
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input type="radio" name="metadata[classification]" value="International"
                                        class="hidden peer" <?= ($course['metadata']['classification'] ?? 'International') === 'International' ? 'checked' : '' ?>>
                                    <div
                                        class="px-3 py-1.5 rounded-lg border border-slate-200 text-xs font-bold text-slate-500 peer-checked:border-indigo-600 peer-checked:bg-indigo-50 peer-checked:text-indigo-600 transition-all hover:bg-slate-100">
                                        International</div>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input type="radio" name="metadata[classification]" value="Domestic"
                                        class="hidden peer" <?= ($course['metadata']['classification'] ?? '') === 'Domestic' ? 'checked' : '' ?>>
                                    <div
                                        class="px-3 py-1.5 rounded-lg border border-slate-200 text-xs font-bold text-slate-500 peer-checked:border-indigo-600 peer-checked:bg-indigo-50 peer-checked:text-indigo-600 transition-all hover:bg-slate-100">
                                        Domestic</div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="border-slate-100">

                <!-- Dynamic Admission Requirements -->
                <div class="space-y-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="size-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
                                <span class="material-symbols-outlined text-sm">cognition</span>
                            </div>
                            <h3 class="font-bold text-slate-800">Dynamic Requirements</h3>
                        </div>
                        <div id="requirementsLoading" class="hidden animate-spin size-4 border-2 border-indigo-600 border-t-transparent rounded-full"></div>
                    </div>

                    <div id="requirementsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 p-6 bg-slate-50/50 rounded-2xl border border-slate-100">
                        <!-- Dynamic content -->
                    </div>
                    <div id="noRequirements" class="hidden col-span-full text-center py-4 text-slate-400 font-medium italic">
                        No specific requirements found for this level.
                    </div>
                </div>

                <hr class="border-slate-100">

                <!-- Insights & Outcomes -->
                <div class="space-y-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="size-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
                                <span class="material-symbols-outlined text-sm">trending_up</span>
                            </div>
                            <h3 class="font-bold text-slate-800">Insights & Outcomes</h3>
                        </div>
                        <button type="button" id="generateAI"
                            class="flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 disabled:bg-emerald-300 text-white text-xs font-bold rounded-xl transition-all shadow-lg shadow-emerald-100">
                            <span class="material-symbols-outlined text-sm ai-icon">auto_awesome</span>
                            <span class="hidden animate-spin size-3 border-2 border-white border-t-transparent rounded-full ai-spinner"></span>
                            <span class="ai-text">Generate with AI</span>
                        </button>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Specific Field of Study</label>
                            <input type="text" name="field" id="field" value="<?= esc($course['field']) ?>"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-emerald-50 focus:border-emerald-500 transition-all font-medium"
                                placeholder="e.g. Artificial Intelligence, Marketing Strategy">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Course Notes</label>
                            <textarea name="metadata[notes]" id="metadata_notes" rows="3"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-emerald-50 focus:border-emerald-500 transition-all font-medium"
                                placeholder="Summary or important highlights..."><?= esc($course['metadata']['notes'] ?? '') ?></textarea>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Syllabus & Modules</label>
                            <textarea name="metadata[syllabus]" id="metadata_syllabus" rows="3"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-emerald-50 focus:border-emerald-500 transition-all font-medium"
                                placeholder="Key modules and curriculum details..."><?= esc($course['metadata']['syllabus'] ?? '') ?></textarea>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Career Outcomes</label>
                            <textarea name="metadata[career_outcomes]" id="metadata_career_outcomes" rows="2"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-emerald-50 focus:border-emerald-500 transition-all font-medium"
                                placeholder="Potential industries and career growth..."><?= esc($course['metadata']['career_outcomes'] ?? '') ?></textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Employment Rate</label>
                            <input type="text" name="metadata[employment_rate]" id="metadata_employment_rate" value="<?= esc($course['metadata']['employment_rate'] ?? '') ?>"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-emerald-50 focus:border-emerald-500 transition-all font-medium"
                                placeholder="e.g. 95%">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Avg. Starting Salary</label>
                            <input type="text" name="metadata[avg_salary]" id="metadata_avg_salary" value="<?= esc($course['metadata']['avg_salary'] ?? '') ?>"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-emerald-50 focus:border-emerald-500 transition-all font-medium"
                                placeholder="e.g. $65,000">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Top Hiring Roles</label>
                            <input type="text" name="metadata[top_roles]" id="metadata_top_roles" value="<?= esc($course['metadata']['top_roles'] ?? '') ?>"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-emerald-50 focus:border-emerald-500 transition-all font-medium"
                                placeholder="e.g. Software Engineer, Data Analyst, Project Manager">
                        </div>
                    </div>
                </div>

                <hr class="border-slate-100">

                <!-- Intake Section -->
                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                        <div class="size-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                            <span class="material-symbols-outlined text-sm">calendar_month</span>
                        </div>
                        <h3 class="font-bold text-slate-800">Intake Availability</h3>
                    </div>

                    <div class="grid grid-cols-4 md:grid-cols-6 gap-3">
                        <?php $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                        foreach ($months as $m): ?>
                            <label
                                class="relative flex items-center justify-center p-3 rounded-xl border-2 cursor-pointer transition-all group hover:border-indigo-200 has-[:checked]:border-indigo-600 has-[:checked]:bg-indigo-50">
                                <input type="checkbox" name="intake_months[]" value="<?= $m ?>" 
                                       <?= in_array($m, $course['intake_months']) ? 'checked' : '' ?>
                                       class="sr-only peer">
                                <span
                                    class="text-xs font-bold text-slate-500 peer-checked:text-indigo-600 group-hover:text-slate-700"><?= $m ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="px-10 py-8 bg-slate-50 border-t border-slate-100 flex justify-end">
                <button type="submit"
                    class="px-12 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-2xl shadow-xl shadow-indigo-100 transition-all transform hover:-translate-y-1 active:scale-95">
                    Update Course
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let csrfToken = '<?= csrf_hash() ?>';
    const csrfName = '<?= csrf_token() ?>';
    const savedMetadata = <?= json_encode($course['metadata'] ?: []) ?>;
    
    // Elements
    const universitySelect = $('#university_id');
    const levelSelect = document.getElementById('level');
    const stemCheckbox = document.getElementById('stem');
    const requirementsContainer = document.getElementById('requirementsContainer');
    const requirementsLoading = document.getElementById('requirementsLoading');
    const noRequirements = document.getElementById('noRequirements');
    const generateAIBtn = document.getElementById('generateAI');
    
    // Initialize Select2
    universitySelect.select2({
        placeholder: 'Search university...',
        width: '100%'
    }).on('change', function(e) {
        fetchRequirements();
    });

    levelSelect.addEventListener('change', fetchRequirements);
    stemCheckbox.addEventListener('change', function() {
        toggleClassification();
        fetchRequirements();
    });

    function toggleClassification() {
        const container = document.getElementById('classificationContainer');
        if (stemCheckbox.checked) {
            container.classList.add('hidden');
            container.classList.remove('flex');
        } else {
            container.classList.remove('hidden');
            container.classList.add('flex');
        }
    }
    
    // Initial state check
    toggleClassification();

    async function fetchRequirements() {
        requirementsLoading.classList.remove('hidden');
        requirementsContainer.classList.add('opacity-50');
        
        const universityId = universitySelect.val();
        const level = levelSelect.value;
        const stem = stemCheckbox.checked;

        try {
            let formData = new FormData();
            formData.append('level', level);
            formData.append('stem', stem);
            formData.append('university_id', universityId);
            formData.append('target_type', 'Course');
            formData.append(csrfName, csrfToken);
            
            const response = await fetch('<?= base_url('admin/requirements/get-requirements') ?>', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const data = await response.json();
            
            if (data.csrf) {
                csrfToken = data.csrf;
                if (typeof updateCSRF === 'function') updateCSRF(data.csrf);
            }

            renderRequirements(data.results || []);
            
        } catch (e) {
            console.error('Failed to fetch requirements', e);
        } finally {
            requirementsLoading.classList.add('hidden');
            requirementsContainer.classList.remove('opacity-50');
        }
    }

    function renderRequirements(requirements) {
        requirementsContainer.innerHTML = '';
        
        if (requirements.length === 0) {
            noRequirements.classList.remove('hidden');
            return;
        }

        noRequirements.classList.add('hidden');
        
        requirements.forEach(req => {
            const div = document.createElement('div');
            if (req.type === 'string') div.className = 'col-span-2';
            
            const val = savedMetadata[req.code] || '';
            
            let inputHtml = '';
            if (req.type === 'number') {
                inputHtml = `
                    <div class="relative group">
                        <input type="text" name="metadata[${req.code}]" id="meta_${req.code}" value="${val}"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-medium"
                            placeholder="Score or 'Not Accepted'">
                        <div class="flex flex-wrap gap-2 mt-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <button type="button" onclick="document.getElementById('meta_${req.code}').value = 'Waiver Available'" 
                                class="text-[9px] font-bold text-emerald-600 uppercase hover:underline">Mark Waiver</button>
                            <button type="button" onclick="document.getElementById('meta_${req.code}').value = 'Not Accepted'" 
                                class="text-[9px] font-bold text-rose-500 uppercase hover:underline">Mark Not Accepted</button>
                            <button type="button" onclick="document.getElementById('meta_${req.code}').value = 'N/A'" 
                                class="text-[9px] font-bold text-slate-400 uppercase hover:underline">N/A</button>
                        </div>
                    </div>`;
            } else if (req.type === 'string') {
                inputHtml = `<input type="text" name="metadata[${req.code}]" value="${val}"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-medium"
                                placeholder="Enter details">`;
            } else if (req.type === 'boolean') {
                inputHtml = `<select name="metadata[${req.code}]"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-4 focus:ring-indigo-50 focus:border-indigo-500 transition-all font-medium">
                                <option value="Yes" ${val === 'Yes' ? 'selected' : ''}>Yes</option>
                                <option value="No" ${val === 'No' ? 'selected' : ''}>No</option>
                            </select>`;
            }

            div.innerHTML = `
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">${req.label}</label>
                ${inputHtml}
            `;
            requirementsContainer.appendChild(div);
        });
    }

    // AI Generation
    generateAIBtn.addEventListener('click', async function() {
        const name = document.getElementById('course_name').value;
        if (!name) return alert('Please enter course name first');
        
        // Show loading
        const icon = generateAIBtn.querySelector('.ai-icon');
        const spinner = generateAIBtn.querySelector('.ai-spinner');
        const text = generateAIBtn.querySelector('.ai-text');
        
        generateAIBtn.disabled = true;
        icon.classList.add('hidden');
        spinner.classList.remove('hidden');
        text.innerText = 'Generating...';

        try {
            let formData = new FormData();
            formData.append('university_id', universitySelect.val());
            formData.append('name', name);
            formData.append('level', levelSelect.value);
            formData.append(csrfName, csrfToken);
            
            const response = await fetch('<?= base_url('admin/courses/ai-generate-insights') ?>', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const res = await response.json();
            
            if (res.csrf) {
                csrfToken = res.csrf;
                if (typeof updateCSRF === 'function') updateCSRF(res.csrf);
            }
            
            if (res.error) {
                alert(res.error);
            } else {
                const data = res.data;
                if (data.error) return alert(data.error);

                if (data.field) document.getElementById('field').value = data.field;
                if (data.credits) document.getElementById('credits').value = data.credits;
                if (data.notes) document.getElementById('metadata_notes').value = data.notes;
                if (data.syllabus) document.getElementById('metadata_syllabus').value = data.syllabus;
                if (data.career_outcomes) document.getElementById('metadata_career_outcomes').value = data.career_outcomes;
                if (data.employment_rate) document.getElementById('metadata_employment_rate').value = data.employment_rate;
                if (data.avg_salary) document.getElementById('metadata_avg_salary').value = data.avg_salary;
                if (data.top_roles) document.getElementById('metadata_top_roles').value = data.top_roles;
            }
        } catch (e) {
            alert('AI Generation failed: ' + e.message);
        } finally {
            generateAIBtn.disabled = false;
            icon.classList.remove('hidden');
            spinner.classList.add('hidden');
            text.innerText = 'Generate with AI';
        }
    });

    // Handle global CSRF updates
    window.addEventListener('csrf-updated', function(e) {
        csrfToken = e.detail;
    });

    // Initial fetch
    fetchRequirements();
});
</script>

<?= $this->endSection() ?>
