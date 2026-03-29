<?php

namespace App\Models;

use CodeIgniter\Model;

class CountryModel extends Model
{
    protected $table = 'countries';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'code',
        'name',
        'slug',
        'currency',
        'living_cost_min',
        'living_cost_max',
        'gic_amount',
        'created_at'
    ];

    // Dates
    protected $useTimestamps = false;
}
