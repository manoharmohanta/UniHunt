<?= view('user/include/header', ['title' => 'My Activities | UniHunt', 'activePage' => 'dashboard']) ?>

<!-- Main Content Area -->
<main class="flex-1 flex flex-col h-full overflow-hidden relative bg-slate-50 dark:bg-[#0f1115]">
    <!-- Header Section -->
    <header
        class="flex-shrink-0 px-8 py-6 bg-white dark:bg-[#15191e] border-b border-slate-200 dark:border-slate-800 z-10">
        <div class="flex flex-col gap-6">
            <!-- Top Row: Breadcrumbs & Search -->
            <div class="flex justify-between items-center gap-4">
                <div class="hidden md:flex text-sm text-slate-500 font-medium">
                    <span>Dashboard</span>
                    <span class="mx-2">/</span>
                    <span class="text-slate-900 dark:text-white">AI History</span>
                </div>
            </div>
            <!-- Main Heading & Actions -->
            <div class="flex flex-wrap justify-between items-end gap-4">
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight mb-1">My AI
                        Activities</h1>
                    <p class="text-slate-500 dark:text-slate-400 text-base">Track your generated documents, mock tests,
                        and research history.</p>
                </div>
                <div class="flex gap-3">
                    <a href="<?= base_url('profile') ?>"
                        class="flex items-center gap-2 px-5 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 rounded-lg text-slate-700 dark:text-white text-sm font-bold shadow-sm transition-all active:scale-95">
                        <span class="material-symbols-outlined text-[20px]">person</span>
                        Profile
                    </a>
                    <a href="<?= base_url('ai-tools') ?>"
                        class="flex items-center gap-2 px-5 py-2.5 bg-primary hover:bg-primary-hover rounded-lg text-white text-sm font-bold shadow-lg shadow-primary/25 transition-all active:scale-95">
                        <span class="material-symbols-outlined text-[20px]">add</span>
                        New Activity
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Scrollable Content -->
    <div class="flex-1 overflow-y-auto p-8 custom-scrollbar space-y-12">

        <!-- 1. AI Documents Section -->
        <section>
            <div class="flex items-center gap-4 mb-6">
                <div
                    class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center">
                    <span class="material-symbols-outlined text-2xl">description</span>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white">Generated Documents</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400">SOPs, LORs, and Resumes you have created.</p>
                </div>
            </div>

            <?php if (empty($documents)): ?>
                <div
                    class="bg-white dark:bg-[#1b2028] p-8 rounded-xl border border-slate-200 dark:border-slate-800 text-center">
                    <p class="text-slate-500 dark:text-slate-400 mb-4">No documents generated yet.</p>
                    <a href="<?= base_url('ai-tools') ?>" class="text-primary font-medium hover:underline">Start creating
                        now</a>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    <?php foreach ($documents as $doc): ?>
                        <div
                            class="group bg-white dark:bg-[#1b2028] p-5 rounded-xl border border-slate-200 dark:border-slate-800 hover:border-primary/50 hover:shadow-lg transition-all flex flex-col h-full">
                            <div class="flex items-start justify-between mb-4">
                                <span class="px-2.5 py-1 rounded-md text-xs font-bold uppercase tracking-wide
                                    <?php
                                    switch ($doc['type']) {
                                        case 'SOP':
                                            echo 'bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400';
                                            break;
                                        case 'LOR':
                                            echo 'bg-orange-100 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400';
                                            break;
                                        case 'RESUME':
                                            echo 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400';
                                            break;
                                        default:
                                            echo 'bg-slate-100 dark:bg-slate-800 text-slate-600';
                                    }
                                    ?>">
                                    <?= $doc['type'] ?>
                                </span>
                                <span class="text-xs text-slate-400"><?= date('M d, Y', strtotime($doc['created_at'])) ?></span>
                            </div>
                            <h3 class="text-base font-bold text-slate-900 dark:text-white mb-2 line-clamp-2">
                                <?= esc($doc['title']) ?: 'Untitled Document' ?>
                            </h3>
                            <?php $meta = json_decode($doc['metadata'], true); ?>
                            <div class="text-sm text-slate-500 dark:text-slate-400 mb-4 flex-1">
                                <?php if ($doc['type'] == 'SOP'): ?>
                                    For <?= $meta['university'] ?? 'University' ?>
                                <?php elseif ($doc['type'] == 'LOR'): ?>
                                    By <?= $meta['recommender'] ?? 'Recommender' ?>
                                <?php elseif ($doc['type'] == 'RESUME'): ?>
                                    Template <?= $meta['template'] ?? '1' ?>
                                <?php endif; ?>
                            </div>
                            <div class="mt-auto pt-4 border-t border-slate-100 dark:border-slate-800 flex gap-2">
                                <a href="<?= base_url('ai-tools/document/' . $doc['id']) ?>" target="_blank"
                                    class="flex-1 py-2 bg-slate-50 dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-lg text-sm font-medium text-slate-700 dark:text-slate-300 transition-colors text-center">
                                    View
                                </a>
                                <!-- In a real app, adding download functionality would require a specific route -->
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <!-- 1b. Saved Courses Section -->
            <section id="saved-courses">
                <div class="flex items-center gap-4 mb-6">
                    <div
                        class="w-10 h-10 rounded-xl bg-orange-100 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400 flex items-center justify-center">
                        <span class="material-symbols-outlined text-2xl">bookmark</span>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-slate-900 dark:text-white">Saved Courses</h2>
                        <p class="text-sm text-slate-500 dark:text-slate-400">Courses you have bookmarked for later.</p>
                    </div>
                </div>

                <?php if (empty($bookmarks)): ?>
                    <div
                        class="bg-white dark:bg-[#1b2028] p-8 rounded-xl border border-slate-200 dark:border-slate-800 text-center">
                        <p class="text-slate-500 dark:text-slate-400 mb-4">No courses saved yet.</p>
                        <a href="<?= base_url('universities') ?>" class="text-primary font-medium hover:underline">Explore
                            universities</a>
                    </div>
                <?php else: ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        <?php foreach ($bookmarks as $bookmark): ?>
                            <div
                                class="group bg-white dark:bg-[#1b2028] p-5 rounded-xl border border-slate-200 dark:border-slate-800 hover:border-primary/50 hover:shadow-lg transition-all flex flex-col h-full relative">
                                <div class="flex items-start justify-between mb-4">
                                    <span
                                        class="px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wide bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400">
                                        COURSE
                                    </span>
                                    <button onclick="toggleBookmark(this, 'course', <?= $bookmark['entity_id'] ?>)"
                                        class="text-secondary">
                                        <span class="material-symbols-outlined text-[20px]"
                                            style="font-variation-settings: 'FILL' 1">bookmark</span>
                                    </button>
                                </div>
                                <h3 class="text-base font-bold text-slate-900 dark:text-white mb-1 line-clamp-2">
                                    <?= esc($bookmark['course_name']) ?>
                                </h3>
                                <p class="text-sm text-slate-500 dark:text-slate-400 mb-4 line-clamp-1">
                                    <?= esc($bookmark['university_name']) ?>
                                </p>
                                <div class="mt-auto pt-4 border-t border-slate-100 dark:border-slate-800">
                                    <a href="<?= base_url('course/' . $bookmark['country_slug'] . '/' . $bookmark['uni_slug'] . '/' . url_title($bookmark['course_name'], '-', true)) ?>"
                                        class="block w-full py-2 bg-primary/10 hover:bg-primary/20 rounded-lg text-sm font-bold text-primary transition-colors text-center">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>

        </section>

        <!-- Ad Slot: Dashboard Main (Native/Banner) -->
        <div class="uni-ad-slot" data-placement="dashboard_main"></div>

        <!-- 2. Mock Assessments Section -->
        <section>
            <div class="flex items-center gap-4 mb-6">
                <div
                    class="w-10 h-10 rounded-xl bg-pink-100 dark:bg-pink-900/30 text-pink-600 dark:text-pink-400 flex items-center justify-center">
                    <span class="material-symbols-outlined text-2xl">mic</span>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white">Mock Assessments</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Visa Interviews and Standardized Tests.</p>
                </div>
            </div>

            <?php if (empty($interviews) && empty($mockTests)): ?>
                <div
                    class="bg-white dark:bg-[#1b2028] p-8 rounded-xl border border-slate-200 dark:border-slate-800 text-center">
                    <p class="text-slate-500 dark:text-slate-400 mb-4">No assessments taken yet.</p>
                    <a href="<?= base_url('ai-tools/mock-interview') ?>"
                        class="text-primary font-medium hover:underline">Start an Interview</a>
                </div>
            <?php else: ?>
                <div class="space-y-6">
                    <!-- Visa Interviews -->
                    <?php if (!empty($interviews)): ?>
                        <h3 class="text-sm font-bold text-slate-500 uppercase tracking-widest">Visa Mock Interviews</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <?php foreach ($interviews as $interview): ?>
                                <div
                                    class="bg-white dark:bg-[#1b2028] p-5 rounded-xl border border-slate-200 dark:border-slate-800 flex flex-col">
                                    <div class="flex justify-between items-start mb-4">
                                        <div>
                                            <h4 class="font-bold text-slate-900 dark:text-white text-lg">
                                                <?= $interview['country'] ?> Visa
                                            </h4>
                                            <span class="text-xs text-slate-500"><?= $interview['visa_type'] ?></span>
                                        </div>
                                        <div class="bg-slate-100 dark:bg-slate-800 rounded-lg px-2 py-1 flex items-center gap-1">
                                            <span class="material-symbols-outlined text-yellow-500 text-sm">star</span>
                                            <span
                                                class="font-bold text-slate-700 dark:text-white"><?= $interview['score'] ?>/100</span>
                                        </div>
                                    </div>
                                    <div class="mt-auto">
                                        <span class="text-xs text-slate-400 block mb-3">Taken on
                                            <?= date('M d, Y', strtotime($interview['created_at'])) ?></span>
                                        <a href="<?= base_url('ai-tools/mock-interview-view/' . $interview['id']) ?>"
                                            class="block w-full text-center py-2 border border-slate-200 dark:border-slate-700 rounded-lg text-sm font-medium hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                                            View Report
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Standardized Tests -->
                    <?php if (!empty($mockTests)): ?>
                        <h3 class="text-sm font-bold text-slate-500 uppercase tracking-widest mt-8">Standardized Tests (IELTS,
                            PTE, etc.)</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <?php foreach ($mockTests as $test): ?>
                                <?php
                                $summary = json_decode($test['score_summary'], true);
                                $scoreDisplay = $summary['total_score'] ?? 'N/A';
                                ?>
                                <div
                                    class="bg-white dark:bg-[#1b2028] p-5 rounded-xl border border-slate-200 dark:border-slate-800 flex flex-col">
                                    <div class="flex justify-between items-start mb-4">
                                        <div>
                                            <h4 class="font-bold text-slate-900 dark:text-white text-lg uppercase">
                                                <?= $test['test_type'] ?>
                                            </h4>
                                            <span class="text-xs text-slate-500">Mock Test</span>
                                        </div>
                                        <div class="bg-slate-100 dark:bg-slate-800 rounded-lg px-2 py-1 flex items-center gap-1">
                                            <span class="material-symbols-outlined text-blue-500 text-sm">bar_chart</span>
                                            <span class="font-bold text-slate-700 dark:text-white"><?= $scoreDisplay ?></span>
                                        </div>
                                    </div>
                                    <div class="mt-auto">
                                        <span class="text-xs text-slate-400 block mb-3">Taken on
                                            <?= date('M d, Y', strtotime($test['created_at'])) ?></span>
                                        <a href="<?= base_url('ai-tools/mock-result/' . $test['id']) ?>"
                                            class="block text-center w-full py-2 border border-slate-200 dark:border-slate-700 rounded-lg text-sm font-medium hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                                            View Detailed Report
                                        </a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </section>

        <!-- 3. Transaction History Section -->
        <section>
            <div class="flex items-center gap-4 mb-6">
                <div
                    class="w-10 h-10 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 flex items-center justify-center">
                    <span class="material-symbols-outlined text-2xl">payments</span>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white">Transaction History</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Manage your payments and receipts.</p>
                </div>
            </div>

            <?php if (empty($payments)): ?>
                <div
                    class="bg-white dark:bg-[#1b2028] p-8 rounded-xl border border-slate-200 dark:border-slate-800 text-center">
                    <p class="text-slate-500 dark:text-slate-400">No payment history found.</p>
                </div>
            <?php else: ?>
                <div
                    class="bg-white dark:bg-[#1b2028] rounded-xl border border-slate-200 dark:border-slate-800 overflow-hidden">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-700">
                            <tr>
                                <th class="px-6 py-4 font-semibold text-slate-600 dark:text-slate-300">Service</th>
                                <th class="px-6 py-4 font-semibold text-slate-600 dark:text-slate-300">Amount</th>
                                <th class="px-6 py-4 font-semibold text-slate-600 dark:text-slate-300">Status</th>
                                <th class="px-6 py-4 font-semibold text-slate-600 dark:text-slate-300">Date</th>
                                <th class="px-6 py-4 font-semibold text-slate-600 dark:text-slate-300 text-right">
                                    Transaction ID</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            <?php foreach ($payments as $payment): ?>
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-slate-800 dark:text-white">
                                            <?= esc($payment['tool_name']) ?>
                                        </div>
                                        <?php if ($payment['coupon_code']): ?>
                                            <div class="text-[10px] text-primary uppercase font-bold">Coupon:
                                                <?= esc($payment['coupon_code']) ?>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 text-slate-600 dark:text-slate-300 font-bold">
                                        ₹<?= number_format($payment['final_amount'], 2) ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 rounded text-[10px] font-bold uppercase
                                            <?php
                                            switch ($payment['payment_status']) {
                                                case 'paid':
                                                    echo 'bg-green-100 text-green-600 dark:bg-green-900/30 dark:text-green-400';
                                                    break;
                                                case 'waived':
                                                    echo 'bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400';
                                                    break;
                                                default:
                                                    echo 'bg-amber-100 text-amber-600 dark:bg-amber-900/30 dark:text-amber-400';
                                            }
                                            ?>">
                                            <?= $payment['payment_status'] ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-slate-500">
                                        <?= date('M d, Y', strtotime($payment['created_at'])) ?>
                                    </td>
                                    <td class="px-6 py-4 text-right text-xs font-mono text-slate-400">
                                        <?= $payment['razorpay_payment_id'] ?: $payment['razorpay_order_id'] ?: 'N/A' ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </section>

        <!-- 4. Research History Section -->
        <section class="pb-10">
            <div class="flex items-center gap-4 mb-6">
                <div
                    class="w-10 h-10 rounded-xl bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 flex items-center justify-center">
                    <span class="material-symbols-outlined text-2xl">travel_explore</span>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-slate-900 dark:text-white">Research History</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Visa Requirements and Career Predictions.</p>
                </div>
            </div>

            <?php if (empty($searches)): ?>
                <div
                    class="bg-white dark:bg-[#1b2028] p-8 rounded-xl border border-slate-200 dark:border-slate-800 text-center">
                    <p class="text-slate-500 dark:text-slate-400">No research history found.</p>
                </div>
            <?php else: ?>
                <div
                    class="bg-white dark:bg-[#1b2028] rounded-xl border border-slate-200 dark:border-slate-800 overflow-hidden">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-100 dark:border-slate-700">
                            <tr>
                                <th class="px-6 py-4 font-semibold text-slate-600 dark:text-slate-300">Tool</th>
                                <th class="px-6 py-4 font-semibold text-slate-600 dark:text-slate-300">Details</th>
                                <th class="px-6 py-4 font-semibold text-slate-600 dark:text-slate-300 text-right">Date</th>
                                <th class="px-6 py-4 font-semibold text-slate-600 dark:text-slate-300 text-right">Action
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                            <?php foreach ($searches as $search): ?>
                                <?php $params = json_decode($search['search_params'], true); ?>
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/30 transition-colors">
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center gap-2 font-medium text-slate-800 dark:text-white">
                                            <?php if ($search['tool_type'] == 'VISA_CHECKER'): ?>
                                                <span class="material-symbols-outlined text-blue-500">public</span> Visa Checker
                                            <?php else: ?>
                                                <span class="material-symbols-outlined text-purple-500">work</span> Career Predictor
                                            <?php endif; ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-slate-600 dark:text-slate-300">
                                        <?php if ($search['tool_type'] == 'VISA_CHECKER'): ?>
                                            <?= $params['country'] ?> (<?= $params['visa_type'] ?>)
                                        <?php else: ?>
                                            <?= $params['course'] ?> in <?= $params['home_country'] ?>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 text-right text-slate-500">
                                        <?= date('M d, Y', strtotime($search['created_at'])) ?>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <?php if ($search['tool_type'] == 'VISA_CHECKER'): ?>
                                            <a href="<?= base_url('ai-tools/visa-checker-view/' . ($search['result_id'] ?? 0)) ?>"
                                                class="text-primary hover:text-primary-hover font-medium text-xs">View Again</a>
                                        <?php else: ?>
                                            <a href="<?= base_url('ai-tools/career-predictor-view/' . ($search['result_id'] ?? 0)) ?>"
                                                class="text-primary hover:text-primary-hover font-medium text-xs">View Again</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </section>

    </div>
