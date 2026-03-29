<?= view('web/include/header', ['title' => 'Blog Post Detail View - UniHunt', 'bodyClass' => 'bg-background-light dark:bg-background-dark text-[#111816] dark:text-gray-100 antialiased font-display transition-colors duration-200']) ?>

<!-- Main Layout -->
<main class="flex-grow w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
        <!-- Left Column: Article Content (8 cols) -->
        <article class="lg:col-span-8 flex flex-col gap-8">
            <!-- Breadcrumbs & Meta -->
            <div class="flex flex-col gap-6">
                <nav class="flex flex-wrap items-center gap-2 text-sm text-[#61897f] dark:text-gray-400">
                    <a class="hover:text-primary transition-colors" href="<?= base_url() ?>">Home</a>
                    <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                    <a class="hover:text-primary transition-colors" href="<?= base_url('blog') ?>">Blog</a>
                    <span class="material-symbols-outlined text-[16px]">chevron_right</span>
                    <a href="<?= base_url('blog/category/' . url_title($blog['blog_category'] ?? $blog['category'] ?? 'general', '-', true)) ?>"
                        class="text-[#111816] dark:text-white font-medium hover:text-primary hover:underline underline-offset-2 transition-colors">
                        <?= esc($blog['blog_category'] ?? ucfirst($blog['category'] ?? 'General')) ?>
                    </a>
                </nav>
                <h1
                    class="text-[#111816] dark:text-white text-3xl sm:text-4xl md:text-5xl font-black leading-[1.15] tracking-tight">
                    <?= esc($blog['title']) ?>
                </h1>
                <div class="flex items-center justify-between border-y border-gray-200 dark:border-gray-800 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full overflow-hidden bg-gray-200">
                            <img alt="Author" class="w-full h-full object-cover"
                                src="https://ui-avatars.com/api/?name=<?= urlencode($blog['author_name'] ?? 'UniHunt') ?>&background=random" />
                        </div>
                        <div class="flex flex-col">
                            <span
                                class="text-[#111816] dark:text-white text-sm font-bold"><?= esc($blog['author_name'] ?? 'UniHunt Team') ?></span>
                            <span class="text-[#61897f] dark:text-gray-400 text-xs">Contributor</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 text-[#61897f] dark:text-gray-400 text-sm">
                        <span class="hidden sm:inline"><?= date('M d, Y', strtotime($blog['created_at'])) ?></span>
                        <span class="w-1 h-1 rounded-full bg-gray-300 hidden sm:block"></span>
                        <div class="flex items-center gap-1 bg-gray-100 dark:bg-gray-800 px-2 py-1 rounded">
                            <span class="material-symbols-outlined text-[16px]">schedule</span>
                            <span><?= max(1, round(str_word_count(strip_tags($blog['content'])) / 200)) ?> min
                                read</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Featured Image -->
            <div class="w-full aspect-[16/9] rounded-xl overflow-hidden shadow-sm">
                <?php
                $mainImg = !empty($blog['featured_image']) ? base_url($blog['featured_image']) : 'https://placehold.co/800x450?text=UniHunt+Blog';
                if (!empty($blog['uni_gallery_image'])) {
                    $mainImg = (stripos($blog['uni_gallery_image'], 'http') === 0) ? $blog['uni_gallery_image'] : base_url($blog['uni_gallery_image']);
                }
                ?>
                <div class="w-full h-full bg-gray-200 bg-center bg-cover"
                    style="background-image: url('<?= $mainImg ?>');">
                </div>
            </div>
            <!-- Article Body -->
            <div id="blog-body"
                class="prose prose-lg max-w-none text-[#33383D] dark:text-gray-300 leading-relaxed space-y-6">
                <?= $blog['content'] ?>
            </div>
            <!-- Interaction Area: Tags & Share (Bottom) -->
            <div class="border-t border-gray-200 dark:border-gray-800 pt-8 mt-4">
                <div class="flex flex-wrap gap-2 mb-6">
                    <?php if (!empty($blog['blog_tags'])): ?>
                        <?php
                        $tags = explode(',', $blog['blog_tags']);
                        foreach ($tags as $tag):
                            $tag = trim($tag);
                            if (empty($tag))
                                continue;
                            ?>
                            <a href="<?= base_url('blog/tag/' . url_title($tag, '-', true)) ?>"
                                class="px-3 py-1 bg-gray-100 dark:bg-gray-800 text-[#61897f] dark:text-gray-300 text-sm rounded-full font-medium hover:bg-primary/10 hover:text-primary transition-colors">#<?= esc($tag) ?></a>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <span
                            class="px-3 py-1 bg-gray-100 dark:bg-gray-800 text-[#61897f] dark:text-gray-300 text-sm rounded-full font-medium">#StudyAbroad</span>
                    <?php endif; ?>
                </div>
            </div>
            <!-- Newsletter CTA -->
            <div class="bg-primary rounded-xl p-8 sm:p-10 text-white relative overflow-hidden group">
                <div
                    class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700">
                </div>
                <div class="relative z-10">
                    <span class="material-symbols-outlined text-[40px] mb-4">mail</span>
                    <h3 class="text-2xl font-bold mb-2">Don't miss the next guide</h3>
                    <p class="text-white/80 mb-6 max-w-md">Join <?= number_format($subscriberCount ?? 45000) ?>+
                        students getting weekly study abroad
                        tips, scholarship alerts, and university guides.</p>
                    <form hx-post="<?= base_url('subscribe') ?>" hx-swap="outerHTML"
                        class="flex flex-col sm:flex-row gap-3">
                        <?= csrf_field() ?>
                        <input name="email"
                            class="flex-1 px-4 py-3 rounded-lg text-[#111816] focus:outline-none focus:ring-2 focus:ring-white/50 border-none"
                            placeholder="Your email address" type="email" required />
                        <button
                            class="px-6 py-3 bg-[#1c1e22] text-white font-bold rounded-lg hover:bg-black transition-colors shadow-lg flex items-center justify-center gap-2"
                            type="submit">
                            <span>Subscribe Free</span>
                            <span
                                class="htmx-indicator animate-spin material-symbols-outlined text-sm">progress_activity</span>
                        </button>
                    </form>
                </div>
            </div>
            <!-- Comments Section -->
            <section id="comments-section" class="mt-8 pt-8 border-t border-gray-200 dark:border-gray-800">
                <h3 class="text-xl font-bold text-[#111816] dark:text-white mb-6 flex items-center gap-2">
                    Discussion <span class="text-gray-400 text-sm font-normal">(<?= $commentCount ?> comments)</span>
                </h3>

                <!-- Flash Messages -->
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="mb-4 p-4 rounded-lg bg-green-50 text-green-700 border border-green-200">
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="mb-4 p-4 rounded-lg bg-red-50 text-red-700 border border-red-200">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <!-- Comment Input -->
                <div class="flex gap-4 mb-10" id="comment-form-container">
                    <div class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700 flex-shrink-0 overflow-hidden">
                        <?php if (session()->get('isLoggedIn')): ?>
                            <img src="https://ui-avatars.com/api/?name=<?= urlencode(session()->get('user_name')) ?>&background=random"
                                class="w-full h-full object-cover">
                        <?php endif; ?>
                    </div>
                    <div class="flex-1">
                        <?php if (session()->get('isLoggedIn')): ?>
                            <form action="<?= base_url('blog/comment') ?>" method="POST">
                                <?= csrf_field() ?>
                                <input type="hidden" name="blog_id" value="<?= $blog['id'] ?>">
                                <input type="hidden" name="parent_id" id="parent-id-input">

                                <div id="replying-to-banner"
                                    class="hidden mb-2 px-3 py-1 bg-primary/10 text-primary text-xs rounded-full items-center gap-2 w-fit">
                                    <span>Replying to <span id="replying-to-name" class="font-bold"></span></span>
                                    <button type="button" onclick="cancelReply()" class="hover:text-red-600"><span
                                            class="material-symbols-outlined text-[14px]">close</span></button>
                                </div>

                                <textarea name="comment" required
                                    class="w-full bg-[#f0f4f3] dark:bg-gray-800 border-none rounded-lg p-4 text-sm focus:ring-1 focus:ring-primary resize-y min-h-[100px] text-[#111816] dark:text-white"
                                    placeholder="Share your thoughts or ask a question..."></textarea>
                                <div class="flex justify-end mt-2">
                                    <button type="submit"
                                        class="px-4 py-2 bg-primary text-white text-sm font-bold rounded-lg hover:bg-[#085d48] transition-colors">Post
                                        Comment</button>
                                </div>
                            </form>
                        <?php else: ?>
                            <div class="bg-[#f0f4f3] dark:bg-gray-800 rounded-lg p-6 text-center">
                                <p class="text-gray-600 dark:text-gray-300 mb-3">Please log in to join the discussion.</p>
                                <a href="<?= base_url('login') ?>"
                                    class="inline-block px-5 py-2 bg-primary text-white text-sm font-bold rounded-lg hover:bg-primary-hover">Log
                                    In</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Comment List -->
                <div class="space-y-8">
                    <?php if (empty($comments)): ?>
                        <p class="text-gray-500 italic text-center">No comments yet. Be the first to share your thoughts!
                        </p>
                    <?php else: ?>
                        <?php foreach ($comments as $comment): ?>
                            <!-- Parent Comment -->
                            <div class="flex gap-4">
                                <div class="w-10 h-10 rounded-full bg-gray-200 flex-shrink-0 overflow-hidden">
                                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($comment['user_name']) ?>&background=random"
                                        class="w-full h-full object-cover">
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span
                                            class="font-bold text-[#111816] dark:text-white text-sm"><?= esc($comment['user_name']) ?></span>
                                        <span class="text-gray-400 text-xs text-[10px]">•
                                            <?= date('M d, Y', strtotime($comment['created_at'])) ?></span>
                                        <?php if ($comment['user_id'] == $blog['author_id']): ?>
                                            <span
                                                class="bg-primary/10 text-primary text-[9px] px-1.5 py-0.5 rounded uppercase font-bold tracking-wide">Author</span>
                                        <?php endif; ?>
                                    </div>
                                    <p class="text-gray-600 dark:text-gray-300 text-sm leading-relaxed">
                                        <?= esc($comment['comment']) ?>
                                    </p>
                                    <?php if (session()->get('isLoggedIn')): ?>
                                        <button onclick="replyTo(<?= $comment['id'] ?>, '<?= esc($comment['user_name']) ?>')"
                                            class="text-[#61897f] text-xs font-bold mt-2 hover:underline flex items-center gap-1">
                                            Reply
                                        </button>
                                    <?php endif; ?>

                                    <!-- Replies -->
                                    <?php if (!empty($comment['replies'])): ?>
                                        <div class="mt-4 space-y-4">
                                            <?php foreach ($comment['replies'] as $reply): ?>
                                                <div class="flex gap-4">
                                                    <div class="w-8 h-8 rounded-full bg-gray-200 flex-shrink-0 overflow-hidden">
                                                        <img src="https://ui-avatars.com/api/?name=<?= urlencode($reply['user_name']) ?>&background=random"
                                                            class="w-full h-full object-cover">
                                                    </div>
                                                    <div>
                                                        <div class="flex items-center gap-2 mb-1">
                                                            <span
                                                                class="font-bold text-[#111816] dark:text-white text-xs"><?= esc($reply['user_name']) ?></span>
                                                            <span class="text-gray-400 text-[10px]">•
                                                                <?= date('M d, Y', strtotime($reply['created_at'])) ?></span>
                                                            <?php if ($reply['user_id'] == $blog['author_id']): ?>
                                                                <span
                                                                    class="bg-primary/10 text-primary text-[9px] px-1.5 py-0.5 rounded uppercase font-bold tracking-wide">Author</span>
                                                            <?php endif; ?>
                                                        </div>
                                                        <p class="text-gray-600 dark:text-gray-300 text-sm leading-relaxed">
                                                            <?= esc($reply['comment']) ?>
                                                        </p>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </section>
        </article>
        <!-- Right Sidebar: Sticky Widgets (4 cols) -->
        <aside class="hidden lg:block lg:col-span-4 relative">
            <div class="sticky top-28 flex flex-col gap-6">
                <!-- Table of Contents -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                    <h4 class="font-bold text-[#111816] dark:text-white mb-4 flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary text-[20px]">format_list_bulleted</span>
                        In this article
                    </h4>
                    <ul id="toc-list"
                        class="space-y-3 relative border-l-2 border-gray-100 dark:border-gray-700 ml-1.5 pl-4 text-sm">
                        <!-- Auto generated -->
                        <li class="text-gray-400 italic">No headings found</li>
                    </ul>
                </div>
                <!-- Social Share -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                    <h4
                        class="font-bold text-[#111816] dark:text-white text-sm uppercase tracking-wider mb-4 text-center">
                        Share this guide</h4>
                    <div class="flex justify-center gap-4">
                        <a href="https://twitter.com/intent/tweet?url=<?= current_url() ?>&text=<?= urlencode($blog['title']) ?>"
                            target="_blank"
                            class="w-10 h-10 rounded-full bg-[#1DA1F2]/10 text-[#1DA1F2] flex items-center justify-center hover:bg-[#1DA1F2] hover:text-white transition-all">
                            <i class="fa-brands fa-x-twitter"></i>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= current_url() ?>" target="_blank"
                            class="w-10 h-10 rounded-full bg-[#1877F2]/10 text-[#1877F2] flex items-center justify-center hover:bg-[#1877F2] hover:text-white transition-all">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= current_url() ?>"
                            target="_blank"
                            class="w-10 h-10 rounded-full bg-[#0A66C2]/10 text-[#0A66C2] flex items-center justify-center hover:bg-[#0A66C2] hover:text-white transition-all">
                            <i class="fa-brands fa-linkedin-in"></i>
                        </a>
                        <button
                            onclick="navigator.clipboard.writeText('<?= current_url() ?>').then(() => alert('Link copied!'))"
                            class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 flex items-center justify-center hover:bg-gray-600 hover:text-white transition-all">
                            <span class="material-symbols-outlined text-[20px]">link</span>
                        </button>
                    </div>
                </div>
                <!-- Related Articles -->
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
                    <h4 class="font-bold text-[#111816] dark:text-white mb-4">Related Articles</h4>
                    <div class="flex flex-col gap-4">
                        <?php if (empty($relatedBlogs)): ?>
                            <p class="text-sm text-gray-400 italic">No related articles found.</p>
                        <?php else: ?>
                            <?php foreach ($relatedBlogs as $rb): ?>
                                <a class="group flex gap-3 items-start"
                                    href="<?= base_url('blog/' . url_title($rb['category'] ?? 'general', '-', true) . '/' . $rb['slug']) ?>">
                                    <div class="w-16 h-16 rounded-lg overflow-hidden flex-shrink-0 bg-gray-100">
                                        <?php
                                        $rbImg = !empty($rb['featured_image']) ? base_url($rb['featured_image']) : 'https://placehold.co/100x100?text=UniHunt';
                                        if (!empty($rb['uni_gallery_image'])) {
                                            $rbImg = (stripos($rb['uni_gallery_image'], 'http') === 0) ? $rb['uni_gallery_image'] : base_url($rb['uni_gallery_image']);
                                        }
                                        ?>
                                        <img src="<?= $rbImg ?>"
                                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                            alt="Related">
                                    </div>
                                    <div class="flex flex-col">
                                        <h5
                                            class="text-xs font-bold text-[#111816] dark:text-white leading-snug group-hover:text-primary transition-colors line-clamp-2">
                                            <?= esc($rb['title']) ?>
                                        </h5>
                                        <span
                                            class="text-[10px] text-gray-400 mt-1"><?= date('M d, Y', strtotime($rb['created_at'])) ?></span>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <a href="<?= base_url('blog') ?>"
                        class="block text-center w-full mt-6 py-2 text-sm font-bold text-[#61897f] hover:text-primary hover:bg-[#f0f4f3] dark:hover:bg-gray-700 rounded-lg transition-colors">
                        View all guides
                    </a>
                </div>
            </div>
        </aside>
    </div>

    <!-- Schema Markup -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "BlogPosting",
      "headline": "<?= esc($blog['title']) ?>",
      "image": [
        "<?= !empty($blog['featured_image']) ? base_url($blog['featured_image']) : 'https://placehold.co/800x450?text=UniHunt+Blog' ?>"
       ],
      "datePublished": "<?= date('c', strtotime($blog['created_at'])) ?>",
      "dateModified": "<?= date('c', strtotime($blog['updated_at'] ?? $blog['created_at'])) ?>",
      "author": [{
          "@type": "Person",
          "name": "<?= esc($blog['author_name'] ?? 'UniHunt Team') ?>",
          "url": "<?= base_url() ?>"
        }],
      "publisher": {
        "@type": "Organization",
        "name": "UniHunt",
        "logo": {
          "@type": "ImageObject",
          "url": "<?= base_url('favicon_io/android-chrome-512x512.webp') ?>"
        }
      },
      "description": "<?= esc(strip_tags(substr($blog['content'], 0, 160))) ?>..."
    }
    </script>

