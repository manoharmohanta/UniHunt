<?= view('web/include/header', ['title' => 'AI Resume Builder', 'bodyClass' => 'bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 font-display h-screen flex flex-col overflow-hidden']) ?>

    <div class="flex flex-1 overflow-hidden">
        <!-- Sidebar Navigation -->
        <aside
            class="w-64 bg-white dark:bg-[#1c2126] border-r border-slate-200 dark:border-slate-800 flex flex-col shrink-0 overflow-y-auto z-10">
            <div class="p-6">
                <div class="flex items-center justify-between mb-2">
                    <h2 class="text-sm font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Resume
                        Sections</h2>
                    <span class="text-xs font-bold text-primary bg-primary/10 px-2 py-0.5 rounded-full">65%</span>
                </div>
                <!-- Progress Bar -->
                <div class="h-1.5 w-full bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden mb-6">
                    <div class="h-full w-[65%] bg-primary rounded-full"></div>
                </div>
                <nav class="flex flex-col gap-1">
                    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors group"
                        href="#">
                        <span
                            class="material-symbols-outlined text-[20px] text-slate-400 group-hover:text-primary transition-colors">person</span>
                        <span class="text-sm font-medium">Contact Info</span>
                        <span class="material-symbols-outlined text-[16px] text-emerald-500 ml-auto">check_circle</span>
                    </a>
                    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors group"
                        href="#">
                        <span
                            class="material-symbols-outlined text-[20px] text-slate-400 group-hover:text-primary transition-colors">school</span>
                        <span class="text-sm font-medium">Education</span>
                        <span class="material-symbols-outlined text-[16px] text-emerald-500 ml-auto">check_circle</span>
                    </a>
                    <!-- Active Item -->
                    <a class="relative flex items-center gap-3 px-3 py-2.5 rounded-lg bg-primary/5 text-primary dark:text-primary font-bold transition-colors"
                        href="#">
                        <div class="absolute left-0 top-1/2 -translate-y-1/2 h-6 w-1 bg-primary rounded-r-full"></div>
                        <span class="material-symbols-outlined text-[20px] fill-1">work</span>
                        <span class="text-sm">Experience</span>
                    </a>
                    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors group"
                        href="#">
                        <span
                            class="material-symbols-outlined text-[20px] text-slate-400 group-hover:text-primary transition-colors">psychology</span>
                        <span class="text-sm font-medium">Skills</span>
                    </a>
                    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors group"
                        href="#">
                        <span
                            class="material-symbols-outlined text-[20px] text-slate-400 group-hover:text-primary transition-colors">folder</span>
                        <span class="text-sm font-medium">Projects</span>
                    </a>
                    <a class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors group"
                        href="#">
                        <span
                            class="material-symbols-outlined text-[20px] text-slate-400 group-hover:text-primary transition-colors">verified</span>
                        <span class="text-sm font-medium">Certifications</span>
                    </a>
                </nav>
            </div>
            <div class="mt-auto p-6 border-t border-slate-100 dark:border-slate-800">
                <button
                    class="w-full flex items-center justify-center gap-2 py-2 text-sm font-bold text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200">
                    <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                    Back to Dashboard
                </button>
            </div>
        </aside>
        <!-- Center: Editor Area -->
        <main class="flex-1 overflow-y-auto bg-background-light dark:bg-background-dark relative">
            <div class="max-w-3xl mx-auto px-8 py-10 pb-32">
                <header class="mb-8">
                    <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-2">Work Experience</h1>
                    <p class="text-slate-500 dark:text-slate-400 text-lg">Highlight your professional journey. Use the
                        AI tool to refine your achievements.</p>
                </header>
                <div class="flex flex-col gap-6">
                    <!-- Collapsed Item -->
                    <div
                        class="bg-white dark:bg-paper-dark border border-slate-200 dark:border-slate-700 rounded-lg p-4 flex items-center justify-between opacity-60 hover:opacity-100 transition-opacity cursor-pointer group">
                        <div class="flex items-center gap-4">
                            <div
                                class="size-10 rounded-full bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-bold">
                                GC
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-900 dark:text-white">Marketing Intern</h3>
                                <p class="text-sm text-slate-500">Global Corp â€¢ Jan 2023 - Present</p>
                            </div>
                        </div>
                        <button class="text-slate-400 group-hover:text-primary">
                            <span class="material-symbols-outlined">edit</span>
                        </button>
                    </div>
                    <!-- Active Editing Card -->
                    <div
                        class="bg-white dark:bg-paper-dark border-2 border-primary/20 rounded-xl shadow-xl shadow-slate-200/50 dark:shadow-none overflow-hidden relative">
                        <div class="absolute top-0 left-0 w-1 h-full bg-primary"></div>
                        <div class="p-6 flex flex-col gap-6">
                            <div class="flex justify-between items-start">
                                <h3 class="font-bold text-lg text-slate-900 dark:text-white">New Position</h3>
                                <button
                                    class="text-red-500 hover:text-red-600 text-sm font-medium flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[16px]">delete</span>
                                    Delete
                                </button>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div class="space-y-1.5">
                                    <label class="text-xs font-bold uppercase tracking-wider text-slate-500">Job
                                        Title</label>
                                    <input
                                        class="w-full bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-lg text-sm px-3 py-2.5 focus:ring-primary focus:border-primary font-medium text-slate-900 dark:text-white placeholder-slate-400"
                                        placeholder="e.g. Software Engineer" type="text" value="Product Designer" />
                                </div>
                                <div class="space-y-1.5">
                                    <label
                                        class="text-xs font-bold uppercase tracking-wider text-slate-500">Employer</label>
                                    <input
                                        class="w-full bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-lg text-sm px-3 py-2.5 focus:ring-primary focus:border-primary font-medium text-slate-900 dark:text-white placeholder-slate-400"
                                        placeholder="e.g. Google" type="text" value="Creative Solutions Inc." />
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-5">
                                <div class="space-y-1.5">
                                    <label class="text-xs font-bold uppercase tracking-wider text-slate-500">Start
                                        Date</label>
                                    <input
                                        class="w-full bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-lg text-sm px-3 py-2.5 focus:ring-primary focus:border-primary font-medium text-slate-900 dark:text-white"
                                        type="month" value="2022-06" />
                                </div>
                                <div class="space-y-1.5">
                                    <label class="text-xs font-bold uppercase tracking-wider text-slate-500">End
                                        Date</label>
                                    <div class="flex gap-2">
                                        <input
                                            class="w-full bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-lg text-sm px-3 py-2.5 focus:ring-primary focus:border-primary font-medium text-slate-900 dark:text-white disabled:opacity-50"
                                            disabled="" type="month" />
                                        <div
                                            class="flex items-center gap-2 min-w-[100px] px-2 border border-slate-200 dark:border-slate-700 rounded-lg bg-slate-50 dark:bg-slate-800">
                                            <input checked=""
                                                class="rounded text-primary focus:ring-primary border-gray-300"
                                                type="checkbox" />
                                            <span
                                                class="text-sm font-medium text-slate-700 dark:text-slate-300">Current</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-1.5 relative group/editor">
                                <div class="flex items-center justify-between">
                                    <label
                                        class="text-xs font-bold uppercase tracking-wider text-slate-500">Description</label>
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs text-slate-400">Markdown supported</span>
                                    </div>
                                </div>
                                <div class="relative">
                                    <textarea
                                        class="w-full bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-lg text-sm px-4 py-3 focus:ring-primary focus:border-primary text-slate-900 dark:text-white leading-relaxed resize-none"
                                        placeholder="Describe your responsibilities and achievements..." rows="6">- Spearheaded the redesign of the main product interface, resulting in a 20% increase in user engagement.
