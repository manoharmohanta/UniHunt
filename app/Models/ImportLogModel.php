<?php

namespace App\Models;

use CodeIgniter\Model;

class ImportLogModel extends Model
{
    protected $table            = 'import_logs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['entity', 'total', 'success', 'failed', 'created_at'];

    // Dates
    protected $useTimestamps = false;
}
