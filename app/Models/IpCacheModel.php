<?php

namespace App\Models;

use CodeIgniter\Model;

class IpCacheModel extends Model
{
    protected $table = 'ip_cache';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['ip_address', 'country_code', 'currency', 'created_at'];
    protected $useTimestamps = false;
}
