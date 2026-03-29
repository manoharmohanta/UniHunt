<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
    <!-- Stat Card 1 -->
    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-start justify-between">
        <div>
            <p class="text-sm font-medium text-slate-500 mb-1">Total Users</p>
            <h3 class="text-3xl font-bold text-slate-900"><?= number_format($stats['users']) ?></h3>
        </div>
        <div class="size-12 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center">
            <span class="material-symbols-outlined text-2xl">group</span>
        </div>
    </div>

    <!-- Stat Card 2 -->
    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-start justify-between">
        <div>
            <p class="text-sm font-medium text-slate-500 mb-1">Generated Documents</p>
            <h3 class="text-3xl font-bold text-slate-900"><?= number_format($stats['documents']) ?></h3>
        </div>
        <div class="size-12 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center">
            <span class="material-symbols-outlined text-2xl">description</span>
        </div>
    </div>

    <!-- Stat Card 3 -->
    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-start justify-between">
        <div>
            <p class="text-sm font-medium text-slate-500 mb-1">Mock Interviews</p>
            <h3 class="text-3xl font-bold text-slate-900"><?= number_format($stats['interviews']) ?></h3>
        </div>
        <div class="size-12 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center">
            <span class="material-symbols-outlined text-2xl">video_camera_front</span>
        </div>
    </div>

    <!-- Stat Card 4 -->
    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-start justify-between">
        <div>
            <p class="text-sm font-medium text-slate-500 mb-1">Universities</p>
            <h3 class="text-3xl font-bold text-slate-900"><?= number_format($stats['universities']) ?></h3>
        </div>
        <div class="size-12 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
            <span class="material-symbols-outlined text-2xl">account_balance</span>
        </div>
    </div>

    <!-- Stat Card 5 -->
    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-start justify-between">
        <div>
            <p class="text-sm font-medium text-slate-500 mb-1">Total Courses</p>
            <h3 class="text-3xl font-bold text-slate-900"><?= number_format($stats['courses']) ?></h3>
        </div>
        <div class="size-12 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center">
            <span class="material-symbols-outlined text-2xl">list_alt</span>
        </div>
    </div>

    <!-- Stat Card 6 -->
    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-start justify-between">
        <div>
            <p class="text-sm font-medium text-slate-500 mb-1">Total AI Requests</p>
            <h3 class="text-3xl font-bold text-slate-900"><?= number_format($stats['ai_usage']) ?></h3>
        </div>
        <div class="size-12 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
            <span class="material-symbols-outlined text-2xl">psychology</span>
        </div>
    </div>
    <!-- Stat Card 7: Visitors -->
    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-start justify-between">
        <div>
            <p class="text-sm font-medium text-slate-500 mb-1">Total Visitors</p>
            <h3 class="text-3xl font-bold text-slate-900"><?= number_format($stats['visitors']) ?></h3>
        </div>
        <div class="size-12 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
            <span class="material-symbols-outlined text-2xl">visibility</span>
        </div>
    </div>

    <!-- Stat Card 8: Coupons -->
    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-start justify-between">
        <div>
            <p class="text-sm font-medium text-slate-500 mb-1">Coupons Redemptions</p>
            <h3 class="text-3xl font-bold text-slate-900"><?= number_format($stats['coupon_usage']) ?></h3>
        </div>
        <div class="size-12 rounded-lg bg-pink-50 text-pink-600 flex items-center justify-center">
            <span class="material-symbols-outlined text-2xl">local_activity</span>
        </div>
    </div>

    <!-- Stat Card 9: Ad Revenue -->
    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm flex items-start justify-between">
        <div>
            <p class="text-sm font-medium text-slate-500 mb-1">Ad Revenue</p>
            <h3 class="text-3xl font-bold text-slate-900">₹<?= number_format($stats['ad_revenue'], 2) ?></h3>
        </div>
        <div class="size-12 rounded-lg bg-green-50 text-green-600 flex items-center justify-center">
            <span class="material-symbols-outlined text-2xl">monetization_on</span>
        </div>
    </div>
</div>

