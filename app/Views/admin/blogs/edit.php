<?= $this->extend('admin/layout') ?>

<?= $this->section('content') ?>

<div class="max-w-4xl mx-auto" x-data="blogForm()">
    <div class="flex items-center gap-4 mb-6">
        <a href="<?= base_url('admin/blogs') ?>"
            class="size-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-slate-200 hover:text-slate-800 transition-colors">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
        </a>
        <h1 class="text-2xl font-bold text-slate-900">Edit Blog Post</h1>
    </div>

    <form action="<?= base_url('admin/blogs/update/' . $blog['id']) ?>" method="post" enctype="multipart/form-data"
        class="space-y-6">
        <?= csrf_field() ?>
        <?= honeypot_field() ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Editor -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Blog Type Selection -->
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                    <label class="block text-sm font-medium text-slate-700 mb-3">Blog Type</label>
                    <div class="flex items-center gap-6">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="category" value="general" x-model="category"
                                class="text-indigo-600 focus:ring-indigo-500">
                            <span class="text-slate-700">General Blog</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="category" value="university" x-model="category"
                                class="text-indigo-600 focus:ring-indigo-500">
                            <span class="text-slate-700">University Specific</span>
                        </label>
                    </div>

                    <!-- University Selection -->
                    <div x-show="category === 'university'" x-transition class="mt-4">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Select University</label>
                        <select name="university_id" id="universitySelect" x-model="universityId" class="w-full">
                            <option value="">-- Choose University --</option>
                            <?php foreach ($universities as $uni): ?>
                                <option value="<?= $uni['id'] ?>">
                                    <?= esc($uni['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <p class="text-xs text-slate-500 mt-1">Images will be automatically fetched from university's
                            gallery.</p>
                    </div>

                    <!-- General Image Upload -->
                    <div x-show="category === 'general'" x-transition class="mt-4">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Featured Image</label>
                        <?php if (!empty($blog['featured_image'])): ?>
                            <div class="mb-2">
                                <img src="<?= base_url($blog['featured_image']) ?>" class="h-20 w-auto rounded border">
                            </div>
                        <?php endif; ?>
                        <input type="file" name="featured_image" accept="image/*"
                            class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    </div>
                </div>

                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Post Title</label>
                    <input type="text" name="title" required value="<?= esc($blog['title']) ?>"
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg text-lg font-medium focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none">
                </div>

                <!-- Quill Styles -->
                <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 flex flex-col h-[600px]">
                    <div class="flex justify-between items-center mb-4">
                        <label class="block text-sm font-medium text-slate-700">Content</label>
                        <button type="button" @click="improveContent" :disabled="loadingAi"
                            class="text-xs font-bold text-indigo-600 flex items-center gap-1 hover:underline disabled:opacity-50">
                            <span class="material-symbols-outlined text-[16px]"
                                :class="loadingAi ? 'animate-spin' : ''">auto_awesome</span>
                            <span x-text="loadingAi ? 'Processing...' : 'Improve with AI'"></span>
                        </button>
                    </div>

                    <!-- Hidden input to store Quill content -->
                    <input type="hidden" name="content" id="blogContent" value="<?= esc($blog['content']) ?>">

                    <!-- Quill container -->
                    <div id="editor-container" class="h-[450px]" style="min-height: 400px;"></div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Publish Settings -->
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                    <h3 class="font-bold text-slate-900 mb-4">Publish</h3>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                        <select name="status" x-model="status"
                            class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 outline-none">
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                        </select>
                    </div>
                    <button type="submit"
                        class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium shadow-sm transition-colors">
                        Update Post
                    </button>
                </div>

                <!-- SEO Settings -->
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 relative overflow-hidden">
                    <div
                        class="absolute top-0 right-0 w-24 h-24 bg-indigo-50 rounded-bl-full -mr-10 -mt-10 pointer-events-none">
                    </div>
                    <h3 class="font-bold text-slate-900 mb-4 relative z-10 flex items-center gap-2">
                        SEO Settings
                        <span
                            class="bg-indigo-100 text-indigo-700 text-[10px] px-2 py-0.5 rounded uppercase">Auto</span>
                    </h3>

                    <div class="space-y-4 relative z-10">
                        <div>
                            <label class="block text-xs font-medium text-slate-500 mb-1">Meta Title</label>
                            <input type="text" name="meta_title" x-model="seo.title"
                                class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-500 mb-1">Meta Description</label>
                            <textarea name="meta_description" x-model="seo.description" rows="3"
                                class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs"></textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-500 mb-1">Keywords</label>
                            <input type="text" name="meta_keywords" x-model="seo.keywords"
                                class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs">
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-medium text-slate-500 mb-1">Blog Category</label>
                                <input type="text" name="blog_category" x-model="seo.blog_category"
                                    placeholder="AI Suggested"
                                    class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs bg-slate-50">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-500 mb-1">Blog Tags</label>
                                <input type="text" name="blog_tags" x-model="seo.blog_tags" placeholder="AI Suggested"
                                    class="w-full px-3 py-2 border border-slate-300 rounded-lg text-xs bg-slate-50">
                            </div>
                        </div>

                        <button type="button" @click="generateSEO" :disabled="loadingSeo"
                            class="w-full py-2 bg-white border border-indigo-200 text-indigo-700 hover:bg-indigo-50 rounded-lg text-sm font-medium transition-colors flex justify-center items-center gap-2 disabled:opacity-50">
                            <span class="material-symbols-outlined text-[18px]"
                                :class="loadingSeo ? 'animate-spin' : ''">auto_fix_high</span>
                            <span x-text="loadingSeo ? 'Analyzing...' : 'Generate Metadata'"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<!-- Quill Library -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<script>
    function blogForm() {
        return {
            category: <?= json_encode($blog['category'] ?? 'general') ?>,
            universityId: <?= json_encode($blog['university_id'] ?? '') ?>,
            status: <?= json_encode($blog['status'] ?? 'draft') ?>,
            loadingAi: false,
            loadingSeo: false,
            seo: {
                title: <?= json_encode($blog['meta_title'] ?? '') ?>,
                description: <?= json_encode($blog['meta_description'] ?? '') ?>,
                keywords: <?= json_encode($blog['meta_keywords'] ?? '') ?>,
                blog_category: <?= json_encode($blog['blog_category'] ?? '') ?>,
                blog_tags: <?= json_encode($blog['blog_tags'] ?? '') ?>
            },
            quill: null,

            init() {
                if (typeof Quill === 'undefined') {
                    console.error('Quill is not defined. Retrying in 100ms...');
                    setTimeout(() => this.init(), 100);
                    return;
                }

                this.quill = new Quill('#editor-container', {
                    theme: 'snow',
                    placeholder: 'Write your specific blog content here...',
                    modules: {
                        toolbar: [
                            [{ 'header': [1, 2, 3, false] }],
                            ['bold', 'italic', 'underline', 'strike'],
                            [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                            ['link', 'image', 'code-block'],
                            ['clean']
                        ]
                    }
                });

                // Load initial content
                // Use a safe way to decode HTML entities if needed, but here we just need raw html
                const initialContent = document.getElementById('blogContent').value;

                // Decode HTML entities if they were encoded by esc()? 
                // esc() encodes chars. Quill needs HTML. 
                // Using a textarea to decode or creating a DOM element helps.
                const txt = document.createElement("textarea");
                txt.innerHTML = initialContent;
                this.quill.root.innerHTML = txt.value;

                // Initialize Select2 for University
                $('#universitySelect').select2({
                    placeholder: '-- Choose University --',
                    allowClear: true,
                    width: '100%'
                }).on('change', (e) => {
                    this.universityId = e.target.value;
                });

                this.quill.on('text-change', () => {
                    document.getElementById('blogContent').value = this.quill.root.innerHTML;
                });
            },

            async generateSEO() {
                const content = this.quill.root.innerText;
                if (content.length < 50) {
                    alert('Please write more content first!');
                    return;
                }

                this.loadingSeo = true;
                try {
                    const res = await fetch('<?= base_url("admin/generate-seo") ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ content: content })
                    });

                    const data = await res.json();

                    if (data.meta_title) this.seo.title = data.meta_title;
                    if (data.meta_description) this.seo.description = data.meta_description;
                    if (data.keywords) this.seo.keywords = data.keywords;
                    if (data.blog_category) this.seo.blog_category = data.blog_category;
                    if (data.blog_tags) this.seo.blog_tags = data.blog_tags;

                    if (data.error) alert(data.error);
                } catch (e) {
                    alert('Failed to generate SEO');
                } finally {
                    this.loadingSeo = false;
                }
            },

            async improveContent() {
                alert('AI Improvement feature coming soon!');
            }
        }
    }
</script>

<?= $this->endSection() ?>