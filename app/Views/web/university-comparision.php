<?= view('web/include/header', [
    'title' => 'University Comparison Tool | UniHunt',
    'bodyClass' => 'bg-background-light dark:bg-background-dark font-display text-text-main dark:text-gray-100 overflow-x-hidden min-h-screen flex flex-col'
]) ?>

<div class="flex-1 flex flex-col max-w-[1400px] mx-auto w-full px-4 md:px-10 pb-20">
    <!-- Breadcrumbs -->
    <div class="flex flex-wrap gap-2 py-6">
        <a class="text-text-muted text-sm font-medium leading-normal hover:underline" href="<?= base_url() ?>">Home</a>
        <span class="text-text-muted text-sm font-medium leading-normal">/</span>
        <a class="text-text-muted text-sm font-medium leading-normal hover:underline"
            href="<?= base_url('universities') ?>">Universities</a>
        <span class="text-text-muted text-sm font-medium leading-normal">/</span>
        <span class="text-primary dark:text-white text-sm font-bold leading-normal">Compare</span>
    </div>

    <!-- Page Controls & Heading -->
    <div class="flex flex-col xl:flex-row xl:items-end justify-between gap-6 mb-10">
        <div class="flex flex-col gap-3">
            <div
                class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary/10 text-primary text-xs font-bold uppercase tracking-wider w-max">
                <span class="material-symbols-outlined text-[16px]">compare_arrows</span>
                Comparison Tool
            </div>
            <h1 class="text-text-main dark:text-white text-3xl md:text-5xl font-black leading-tight tracking-tight">
                University Comparison
            </h1>
            <p class="text-text-muted dark:text-gray-400 text-lg font-medium leading-relaxed max-w-2xl">
                Make an informed decision by analyzing key metrics side-by-side. Add up to 3 universities for
                comparison.
            </p>
        </div>
        <div class="flex flex-wrap items-center gap-4">
            <a href="<?= base_url('comparison/clear?type=university') ?>"
                class="group flex items-center justify-center rounded-xl h-12 px-6 bg-white border border-gray-200 hover:border-danger hover:bg-danger/5 text-text-muted hover:text-danger gap-2 text-sm font-bold transition-all dark:bg-card-dark dark:border-gray-800 shadow-sm">
                <span
                    class="material-symbols-outlined text-[22px] group-hover:rotate-12 transition-transform">delete</span>
                Clear Comparison
            </a>
        </div>
    </div>

    <?php if (empty($universities)): ?>
        <div
            class="bg-white dark:bg-card-dark p-12 md:p-24 rounded-3xl border-2 border-dashed border-gray-200 dark:border-gray-800 text-center flex flex-col items-center">
            <div
                class="size-24 bg-primary/5 text-primary rounded-3xl flex items-center justify-center mb-8 rotate-3 shadow-inner">
                <span class="material-symbols-outlined text-5xl">balance</span>
            </div>
            <h3 class="text-2xl font-black text-text-main dark:text-white mb-3">Your comparison list is empty</h3>
            <p class="text-text-muted dark:text-gray-400 mb-10 max-w-sm mx-auto text-lg">
                Add up to 3 universities from the search results to see them side-by-side.
            </p>
            <a href="<?= base_url('universities') ?>"
                class="inline-flex items-center gap-3 px-10 py-4 bg-primary text-white rounded-2xl font-bold hover:bg-primary-hover transition-all shadow-xl shadow-primary/20 hover:-translate-y-1">
                Explore Universities
                <span class="material-symbols-outlined">arrow_forward</span>
            </a>
        </div>
    <?php else:
        // Logic to find best values
        $minRank = 999999;
        $minTuition = 999999999;
        foreach ($universities as $u) {
            if ($u['ranking'] && $u['ranking'] < $minRank)
                $minRank = $u['ranking'];
            if ($u['tuition_fee_min'] && $u['tuition_fee_min'] < $minTuition)
                $minTuition = $u['tuition_fee_min'];
        }
        $gridStyle = "grid-template-columns: 240px repeat(3, 320px);";
        ?>
        <!-- Comparison Table Container -->
        <div
            class="bg-white dark:bg-card-dark rounded-3xl border border-gray-100 dark:border-gray-800 shadow-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <div class="min-w-max">
                    <!-- Sticky Header Row -->
                    <div class="grid border-b border-gray-100 dark:border-gray-800" style="<?= $gridStyle ?>">
                        <!-- Label Column Header -->
                        <div class="p-8 flex items-end pb-8 bg-gray-50/50 dark:bg-gray-900/40">
                            <span class="text-xs font-black text-text-muted uppercase tracking-[0.2em]">University
                                Matrix</span>
                        </div>

                        <?php foreach ($universities as $uni): ?>
                            <!-- Uni Header -->
                            <div
                                class="relative p-8 border-l border-gray-100 dark:border-gray-800 flex flex-col gap-6 group hover:bg-gray-50/30 dark:hover:bg-gray-800/10 transition-colors">
                                <button onclick="removeFromCompare('university', <?= $uni['id'] ?>)"
                                    class="absolute top-4 right-4 size-8 flex items-center justify-center rounded-full text-gray-400 hover:text-danger hover:bg-danger/10 transition-all opacity-0 group-hover:opacity-100">
                                    <span class="material-symbols-outlined text-[20px]">close</span>
                                </button>

                                <div class="flex flex-col items-center text-center gap-5">
                                    <div
                                        class="size-20 rounded-2xl bg-white dark:bg-gray-800 flex items-center justify-center p-3 border border-gray-100 dark:border-gray-700 shadow-xl group-hover:scale-110 transition-transform">
                                        <img class="w-full h-full object-contain"
                                            src="<?= $uni['logo_path'] ? base_url($uni['logo_path']) : base_url('favicon_io/android-chrome-512x512.webp') ?>" />
                                    </div>
                                    <div>
                                        <h3
                                            class="font-black text-xl text-text-main dark:text-white leading-tight line-clamp-2 h-14">
                                            <?= esc($uni['name']) ?></h3>
                                        <div
                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-gray-100 dark:bg-gray-800 text-text-muted text-xs font-bold mt-2">
                                            <span class="material-symbols-outlined text-[16px] text-primary">location_on</span>
                                            <?= esc($uni['country_name']) ?>
                                        </div>
                                    </div>
                                </div>
                                <a href="<?= base_url('universities/' . $uni['country_slug'] . '/' . $uni['slug']) ?>"
                                    class="w-full py-4 rounded-xl bg-primary hover:bg-primary-hover text-white text-sm font-bold shadow-lg shadow-primary/20 transition-all flex items-center justify-center gap-2 group/btn">
                                    Profile details
                                    <span
                                        class="material-symbols-outlined text-[18px] transition-transform group-hover/btn:translate-x-1">arrow_forward</span>
                                </a>
                            </div>
                        <?php endforeach; ?>

                        <?php for ($i = count($universities); $i < 3; $i++): ?>
                            <!-- Add Uni Header -->
                            <div class="p-8 border-l border-gray-100 dark:border-gray-800 flex flex-col justify-center h-full">
                                <a href="<?= base_url('universities') ?>"
                                    class="h-full min-h-[160px] rounded-2xl border-2 border-dashed border-gray-200 hover:border-primary/50 hover:bg-primary/5 dark:border-gray-700 dark:hover:border-primary/50 transition-all flex flex-col items-center justify-center gap-4 group text-text-muted">
                                    <div
                                        class="size-14 rounded-full bg-gray-50 dark:bg-gray-800 group-hover:bg-primary group-hover:text-white flex items-center justify-center transition-all shadow-sm">
                                        <span class="material-symbols-outlined text-3xl">add_circle</span>
                                    </div>
                                    <div class="text-center">
                                        <span class="block text-sm font-bold group-hover:text-primary">Add university</span>
                                        <span
                                            class="block text-[10px] font-medium opacity-60 mt-1 uppercase tracking-wider">Slot
                                            Available</span>
                                    </div>
                                </a>
                            </div>
                        <?php endfor; ?>
                    </div>

                    <!-- Category: Rankings -->
                    <div class="grid bg-gray-50/50 dark:bg-gray-900/50 border-b border-gray-100 dark:border-gray-800"
                        style="<?= $gridStyle ?>">
                        <div class="p-5 px-8 flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary text-[24px]">trending_up</span>
                            <span class="text-xs font-black text-text-muted uppercase tracking-[0.1em]">Rankings &
                                Standing</span>
                        </div>
                        <div class="border-l border-gray-100 dark:border-gray-800"></div>
                        <div class="border-l border-gray-100 dark:border-gray-800"></div>
                        <div class="border-l border-gray-100 dark:border-gray-800"></div>
                    </div>

                    <!-- Row: World Ranking -->
                    <div class="grid border-b border-gray-100 dark:border-gray-800 group/row hover:bg-gray-50/50 dark:hover:bg-gray-800/10 transition-all"
                        style="<?= $gridStyle ?>">
                        <div class="p-8 px-10 text-sm font-bold text-text-main dark:text-gray-300 flex items-center">
                            QS World Ranking
                        </div>
                        <?php foreach ($universities as $uni): ?>
                            <div class="p-8 px-10 border-l border-gray-100 dark:border-gray-800 flex items-center">
                                <?php if ($uni['ranking'] == $minRank && count($universities) > 1): ?>
                                    <div class="flex flex-col gap-2">
                                        <span
                                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-black bg-success/10 text-success border border-success/20 shadow-sm">
                                            <span class="material-symbols-outlined text-[18px]">workspace_premium</span>
                                            #<?= $uni['ranking'] ?: 'N/A' ?>
                                        </span>
                                        <span class="text-[10px] font-black text-success uppercase tracking-wider">Top in
                                            selection</span>
                                    </div>
                                <?php else: ?>
                                    <span
                                        class="inline-flex items-center px-4 py-2 rounded-xl text-sm font-bold bg-gray-100 dark:bg-gray-800 text-text-main dark:text-white">
                                        #<?= $uni['ranking'] ?: 'N/A' ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                        <?php for ($i = count($universities); $i < 3; $i++): ?>
                            <div class="p-8 border-l border-gray-100 dark:border-gray-800"></div><?php endfor; ?>
                    </div>

                    <!-- Category: Financials -->
                    <div class="grid bg-gray-50/50 dark:bg-gray-900/50 border-b border-gray-100 dark:border-gray-800"
                        style="<?= $gridStyle ?>">
                        <div class="p-5 px-8 flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary text-[24px]">payments</span>
                            <span class="text-xs font-black text-text-muted uppercase tracking-[0.1em]">Annual Tuition
                                Fees</span>
                        </div>
                        <div class="border-l border-gray-100 dark:border-gray-800"></div>
                        <div class="border-l border-gray-100 dark:border-gray-800"></div>
                        <div class="border-l border-gray-100 dark:border-gray-800"></div>
                    </div>

                    <!-- Row: Tuition Range -->
                    <div class="grid border-b border-gray-100 dark:border-gray-800 group/row hover:bg-gray-50/50 dark:hover:bg-gray-800/10 transition-all"
                        style="<?= $gridStyle ?>">
                        <div class="p-8 px-10 text-sm font-bold text-text-main dark:text-gray-300 flex items-center">
                            Est. Range (USD)
                        </div>
                        <?php foreach ($universities as $uni): ?>
                            <div class="p-8 px-10 border-l border-gray-100 dark:border-gray-800 flex items-center">
                                <div class="flex flex-col gap-1">
                                    <span class="text-xl font-black text-text-main dark:text-white">
                                        <?= $uni['tuition_fee_min'] ? '$' . number_format($uni['tuition_fee_min'] / 1000, 1) . 'k' : 'N/A' ?>
                                        <span class="text-text-muted font-medium text-sm mx-1">-</span>
                                        <?= $uni['tuition_fee_max'] ? '$' . number_format($uni['tuition_fee_max'] / 1000, 1) . 'k' : 'N/A' ?>
                                    </span>
                                    <?php if ($uni['tuition_fee_min'] == $minTuition && count($universities) > 1): ?>
                                        <span
                                            class="inline-flex items-center gap-1.5 text-[10px] font-black text-success uppercase tracking-wider">
                                            <span class="material-symbols-outlined text-[14px]">saving</span>
                                            Most Affordable
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <?php for ($i = count($universities); $i < 3; $i++): ?>
                            <div class="p-8 border-l border-gray-100 dark:border-gray-800"></div><?php endfor; ?>
                    </div>

                    <!-- Category: Academic Profile -->
                    <div class="grid bg-gray-50/50 dark:bg-gray-900/50 border-b border-gray-100 dark:border-gray-800"
                        style="<?= $gridStyle ?>">
                        <div class="p-5 px-8 flex items-center gap-3">
                            <span class="material-symbols-outlined text-primary text-[24px]">school</span>
                            <span class="text-xs font-black text-text-muted uppercase tracking-[0.1em]">Academic
                                Profile</span>
                        </div>
                        <div class="border-l border-gray-100 dark:border-gray-800"></div>
                        <div class="border-l border-gray-100 dark:border-gray-800"></div>
                        <div class="border-l border-gray-100 dark:border-gray-800"></div>
                    </div>

                    <!-- Row: Type -->
                    <div class="grid border-b border-gray-100 dark:border-gray-800 group/row hover:bg-gray-50/50 dark:hover:bg-gray-800/10 transition-all"
                        style="<?= $gridStyle ?>">
                        <div class="p-8 px-10 text-sm font-bold text-text-main dark:text-gray-300 flex items-center">
                            Institution Type
                        </div>
                        <?php foreach ($universities as $uni): ?>
                            <div class="p-8 px-10 border-l border-gray-100 dark:border-gray-800 flex items-center">
                                <span class="px-4 py-2 rounded-xl bg-primary/5 text-primary text-sm font-bold capitalize">
                                    <?= esc($uni['type'] ?: 'N/A') ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                        <?php for ($i = count($universities); $i < 3; $i++): ?>
                            <div class="p-8 border-l border-gray-100 dark:border-gray-800"></div><?php endfor; ?>
                    </div>

                    <!-- Row: STEM -->
                    <div class="grid border-b border-gray-100 dark:border-gray-800 group/row hover:bg-gray-50/50 dark:hover:bg-gray-800/10 transition-all"
                        style="<?= $gridStyle ?>">
                        <div class="p-8 px-10 text-sm font-bold text-text-main dark:text-gray-300 flex items-center">
                            STEM Programs
                        </div>
                        <?php foreach ($universities as $uni): ?>
                            <div class="p-8 px-10 border-l border-gray-100 dark:border-gray-800 flex items-center">
                                <div class="flex items-center gap-3">
                                    <?php if ($uni['stem_available']): ?>
                                        <div
                                            class="size-8 rounded-full bg-success/10 text-success flex items-center justify-center shadow-sm border border-success/20">
                                            <span class="material-symbols-outlined text-[18px] font-black">check</span>
                                        </div>
                                        <span class="text-sm font-bold text-text-main dark:text-white">Available</span>
                                    <?php else: ?>
                                        <div
                                            class="size-8 rounded-full bg-danger/10 text-danger flex items-center justify-center shadow-sm border border-danger/20">
                                            <span class="material-symbols-outlined text-[18px] font-black">close</span>
                                        </div>
                                        <span class="text-sm font-bold text-text-muted">Limited/No</span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <?php for ($i = count($universities); $i < 3; $i++): ?>
                            <div class="p-8 border-l border-gray-100 dark:border-gray-800"></div><?php endfor; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Advisory -->
        <div
            class="mt-12 p-8 rounded-3xl bg-secondary/5 border border-secondary/10 flex flex-col md:flex-row items-center gap-6">
            <div
                class="size-16 rounded-2xl bg-secondary text-white flex items-center justify-center shrink-0 shadow-lg shadow-secondary/20">
                <span class="material-symbols-outlined text-3xl">lightbulb</span>
            </div>
            <div>
                <h4 class="text-xl font-black text-text-main dark:text-white mb-2">Decision Support Tip</h4>
                <p class="text-text-muted dark:text-gray-400 text-base leading-relaxed">
                    While rankings are important, consider the **Total Cost of Attendance** including living expenses in
                    <?= count($universities) > 1 ? 'these locations' : 'this location' ?>.
                    STEM designated programs may offer extended work permits (OPT) in some countries.
                </p>
            </div>
            <div class="md:ml-auto">
                <a href="<?= base_url('contact') ?>"
                    class="flex items-center gap-2 px-6 py-3 bg-secondary hover:bg-secondary-hover text-white rounded-xl font-bold transition-all shadow-xl shadow-secondary/20 whitespace-nowrap">
                    Speak to an Advisor
                    <span class="material-symbols-outlined text-[18px]">support_agent</span>
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
    async function removeFromCompare(type, id) {
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
                location.reload();
            } else {
                alert(data.message || 'Error removing item');
            }
        } catch (error) {
            console.error(error);
        }
    }
</script>

<?= view('web/include/footer') ?>