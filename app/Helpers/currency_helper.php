<?php

use App\Models\ExchangeRateModel;
use App\Models\IpCacheModel;
use CodeIgniter\I18n\Time;

if (!function_exists('get_user_currency')) {
    /**
     * Detects user's currency based on Session or IP.
     * Caches result in Session and Database.
     * 
     * @return string Currency code (e.g. 'USD', 'INR')
     */
    function get_user_currency()
    {
        $session = session();

        // 1. Check Session
        if ($session->has('user_currency')) {
            return $session->get('user_currency');
        }

        $ip = service('request')->getIPAddress();

        // Localhost fallback
        if ($ip === '::1' || $ip === '127.0.0.1') {
            $session->set('user_currency', 'USD');
            return 'USD';
        }

        // 2. Check Database Cache
        $ipCacheModel = new IpCacheModel();
        $cached = $ipCacheModel->where('ip_address', $ip)->first();

        if ($cached) {
            $currency = $cached['currency'] ?: 'USD';
            $session->set('user_currency', $currency);
            return $currency;
        }

        // 3. Call API (ip-api.com)
        // Rate limit handling is not implemented here but ip-api allows 45 requests per minute.
        $client = \Config\Services::curlrequest();

        try {
            $response = $client->get("http://ip-api.com/json/{$ip}?fields=status,countryCode,currency");
            $data = json_decode($response->getBody(), true);

            if (isset($data['status']) && $data['status'] === 'success') {
                $currency = $data['currency'] ?? 'USD';
                $countryCode = $data['countryCode'] ?? null;

                // 4. Save to Cache
                $ipCacheModel->insert([
                    'ip_address' => $ip,
                    'country_code' => $countryCode,
                    'currency' => $currency,
                    'created_at' => date('Y-m-d H:i:s')
                ]);

                $session->set('user_currency', $currency);
                return $currency;
            }
        } catch (\Exception $e) {
            log_message('error', 'IP API Error: ' . $e->getMessage());
        }

        // Fallback
        $session->set('user_currency', 'USD');
        return 'USD';
    }
}

if (!function_exists('convert_currency')) {
    /**
     * Converts amount from one currency to another.
     * 
     * @param float $amount
     * @param string $fromCurrency
     * @param string $toCurrency
     * @return float|null Returns null if rate not found
     */
    function convert_currency($amount, $fromCurrency, $toCurrency)
    {
        if ($fromCurrency === $toCurrency) {
            return $amount;
        }

        $rateModel = new ExchangeRateModel();

        // Get rates (relative to USD)
        // 1 USD = X FromCurrency
        // 1 USD = Y ToCurrency

        $fromRate = ($fromCurrency === 'USD') ? 1.0 : 0;
        $toRate = ($toCurrency === 'USD') ? 1.0 : 0;

        if ($fromCurrency !== 'USD') {
            $r = $rateModel->find($fromCurrency);
            if ($r)
                $fromRate = (float) $r['rate_to_usd'];
        }

        if ($toCurrency !== 'USD') {
            $r = $rateModel->find($toCurrency);
            if ($r)
                $toRate = (float) $r['rate_to_usd'];
        }

        if ($fromRate <= 0 || $toRate <= 0) {
            return null; // Conversion impossible
        }

        // Convert From -> USD
        $usdAmount = $amount / $fromRate;

        // Convert USD -> To
        $finalAmount = $usdAmount * $toRate;

        return $finalAmount;
    }
}

if (!function_exists('format_currency_price')) {
    /**
     * Formats price with symbol.
     */
    function format_currency_price($amount, $currency)
    {
        $fmt = new \NumberFormatter('en_US', \NumberFormatter::CURRENCY);
        // We set pattern explicitly or just let it handle it. 
        // Ideally we want the symbol of the requested currency.
        // setTextAttribute might be needed for some specific display needs but 
        // formatCurrency should usually work.

        return $fmt->formatCurrency($amount, $currency);
    }
}
