<?php

namespace App\Models;

use CodeIgniter\Model;

class SiteConfigModel extends Model
{
    protected $table            = 'site_config';
    protected $primaryKey       = 'config_key';
    protected $useAutoIncrement = false;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['config_key', 'config_value'];

    // Dates
    protected $useTimestamps = false;
}
