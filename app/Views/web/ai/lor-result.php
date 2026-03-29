<?= view('web/include/header', ['title' => 'AI LOR Generator - Your Recommendation Letter', 'bodyClass' => 'bg-background-light dark:bg-background-dark text-[#101818] dark:text-[#f0f4f5] font-display overflow-x-hidden flex flex-col min-h-screen']) ?>

<main class="flex-1 layout-container flex flex-col w-full max-w-[1280px] mx-auto px-4 md:px-8 py-6">
    <!-- Page Header & Actions -->
    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-8">
        <div class="flex flex-col gap-2 max-w-2xl">
            <h1
                class="text-[#101818] dark:text-white text-3xl md:text-4xl font-black leading-tight tracking-[-0.033em]">
                Your Recommendation Letter</h1>
            <p class="text-[#5e888d] text-base md:text-lg font-normal leading-normal">The generated Letter of
                Recommendation is ready. You can refine the text below.</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <button onclick="copyLOR()"
                class="flex items-center justify-center rounded-lg h-10 px-4 bg-white border border-[#d0d7de] hover:bg-[#f0f4f5] text-[#101818] text-sm font-bold shadow-sm transition-all group">
                <span
                    class="material-symbols-outlined mr-2 text-[18px] text-[#5e888d] group-hover:text-primary">content_copy</span>
                <span>Copy Text</span>
            </button>
            <button onclick="window.print()"
                class="flex items-center justify-center rounded-lg h-10 px-6 bg-primary hover:bg-primary-hover text-white text-sm font-bold shadow-md transition-all">
                <span class="material-symbols-outlined mr-2 text-[18px]">download</span>
                <span>Download PDF</span>
            </button>
        </div>
    </div>

    <div class="flex flex-col items-center">
        <div
            class="w-full max-w-[210mm] bg-white dark:bg-[#1e1e1e] p-[20mm] shadow-xl border border-[#e5e7eb] dark:border-[#333] min-h-[297mm]">
            <div id="lorEditor"
                class="prose prose-slate dark:prose-invert max-w-none editor-content outline-none text-[#101818] dark:text-gray-200"
                contenteditable="true">
            </div>
            <textarea id="rawLorContent" class="hidden"><?php
            $content = $lor_content ?? '';
            $content = preg_replace('/^```(?:markdown)?\s*/i', '', $content);
            $content = preg_replace('/```\s*$/', '', $content);
            echo htmlspecialchars($content);
            ?></textarea>
        </div>
    </div>
</main>

<script src="<?= base_url('js/marked.min.js') ?>"></script>
<script>
    function copyLOR() {
        const content = document.getElementById('lorEditor').innerText;
        navigator.clipboard.writeText(content).then(() => {
            alert('LOR copied to clipboard!');
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        const raw = document.getElementById('rawLorContent').value;
        const target = document.getElementById('lorEditor');

        if (raw) {
            if (typeof marked !== 'undefined') {
                marked.use({ breaks: true, gfm: true });
                try {
                    target.innerHTML = marked.parse(raw);
                } catch (e) {
                    console.error('Markdown parsing failed', e);
                    target.textContent = raw;
                    target.style.whiteSpace = 'pre-wrap';
                }
            } else {
                console.error('Marked library not loaded');
                target.textContent = raw;
                target.style.whiteSpace = 'pre-wrap';
            }
        }
    });
</script>

<style>
    @media print {
        body * {
            visibility: hidden;
        }

        .layout-container,
        .layout-container * {
            visibility: visible;
        }

        .layout-container {
            position: absolute;
            left: 0;
            top: 0;
            padding: 0 !important;
            margin: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
        }

        button {
            display: none !important;
        }

        .bg-background-light {
            background: white !important;
        }

        h1,
        p {
            display: none !important;
        }
    }
</style>

<?= view('web/include/footer') ?>