<?php

namespace App\Models;

use CodeIgniter\Model;

class MockAttemptModel extends Model
{
    protected $table = 'mock_attempts';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'user_id',
        'test_type',
        'score_summary',
        'detailed_report',
        'created_at',
    ];

    protected $useTimestamps = false;
}
