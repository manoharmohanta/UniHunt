<?php

namespace App\Models;

use CodeIgniter\Model;

class ExchangeRateModel extends Model
{
    protected $table            = 'exchange_rates';
    protected $primaryKey       = 'currency';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['currency', 'rate_to_usd', 'updated_at'];

    // Dates
    protected $useTimestamps = false;
}
