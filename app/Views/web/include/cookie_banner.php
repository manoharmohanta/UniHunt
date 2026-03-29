<div id="cookie-banner"
    class="fixed bottom-0 left-0 right-0 z-[60] p-4 bg-white dark:bg-[#202428] border-t border-gray-200 dark:border-gray-700 shadow-[0_-4px_20px_rgb(0,0,0,0.1)] transition-transform duration-300"
    style="transform: translateY(100%); display: none;"> 
    <!-- Added inline style for initial state to be sure -->
    <div class="max-w-[1280px] mx-auto flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="flex-1">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">We value your privacy</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                We use cookies to enhance your experience, analyze site traffic, and deliver personalized content. By
                clicking "Accept All", you consent to our use of cookies.
                <a href="<?= base_url('privacy') ?>" class="text-primary hover:underline ml-1">Privacy Policy</a>
            </p>
        </div>
        <div class="flex flex-col sm:flex-row gap-3 min-w-max">
            <button id="btn-reject-cookies" type="button"
                class="px-6 py-2.5 text-sm font-semibold text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-colors cursor-pointer">
                Reject All
            </button>
            <button id="btn-accept-cookies" type="button"
                class="px-6 py-2.5 text-sm font-bold text-white bg-primary hover:bg-primary-hover shadow-lg shadow-primary/20 hover:shadow-primary/30 rounded-lg transition-all transform hover:-translate-y-0.5 cursor-pointer">
                Accept All
            </button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const banner = document.getElementById('cookie-banner');
        const btnAccept = document.getElementById('btn-accept-cookies');
        const btnReject = document.getElementById('btn-reject-cookies');

        // Force hide function using direct style
        function hideBanner() {
            if (banner) {
                banner.style.transform = 'translateY(100%)';
                // Wait for transition then fully hide
                setTimeout(() => {
                    banner.style.display = 'none';
                }, 300);
            }
        }

        // Force show function
        function showBanner() {
            if (banner) {
                banner.style.display = 'block';
                // Small delay to allow display:block to render before transforming
                setTimeout(() => {
                    banner.style.transform = 'translateY(0)';
                }, 10);
            }
        }

        if (btnAccept) {
            btnAccept.addEventListener('click', function(e) {
                e.preventDefault(); // Prevent any default button behavior
                console.log('Accept clicked'); // Debugging
                localStorage.setItem('cookieConsent', 'accepted');
                hideBanner();
            });
        }

        if (btnReject) {
            btnReject.addEventListener('click', function(e) {
                e.preventDefault();
                console.log('Reject clicked'); // Debugging
                localStorage.setItem('cookieConsent', 'rejected');
                hideBanner();
            });
        }

        // Logic check
        if (!localStorage.getItem('cookieConsent')) {
            setTimeout(showBanner, 1000);
        } else {
            // Ensure functionality for "settings" link even if consented
        }

        // Re-open logic
        const settingsLinks = document.querySelectorAll('a[href*="cookies"]');
        settingsLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                showBanner();
            });
        });
    });
</script>