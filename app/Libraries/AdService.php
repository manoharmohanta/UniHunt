<?php

namespace App\Libraries;

use App\Models\AdsModel;

class AdService
{
    protected $adsModel;
    protected $user;

    public function __construct()
    {
        $this->adsModel = new AdsModel();
        // Load current user from session if available
        $this->user = session()->get('user') ?? null;
    }

    /**
     * Get an ad for a specific placement.
     * 
     * @param string $placement e.g. 'home_top', 'dashboard_sidebar'
     * @param array $context Contextual data (e.g. ['page' => 'score'])
     * @return array|null Ad data or null
     */
    public function getAd(string $placement, array $context = [])
    {
        // 1. Fetch Active Ads for Placement
        $ads = $this->adsModel->where('status', 'active')
            ->where('placement', $placement)
            ->orderBy('id', 'RANDOM') // Database-specific rotation handled natively by CI4
            ->findAll();

        if (empty($ads)) {
            return null;
        }

        // 2. Filter by Targeting
        foreach ($ads as $ad) {
            if ($this->checkTargeting($ad, $context) && $this->checkFrequency($ad)) {
                // Record Impression (async - simplistic here, normally done via separate pixel/call)
                // In this architecture, impression counting happens via frontend pixel after render.
                return $ad;
            }
        }

        return null;
    }

    protected function checkTargeting($ad, $context)
    {
        $targeting = json_decode($ad['targeting'] ?? '{}', true);

        // Role Check
        $allowedRoles = $targeting['role'] ?? [];
        if (!empty($allowedRoles)) {
            $currentRole = $this->user ? ($this->user['role_id'] == 1 ? 'admin' : 'student') : 'guest';
            // Assuming role_id 1=admin, 2=student in simple terms, or just custom logic.
            // Using 'student' and 'guest' mapping.
            if (!in_array($currentRole, $allowedRoles)) {
                return false;
            }
        }

        // Country Check (if implemented via GEOIP)
        // $allowedCountries = $targeting['country'] ?? [];
        // if (!empty($allowedCountries)) {
        //    $userCountry = service('request')->getIPAddress(); // Logic needed
        //    if (!in_array($userCountry, $allowedCountries)) return false;
        // }

        return true;
    }

    /**
     * Check Frequency Capping (Session based)
     */
    protected function checkFrequency($ad)
    {
        $caps = json_decode($ad['frequency_capping'] ?? '{}', true);
        $maxImpressions = $caps['max_impressions'] ?? 0;

        if ($maxImpressions > 0) {
            $session = session();
            $seenKey = 'ad_seen_' . $ad['id'];
            $count = $session->get($seenKey) ?? 0;

            if ($count >= $maxImpressions) {
                return false;
            }
        }

        return true;
    }
}
