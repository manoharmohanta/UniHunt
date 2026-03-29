<?= view('web/include/header', ['title' => 'AI SOP Generator - Final Edit', 'bodyClass' => 'bg-background-light dark:bg-background-dark text-[#101818] dark:text-[#f0f4f5] font-display overflow-x-hidden flex flex-col min-h-screen']) ?>

<main class="flex-1 layout-container flex flex-col w-full max-w-[1280px] mx-auto px-4 md:px-8 py-6">
    <!-- Breadcrumbs -->
    <div class="flex flex-wrap gap-2 px-0 pb-4">
        <a class="text-[#5e888d] text-sm font-medium leading-normal hover:text-primary transition-colors"
            href="<?= base_url('ai-tools') ?>">AI Tools</a>
        <span class="text-[#5e888d] text-sm font-medium leading-normal">/</span>
        <a class="text-[#5e888d] text-sm font-medium leading-normal hover:text-primary transition-colors"
            href="<?= base_url('ai-tools/sop-generator-form') ?>">SOP Generator</a>
        <span class="text-[#5e888d] text-sm font-medium leading-normal">/</span>
        <span class="text-[#101818] dark:text-white text-sm font-medium leading-normal">Final Edit</span>
    </div>
    <!-- Page Header & Actions -->
    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-8">
        <div class="flex flex-col gap-2 max-w-2xl">
            <h1
                class="text-[#101818] dark:text-white text-3xl md:text-4xl font-black leading-tight tracking-[-0.033em]">
                Review &amp; Refine Your SOP</h1>
            <p class="text-[#5e888d] text-base md:text-lg font-normal leading-normal">Your Statement of Purpose is
                ready. Make final tweaks or adjust the tone before exporting.</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <button
                class="flex items-center justify-center rounded-lg h-10 px-4 bg-white border border-[#d0d7de] hover:bg-[#f0f4f5] text-[#101818] text-sm font-bold shadow-sm transition-all group">
                <span
                    class="material-symbols-outlined mr-2 text-[18px] text-[#5e888d] group-hover:text-primary">content_copy</span>
                <span>Copy Text</span>
            </button>
            <button
                class="flex items-center justify-center rounded-lg h-10 px-4 bg-white border border-[#d0d7de] hover:bg-[#f0f4f5] text-[#101818] text-sm font-bold shadow-sm transition-all group">
                <span
                    class="material-symbols-outlined mr-2 text-[18px] text-[#5e888d] group-hover:text-primary">bookmark</span>
                <span>Save Draft</span>
            </button>
            <button
                class="flex items-center justify-center rounded-lg h-10 px-6 bg-primary hover:bg-primary-hover text-white text-sm font-bold shadow-md transition-all">
                <span class="material-symbols-outlined mr-2 text-[18px]">download</span>
                <span>Download PDF</span>
            </button>
        </div>
    </div>
    <!-- Main Workspace: Split View -->
    <div class="flex flex-col lg:grid lg:grid-cols-12 gap-8 h-full min-h-[600px]">
        <!-- Left Column: Editor (8 cols) -->
        <div class="lg:col-span-8 flex flex-col gap-4">
            <!-- Toolbar & Tone Selector -->
            <div
                class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-white dark:bg-[#252525] p-2 rounded-xl shadow-sm border border-[#e5e7eb] dark:border-[#333]">
                <div class="flex items-center gap-2 pl-2">
                    <span class="text-xs font-bold uppercase tracking-wider text-[#5e888d]">Tone:</span>
                </div>
                <!-- Segmented Buttons from provided list, styled -->
                <div class="flex h-9 p-1 bg-[#f0f4f5] dark:bg-[#333] rounded-lg w-full sm:w-auto">
                    <label
                        class="flex-1 sm:flex-none cursor-pointer flex items-center justify-center rounded px-4 text-xs font-medium transition-all text-[#5e888d] hover:text-[#101818] dark:hover:text-white">
                        <span>Academic</span>
                        <input class="hidden" name="tone" type="radio" value="Academic" />
                    </label>
                    <label
                        class="flex-1 sm:flex-none cursor-pointer flex items-center justify-center rounded px-4 text-xs font-medium transition-all bg-white dark:bg-[#444] shadow-sm text-primary dark:text-white font-bold">
                        <span>Passionate</span>
                        <input checked="" class="hidden" name="tone" type="radio" value="Passionate" />
                    </label>
                    <label
                        class="flex-1 sm:flex-none cursor-pointer flex items-center justify-center rounded px-4 text-xs font-medium transition-all text-[#5e888d] hover:text-[#101818] dark:hover:text-white">
                        <span>Professional</span>
                        <input class="hidden" name="tone" type="radio" value="Professional" />
                    </label>
                </div>
                <div class="hidden sm:block w-px h-6 bg-gray-200 dark:bg-[#444]"></div>
                <div class="flex items-center gap-1 pr-2 overflow-x-auto">
                    <button class="p-1.5 rounded hover:bg-gray-100 dark:hover:bg-[#333] text-gray-500" title="Undo">
                        <span class="material-symbols-outlined text-[18px]">undo</span>
                    </button>
                    <button class="p-1.5 rounded hover:bg-gray-100 dark:hover:bg-[#333] text-gray-500" title="Redo">
                        <span class="material-symbols-outlined text-[18px]">redo</span>
                    </button>
                    <button
                        class="flex items-center gap-1.5 px-3 py-1.5 rounded hover:bg-gray-100 dark:hover:bg-[#333] text-xs font-medium text-primary ml-2">
                        <span class="material-symbols-outlined text-[16px]">auto_fix_high</span>
                        AI Rephrase
                    </button>
                </div>
            </div>
            <!-- Editor Surface -->
            <div
                class="relative flex-1 bg-white dark:bg-[#1e1e1e] rounded-xl shadow-[0_2px_12px_-4px_rgba(0,0,0,0.08)] border border-[#e5e7eb] dark:border-[#333] overflow-hidden flex flex-col">
                <!-- Page simulation wrapper -->
                <div class="flex-1 overflow-y-auto p-8 md:p-12 bg-white dark:bg-[#1e1e1e]">
                    <article id="sopContent"
                        class="prose prose-slate dark:prose-invert max-w-none editor-content outline-none"
                        contenteditable="true">
                        <!-- Content will be rendered here by JS -->
                    </article>
                    <textarea id="rawSopContent" class="hidden"><?php
                    // Format the SOP content to display properly
                    $content = $sop_content ?? 'Your SOP content will appear here.';

                    // Remove the AI's preamble if it exists
                    $content = preg_replace('/^.*?Statement of Purpose.*?---\s*/s', '', $content);
                    $content = preg_replace('/^Okay,.*?word count.*?\.\s*/s', '', $content);

                    // Remove Markdown code block wrappers if present
                    $content = preg_replace('/^```(?:markdown)?\s*/i', '', $content);
                    $content = preg_replace('/```\s*$/', '', $content);

                    echo htmlspecialchars($content);
                    ?></textarea>
                </div>
                <!-- Editor Footer Status -->
                <div
                    class="border-t border-gray-100 dark:border-[#333] px-6 py-3 bg-[#fbfcfd] dark:bg-[#252525] flex justify-between text-xs text-gray-500 font-medium">
                    <span>Last auto-saved 2 mins ago</span>
                    <span>Page 1 of 1</span>
                </div>
            </div>
        </div>
        <!-- Right Column: Checklist (4 cols) -->
        <div class="lg:col-span-4 flex flex-col gap-6">
            <!-- Health Score Card -->
            <div
                class="bg-white dark:bg-[#1e1e1e] rounded-xl p-6 shadow-sm border border-[#e5e7eb] dark:border-[#333] flex items-center justify-between relative overflow-hidden">
                <div class="relative z-10">
                    <p class="text-[#5e888d] text-sm font-bold uppercase tracking-wider mb-1">SOP Health Score</p>
                    <div class="flex items-baseline gap-1">
                        <span
                            class="text-5xl font-black text-primary tracking-tighter"><?= $health_score ?? 85 ?></span>
                        <span class="text-gray-400 font-bold text-lg">/100</span>
                    </div>
                    <p class="text-xs text-gray-500 mt-2 font-medium">
                        <?php
                        $score = $health_score ?? 85;
                        if ($score >= 90) {
                            echo 'Excellent! Ready to submit.';
                        } elseif ($score >= 75) {
                            echo 'Great job! Almost ready to submit.';
                        } elseif ($score >= 60) {
                            echo 'Good start. Consider some improvements.';
                        } else {
                            echo 'Needs work. Review suggestions below.';
                        }
                        ?>
                    </p>
                </div>
                <!-- Decorative Circular Chart BG -->
                <div
                    class="absolute right-[-20px] top-[-20px] size-32 rounded-full border-[12px] border-[#f0f4f5] dark:border-[#333] z-0">
                </div>
                <div
                    class="absolute right-[-20px] top-[-20px] size-32 rounded-full border-[12px] border-primary border-t-transparent border-l-transparent -rotate-45 z-0">
                </div>
                <span
                    class="material-symbols-outlined relative z-10 text-4xl text-primary bg-primary/10 p-2 rounded-full">check_circle</span>
            </div>
            <!-- Checklist Accordion -->
            <div class="flex flex-col gap-4">
                <h3 class="text-[#101818] dark:text-white font-bold text-lg">Final Checklist</h3>
                <!-- Item 1: Word Count (Success) -->
                <div
                    class="group bg-white dark:bg-[#1e1e1e] rounded-lg border border-[#e5e7eb] dark:border-[#333] hover:shadow-md transition-all overflow-hidden">
                    <div class="p-4 flex items-start gap-3 cursor-pointer">
                        <div
                            class="mt-0.5 rounded-full bg-green-100 dark:bg-green-900/30 p-1 text-green-600 dark:text-green-400">
                            <span class="material-symbols-outlined text-[20px]">check</span>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-center mb-1">
                                <span class="font-bold text-[#101818] dark:text-white text-sm">Word Count</span>
                                <span class="text-xs font-bold text-green-600 dark:text-green-400">Perfect</span>
                            </div>
                            <p class="text-xs text-gray-500 mb-2">Target: <?= $word_count ?? '750 - 1000' ?> words for
                                <?= $country ?? 'General' ?>
                            </p>
                            <div class="w-full bg-gray-100 dark:bg-[#333] rounded-full h-1.5">
                                <div class="bg-green-500 h-1.5 rounded-full" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Item 2: Grammar (Success) -->
                <div
                    class="group bg-white dark:bg-[#1e1e1e] rounded-lg border border-[#e5e7eb] dark:border-[#333] hover:shadow-md transition-all overflow-hidden">
                    <div class="p-4 flex items-start gap-3 cursor-pointer">
                        <div
                            class="mt-0.5 rounded-full bg-green-100 dark:bg-green-900/30 p-1 text-green-600 dark:text-green-400">
                            <span class="material-symbols-outlined text-[20px]">check</span>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-center mb-1">
                                <span class="font-bold text-[#101818] dark:text-white text-sm">Grammar &amp;
                                    Spelling</span>
                                <span class="text-xs font-bold text-green-600 dark:text-green-400">Clean</span>
                            </div>
                            <p class="text-xs text-gray-500">0 critical errors found by AI.</p>
                        </div>
                    </div>
                </div>
                <!-- Item 3: Structure (Warning/Success) -->
                <div
                    class="group bg-white dark:bg-[#1e1e1e] rounded-lg border <?= $health_score >= 90 ? 'border-[#e5e7eb] dark:border-[#333]' : 'border-amber-200 dark:border-amber-900/50' ?> hover:shadow-md transition-all overflow-hidden">
                    <div class="p-4 flex items-start gap-3 cursor-pointer">
                        <div
                            class="mt-0.5 rounded-full <?= $health_score >= 90 ? 'bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400' : 'bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400' ?> p-1">
                            <span
                                class="material-symbols-outlined text-[20px]"><?= $health_score >= 90 ? 'check' : 'priority_high' ?></span>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-center mb-1">
                                <span class="font-bold text-[#101818] dark:text-white text-sm">Structure
                                    Check</span>
                                <span
                                    class="text-xs font-bold <?= $health_score >= 90 ? 'text-green-600 dark:text-green-400' : 'text-amber-600 dark:text-amber-400' ?>"><?= $health_score >= 90 ? 'Perfect' : '1 Suggestion' ?></span>
                            </div>
                            <?php if ($health_score < 90): ?>
                                <p class="text-xs text-gray-500 mb-3">The conclusion feels slightly generic for
                                    <?= (!empty($university) && $university !== '[University Name]') ? $university : 'your target university' ?>.
                                </p>
                                <button
                                    class="w-full text-xs font-bold text-primary bg-primary/10 hover:bg-primary/20 py-2 rounded transition-colors text-center">
                                    Fix with AI
                                </button>
                            <?php else: ?>
                                <p class="text-xs text-gray-500">Document structure follows all academic standards.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <!-- Item 4: Uniqueness (Neutral) -->
                <div
                    class="group bg-white dark:bg-[#1e1e1e] rounded-lg border border-[#e5e7eb] dark:border-[#333] hover:shadow-md transition-all overflow-hidden opacity-80 hover:opacity-100">
                    <div class="p-4 flex items-start gap-3 cursor-pointer">
                        <div
                            class="mt-0.5 rounded-full bg-blue-100 dark:bg-blue-900/30 p-1 text-blue-600 dark:text-blue-400">
                            <span class="material-symbols-outlined text-[20px]">fingerprint</span>
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-center mb-1">
                                <span class="font-bold text-[#101818] dark:text-white text-sm">Uniqueness</span>
                                <span class="text-xs font-bold text-blue-600 dark:text-blue-400">Good</span>
                            </div>
                            <p class="text-xs text-gray-500">Includes 3 specific personal anecdotes.</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Promo / Upgrade box -->
            <div
                class="mt-auto bg-gradient-to-br from-[#006e7a] to-[#004e57] rounded-xl p-5 text-white relative overflow-hidden">
                <div class="absolute top-0 right-0 p-4 opacity-10">
                    <span class="material-symbols-outlined text-6xl">school</span>
                </div>
                <h4 class="font-bold text-sm mb-2 relative z-10">Need a Human Review?</h4>
                <p class="text-xs opacity-90 mb-3 relative z-10">Get an expert from Oxford or Harvard to review your
                    SOP within 24 hours.</p>
                <button
                    class="w-full bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white text-xs font-bold py-2 rounded transition-colors relative z-10 border border-white/30">
                    Explore Premium Services
                </button>
            </div>
        </div>
    </div>
</main>

<!-- Markdown Parser (Local Asset) -->
<script src="<?= base_url('js/marked.min.js') ?>"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const raw = document.getElementById('rawSopContent').value;
        const target = document.getElementById('sopContent');

        if (raw) {
            // Check if marked is loaded
            if (typeof marked !== 'undefined') {
                try {
                    // Handle both function and object export styles
                    const parseMarkdown = (typeof marked.parse === 'function') ? marked.parse : marked;

                    if (typeof marked.use === 'function') {
                        marked.use({ gfm: true, breaks: true });
                    } else if (typeof marked.setOptions === 'function') {
                        marked.setOptions({ gfm: true, breaks: true });
                    }

                    target.innerHTML = parseMarkdown(raw);
                    return; // Success
                } catch (e) {
                    console.error('Markdown parsing failed:', e);
                }
            } else {
                console.error('Marked.js library not loaded! Check: <?= base_url('js/marked.min.js') ?>');
            }

            // Fallback: Display raw text ensuring it wraps
            target.textContent = raw;
            target.style.whiteSpace = 'pre-wrap';
            target.style.wordBreak = 'break-word';
        }
    });
