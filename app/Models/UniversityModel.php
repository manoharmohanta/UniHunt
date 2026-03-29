<?php

namespace App\Models;

use CodeIgniter\Model;

class UniversityModel extends Model
{
    protected $table = 'universities';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'country_id',
        'state_id',
        'name',
        'slug',
        'type',
        'website',
        'ranking',
        'stem_available',
        'classification',
        'tuition_fee_min',
        'tuition_fee_max',
        'metadata',
        'created_at'
    ];

    // Dates
    protected $useTimestamps = false;
}