<!-- Visitor Analytics Section -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
    <!-- Top Countries Analytics Card -->
    <div
        class="lg:col-span-2 bg-white rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/50 overflow-hidden flex flex-col max-w-6xl mx-auto">

        <!-- Card Header -->
        <div class="px-8 py-6 border-b border-slate-50 flex items-center justify-between bg-white">
            <div>
                <h2 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                    <span class="material-symbols-outlined text-indigo-500">public</span>
                    Top Countries
                </h2>
                <p class="text-xs text-slate-400 font-medium mt-1">
                    Geographic distribution of unique visitors
                </p>
            </div>
            <div class="flex items-center gap-2">
                <span
                    class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-full text-[10px] font-bold uppercase tracking-wider">
                    30 Days
                </span>
                <button class="p-2 hover:bg-slate-50 rounded-full transition-colors text-slate-400">
                    <span class="material-symbols-outlined text-[20px]">more_vert</span>
                </button>
            </div>
        </div>

        <!-- Content -->
        <div class="p-8 flex-1">
            <!-- Chart (100% Width) -->
            <div class="relative w-full h-[400px]">
                <canvas id="countryChart" class="w-full h-full"></canvas>
            </div>

            <!-- Footer Info -->
            <div class="mt-6 flex items-center gap-4 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                <div class="size-10 rounded-xl bg-white shadow-sm flex items-center justify-center text-indigo-600">
                    <span class="material-symbols-outlined">analytics</span>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                        Global Reach
                    </p>
                    <p class="text-xs font-bold text-slate-700">
                        Tracking traffic from 8 countries this month
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Popular Study Destinations -->
    <div
        class="bg-white rounded-3xl border border-slate-100 shadow-xl shadow-slate-200/50 overflow-hidden flex flex-col">
        <div class="px-8 py-6 border-b border-slate-50 flex items-center justify-between bg-white">
            <div>
                <h2 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                    <span class="material-symbols-outlined text-emerald-500">explore</span>
                    Popular Destinations
                </h2>
                <p class="text-xs text-slate-400 font-medium mt-1">Most searched study destinations</p>
            </div>
            <div class="flex items-center gap-2">
                <span
                    class="px-3 py-1 bg-emerald-50 text-emerald-600 rounded-full text-[10px] font-bold uppercase tracking-wider">30
                    Days</span>
            </div>
        </div>

        <div class="p-8 flex-1">
            <?php if (!empty($visitors['destinations'])): ?>
                <div class="space-y-5">
                    <?php
                    $destFlags = [
                        'usa' => '🇺🇸',
                        'united-states' => '🇺🇸',
                        'uk' => '🇬🇧',
                        'united-kingdom' => '🇬🇧',
                        'canada' => '🇨🇦',
                        'australia' => '🇦🇺',
                        'germany' => '🇩🇪',
                        'france' => '🇫🇷',
                        'netherlands' => '🇳🇱',
                        'ireland' => '🇮🇪',
                        'new-zealand' => '🇳🇿',
                        'singapore' => '🇸🇬'
                    ];
                    $maxCount = !empty($visitors['destinations']) ? $visitors['destinations'][0]['count'] : 1;
                    foreach ($visitors['destinations'] as $dest):
                        $percentage = round(($dest['count'] / $maxCount) * 100);
                        $flag = $destFlags[strtolower($dest['country_slug'])] ?? '🌍';
                        $displayName = ucwords(str_replace('-', ' ', $dest['country_slug']));
                        ?>
                        <div class="group">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-3">
                                    <span class="text-2xl"><?= $flag ?></span>
                                    <div>
                                        <span
                                            class="text-sm font-bold text-slate-700 group-hover:text-emerald-600 transition-colors"><?= $displayName ?></span>
                                        <p class="text-[10px] text-slate-400 font-medium">Study Interest</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="text-sm font-black text-slate-800"><?= number_format($dest['count']) ?></span>
                                    <p class="text-[10px] text-slate-400 font-medium"><?= $percentage ?>%</p>
                                </div>
                            </div>
                            <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-emerald-500 to-teal-500 rounded-full transition-all duration-1000"
                                    style="width: <?= $percentage ?>%"></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-12">
                    <span class="material-symbols-outlined text-6xl text-slate-200">travel_explore</span>
                    <p class="text-sm text-slate-400 mt-4">No destination data yet</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Device Usage Section (Moved Below) -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 flex flex-col">
        <div class="flex items-center justify-between mb-6">
            <h2 class="font-bold text-slate-800">Device Usage</h2>
            <span class="material-symbols-outlined text-slate-400">devices</span>
        </div>
        <div class="relative h-[350px]">
            <canvas id="deviceChart"></canvas>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 flex flex-col gap-6">
        <h2 class="font-bold text-slate-800">System Actions</h2>
        <a href="<?= base_url('admin/universities/create') ?>"
            class="group p-4 rounded-xl border border-slate-100 hover:border-indigo-100 hover:bg-indigo-50/30 transition-all flex items-center gap-4">
            <div
                class="size-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center group-hover:bg-indigo-600 group-hover:text-white transition-all">
                <span class="material-symbols-outlined">add_business</span>
            </div>
            <div>
                <p class="text-sm font-bold text-slate-800">New University</p>
                <p class="text-[11px] text-slate-500">Register educational hub</p>
            </div>
        </a>
        <a href="<?= base_url('admin/courses/create') ?>"
            class="group p-4 rounded-xl border border-slate-100 hover:border-teal-100 hover:bg-teal-50/30 transition-all flex items-center gap-4">
            <div
                class="size-10 rounded-lg bg-teal-50 text-teal-600 flex items-center justify-center group-hover:bg-teal-600 group-hover:text-white transition-all">
                <span class="material-symbols-outlined">playlist_add</span>
            </div>
            <div>
                <p class="text-sm font-bold text-slate-800">New Course</p>
                <p class="text-[11px] text-slate-500">List new study program</p>
            </div>
        </a>
        <a href="<?= base_url('admin/blogs/create') ?>"
            class="group p-4 rounded-xl border border-slate-100 hover:border-amber-100 hover:bg-amber-50/30 transition-all flex items-center gap-4">
            <div
                class="size-10 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center group-hover:bg-amber-600 group-hover:text-white transition-all">
                <span class="material-symbols-outlined">edit</span>
            </div>
            <div>
                <p class="text-sm font-bold text-slate-800">Post Blog</p>
                <p class="text-[11px] text-slate-500">Publish news or guides</p>
            </div>
        </a>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // 1. Country Chart with Custom Gradient & UI Hooks
    const ctxCountry = document.getElementById('countryChart').getContext('2d');

    // Create Premium Gradient
    const gradient = ctxCountry.createLinearGradient(0, 0, 400, 0);
    gradient.addColorStop(0, '#6366f1');
    gradient.addColorStop(1, '#a855f7');

    new Chart(ctxCountry, {
        type: 'bar',
        data: {
            labels: <?= json_encode(array_column($visitors['countries'], 'country')) ?>,
            datasets: [{
                label: 'Visitors',
                data: <?= json_encode(array_column($visitors['countries'], 'count')) ?>,
                backgroundColor: gradient,
                hoverBackgroundColor: '#4f46e5',
                borderRadius: 12,
                barPercentage: 0.7,
                categoryPercentage: 0.8,
                maxBarThickness: 40,
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                duration: 2000,
                easing: 'easeOutQuart'
            },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b',
                    padding: 16,
                    titleFont: { size: 14, weight: 'bold', family: 'Plus Jakarta Sans' },
                    bodyFont: { size: 13, family: 'Plus Jakarta Sans' },
                    displayColors: false,
                    cornerRadius: 12,
                    callbacks: {
                        label: function (context) {
                            return ' ' + context.parsed.x.toLocaleString() + ' Unique Visitors';
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: true,
                        color: '#f1f5f9',
                        drawBorder: false
                    },
                    ticks: {
                        color: '#94a3b8',
                        font: { size: 10, weight: '600' },
                        callback: function (value) { return value.toLocaleString(); }
                    },
                    beginAtZero: true
                },
                y: {
                    grid: { display: false, drawBorder: false },
                    ticks: {
                        font: { size: 12, weight: '600', family: 'Plus Jakarta Sans' },
                        color: '#1e293b'
                    }
                }
            }
        }
    });

    // 2. Device Chart
    const ctxDevice = document.getElementById('deviceChart');
    new Chart(ctxDevice, {
        type: 'doughnut',
        data: {
            labels: ['Mobile', 'Desktop'],
            datasets: [{
                data: [<?= $visitors['devices']['mobile'] ?>, <?= $visitors['devices']['desktop'] ?>],
                backgroundColor: ['#f43f5e', '#6366f1'],
                borderWidth: 0,
                cutout: '70%',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20 } }
            }
        }
    });
</script>
<?= $this->endSection() ?>