</script>

<!-- jsPDF Library for PDF Generation -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
    // Get buttons by their position in the action bar
    const actionButtons = document.querySelectorAll('.flex.flex-wrap.gap-3 button');
    const copyButton = actionButtons[0];
    const saveButton = actionButtons[1];
    const downloadButton = actionButtons[2];

    // Get AI Rephrase button from toolbar
    const rephraseButton = document.querySelector('.flex.items-center.gap-1\\.5.px-3.py-1\\.5');

    // Notification System
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

    // Copy to Clipboard
    if (copyButton) {
        copyButton.addEventListener('click', function () {
            const content = document.getElementById('sopContent').innerText;
            navigator.clipboard.writeText(content).then(() => {
                showNotification('✓ Copied to clipboard!', 'success');
            }).catch(err => {
                showNotification('Failed to copy', 'error');
            });
        });
    }

    // Save Draft
    if (saveButton) {
        saveButton.addEventListener('click', function () {
            const content = document.getElementById('sopContent').innerHTML;
            localStorage.setItem('sop_draft', content);
            localStorage.setItem('sop_draft_time', new Date().toISOString());
            showNotification('✓ Draft saved!', 'success');
        });
    }

    // Download as PDF File
    if (downloadButton) {
        downloadButton.addEventListener('click', function () {
            try {
                // Get the jsPDF constructor
                const { jsPDF } = window.jspdf;
                const doc = new jsPDF();

                // Get content and clean it
                const contentElement = document.getElementById('sopContent');
                let content = contentElement.innerText;

                // PDF settings
                const pageWidth = doc.internal.pageSize.getWidth();
                const pageHeight = doc.internal.pageSize.getHeight();
                const margin = 20;
                const maxWidth = pageWidth - (margin * 2);
                let yPosition = margin;

                // Title
                doc.setFontSize(16);
                doc.setFont(undefined, 'bold');
                doc.text('Statement of Purpose', margin, yPosition);
                yPosition += 10;

                // Add name and date if available
                doc.setFontSize(10);
                doc.setFont(undefined, 'normal');
                const name = '<?= $name ?? "" ?>';
                const date = '<?= date("F d, Y") ?>';
                if (name) {
                    doc.text('Name: ' + name, margin, yPosition);
                    yPosition += 6;
                }
                doc.text('Date: ' + date, margin, yPosition);
                yPosition += 12;

                // Content
                doc.setFontSize(11);
                doc.setFont(undefined, 'normal');

                // Split content into lines that fit the page width
                const lines = doc.splitTextToSize(content, maxWidth);

                // Add lines to PDF with page breaks
                lines.forEach(line => {
                    if (yPosition > pageHeight - margin) {
                        doc.addPage();
                        yPosition = margin;
                    }
                    doc.text(line, margin, yPosition);
                    yPosition += 6;
                });

                // Generate filename
                const filename = 'SOP_<?= str_replace(" ", "_", $name ?? "Document") ?>_<?= date("Y-m-d") ?>.pdf';

                // Download the PDF
                doc.save(filename);

                showNotification('✓ PDF downloaded successfully!', 'success');
            } catch (error) {
                console.error('PDF generation error:', error);
                showNotification('Failed to generate PDF', 'error');
            }
        });
    }

    // AI Rephrase
    if (rephraseButton) {
        rephraseButton.addEventListener('click', function () {
            showNotification('AI Rephrase feature coming soon!', 'info');
        });
    }

    // Load saved draft timestamp
    window.addEventListener('load', function () {
        const savedTime = localStorage.getItem('sop_draft_time');
        if (savedTime) {
            const timeAgo = Math.floor((new Date() - new Date(savedTime)) / 60000);
            const statusElement = document.querySelector('.border-t.border-gray-100 span');
            if (statusElement) {
                statusElement.textContent = `Last auto-saved ${timeAgo} mins ago`;
            }
        }
    });
</script>
<!-- Footer -->

<?= view('web/include/footer') ?>