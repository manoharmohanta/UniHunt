<?= view('web/include/header', ['title' => 'UniHunt - University Directory', 'bodyClass' => 'bg-background-light dark:bg-background-dark font-display text-text-main dark:text-gray-100 min-h-screen flex flex-col']) ?>

<!-- Main Layout -->
<div class="flex-1 max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumbs -->
    <nav aria-label="Breadcrumb" class="flex mb-8">
        <ol class="flex items-center space-x-2">
            <li><a class="text-text-muted hover:text-primary text-sm font-medium" href="<?= base_url() ?>">Home</a></li>
            <li><span class="text-text-muted text-sm">/</span></li>
            <li><a class="text-text-muted hover:text-primary text-sm font-medium"
                    href="<?= base_url('universities') ?>">Study Abroad</a></li>
            <li><span class="text-text-muted text-sm">/</span></li>
            <li><span class="text-text-main dark:text-white text-sm font-medium">
                    <?= isset($country) ? 'Study in ' . ucfirst($country) : 'Universities' ?>
                </span></li>
        </ol>
    </nav>
    <div class="flex flex-col lg:flex-row gap-8 items-start">
        <!-- Filters Sidebar -->
        <form id="searchForm" action="<?= base_url('universities') ?>" method="get" x-data='{ 
            subjectOpen: false, 
            majorOpen: false,
            subjectQuery: `<?= esc(service("request")->getGet("subject") ?? "", "js") ?>`,
            majorQuery: `<?= esc(service("request")->getGet("major") ?? "", "js") ?>`,
            subjects: <?= json_encode($filter_subjects ?? []) ?>,
            majors: <?= json_encode($filter_majors ?? []) ?>,
            get filteredSubjects() {
                if (this.subjectQuery === "") return this.subjects.slice(0, 10);
                return this.subjects.filter(s => s.toLowerCase().includes(this.subjectQuery.toLowerCase())).slice(0, 10);
            },
            get filteredMajors() {
                if (this.majorQuery === "") return this.majors.slice(0, 10);
                return this.majors.filter(m => m.toLowerCase().includes(this.majorQuery.toLowerCase())).slice(0, 10);
            }
        }' class="w-full lg:w-80 shrink-0 lg:sticky lg:top-24 bg-surface-light dark:bg-surface-dark rounded-xl shadow-soft border border-border-light dark:border-border-dark p-6 overflow-visible">
            
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold">Filter Results</h3>
                <a href="<?= base_url('universities') ?>" class="text-xs font-medium text-text-muted hover:text-primary">Clear All</a>
            </div>

            <!-- AI Smart Recommendations -->
            <div class="mb-8 p-4 bg-primary/5 dark:bg-primary/10 rounded-xl border border-primary/20">
                <label class="flex items-center gap-3 cursor-pointer group">
                    <input name="ai_recommend" value="1" <?= service('request')->getGet('ai_recommend') == '1' ? 'checked' : '' ?>
                        class="size-5 rounded border-gray-300 text-primary focus:ring-primary bg-transparent"
                        type="checkbox" />
                    <div class="flex flex-col">
                        <span class="text-sm font-black text-primary uppercase tracking-tight">AI Smart Search</span>
                        <span class="text-[10px] text-text-muted leading-tight">Get personalized university recommendations based on your profile</span>
                    </div>
                </label>
            </div>

            <!-- Location & Academic Goal -->
            <div class="mb-8">
                <label class="block text-sm font-bold mb-3">Country Planning to Study</label>
                <div class="relative mb-3">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-text-muted">
                        <span class="material-symbols-outlined text-lg">search</span>
                    </span>
                    <input id="countrySearchInput"
                        class="w-full pl-9 pr-3 py-2 text-sm border border-border-light dark:border-border-dark rounded-lg bg-background-light dark:bg-gray-800 focus:ring-1 focus:ring-primary focus:border-primary"
                        placeholder="Search Country" type="text" />
                </div>
                <div id="countryList" class="space-y-2 max-h-48 overflow-y-auto custom-scrollbar">
                    <?php
                    $selectedCountries = service('request')->getGet('country') ?? [];
                    if (!empty($filter_countries)):
                        ?>
                                <?php foreach ($filter_countries as $country): ?>
                                            <label class="flex items-center gap-3 cursor-pointer group country-item">
                                                <input name="country[]" value="<?= esc($country['id']) ?>" 
                                                    <?= in_array($country['id'], $selectedCountries) ? 'checked' : '' ?>
                                                    class="size-4 rounded border-gray-300 text-primary focus:ring-primary bg-transparent"
                                                    type="checkbox" />
                                                <span class="text-sm text-text-main dark:text-gray-300 group-hover:text-primary transition-colors country-name">
                                                    <?= esc($country['name']) ?>
                                                </span>
                                            </label>
                                <?php endforeach; ?>
                    <?php else: ?>
                                <p class="text-xs text-text-muted">No countries found.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Academic Profile Section -->
            <div class="mb-8 border-t border-border-light dark:border-border-dark pt-8" x-data="{ showAcademic: <?= !empty(service('request')->getGet('ielts')) ? 'true' : 'false' ?> }">
                <div class="flex items-center justify-between mb-4">
                    <label class="text-sm font-bold">Your Academic Profile</label>
                    <button type="button" @click="showAcademic = !showAcademic" class="text-xs text-primary font-bold flex items-center gap-1">
                        <span x-text="showAcademic ? 'Hide' : 'Show'">Show</span>
                        <span class="material-symbols-outlined text-xs transition-transform" :class="showAcademic ? 'rotate-180' : ''">expand_more</span>
                    </button>
                </div>
                
                <div x-show="showAcademic" x-collapse x-cloak class="space-y-5">
                    <!-- Academic Data -->
                    <div>
                        <label class="block text-[10px] uppercase font-bold text-text-muted mb-1.5 tracking-wider">Academic Performance (GPA/%)</label>
                        <input type="text" name="academic_data" value="<?= esc(service('request')->getGet('academic_data') ?: ($user_profile['academic_data'] ?? '')) ?>" placeholder="e.g. 3.8 or 85%" 
                            class="w-full px-3 py-2 text-sm bg-background-light dark:bg-gray-800 border border-border-light dark:border-border-dark rounded-lg focus:ring-1 focus:ring-primary">
                    </div>

                    <!-- Scores Row -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] uppercase font-bold text-text-muted mb-1.5 tracking-wider">IELTS Score</label>
                            <input type="number" step="0.5" name="ielts" value="<?= esc(service('request')->getGet('ielts') ?: ($user_profile['ielts_score'] ?? '')) ?>" placeholder="7.5"
                                class="w-full px-3 py-2 text-sm bg-background-light dark:bg-gray-800 border border-border-light dark:border-border-dark rounded-lg focus:ring-1 focus:ring-primary">
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase font-bold text-text-muted mb-1.5 tracking-wider">GRE Score</label>
                            <input type="number" name="gre" value="<?= esc(service('request')->getGet('gre') ?: ($user_profile['gre_score'] ?? '')) ?>" placeholder="310"
                                class="w-full px-3 py-2 text-sm bg-background-light dark:bg-gray-800 border border-border-light dark:border-border-dark rounded-lg focus:ring-1 focus:ring-primary">
                        </div>
                    </div>

                    <!-- Backlogs & Ed Year -->
                    <div>
                        <label class="block text-[10px] uppercase font-bold text-text-muted mb-1.5 tracking-wider">Active Backlogs</label>
                        <input type="number" name="backlogs" value="<?= esc(service('request')->getGet('backlogs') ?: ($user_profile['backlogs'] ?? '')) ?>" placeholder="0"
                            class="w-full px-3 py-2 text-sm bg-background-light dark:bg-gray-800 border border-border-light dark:border-border-dark rounded-lg focus:ring-1 focus:ring-primary">
                    </div>

                    <div class="flex flex-col gap-3 pt-2">
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input name="edu_15" value="1" <?= (service('request')->getGet('edu_15') == '1' || ($user_profile['is_15_years_education'] ?? false)) ? 'checked' : '' ?>
                                class="size-4 rounded border-gray-300 text-primary focus:ring-primary bg-transparent"
                                type="checkbox" />
                            <span class="text-xs font-bold text-text-main dark:text-gray-300">15 Years Education Complete</span>
                        </label>
                        
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input name="stem" value="1" <?= (service('request')->getGet('stem') == '1' || ($user_profile['stem_interest'] ?? false)) ? 'checked' : '' ?>
                                class="size-4 rounded border-gray-300 text-primary focus:ring-primary bg-transparent"
                                type="checkbox" />
                            <span class="text-xs font-bold text-text-main dark:text-gray-300">Interested in STEM Programs</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Program Filters -->
            <div class="mb-8 border-t border-border-light dark:border-border-dark pt-8">
                <label class="block text-sm font-bold mb-3">Choice of Study</label>
                <!-- Subject Area (with suggestions) -->
                <div class="mb-4 relative" @click.away="subjectOpen = false">
                    <div class="relative">
                        <input type="text" name="subject" x-model="subjectQuery" @focus="subjectOpen = true; majorOpen = false"
                            class="w-full pl-3 pr-10 py-2.5 text-sm bg-background-light dark:bg-gray-800 border border-border-light dark:border-border-dark rounded-lg focus:ring-1 focus:ring-primary focus:border-primary"
                            placeholder="e.g. Computer Science">
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none text-text-muted">
                            <span class="material-symbols-outlined text-lg">category</span>
                        </div>
                    </div>
                    <!-- Suggestions Dropdown -->
                    <div x-show="subjectOpen && filteredSubjects.length > 0" 
                        class="absolute z-50 w-full mt-1 bg-white dark:bg-gray-800 border border-border-light dark:border-border-dark rounded-lg shadow-xl max-h-60 overflow-y-auto">
                        <template x-for="s in filteredSubjects" :key="s">
                            <div @click="subjectQuery = s; subjectOpen = false" 
                                class="px-4 py-2 text-sm hover:bg-primary/10 hover:text-primary cursor-pointer transition-colors"
                                x-text="s"></div>
                        </template>
                    </div>
                </div>

                <!-- Specific Major (with suggestions) -->
                <div class="mb-4 relative" @click.away="majorOpen = false">
                    <div class="relative">
                        <input type="text" name="major" x-model="majorQuery" @focus="majorOpen = true; subjectOpen = false"
                            class="w-full pl-3 pr-10 py-2.5 text-sm bg-background-light dark:bg-gray-800 border border-border-light dark:border-border-dark rounded-lg focus:ring-1 focus:ring-primary focus:border-primary"
                            placeholder="e.g. Data Analytics">
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none text-text-muted">
                            <span class="material-symbols-outlined text-lg">history_edu</span>
                        </div>
                    </div>
                    <!-- Suggestions Dropdown -->
                    <div x-show="majorOpen && filteredMajors.length > 0" 
                        class="absolute z-50 w-full mt-1 bg-white dark:bg-gray-800 border border-border-light dark:border-border-dark rounded-lg shadow-xl max-h-60 overflow-y-auto">
                        <template x-for="m in filteredMajors" :key="m">
                            <div @click="majorQuery = m; majorOpen = false" 
                                class="px-4 py-2 text-sm hover:bg-primary/10 hover:text-primary cursor-pointer transition-colors"
                                x-text="m"></div>
                        </template>
                    </div>
                </div>

                <!-- Program Level -->
                <div class="mb-4">
                    <select name="level"
                        class="w-full pl-3 pr-10 py-2.5 text-sm bg-background-light dark:bg-gray-800 border border-border-light dark:border-border-dark rounded-lg appearance-none focus:ring-1 focus:ring-primary focus:border-primary">
                        <option value="">Any Level</option>
                        <?php foreach ($filter_levels as $level): ?>
                                    <option value="<?= esc($level) ?>" <?= service('request')->getGet('level') == $level ? 'selected' : '' ?>>
                                        <?= esc($level) ?>
                                    </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- University Type & Costs -->
            <div class="mb-8 border-t border-border-light dark:border-border-dark pt-8">
                <label class="block text-sm font-bold mb-3">More Filters</label>
                
                <div class="grid grid-cols-2 gap-2 mb-4">
                    <label class="flex flex-col items-center p-3 border border-border-light dark:border-border-dark rounded-lg cursor-pointer hover:border-primary transition-colors has-[:checked]:bg-primary/5 has-[:checked]:border-primary">
                        <input name="classification" value="International" <?= service('request')->getGet('classification') == 'International' ? 'checked' : '' ?> class="hidden" type="radio" />
                        <span class="material-symbols-outlined text-xl mb-1">public</span>
                        <span class="text-[10px] font-bold uppercase">International</span>
                    </label>
                    <label class="flex flex-col items-center p-3 border border-border-light dark:border-border-dark rounded-lg cursor-pointer hover:border-primary transition-colors has-[:checked]:bg-primary/5 has-[:checked]:border-primary">
                        <input name="classification" value="Domestic" <?= service('request')->getGet('classification') == 'Domestic' ? 'checked' : '' ?> class="hidden" type="radio" />
                        <span class="material-symbols-outlined text-xl mb-1">home</span>
                        <span class="text-[10px] font-bold uppercase">Domestic</span>
                    </label>
                </div>

                <div class="space-y-4">
                    <!-- Tuition Slider -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label class="text-[10px] font-bold uppercase text-text-muted">Max Tuition</label>
                            <span class="text-[10px] font-bold text-primary">$<?= number_format((service('request')->getGet('max_tuition') ?? ($filter_max_tuition ?? 50000)) / 1000, 0) ?>k</span>
                        </div>
                        <input name="max_tuition"
                            class="w-full h-1.5 bg-gray-200 dark:bg-gray-700 rounded-lg appearance-none cursor-pointer accent-primary"
                            max="<?= esc($filter_max_tuition ?? 50000) ?>" min="0" type="range" 
                            value="<?= service('request')->getGet('max_tuition') ?? ($filter_max_tuition ?? 50000) ?>" />
                    </div>
                </div>
            </div>

            <input type="hidden" name="store_profile" id="storeProfileInput" value="0">
            <button type="submit" id="searchSubmitBtn"
                class="w-full bg-primary hover:bg-primary-hover text-white font-black uppercase tracking-widest text-xs py-4 px-4 rounded-xl transition-all flex items-center justify-center gap-2 sticky bottom-0 z-10 shadow-xl shadow-primary/20">
                <span>Find Universities</span>
                <span class="material-symbols-outlined text-sm">auto_awesome</span>
            </button>
        </form>

        <!-- Personal Details Confirmation Modal -->
        <div id="consentModal" class="hidden fixed inset-0 z-[200] items-center justify-center p-4 bg-black/60 backdrop-blur-sm">
            <div class="bg-white dark:bg-surface-dark p-8 rounded-2xl max-w-sm w-full shadow-2xl animate-in zoom-in-95 duration-200">
                <div class="size-16 bg-primary/10 text-primary rounded-full flex items-center justify-center mb-6 mx-auto">
                    <span class="material-symbols-outlined text-3xl">account_circle</span>
                </div>
                <h3 class="text-xl font-black text-center mb-3">Save Search Profile?</h3>
                <p class="text-sm text-text-muted text-center mb-8 leading-relaxed">Is this your personal academic data? If you confirm, we will save this to your profile to provide better AI recommendations in the future.</p>
                <div class="flex flex-col gap-3">
                    <button type="button" onclick="confirmSearch(true)" 
                        class="w-full bg-primary text-white font-bold py-4 rounded-xl hover:bg-primary-hover transition-all shadow-lg shadow-primary/20">
                        Yes, save and search
                    </button>
                    <button type="button" onclick="confirmSearch(false)" 
                        class="w-full bg-background-light dark:bg-gray-800 text-text-main dark:text-white font-bold py-3.5 rounded-xl border border-border-light dark:border-border-dark hover:bg-gray-50 transition-all">
                        No, just search once
                    </button>
                </div>
            </div>
        </div>

        <script>
            const searchForm = document.getElementById('searchForm');
            const consentModal = document.getElementById('consentModal');
            const storeProfileInput = document.getElementById('storeProfileInput');
            const isRegistered = <?= session()->get('isLoggedIn') ? 'true' : 'false' ?>;

            searchForm.addEventListener('submit', function(e) {
                // Only show popup if academic data is filled and user is registered
                const hasAcademicData = searchForm.querySelector('[name="academic_data"]').value || searchForm.querySelector('[name="ielts"]').value;
                
                if (isRegistered && hasAcademicData && storeProfileInput.value === '0') {
                    e.preventDefault();
                    consentModal.classList.remove('hidden');
                    consentModal.classList.add('flex');
                }
            });

            function confirmSearch(save) {
                storeProfileInput.value = save ? '1' : '0';
                consentModal.classList.add('hidden');
                consentModal.classList.remove('flex');
                searchForm.submit();
            }

            async function toggleCompare(e, type, id) {
                e.preventDefault();
                e.stopPropagation();
                try {
                    const response = await fetch('<?= base_url('comparison/toggle') ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
                        },
                        body: `type=${type}&id=${id}`
                    });
                    const data = await response.json();
                    if (response.ok) {
                        // Show a simple notification or just redirect
                        if (confirm(data.message + ' View comparison?')) {
                            window.location.href = type === 'university' ? '<?= base_url('compare-universities') ?>' : '<?= base_url('compare-courses') ?>';
                        }
                    } else {
                        alert(data.message || 'Error updating comparison');
                    }
                } catch (error) {
                    console.error(error);
                }
            }
        </script>
        <!-- Main Content -->
        <main class="flex-1 w-full">
            <!-- Results Header -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                <h1 class="text-2xl font-bold text-text-main dark:text-white">Showing <?= $pager->getTotal() ?> Universities</h1>
                <div class="flex items-center gap-3">
                    <span class="text-sm text-text-muted whitespace-nowrap">Sort by:</span>
                    <form id="sortForm" action="" method="get" class="relative inline-block text-left w-40">
                        <!-- Preserve other filters -->
                        <?php foreach (service('request')->getGet() as $key => $value): ?>
                                    <?php if ($key !== 'sort' && !is_array($value)): ?>
                                                <input type="hidden" name="<?= esc($key) ?>" value="<?= esc($value) ?>">
                                    <?php elseif ($key !== 'sort' && is_array($value)): ?>
                                                <?php foreach ($value as $v): ?>
                                                            <input type="hidden" name="<?= esc($key) ?>[]" value="<?= esc($v) ?>">
                                                <?php endforeach; ?>
                                    <?php endif; ?>
                        <?php endforeach; ?>
                        
                        <select name="sort" onchange="document.getElementById('sortForm').submit()"
                            class="w-full pl-3 pr-8 py-2 text-sm font-medium bg-surface-light dark:bg-surface-dark border-none shadow-soft rounded-lg appearance-none focus:ring-0 cursor-pointer">
                            <option value="ranking_asc" <?= service('request')->getGet('sort') == 'ranking_asc' ? 'selected' : '' ?>>Ranking (High to Low)</option>
                            <option value="tuition_asc" <?= service('request')->getGet('sort') == 'tuition_asc' ? 'selected' : '' ?>>Tuition (Low to High)</option>
                            <option value="name_asc" <?= service('request')->getGet('sort') == 'name_asc' ? 'selected' : '' ?>>Name (A-Z)</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none text-text-muted">
                            <span class="material-symbols-outlined text-lg">sort</span>
                        </div>
                    </form>
                </div>
            </div>
            <!-- University Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                <?php if (!empty($universities)): ?>
                            <?php foreach ($universities as $uni): ?>
                                        <div
                                            class="group bg-surface-light dark:bg-surface-dark rounded-xl border border-border-light dark:border-border-dark overflow-hidden shadow-soft hover:shadow-soft-hover transition-all duration-300 flex flex-col h-full relative">
                                            <!-- Image Container -->
                                            <div class="relative h-48 w-full overflow-hidden">
                                                <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-105"
                                                    style="background-image: url('<?= !empty($uni['gallery_image']) ? base_url($uni['gallery_image']) : (isset($uni['main_image_path']) ? base_url($uni['main_image_path']) : 'https://placehold.co/600x400?text=' . urlencode($uni['name'])) ?>');">
                                                </div>
                                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                                
                                                <!-- AI Match Badge -->
                                                <?php if (isset($ai_names) && in_array($uni['name'], $ai_names)): ?>
                                                    <div class="absolute top-3 left-3 bg-primary text-white text-[10px] font-bold px-2 py-1 rounded-full z-20 flex items-center gap-1 shadow-lg animate-pulse">
                                                        <span class="material-symbols-outlined text-[12px]">auto_awesome</span>
                                                        AI MATCH
                                                    </div>
                                                <?php endif; ?>

                                                <!-- Save Button -->
                                                <?php /* Bookmark button removed as per request */ ?>
                                                <button onclick="toggleCompare(event, 'university', <?= $uni['id'] ?>)" 
                                                    class="absolute top-3 right-3 z-20 size-10 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white flex items-center justify-center hover:bg-primary transition-all group/comp"
                                                    title="Add to Compare">
                                                    <span class="material-symbols-outlined text-[20px] group-hover/comp:scale-110 transition-transform">compare_arrows</span>
                                                </button>
                                                <!-- Ranking Badge -->
                                                <?php if ($uni['ranking']): ?>
                                                            <div
                                                                class="absolute bottom-3 <?= (isset($ai_names) && in_array($uni['name'], $ai_names)) ? 'right-3' : 'left-3' ?> bg-secondary text-surface-dark text-xs font-bold px-3 py-1 rounded-full flex items-center gap-1 shadow-sm">
                                                                <span class="material-symbols-outlined text-sm">trophy</span>
                                                                #<?= $uni['ranking'] ?> World Rank
                                                            </div>
                                                <?php endif; ?>
                                            </div>
                                            <!-- Card Content -->
                                            <div class="p-5 flex-1 flex flex-col">
                                                <div class="flex items-start justify-between mb-2">
                                                    <div>
                                                        <?php 
                                                            $nameLen = strlen($uni['name']);
                                                            if ($nameLen >= 45) {
                                                                $fontSize = 'text-xs';
                                                            } elseif ($nameLen >= 25) {
                                                                $fontSize = 'text-sm';
                                                            } else {
                                                                $fontSize = 'text-base';
                                                            }
                                                        ?>
                                                        <h3
                                                            class="font-bold <?= $fontSize ?> leading-tight mb-1 text-text-main dark:text-white line-clamp-1">
                                                            <?= esc($uni['name']) ?>
                                                        </h3>
                                                        <div class="flex items-center text-text-muted text-sm gap-1">
                                                            <span class="material-symbols-outlined text-sm">location_on</span>
                                                            <?= esc($uni['country_name']) ?>
                                                        </div>
                                                    </div>
                                                <div
                                                    class="size-10 bg-white rounded-lg p-1 shadow-sm border border-gray-100 flex items-center justify-center shrink-0 -mt-10 z-10 relative">
                                                    <img src="<?= isset($uni['main_image_path']) ? base_url($uni['main_image_path']) : (isset($uni['logo_path']) ? base_url($uni['logo_path']) : base_url('favicon_io/android-chrome-512x512.webp')) ?>"
                                                        class="w-full h-full object-contain" alt="Logo">
                                                </div>
                                                </div>
                                                <hr class="border-border-light dark:border-border-dark my-4 border-dashed" />
                                                <div class="grid grid-cols-2 gap-y-3 gap-x-2 mb-6">
                                                    <div class="flex items-center gap-2">
                                                        <div class="p-1.5 rounded bg-primary/10 text-primary">
                                                            <span class="material-symbols-outlined text-sm block">payments</span>
                                                        </div>
                                                        <div class="flex flex-col">
                                                            <span
                                                                class="text-[10px] uppercase font-bold text-text-muted tracking-wider">Tuition</span>
                                                            <span
                                                                class="text-xs font-semibold text-text-main dark:text-gray-200"><?= $uni['tuition_fee_min'] ? '$' . number_format($uni['tuition_fee_min'] / 1000, 0) . 'k' : 'N/A' ?>/yr</span>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center gap-2">
                                                        <div class="p-1.5 rounded bg-primary/10 text-primary">
                                                            <span class="material-symbols-outlined text-sm block">school</span>
                                                        </div>
                                                        <div class="flex flex-col">
                                                            <span
                                                                class="text-[10px] uppercase font-bold text-text-muted tracking-wider">Type</span>
                                                            <span
                                                                class="text-xs font-semibold text-text-main dark:text-gray-200"><?= ucfirst(esc($uni['type'])) ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mt-auto">
                                                    <a class="block w-full text-center py-2.5 rounded-lg border border-border-light dark:border-border-dark hover:border-primary hover:text-primary text-sm font-semibold transition-all dark:text-gray-300 dark:hover:text-primary"
                                                        href="<?= base_url('universities/' . ($uni['country_slug'] ?? url_title($uni['country_name'], '-', true)) . '/' . ($uni['slug'] ?? url_title($uni['name'], '-', true))) ?>">
                                                        View Details
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                            <?php endforeach; ?>
                <?php else: ?>
                            <div
                                class="col-span-full py-12 text-center bg-surface-light dark:bg-surface-dark rounded-xl border border-border-light dark:border-border-dark">
                                <span class="material-symbols-outlined text-6xl text-text-muted mb-4">search_off</span>
                                <h3 class="text-xl font-bold mb-2">No Universities Found</h3>
                                <p class="text-text-muted">Try adjusting your filters or search terms.</p>
                            </div>
                <?php endif; ?>
            </div>
            <!-- Pagination -->
            <div class="flex justify-center mt-12 gap-2">
                <?= $pager->links('default', 'tailwind_full') ?>
            </div>
        </main>
    </div>
</div>
<!-- Footer -->

<?= view('web/include/footer') ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const countryInput = document.getElementById('countrySearchInput');
        const countryList = document.getElementById('countryList');
        
        if (countryInput && countryList) {
            countryInput.addEventListener('keyup', function() {
                const filter = this.value.toLowerCase();
                const items = countryList.querySelectorAll('.country-item');
                
                items.forEach(function(item) {
                    const text = item.querySelector('.country-name').textContent.toLowerCase();
                    if (text.includes(filter)) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        }
    });
</script>