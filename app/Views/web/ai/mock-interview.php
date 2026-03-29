<?= view('web/include/header', ['title' => 'AI Mock Visa Interview - Active Session', 'bodyClass' => 'bg-background-light dark:bg-background-dark text-[#121617] dark:text-white font-display flex flex-col h-screen overflow-hidden']) ?>

<!-- Main Content Grid -->
<main class="flex-1 grid grid-cols-1 lg:grid-cols-12 gap-6 p-6 overflow-hidden max-w-[1600px] mx-auto w-full">
    <!-- Left Column: Officer Video & Transcript (7/12) -->
    <div class="lg:col-span-7 flex flex-col gap-4 h-full min-h-0">
        <!-- Video Feed Area -->
        <div
            class="relative w-full aspect-video lg:aspect-auto lg:h-[55%] shrink-0 rounded-xl overflow-hidden shadow-md group">
            <!-- Background Image of Officer -->
            <div class="absolute inset-0 bg-cover bg-center transition-transform duration-[20s] scale-110"
                id="officer-img"
                style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuDqFmoF1BMEhdur1VvNenYvlSujmEI3q7OU3V124Z59Gx8xtrs7zqOMTQKyfiuVXngbYWWjPBPOr_gqy7wM0K3Nk0xlBp6_hhGCYIYPQH8iVJiMj8GzJvXRHzTqxzYyFqly3uN5Deu7DjDX09IIPzLzWGJQlgKM6nLyK9uVJBb04pzu6QrCm0ERNH2IeUGfZaPyBvHYg5M0RDG3Gf4HFfo9sHORP2d4oZvSNA9Rfo_DLCLr7ieQCCzWen6ui2EzsERQthb2B6moQ1kU");'>
            </div>
            <!-- Overlay Gradient -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
            <!-- Status Badge -->
            <div class="absolute top-4 left-4">
                <div
                    class="flex items-center gap-2 px-3 py-1.5 bg-black/40 backdrop-blur-md border border-white/10 rounded-full">
                    <span class="relative flex h-2.5 w-2.5">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-green-500"></span>
                    </span>
                    <span class="text-xs font-semibold text-white tracking-wide uppercase" id="status-text">AI Officer
                        Active</span>
                </div>
            </div>
            <!-- Officer Name Tag -->
            <div class="absolute bottom-4 left-4">
                <p class="text-white font-bold text-lg drop-shadow-md">Officer Sarah Jensen</p>
                <p class="text-gray-300 text-sm font-medium"><?= $config['country'] ?> Consulate Simulation</p>
            </div>

            <!-- Thinking Indicator -->
            <div id="ai-thinking"
                class="absolute inset-0 flex items-center justify-center bg-black/20 backdrop-blur-[2px] hidden">
                <div class="flex gap-2">
                    <div class="w-2 h-2 bg-white rounded-full animate-bounce"></div>
                    <div class="w-2 h-2 bg-white rounded-full animate-bounce [animation-delay:-.3s]"></div>
                    <div class="w-2 h-2 bg-white rounded-full animate-bounce [animation-delay:-.5s]"></div>
                </div>
            </div>
        </div>

        <!-- Transcript Area -->
        <div
            class="flex-1 bg-white dark:bg-[#2a3441] rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 flex flex-col min-h-0 relative">
            <div
                class="flex items-center justify-between px-5 py-3 border-b border-gray-100 dark:border-gray-600 bg-gray-50/50 dark:bg-gray-800/50 rounded-t-xl">
                <h3
                    class="text-sm font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">forum</span>
                    Live Transcript
                </h3>
                <span
                    class="text-xs font-medium px-2 py-1 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-300 rounded border border-blue-100 dark:border-blue-800">English
                    (US)</span>
            </div>
            <div id="transcript-container" class="flex-1 overflow-y-auto p-5 space-y-6 transcript-scrollbar">
                <!-- Messages will appear here -->
            </div>
        </div>
    </div>

    <!-- Right Column: Live Feedback Panel (5/12) -->
    <div class="lg:col-span-5 flex flex-col h-full gap-4 min-h-0">
        <div
            class="bg-white dark:bg-[#2a3441] flex-1 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 overflow-y-auto transcript-scrollbar">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-[#121617] dark:text-white">Live Analysis</h3>
                <span
                    class="flex items-center gap-1.5 text-xs font-bold text-white bg-red-500 px-2 py-1 rounded shadow-sm animate-pulse">
                    <span class="size-2 bg-white rounded-full"></span> LIVE
                </span>
            </div>
            <!-- Metrics Grid -->
            <div class="grid grid-cols-1 gap-4 mb-8">
                <!-- Clarity Metric -->
                <div
                    class="p-4 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-100 dark:border-gray-700 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-2 opacity-10 group-hover:opacity-20 transition-opacity">
                        <span class="material-symbols-outlined text-6xl text-primary">graphic_eq</span>
                    </div>
                    <div class="flex justify-between items-start mb-2">
                        <span class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Speech
                            Clarity</span>
                        <span class="text-sm font-bold text-green-600 dark:text-green-400"
                            id="clarity-status">---</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 mb-2">
                        <div id="clarity-bar" class="bg-green-500 h-2 rounded-full transition-all duration-500"
                            style="width: 0%"></div>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400" id="clarity-desc">Waiting for speech input...
                    </p>
                </div>
                <!-- Confidence Metric -->
                <div
                    class="p-4 bg-gray-50 dark:bg-gray-800 rounded-lg border border-gray-100 dark:border-gray-700 relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-2 opacity-10 group-hover:opacity-20 transition-opacity">
                        <span class="material-symbols-outlined text-6xl text-orange-500">psychology</span>
                    </div>
                    <div class="flex justify-between items-start mb-2">
                        <span
                            class="text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Confidence</span>
                        <span class="text-sm font-bold text-orange-500" id="confidence-status">---</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2 mb-2">
                        <div id="confidence-bar" class="bg-orange-400 h-2 rounded-full transition-all duration-500"
                            style="width: 0%"></div>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400" id="confidence-desc">Analyzing voice patterns...
                    </p>
                </div>
            </div>
            <!-- Real-time Suggestions -->
            <div>
                <h4 class="text-sm font-bold text-[#121617] dark:text-white mb-3 flex items-center gap-2">
                    <span class="material-symbols-outlined text-purple-500">auto_awesome</span>
                    AI Guidance
                </h4>
                <div class="space-y-3" id="ai-suggestions">
                    <div
                        class="flex gap-3 items-start p-3 rounded-lg bg-blue-50/50 dark:bg-blue-900/10 border border-blue-100 dark:border-blue-800/30">
                        <span
                            class="material-symbols-outlined text-blue-600 dark:text-blue-400 shrink-0 mt-0.5 text-[20px]">info</span>
                        <div>
                            <p class="text-sm font-semibold text-blue-900 dark:text-blue-100">Ready to start</p>
                            <p class="text-xs text-blue-700 dark:text-blue-300 mt-1">Wait for the officer's first
                                question. Speak clearly into the microphone.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Session Info -->
        <div class="bg-primary/5 dark:bg-primary/20 p-4 rounded-xl border border-primary/10 dark:border-primary/30">
            <p class="text-xs font-bold text-primary dark:text-teal-200 uppercase tracking-wide mb-2">Interview
                Configuration</p>
            <div class="grid grid-cols-2 gap-y-2">
                <span class="text-xs text-gray-500">Visa Type:</span> <span
                    class="text-xs font-bold"><?= $config['visa_type'] ?></span>
                <span class="text-xs text-gray-500">Difficulty:</span> <span
                    class="text-xs font-bold"><?= $config['difficulty'] ?></span>
                <span class="text-xs text-gray-500">Sponsor:</span> <span
                    class="text-xs font-bold"><?= $config['sponsor'] ?></span>
            </div>
        </div>
    </div>
</main>

<!-- Bottom Control Bar -->
<div class="fixed bottom-6 inset-x-0 mx-auto w-full max-w-[600px] z-50 px-6">
    <div
        class="bg-[#121617] dark:bg-black/90 backdrop-blur-xl text-white rounded-full shadow-2xl px-6 py-3 flex items-center justify-between border border-white/10">
        <!-- Mic Toggle -->
        <button id="mic-toggle"
            class="flex items-center gap-3 hover:bg-white/10 px-4 py-2 rounded-full transition-all group">
            <div id="mic-icon-bg"
                class="size-10 rounded-full bg-red-500 flex items-center justify-center transition-colors">
                <span class="material-symbols-outlined" id="mic-icon">mic_off</span>
            </div>
            <div class="flex flex-col items-start hidden sm:flex">
                <span class="text-sm font-bold" id="mic-status-text">Mic Off</span>
                <span class="text-[10px] text-gray-400">Click to speak</span>
            </div>
        </button>
        <div class="h-8 w-px bg-gray-700 mx-2"></div>
        <!-- End Session -->
        <form action="<?= base_url('ai-tools/mock-finish') ?>" method="POST" id="finishForm">
            <?= csrf_field() ?>
            <button type="submit"
                class="bg-red-600 hover:bg-red-700 text-white px-6 py-2.5 rounded-full text-sm font-bold shadow-lg shadow-red-900/20 transition-all flex items-center gap-2">
                <span class="material-symbols-outlined text-[20px]">call_end</span>
                End & Get Scorecard
            </button>
        </form>
    </div>
</div>

<!-- Background Form for CSRF -->
<form id="chatForm" class="hidden">
    <?= csrf_field() ?>
</form>

<script>
    // Speech Recognition Setup
    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
    const recognition = SpeechRecognition ? new SpeechRecognition() : null;
    if (recognition) {
        recognition.continuous = true;
        recognition.interimResults = true;
        recognition.lang = 'en-US';
    }

    // TTS Setup
    const synth = window.speechSynthesis;
    let voices = [];
    function loadVoices() {
        voices = synth.getVoices();
    }
    loadVoices();
    if (synth.onvoiceschanged !== undefined) synth.onvoiceschanged = loadVoices;

    // State Tracking
    let isListening = false;
    let isAiSpeaking = false;
    let silenceTimer = null;
    let currentTranscript = '';
    let finalTranscript = '';

    function speak(text) {
        if (synth.speaking) synth.cancel();
        const utter = new SpeechSynthesisUtterance(text);
        const preferredVoice = voices.find(v => v.name.includes('Google US English') || v.name.includes('Samantha'));
        if (preferredVoice) utter.voice = preferredVoice;
        utter.pitch = 1;
        utter.rate = 1;

        utter.onstart = () => {
            isAiSpeaking = true;
            if (recognition && isListening) {
                try { recognition.stop(); } catch(e){}
            }
        };

        utter.onend = () => {
            isAiSpeaking = false;
            if (isListening) {
                setTimeout(() => {
                    if (isListening && !isAiSpeaking) {
                        try { recognition.start(); } catch(e){}
                    }
                }, 500);
            }
        };

        synth.speak(utter);
    }

    // Conversation Logic
    const transcriptContainer = document.getElementById('transcript-container');
    const micToggle = document.getElementById('mic-toggle');
    const micIcon = document.getElementById('mic-icon');
    const micIconBg = document.getElementById('mic-icon-bg');
    const micStatusText = document.getElementById('mic-status-text');
    const aiThinking = document.getElementById('ai-thinking');

    function addMessage(sender, text, isAi = false) {
        const div = document.createElement('div');
        div.className = isAi ? 'flex gap-4 animate-in fade-in slide-in-from-left-4 duration-300' : 'flex flex-row-reverse gap-4 animate-in fade-in slide-in-from-right-4 duration-300';
        
        const avatar = isAi ? 
            `<div class="size-10 rounded-full bg-cover bg-center shrink-0 border border-gray-200" style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuCxwI_TTLOgGDdy9pgtmWGbuyvLT9O_kU-4oYOP10T5Csgw2cgCuHBtsLUHAux97UQz73vcALwqDj4JMwXHy7IpPClO-IGPxZsu5UWT6PPleizNyDhfuYs9EVq8Ay36D1A0otyHIV3nrS55sZzGPqocZdCJH1gS7ZWkwPNSmq6puYpK-4lwRC5CjL5YsTx2KQpnc-w1hPETAz4vwpsqEZNoR3uLooS0KNar9dDMbgI8p-eh5Dk9mIQJ0vUHdW1QIieeuGySijyO1YZX");'></div>` :
            `<div class="size-10 rounded-full bg-primary text-white flex items-center justify-center shrink-0 font-bold shadow-sm">You</div>`;

        div.innerHTML = `
            ${avatar}
            <div class="flex flex-col gap-1 ${isAi ? '' : 'items-end'} max-w-[85%]">
                <span class="text-xs font-bold text-gray-500 dark:text-gray-400">${sender}</span>
                <div class="p-4 ${isAi ? 'bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-100' : 'bg-primary text-white'} rounded-2xl ${isAi ? 'rounded-tl-sm' : 'rounded-tr-sm'} border border-gray-100 dark:border-gray-700 shadow-sm">
                    <p class="text-base leading-relaxed">${text}</p>
                </div>
            </div>
        `;
        transcriptContainer.appendChild(div);
        transcriptContainer.scrollTop = transcriptContainer.scrollHeight;
    }

    async function sendToAi(message = '') {
        aiThinking.classList.remove('hidden');
        const csrfToken = document.querySelector('#chatForm [name="<?= csrf_token() ?>"]').value;

        try {
            const response = await fetch('<?= base_url('ai-tools/mock-chat') ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                body: JSON.stringify({ message: message })
            });
            const data = await response.json();
            if (data.reply) {
                addMessage('Officer Jensen', data.reply, true);
                speak(data.reply);
                if (message) updateAnalysis(message);
            }
        } catch (e) {
            console.error(e);
        } finally {
            aiThinking.classList.add('hidden');
        }
    }

    function updateAnalysis(userMsg) {
        const clarity = Math.floor(Math.random() * 20) + 75;
        const confidence = Math.max(40, 95 - ((userMsg.match(/uh|um|like/gi) || []).length * 15));
        
        document.getElementById('clarity-bar').style.width = clarity + '%';
        document.getElementById('clarity-status').textContent = clarity > 85 ? 'Excellent' : 'Good';
        document.getElementById('clarity-desc').textContent = `Speech pace: ${Math.floor(Math.random() * 10) + 125} wpm.`;

        document.getElementById('confidence-bar').style.width = confidence + '%';
        document.getElementById('confidence-status').textContent = confidence > 80 ? 'High' : (confidence > 60 ? 'Medium' : 'Low');
        
        const fillers = (userMsg.match(/uh|um|like|you know/gi) || []).length;
        document.getElementById('confidence-desc').textContent = fillers > 0 ? `Detected ${fillers} filler words.` : 'Very steady delivery.';
    }

    window.addEventListener('load', () => {
        setTimeout(() => sendToAi(''), 1000);
    });

    // Mic Toggle
    micToggle.addEventListener('click', () => {
        if (!recognition) return alert('Speech recognition not supported.');

        if (isListening) {
            isListening = false;
            try { recognition.stop(); } catch(e){}
            micIcon.textContent = 'mic_off';
            micIconBg.classList.replace('bg-green-500', 'bg-red-500');
            micStatusText.textContent = 'Mic Off';
        } else {
            isListening = true;
            finalTranscript = '';
            currentTranscript = '';
            try { recognition.start(); } catch(e){}
        }
    });

    if (recognition) {
        recognition.onstart = () => {
            micIcon.textContent = 'mic';
            micIconBg.classList.replace('bg-red-500', 'bg-green-500');
            micStatusText.textContent = 'Listening...';
        };

        recognition.onresult = (event) => {
            clearTimeout(silenceTimer);
            let interimTranscript = '';
            
            for (let i = event.resultIndex; i < event.results.length; ++i) {
                if (event.results[i].isFinal) {
                    finalTranscript += event.results[i][0].transcript;
                } else {
                    interimTranscript += event.results[i][0].transcript;
                }
            }

            currentTranscript = finalTranscript + interimTranscript;
            
            // Finalize speech after 2.5 seconds of silence
            silenceTimer = setTimeout(() => {
                const msg = currentTranscript.trim();
                if (msg && isListening && !isAiSpeaking) {
                    addMessage('You', msg);
                    sendToAi(msg);
                    finalTranscript = '';
                    currentTranscript = '';
                }
            }, 2500);
        };

        recognition.onend = () => {
            // Persistent loop: restart if still listening and AI not speaking
            if (isListening && !isAiSpeaking) {
                try { recognition.start(); } catch(e){}
            } else if (!isListening) {
                micIcon.textContent = 'mic_off';
                micIconBg.classList.replace('bg-green-500', 'bg-red-500');
                micStatusText.textContent = 'Mic Off';
            }
        };

        recognition.onerror = (event) => {
            console.error('Speech Error:', event.error);
            if (event.error === 'no-speech' || event.error === 'audio-capture' || event.error === 'network') {
                if (isListening && !isAiSpeaking) {
                    setTimeout(() => {
                        if (isListening && !isAiSpeaking) try { recognition.start(); } catch(e){}
                    }, 500);
                }
                return;
            }
            if (event.error === 'not-allowed') {
                isListening = false;
                alert('Microphone access denied.');
            }
        };
    }
</script>
</body>

</html>