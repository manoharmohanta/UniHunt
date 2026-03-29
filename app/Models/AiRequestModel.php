<?php

namespace App\Models;

use CodeIgniter\Model;

class AiRequestModel extends Model
{
    protected $table            = 'ai_requests';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'tool_id',
        'payment_status',
        'razorpay_order_id',
        'razorpay_payment_id',
        'final_amount',
        'coupon_code',
        'input_data',
        'output_data',
        'created_at'
    ];

    // Dates
    protected $useTimestamps = false;
}
