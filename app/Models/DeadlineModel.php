<?php

namespace App\Models;

use CodeIgniter\Model;

class DeadlineModel extends Model
{
    protected $table = 'deadlines';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'entity_type',
        'entity_id',
        'intake',
        'deadline_type',
        'deadline_date',
        'is_rolling',
        'notes',
        'created_at',
    ];

    protected $useTimestamps = false;
}
