<?php

namespace App\Libraries;

use App\Models\AiToolModel;
use App\Models\CouponModel;
use App\Models\SiteConfigModel;

class PaymentService
{
    protected $db;
    protected $config;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->config = $this->loadSiteSettings();
    }

    private function loadSiteSettings()
    {
        $builder = $this->db->table('site_config');
        $configs = $builder->get()->getResultArray();
        $settings = [];
        foreach ($configs as $c) {
            $val = $c['config_value'];
            $decoded = json_decode($val, true);
            $settings[$c['config_key']] = (json_last_error() === JSON_ERROR_NONE) ? $decoded : trim($val, '"\' ');
        }
        return $settings;
    }

    /**
     * Check if payments are enabled globally.
     */
    public function isPaymentEnabled()
    {
        return ($this->config['payments_enabled'] ?? '0') === '1';
    }

    /**
     * Calculate final price after applying coupon.
     */
    public function calculateFinalPrice(int $toolId, ?string $couponCode = null, ?int $userId = null)
    {
        $toolModel = new AiToolModel();
        $tool = $toolModel->find($toolId);

        if (!$tool) {
            return ['error' => 'Tool not found'];
        }

        $originalPrice = (float) ($tool['price'] ?? 0);
        $finalPrice = $originalPrice;
        $discountAmount = 0;
        $couponId = null;

        if (!$this->isPaymentEnabled()) {
            return [
                'original_price' => $originalPrice,
                'final_price' => 0,
                'discount_amount' => $originalPrice,
                'status' => 'free'
            ];
        }

        if ($originalPrice <= 0) {
            return [
                'original_price' => $originalPrice,
                'final_price' => 0,
                'discount_amount' => 0,
                'status' => 'free'
            ];
        }

        if ($couponCode) {
            $couponModel = new CouponModel();
            $coupon = $couponModel->where('code', $couponCode)
                ->where('status', 'active')
                ->groupStart()
                ->where('starts_at <=', date('Y-m-d H:i:s'))
                ->orWhere('starts_at', null)
                ->groupEnd()
                ->groupStart()
                ->where('expires_at >=', date('Y-m-d H:i:s'))
                ->orWhere('expires_at', null)
                ->groupEnd()
                ->first();

            if ($coupon) {
                // Check usage limits
                if ($coupon['usage_limit'] && $coupon['usage_count'] >= $coupon['usage_limit']) {
                    return ['error' => 'Coupon usage limit reached'];
                }

                if ($userId && $coupon['usage_limit_per_user']) {
                    $usedCount = $this->db->table('coupon_usage')
                        ->where('coupon_id', $coupon['id'])
                        ->where('user_id', $userId)
                        ->countAllResults();
                    if ($usedCount >= $coupon['usage_limit_per_user']) {
                        return ['error' => 'You have already used this coupon'];
                    }
                }

                // Check min purchase
                if ($originalPrice < $coupon['min_purchase_amount']) {
                    return ['error' => 'Minimum purchase amount not met'];
                }

                // Apply discount
                if ($coupon['discount_type'] === 'percentage') {
                    $discountAmount = ($originalPrice * (float) $coupon['discount_value']) / 100;
                    if ($coupon['max_discount_amount'] && $discountAmount > $coupon['max_discount_amount']) {
                        $discountAmount = (float) $coupon['max_discount_amount'];
                    }
                } else {
                    $discountAmount = (float) $coupon['discount_value'];
                }

                $finalPrice = max(0, $originalPrice - $discountAmount);
                $couponId = $coupon['id'];
            } else {
                return ['error' => 'Invalid or expired coupon code'];
            }
        }

        return [
            'original_price' => $originalPrice,
            'final_price' => round($finalPrice, 2),
            'discount_amount' => round($discountAmount, 2),
            'coupon_id' => $couponId,
            'status' => $finalPrice <= 0 ? 'waived' : 'pending'
        ];
    }

    public function getRazorpayKey()
    {
        $isLiveMode = ($this->config['razorpay_live_mode'] ?? '0') === '1';

        if ($isLiveMode) {
            $keyId = $this->config['razorpay_live_key_id'] ?? '';
            return empty($keyId) ? env('razorpay_key_live') : $keyId;
        } else {
            $keyId = $this->config['razorpay_key_id'] ?? '';
            return empty($keyId) ? env('razorpay_key') : $keyId;
        }
    }

    /**
     * Create Razorpay Order
     */
    public function createRazorpayOrder(float $amount, string $receiptId)
    {
        $isLiveMode = ($this->config['razorpay_live_mode'] ?? '0') === '1';

        if ($isLiveMode) {
            $keyId = $this->config['razorpay_live_key_id'] ?? '';
            if (empty($keyId)) {
                $keyId = env('razorpay_key_live');
            }

            $keySecret = $this->config['razorpay_live_key_secret'] ?? '';
            if (empty($keySecret)) {
                $keySecret = env('razorpay_secret_live');
            }
        } else {
            $keyId = $this->config['razorpay_key_id'] ?? '';
            if (empty($keyId)) {
                $keyId = env('razorpay_key');
            }

            $keySecret = $this->config['razorpay_key_secret'] ?? '';
            if (empty($keySecret)) {
                $keySecret = env('razorpay_secret');
            }
        }

        if (empty($keyId) || empty($keySecret)) {
            return ['error' => 'Razorpay keys not configured'];
        }

        $api = "https://api.razorpay.com/v1/orders";
        $data = [
            'amount' => $amount * 100, // in paise
            'currency' => 'INR',
            'receipt' => $receiptId,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api);
        curl_setopt($ch, CURLOPT_USERPWD, $keyId . ":" . $keySecret);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

        $response = curl_exec($ch);
        $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $result = json_decode($response, true);

        if ($httpStatus !== 200) {
            return ['error' => 'Razorpay Error: ' . ($result['error']['description'] ?? 'Unknown error')];
        }

        return $result;
    }

    /**
     * Verify Razorpay Payment Signature
     */
    public function verifySignature($orderId, $paymentId, $signature)
    {
        $isLiveMode = ($this->config['razorpay_live_mode'] ?? '0') === '1';

        if ($isLiveMode) {
            $keySecret = $this->config['razorpay_live_key_secret'] ?? '';
            if (empty($keySecret)) {
                $keySecret = env('razorpay_secret_live');
            }
        } else {
            $keySecret = $this->config['razorpay_key_secret'] ?? '';
            if (empty($keySecret)) {
                $keySecret = env('razorpay_secret');
            }
        }
        $generatedSignature = hash_hmac('sha256', $orderId . "|" . $paymentId, $keySecret);
        return $generatedSignature === $signature;
    }

    /**
     * Record Coupon Usage
     */
    public function recordCouponUsage(int $couponId, int $userId, float $discountAmount, $orderId = null)
    {
        $this->db->table('coupon_usage')->insert([
            'coupon_id' => $couponId,
            'user_id' => $userId,
            'discount_amount' => $discountAmount,
            'order_id' => $orderId,
            'used_at' => date('Y-m-d H:i:s')
        ]);

        $this->db->table('coupons')->where('id', $couponId)->increment('usage_count');
    }
}
