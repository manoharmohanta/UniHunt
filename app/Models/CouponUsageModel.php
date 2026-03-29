<?php

namespace App\Models;

use CodeIgniter\Model;

class CouponUsageModel extends Model
{
    protected $table = 'coupon_usage';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'coupon_id',
        'user_id',
        'order_id',
        'discount_amount',
        'used_at',
    ];

    protected $useTimestamps = false;
}
