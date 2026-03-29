<?php

namespace App\Models;

use CodeIgniter\Model;

class CountryRequirementModel extends Model
{
    protected $table            = 'country_requirements';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['country_id', 'parameter_id', 'value', 'is_mandatory'];

    // Dates
    protected $useTimestamps = false;
}
