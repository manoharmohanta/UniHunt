<?php

namespace App\Models;

use CodeIgniter\Model;

class VisaTypeModel extends Model
{
    protected $table            = 'visa_types';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['country_id', 'name'];

    // Dates
    protected $useTimestamps = false;
}
