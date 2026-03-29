<?php

namespace App\Models;

use CodeIgniter\Model;

class AiSearchHistoryModel extends Model
{
    protected $table            = 'ai_search_history';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'tool_type', 'search_params', 'result_id', 'created_at'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
}
