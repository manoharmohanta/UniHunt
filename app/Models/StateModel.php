<?php

namespace App\Models;

use CodeIgniter\Model;

class StateModel extends Model
{
    protected $table            = 'states';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['country_id', 'name'];

    // Dates
    protected $useTimestamps = false;
}
