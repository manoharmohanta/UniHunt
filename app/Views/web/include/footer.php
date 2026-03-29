<footer class="bg-white dark:bg-card-dark border-t border-gray-100 dark:border-gray-800 pt-16 pb-8">
    <div class="max-w-[1280px] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-8 mb-12">
            <div class="col-span-2 lg:col-span-2 pr-8">
                <div class="flex items-center gap-2 mb-4">
                    <img src="<?= base_url('favicon_io/android-chrome-512x512.webp') ?>"
                        class="w-10 h-10 object-contain" alt="UniHunt Logo">
                    <span class="text-2xl font-black tracking-tighter uppercase">
                        <span class="text-primary dark:text-white">UNI</span><span class="text-secondary">HUNT</span>
                    </span>
                </div>
                <p class="text-text-muted text-sm leading-relaxed mb-6 max-w-xs">
                    Unihunt helping students discover the best universities worldwide. With
                    an easy-to-use interface, it provides detailed university information, admission requirements, and
                    expert guidance. Find your ideal program quickly and efficiently.
                </p>
                <div class="flex gap-4">
                    <a class="text-gray-400 hover:text-primary transition-colors" href="#"><span
                            class="sr-only">Twitter</span>
                        <svg aria-hidden="true" class="h-5 w-5" fill="currentColor" viewbox="0 0 24 24">
                            <path
                                d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84">
                            </path>
                        </svg>
                    </a>
                    <a class="text-gray-400 hover:text-primary transition-colors" href="#"><span
                            class="sr-only">LinkedIn</span>
                        <svg aria-hidden="true" class="h-5 w-5" fill="currentColor" viewbox="0 0 24 24">
                            <path clip-rule="evenodd"
                                d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"
                                fill-rule="evenodd"></path>
                        </svg>
                    </a>
                </div>
            </div>
            <div>
                <h3 class="font-bold text-text-main dark:text-white mb-4">Platform</h3>
                <ul class="space-y-3 text-sm text-text-muted">
                    <li><a class="hover:text-primary transition-colors" href="<?= base_url('universities') ?>">Browse
                            Universities</a></li>
                    <li><a class="hover:text-primary transition-colors" href="<?= base_url('study-in-usa') ?>">Study in
                            USA</a></li>
                    <li><a class="hover:text-primary transition-colors" href="<?= base_url('study-in-uk') ?>">Study in
                            UK</a></li>
                    <li><a class="hover:text-primary transition-colors" href="<?= base_url('study-in-canada') ?>">Study
                            in Canada</a></li>
                    <li><a class="hover:text-primary transition-colors"
                            href="<?= base_url('study-in-australia') ?>">Study in Australia</a></li>
                    <li><a class="hover:text-primary transition-colors" href="<?= base_url('study-in-germany') ?>">Study
                            in Germany</a></li>
                    <!-- <li><a class="hover:text-primary transition-colors"
                            href="<?= base_url('scholarships') ?>">Scholarships</a>
                    </li> -->
                    <li><a class="hover:text-primary transition-colors" href="<?= base_url('events') ?>">Events</a></li>
                </ul>
            </div>
            <div>
                <h3 class="font-bold text-text-main dark:text-white mb-4">Resources</h3>
                <ul class="space-y-3 text-sm text-text-muted">
                    <li><a class="hover:text-primary transition-colors" href="<?= base_url('blog') ?>">Blog</a></li>
                    <li><a class="hover:text-primary transition-colors" href="<?= base_url('sop-generator') ?>">SOP
                            Generator</a></li>
                    <li><a class="hover:text-primary transition-colors"
                            href="<?= base_url('ai-tools/resume-builder-form') ?>">Resume
                            Builder</a></li>
                    <li><a class="hover:text-primary transition-colors" href="<?= base_url('visa-checker') ?>">Visa
                            Checker</a></li>
                    <li><a class="hover:text-primary transition-colors"
                            href="<?= base_url('university-counsellor') ?>">Uni Counsellor</a></li>
                    <li><a class="hover:text-primary transition-colors" href="<?= base_url('blog/guides') ?>">Student
                            Guides</a></li>
                </ul>
            </div>
            <div>
                <h3 class="font-bold text-text-main dark:text-white mb-4">Company</h3>
                <ul class="space-y-3 text-sm text-text-muted">
                    <li><a class="hover:text-primary transition-colors" href="<?= base_url('about') ?>">About Us</a>
                    </li>
                    <li><a class="hover:text-primary transition-colors" href="#">Careers</a></li>
                    <li><a class="hover:text-primary transition-colors" href="<?= base_url('partnership') ?>">Partner
                            with us</a>
                    </li>
                    <li><a class="hover:text-primary transition-colors" href="<?= base_url('contact') ?>">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
        <div
            class="border-t border-gray-100 dark:border-gray-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-text-muted">
            <p>© 2026 UniHunt Inc. All rights reserved.</p>
            <div class="flex gap-6">
                <a class="hover:text-text-main transition-colors" href="<?= base_url('privacy') ?>">Privacy Policy</a>
                <a class="hover:text-text-main transition-colors" href="<?= base_url('terms') ?>">Terms of Service</a>
                <a class="hover:text-text-main transition-colors" href="<?= base_url('refund-policy') ?>">No Refund
                    Policy</a>
                <a class="hover:text-text-main transition-colors" href="<?= base_url('cookies') ?>">Cookie Settings</a>
            </div>
        </div>
    </div>
</footer>
<?= view('web/include/cookie_banner') ?>
<script src="<?= base_url('assets/js/ads.js?v=' . time()) ?>"></script>
</body>

</html>