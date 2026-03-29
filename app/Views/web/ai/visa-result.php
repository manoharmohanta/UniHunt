<?= view('web/include/header', ['title' => 'Visa Requirements Result - ' . ($country ?? 'Destination'), 'bodyClass' => 'bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 font-display min-h-screen flex flex-col transition-colors duration-200']) ?>

<?php
// Fallback image if keyword is missing
$imgKeyword = !empty($image_keyword) ? $image_keyword : ($country . ' scenery');
$bgImage = "https://source.unsplash.com/1600x900/?" . urlencode($imgKeyword);
// Unsplash source is deprecated/unreliable, let's use a simpler placeholder or a different source if possible, but for now stick to simple or standard
// Better: "https://api.dicebear.com/9.x/initials/svg?seed=" . $country 
// Even Better for scenery: Pexels or Unsplash via keyword is best effort. 
// Since source.unsplash is often broken, let's try a different free service or just a pattern if it fails.
// Actually, let's use a nice gradient overlay + the image.
?>

<main class="flex-grow">
    <!-- Hero Section -->
    <div class="relative h-[400px] w-full overflow-hidden">
        <div class="absolute inset-0 bg-cover bg-center"
            style="background-image: url('https://image.pollinations.ai/prompt/<?= urlencode($imgKeyword) ?>%20cinematic%20travel%20photography');">
        </div>
        <div
            class="absolute inset-0 bg-gradient-to-t from-background-light dark:from-background-dark via-background-light/50 dark:via-background-dark/50 to-transparent">
        </div>
        <div class="absolute inset-0 bg-black/30"></div>

        <div class="relative h-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col justify-end pb-12">
            <div class="flex flex-col md:flex-row justify-between items-end gap-6 animate-fade-in-up">
                <div>
                    <span
                        class="inline-block py-1 px-3 rounded-full bg-white/20 backdrop-blur-md border border-white/10 text-white text-xs font-bold uppercase tracking-wider mb-2">
                        <?= esc($visa_type) ?> Visa
                    </span>
                    <h1 class="text-4xl md:text-6xl font-black text-white tracking-tight shadow-black drop-shadow-lg">
                        <?= esc($country) ?>
                    </h1>
                    <p class="text-white/90 text-lg mt-2 font-medium max-w-xl">
                        Everything you need to know for your trip to <?= esc($country) ?>.
                    </p>
                </div>

                <button onclick="window.print()"
                    class="flex items-center justify-center rounded-xl h-12 px-6 bg-white/20 hover:bg-white/30 backdrop-blur-md border border-white/30 text-white text-sm font-bold transition-all hover:-translate-y-1">
                    <span class="material-symbols-outlined mr-2">download</span>
                    Download Guide
                </button>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 -mt-8 relative z-10">

        <!-- Quick Stats / Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <!-- Card 1 -->
            <div
                class="bg-white dark:bg-card-dark rounded-2xl p-6 border border-gray-100 dark:border-gray-700 shadow-lg hover:shadow-xl transition-all group">
                <div
                    class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-blue-600 dark:text-blue-400">assignment_turned_in</span>
                </div>
                <h3 class="font-bold text-lg text-text-main dark:text-white mb-1">Documents</h3>
                <p class="text-sm text-text-muted">Essentials checklist</p>
            </div>

            <!-- Card 2 -->
            <div
                class="bg-white dark:bg-card-dark rounded-2xl p-6 border border-gray-100 dark:border-gray-700 shadow-lg hover:shadow-xl transition-all group">
                <div
                    class="w-12 h-12 rounded-xl bg-green-50 dark:bg-green-900/30 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-green-600 dark:text-green-400">map</span>
                </div>
                <h3 class="font-bold text-lg text-text-main dark:text-white mb-1">Itinerary</h3>
                <p class="text-sm text-text-muted">7-Day Plan</p>
            </div>

            <!-- Card 3 -->
            <div
                class="bg-white dark:bg-card-dark rounded-2xl p-6 border border-gray-100 dark:border-gray-700 shadow-lg hover:shadow-xl transition-all group">
                <div
                    class="w-12 h-12 rounded-xl bg-purple-50 dark:bg-purple-900/30 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-purple-600 dark:text-purple-400">photo_camera</span>
                </div>
                <h3 class="font-bold text-lg text-text-main dark:text-white mb-1">Attractions</h3>
                <p class="text-sm text-text-muted">Must-visit spots</p>
            </div>

            <!-- Card 4 -->
            <div
                class="bg-white dark:bg-card-dark rounded-2xl p-6 border border-gray-100 dark:border-gray-700 shadow-lg hover:shadow-xl transition-all group">
                <div
                    class="w-12 h-12 rounded-xl bg-orange-50 dark:bg-orange-900/30 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                    <span class="material-symbols-outlined text-orange-600 dark:text-orange-400">luggage</span>
                </div>
                <h3 class="font-bold text-lg text-text-main dark:text-white mb-1">Packing</h3>
                <p class="text-sm text-text-muted">Travel essentials</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Detailed Info -->
            <div class="lg:col-span-2 space-y-8">

                <!-- Documents -->
                <div
                    class="bg-white dark:bg-card-dark rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex items-center gap-3">
                        <div
                            class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600">
                            <span class="material-symbols-outlined text-lg">description</span>
                        </div>
                        <h2 class="text-xl font-bold text-text-main dark:text-white">Document Checklist</h2>
                    </div>
                    <div class="p-8 prose dark:prose-invert max-w-none markdown-content hidden">
                        <?= htmlspecialchars($document_checklist ?? 'No document information available.') ?>
                    </div>
                </div>

                <!-- Travel Plan -->
                <div
                    class="bg-white dark:bg-card-dark rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex items-center gap-3">
                        <div
                            class="w-8 h-8 rounded-lg bg-green-100 dark:bg-green-900/30 flex items-center justify-center text-green-600">
                            <span class="material-symbols-outlined text-lg">calendar_month</span>
                        </div>
                        <h2 class="text-xl font-bold text-text-main dark:text-white">7-Day Travel Itinerary</h2>
                    </div>
                    <div class="p-8 prose dark:prose-invert max-w-none markdown-content hidden">
                        <?= htmlspecialchars($travel_plan ?? 'No travel plan available.') ?>
                    </div>
                </div>

                <!-- Places to Visit -->
                <div
                    class="bg-white dark:bg-card-dark rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex items-center gap-3">
                        <div
                            class="w-8 h-8 rounded-lg bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center text-purple-600">
                            <span class="material-symbols-outlined text-lg">landscape</span>
                        </div>
                        <h2 class="text-xl font-bold text-text-main dark:text-white">Must-Visit Places</h2>
                    </div>
                    <div class="p-8 prose dark:prose-invert max-w-none markdown-content hidden">
                        <?= htmlspecialchars($places_to_visit ?? 'No place information available.') ?>
                    </div>
                </div>
            </div>

            <!-- Right Column: Quick Tips & Resources -->
            <div class="space-y-8">

                <!-- Things to Carry -->
                <div
                    class="bg-white dark:bg-card-dark rounded-3xl border border-gray-100 dark:border-gray-700 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-gray-100 dark:border-gray-700 flex items-center gap-3">
                        <div
                            class="w-8 h-8 rounded-lg bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center text-orange-600">
                            <span class="material-symbols-outlined text-lg">backpack</span>
                        </div>
                        <h2 class="text-xl font-bold text-text-main dark:text-white">Packing List</h2>
                    </div>
                    <div class="p-6 prose dark:prose-invert max-w-none text-sm markdown-content hidden">
                        <?= htmlspecialchars($things_to_carry ?? 'No packing info.') ?>
                    </div>
                </div>

                <!-- Useful Links -->
                <?php if (!empty($useful_links)): ?>
                    <div
                        class="bg-gradient-to-br from-primary/5 to-blue-500/5 dark:from-primary/20 dark:to-blue-500/10 rounded-3xl border border-primary/20 p-6">
                        <h3 class="font-bold text-lg text-text-main dark:text-white mb-4 flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary">link</span> Official Resources
                        </h3>
                        <div class="space-y-3">
                            <?php
                            // Parse links if they are in "Title: URL" format roughly
                            $lines = explode("\n", $useful_links);
                            foreach ($lines as $line):
                                $parts = explode(':', $line, 2);
                                $url = trim($parts[1] ?? $line);
                                $label = trim($parts[0] ?? 'Resource');
                                if (filter_var($url, FILTER_VALIDATE_URL)):
                                    ?>
                                    <a href="<?= esc($url) ?>" target="_blank" rel="noopener noreferrer"
                                        class="flex items-center gap-3 p-3 bg-white dark:bg-card-dark rounded-xl border border-gray-100 dark:border-gray-700 hover:border-primary transition-colors group">
                                        <span
                                            class="material-symbols-outlined text-gray-400 group-hover:text-primary transition-colors">public</span>
                                        <div class="flex-1 min-w-0">
                                            <p
                                                class="text-sm font-bold text-text-main dark:text-white truncate group-hover:text-primary transition-colors">
                                                <?= esc($label) ?>
                                            </p>
                                            <p class="text-xs text-text-muted truncate"><?= esc($url) ?></p>
                                        </div>
                                        <span
                                            class="material-symbols-outlined text-gray-300 text-sm group-hover:text-primary">open_in_new</span>
                                    </a>
                                <?php endif; endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Ad/Promo (Optional) -->
                <div class="bg-gray-900 rounded-3xl p-6 text-center text-white relative overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-tr from-primary to-blue-600 opacity-90"></div>
                    <div class="relative z-10">
                        <h3 class="font-bold text-lg mb-2">Need Flight Deals?</h3>
                        <p class="text-sm text-blue-100 mb-4">Find the cheapest flights to <?= esc($country) ?>
                            instantly.</p>
                        <button
                            class="w-full py-3 bg-white text-primary font-bold rounded-xl text-sm hover:bg-gray-50 transition-colors">
                            Search Flights
                        </button>
                    </div>
                </div>

                <!-- Score Page / General Ad Slot -->
                <div class="uni-ad-slot" data-placement="score_page"></div>

            </div>
        </div>
    </div>
</main>

<style>
    @keyframes fade-in-up {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate-fade-in-up {
        animation: fade-in-up 0.6s ease-out forwards;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        marked.setOptions({ breaks: true, gfm: true });

        // Render all elements with .markdown-content class
        document.querySelectorAll('.markdown-content').forEach(el => {
            const raw = el.textContent.trim();
            if (raw) {
                el.innerHTML = marked.parse(raw);
                el.classList.remove('hidden');
            }
        });
    });
</script>

<?= view('web/include/footer') ?>