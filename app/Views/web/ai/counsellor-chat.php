<?= view('web/include/header', ['title' => 'AI Counsellor Chat | UniHunt', 'bodyClass' => 'bg-background-light dark:bg-background-dark font-display h-screen flex flex-col overflow-hidden']) ?>

<div class="flex-1 flex overflow-hidden">
    <!-- Sidebar: Profile & Recommendations -->
    <aside
        class="w-full max-w-sm bg-surface-light dark:bg-surface-dark border-r border-border-light dark:border-border-dark flex flex-col overflow-y-auto hidden md:flex">
        <div class="p-4 border-b border-border-light dark:border-border-dark">
            <h2 class="font-bold text-lg text-text-main dark:text-white mb-1">Student Profile</h2>
            <div class="text-xs text-text-secondary dark:text-gray-400">
                <p><strong>Education:</strong>
                    <?= esc($profile['education_level'] ?? 'N/A') ?>
                </p>
                <p><strong>Target:</strong>
                    <?= esc($profile['preferred_country'] ?? 'N/A') ?>
                </p>
                <p><strong>Field:</strong>
                    <?= esc($profile['field_of_study'] ?? 'N/A') ?>
                </p>
            </div>
        </div>

        <div class="flex-1 p-4 space-y-4">
            <h3 class="font-bold text-md text-primary">Top Recommendations</h3>

            <?php if (!empty($recommendations['top_recommendations'])): ?>
                <?php foreach ($recommendations['top_recommendations'] as $rec): ?>
                    <div
                        class="bg-white dark:bg-[#2a323c] rounded-lg p-3 shadow-sm border border-border-light dark:border-border-dark hover:border-primary transition-colors">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="font-bold text-sm text-text-main dark:text-gray-200">
                                <?= esc($rec['university_name']) ?>
                            </h4>
                            <span class="bg-green-100 text-green-700 text-[10px] px-2 py-0.5 rounded-full font-bold">
                                <?= esc($rec['fit_score']) ?>% Match
                            </span>
                        </div>
                        <p class="text-xs text-text-secondary dark:text-gray-400 mb-2">
                            <?= esc($rec['course_name']) ?>
                        </p>
                        <div class="text-[10px] text-text-muted dark:text-gray-500 space-y-1">
                            <p>💰
                                <?= esc($rec['estimated_total_cost']) ?>
                            </p>
                            <p>✅
                                <?= implode(', ', array_slice($rec['match_reasons'] ?? [], 0, 2)) ?>
                            </p>
                        </div>
                        <?php if (isset($rec['university_id']) && isset($rec['course_id'])): ?>
                            <a href="<?= base_url('courses/view/' . $rec['course_id']) ?>" target="_blank"
                                class="block mt-2 text-center text-xs bg-primary/10 text-primary py-1 rounded hover:bg-primary hover:text-white transition-colors">View
                                Course</a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="text-center text-gray-400 text-sm py-4">
                    <p>AI is analyzing your profile to generate recommendations...</p>
                </div>
            <?php endif; ?>
        </div>
    </aside>

    <!-- Chat Area -->
    <main class="flex-1 flex flex-col bg-[#f0f2f5] dark:bg-[#1a202c]">
        <!-- Chat Header -->
        <div
            class="bg-white dark:bg-surface-dark border-b border-border-light dark:border-border-dark p-4 flex justify-between items-center shadow-sm z-10">
            <div class="flex items-center gap-3">
                <div class="size-10 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined">smart_toy</span>
                </div>
                <div>
                    <h1 class="font-bold text-text-main dark:text-white">UniHunt AI Counsellor</h1>
                    <p class="text-xs text-green-500 flex items-center gap-1">
                        <span class="size-2 bg-green-500 rounded-full animate-pulse"></span> Online
                    </p>
                </div>
            </div>
            <a href="<?= base_url('ai-tools/university-counsellor') ?>"
                class="text-xs text-text-secondary hover:text-primary">Exit Session</a>
        </div>

        <!-- Messages Area -->
        <div id="chat-messages" class="flex-1 overflow-y-auto p-4 space-y-4">
            <!-- Initial Greeting -->
            <div class="flex gap-3 max-w-[80%]">
                <div
                    class="size-8 rounded-full bg-primary/10 flex-shrink-0 flex items-center justify-center text-primary mt-1">
                    <span class="material-symbols-outlined text-sm">smart_toy</span>
                </div>
                <div
                    class="bg-white dark:bg-surface-dark p-3 rounded-2xl rounded-tl-none shadow-sm border border-border-light dark:border-border-dark">
                    <p class="text-sm text-text-main dark:text-gray-200">Hello! I've analyzed your profile. Based on
                        your interest in <strong>
                            <?= esc($profile['field_of_study']) ?>
                        </strong> in <strong>
                            <?= esc($profile['preferred_country']) ?>
                        </strong>, I've found some great universities for you. Feel free to ask me questions about them!
                    </p>
                </div>
            </div>

            <!-- History -->
            <?php
            $history = json_decode($session['conversation_history'] ?? '[]', true);
            foreach ($history as $msg):
                ?>
                <div class="flex gap-3 max-w-[80%] <?= $msg['role'] === 'user' ? 'ml-auto flex-row-reverse' : '' ?>">
                    <div
                        class="size-8 rounded-full flex-shrink-0 flex items-center justify-center mt-1 <?= $msg['role'] === 'user' ? 'bg-gray-200 dark:bg-gray-700' : 'bg-primary/10 text-primary' ?>">
                        <span class="material-symbols-outlined text-sm">
                            <?= $msg['role'] === 'user' ? 'person' : 'smart_toy' ?>
                        </span>
                    </div>
                    <div
                        class="p-3 rounded-2xl shadow-sm border border-border-light dark:border-border-dark <?= $msg['role'] === 'user' ? 'bg-primary text-white rounded-tr-none' : 'bg-white dark:bg-surface-dark text-text-main dark:text-gray-200 rounded-tl-none' ?>">
                        <div class="text-sm prose dark:prose-invert max-w-none chat-content">
                            <?= esc($msg['message']) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Input Area -->
        <div class="bg-white dark:bg-surface-dark p-4 border-t border-border-light dark:border-border-dark">
            <form id="chatForm" class="flex gap-2 max-w-4xl mx-auto">
                <input type="hidden" name="session_id" value="<?= esc($session['id']) ?>">
                <input type="text" id="userHelperInput"
                    class="flex-1 rounded-full border border-border-light dark:border-border-dark bg-[#f8fafc] dark:bg-[#2a323c] h-12 px-6 focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all shadow-inner"
                    placeholder="Ask about scholarships, visa, or course details..." required autocomplete="off">
                <button type="submit"
                    class="size-12 rounded-full bg-primary hover:bg-[#158bb3] text-white flex items-center justify-center shadow-lg transition-transform hover:scale-105 active:scale-95 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span class="material-symbols-outlined">send</span>
                </button>
            </form>
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script>
    const chatContainer = document.getElementById('chat-messages');
    const chatForm = document.getElementById('chatForm');
    const inputField = document.getElementById('userHelperInput');

    // Configure marked options
    const renderer = new marked.Renderer();
    const linkRenderer = renderer.link;
    renderer.link = (href, title, text) => {
        const html = linkRenderer.call(renderer, href, title, text);
        return html.replace(/^<a /, '<a target="_blank" rel="noopener noreferrer" ');
    };

    marked.setOptions({
        breaks: true,
        gfm: true,
        renderer: renderer
    });

    function scrollToBottom() {
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }

    // Initial parsing of history
    document.querySelectorAll('.chat-content').forEach(el => {
        const raw = el.textContent.trim();
        if (raw) {
            el.innerHTML = marked.parse(raw);
        }
    });

    scrollToBottom();

    chatForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const message = inputField.value.trim();
        if (!message) return;

        // Optimistic UI Update (User Message)
        appendMessage('user', message);
        inputField.value = '';
        const submitBtn = chatForm.querySelector('button');
        submitBtn.disabled = true;

        // Show typing indicator
        const typingId = showTypingIndicator();
        scrollToBottom();

        try {
            const formData = new FormData();
            formData.append('message', message);
            formData.append('session_id', '<?= esc($session['id']) ?>');
            formData.append('<?= csrf_token() ?>', '<?= csrf_hash() ?>');

            const response = await fetch('<?= base_url('ai-tools/counsellor-chat') ?>', {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            });

            const data = await response.json();

            // Remove typing indicator
            document.getElementById(typingId)?.remove();

            if (data.error) {
                appendMessage('system', 'Error: ' + data.error);
            } else {
                appendMessage('ai', data.reply);
            }

        } catch (error) {
            document.getElementById(typingId)?.remove();
            appendMessage('system', 'Connection error. Please try again.');
        } finally {
            submitBtn.disabled = false;
            scrollToBottom();
            inputField.focus();
        }
    });

    function appendMessage(role, text) {
        const isUser = role === 'user';
        const div = document.createElement('div');
        div.className = `flex gap-3 max-w-[80%] ${isUser ? 'ml-auto flex-row-reverse' : ''}`;

        // Parse markdown for AI, simple text for user (or markdown for both if preferred)
        const contentHtml = marked.parse(text);

        // TTS Button for AI messages
        const ttsButton = !isUser ? `
            <button onclick="playAudio(this)" data-text="${encodeURIComponent(text)}" class="absolute -bottom-3 right-0 size-6 bg-white dark:bg-gray-700 rounded-full shadow border border-border-light dark:border-border-dark flex items-center justify-center text-text-secondary dark:text-gray-400 hover:text-primary transition-colors group">
                <span class="material-symbols-outlined text-[14px]">volume_up</span>
            </button>
        ` : '';

        div.innerHTML = `
            <div class="size-8 rounded-full flex-shrink-0 flex items-center justify-center mt-1 ${isUser ? 'bg-gray-200 dark:bg-gray-700' : 'bg-primary/10 text-primary'}">
                <span class="material-symbols-outlined text-sm">${isUser ? 'person' : 'smart_toy'}</span>
            </div>
            <div class="relative group">
                <div class="p-3 rounded-2xl shadow-sm border border-border-light dark:border-border-dark ${isUser ? 'bg-primary text-white rounded-tr-none' : 'bg-white dark:bg-surface-dark text-text-main dark:text-gray-200 rounded-tl-none'}">
                    <div class="text-sm prose dark:prose-invert max-w-none [&>p]:mb-2 [&>p:last-child]:mb-0 [&>ul]:list-disc [&>ul]:pl-4 [&>ol]:list-decimal [&>ol]:pl-4">
                        ${contentHtml}
                    </div>
                </div>
                ${ttsButton}
            </div>
        `;
        chatContainer.appendChild(div);
    }

    function playAudio(btn) {
        const text = decodeURIComponent(btn.getAttribute('data-text'));

        if ('speechSynthesis' in window) {
            // Cancel any current speech
            window.speechSynthesis.cancel();

            const utterance = new SpeechSynthesisUtterance(text);
            utterance.lang = 'en-US'; // Default to English
            utterance.rate = 1;
            utterance.pitch = 1;

            // Highlight button state
            btn.querySelector('span').textContent = 'stop';
            btn.classList.add('text-primary');

            utterance.onend = function () {
                btn.querySelector('span').textContent = 'volume_up';
                btn.classList.remove('text-primary');
            };

            window.speechSynthesis.speak(utterance);
        } else {
            alert("Sorry, your browser doesn't support text-to-speech.");
        }
    }


    function showTypingIndicator() {
        const id = 'typing-' + Date.now();
        const div = document.createElement('div');
        div.id = id;
        div.className = "flex gap-3 max-w-[80%]";
        div.innerHTML = `
            <div class="size-8 rounded-full flex-shrink-0 flex items-center justify-center mt-1 bg-primary/10 text-primary">
                <span class="material-symbols-outlined text-sm">smart_toy</span>
            </div>
            <div class="p-3 rounded-2xl shadow-sm border border-border-light dark:border-border-dark bg-white dark:bg-surface-dark rounded-tl-none">
                <div class="flex gap-1">
                    <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></span>
                    <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce delay-75"></span>
                    <span class="w-2 h-2 bg-gray-400 rounded-full animate-bounce delay-150"></span>
                </div>
            </div>
        `;
        chatContainer.appendChild(div);
        return id;
    }
</script>