</main>
<!-- Footer -->

<?= view('web/include/footer') ?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // --- 1. Auto-generate Table of Contents ---
        const blogBody = document.getElementById('blog-body');
        const tocList = document.getElementById('toc-list');
        const headings = blogBody.querySelectorAll('h2, h3');

        if (headings.length > 0) {
            tocList.innerHTML = ''; // Clear fallback
            headings.forEach((heading, index) => {
                // Create anchor ID if not present
                const id = 'heading-' + index;
                heading.id = id;

                const li = document.createElement('li');
                li.className = 'relative';
                if (index === 0) {
                    const dot = document.createElement('div');
                    dot.className = 'absolute -left-[19px] top-1.5 h-2 w-2 rounded-full bg-primary ring-4 ring-white dark:ring-gray-800';
                    li.appendChild(dot);
                }

                const a = document.createElement('a');
                a.href = '#' + id;
                a.textContent = heading.textContent;
                a.className = index === 0 ? 'text-primary font-bold' : 'text-gray-500 dark:text-gray-400 hover:text-primary transition-colors';

                li.appendChild(a);
                tocList.appendChild(li);
            });
        }

        // --- 2. Smooth Scroll for TOC ---
        document.querySelectorAll('#toc-list a').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const targetId = this.getAttribute('href').substring(1);
                const targetElement = document.getElementById(targetId);
                const offset = 100; // Account for sticky header
                const elementPosition = targetElement.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - offset;

                window.scrollTo({
                    top: offsetPosition,
                    behavior: "smooth"
                });
            });
        });
        // --- 3. Comment Reply Logic ---
        window.replyTo = function (commentId, userName) {
            document.getElementById('parent-id-input').value = commentId;
            document.getElementById('replying-to-name').textContent = userName;

            const banner = document.getElementById('replying-to-banner');
            banner.classList.remove('hidden');
            banner.classList.add('inline-flex');

            // Scroll to form
            document.getElementById('comment-form-container').scrollIntoView({ behavior: 'smooth' });
        };

        window.cancelReply = function () {
            document.getElementById('parent-id-input').value = '';
            document.getElementById('replying-to-name').textContent = '';

            const banner = document.getElementById('replying-to-banner');
            banner.classList.add('hidden');
            banner.classList.remove('inline-flex');
        };
    });
</script>