/**
 * UniAds - Ad Client SDK
 * Handles fetching, rendering, and tracking of ads.
 */
const UniAds = {
    config: {
        baseUrl: (function () {
            console.log('UniAds: Initializing (v1.1)...');
            // Priority 1: Global Config from header
            if (window.UniHunt && window.UniHunt.apiUrl) {
                const apiBase = window.UniHunt.apiUrl + '/ads';
                console.log('UniAds: Found window.UniHunt.apiUrl ->', apiBase);
                return apiBase;
            }

            // Priority 2: Detect from current script source
            const script = document.currentScript || document.querySelector('script[src*="ads.js"]');
            if (script && script.src) {
                try {
                    const url = new URL(script.src, window.location.href);
                    console.log('UniAds: Detecting base from script source:', url.pathname);
                    const pathParts = url.pathname.split('/');
                    // We expect something like /unisearch/assets/js/ads.js
                    // Remove 'assets/js/ads.js' (last 3 segments)
                    const baseParts = pathParts.slice(0, pathParts.length - 3);
                    const detectedBase = baseParts.join('/') + '/api/ads';
                    console.log('UniAds: Final detected base ->', detectedBase);
                    return detectedBase;
                } catch (e) {
                    console.error('UniAds: Error parsing script URL ->', e);
                }
            }

            // Fallback: Absolute path (often fails in subdirectories)
            console.warn('UniAds: Falling back to default /api/ads');
            return '/api/ads';
        })(),
    },

    /**
     * Initialize ad units on the page.
     * Looks for elements with class 'uni-ad-slot' and data-placement attribute.
     */
    init: function () {
        const slots = document.querySelectorAll('.uni-ad-slot');
        slots.forEach(slot => {
            const placement = slot.dataset.placement;
            if (placement) {
                this.loadAd(slot, placement);
            }
        });
    },

    loadAd: async function (container, placement) {
        try {
            const url = `${this.config.baseUrl}/fetch?placement=${placement}`;
            console.log('UniAds: Fetching ad from', url);
            const response = await fetch(url);

            if (!response.ok) {
                console.error('UniAds: API returned status', response.status);
                container.style.display = 'none';
                return;
            }

            const data = await response.json();

            if (data.found) {
                this.renderAd(container, data);
            } else {
                // Collapse slot or show fallback (e.g. house ad handled by CSS)
                container.style.display = 'none';
            }
        } catch (error) {
            console.error('UniAds: Failed to load ad', error);
            container.style.display = 'none';
        }
    },

    renderAd: function (container, ad) {
        // Clear container
        container.innerHTML = '';
        container.classList.remove('hidden');

        let html = '';

        // Network Ad vs Direct Ad Styling
        let aspectStyle = 'aspect-ratio: 3/1;';
        if (ad.placement === 'home_top') aspectStyle = 'aspect-ratio: 21/9; max-height: 400px;';
        else if (ad.placement === 'university_sidebar') aspectStyle = 'aspect-ratio: 1/1; max-height: 400px;';
        else if (ad.placement === 'dashboard_main') aspectStyle = 'aspect-ratio: 4/1; max-height: 250px;';
        else if (ad.placement === 'score_page') aspectStyle = 'aspect-ratio: 4/1; max-height: 200px;';
        else if (ad.placement === 'course_list') aspectStyle = 'aspect-ratio: 1/1; max-height: 400px; width: 100%; display: flex; align-items: center; justify-content: center; overflow: hidden;';
        else if (ad.placement === 'course_requirements_bottom') aspectStyle = 'aspect-ratio: 1/1; max-height: 400px;';

        if (ad.type === 'direct') {
            const content = ad.content;
            // Native/Banner Template for Direct Ads
            if (ad.format === 'native') {
                html = `
                    <div class="uni-ad-native bg-white border border-slate-200 rounded-lg p-4 flex items-center gap-4 relative overflow-hidden group">
                        <div class="absolute top-0 right-0 bg-slate-100 text-[10px] text-slate-500 px-2 py-0.5 rounded-bl">Sponsored</div>
                        <img src="${(window.UniHunt ? window.UniHunt.baseUrl : '') + '/' + content.image_url}" class="h-16 w-16 object-cover rounded-md" alt="Ad">
                        <div class="flex-1">
                            <h4 class="font-bold text-slate-900 text-sm mb-1">${ad.title || 'Recommended'}</h4>
                            <p class="text-xs text-slate-500 mb-2 truncate">${content.cta_text || 'Learn more about this opportunity'}</p>
                            <a href="${content.link_url}" target="_blank" onclick="UniAds.trackClick(${ad.id})" class="inline-block text-xs font-semibold text-indigo-600 hover:text-indigo-700">
                                ${content.cta_text || 'Learn More'} &rarr;
                            </a>
                        </div>
                    </div>
                `;
            } else {
                html = `
                    <div class="uni-ad-banner relative group w-full overflow-hidden rounded-lg bg-slate-100 dark:bg-slate-800" style="${aspectStyle}">
                        <span class="absolute top-0 right-0 bg-black/40 text-white text-[10px] px-2 py-0.5 z-10 rounded-bl-lg font-medium backdrop-blur-sm shadow-sm">Ad</span>
                        <a href="${content.link_url}" target="_blank" onclick="UniAds.trackClick(${ad.id})" class="block w-full h-full">
                            <img src="${(window.UniHunt ? window.UniHunt.baseUrl : '') + '/' + content.image_url}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" alt="Advertisement">
                        </a>
                    </div>
                `;
            }
        } else {
            // Container constraints for network network ads
            container.setAttribute('style', aspectStyle);
            container.classList.add('relative', 'overflow-hidden', 'rounded-lg', 'bg-slate-50', 'dark:bg-slate-800/50');

            // Script check
            if (ad.content.trim().toLowerCase().startsWith('<script')) {
                const range = document.createRange();
                range.setStart(container, 0);
                container.appendChild(range.createContextualFragment(ad.content));
            } else {
                html = ad.content;
            }
        }

        if (html) container.innerHTML = html;

        // Track Impression
        this.trackImpression(ad.id);
    },

    trackImpression: function (id) {
        fetch(`${this.config.baseUrl}/track-impression/${id}`, { method: 'POST' });
    },

    trackClick: function (id) {
        fetch(`${this.config.baseUrl}/track-click/${id}`, { method: 'POST' });
    }
};

// Auto-init on DOM Ready
document.addEventListener('DOMContentLoaded', () => {
    UniAds.init();
});
