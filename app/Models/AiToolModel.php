<?php

namespace App\Models;

use CodeIgniter\Model;

class AiToolModel extends Model
{
    protected $table = 'ai_tools';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['name', 'description', 'price', 'created_at', 'updated_at'];

    // Dates
    protected $useTimestamps = true;
}