</main>

<script>
    async function toggleBookmark(btn, type, id) {
        const iconSpan = btn.querySelector('span');
        const originalIcon = iconSpan.innerText;

        // Optimistic UI update
        // On dashboard, if we have bookmark, it's always 'bookmark' initially
        const isCurrentlyBookmarked = iconSpan.innerText === 'bookmark';
        iconSpan.innerText = isCurrentlyBookmarked ? 'bookmark_border' : 'bookmark';

        if (!isCurrentlyBookmarked) {
            btn.classList.add('text-secondary');
            btn.classList.remove('text-[#677583]');
            iconSpan.style.fontVariationSettings = "'FILL' 1";
        } else {
            btn.classList.remove('text-secondary');
            btn.classList.add('text-[#677583]');
            iconSpan.style.fontVariationSettings = "'FILL' 0";
        }

        try {
            const response = await fetch('<?= base_url('bookmark/toggle') ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': '<?= csrf_hash() ?>'
                },
                body: `entity_type=${type}&entity_id=${id}`
            });

            const data = await response.json();

            if (!response.ok) {
                if (response.status === 401) {
                    window.location.href = '<?= base_url('login') ?>';
                    return;
                }
                throw new Error(data.message || 'Error toggling bookmark');
            }

            // Sync with server response just in case
            if (data.icon) {
                iconSpan.innerText = data.icon;
            }

            // If removed, we could hide the card, but let's just toggle icon for now
            // Or simple refresh after a delay
            if (data.status === 'removed') {
                // btn.closest('.group').style.opacity = '0.5';
            }

        } catch (error) {
            console.error(error);
            // Revert on error
            iconSpan.innerText = originalIcon;
            alert('Failed to update bookmark. Please try again.');
        }
    }
</script>

<?= view('user/include/footer') ?>