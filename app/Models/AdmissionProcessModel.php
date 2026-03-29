<?php

namespace App\Models;

use CodeIgniter\Model;

class AdmissionProcessModel extends Model
{
    protected $table            = 'admission_processes';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'country_id',
        'version',
        'steps',
        'effective_from',
        'effective_to'
    ];

    // Dates
    protected $useTimestamps = false;
}
