<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Libraries\AdService;

class AdController extends BaseController
{
    public function fetch()
    {
        $placement = $this->request->getGet('placement');

        if (!$placement) {
            return $this->response->setStatusCode(400)->setJSON(['error' => 'Placement required']);
        }

        $service = new AdService();
        $ad = $service->getAd($placement);

        if ($ad) {
            // Process Ad Content if it's JSON (Direct)
            if ($ad['source_type'] === 'direct') {
                $ad['ad_content'] = json_decode($ad['ad_content'] ?? '{}', true);
            }
            // If network, ad_content is string (script)

            // Return stripped data for security/privacy
            return $this->response->setJSON([
                'found' => true,
                'id' => $ad['id'],
                'type' => $ad['source_type'],
                'format' => $ad['format'],
                'content' => $ad['ad_content']
            ]);
        }

        return $this->response->setJSON(['found' => false]);
    }

    public function track_impression($id)
    {
        $model = new \App\Models\AdsModel();
        // Increment impression in DB
        // Use query builder for atomic update
        $db = \Config\Database::connect();
        $db->table('ads')->where('id', $id)->increment('impressions');

        // Update session frequency
        $session = session();
        $seenKey = 'ad_seen_' . $id;
        $count = $session->get($seenKey) ?? 0;
        $session->set($seenKey, $count + 1);

        return $this->response->setJSON(['status' => 'ok']);
    }

    public function track_click($id)
    {
        $db = \Config\Database::connect();
        $db->table('ads')->where('id', $id)->increment('clicks');
        return $this->response->setJSON(['status' => 'ok']);
    }
}