- Collaborated with cross-functional teams to implement a new design system.
- Conducted user research sessions to gather qualitative feedback.</textarea>
                                    <!-- AI Enhance Floating Action -->
                                    <div class="absolute bottom-3 right-3 flex items-center gap-2 z-10">
                                        <button
                                            class="flex items-center gap-2 pl-3 pr-4 py-1.5 bg-gradient-to-r from-teal-50 to-white dark:from-slate-800 dark:to-slate-700 border border-teal-200 dark:border-teal-900/50 rounded-full shadow-sm hover:shadow-md hover:border-teal-300 transition-all group/ai">
                                            <div
                                                class="bg-gradient-to-br from-teal-400 to-emerald-400 text-white rounded-full p-1 shadow-sm">
                                                <span
                                                    class="material-symbols-outlined text-[14px] animate-pulse">auto_awesome</span>
                                            </div>
                                            <span
                                                class="text-xs font-bold text-teal-800 dark:text-teal-300 group-hover/ai:text-teal-900 dark:group-hover/ai:text-teal-200">AI
                                                Enhance</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Action Footer inside Card -->
                        <div
                            class="bg-slate-50 dark:bg-slate-800/50 px-6 py-4 flex justify-end gap-3 border-t border-slate-100 dark:border-slate-800">
                            <button
                                class="px-4 py-2 text-sm font-bold text-slate-500 hover:text-slate-700 dark:text-slate-400">Cancel</button>
                            <button
                                class="px-6 py-2 bg-slate-900 dark:bg-white text-white dark:text-slate-900 rounded-lg text-sm font-bold hover:bg-slate-800 dark:hover:bg-slate-100 transition-colors">Save</button>
                        </div>
                    </div>
                    <button
                        class="flex items-center justify-center gap-2 py-4 border-2 border-dashed border-slate-300 dark:border-slate-700 rounded-xl text-slate-500 font-bold hover:border-primary hover:text-primary hover:bg-primary/5 transition-all">
                        <span class="material-symbols-outlined">add</span>
                        Add Another Position
                    </button>
                </div>
            </div>
        </main>
        <!-- Right: Live Preview Panel -->
        <aside
            class="hidden xl:flex w-[45%] max-w-[700px] bg-[#eef2f6] dark:bg-[#0d1117] border-l border-slate-200 dark:border-slate-800 flex-col relative">
            <div
                class="h-12 flex items-center justify-between px-6 border-b border-slate-200/50 dark:border-slate-800/50 bg-[#eef2f6]/90 dark:bg-[#0d1117]/90 backdrop-blur-sm z-10 shrink-0">
                <span class="text-xs font-bold uppercase tracking-widest text-slate-400">Live Preview</span>
                <div class="flex items-center gap-2">
                    <button class="p-1 hover:bg-white dark:hover:bg-slate-800 rounded text-slate-500">
                        <span class="material-symbols-outlined text-[18px]">zoom_out</span>
                    </button>
                    <span class="text-xs font-medium text-slate-600 dark:text-slate-400">100%</span>
                    <button class="p-1 hover:bg-white dark:hover:bg-slate-800 rounded text-slate-500">
                        <span class="material-symbols-outlined text-[18px]">zoom_in</span>
                    </button>
                </div>
            </div>
            <!-- The Scrollable Area -->
            <div class="flex-1 overflow-y-auto p-8 flex justify-center items-start custom-scrollbar">
                <!-- Resume Paper -->
                <div
                    class="w-full max-w-[210mm] aspect-[1/1.414] bg-white text-slate-900 shadow-2xl shadow-slate-300/50 dark:shadow-black/50 p-[10mm] sm:p-[15mm] flex flex-col gap-6 text-[10px] leading-relaxed origin-top transform transition-transform duration-200">
                    <!-- Header -->
                    <div class="border-b border-slate-900 pb-4 mb-2">
                        <h1 class="text-2xl font-serif font-bold tracking-tight text-slate-900 mb-1">Alex Morgan</h1>
                        <div class="flex flex-wrap gap-x-4 gap-y-1 text-slate-600 font-serif italic text-[9px]">
                            <span>San Francisco, CA</span>
                            <span>â€¢</span>
                            <span>alex.morgan@university.edu</span>
                            <span>â€¢</span>
                            <span>(555) 123-4567</span>
                            <span>â€¢</span>
                            <span>linkedin.com/in/alexmorgan</span>
                        </div>
                    </div>
                    <!-- Education -->
                    <div>
                        <h2
                            class="font-bold text-xs uppercase tracking-widest text-slate-900 border-b border-slate-200 pb-1 mb-3">
                            Education</h2>
                        <div class="flex justify-between font-bold mb-1">
                            <span>University of Global Studies</span>
                            <span>Expected May 2024</span>
                        </div>
                        <div class="flex justify-between italic text-slate-700 mb-2">
                            <span>Bachelor of Science in Computer Science</span>
                            <span>GPA: 3.8/4.0</span>
                        </div>
                        <ul class="list-disc list-outside ml-4 text-slate-600 space-y-1">
                            <li>Relevant Coursework: Data Structures, Algorithms, User Interface Design, Artificial
                                Intelligence.</li>
                            <li>Dean's List: Fall 2021, Spring 2022, Fall 2022.</li>
                        </ul>
                    </div>
                    <!-- Experience (Live Updating) -->
                    <div>
                        <h2
                            class="font-bold text-xs uppercase tracking-widest text-slate-900 border-b border-slate-200 pb-1 mb-3">
                            Work Experience</h2>
                        <!-- Entry 1 (Being Edited) -->
                        <div class="mb-4 group relative">
                            <!-- Visual cue for active editing in preview -->
                            <div class="absolute -left-4 top-1 bottom-1 w-0.5 bg-primary/50 rounded-full"></div>
                            <div class="flex justify-between font-bold mb-1">
                                <span>Product Designer</span>
                                <span>June 2022 - Present</span>
                            </div>
                            <div class="flex justify-between italic text-slate-700 mb-2">
                                <span>Creative Solutions Inc.</span>
                                <span>New York, NY</span>
                            </div>
                            <ul class="list-disc list-outside ml-4 text-slate-600 space-y-1">
                                <li>Spearheaded the redesign of the main product interface, resulting in a 20% increase
                                    in user engagement.</li>
                                <li>Collaborated with cross-functional teams to implement a new design system.</li>
                                <li>Conducted user research sessions to gather qualitative feedback.</li>
                            </ul>
                        </div>
                        <!-- Entry 2 -->
                        <div class="mb-4">
                            <div class="flex justify-between font-bold mb-1">
                                <span>Marketing Intern</span>
                                <span>Jan 2022 - May 2022</span>
                            </div>
                            <div class="flex justify-between italic text-slate-700 mb-2">
                                <span>Global Corp</span>
                                <span>Remote</span>
                            </div>
                            <ul class="list-disc list-outside ml-4 text-slate-600 space-y-1">
                                <li>Assisted in the development of social media campaigns reaching 50k+ followers.</li>
                                <li>Analyzed engagement metrics to optimize future content strategies.</li>
                            </ul>
                        </div>
                    </div>
                    <!-- Projects -->
                    <div>
                        <h2
                            class="font-bold text-xs uppercase tracking-widest text-slate-900 border-b border-slate-200 pb-1 mb-3">
                            Projects</h2>
                        <div class="mb-2">
                            <div class="flex justify-between font-bold mb-1">
                                <span>EcoTrack App</span>
                                <span class="text-slate-500 font-normal italic">React Native, Firebase</span>
                            </div>
                            <ul class="list-disc list-outside ml-4 text-slate-600 space-y-1">
                                <li>Built a mobile application to help users track their carbon footprint.</li>
                                <li>Integrated REST APIs for real-time environmental data visualization.</li>
                            </ul>
                        </div>
                    </div>
                    <!-- Skills -->
                    <div>
                        <h2
                            class="font-bold text-xs uppercase tracking-widest text-slate-900 border-b border-slate-200 pb-1 mb-3">
                            Skills</h2>
                        <div class="grid grid-cols-[100px_1fr] gap-y-2 text-slate-700">
                            <span class="font-bold">Languages:</span>
                            <span>JavaScript (ES6+), Python, HTML5, CSS3, SQL</span>
                            <span class="font-bold">Frameworks:</span>
                            <span>React, Vue.js, Node.js, Tailwind CSS</span>
                            <span class="font-bold">Tools:</span>
                            <span>Git, Figma, Adobe Creative Suite, VS Code</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Mobile Toggle overlay (Decorative for desktop view) -->
            <div class="absolute bottom-6 left-1/2 -translate-x-1/2 md:hidden">
                <button
                    class="bg-slate-900 text-white px-4 py-2 rounded-full shadow-lg text-sm font-bold flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">visibility</span>
                    Preview Resume
                </button>
            </div>
        </aside>
    </div>
</body>

</html>

