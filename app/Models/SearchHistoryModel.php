<?php

namespace App\Models;

use CodeIgniter\Model;

class SearchHistoryModel extends Model
{
    protected $table            = 'search_history';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'query', 'filters', 'created_at'];

    // Dates
    protected $useTimestamps = false;
}
