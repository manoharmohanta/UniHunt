<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\VisitorModel;

class VisitorTrackerFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Cast to IncomingRequest to access helper methods
        if (!$request instanceof \CodeIgniter\HTTP\IncomingRequest) {
            return;
        }

        // Don't track in admin or for AJAX/Internal requests if necessary
        if (strpos($request->getUri()->getPath(), 'admin') === 0 || $request->isAJAX()) {
            return;
        }

        $visitorModel = new VisitorModel();
        $ip = $request->getIPAddress();
        $ua = $request->getUserAgent();

        // Basic Session-based throttling (track once per session day)
        $session = session();
        $lastTracked = $session->get('last_tracked_date');
        $today = date('Y-m-d');

        if ($lastTracked !== $today) {
            $country = 'Unknown';

            // Try to get country via GeoIP (Mocked for localhost, or use a free API)
            // Note: In production, you'd use a local database (like MaxMind) for performance
            if ($ip !== '127.0.0.1' && $ip !== '::1') {
                try {
                    $ch = curl_init("http://ip-api.com/json/{$ip}?fields=status,country,countryCode");
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_TIMEOUT, 2);
                    $response = curl_exec($ch);
                    curl_close($ch);
                    $geo = json_decode($response, true);
                    if ($geo && $geo['status'] === 'success') {
                        $country = $geo['country'];
                    }
                } catch (\Exception $e) {
                    // Silently fail
                }
            } else {
                // For local testing, randomize countries
                $mocks = ['United States', 'India', 'United Kingdom', 'Canada', 'Australia', 'Germany'];
                $country = $mocks[array_rand($mocks)];
            }

            $visitorModel->insert([
                'ip_address' => $ip,
                'country' => $country,
                'user_agent' => (string) $ua,
                'visited_at' => date('Y-m-d H:i:s')
            ]);

            $session->set('last_tracked_date', $today);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}
