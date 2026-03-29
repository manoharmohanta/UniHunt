<?php

namespace App\Models;

use CodeIgniter\Model;

class UniversityRequirementModel extends Model
{
    protected $table            = 'university_requirements';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['university_id', 'parameter_id', 'value'];

    // Dates
    protected $useTimestamps = false;
}
